<?PHP
//+++ ตรวจสอบการเข้าระบบ
if ( ! isset($_SESSION["culture"]) or $_SESSION["culture"] !="1")	{
	print "<script>
		alert('ท่านไม่ได้รับสิทธิ์ในการใช้งานหน้านี้ ..'); 
		window.location='./';
	</script>";

}else{
	include("./tblab_connector.php");
}

if (isset($_GET["fn"])){
	$fn =$_GET["fn"];

	$sql="insert into culture(lsn, date_in, fname, froms, hn, specimen, pttype, afb, cul_no, method, result, datereport, report_by) 
		values(	";
	$lsn=$_POST["lsn"];		if ($lsn=="") {		$sql .="NULL";	}else{		$sql .="	'$lsn'	";	}
	$date_in=$_POST["date_in"];			$sql .="	,'$date_in'	";		
	$sql .="	,'$fn'	";		
	$froms=$_POST["froms"];			if ($froms=="") {		$sql .="	,'N/A'	";		}else{			$sql .="	,'$froms'	";		}
	$hn=$_POST["hn"];			if ($hn=="") {		$sql .="	,NULL";		}else{			$sql .="	,'$hn'	";		}
	$specimen=$_POST["specimen"];			if ($specimen=="") {		$sql .="	,'N/A'	";		}else{			$sql .="	,'$specimen'	";			}					
	$pttype=$_POST["pttype"];			if ($pttype=="") {		$sql .="	,'N/A'	";		}else{			$sql .="	,'$pttype'	";			}				
	$afb=$_POST["afb"];			if ($afb=="") {		$sql .="	,'N/A'	";		}else{			$sql .="	,'$afb'	";			}					
	$cul_no=$_POST["cul_no"];				$sql .="	,'$cul_no'	";		
	$method=$_POST["method"];			if ($method=="") {		$sql .="	,'N/A'	";		}else{			$sql .="	,'$method'	";			}					
	$result=$_POST["result"];			if ($result=="") {		$sql .="	,'N/A'	";		}else{			$sql .="	,'$result'	";			}					
	$datereport =(date('Y')+543) .date('-m-d');		$sql .="	,'$datereport'	";	
	$report_by=$_SESSION["user_name"];				$sql .="	,'$report_by')	";	

	if (mysql_query($sql))	{
		print "<script>		alert('บันทึกข้อมูล เรียบร้อย ..'); 		</script>";				
	}else{
		print "<script>		alert('บันทึกข้อมูล ไม่สำเร็จ กรุณาลองใหม่ หรือติดต่อผู้ดูแลระบบ ..'); 		</script>";				
	}

	print "<script>		window.location='./append_data.php?select&fn=$fn';	</script>";
}

if (isset($_GET["editdata"])){
	$pttname =$_GET["editdata"];	
	$cno =$_GET["cno"];

	$sql ="update culture set 	";

	$lsn =$_POST["lsn"];	if ($lsn=="")	{ $sql =$sql . "lsn=NULL";	}else{	 $sql =$sql . "	lsn='$lsn'	";		}
	$date_in =$_POST["date_in"];		 $sql =$sql . "	, date_in='$date_in'	";	
	$froms =$_POST["froms"];				 $sql =$sql . "	, froms='$froms'	";	
	$hn =$_POST["hn"];		if ($hn=="")	{	$sql =$sql . " , hn=NULL	";		}else{	$sql =$sql . " , hn='$hn'	";		}
	$specimen =$_POST["specimen"];		if ($specimen=="")	{	$sql =$sql . " , specimen='N/A'	";		}else{	$sql =$sql . " , specimen='$specimen'	";		}
	$pttype =$_POST["pttype"];		if ($pttype=="")	{	$sql =$sql . " , pttype='N/A'	";		}else{	$sql =$sql . " , pttype='$pttype'	";		}
	$afb =$_POST["afb"];		if ($afb=="")	{	$sql =$sql . " , afb=NULL	";		}else{	$sql =$sql . " , afb='$afb'	";		}
	$method =$_POST["method"];		if ($method=="")	{	$sql =$sql . " , method='N/A'	";		}else{	$sql =$sql . " , method='$method'	";		}
	$result =$_POST["result"];		if ($result=="")	{	$sql =$sql . " , result=NULL	";		}else{	$sql =$sql . " , result='$result'	";		}
		if ($result=='No Growth' or $result=='Not Done' or $result=='Contaminated')	{
			$drp =(date('Y')+543) .date('-m-d');
			$rby =$_SESSION["user_name"];
			mysql_query("replace into identification(fname, cul_no, result, datereport, report_by) 
				value('$pttname', '$cno', 'Not Done','$drp', '$rby')	");
		}

	$datereport =(date('Y')+543) .date('-m-d');		$sql=$sql . " , datereport='$datereport'	";
	$report_by =$_SESSION["user_name"];		$sql=$sql . " , report_by='$report_by'	";

	$sql =$sql . "where fname='$pttname' and cul_no='$cno'	";

	if (mysql_query($sql))	{
		print "<script>		alert('บันทึกข้อมูล เรียบร้อย ..'); 		</script>";				
	}else{
		print "<script>		alert('บันทึกข้อมูล ไม่สำเร็จ กรุณาลองใหม่ หรือติดต่อผู้ดูแลระบบ ..'); 		</script>";				
	}

	print "<script>		window.location='./append_data.php?pt_name=$pttname&cno=$cno';	</script>";
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

	if (isset($_GET["cul"]))	{
		$profile_name =$_GET["cul"];
	}

	if (isset($_GET["culture"]))	{
		$profile_name =$_GET["ptt"];
		$culno =$_GET["culno"];

		$sql_cul =mysql_query("select * from culture where fname='$profile_name' and cul_no='$culno'	");
		$row_cul =mysql_fetch_array($sql_cul);
			$_lsn =$row_cul["lsn"];
			$_datein =$row_cul["date_in"];
			$_froms =$row_cul["froms"];
			$_hn =$row_cul["hn"];
			$_specimen =$row_cul["specimen"];
			$pt_type =$row_cul["pttype"];
			$afb =$row_cul["afb"];
			$method =$row_cul["method"];
			$result =$row_cul["result"];
	}

	print "		</div><!-- end panel-heading -->
		<div class='panel-body' style='color:#2F70A8;'>
		<p style='font-size:1.25em; font-weight:bold; text-align:center;'>การลงผลการเพาะเชื้อวัณโรคทางห้องปฏิบัติการ</p>
	";

	if (isset($_GET["culture"]))	{
		print "	<p style='font-size:1em; font-weight:bold; '><a href='./append_data.php?pt_name=$profile_name&cno=$culno'><img src='./images/undo.png'></a> &nbsp;&nbsp; 
				ชื่อ - สกุล ผู้ป่วย : <font color='#f00'>$profile_name</font> &nbsp;&nbsp; Culture No. : <font color='#f00'>$culno</font>
			</p>
		";
	}else{
		print "	<p style='font-size:1em; font-weight:bold; '><a href='./append_data.php?select&fn=$profile_name'><img src='./images/undo.png'></a> &nbsp;&nbsp; 
				ชื่อ - สกุล ผู้ป่วย : <font color='#f00'>$profile_name</font> &nbsp;&nbsp; 
			</p>
		";
	}

	if (isset($_GET["culture"]))	{
		print "<form class='form-horizontal' role='form' name='editcul_form' method='post' action='./append_cul.php?editdata=$profile_name&cno=$culno'>	";
	}else{
		print "<form class='form-horizontal' role='form' name='cul_form' method='post' action='./append_cul.php?fn=$profile_name'>	";
	}
	
	if (isset($_GET["culture"]))	{
		print "	<div class='form-group'>
				<label for='lsn' class='col-sm-3 control-label'>LSN</label>
				<div class='col-sm-9'>
					<input type='text' class='form-control' name='lsn' value='$_lsn' autofocus>	
				</div>
			</div>
		";
	}else{
		print "	<div class='form-group'>
				<label for='lsn' class='col-sm-3 control-label'>LSN</label>
				<div class='col-sm-9'>
					<input type='text' class='form-control' name='lsn' autofocus>	
				</div>
			</div>
		";
	}

	if (isset($_GET["culture"]))	{
		print "	<div class='form-group'>
				<label for='date_in' class='col-sm-3 control-label'>วันที่รับตัวอย่าง (ปีพ.ศ.-เดือน-วัน)</label>
				<div class='col-sm-9'>
					<input type='text' class='form-control' name='date_in' value='$_datein' required>	
				</div>
			</div>
		";
	}else{
		print "	<div class='form-group'>
				<label for='date_in' class='col-sm-3 control-label'>วันที่รับตัวอย่าง (ปีพ.ศ.-เดือน-วัน)</label>
				<div class='col-sm-9'>
					<input type='text' class='form-control' name='date_in' placeholder='* * * โปรดระบุ * * *' required>	
				</div>
			</div>
		";
	}

	if (isset($_GET["culture"]))	{
		print "	<div class='form-group'>
				<label for='froms' class='col-sm-3 control-label'>สถานที่ส่งตรวจ</label>
				<div class='col-sm-9'>
					<select class='form-control' name='froms'>
		";
		$sql_froms =mysql_query("select off_name1,off_name2 from hospcode order by off_name1");
		while ($list_hosp =mysql_fetch_array($sql_froms))	{
			$offname1 =$list_hosp["off_name1"];
			$offname2 =$list_hosp["off_name2"];

			if ($_froms==$offname1)	{
				print "<option selected value='$offname1'>$offname1 $offname2</option>";
			}else{
				print "<option value='$offname1'>$offname1 $offname2</option>";
			}
		}
		print "		</select>	</div>		</div>	";

	}else{
		print "	<div class='form-group'>
				<label for='froms' class='col-sm-3 control-label'>สถานที่ส่งตรวจ</label>
				<div class='col-sm-9'>
					<select class='form-control' name='froms'>
						<option selected value='N/A'>ไม่ได้ระบุมา</option>
		";
		$sql_froms =mysql_query("select off_name1,off_name2 from hospcode order by off_name1");
		while ($list_hosp =mysql_fetch_array($sql_froms))	{
			$offname1 =$list_hosp["off_name1"];
			$offname2 =$list_hosp["off_name2"];

			print "<option value='$offname1'>$offname1 $offname2</option>";
		}
		print "		</select>	</div>		</div>	";

	}

	if (isset($_GET["culture"]))	{
		print "	<div class='form-group'>
				<label for='hn' class='col-sm-3 control-label'>HN</label>
				<div class='col-sm-9'>
					<input type='text' class='form-control' name='hn' value='$_hn'>	
				</div>
			</div>
		";
	}else{
		print "	<div class='form-group'>
				<label for='hn' class='col-sm-3 control-label'>HN</label>
				<div class='col-sm-9'>
					<input type='text' class='form-control' name='hn'>	
				</div>
			</div>
		";
	}

	if (isset($_GET["culture"]))	{
		print "	<div class='form-group'>
				<label for='specimen' class='col-sm-3 control-label'>Specimen type</label>
				<div class='col-sm-9'>
					<select class='form-control' name='specimen'>
						<option selected value=''>ไม่ได้ระบุมา</option>
		";

		$sql_specimen =mysql_query("select * from specimen");
		while ($list_specimen =mysql_fetch_array($sql_specimen))	{
			$spec =$list_specimen["specimen"];
			$thai_sp =$list_specimen["thai_sp"];

			if ($_specimen==$spec){
				print "<option selected value='$spec'>$spec : $thai_sp</option>";
			}else{
				print "<option value='$spec'>$spec : $thai_sp</option>";
			}
		}

		print "				</select>		</div>	</div>	";

	}else{
		print "	<div class='form-group'>
				<label for='specimen' class='col-sm-3 control-label'>Specimen type</label>
				<div class='col-sm-9'>
					<select class='form-control' name='specimen'>
						<option value=''>ชนิดของตัวอย่างส่งตรวจ</option>
		";

		$sql_specimen =mysql_query("select * from specimen");
		while ($list_specimen =mysql_fetch_array($sql_specimen))	{
			$spec =$list_specimen["specimen"];
			$thai_sp =$list_specimen["thai_sp"];

			print "<option value='$spec'>$spec : $thai_sp</option>";
		}

		print "				</select>		</div>	</div>	";

	}

	if (isset($_GET["culture"]))	{
		print "	<div class='form-group'>
				<label for='pttype' class='col-sm-3 control-label'>ประเภทผู้ป่วย</label>
				<div class='col-sm-9'>
					<select class='form-control' name='pttype'>
						<option selected value='N/A'>ไม่ได้ระบุมา</option>
		";
		$sql_pttype =mysql_query("select * from pttype order by num	");
		while ($list_pttype =mysql_fetch_array($sql_pttype))	{
			$_pttype =$list_pttype["pttype"];

			if ($pt_type==$_pttype)	{
				print "<option selected value='$_pttype'>$_pttype</option>";
			}else{
				print "<option value='$_pttype'>$_pttype</option>";
			}
		}
		print "				</select>	</div>	</div>	";

	}else{
		print "	<div class='form-group'>
				<label for='pttype' class='col-sm-3 control-label'>ประเภทผู้ป่วย</label>
				<div class='col-sm-9'>
					<select class='form-control' name='pttype'>
						<option selected value='N/A'>ไม่ได้ระบุมา</option>
		";
		$sql_pttype =mysql_query("select * from pttype order by num	");
		while ($list_pttype =mysql_fetch_array($sql_pttype))	{
			$_pttype =$list_pttype["pttype"];

			print "<option value='$_pttype'>$_pttype</option>";
		}
		print "				</select>	</div>	</div>	";

	}

	if (isset($_GET["culture"]))	{
		print "	<div class='form-group'>
				<label for='afb' class='col-sm-3 control-label'>AFB Result</label>
					<div class='col-sm-9'>
					<select class='form-control' name='afb'>
						<option selected value='N/A'>ไม่ได้ระบุมา</option>
		";
		$sql_afb =mysql_query("select * from result where result_group='std' or result_group='afb' order by num");
		while ($list_afb =mysql_fetch_array($sql_afb))	{
			$_afb =$list_afb["result"];

			if ($afb==$_afb)	{
				print "<option selected value='$_afb'>$_afb</option>";
			}else{
				print "<option value='$_afb'>$_afb</option>";
			}
		}
		print "				</select>	</div>	</div>	";

	}else{
		print "	<div class='form-group'>
				<label for='afb' class='col-sm-3 control-label'>AFB Result</label>
					<div class='col-sm-9'>
					<select class='form-control' name='afb'>
						<option selected value='N/A'>ไม่ได้ระบุมา</option>
		";
		$sql_afb =mysql_query("select * from result where result_group='std' or result_group='afb' order by num");
		while ($list_afb =mysql_fetch_array($sql_afb))	{
			$_afb =$list_afb["result"];

			print "<option value='$_afb'>$_afb</option>";
		}
		print "				</select>	</div>	</div>	";

	}

	if (! isset($_GET["culture"]))	{
		print "	<div class='form-group'>
					<label for='cul_no' class='col-sm-3 control-label'>Culture no.</label>
					<div class='col-sm-9'>
						<input type='text' class='form-control' name='cul_no' placeholder='* * * โปรดระบุ * * *' required>	
					</div>
			</div>
		";
	}

	if ( isset($_GET["culture"]))	{
		print "		<div class='form-group'>
			<label for='method' class='col-sm-3 control-label'>วิธีการเพาะเชื้อ</label>
			<div class='col-sm-9'>
				<select class='form-control' name='method'>
					<option selected value=''>*** วิธีเพาะเชื้อ ***</option>
		";
		$sql_method =mysql_query("select * from method where method_group ='cul' order by num");
		while ($list_method =mysql_fetch_array($sql_method))	{
			$_method =$list_method["method"];

			if ($method==$_method)	{
				print "<option selected value='$_method'>$_method</option>";
			}else{
				print "<option value='$_method'>$_method</option>";
			}
		}
		print "				</select>	</div>	</div>	";

	}else{
		print "		<div class='form-group'>
			<label for='method' class='col-sm-3 control-label'>วิธีการเพาะเชื้อ</label>
			<div class='col-sm-9'>
				<select class='form-control' name='method'>
					<option value=''>*** วิธีเพาะเชื้อ ***</option>
		";
		$sql_method =mysql_query("select * from method where method_group ='cul' order by num");
		while ($list_method =mysql_fetch_array($sql_method))	{
			$_method =$list_method["method"];

			print "<option value='$_method'>$_method</option>";
		}
		print "				</select>	</div>	</div>	";
	}

	if ( isset($_GET["culture"]))	{
		print "		<div class='form-group'>
			<label for='result' class='col-sm-3 control-label'>ผลการเพาะเชื้อ</label>
			<div class='col-sm-9'>
				<select class='form-control' name='result'>
		";
		$sql_result =mysql_query("select * from result where result_group like '%std%' or result_group like '%culture%' order by num");
		while ($list_result =mysql_fetch_array($sql_result))	{
			$_result =$list_result["result"];

			if ($result==$_result)	{
				print "<option selected value='$_result'>$_result</option>";
			}else{
				print "<option value='$_result'>$_result</option>";
			}
		}
		print "				</select>	</div>	</div>	";

	}else{
		print "		<div class='form-group'>
			<label for='result' class='col-sm-3 control-label'>ผลการเพาะเชื้อ</label>
			<div class='col-sm-9'>
				<select class='form-control' name='result'>
		";
		$sql_result =mysql_query("select * from result where result_group like '%std%' or result_group like '%culture%' order by num");
		while ($list_result =mysql_fetch_array($sql_result))	{
			$_result =$list_result["result"];

			print "<option value='$_result'>$_result</option>";
		}
		print "				</select>	</div>	</div>	";
	}

	print "	<div class='form-group'>
			<div class='col-sm-offset-3 col-sm-9'>
				<button type='submit' class='btn btn-primary'> บันทึก </button>
			</div>
		</div>
	</form>
	";


















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