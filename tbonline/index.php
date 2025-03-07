<?PHP
	include("./tblab_connector.php");

	if (isset($_GET["get"]) and $_GET["get"]=="out"){			//=== ตรวจสอบการออกจากระบบ
		session_unset();
		session_destroy(); 

		print "		<meta http-equiv=\"refresh\" content=\"0; url=./index.php \">";
	}

	//+++	ตรวจสอบการเข้าระบบจะต้องมี username password
	if (isset($_POST["user_name"]) and isset($_POST["user_pwd"]))	{
		$user_name =$_POST["user_name"];
			$count_char =strlen($user_name);
		$post_pwd =$_POST["user_pwd"];

		//+++	ตรวจสอบ off_id ว่าเป็น รพ.ทั่วไป หรือ จนท.สนง.
		if ($count_char >5)	{		//+++	จนท.สนง.
			$sql1 =mysql_query("select u.off_id, u.user_pwd, u.user, u.sample, u.culture, u.identification, u.sensitivity, u.molecular, 
				u.approve, u.export_data, p.fname, p.position, p.level
			from user u, person p
			where u.off_id=p.id_card and u.off_id='$user_name'	");
		}else{		//+++	รพ.ทั่วไป
			$sql1 =mysql_query("select u.off_id, u.user_pwd, u.user, u.sample, u.culture, u.identification, u.sensitivity, u.molecular, 
				u.approve, u.export_data, h.off_name1, h.off_name2, h.region_nhso
			from user u, hospcode h
			where u.off_id=h.off_id and u.off_id='$user_name'	");
		}
		
		$rows1 =mysql_num_rows($sql1);

		if ($rows1 >0){		//+++	ตรวจสอบ off_id ว่าได้ลงทะเบียนไว้หรือยัง
			$show_rec =mysql_fetch_array($sql1);
				$user_pwd =$show_rec["user_pwd"] ;

				if ($user_pwd==$post_pwd)	{	//+++	ตรวจสอบรหัสผ่าน ถ้าถูกต้อง สร้าง session
					$_SESSION["user_name"] =$user_name;
					$_SESSION["user_pwd"] =$user_pwd;
					$_SESSION["user"] =$show_rec["user"] ;
					$_SESSION["sample"] =$show_rec["sample"] ;
					$_SESSION["culture"] =$show_rec["culture"] ;
					$_SESSION["identification"] =$show_rec["identification"] ;
					$_SESSION["sensitivity"] =$show_rec["sensitivity"] ;
					$_SESSION["molecular"] =$show_rec["molecular"] ;
					$_SESSION["approve"] =$show_rec["approve"] ;
					$_SESSION["export_data"] =$show_rec["export_data"] ;

					if ($count_char >5)	{
						$_SESSION["off_name1"] =$show_rec["level"] ;
						$_SESSION["off_name2"] =$show_rec["position"] ;
						$_SESSION["region_nhso"] =$show_rec["fname"] ;
					}else{
						$_SESSION["off_name1"] =$show_rec["off_name1"] ;
						$_SESSION["off_name2"] =$show_rec["off_name2"] ;
						$_SESSION["region_nhso"] =$show_rec["region_nhso"] ;
					}

					$use_date =(date("Y")+543) . date("-m-d H-i");
					mysql_query("update user set use_date='$use_date', use_count=(use_count+1)
						where off_id='$user_name'	");

				}else{
					print "<script>
						alert('รหัสผ่านไม่ถูกต้อง กรุณาลองใหม่ หรือติดต่อผู้ดูแลระบบ  ..'); 
						window.location='./index.php';
					</script>";
				}

		}else{
			print "<script>
				alert('ท่านไม่ใช่สมาชิก กรุณาติดต่อผู้ดูแลระบบ  ..'); 
				window.location='./index.php';
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
			document.getElementById("profile1_p").innerHTML="";
			document.getElementById("profile1_div").style.display = "none";
			document.getElementById("work_permit").innerHTML="";
			document.getElementById("qdata").style.display="none";
			document.getElementById("keyword").value = "";
			document.getElementById("keyword").focus();
			document.getElementById("td1").innerHTML="";
			document.getElementById("td2").innerHTML="";
			return;
		}	

		//+++ ฟังก์ชัน ค้นหาชื่อในฐานข้อมูล
		function find_name(str) {
			if (str == "") {
				return;
			} else { 
				document.getElementById("search_name").innerHTML="";
				document.getElementById("search_name").style.display="block";
				document.getElementById("qdata").style.display="block";
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

/*		//+++ ฟังก์ชัน เอารายละเอียดข้อมูลมาแสดง
		function get_data(str) {
			if (str == "") {
				document.getElementById("profile1_p").innerHTML = "";
				return;
			} else { 

				document.getElementById("work_permit").style.display="block";
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
				xmlhttp.open("GET","get_data.php?getdata="+str,true);
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
				<a href="./"><img src="./images/home.png" style="align:middle;"></a>
				TB-Online for ODPC 7 Khon Kaen<a href="./index.php?get=out">&nbsp;&nbsp;&nbsp;<img src="./images/signout.png"></a> 
			</p>
			<br>

<?PHP
	//+++	ตรวจสอบการเข้าระบบ ถ้ายังไม่เข้าให้แสดงฟอร์มการ sign in
	if (! isset($_SESSION["user_name"]))	{
		print "		</div><!-- end panel-heading -->
			<div class='panel-body' style='color:#2F70A8;'>	
		";
		print "<form class='form-horizontal' role='form' name='step_name' method='post' action='./index.php'>
						<div class='form-group'>
							<label for='user_name' class='col-sm-2 control-label'>Username</label>
							<div class='col-sm-10'>
								<input type='text' class='form-control' name='user_name' placeholder='โปรดระบุ ..' required autofocus autocomplete='off'>
							</div>
						</div>
					<div class='form-group'>
						<label for='user_pwd' class='col-sm-2 control-label'>Password</label>
						<div class='col-sm-10'>
							<input type='password' class='form-control' name='user_pwd' placeholder='โปรดระบุ ..' required autocomplete='off'>
						</div>
					</div>
						<div class='form-group'>
							<div class='col-sm-offset-2 col-sm-10'>
								<button type='submit' class='btn btn-primary'> ตกลง </button>
							</div>
						</div>
					</form>
		";

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

		//+++	เครื่องมือค้นหา ผป.เก่า และสามารถเชื่อมต่อการเพิ่มข้อมูลใหม่ได้
		print "		<div style='border:1px solid #000; padding:1rem;'>
		<p>	<form id='search_ptt' name='search_ptt' method='post' action='index.php' >
					<input type='button' value=' ล้างข้อความ ' onclick=\"get_clear()\">
					<input type='text' id='keyword' name='keyword'  autofocus autocomplete='off' 
						placeholder='ค้นโดยชื่อ หรือบัตรประชาชน' onkeyup=\"find_name(this.value)\">
				</form>
		</p>
		<p>
			<form id='name_search' name='name_search' method='post' action='index.php'>
				<select id='search_name' name='search_name' size='10' style='width:100%; display:none;' >

				</select>	
				<input type='submit' id='qdata' value=' ดึงข้อมูล ' style='display:none;'>
			</form>
		</p>
		</div>	<br>
		";
		
		if ($sample=="1")		{		
			print "<div style='border:1px solid #000; padding:1rem;'><p>
				<form id='hosp_search' name='hosp_search' method='post' action='index.php?multisearch'>
					<p>
						<input type='text' id='ptname' name='ptname' autocomplete='off' placeholder='ส่วนหนึ่งของ ชื่อ-สกุล'>
						<input type='text' id='cn' name='cn' autocomplete='off' placeholder='และ/หรือ Culture NO.'>
						<select id='search_hosp' name='search_hosp'>
							<option selected value=''>เลือกชื่อสถานพยาบาล ..</option>
			";

			$sql_hosp =mysql_query("select distinct froms from culture order by froms");
			while ($list_hosp =mysql_fetch_array($sql_hosp)){
				$hosp =$list_hosp["froms"];
				print "<option value='$hosp'>$hosp</option>";
			}
			print "			</select>	</p>
				<p>
					ตั้งแต่วันที่ : <input type='text' id='start_date' name='start_date' autocomplete='off' placeholder='รูปแบบ : ปี พ.ศ. - เดือน - วัน'>
					ถึงวันที่ : <input type='text' id='end_date' name='end_date' autocomplete='off' placeholder='รูปแบบ : ปี พ.ศ. - เดือน - วัน'>
				</p>
				<p>	<input type='submit' value=' สืบค้น '> &nbsp; <input type='reset' value=' ล้างข้อมูล '>	</p>
				</form>
			";
			print "</div>	<br>		";
		}


		if (isset($_POST["search_name"]) or isset($_GET["search_name"])){	//+++	ถ้ามีการสืบค้น ให้แสดงข้อมูลของการสืบค้น
			if (isset($_POST["search_name"]))	{
				$search_name=$_POST["search_name"];
			}

			if (isset($_GET["search_name"]))	{
				$search_name=$_GET["search_name"];
			}

			$sql =mysql_query("select * from ptt_profile where fname='$search_name'	");
			$show_profile =mysql_fetch_array($sql);
				$id =$show_profile["id_card"];
				$sex =$show_profile["sex"];
				$age =$show_profile["age"];
				$right_care =$show_profile["right_care"];
				$space ='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	';
		}
		
		if (isset($_POST["search_name"]) or isset($_GET["search_name"])){	
			//+++	ตรวจสอบการนำข้อมูลเดิม จากเครื่องมือสืบค้นขึ้นมาแสดง
			print "	<div id='profile1_div' style='margin:0 0 10px 0; border:1px solid #000; padding:1rem;'>
				<p id='profile1_p'>เลขบัตรประชาชน : $id $space ชื่อ - สกุล : $search_name $space เพศ : $sex $space อายุ : $age $space สิทธิการรักษา : $right_care	</p>
			</div>	";
		}else{

			//+++	ตรวจสอบการนำข้อมูลเดิม จากเครื่องมือสืบค้นขึ้นมาแสดง ถ้าไมีมีการสืบค้นให้ ซ่อน profile1_div
			print "	<div id='profile1_div' style='margin:0 0 10px 0; border:1px solid #000; padding:1rem; display:none;'>
				<p id='profile1_p'>	</p>
			</div>	";
		}
		
		print "			<div class='table-responsive'>
			<p>	<span class='label label-danger'>N/A , Invalid</span>
				<span style='background-color:#ff0; font-size:0.75em; padding:3px; font-weight:bold;'> Waiting , Waiting 4-8 weeks </span> &nbsp;
				<span class='label label-success'>ผลออก</span>
				<span style='background-color:#ccc; font-size:0.75em; padding:3px; font-weight:bold; color:#fff;'>&nbsp; Not Done , ยังไม่ได้ลงทะเบียน &nbsp;</span>
			</p>
						<table class='table table-hover' style='font-size:0.9em;'>
							<thead>
								<tr class='success'>
									<th style='color:#2F70A8;'>ลำดับ</th>
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

		$this_month =date("n");
		if (isset($_POST["search_name"]) or isset($_GET["search_name"])){	//+++	ถ้ามีการสืบค้น ให้แสดงข้อมูล Culture
			if ($count_char >5)	{	//+++	ถ้าผู้เข้าระบบมาสืบค้นเป็น จนท.สคร.
				$sql_cul =mysql_query("select * from culture 	where fname='$search_name' order by date_in desc, cul_no desc 	");
			}else{
				$sql_cul =mysql_query("select * from culture 	where fname='$search_name' and froms='$off_name1' 	order by date_in desc, cul_no desc	");
			}

		}else{			//+++	ถ้า ไม่มีการสืบค้น ให้ดึงข้อมูลของเดือนปัจจุบัน culture

			if ($count_char >5)	{	//+++	แสดงข้อมูลผลการตรวจทั้งหมด
				$sql_cul =mysql_query("select * from culture 
					where month(date_in)=$this_month order by date_in desc, cul_no desc	");

			}else{	//+++	แสดงข้อมูลผลการตรวจเฉพาะรพ. ที่จนท.รพ.นั้นเข้าระบบ

				$sql_cul =mysql_query("select c.* from culture c, hospcode h 
					where month(c.date_in)=$this_month and c.froms=h.off_name1 and h.off_id='$user_name'
					order by c.date_in, c.fname, c.cul_no	");
			}
		}

		if (isset($_GET["multisearch"]))	{
			$x =1;
			$sql_multi ="select * from culture 	";

			if (isset($_POST["ptname"]) and $_POST["ptname"] !="")	{
				$ptname =$_POST["ptname"];
				if ($x==1)	{
					$sql_multi .=" where fname like '%$ptname%'	";
				}else{
					$sql_multi .=" and fname like '%$ptname%'	";
				}

				$x =0;
			}

			if (isset($_POST["cn"]) and $_POST["cn"] !="")	{
				$cn =$_POST["cn"];
				if ($x==1)	{
					$sql_multi .=" where cul_no ='$cn'	";
				}else{
					$sql_multi .=" and cul_no ='$cn'	";
				}

				$x =0;
			}

			if (isset($_POST["search_hosp"]) and $_POST["search_hosp"] !="")	{
				$hosp_name =$_POST["search_hosp"];
				if ($x==1)	{
					$sql_multi .=" where froms ='$hosp_name'	";
				}else{
					$sql_multi .=" and froms ='$hosp_name'	";
				}

				$x =0;
			}
			
			if (isset($_POST["start_date"]) and $_POST["start_date"] !="" 
				and isset($_POST["end_date"]) and $_POST["end_date"] !="")	{

				$start_date =$_POST["start_date"];
				$end_date =$_POST["end_date"];
				if ($x==1)	{
					$sql_multi .=" where date_in>='$start_date' and date_in<='$end_date'	";
				}else{
					$sql_multi .=" and date_in>='$start_date' and date_in<='$end_date'	";
				}

				$x =0;
			}
			
			if ($_POST["search_hosp"] =="" and $_POST["cn"] =="" and $_POST["ptname"] ==""
				and $_POST["start_date"] =="" and $_POST["end_date"] =="")	{
				$sql_multi ="select * from culture where month(date_in)=$this_month";
			}
			
			$sql_multi .=" order by date_in desc, froms asc	";
			$sql_cul =mysql_query($sql_multi);
		}

		$i =1;
		while ($list_cul =mysql_fetch_array($sql_cul))	{
			$date_in =$list_cul["date_in"];
			$ptt_name =$list_cul["fname"];
			$cul_no =$list_cul["cul_no"];
			$froms =$list_cul["froms"];
			$result =$list_cul["result"];
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
			$sql_check_approve =mysql_query("select result from approve where fname='$ptt_name' and cul_no='$cul_no'	");
			$row_check_approve =mysql_num_rows($sql_check_approve);
			$show_check_approve =mysql_fetch_array($sql_check_approve);
				$approve_result =$show_check_approve["result"];
//+++++++++++++++++++++++++++++++++++

			print "<tr>
				<td>$i</td>
				<td>$date_in</td>
				<td>$ptt_name</td>
			";

			if ($approve=="1")	{
				print "	<td><a href='./edit_culno.php?ptname=$ptt_name&culno=$cul_no&senddate=$date_in' target='_blank'>$cul_no</a></td>	";
			}else{
				print "	<td>$cul_no</td>	";
			}

			print "	<td>$froms</td>		";

/*			if ($culture=="1" and ($row_check_approve==0 or $approve_result==0))	{
				print "	<td style='background-color:$color;'>
						<a href='./append_cul.php?culture&ptt=$ptt_name&culno=$cul_no' target='_blank'>$result	</a>
					</td>
				";
			}else{

				if ($culture=="1" and $approve=="1")	{
					print "	<td style='background-color:$color;'>
							<a href='./append_cul.php?culture&ptt=$ptt_name&culno=$cul_no' target='_blank'>$result	</a>
						</td>
					";
				}else{
					print "	<td style='background-color:$color;'>$result	</td>		";
				}
			}
*/
			if ($culture=="1")	{
				print "	<td style='background-color:$color;'>
						<a href='./append_cul.php?culture&ptt=$ptt_name&culno=$cul_no' target='_blank'>$result	</a>
					</td>
				";
			}else{
					
					print "	<td style='background-color:$color;'>$result	</td>		";
			}


		if (isset($_POST["search_name"]) or isset($_GET["search_name"])){		//+++	ถ้ามีการสืบค้น ให้แสดงข้อมูลของการสืบค้น DST, Molecular, Approve
			if ($count_char >5)	{	//+++	แสดงข้อมูลผลการตรวจทั้งหมด
				$sql_iden =mysql_query("select i.* from identification i,culture c
				where i.fname=c.fname and i.cul_no=c.cul_no and i.fname='$ptt_name' 
					and i.cul_no='$cul_no'	order by i.fname desc, i.cul_no desc 	");

				$sql_dst =mysql_query("select dst.* from dst,culture c
				where dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$ptt_name' 
					and dst.cul_no='$cul_no' and dst.anal_method in('Solid-FLDST','Solid-SLDST','Liquid-FLDST MGIT',
					   'Liquid-FLDST MTT','Liquid-SLDST')
				order by dst.fname desc, dst.cul_no desc 	");

				$sql_mol =mysql_query("select dst.* from dst,culture c
				where dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$ptt_name' 
					and dst.cul_no='$cul_no' and dst.anal_method in('LPA-FLDST','LPA-SLDST','Real-time PCR FLDST',
					   'Real-time PCR SLDST','Gene-Xpert FLDST','Gene-Xpert SLDST')
				order by dst.fname desc, dst.cul_no desc 	");

				$sql_appr =mysql_query("select * from approve where fname='$ptt_name' and cul_no='$cul_no'	");

			}else{	//+++	แสดงข้อมูลผลการตรวจเฉพาะรพ. ที่จนท.รพ.นั้นเข้าระบบ
				$sql_iden =mysql_query("select i.* from identification i, culture c, hospcode h
				where i.fname=c.fname and i.cul_no=c.cul_no and i.fname='$ptt_name' 
					and i.cul_no='$cul_no'	and c.froms=h.off_name1 and h.off_id='$user_name'
				order by i.fname, i.cul_no 	");

				$sql_dst =mysql_query("select dst.* from dst	,culture c, hospcode h
				where dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$ptt_name' 
					and dst.cul_no='$cul_no' and dst.anal_method in('Solid-FLDST','Solid-SLDST','Liquid-FLDST MGIT',
																   'Liquid-FLDST MTT','Liquid-SLDST')
					and c.froms=h.off_name1 and h.off_id='$user_name'
				order by dst.anal_method, dst.drug 	");

				$sql_mol =mysql_query("select dst.* from dst	,culture c, hospcode h
				where dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$ptt_name' 
					and dst.cul_no='$cul_no' and dst.anal_method in('LPA-FLDST','LPA-SLDST','Real-time PCR FLDST',
																   'Real-time PCR SLDST','Gene-Xpert FLDST','Gene-Xpert SLDST')
					and c.froms=h.off_name1 and h.off_id='$user_name'
				order by dst.anal_method, dst.drug 	");

				$sql_appr =mysql_query("select appr.* from approve appr, culture c, hospcode h 
					where appr.fname=c.fname and appr.cul_no=c.cul_no 
						and appr.fname='$ptt_name' and appr.cul_no='$cul_no'
						and c.froms=h.off_name1 and h.off_id='$user_name'	");
			}

		}else{	//+++	ถ้า ไม่มีการสืบค้น ให้แสดงข้อมูลของการสืบค้น DST, Molecular, Approve ทั้งหมดของเดือนปัจจุบัน
		
			if ($count_char >5)	{	//+++	แสดงข้อมูลผลการตรวจทั้งหมด
				$sql_iden =mysql_query("select i.* from identification i,culture c
				where i.fname=c.fname and i.cul_no=c.cul_no and i.fname='$ptt_name' 
					and i.cul_no='$cul_no'	order by i.fname desc, i.cul_no desc 	");

				$sql_dst =mysql_query("select dst.* from dst,culture c
				where dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$ptt_name' 
					and dst.cul_no='$cul_no' and month(c.date_in)=$this_month 
					and dst.anal_method in('Solid-FLDST','Solid-SLDST','Liquid-FLDST MGIT',
																   'Liquid-FLDST MTT','Liquid-SLDST')
				order by dst.fname desc, dst.cul_no desc 	");

				$sql_mol =mysql_query("select dst.* from dst,culture c
				where dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$ptt_name' 
					and dst.cul_no='$cul_no' and month(c.date_in)=$this_month 
					and dst.anal_method in('LPA-FLDST','LPA-SLDST','Real-time PCR FLDST',
																   'Real-time PCR SLDST','Gene-Xpert FLDST','Gene-Xpert SLDST')
				order by dst.fname desc, dst.cul_no desc 	");

				$sql_appr =mysql_query("select * from approve where fname='$ptt_name' and cul_no='$cul_no'	");

			}else{	//+++	แสดงข้อมูลผลการตรวจเฉพาะรพ. ที่จนท.รพ.นั้นเข้าระบบ
				$sql_iden =mysql_query("select i.* from identification i, culture c, hospcode h
				where month(c.date_in)=$this_month and i.fname=c.fname and i.cul_no=c.cul_no and i.fname='$ptt_name' 
					and i.cul_no='$cul_no'	and c.froms=h.off_name1 and h.off_id='$user_name'
				order by i.fname, i.cul_no 	");

				$sql_dst =mysql_query("select dst.* from dst	,culture c, hospcode h
				where month(c.date_in)=$this_month and dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$ptt_name' 
					and dst.cul_no='$cul_no' and dst.anal_method in('Solid-FLDST','Solid-SLDST','Liquid-FLDST MGIT',
																   'Liquid-FLDST MTT','Liquid-SLDST')
					and c.froms=h.off_name1 and h.off_id='$user_name'
				order by dst.anal_method, dst.drug 	");

				$sql_mol =mysql_query("select dst.* from dst	,culture c, hospcode h
				where month(c.date_in)=$this_month and dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$ptt_name' 
					and dst.cul_no='$cul_no' and dst.anal_method in('LPA-FLDST','LPA-SLDST','Real-time PCR FLDST',
																   'Real-time PCR SLDST','Gene-Xpert FLDST','Gene-Xpert SLDST')
					and c.froms=h.off_name1 and h.off_id='$user_name'
				order by dst.anal_method, dst.drug 	");

				$sql_appr =mysql_query("select appr.* from approve appr, culture c, hospcode h 
					where appr.fname=c.fname and appr.cul_no=c.cul_no 
						and appr.fname='$ptt_name' and appr.cul_no='$cul_no'
						and c.froms=h.off_name1 and h.off_id='$user_name'	");
			}
		}

		if (isset($_GET["multisearch"]))	{
			$sql_iden =mysql_query("select i.* from identification i,culture c
			where i.fname=c.fname and i.cul_no=c.cul_no and i.fname='$ptt_name' 
				and i.cul_no='$cul_no'	order by i.fname desc, i.cul_no desc 	");

			$sql_dst =mysql_query("select dst.* from dst,culture c
			where dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$ptt_name' 
				and dst.cul_no='$cul_no' and dst.anal_method in('Solid-FLDST','Solid-SLDST','Liquid-FLDST MGIT',
				   'Liquid-FLDST MTT','Liquid-SLDST')
			order by dst.fname desc, dst.cul_no desc 	");

			$sql_mol =mysql_query("select dst.* from dst,culture c
			where dst.fname=c.fname and dst.cul_no=c.cul_no and dst.fname='$ptt_name' 
				and dst.cul_no='$cul_no' and dst.anal_method in('LPA-FLDST','LPA-SLDST','Real-time PCR FLDST',
				   'Real-time PCR SLDST','Gene-Xpert FLDST','Gene-Xpert SLDST')
			order by dst.fname desc, dst.cul_no desc 	");

			$sql_appr =mysql_query("select * from approve where fname='$ptt_name' and cul_no='$cul_no'	");
		}

			$rows_iden =mysql_num_rows($sql_iden);
			$show_iden =mysql_fetch_array($sql_iden);
				$iden_result =$show_iden["result"];

//			if ($result=="No Growth" or $result=="Not Done")	{	$iden_result ="Not Done";	}
			if ($result=="Waiting 4-8 weeks")	{	$iden_result =$show_iden["result"];	}
				
				if ($rows_iden<=0)	{
					$color ="#ccc";
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

/*				if ($identification=="1" and ($row_check_approve==0 or $approve_result==0))	{	
					print "	<td style='background-color:$color;'>
						<a href='./append_iden.php?ptt=$ptt_name&culno=$cul_no' target='_blank'>$iden_result	</a>
					</td>				";
				}else{

					if ($identification=="1" and $approve=="1")	{
						print "	<td style='background-color:$color;'>
							<a href='./append_iden.php?ptt=$ptt_name&culno=$cul_no' target='_blank'>$iden_result	</a>
						</td>				";
					}else{
						print "	<td style='background-color:$color;'>$iden_result			</td>				";
					}
				}
*/
				if ($identification=="1")	{	
					print "	<td style='background-color:$color;'>
						<a href='./append_iden.php?ptt=$ptt_name&culno=$cul_no' target='_blank'>$iden_result	</a>
					</td>				";
				}else{

					print "	<td style='background-color:$color;'>$iden_result			</td>				";
				}


			$rows_dst =mysql_num_rows($sql_dst);
			$show_dst =mysql_fetch_array($sql_dst);
				$dst_result =$show_dst["result"];		
					if ($dst_result=="Susceptible" or $dst_result=="Resistance")	{	$dst_result="Result";	}
				
				if ($rows_dst<=0)	{
					$color ="#ccc";
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

/*				if ($sensitivity=="1" and ($row_check_approve==0 or $approve_result==0))	{	
					print "	<td style='background-color:$color;'>
						<a href='./update_dst.php?dst&ptt=$ptt_name&culno=$cul_no' target='_blank'>$dst_result	</a>
					</td>				";
				}else{

					if ($sensitivity=="1" and $approve=="1")	{
						print "	<td style='background-color:$color;'>
							<a href='./update_dst.php?dst&ptt=$ptt_name&culno=$cul_no' target='_blank'>$dst_result	</a>
						</td>				";
					}else{
						print "	<td style='background-color:$color;'>$dst_result			</td>				";
					}
				}
*/
				if ($sensitivity=="1")	{	
					print "	<td style='background-color:$color;'>
						<a href='./update_dst.php?dst&ptt=$ptt_name&culno=$cul_no' target='_blank'>$dst_result	</a>
					</td>				";
				}else{

					print "	<td style='background-color:$color;'>$dst_result			</td>				";
				}


			$rows_mol =mysql_num_rows($sql_mol);
			$show_mol =mysql_fetch_array($sql_mol);
				$mol_result =$show_mol["anal_result"];

				if ($rows_mol<=0)	{
					$color ="#ccc";
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
						<a href='./update_mol.php?molecular&ptt=$ptt_name&culno=$cul_no' target='_blank'>$mol_result	</a>
					</td>				";
				}else{

					if ($molecular=="1" and $approve=="1")	{
						print "	<td style='background-color:$color;'>
							<a href='./update_mol.php?molecular&ptt=$ptt_name&culno=$cul_no' target='_blank'>$mol_result	</a>
						</td>				";
					}else{
						print "	<td style='background-color:$color;'>$mol_result		</td>				";
					}
				}
*/
				if ($molecular=="1")	{		
					print "	<td style='background-color:$color;'>
						<a href='./update_mol.php?molecular&ptt=$ptt_name&culno=$cul_no' target='_blank'>$mol_result	</a>
					</td>				";
				}else{

					print "	<td style='background-color:$color;'>$mol_result		</td>				";
				}

			$show_appr =mysql_fetch_array($sql_appr);
				$appr_result =$show_appr["result"];
				$note =$show_appr["note"];
				if ($appr_result=='1')	{
					print "	<td style='text-align:center;'><img src='./images/approve.png' title='$note'></td>				";
					print "<td style='text-align:center;'>
						<a href='report.php?pt_name=$ptt_name&cno=$cul_no' target='_blank'><img src='./images/eye.jpg'></a>
					</td>		</tr>";
				}else{

					if ($sample=='1')	{
						print "	<td style='text-align:center;'></td>				";
						print "<td style='text-align:center;'>
							<a href='report.php?pt_name=$ptt_name&cno=$cul_no' target='_blank'><img src='./images/eye.jpg'></a>
						</td>		</tr>";
					}else{
						print "	<td style='text-align:center;'></td>				";
						print "<td style='text-align:center;'>	</td>		</tr>";
					}
				}

			$i++;
		}
		
		print "</tbody></table></div>";
		print "<p>	<span class='label label-danger'>N/A , Invalid</span>
				<span style='background-color:#ff0; font-size:0.75em; padding:3px; font-weight:bold;'> Waiting , Waiting 4-8 weeks </span> &nbsp;
				<span class='label label-success'>ผลออก</span>
				<span style='background-color:#ccc; font-size:0.75em; padding:3px; font-weight:bold; color:#fff;'>&nbsp; Not Done , ยังไม่ได้ลงทะเบียน &nbsp;</span>
		</p>";
	}

?>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

<?PHP	mysql_close($tb_conn);	?>

</body>
</html>