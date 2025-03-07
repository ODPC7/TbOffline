<?PHP
	include("../tblab_connector.php");

if (isset($_POST["start_date"]) and isset($_POST["end_date"]) and 
	isset($_POST["report"]) and isset($_POST["export_type"]))	{

	$start_date =$_POST["start_date"];
	$end_date =$_POST["end_date"];
	$report =$_POST["report"];
	$export_type =$_POST["export_type"];

	if ($report=='1')	{
		print "<script>
			window.location='./report1.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
		</script>";

	}

	if ($report=='2')	{
		print "<script>
			window.location='./report2.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
		</script>";
	}

	if ($report=='3')	{
		print "<script>
			window.location='./report3.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
		</script>";
	}

	if ($report=='4')	{
		print "<script>
			window.location='./report4.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
		</script>";
	}

	if ($report=='5')	{
		print "<script>
			window.location='./report5.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
		</script>";
	}

	if ($report=='6')	{
		print "<script>
			window.location='./report6.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
		</script>";
	}

	if ($report=='7')	{
		print "<script>
			window.location='./report7.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
		</script>";
	}

	if ($report=='8')	{
		print "<script>
			window.location='./report8.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
		</script>";
	}

	if ($report=='9')	{
		print "<script>
			window.location='./report9.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
		</script>";
	}

	if ($report=='10')	{
		print "<script>
			window.location='./report10.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
		</script>";
	}

	if ($report=='11')	{
		print "<script>
			window.location='./report11.php?date1=$start_date&date2=$end_date&exp_type=$export_type' ;
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

	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/css_plugin.css">

</head>
<body>
<script src="../../js/jquery-3.2.1.js"></script>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/bootstrap_plugin.js"></script>

<div class="container-fluid"><!-- container-01 -->
	<div class='row' style='margin:10px 0 10px 0;'>
		<div class='col-xs-1, col-sm-1, col-md-1, col-lg-1'>
			<img src='../../images/mophlogo.png' class='img-responsive'>
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
				<a href="../"><img src="./../images/home.png" style="align:middle;"></a>
				ระบบรายงานสรุปการส่งตัวอย่างตรวจสอบเชื้อมัยโคแบคทีเรีย	 <a href="../index.php?get=out">&nbsp;&nbsp;&nbsp;<img src="../images/signout.png"></a> 
			</p>
			<br>

		</div><!-- end panel-heading -->
		<div class='panel-body' style='color:#2F70A8;'>	

		<form class='form-horizontal' role='form' name='report' method='post' action='./report.php'>

<?PHP
$space ='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	';

print "	<div class='form-group'>
		<label for='start_date' class='col-sm-3 control-label'>เริ่มวันที่ : </label>
		<div class='col-sm-9'>
			<input type='text' class='form-control' id='start_date' name='start_date' 
				placeholder='รูปแบบ : ปี พ.ศ.-เดือน-วัน' required autofocus autocomplete='off'>	
		</div>		</div>	";
print "	<div class='form-group'>
		<label for='end_date' class='col-sm-3 control-label'>ถึงวันที่ : </label>
		<div class='col-sm-9'>
			<input type='text' class='form-control' id='end_date' name='end_date' 
				placeholder='รูปแบบ : ปี พ.ศ.-เดือน-วัน' required autocomplete='off'>	
		</div>		</div>	";
print "	<div class='form-group'>
		<label for='report' class='col-sm-3 control-label'>รายงาน : </label>
		<div class='col-sm-9'>
			<select class='form-control' name='report' required>
				<option value=''>โปรดเลือก รูปแบบรายงาน ..</option>
				<option value='1'>1. จำนวนตัวอย่างแยกตามประเภทผู้ป่วยของแต่ละจังหวัด </option>
				<option value='2'>2. จำนวนตัวอย่างแยกตามประเภทผู้ป่วยของแต่ละโรงพยาบาล</option>
				<option value='3'>3. จำนวนตัวอย่างแยกตามประเภทการทดสอบของแต่ละจังหวัด</option>
				<option value='4'>4. จำนวนตัวอย่างแยกตามชนิดตัวอย่างส่งตรวจของแต่ละจังหวัด</option>
";

if (isset($_SESSION["culture"]) and $_SESSION["culture"]=="1")	{
	print "		<option value='5'>5. จำนวนตัวอย่างแยกตามประเภทผู้ป่วย และผลการเพาะเชื้อ</option>	";
}

if (isset($_SESSION["approve"]) and $_SESSION["approve"]=="1")	{
	print "		<option value='6'>6. จำนวนตัวอย่างแยกตามประเภทผู้ป่วย และผลการตรวจ Gene-Xpert FLDST</option>	";
	print "		<option value='7'>7. จำนวนตัวอย่างแยกตามประเภทผู้ป่วย และผลการตรวจ Real-time PCR FLDST</option>	";
	print "		<option value='8'>8. จำนวนตัวอย่างแยกตามประเภทผู้ป่วย และผลการตรวจ LPA-FLDST</option>	";
}

if (isset($_SESSION["culture"]) and $_SESSION["culture"]=="1")	{
	print "		<option value='9'>9. จำนวนตัวอย่าง Turnaround Time ของการตรวจวิเคราะห์แต่ละวิธี</option>	";
	print "		<option value='10'>10. รายงานผลการปฏิบัติงาน รายบุคคล</option>	";
}

if (isset($_SESSION["approve"]) and $_SESSION["approve"]=="1")	{
	print "		<option value='11'>11. รายงานจำนวนตัวอย่าง แยกตามโรงพยาบาลของแต่ละจังหวัด กับผลการทดสอบยาของแต่ละวิธีที่ตรวจทาง Molecular</option>	";
}

print "			</select>	</div>		</div>	";

if (isset($_SESSION["approve"]) and $_SESSION["approve"]=="1")	{
	print "	<div class='form-group'>
			<label for='report' class='col-sm-3 control-label'>การแสดงผล : </label>
			<div class='col-sm-9'>
				<input type='radio' name='export_type' value='screen' checked>	หน้าจอ	$space
				<input type='radio' name='export_type' value='file'>	MS Excel
			</div>		</div>	
	";
}else{
	print "	<div class='form-group' style='display:none;'>
			<label for='report' class='col-sm-3 control-label'>การแสดงผล : </label>
			<div class='col-sm-9'>
				<input type='radio' name='export_type' value='screen' checked>	หน้าจอ	$space
				<input type='radio' name='export_type' value='file'>	MS Excel
			</div>		</div>	
	";
}

print "	<div class='form-group'>
		<label for='report' class='col-sm-3 control-label'>ปุ่ม Ctrl + </label>
		<div class='col-sm-9'>
			<button type='submit' class='btn btn-primary'> ตกลง </button> = เปิดรายงานไปหน้าต่างใหม่ (ใช้ได้เฉพาะ Chrome Browser)
		</div>
	</div>
</form>
";
		
		
		
?>		
		</form>


		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

<?PHP	mysql_close($tb_conn);	?>

</body>
</html>