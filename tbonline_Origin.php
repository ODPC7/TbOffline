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
				<a href="./tbonline.php"><img src="./images/home.png" style="align:middle;"></a>
				TB-Online for ODPC 7 Khon Kaen	 
			</p>
		</div><!-- end panel-heading -->
		<div class='panel-body' style='color:#2F70A8;'>	
			<br><br>
			<div style='border:1px solid #ccc;'>
				<br>
				<p style="font-size:2rem; text-align:center;"><a href="./lab/tb60/" target="_blank">รายงานผลการตรวจสอบเชื้อมัยโคแบคทีเรีย (Mycobacterium examination) 
					<br><font color="#339966">[ระบบเดิม] ลงทะเบียนรับตัวอย่าง ก่อนเดือน มีนาคม 2561</font></a>
				</p><br>
			</div>
			<div style='border:1px solid #ccc;'>
				<br>
				<p style="font-size:2rem; text-align:center;"><a href="./tbonline/" target="_blank">รายงานผลการตรวจสอบเชื้อมัยโคแบคทีเรีย (Mycobacterium examination)	
					<br><font color="#f00">[ระบบใหม่] ลงทะเบียนรับตัวอย่าง ตั้งแต่เดือน มีนาคม 2561</font></a>
				</p><br>
			</div>
			<div style='border:1px solid #ccc;'>
				<br>
				<p style="font-size:2rem; text-align:center;"><a href='./tbonline/report/report.php' target='_blank'>ระบบรายงานสรุปการส่งตัวอย่างตรวจสอบเชื้อมัยโคแบคทีเรีย</a></p>
				<br>
			</div>
			<div style='border:1px solid #ccc;'>
				<br>
				<p style="font-size:2rem; text-align:center;"><a href='./tbonline/tb-request-form.pdf' target='_blank'>แบบฟอร์มส่งตัวอย่างตรวจ</a></p>
				<br>
			</div>
			<br>

<?PHP
		print "<p style='font-size:1em; '><u>สอบถามข้อมูลเพิ่มเติมได้ที่</u><br><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ห้องปฏิบัติการวัณโรค กลุ่มห้องปฏิบัติการทางการแพทย์ด้านควบคุมโรค</b> <br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สำนักงานป้องกันควบคุมโรคที่ 7 จังหวัดขอนแก่น <br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หรือ เจ้าหน้าที่ผู้รับผิดชอบทางห้องปฏิบัติการวัณโรค	<br><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เบอร์โทรศัพท์: 043-222- 818-9 ต่อ 302  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;มือถือ: 098-1746853  (ในวันและเวลาราชการ) <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-Mail: labtbdpc7@hotmail.com
		</p> <br>";
		print "			<div class='table-responsive'>
						<table class='table table-hover'>
							<thead>
								<tr class='success'>
									<th style='color:#2F70A8;'>ลำดับ</th>
									<th style='color:#2F70A8;'>ชื่อ - สกุล</th>
									<th style='color:#2F70A8;'>ตำแหน่ง</th>
									<th style='color:#2F70A8;'>อีเมล</th>
									<th style='color:#2F70A8;'>โทรศัพท์</th>
								</tr>
							</thead>
							<tbody>
		";

include("./tbonline/tblab_connector.php");

		$sql_person =mysql_query("select * from person where note = 1 order by num");

		while ($list_person =mysql_fetch_array($sql_person)){
			$num =$list_person["num"];
			$person_name =$list_person["fname"];
			$_position =$list_person["position"];
			$_tel =$list_person["tel"];
			$_email =$list_person["email"];

			print "<tr>
				<td style='text-align:left;'>$num</td>
				<td style='text-align:left;'>$person_name</td>
				<td style='text-align:left;'>$_position</td>
				<td style='text-align:left;'>$_email</td>
				<td style='text-align:left;'>$_tel</td>
			</tr>";
		}

		print "</tbody></table></div>";


mysql_close($tb_conn);

?>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

</body>
</html>