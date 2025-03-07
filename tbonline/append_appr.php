<?PHP
//+++ ตรวจสอบการเข้าระบบ
if ( ! isset($_SESSION["approve"]) or $_SESSION["approve"] !="1")	{
	print "<script>
		alert('ท่านไม่ได้รับสิทธิ์ในการใช้งานหน้านี้ ..'); 
		window.location='./';
	</script>";

}else{
	include("./tblab_connector.php");
}

if ( isset($_POST["cul_no"]))	{
	$ptt_name =$_GET["appr"];
	$culno =$_POST["cul_no"];
	$note =$_POST["note"];
	$approve_date =(date("Y")	+543) . date("-m-d");
	$reporter =$_SESSION["user_name"];

	mysql_query("replace into approve(fname, cul_no, result, note, datereport, report_by)	
		values ('$ptt_name', '$culno', '1', '$note', '$approve_date', '$reporter')	");

	print "<script>	window.location='./append_appr.php?appr=$ptt_name';		</script>	";

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

	$profile_name =$_GET["appr"];
	print "		</div><!-- end panel-heading -->	
		<div class='panel-body' style='color:#2F70A8;'>
		<p style='font-size:1.25em; font-weight:bold; text-align:center;'>การลงผลการเพาะเชื้อวัณโรคทางห้องปฏิบัติการ</p>
		<p style='font-size:1em; font-weight:bold; '><a href='./append_data.php?select&fn=$profile_name'><img src='./images/undo.png'></a> &nbsp;&nbsp; 
			ชื่อ - สกุล ผู้ป่วย : <font color='#f00'>$profile_name</font> &nbsp;&nbsp; 		</p>
	";
	print "	<form class='form-horizontal' role='form' name='mol_form' method='post' action='./append_appr.php?appr=$profile_name'>	";
	print "	<div class='form-group'>
				<label for='cul_no' class='col-sm-3 control-label'>Culture no.</label>
				<div class='col-sm-9'>
				<select class='form-control' name='cul_no' required>
					<option selected value=''>โปรดระบุ ..</option>
	";
	$sql_culno =mysql_query("select date_in, cul_no from culture where fname='$profile_name' order by date_in desc, cul_no desc");
	while ($list_culno =mysql_fetch_array($sql_culno))	{
		$date_in =$list_culno["date_in"];
		$cul_no =$list_culno["cul_no"];

		print "<option value='$cul_no'>$date_in : $cul_no</option>";
	}

	print "		</select>	</div>
					</div>
	";
	print "	<div class='form-group'>
				<label for='note' class='col-sm-3 control-label'>หมายเหตุ : </label>
				<div class='col-sm-9'>
					<input type='text' class='form-control' name='note'>
				</div>
	</div>";
	print "	<div class='form-group'>
			<div class='col-sm-offset-3 col-sm-9'>
				<button type='submit' class='btn btn-primary'> Approve </button>
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