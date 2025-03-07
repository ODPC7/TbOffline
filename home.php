<?PHP
if ((isset($_GET["get"]) and $_GET["get"] == "out") or !isset($_SESSION["Back_Office"])) {			//=== ตรวจสอบการออกจากระบบ
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

	<div class="container-fluid">
		<!-- container-01 -->
		<?PHP include("./menu.php");		?>
		<?PHP include("./head.php");		?>

	</div> <!-- end container-01 -->
	<?PHP
	include("./config/dataconnector.php");
	print "<div class='container'> <br>	";	//<!-- container-02 -->

	if (isset($_SESSION["Back_Office"]) and ($_SESSION["Back_Office"] != "guest")) {
		$_fname = $_SESSION["fname"];
		$bo = $_SESSION["Back_Office"];

		print "	<div class='panel panel-primary'>
		<div class='panel-heading panel-title' style='font-size:1.2em;'>
			ขณะนี้คุณ $_fname กำลังอยุ่ในระบบ ..
	";

		if ($bo == "admin") {
			print "		<a href='./permit.php'><button type='button' class='btn btn-info'>การจัดการสิทธิ</button></a>	";
		}

		print "		<a href='./home.php?get=out'><button type='button' class='btn btn-danger'>ออกจากระบบ</button></a>
		</div>
	</div>
	";
		//	+++++++++	ระบบงานแถวที่ 1
		print "		
		<div class='row'>
			<div class='col-sm-6 col-md-2'>
				<a href='./profile.php' class='thumbnail'>
					<img src='./images/profile_icon.png' class='img-rounded'> <br>
					<div class='caption'>
						<h4><font color='#337ab7'>ทะเบียนบุคลากร</font></h4>
					</div>
				</a>
			</div>
			<div class='col-sm-6 col-md-2'>
				<a href='./send_notify_all/' class='thumbnail'>
					<img src='./images/send_msg_via_notify.png' class='img-rounded'> 
					<div class='caption'>
						<h4><font color='#337ab7'>ส่งข้อความให้ Line ส่วนตัว</font></h4>
					</div>
				</a>
			</div>
	";
		/*			<div class='col-sm-6 col-md-2'>
				<a href='./journal/' class='thumbnail'>
					<img src='./images/jn.jpg' class='img-rounded'> <br>
					<div class='caption'>
						<h4><font color='#337ab7'>การจัดการวารสาร</font></h4>
					</div>
				</a>
			</div> 
*/
		print "
			<div class='col-sm-6 col-md-2'>
				<a href='./maintenance/index.php?act=showsv' class='thumbnail'>
					<img src='./images/service.png' class='img-rounded'> 
					<div class='caption'>
						<h4><font color='#337ab7'>ระบบแจ้งซ่อม<br>งานพัสดุ</font></h4>
					</div>
				</a>
			</div>
			<div class='col-sm-6 col-md-2'>
				<a href='./itservice/' target='_blank' class='thumbnail'>
					<img src='./images/itservice_icon.png' class='img-rounded'> 
					<div class='caption'>
						<h4><font color='#337ab7'>ระบบแจ้งซ่อม<br>งานสารสนเทศ</font></h4>
					</div>
				</a>
			</div>
			<div class='col-sm-6 col-md-2'>
				<a href='./telephone/telephonebook.php' class='thumbnail'>
					<img src='./images/Telephone_150x100.png' class='img-rounded'> 
					<div class='caption'>
						<h4><font color='#337ab7'>สมุดโทรศัพท์ สคร.7 ขอนแก่น</font></h4>
					</div>
				</a>
			</div>
			<div class='col-sm-6 col-md-2'>
				<a href='./eoc_report.php' class='thumbnail'>
					<img src='./images/WeeklySAT-JIT.png' class='img-rounded'> 
					<div class='caption'>
						<h4><font color='#337ab7'>ผลการดำเนินงาน SAT & JIT สคร.7</font></h4>
					</div>
				</a>
			</div>

		</div>	<!-- end row -->
	";
			/*
			<div class='col-sm-6 col-md-2'>
				<a href='./disease_group.php' class='thumbnail'>
					<img src='./images/disease_group.jpg' class='img-rounded'> 
					<div class='caption'>
						<h4><font color='#337ab7'>ข้อมูลกลุ่มโรค</font></h4>
					</div>
				</a>
			</div>
			*/
		//	+++++++++	จบ ระบบงานแถวที่ 1

		//	+++++++++	ระบบงานแถวที่ 2
		print "		
		<div class='row'>
			<div class='col-sm-6 col-md-2'>
				<a href='./salary.php' class='thumbnail'>
					<img src='./images/slip.jpg' class='img-rounded'> <br>
					<div class='caption'>
						<h4><font color='#337ab7'>สลิป ออนไลน์</font></h4>
					</div>
				</a>
			</div>
			<div class='col-sm-6 col-md-2'>
				<a href='./training.php' class='thumbnail'>
					<img src='./images/training_icon.jpg' class='img-rounded'> 
					<div class='caption'>
						<h4><font color='#337ab7'>ประวัติ<br>การฝึกอบรมฯ</font></h4>
					</div>
				</a>
			</div>
			<div class='col-sm-6 col-md-2'>
				<a href='./stock/' class='thumbnail'>
					<img src='./images/stock.jpg' class='img-rounded'> 
					<div class='caption'>
						<h4><font color='#337ab7'>ระบบคลังวัสดุ</font></h4>
					</div>
				</a>
			</div>
";
		/*
		<div class='col-sm-6 col-md-2'>
			<a href='./bmc59' class='thumbnail'>
				<img src='./images/bmc7_icon.jpg' class='img-rounded'> 
				<div class='caption'>
					<h4><font color='#337ab7'>BMC สคร.7</font></h4>
				</div>
			</a>
		</div>
		<div class='col-sm-6 col-md-2'>
			<a href='./bmc860' class='thumbnail'>
				<img src='./images/bmc8_icon.jpg' class='img-rounded'> 
				<div class='caption'>
					<h4><font color='#337ab7'>BMC สคร.8</font></h4>
				</div>
			</a>
		</div>
	*/
		print "
			<div class='col-sm-6 col-md-2'>
				<a href='./lab_stock/' class='thumbnail'>
					<img src='./images/stock_science.jpg' class='img-rounded'> 
					<div class='caption'>
						<h4><font color='#337ab7'>คลังวัสดุวิทย์</font></h4>
					</div>
				</a>
			</div>
			<div class='col-sm-6 col-md-2'>
				<a href='./pakeynetwork.php' class='thumbnail'>
					<img src='./images/addressbook.png' class='img-rounded'> 
					<div class='caption'>
						<h4><font color='#337ab7'>รายชื่อเครือข่าย<br>เขต 7</font></h4>
					</div>
				</a>
			</div>
			<div class='row'>
			<div class='col-sm-6 col-md-2'>
				<a href='./essay.php' class='thumbnail'>
					<img src='./images/essay_icon.png' class='img-rounded'> <br>
					<div class='caption'>
						<h4><font color='#337ab7'>เรียงความ สคร.7</font></h4>
					</div>
				</a>
			</div>
		</div>	<!-- end row -->
	";
		//	+++++++++	จบ ระบบงานแถวที่ 2

		//	+++++++++	เริ่มระบบงานแถวที่ 3
		// จบ ระบบงานแถวที่ 3

	} else {
		print "<script>window.location='./entry.php';</script>";
	}

	print "	</div>	";		// <!-- end container-02 -->


	mysql_close($conn);

	?>

</body>

</html>
