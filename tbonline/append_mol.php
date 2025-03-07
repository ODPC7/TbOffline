<?PHP
//+++ ตรวจสอบการเข้าระบบ
if ( ! isset($_SESSION["molecular"]) or $_SESSION["molecular"] !="1")	{
	print "<script>
		alert('ท่านไม่ได้รับสิทธิ์ในการใช้งานหน้านี้ ..'); 
		window.location='./';
	</script>";

}else{
	include("./tblab_connector.php");
}

if (isset($_GET["mol"]) and isset($_GET["culno"]) and isset($_GET["method"]))	{
	$ptt_name =$_GET["mol"];
	$culno =$_GET["culno"];
	$method =$_GET["method"];
	$m =$_GET["tt"];

	$anal_result =$_POST["anal_result"];
	$level_result =$_POST["level_result"];

	$testdate =(date("Y")	+543) . date("-m-d");
	$datereport =(date("Y")	+543) . date("-m-d");
	$reporter =$_SESSION["user_name"];

	for ($i=1; $i<=$m; $i++){
		$drug =$_POST["d$i"];
		$result =$_POST["r$i"];

		mysql_query("insert into dst(fname, cul_no, anal_method, anal_result, level_result, drug, result, test_date, datereport, report_by)
				values ('$ptt_name', '$culno', '$method', '$anal_result', '$level_result', '$drug', '$result', '$testdate', '$datereport', '$reporter')	");
	}

	print "<script>	window.location='./append_mol.php?mol=$ptt_name';		</script>	";

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
				TB-Online for ODPC 7 Khon Kaen ...	 <a href="./index.php?get=out"><img src="./images/signout.png"></a> 
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

	$profile_name =$_GET["mol"];
	print "		</div><!-- end panel-heading -->	
		<div class='panel-body' style='color:#2F70A8;'>
		<p style='font-size:1.25em; font-weight:bold; text-align:center;'>การลงผลการเพาะเชื้อวัณโรคทางห้องปฏิบัติการ</p>
		<p style='font-size:1em; font-weight:bold; '><a href='./append_data.php?select&fn=$profile_name'><img src='./images/undo.png'></a> &nbsp;&nbsp; 
			ชื่อ - สกุล ผู้ป่วย : <font color='#f00'>$profile_name</font> &nbsp;&nbsp; 		</p>
	";
		
	if (! isset($_POST["cul_no"]) and ! isset($_POST["anal_method"])){
		print "	<form class='form-horizontal' role='form' name='mol_form' method='post' action='./append_mol.php?mol=$profile_name'>	";
	}

	if (! isset($_POST["cul_no"]) and ! isset($_POST["anal_method"])){
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
	}

	if (! isset($_POST["cul_no"]) and ! isset($_POST["anal_method"])){
		print "	<div class='form-group'>
				<label for='method' class='col-sm-3 control-label'>Analysis Method</label>
				<div class='col-sm-9'>
					<select class='form-control' name='anal_method' required >
						<option selected value=''>โปรดระบุ ..</option>
		";
		$sql_method =mysql_query("select * from method where method_group='mol' order by num asc");
		while ($list_method =mysql_fetch_array($sql_method))	{
			$method =$list_method["method"];

			print "<option value='$method'>$method</option>";
		}

		print "				</select>
							</div>
						</div>
		";
	}

	if (! isset($_POST["cul_no"]) and ! isset($_POST["anal_method"])){
		print "	<div class='form-group'>
				<div class='col-sm-offset-3 col-sm-9'>
					<button type='submit' class='btn btn-primary'> ต่อไป </button>
				</div>
			</div>
		</form>
		";
	}

//+++	ช่วงเพิ่มตัวยาเข้าฐานตามวิธีการตรวจวิเคราะห์

	if (isset($_POST["cul_no"]) and isset($_POST["anal_method"])){
		$culno =$_POST["cul_no"];
		$method =$_POST["anal_method"];

		switch	($method){
			case "LPA-FLDST":
			case "Real-time PCR FLDST":
				$m=2;
				break;
			case "LPA-SLDST":
			case "Real-time PCR SLDST":
				$m=3;
				break;
			case "Gene-Xpert FLDST":
			case "Gene-Xpert SLDST":
				$m=1;
				break;
		}

		print "	<form class='form-horizontal' role='form' name='seledrug_form' method='post' 
			action='./append_mol.php?mol=$profile_name&culno=$culno&method=$method&tt=$m'>	";
		print "		<div class='form-group'>
				<label for='cul_no' class='col-sm-3 control-label'>Culture no.</label>
				<div class='col-sm-9'>
					<input type='text' class='form-control' name='cul_no' value='$culno' readonly>	
				</div>
			</div>
		";
		print "		<div class='form-group'>
			<label for='method' class='col-sm-3 control-label'>Analysis Method</label>
			<div class='col-sm-9'>
					<input type='text' class='form-control' name='anal_method' value='$method' readonly>	
				</div>
			</div>
		";
		print "		<div class='form-group'>
			<label for='anal_result' class='col-sm-3 control-label'>Analysis Result</label>
			<div class='col-sm-9'>
					<select class='form-control' name='anal_result' required>
						<option selected value=''>โปรดระบุ ..</option>
		";

		$sql_mol =mysql_query("select result from result	where result_group like '%std%' or result_group like '%mol%' order by num asc	");
		while ($list_mol =mysql_fetch_array($sql_mol))	{
			$result =$list_mol["result"];

			print "<option value='$result'>$result</option>";
		}

		print "	</select></div>			</div>	";
		print "		<div class='form-group'>
			<label for='level_result' class='col-sm-3 control-label'>Level Result</label>
			<div class='col-sm-9'>
					<select class='form-control' name='level_result'>
						<option selected value=''>เฉพาะวิธี Gene-Xpert ..</option>
		";

		$sql_level =mysql_query("select result from result	where result='Waiting' or result_group like '%level%' order by num asc	");
		while ($list_level =mysql_fetch_array($sql_level))	{
			$result =$list_level["result"];

			print "<option value='$result'>$result</option>";
		}

		print "	</select></div>			</div>	";

//+++	LPA-FLDST, Real-time PCR FLDST
		if ($method=="LPA-FLDST" or $method=="Real-time PCR FLDST")	{		
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d1' value='Isoniazid' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r1' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d1r1 =mysql_query("select result from result 
				where result_group like '%std%' or result_group like '%lpa%' or result_group like '%pcr%' order by num asc");
			while ($list_d1r1 =mysql_fetch_array($sql_d1r1))	{
				$result =$list_d1r1["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d2' value='Rifampicin' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r2' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d2r2 =mysql_query("select result from result 
				where result_group like '%std%' or result_group like '%lpa%' or result_group like '%pcr%' order by num asc");
			while ($list_d2r2 =mysql_fetch_array($sql_d2r2))	{
				$result =$list_d2r2["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		
		}
//+++	end		LPA-FLDST, Real-time PCR FLDST

//+++	LPA-SLDST, Real-time PCR SLDST
		if ($method=="LPA-SLDST" or $method=="Real-time PCR SLDST")	{		
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d1' value='Fluoroquinolone' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r1' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d1r1 =mysql_query("select result from result 
				where result_group like '%std%' or result_group like '%lpa%' or result_group like '%pcr%' order by num asc");
			while ($list_d1r1 =mysql_fetch_array($sql_d1r1))	{
				$result =$list_d1r1["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d2' value='AG/CP' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r2' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d2r2 =mysql_query("select result from result 
				where result_group like '%std%' or result_group like '%lpa%' or result_group like '%pcr%' order by num asc");
			while ($list_d2r2 =mysql_fetch_array($sql_d2r2))	{
				$result =$list_d2r2["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d3' value='Low-level kanamycin' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r3' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d3r3 =mysql_query("select result from result 
				where result_group like '%std%' or result_group like '%lpa%' or result_group like '%pcr%' order by num asc");
			while ($list_d3r3 =mysql_fetch_array($sql_d3r3))	{
				$result =$list_d3r3["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";
		}

//+++	end		LPA-SLDST, Real-time PCR SLDST

//+++	Gene-Xpert FLDST, Gene-Xpert SLDST
		if ($method=="Gene-Xpert FLDST" or $method=="Gene-Xpert SLDST")	{		
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d1' value='Rifampicin' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r1' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d1r1 =mysql_query("select result from result where result_group like '%xpert%' or result_group like '%std%' order by num asc");
			while ($list_d1r1 =mysql_fetch_array($sql_d1r1))	{
				$result =$list_d1r1["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";
		}

//+++	end		Gene-Xpert FLDST, Gene-Xpert SLDST


		print "	<div class='form-group'>
				<div class='col-sm-offset-3 col-sm-9'>
					<button type='submit' class='btn btn-primary'> บันทึก </button>
				</div>
			</div>
		</form>
		";

	}

//+++	จบ	ช่วงเพิ่มตัวยาเข้าฐานตามวิธีการตรวจวิเคราะห์

























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