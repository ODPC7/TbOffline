<?PHP
if ((isset($_GET["get"]) and $_GET["get"]=="out") or (isset($_SESSION["Back_Office"]) and $_SESSION["Back_Office"] !="admin") ){			//=== ตรวจสอบการออกจากระบบ
	session_unset();
	session_destroy(); 

	print "<script>window.location='./entry.php';</script>";	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>สำนักงานป้องกันควบคุมโรคที่ 7 จังหวัดขอนแก่น</title>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="./css/bootstrap.css">
	<link rel="stylesheet" href="./css/bootstrap-theme.css">
	<link rel="stylesheet" href="./css/css_plugin.css">
</head>
<body>
<script src="https://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap_plugin.js"></script>

<div class="container-fluid"><!-- container-01 -->
	<?PHP		include("./menu.php");		?>
	<?PHP		include("./head.php");		?>

</div>	<!-- end container-01 -->
<?PHP
include("./config/dataconnector.php");
print "<div class='container'> <br>	";	//<!-- container-02 -->

$_fname =$_SESSION["fname"];

print "	<div class='panel panel-primary'>
	<div class='panel-heading panel-title' style='font-size:1.2em;'>
		ขณะนี้คุณ $_fname กำลังอยุ่ในระบบ ..
";
print "		<a href='./home.php'><button type='button' class='btn btn-info'>หน้าหลัก</button></a>	";
print "		<a href='./right_report.php'><button type='button' class='btn btn-success'>รายงาน</button></a>	";
print "		<a href='./home.php?get=out'><button type='button' class='btn btn-danger'>ออกจากระบบ</button></a>
	</div>
</div>
";
print "	<div class='panel panel-info'>
		<div class='panel-heading'>
			<p class='panel-title' style='font-size:1.5em;'>การจัดการสิทธิ์</p>
		</div>
		<div class='panel-body'>
";

if (isset($_POST["personnel"]) and isset($_POST["ws"]) and $_POST["ws"] !="" 
	and isset($_POST["pr"]) and $_POST["pr"] !="")	{
		$psn =$_POST["personnel"];
		$ws =$_POST["ws"];
		$pr =$_POST["pr"];

		if ($psn=="all" and $ws !="all")	{
			$sql_person =mysql_query("select id_card from person where status='active'	");
			$rows =mysql_num_rows($sql_person);
			$i =0;	$j =0;
			while ($list_person =mysql_fetch_array($sql_person)){
				$id =$list_person["id_card"];
				if (mysql_query("replace into permit(id_card, work_system, permit) values('$id', '$ws', '$pr')	"))	{
					$i +=1;
				}else{
					$j +=1;
				}
			}

			if ($i==$rows)	{
				print "<p>การกำหนดสิทธิ์ทั้งหมด เสร็จเรียบร้อย กรุณารอสักครู่  ..</p>";
			}else{
				print "<p>การกำหนดสิทธิ์ สำเร็จ $i ราย, ไม่สำเร็จ $j ราย กรุณารอสักครู่  ..</p>";
			}

			print "		<meta http-equiv=\"refresh\" content=\"3; url=./permit.php \">";
		
		}else{
		
			if ($ws=="all" and $psn !="all")	{
					$sql_ws =mysql_query("select system_name from work_system order by system_name asc");
					$rows =mysql_num_rows($sql_ws);
					$i =0;	$j =0;
					while ($list_ws =mysql_fetch_array($sql_ws)){
						$system_name =$list_ws["system_name"];
						if (mysql_query("replace into permit(id_card, work_system, permit) values('$psn', '$system_name', '$pr')	"))	{
							$i +=1;
						}else{
							$j +=1;
						}
					}

					if ($i==$rows)	{
						print "<p>การกำหนดสิทธิ์ทุกระบบงาน เสร็จเรียบร้อย กรุณารอสักครู่  ..</p>";
					}else{
						print "<p>การกำหนดสิทธิ์ สำเร็จ $i ระบบ, ไม่สำเร็จ $j ระบบ กรุณารอสักครู่  ..</p>";
					}

					print "		<meta http-equiv=\"refresh\" content=\"3; url=./permit.php \">";

			}else{

				if ($psn !="all" and $ws !="all")	{
					if (mysql_query("replace into permit(id_card, work_system, permit) values('$psn', '$ws', '$pr')	")){
						print "<p>การกำหนดสิทธิ์ เสร็จเรียบร้อย กรุณารอสักครู่  ..</p>";
					}else{
						print "<p>การกำหนดสิทธิ์ ไม่สำเร็จ  กรุณารอสักครู่  ..</p>";
					}

					print "		<meta http-equiv=\"refresh\" content=\"3; url=./permit.php \">";
				}else{
					print "<p>ไม่สามารถเลือกทุกคน และทุกระบบพร้อมกันได้  กรุณารอสักครู่  ..</p>";
					print "		<meta http-equiv=\"refresh\" content=\"3; url=./permit.php \">";
				}
			}
		}

}else{
	print "	<form class='form-horizontal' role='form' name='permit_form' method='post' action='./permit.php'>
			<div class='form-group'>
				<label for='personel' class='col-sm-2 control-label'>เลือกบุคลากร ..</label>
				<div class='col-sm-10'>
					<select class='form-control' name='personnel' required autofocus>
						<option value='all'>เลือกทั้งหมด</option>
	";
	$sql_personel =mysql_query("select id_card, fname from person order by fname asc");
	while ($list_personel =mysql_fetch_array($sql_personel))	{
		$id =$list_personel["id_card"];
		$name =$list_personel["fname"];
		print "<option value='$id'>$name</option>";
	}
	print "				</select>	</div>
				<label for='work_system' class='col-sm-2 control-label'>เลือกระบบงาน ..</label>
				<div class='col-sm-10'>
					<select class='form-control' name='ws' required>
						<option value='all'>ทุกระบบ</option>
	";
	$sql_ws =mysql_query("select num, system_name from work_system order by system_name asc");
	while ($list_ws =mysql_fetch_array($sql_ws))	{
		$num =$list_ws["num"];
		$system_name =$list_ws["system_name"];
		print "<option value='$system_name'>$system_name</option>";
	}
	print "				</select>	</div>
				<label for='pr' class='col-sm-2 control-label'>เลือกสิทธิ์การใช้งาน ..</label>
				<div class='col-sm-10'>
					<select class='form-control' name='pr' required>
						<option value=''>โปรดระบุ ..</option>
	";
	$sql_pr =mysql_query("select num, permit_right from permit_right order by num asc");
	while ($list_pr =mysql_fetch_array($sql_pr))	{
		$num =$list_pr["num"];
		$permit_right =$list_pr["permit_right"];
		print "<option value='$permit_right'>$permit_right</option>";
	}
	print "				</select>	</div>
				<div class='col-sm-offset-2 col-sm-10'>
					<button type='submit' class='btn btn-primary' onclick=\"return confirm('คุณตกลงที่จะกำหนดสิทธิ์นี้ ใช่หรือไม่?')\"> ตกลง </button>
				</div>
			</div>
		</form>
	";
		
}		
		
print "		</div>	</div>	";
//++++ end	panel-body		panel-info

print "	</div>	";		// <!-- end container-02 -->
mysql_close($conn);

?>

</body>
</html>