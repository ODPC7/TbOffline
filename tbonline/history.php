<?PHP
	include("./tblab_connector.php");

	if (isset($_GET["get"]) and $_GET["get"]=="out"){			//=== ตรวจสอบการออกจากระบบ
		session_unset();
		session_destroy(); 

		print "		<meta http-equiv=\"refresh\" content=\"0; url=./index.php \">";
	}



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>สำนักงานป้องกันควบคุมโรคที่ 7 จังหวัดขอนแก่น</title>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/css_plugin.css">



</head>
<body>
<script src="../js/jquery-3.2.1.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/bootstrap_plugin.js"></script>

<div class="container-fluid"><!-- container-01 -->
	<div class='row' style='margin:10px 0 10px 0;'>
		<div class='col-xs-1, col-sm-1, col-md-1, col-lg-1'>
			<img src='../images/mophlogo.png' class='img-responsive'>
		</div>
		<div class='col-xs-6, col-sm-6, col-md-6, col-lg-6'>
			<p style='font-size:2em; color:#056839; text-shadow:1px 1px 1px #fff, -1px -1px 1px #222; border-bottom:0.12em solid #888;'>
				สำนักงานป้องกันควบคุมโรคที่ 7 จังหวัดขอนแก่น
			</p>
			<p style='font-size:1.5em; color:#056839; text-shadow:1px 1px 1px #fff, -1px -1px 1px #222;'>
				The Office of Disease Prevention and Control 7 Khon Kaen
			</p>
		</div>
	</div>
</div>	<!-- end container-01 -->

<div class="container-fluid">	<!-- container-02 -->

	<div class="panel panel-primary">
		<div class="panel-heading" class='img-responsive'>
			<p class='panel-title' style='font-size:1.5em;'>	
				<a href="./"><img src="./images/home.png" style="align:middle;"></a>
				TB-Online for ODPC 7 Khon Kaen <a href="./index.php?get=out">&nbsp;&nbsp;<img src="./images/signout.png"></a> 
			</p>
			<br>

<?PHP
	//+++	ตรวจสอบการเข้าระบบ ถ้ายังไม่เข้าให้แสดงฟอร์มการ sign in
	if (! isset($_SESSION["user_name"]))	{
		print "<script>
			alert('กรุณาเข้าระบบ ก่อนใช้งาน  ..'); 
			window.location='./index.php';
		</script>";

	}else{	//+++	ถ้าเข้าแล้วให้เก็บตัวแปรข้อมูลของผู้เข้าระบบไว้ใช้งานต่อไป

		$user_name =$_SESSION["user_name"];		//+++	ก็คือ off_id1(ชื่อ รพ.ที่ส่งตรวจ)
			$count_char =strlen($user_name);
		$user =$_SESSION["user"];
		$sample =$_SESSION["sample"];
		$culture =$_SESSION["culture"];
		$identification =$_SESSION["identification"];
		$sensitivity =$_SESSION["sensitivity"];
		$molecular =$_SESSION["molecular"];
		$approve =$_SESSION["approve"];
		$export_data =$_SESSION["export_data"];
		$off_name1 =$_SESSION["off_name1"];
		$off_name2 =$_SESSION["off_name2"];
		$region_nhso =$_SESSION["region_nhso"];

		if ($count_char >5)	{
			print "<p><span class='label label-info'>เจ้าหน้าที่ : $region_nhso $off_name2 $off_name1 อยู่ในระบบ ..	 </span></p>	";
		}else{
			print "<p><span class='label label-info'>เจ้าหน้าที่ : $off_name2 $off_name1 อยู่ในระบบ ..	 </span></p>	";
		}

		print "		</div><!-- end panel-heading -->
			<div class='panel-body' style='color:#2F70A8;'>	<p>
		";

		//+++	ตรวจสอบสิทธิ์การใช้งานเมนูต่างๆ
		if ($user=="1")		{
			print "<a href='./index.php'><span class='label label-default'> สืบค้นข้อมูล </span></a>	&nbsp;";
			print "<a href='./history.php'><span class='label label-success'> ประวัติผู้เข้าใช้ระบบ </span></a>	&nbsp;";
			print "<a href='./report/report.php'><span class='label label-primary'> รายงานสรุป </span></a>	&nbsp;";
		}

		if ($sample=="1")		{
			print "<a href='./append_data.php'><span class='label label-primary'> สำหรับ จนท.ลงทะเบียน </span></a>	&nbsp;";
		}

		if ($export_data=="1")		{
			print "<a href='./export_data.php'><span class='label label-warning'> ส่งออกข้อมูล </span></a>	&nbsp;";
			print "<a href='./member.php'><span class='label label-default'> จัดการสมาชิก </span></a>	&nbsp;";
		}

		//+++	สิ้นสุด	ตรวจสอบสิทธิ์การใช้งานเมนูต่างๆ


		print "			<div class='table-responsive'>
			<table class='table table-hover'>
				<thead>
					<tr class='success'>
						<th style='color:#2F70A8;'>ผู้เข้าใช้ระบบ</th>
						<th style='color:#2F70A8;'>วันที่ - เวลา  ที่เข้าใช้ล่าสุด</th>
						<th style='color:#2F70A8;'>จำนวนครั้ง</th>
					</tr>
				</thead>
				<tbody>
		";

			$sql_odpc7 =mysql_query("select u.off_id, p.fname, u.use_date, u.use_count from person p, user u
				where p.id_card=u.off_id and u.use_count !=0 order by u.use_date desc, u.use_count desc	");
			$sql_hospital =mysql_query("select u.off_id, h.off_name2, h.off_name1, u.use_date, u.use_count from hospcode h, user u
				where h.off_id=u.off_id and u.use_count !=0 order by u.use_date desc, u.use_count desc	");

		while ($list_hospital =mysql_fetch_array($sql_hospital)){
			$off_id =$list_hospital["off_id"];
			$offname2 =$list_hospital["off_name2"];
			$offname1 =$list_hospital["off_name1"];
			$usedate =$list_hospital["use_date"];
			$usecount =$list_hospital["use_count"];

			print "<tr>
				<td>$offname2 $offname1</td>
				<td>$usedate</td>
				<td>$usecount</td>
			</tr>";
		}

		while ($list_history =mysql_fetch_array($sql_odpc7)){
			$off_id =$list_history["off_id"];
			$_usename =$list_history["fname"];
			$usedate =$list_history["use_date"];
			$usecount =$list_history["use_count"];

			print "<tr>
				<td>$_usename</td>
				<td>$usedate</td>
				<td>$usecount</td>
			</tr>";
		}

		print "</tbody></table></div>";
	}

?>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

<?PHP	mysql_close($tb_conn);	?>

</body>
</html>