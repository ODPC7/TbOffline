<?PHP
	include("./tblab_connector.php");

	if (isset($_GET["get"]) and $_GET["get"]=="out"){			//=== ตรวจสอบการออกจากระบบ
		session_unset();
		session_destroy(); 

		print "		<meta http-equiv=\"refresh\" content=\"0; url=./index.php \">";
	}


	if (isset($_GET["update"]))	{
		$ptname =$_GET["ptname"];
		$culno =$_GET["culno"];
		$new_culno =$_POST["cul_no"];
		$senddate =$_GET["senddate"];

		$sql_culture ="update culture set cul_no='$new_culno' where fname='$ptname' and cul_no='$culno' and date_in='$senddate'	";
		$sql_iden ="update identification set cul_no='$new_culno' where fname='$ptname' and cul_no='$culno'	";
		$sql_dst ="update dst set cul_no='$new_culno' where fname='$ptname' and cul_no='$culno'	";
		$sql_appr ="update approve set cul_no='$new_culno' where fname='$ptname' and cul_no='$culno'	";

		if (mysql_query($sql_culture) and
			mysql_query($sql_dst) and
			mysql_query($sql_iden) and
			mysql_query($sql_appr) )	{
			print "<script>
				alert('ระบบทำการแก้ไขข้อมูลเสร็จเรียบร้อย ..'); 
				window.location='./index.php?search_name=$ptname';
			</script>";
		}else{
			print "<script>
				alert('ระบบไม่สามารถแก้ไขข้อมูลให้ท่านได้ !! กรุณาลองใหม่ หรือติดต่อผู้ดูแลระบบ'); 
				window.location='./index.php?search_name=$ptname';
			</script>";
		}

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
		$approve =$_SESSION["approve"];
		$off_name1 =$_SESSION["off_name1"];
		$off_name2 =$_SESSION["off_name2"];
		$region_nhso =$_SESSION["region_nhso"];

		if ($count_char >5)	{
			print "<p><span class='label label-info'>เจ้าหน้าที่ : $region_nhso $off_name2 $off_name1 อยู่ในระบบ ..	 </span></p>	";
		}else{
			print "<p><span class='label label-info'>เจ้าหน้าที่ : $off_name2 $off_name1 อยู่ในระบบ ..	 </span></p>	";
		}

		print "		</div><!-- end panel-heading -->
			<div class='panel-body' style='color:#2F70A8;'>	
			<p style='text-align:center; font-size:1.5em; font-weight:bold; color:#f00;'>
				<br>	การแก้ไข Culture No. <br> จะมีผลให้มีการเปลี่ยนไปทุกระเบียนของผลการตรวจ	
			</p>
		";

		$ptname =$_GET["ptname"];
		$culno =$_GET["culno"];
		$senddate =$_GET["senddate"];

		$space ='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	';

		print "	<br>
			<p style='font-weight:bold;'>ชื่อ - สกุล ผู้ป่วย : $ptname $space รับตัวอย่างวันที่ $senddate $space Culture NO.(เดิม) : $culno</p>
		<br>";
		print "<form class='form-horizontal' role='form' name='edit_culno' method='post' 
			action='./edit_culno.php?update&ptname=$ptname&culno=$culno&senddate=$senddate'>	";
		print "	<div class='form-group'>
				<label for='new_culno' class='col-sm-3 control-label'>Culture NO. (ใหม่)</label>
				<div class='col-sm-9'>
					<input type='text' class='form-control' name='cul_no' autocomplete='off' required autofocus>	
				</div>
			</div>
		";
		print "	<div class='form-group'>
				<div class='col-sm-offset-3 col-sm-9'>
					<button type='submit' class='btn btn-primary'> บันทึก </button>
				</div>
			</div>
		";

		print "</form>";
	}

?>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

<?PHP	mysql_close($tb_conn);	?>

</body>
</html>