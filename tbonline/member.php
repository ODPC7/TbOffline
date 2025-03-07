<?PHP
	include("./tblab_connector.php");

	$space ='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	';

	if (isset($_GET["get"]) and $_GET["get"]=="out"){			//=== ตรวจสอบการออกจากระบบ
		session_unset();
		session_destroy(); 

		print "		<meta http-equiv=\"refresh\" content=\"0; url=./index.php \">";
	}

	if (isset($_GET["append"]))	{
		$mem_id =$_GET["append"];
		$off_name2_p =$_POST["off_name2"];
		$off_name1_p =$_POST["off_name1"];
		$off_idssj_p =$_POST["off_idssj"];
		$off_ssj_p =$_POST["off_ssj"];
		$changwat_p =$_POST["changwat"];
		$region_nhso_p =$_POST["region_nhso"];
		$user_pwd =$_POST["user_pwd"];

		$sql1 =mysql_query("insert into hospcode(off_id, off_name2, off_name1, off_idssj,
			off_ssj, changwat, region_nhso) values('$mem_id', '$off_name2_p', '$off_name1_p', 
			'$off_idssj_p', '$off_ssj_p', '$changwat_p', '$region_nhso_p')	");
		$sql2 =mysql_query("insert into user(off_id, user_pwd, user) values('$mem_id', '$user_pwd', '1')	");

		if ($sql1 and $sql2)	{
			print "<script>		alert('การเพิ่มสมาชิก สำเร็จ  ..'); 			</script>";		
		}else{
			print "<script>		alert('การเพิ่มสมาชิก ไม่สำเร็จ กรุณาลองใหม่ หรือติดต่อผู้ดูแลระบบ  ..'); 			</script>";		
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
	if (isset($_SESSION["export_data"]) and $_SESSION["export_data"]=="1")	{

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
			print "<a href='./index2.php'><span class='label label-default'> ค้นข้อมูลย้อนหลัง </span></a>	&nbsp;";
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

		print "		<div style='border:1px solid #000; padding:1rem;'>
		<p>	<form id='search_member' name='search_member' method='post' action='member.php' >
					<input type='text' id='off_id' name='off_id'  autofocus autocomplete='off' maxlength='5' size='30'
						placeholder='ค้นโดยรหัสหน่วยบริการสุขภาพ' required> &nbsp; 
					<input type='submit' value=' ตกลง '>
				</form>
		</p>
		</div>	<br>
		";

		if (isset($_POST["off_id"]))	{
			$off_id_post =$_POST["off_id"];
			$sql =mysql_query("select h.*, u.* from hospcode h,user u where h.off_id=u.off_id and h.off_id='$off_id_post'	");
			$rows =mysql_num_rows($sql);

			if ($rows >0)	{
				$show_rec =mysql_fetch_array($sql);
					$off_id_q =$show_rec["off_id"];
					$off_name2_q =$show_rec["off_name2"];
					$off_name1_q =$show_rec["off_name1"];
					$off_idssj_q =$show_rec["off_idssj"];
					$changwat_q =$show_rec["changwat"];
					$region_nhso_q =$show_rec["region_nhso"];
					$user_pwd_q =$show_rec["user_pwd"];

					print "		<div style='border:1px solid #000; padding:1rem;'>
						<p>	รหัสหน่วยบริการ : $off_id_q $space ชื่อหน่วยบริการ : $off_name2_q $off_name1_q $space รหัส สสจ. : $off_idssj_q		</p>
						<p>	รหัสจังหวัด : $changwat_q $space รหัสเขตสุขภาพ : $region_nhso_q $space รหัสผ่านเข้าใช้ระบบ : $user_pwd_q 		</p>
					</div>	
					";

			}else{

				print "		<div style='border:1px solid #000; padding:1rem;'>
					<p style='font-weight:bold; font-size:1.2em; color:#f00;'>	ยังไม่ได้เป็นสมาชิก ..!!		</p>
					<p>	ต้องการ <a href='./member.php?member=$off_id_post'><font color='#f00'><b>เพิ่มสมาชิก</b></font></a> <== คลิก 		</p>
				</div>	
				";
			}
		}

		if (isset($_GET["member"]))	{
			$member_id =$_GET["member"];

			$sql_ran_num =mysql_query("SELECT FLOOR(RAND() * (999999 - 100000 + 1)) + 100000 AS random_number");
			$show_ran_num =mysql_fetch_array($sql_ran_num);
				$user_pwd =$show_ran_num["random_number"];

			print "		<div style='border:1px solid #000; padding:1rem;'>
				<form id='append_member' name='append_member' method='post' action='member.php?append=$member_id' >
					<p>รหัสสถานพยาบาล : $member_id (รหัสสถานพยาบาล จะใช้เป็น User ID ในตอนเข้าระบบใช้งาน)</p>
					<p><select name='off_name2' required><option value=''>สถานะสถานพยาบาล</option>
								<option value='รพศ.'>รพศ.</option>
								<option value='รพช.'>รพช.</option>
								<option value='รพท.'>รพท.</option>
								<option value='รพ.'>รพ.</option>
								<option value='รพร.'>รพร.</option>
								<option value='สถานพยาบาล'>สถานพยาบาล</option>
								<option value='ศูนย์บริการสาธารณสุข'>ศูนย์บริการสาธารณสุข</option>
							</select>	$space
							ชื่อสถานพยาบาล : <input type='text' name='off_name1' autocomplete='off' size='30' required> 	
					</p>
					<p><select name='off_idssj' required><option value=''>รหัส สสจ.</option>
								<option value='00026'>00026 : หนองบัวลำภู</option>
								<option value='00027'>00027 : ขอนแก่น</option>
								<option value='00028'>00028 : อุดรธานี</option>
								<option value='00029'>00029 : เลย</option>
								<option value='00030'>00030 : หนองคาย</option>
								<option value='00031'>00031 : มหาสารคาม</option>
								<option value='00032'>00032 : ร้อยเอ็ด</option>
								<option value='00033'>00033 : กาฬสินธุ์</option>
								<option value='00034'>00034 : สกลนคร</option>
								<option value='00035'>00035 : นครพนม</option>
								<option value='00038'>00038 : บึงกาฬ</option>
							</select>	$space
							<select name='off_ssj' required><option value=''>ชื่อ สสจ.</option>
								<option value='กาฬสินธุ์'>กาฬสินธุ์</option>
								<option value='ขอนแก่น'>ขอนแก่น</option>
								<option value='มหาสารคาม'>มหาสารคาม</option>
								<option value='ร้อยเอ็ด'>ร้อยเอ็ด</option>
								<option value='นครพนม'>นครพนม</option>
								<option value='บึงกาฬ'>บึงกาฬ</option>
								<option value='สกลนคร'>สกลนคร</option>
								<option value='หนองคาย'>หนองคาย</option>
								<option value='หนองบัวลำภู'>หนองบัวลำภู</option>
								<option value='อุดรธานี'>อุดรธานี</option>
								<option value='เลย'>เลย</option>
							</select>	$space
							<select name='changwat' required><option value=''>รหัสจังหวัด</option>
								<option value='38'>38 : บึงกาฬ</option>
								<option value='39'>39 : หนองบัวลำภู</option>
								<option value='40'>40 : ขอนแก่น</option>
								<option value='41'>41 : อุดรธานี</option>
								<option value='42'>42 : เลย</option>
								<option value='43'>43 : หนองคาย</option>
								<option value='44'>44 : มหาสารคาม</option>
								<option value='45'>45 : ร้อยเอ็ด</option>
								<option value='46'>46 : กาฬสินธุ์</option>
								<option value='47'>47 : สกลนคร</option>
								<option value='48'>48 : นครพนม</option>
							</select>	$space
					</p>
					<p>	<select name='region_nhso' required><option value=''>รหัสเขตสุขภาพ</option>
								<option value='7'>เขตสุขภาพที่ 7 ขอนแก่น</option>
								<option value='8'>เขตสุขภาพที่ 8 อุดรธานี</option>
							</select>	$space
						รหัสผ่าน : <input type='text' name='user_pwd' autocomplete='off' size='10' 
						required value='$user_pwd' readonly> 	</p>
					<p><input type='submit' value=' ตกลง '></p>
				</form>
			</div>	<br>
			";
		}









	}else{	
		print "<script>
			alert('ท่านไม่ได้รับสิทธิ์ในการใช้ระบบนี้ กรุณาติดต่อผู้ดูแลระบบ  ..'); 
			window.location='./index.php';
		</script>";		
	}

?>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

<?PHP	mysql_close($tb_conn);	?>

</body>
</html>