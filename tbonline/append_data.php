<?PHP
//+++ ตรวจสอบการเข้าระบบ
if ( ! isset($_SESSION["sample"]) or $_SESSION["sample"] !="1")	{
	print "<script>
		alert('ท่านไม่ได้รับสิทธิ์ในการใช้งานหน้านี้ ..'); 
		window.location='./';
	</script>";

}else{
	include("./tblab_connector.php");
}

//+++ ตรวจสอบการเพิ่มข้อมูล
if (isset($_GET["append"]))	{
	$sql ="	insert into ptt_profile(id_card, fname, sex, age, right_care) values(		";

	$id =$_POST["id_card"];
		if ($id=="")	{	$sql =$sql . "NULL";	}else{	$sql =$sql . " '$id'	";	}
	$post_name =$_POST["fname"];
		$post_name = str_replace("  ", " ", trim($post_name));
		$sql =$sql . " ,'$post_name'	";	
	$sex =$_POST["sex"];
		if ($sex=="")	{	$sql =$sql . "	,NULL	";	}else{	$sql =$sql . " ,'$sex'	";	}
	$age =$_POST["age"];
		if ($age=="")	{	$sql =$sql . "	,NULL	";	}else{	$sql =$sql . " ,'$age'	";	}
	$right_care =$_POST["right_care"];
		if ($right_care=="")	{	$sql =$sql . "	,NULL)	";	}else{	$sql =$sql . " ,'$right_care')	";	}

	mysql_query($sql);
}

//+++ ตรวจสอบการลบข้อมูล
if (isset($_GET["delete"]))	{
	$del_name =$_GET["delete"];
	$sql_profile ="delete from ptt_profile where fname ='$del_name'	";
	$sql_cul ="delete from culture where fname ='$del_name'	";
	$sql_iden ="delete from identification where fname ='$del_name'	";
	$sql_dst ="delete from dst where fname ='$del_name'	";
	$sql_appr ="delete from approve where fname ='$del_name'	";

	if (mysql_query($sql_profile) and
		mysql_query($sql_cul) and
		mysql_query($sql_iden) and
		mysql_query($sql_dst) and
		mysql_query($sql_appr))	{
		print "<script>
			alert('ระบบทำการลบข้อมูลเสร็จเรียบร้อย ..'); 
			window.location='./append_data.php';
		</script>";
	}else{
		print "<script>
			alert('ระบบไม่สามารถลบข้อมูลให้ท่านได้ !! กรุณาลองใหม่ หรือติดต่อผู้ดูแลระบบ'); 
			window.location='./append_data.php';
		</script>";
	}
}

//+++ ตรวจสอบการแก้ไขข้อมูล
if (isset($_GET["update"]))	{
	$update_name =$_GET["update"];
	$_id =$_POST["id_card"];
	$ptname =$_POST["fname"];
	$_sex =$_POST["sex"];
	$_age =$_POST["age"];
	$_right_care =$_POST["right_care"];

	$sql_profile ="update ptt_profile set id_card='$_id', fname='$ptname', sex='$_sex', age='$_age', right_care='$_right_care'
	where fname ='$update_name'	";
	$sql_cul ="update culture set fname='$ptname'	where fname ='$update_name'	";
	$sql_iden ="update identification set fname='$ptname'	where fname ='$update_name'	";
	$sql_dst ="update dst set fname='$ptname'	where fname ='$update_name'	";
	$sql_appr ="update approve set fname='$ptname'	where fname ='$update_name'	";

	if (mysql_query($sql_profile) and
		mysql_query($sql_cul) and 
		mysql_query($sql_iden) and
		mysql_query($sql_dst) and 
		mysql_query($sql_appr))	{
		print "<script>
			alert('ระบบทำการแก้ไขข้อมูลเสร็จเรียบร้อย ..'); 
			window.location='./append_data.php';
		</script>";
	}else{
		print "<script>
			alert('ระบบไม่สามารถแก้ไขข้อมูลให้ท่านได้ !! กรุณาลองใหม่ หรือติดต่อผู้ดูแลระบบ'); 
			window.location='./append_data.php';
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

	<script>
		//+++ ฟังก์ชัน clear form element
		function get_clear() {
			document.getElementById("search_name").innerHTML="";
			document.getElementById("search_name").style.display = "none";
			document.getElementById("sele_profile").style.display = "none";

			document.getElementById("cul").style.display = "none";
			document.getElementById("iden").style.display = "none";
			document.getElementById("mol").style.display = "none";
			document.getElementById("appr").style.display = "none";

			document.getElementById("profile1_p").innerHTML="";
			document.getElementById("profile1_div").style.display = "none";
			document.getElementById("keyword").value = "";
			document.getElementById("keyword").focus();
			document.getElementById("append_div").style.display = "none";
			return;
		}	

		//+++ ฟังก์ชัน ค้นหาชื่อในฐานข้อมูล
		function find_name(str) {
			if (str == "") {
				return;
			} else { 
				document.getElementById("search_name").innerHTML="";
				document.getElementById("search_name").style.display="block";
				document.getElementById("sele_profile").style.display="block";
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("search_name").innerHTML = xmlhttp.responseText;
					}
				};
				xmlhttp.open("GET","get_data.php?keyword="+str,true);
				xmlhttp.send();
			}
		}

		//+++ ฟังก์ชัน เอารายละเอียดข้อมูลมาแสดง
/*		function get_data(str) {
			if (str == "") {
				document.getElementById("profile1_p").innerHTML = "";
				return;
			} else { 

				document.getElementById("profile1_div").style.display="block";
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("profile1_p").innerHTML = xmlhttp.responseText;
					}
				};
				xmlhttp.open("GET","get_data.php?fn="+str,true);
				xmlhttp.send();
			}
		}
*/
	</script>


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
				<a href="./"><img src="./images/home.png"></a>
				TB-Online for ODPC 7 Khon Kaen <a href="./index.php?get=out">&nbsp;&nbsp;<img src="./images/signout.png"></a> 
			</p>
			<br>

<?PHP
//+++	ตรวจสอบการเข้าระบบ
if (isset($_SESSION["user_name"]))	{
	$user_name =$_SESSION["user_name"];
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

	//+++	ตรวจสอบ user_id ว่ามีกี่ตัวอักษร(รพ.ทั่วไปมี 5 หลัก, สำหรับ จนท.มี 13 หลัก)
	if ($count_char >5)	{
		print "<p><span class='label label-info'>เจ้าหน้าที่ : $region_nhso $off_name2 $off_name1 อยู่ในระบบ ..	 </span></p>	";
	}else{
		print "<p><span class='label label-info'>เจ้าหน้าที่ : $off_name2 $off_name1 อยู่ในระบบ ..	 </span></p>	";
	}

	print "		</div><!-- end panel-heading -->
		<div class='panel-body' style='color:#2F70A8;'>	<p>
	";

	//+++	ตรวจสอบสิทธิ์การใช้เมนู
	if ($user=="1")		{	//+++	สำหรับ จนท.ทุกคน
		print "<a href='./index.php'><span class='label label-default'> สืบค้นข้อมูล </span></a>	&nbsp;";
		print "<a href='./history.php'><span class='label label-success'> ประวัติผู้เข้าใช้ระบบ </span></a>	&nbsp;";
		print "<a href='./report/report.php'><span class='label label-primary'> รายงานสรุป </span></a>	&nbsp;";
	}

	if ($sample=="1")		{	//+++	สำหรับ จนท.ที่ลงทะเบียนประวัติพื้นฐาน
		print "<a href='./append_data.php'><span class='label label-primary'> สำหรับ จนท.ลงทะเบียน </span></a>	&nbsp;";
	}

	if ($export_data=="1")		{
		print "<a href='./export_data.php'><span class='label label-warning'> ส่งออกข้อมูล </span></a>	&nbsp;";
		print "<a href='./member.php'><span class='label label-default'> จัดการสมาชิก </span></a>	&nbsp;";
	}

	//+++	เครื่องมือค้นหา ผป.เก่า และสามารถเชื่อมต่อการเพิ่มข้อมูลใหม่ได้
	print "		<div style='border:1px solid #000; padding:1rem;'>
	<p>	<form id='new_ptt' name='new_ptt' method='post' action='append_data.php'  onsubmit=\"return confirm('ท่านต้องการเพิ่มข้อมูล หรือไม่?')\">
			<input type='button' value=' ล้างข้อความ ' onclick=\"get_clear()\">
			<input type='text' id='keyword' name='keyword'  autofocus autocomplete='off' 
				placeholder='ค้นโดยชื่อ หรือบัตรประชาชน' onkeyup=\"find_name(this.value)\">
	";

	if ($sample=="1")		{
		print "	<input type='submit' value=' เพิ่มรายชื่อ '> ";
	}

	print "	</form>
	</p>
	<p>
		<form id='name_search' name='name_search' method='post' action='append_data.php?select'>
			<select id='search_name' name='search_name' size='10' style='width:100%; display:none;' >

			</select>
			<input id='sele_profile' type='submit' value=' นำเข้าข้อมูล ' style='display:none;'>
		</form>
	</p>
	</div>	<br>
	";

	$space ='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	';

//+++	ตรวจสอบว่ามี่การส่งค่ามาหลังจากการ แก้ไขข้อมูล หรือไม่
	if (! isset($_GET["pt_name"]) and ! isset($_GET["cno"]))	{

		if (isset($_GET["edit"]))	{
			$keyword =$_GET["edit"];
			$sql =mysql_query("select * from ptt_profile where fname='$keyword'	");
			$show_rec =mysql_fetch_array($sql);
				$_id =$show_rec["id_card"];
				$_sex =$show_rec["sex"];
				$_age =$show_rec["age"];
				$_right_care =$show_rec["right_care"];

			print "<div id='edit_div' style='border:1px solid #000; margin:10px 0 10px 0; padding:1rem;'>
			<form id='edit_form' name='edit_form' method='post' action='append_data.php?update=$keyword'
				onsubmit=\"return confirm('ท่านต้องการบันทึกการแก้ไขข้อมูลนี้ หรือไม่?')\">

			<p>เลขบัตรประชาชน : <input type='text' name='id_card' size='12' maxlength='13' value='$_id' autocomplete='off' autofocus> $space
					ชื่อ - สกุล : <input type='text' name='fname' value='$keyword' autocomplete='off'> $space
			";

			if ($_sex=="ชาย")	{
				print "	เพศ : <input type='radio' name='sex' value='ชาย' checked> ชาย $space 
									<input type='radio' name='sex' value='หญิง'> หญิง $space	";
			}

			if ($_sex=="หญิง")	{
				print "	เพศ : <input type='radio' name='sex' value='ชาย'> ชาย $space 
									<input type='radio' name='sex' value='หญิง' checked> หญิง $space	";
			}

			print "	อายุ : <input type='text' name='age' value='$_age' autocomplete='off'> <br><br>	";

			if ($_right_care=="UC")	{
				print "	สิทธิการรักษา : <input type='radio' name='right_care' value='UC' checked> UC $space 
												<input type='radio' name='right_care' value='สิทธิข้าราชการ'> สิทธิข้าราชการ $space 
												<input type='radio' name='right_care' value='สิทธิประกันสังคม'> สิทธิประกันสังคม $space 
												<input type='radio' name='right_care' value='สิทธิต่างด้าว'> สิทธิต่างด้าว $space 
												<input type='radio' name='right_care' value='สิทธิอื่นๆ'> สิทธิอื่นๆ <br><br>
				";
			}

			if ($_right_care=="สิทธิข้าราชการ")	{
				print "	สิทธิการรักษา : <input type='radio' name='right_care' value='UC'> UC $space 
												<input type='radio' name='right_care' value='สิทธิข้าราชการ' checked> สิทธิข้าราชการ $space 
												<input type='radio' name='right_care' value='สิทธิประกันสังคม'> สิทธิประกันสังคม $space 
												<input type='radio' name='right_care' value='สิทธิต่างด้าว'> สิทธิต่างด้าว $space 
												<input type='radio' name='right_care' value='สิทธิอื่นๆ'> สิทธิอื่นๆ <br><br>
				";
			}

			if ($_right_care=="สิทธิประกันสังคม")	{
				print "	สิทธิการรักษา : <input type='radio' name='right_care' value='UC'> UC $space 
												<input type='radio' name='right_care' value='สิทธิข้าราชการ'> สิทธิข้าราชการ $space 
												<input type='radio' name='right_care' value='สิทธิประกันสังคม' checked> สิทธิประกันสังคม $space 
												<input type='radio' name='right_care' value='สิทธิต่างด้าว'> สิทธิต่างด้าว $space 
												<input type='radio' name='right_care' value='สิทธิอื่นๆ'> สิทธิอื่นๆ <br><br>
				";
			}

			if ($_right_care=="สิทธิต่างด้าว")	{
				print "	สิทธิการรักษา : <input type='radio' name='right_care' value='UC'> UC $space 
												<input type='radio' name='right_care' value='สิทธิข้าราชการ'> สิทธิข้าราชการ $space 
												<input type='radio' name='right_care' value='สิทธิประกันสังคม'> สิทธิประกันสังคม $space 
												<input type='radio' name='right_care' value='สิทธิต่างด้าว' checked> สิทธิต่างด้าว $space 
												<input type='radio' name='right_care' value='สิทธิอื่นๆ'> สิทธิอื่นๆ <br><br>
				";
			}

			if ($_right_care=="สิทธิอื่นๆ")	{
				print "	สิทธิการรักษา : <input type='radio' name='right_care' value='UC'> UC $space 
												<input type='radio' name='right_care' value='สิทธิข้าราชการ'> สิทธิข้าราชการ $space 
												<input type='radio' name='right_care' value='สิทธิประกันสังคม'> สิทธิประกันสังคม $space 
												<input type='radio' name='right_care' value='สิทธิต่างด้าว'> สิทธิต่างด้าว $space 
												<input type='radio' name='right_care' value='สิทธิอื่นๆ' checked> สิทธิอื่นๆ <br><br>
				";
			}

			if ($_right_care=="")	{
				print "	สิทธิการรักษา : <input type='radio' name='right_care' value='UC'> UC $space 
												<input type='radio' name='right_care' value='สิทธิข้าราชการ'> สิทธิข้าราชการ $space 
												<input type='radio' name='right_care' value='สิทธิประกันสังคม'> สิทธิประกันสังคม $space 
												<input type='radio' name='right_care' value='สิทธิต่างด้าว'> สิทธิต่างด้าว $space 
												<input type='radio' name='right_care' value='สิทธิอื่นๆ'> สิทธิอื่นๆ <br><br>
				";
			}

			print "	<input type='submit' value=' บันทึกข้อมูล '>		</p>
			</form></div>
			<p>";
		}

		if (isset($_POST["keyword"]))	{
			$keyword =$_POST["keyword"];

			print "<div id='append_div' style='border:1px solid #000; margin:10px 0 10px 0; padding:1rem;'>
			<form id='append_form' name='append_form' method='post' action='append_data.php?append'>

			<p>เลขบัตรประชาชน : <input type='text' name='id_card' size='12' maxlength='13' autocomplete='off' autofocus> $space
					ชื่อ - สกุล : <input type='text' name='fname' value='$keyword'  autocomplete='off'> $space
					เพศ : <input type='radio' name='sex' value='ชาย'> ชาย $space <input type='radio' name='sex' value='หญิง'> หญิง $space
					อายุ : <input type='text' name='age'  autocomplete='off'> <br><br>
					สิทธิการรักษา : <input type='radio' name='right_care' value='UC'> UC $space 
											<input type='radio' name='right_care' value='สิทธิข้าราชการ'> สิทธิข้าราชการ $space 
											<input type='radio' name='right_care' value='สิทธิประกันสังคม'> สิทธิประกันสังคม $space 
											<input type='radio' name='right_care' value='สิทธิต่างด้าว'> สิทธิต่างด้าว $space 
											<input type='radio' name='right_care' value='สิทธิอื่นๆ'> สิทธิอื่นๆ <br><br>
					<input type='submit' value=' บันทึกข้อมูล '>
			</p>

			</form></div>
			<p>";

		}

		//+++	การนำข้อมูลใหม่ที่ได้ทำการบันทึกไปขึ้นมาแสดงผล
		if (isset($_GET["append"]))	{
			$name_search =str_replace("  ", " ", trim($_POST["fname"]));

			$sql =mysql_query("select * from ptt_profile where fname ='$name_search'	");
			$show_rec =mysql_fetch_array($sql);
				$id =$show_rec["id_card"];
				$sex =$show_rec["sex"];
				$age =$show_rec["age"];
				$right_care =$show_rec["right_care"];

			if ($culture=="1")		{	//+++	สำหรับ จนท.ที่ลงผล Culture
				print "<a href='append_cul.php?cul=$name_search'><span id='cul' class='label label-success'> Culture </span></a>	&nbsp;";
			}

			if ($identification=="1")		{	//+++	สำหรับ จนท.ที่ลงผล Identification
				print "<a href='append_iden.php?iden=$name_search'><span id='iden' class='label label-info'> Identification </span></a>	&nbsp;";
			}

			if ($sensitivity=="1")		{	//+++	สำหรับ จนท.ที่ลงผล DST
				print "<a href='append_dst.php?dst=$name_search'><span id='dst' class='label label-info'> DST </span></a>	&nbsp;";
			}

			if ($molecular=="1")		{	//+++	สำหรับ จนท.ที่ลงผล Molecular
				print "<a href='append_mol.php?mol=$name_search'><span id='mol' class='label label-warning'> Molecular </span></a>	&nbsp;";
			}

			if ($approve=="1")		{	//+++	สำหรับ จนท.ที่รับรองผลตรวจ
				print "<a href='append_appr.php?appr=$name_search'><span id='appr' class='label label-danger'> Approve </span></a>	&nbsp;";
			}

			if ($sample=="1")	{
				print "	</p><div id='profile1_div' style='border:1px solid #000; padding:1rem;'>
					<p id='profile1_p'>	
						เลขบัตรประชาชน : $id $space ชื่อ - สกุล : $name_search $space เพศ : $sex $space อายุ : $age $space สิทธิการรักษา : $right_care
						$space <a href='./append_data.php?edit=$name_search' onclick=\"return confirm('ท่านต้องการแก้ไขข้อมูล ใช่หรือไม่?')\">	
							<img src='./images/edit.gif'>	</a>
						$space <a href='./append_data.php?delete=$name_search' 
							onclick=\"return confirm('การลบข้อมูลผู้ป่วย ระบบจะทำการลบผลการตรวจวิเคราะห์ทุกอย่างโดยอัตโนมัติ 	ท่านต้องการลบข้อมูล ใช่หรือไม่?')\">
							<img src='./images/delete.png'>
						</a>
					</p>
				</div>";
			}else{
				print "	</p><div id='profile1_div' style='border:1px solid #000; padding:1rem;'>
					<p id='profile1_p'>	
						เลขบัตรประชาชน : $id $space ชื่อ - สกุล : $name_search $space เพศ : $sex $space อายุ : $age $space สิทธิการรักษา : $right_care
					</p>
				</div>";
			}

		}else{

			if (isset($_GET["select"]))	{		//+++	การนำข้อมูลในฐานขึ้นมาแสดงผล
				if (isset($_POST["search_name"]))	{
					$name_search =$_POST["search_name"];
				}

				if (isset($_GET["fn"]))	{
					$name_search =$_GET["fn"];
				}

				$sql =mysql_query("select * from ptt_profile where fname like '$name_search'	");
				$list_row =mysql_fetch_array($sql);
					$id =$list_row["id_card"];
					$sex =$list_row["sex"];
					$age =$list_row["age"];
					$right_care =$list_row["right_care"];

				if ($culture=="1")		{	//+++	สำหรับ จนท.ที่ลงผล Culture
					print "<a href='append_cul.php?cul=$name_search'><span id='cul' class='label label-success'> Culture </span></a>	&nbsp;";
				}

				if ($identification=="1")		{	//+++	สำหรับ จนท.ที่ลงผล Identification
					print "<a href='append_iden.php?iden=$name_search'><span id='iden' class='label label-info'> Identification </span></a>	&nbsp;";
				}

				if ($sensitivity=="1")		{	//+++	สำหรับ จนท.ที่ลงผล DST
					print "<a href='append_dst.php?dst=$name_search'><span id='dst' class='label label-info'> DST </span></a>	&nbsp;";
				}

				if ($molecular=="1")		{	//+++	สำหรับ จนท.ที่ลงผล Molecular
					print "<a href='append_mol.php?mol=$name_search'><span id='mol' class='label label-warning'> Molecular </span></a>	&nbsp;";
				}

				if ($approve=="1")		{	//+++	สำหรับ จนท.ที่รับรองผลตรวจ
					print "<a href='append_appr.php?appr=$name_search'><span id='appr' class='label label-danger'> Approve </span></a>	&nbsp;";
				}

				if ($sample=="1")	{
					print "	</p><div id='profile1_div' style='border:1px solid #000; padding:1rem;'>
						<p id='profile1_p'>	
							เลขบัตรประชาชน : $id $space ชื่อ - สกุล : $name_search $space เพศ : $sex $space อายุ : $age $space สิทธิการรักษา : $right_care
							$space <a href='./append_data.php?edit=$name_search' onclick=\"return confirm('ท่านต้องการแก้ไขข้อมูล ใช่หรือไม่?')\">
								<img src='./images/edit.gif'>	</a>
							$space <a href='./append_data.php?delete=$name_search' 
							onclick=\"return confirm('การลบข้อมูลผู้ป่วย ระบบจะทำการลบผลการตรวจวิเคราะห์ทุกอย่างโดยอัตโนมัติ	ท่านต้องการลบข้อมูล ใช่หรือไม่?')\">
								<img src='./images/delete.png'>
							</a>
						</p>
					</div><p>";
				}else{
					print "	</p><div id='profile1_div' style='border:1px solid #000; padding:1rem;'>
						<p id='profile1_p'>	
							เลขบัตรประชาชน : $id $space ชื่อ - สกุล : $name_search $space เพศ : $sex $space อายุ : $age $space สิทธิการรักษา : $right_care
						</p>
					</div><p>";
				}

			}
		}

	}else{
		$pt_name =$_GET["pt_name"];
		$cno =$_GET["cno"];

		$sql =mysql_query("select * from culture where fname='$pt_name' and cul_no='$cno'	");
		$row_cul =mysql_fetch_array($sql);
			$datein =$row_cul["date_in"];
			$froms =$row_cul["froms"];
			$result =$row_cul["result"];
				if ($result=='Waiting' or $result=='Waiting 4-8 weeks')	{		//+++	การกำหนด สีเหลือง
					$color ="#ff0";
				}else{

					if ($result=='N/A' or $result=='Not Done' or $result=='Invalid')	{		//+++	การกำหนด สีแดง
						$color ="#f69";
					}else{	//+++	การกำหนด สีเขียว
						$color ="#0f0";
					}
				}

//+++	สร้างเงื่อนไขการตรวจสอบ Approve แล้วแก้ไข
			$sql_check_approve =mysql_query("select result from approve where fname='$pt_name' and cul_no='$cno'	");
			$row_check_approve =mysql_num_rows($sql_check_approve);
			$show_check_approve =mysql_fetch_array($sql_check_approve);
				$approve_result =$show_check_approve["result"];
//+++++++++++++++++++++++++++++++++++





		if ($culture=="1")		{	//+++	สำหรับ จนท.ที่ลงผล Culture
			print "<a href='append_cul.php?cul=$pt_name'><span id='cul' class='label label-success'> Culture </span></a>	&nbsp;";
		}

		if ($identification=="1")		{	//+++	สำหรับ จนท.ที่ลงผล Identification
			print "<a href='append_iden.php?iden=$pt_name'><span id='iden' class='label label-info'> Identification </span></a>	&nbsp;";
		}

		if ($sensitivity=="1")		{	//+++	สำหรับ จนท.ที่ลงผล DST
			print "<a href='append_dst.php?dst=$pt_name'><span id='dst' class='label label-info'> DST </span></a>	&nbsp;";
		}

		if ($molecular=="1")		{	//+++	สำหรับ จนท.ที่ลงผล Molecular
			print "<a href='append_mol.php?mol=$pt_name'><span id='mol' class='label label-warning'> Molecular </span></a>	&nbsp;";
		}

		if ($approve=="1")		{	//+++	สำหรับ จนท.ที่รับรองผลตรวจ
			print "<a href='append_appr.php?appr=$pt_name'><span id='appr' class='label label-danger'> Approve </span></a>	&nbsp;";
		}










		print "	</p>		<div class='table-responsive'>
						<table class='table table-hover'>
							<thead>
								<tr class='success'>
									<th style='color:#2F70A8;'>วันที่รับตัวอย่าง</th>
									<th style='color:#2F70A8;'>ชื่อ - สกุล ผู้ป่วย</th>
									<th style='color:#2F70A8;'>Culture No.</th>
									<th style='color:#2F70A8;'>โรงพยาบาล</th>
									<th style='color:#2F70A8;'>Culture</th>
									<th style='color:#2F70A8;'>Identification</th>
									<th style='color:#2F70A8;'>DST</th>
									<th style='color:#2F70A8;'>Mole</th>
									<th style='color:#2F70A8; text-align:center;'>Approved</th>
									<th style='color:#2F70A8; text-align:center;'>รายงานผล</th>
								</tr>
							</thead>
							<tbody>
		";
		print "<tr>
			<td>$datein</td>
			<td>$pt_name</td>
		";

		if ($approve=="1")	{
			print "	<td><a href='./edit_culno.php?ptname=$pt_name&culno=$cno&senddate=$datein'>$cno</a></td>	";
		}else{
			print "	<td>$cno</td>	";
		}

		print "	<td>$froms</td>		";

/*		if ($culture=="1" and ($row_check_approve==0 or $approve_result==0))	{
			print "	<td style='background-color:$color;'>
					<a href='./append_cul.php?culture&ptt=$pt_name&culno=$cno'>$result	</a>
				</td>
			";
		}else{

			if ($culture=="1" and $approve=="1")	{
				print "	<td style='background-color:$color;'>
						<a href='./append_cul.php?culture&ptt=$pt_name&culno=$cno'>$result	</a>
					</td>
				";
			}else{
				print "	<td style='background-color:$color;'>$result	</td>		";
			}
		}
*/
		if ($culture=="1")	{
			print "	<td style='background-color:$color;'>
					<a href='./append_cul.php?culture&ptt=$pt_name&culno=$cno'>$result	</a>
				</td>
			";
		}else{

			print "	<td style='background-color:$color;'>$result	</td>		";
		}

		$sql_iden =mysql_query("select i.* from identification i,culture c
		where i.fname=c.fname and i.cul_no=c.cul_no and i.fname='$pt_name' 
			and i.cul_no='$cno'	order by i.fname desc, i.cul_no desc 	");

		$sql_dst =mysql_query("select dst.* from dst,culture c
		where dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$pt_name' 
			and dst.cul_no='$cno' and dst.anal_method in('Solid-FLDST','Solid-SLDST','Liquid-FLDST MGIT',
			   'Liquid-FLDST MTT','Liquid-SLDST')
		order by dst.fname desc, dst.cul_no desc 	");

		$sql_mol =mysql_query("select dst.* from dst,culture c
		where dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$pt_name' 
			and dst.cul_no='$cno' and dst.anal_method in('LPA-FLDST','LPA-SLDST','Real-time PCR FLDST',
			   'Real-time PCR SLDST','Gene-Xpert FLDST','Gene-Xpert SLDST')
		order by dst.fname desc, dst.cul_no desc 	");

		$sql_appr =mysql_query("select * from approve where fname='$pt_name' and cul_no='$cno'	");

		$rows_iden =mysql_num_rows($sql_iden);
		$show_iden =mysql_fetch_array($sql_iden);
			$iden_result =$show_iden["result"];		
			
			if ($rows_iden<=0)	{
				$color ="#666";
			}else{
				if ($iden_result=='Waiting')	{
					$color ="#ff0";
				}else{
					if ($iden_result=='N/A' or $iden_result=='Not Done' or $iden_result=='Invalid')	{
						$color ="#f69";
					}else{
						$color ="#0f0";
					}
				}
			}

/*			if ($identification=="1" and ($row_check_approve==0 or $approve_result==0))	{	
				print "	<td style='background-color:$color;'>
					<a href='./append_iden.php?ptt=$pt_name&culno=$cno'>$iden_result	</a>
				</td>				";
			}else{

				if ($identification=="1" and $approve=="1")	{
					print "	<td style='background-color:$color;'>
						<a href='./append_iden.php?ptt=$pt_name&culno=$cno'>$iden_result	</a>
					</td>				";
				}else{
					print "	<td style='background-color:$color;'>$iden_result			</td>				";
				}
			}
*/
			if ($identification=="1")	{	
				print "	<td style='background-color:$color;'>
					<a href='./append_iden.php?ptt=$pt_name&culno=$cno'>$iden_result	</a>
				</td>				";
			}else{

				print "	<td style='background-color:$color;'>$iden_result			</td>				";
			}


		$rows_dst =mysql_num_rows($sql_dst);
		$show_dst =mysql_fetch_array($sql_dst);
			$dst_result =$show_dst["result"];
				if ($dst_result=="Susceptible" or $dst_result=="Resistance")	{	$dst_result="Result";	}
			
			if ($rows_dst<=0)	{
				$color ="#666";
			}else{
				if ($dst_result=='Waiting' or $dst_result=='Waiting 4-8 weeks')	{
					$color ="#ff0";
				}else{
					if ($dst_result=='N/A' or $dst_result=='Not Done' or $dst_result=='Invalid')	{
						$color ="#f69";
					}else{
						$color ="#0f0";
					}
				}
			}

/*			if ($sensitivity=="1" and ($row_check_approve==0 or $approve_result==0))	{	
				print "	<td style='background-color:$color;'>
					<a href='./update_dst.php?dst&ptt=$pt_name&culno=$cno'>$dst_result	</a>
				</td>				";
			}else{

				if ($sensitivity=="1" and $approve=="1")	{
					print "	<td style='background-color:$color;'>
						<a href='./update_dst.php?dst&ptt=$pt_name&culno=$cno'>$dst_result	</a>
					</td>				";
				}else{
					print "	<td style='background-color:$color;'>$dst_result			</td>				";
				}
			}
*/
			if ($sensitivity=="1")	{	
				print "	<td style='background-color:$color;'>
					<a href='./update_dst.php?dst&ptt=$pt_name&culno=$cno'>$dst_result	</a>
				</td>				";
			}else{

				print "	<td style='background-color:$color;'>$dst_result			</td>				";
			}

			$rows_mol =mysql_num_rows($sql_mol);
			$show_mol =mysql_fetch_array($sql_mol);
				$mol_result =$show_mol["anal_result"];

				if ($rows_mol<=0)	{
					$color ="#666";
				}else{
					if ($mol_result=='Waiting' or $mol_result=='Waiting 4-8 weeks')	{
						$color ="#ff0";
					}else{
						if ($mol_result=='N/A' or $mol_result=='Not Done' or $mol_result=='Invalid')	{
							$color ="#f69";
						}else{
							$color ="#0f0";
						}
					}
				}

/*				if ($molecular=="1" and ($row_check_approve==0 or $approve_result==0))	{		
					print "	<td style='background-color:$color;'>
						<a href='./update_mol.php?molecular&ptt=$pt_name&culno=$cno'>$mol_result	</a>
					</td>				";
				}else{

					if ($molecular=="1" and $approve=="1")	{
						print "	<td style='background-color:$color;'>
							<a href='./update_mol.php?molecular&ptt=$pt_name&culno=$cno'>$mol_result	</a>
						</td>				";
					}else{
						print "	<td style='background-color:$color;'>$mol_result		</td>				";
					}
				}
*/
				if ($molecular=="1")	{		
					print "	<td style='background-color:$color;'>
						<a href='./update_mol.php?molecular&ptt=$pt_name&culno=$cno'>$mol_result	</a>
					</td>				";
				}else{

					print "	<td style='background-color:$color;'>$mol_result		</td>				";
				}

			$show_appr =mysql_fetch_array($sql_appr);
				$appr_result =$show_appr["result"];
				if ($appr_result=='1')	{
					print "	<td style='text-align:center;'><img src='./images/approve.png'></td>				";
				}else{
					print "	<td style='text-align:center;'></td>				";
				}

			print "<td style='text-align:center;'>
				<a href='report.php?pt_name=$pt_name&cno=$cno' target='_blank'><img src='./images/eye.jpg'></a>
			</td>		</tr>";

			print "</tr></tbody></table></div>";
			print "<p>	<span class='label label-danger'>N/A , Invalid</span>
					<span style='background-color:#ff0; font-size:0.75em; padding:3px; font-weight:bold;'> Waiting , Waiting 4-8 weeks </span>
					<span class='label label-success'>ผลออก</span>
					<span style='background-color:#666; font-size:0.75em; padding:3px; font-weight:bold; color:#fff;'>&nbsp; Not Done , ยังไม่ได้ลงทะเบียน &nbsp;</span>
			</p>";

	}

}else{		//+++	ถ้ายังไม่เข้าระบบ ให้ไปที่ ./

	print "<script>
		alert('ท่านไม่ได้รับสิทธิ์ในการใช้งานหน้านี้ ..'); 
		window.location='./';
	</script>";
}

?>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

<?PHP	mysql_close($tb_conn);	?>

</body>
</html>