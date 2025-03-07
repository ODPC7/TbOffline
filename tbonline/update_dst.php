<?PHP
//+++ ตรวจสอบการเข้าระบบ
if ( ! isset($_SESSION["user_name"]))	{
	print "<script>
		alert('ท่านไม่ได้รับสิทธิ์ในการใช้งานหน้านี้ ..'); 
		window.location='./';
	</script>";

}else{
	include("./tblab_connector.php");
}


if (isset($_GET["ptt"]) and isset($_GET["culno"]) and isset($_GET["method"]))	{
	$ptt_name =$_GET["ptt"];
	$culno =$_GET["culno"];
	$method =$_GET["method"];
	$m =$_GET["tt"];

	$datereport =(date("Y")	+543) . date("-m-d");
	$reporter =$_SESSION["user_name"];

	for ($i=1; $i<=$m; $i++){
		$drug =$_POST["d$i"];
		$result =$_POST["r$i"];

		mysql_query("update dst set result='$result', datereport='$datereport', report_by='$reporter' 
			where fname='$ptt_name' and cul_no='$culno' and anal_method='$method' and drug='$drug'	");
	}

	print "<script>	window.location='./append_data.php?pt_name=$ptt_name&cno=$culno';		</script>	";

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

	$profile_name =$_GET["ptt"];
	$culno =$_GET["culno"];

	print "		</div><!-- end panel-heading -->	
		<div class='panel-body' style='color:#2F70A8;'>
		<p style='font-size:1.25em; font-weight:bold; text-align:center;'>การลงผลการเพาะเชื้อวัณโรคทางห้องปฏิบัติการ</p>
		<p style='font-size:1em; font-weight:bold; '><a href='./append_data.php?pt_name=$profile_name&cno=$culno'>
			<img src='./images/undo.png'></a> &nbsp;&nbsp; 
			ชื่อ - สกุล ผู้ป่วย : <font color='#f00'>$profile_name</font>  &nbsp;&nbsp; Culture No. : <font color='#f00'>$culno</font> 		</p>
	";

	if (! isset($_POST["anal_method"]))	{
		print "	<form class='form-horizontal' role='form' name='updatedst_form' method='post' 
			action='./update_dst.php?dst&ptt=$profile_name&culno=$culno'>	";

		print "	<div class='form-group'>
				<label for='method' class='col-sm-3 control-label'>Analysis Method</label>
				<div class='col-sm-9'>
					<select class='form-control' name='anal_method' required >
						<option selected value=''>โปรดระบุ ..</option>
		";
		$sql_method =mysql_query("select distinct anal_method from dst 
			where fname='$profile_name' and cul_no='$culno' and anal_method in('Solid-FLDST','Solid-SLDST','Liquid-FLDST MGIT',
				   'Liquid-FLDST MTT','Liquid-SLDST')
			order by anal_method asc");
		while ($list_method =mysql_fetch_array($sql_method))	{
			$method =$list_method["anal_method"];

			print "<option value='$method'>$method</option>";
		}

		print "				</select>
							</div>
						</div>
		";
		print "	<div class='form-group'>
				<div class='col-sm-offset-3 col-sm-9'>
					<button type='submit' class='btn btn-primary'> ต่อไป </button>
				</div>
			</div>
		</form>
		";
		
	}else{
		$method =$_POST["anal_method"];
		switch	($method){
			case "Solid-FLDST":
			case "Liquid-FLDST MGIT":
				$m=5;
				break;
			case "Solid-SLDST":
			case "Liquid-FLDST MTT":
				$m=7;
				break;
			case "Liquid-SLDST":
				$m=8;
				break;
		}

		print "	<form class='form-horizontal' role='form' name='seledrug_form' method='post' 
			action='./update_dst.php?dst&ptt=$profile_name&culno=$culno&method=$method&tt=$m'>	";
		print "		<div class='form-group'>
			<label for='method' class='col-sm-3 control-label'>Analysis Method</label>
			<div class='col-sm-9'>
					<input type='text' class='form-control' name='anal_method' value='$method' readonly>	
				</div>
			</div>
		";

//+++	Solid-FLDST
		if ($method=="Solid-FLDST")	{		
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d1' value='Streptomycin 4.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r1' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d1r1 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d1r1 =mysql_fetch_array($sql_d1r1))	{
				$result =$list_d1r1["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d2' value='Isoniazid 0.2' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r2' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d2r2 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d2r2 =mysql_fetch_array($sql_d2r2))	{
				$result =$list_d2r2["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";
		
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d3' value='Isoniazid 1.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r3' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d3r3 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d3r3 =mysql_fetch_array($sql_d3r3))	{
				$result =$list_d3r3["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";
		
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d4' value='Rifampicin 40.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r4' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d4r4 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d4r4 =mysql_fetch_array($sql_d4r4))	{
				$result =$list_d4r4["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";
		
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d5' value='Ethambutol 2.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r5' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d5r5 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d5r5 =mysql_fetch_array($sql_d5r5))	{
				$result =$list_d5r5["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		
		}
//+++	end		Solid-FLDST

//+++	Solid-SLDST
		if ($method=="Solid-SLDST")	{
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d1' value='Ofloxazcin 2.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r1' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d1r1 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d1r1 =mysql_fetch_array($sql_d1r1))	{
				$result =$list_d1r1["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d2' value='Kanamycin 30.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r2' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d2r2 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d2r2 =mysql_fetch_array($sql_d2r2))	{
				$result =$list_d2r2["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d3' value='Levofloxacin 2.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r3' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d3r3 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d3r3 =mysql_fetch_array($sql_d3r3))	{
				$result =$list_d3r3["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d4' value='Cycloserine 40.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r4' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d4r4 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d4r4 =mysql_fetch_array($sql_d4r4))	{
				$result =$list_d4r4["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d5' value='Ethionamide 40.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r5' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d5r5 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d5r5 =mysql_fetch_array($sql_d5r5))	{
				$result =$list_d5r5["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d6' value='PAS 0.5' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r6' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d6r6 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d6r6 =mysql_fetch_array($sql_d6r6))	{
				$result =$list_d6r6["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d7' value='Capreomycin 40.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r7' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d7r7 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d7r7 =mysql_fetch_array($sql_d7r7))	{
				$result =$list_d7r7["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		
		}

//+++	end		Solid-SLDST

//+++	Liquid-FLDST MGIT
		if ($method=="Liquid-FLDST MGIT")	{
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d1' value='Streptomycin 1.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r1' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d1r1 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d1r1 =mysql_fetch_array($sql_d1r1))	{
				$result =$list_d1r1["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d2' value='Isoniazid 0.1' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r2' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d2r2 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d2r2 =mysql_fetch_array($sql_d2r2))	{
				$result =$list_d2r2["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d3' value='Rifampicin 1.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r3' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d3r3 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d3r3 =mysql_fetch_array($sql_d3r3))	{
				$result =$list_d3r3["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d4' value='Ethambutol 5.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r4' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d4r4 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d4r4 =mysql_fetch_array($sql_d4r4))	{
				$result =$list_d4r4["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d5' value='Pyrazinamide 100.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r5' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d5r5 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d5r5 =mysql_fetch_array($sql_d5r5))	{
				$result =$list_d5r5["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		
		}

//+++	end		Liquid-FLDST MGIT

//+++	Liquid-FLDST MTT
		if ($method=="Liquid-FLDST MTT")	{
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d1' value='Streptomycin 2.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r1' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d1r1 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d1r1 =mysql_fetch_array($sql_d1r1))	{
				$result =$list_d1r1["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d2' value='Streptomycin 10.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r2' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d2r2 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d2r2 =mysql_fetch_array($sql_d2r2))	{
				$result =$list_d2r2["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d3' value='Isoniazid 0.2' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r3' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d3r3 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d3r3 =mysql_fetch_array($sql_d3r3))	{
				$result =$list_d3r3["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d4' value='Isoniazid 1.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r4' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d4r4 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d4r4 =mysql_fetch_array($sql_d4r4))	{
				$result =$list_d4r4["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d5' value='Rifampicin 1.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r5' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d5r5 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d5r5 =mysql_fetch_array($sql_d5r5))	{
				$result =$list_d5r5["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d6' value='Ethambutol 5.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r6' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d6r6 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d6r6 =mysql_fetch_array($sql_d6r6))	{
				$result =$list_d6r6["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d7' value='Ethambutol 10.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r7' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d7r7 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d7r7 =mysql_fetch_array($sql_d7r7))	{
				$result =$list_d7r7["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		
		}

//+++	end		Liquid-FLDST MTT

//+++	Liquid-SLDST
		if ($method=="Liquid-SLDST")	{
			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d1' value='Ofloxazcin 2.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r1' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d1r1 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d1r1 =mysql_fetch_array($sql_d1r1))	{
				$result =$list_d1r1["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d2' value='Kanamycin' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r2' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d2r2 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d2r2 =mysql_fetch_array($sql_d2r2))	{
				$result =$list_d2r2["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d3' value='Levofloxacin 2.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r3' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d3r3 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d3r3 =mysql_fetch_array($sql_d3r3))	{
				$result =$list_d3r3["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d4' value='Cycloserine' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r4' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d4r4 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d4r4 =mysql_fetch_array($sql_d4r4))	{
				$result =$list_d4r4["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d5' value='Ethionamide 5.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r5' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d5r5 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d5r5 =mysql_fetch_array($sql_d5r5))	{
				$result =$list_d5r5["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d6' value='PAS' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r6' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d6r6 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d6r6 =mysql_fetch_array($sql_d6r6))	{
				$result =$list_d6r6["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d7' value='Capreomycin 2.5' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r7' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d7r7 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d7r7 =mysql_fetch_array($sql_d7r7))	{
				$result =$list_d7r7["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		

			print "<div class='form-group'>
				<div class='col-sm-6'>
					<input type='text' class='form-control' name='d8' value='Amikacin 1.0' readonly>	
				</div>
				<div class='col-sm-6'>
					<select class='form-control' name='r8' required >
						<option selected value=''>โปรดระบุ ..</option>
			";

			$sql_d8r8 =mysql_query("select result from result where result_group like '%dst%' or result_group like '%std%' order by num asc");
			while ($list_d8r8 =mysql_fetch_array($sql_d8r8))	{
				$result =$list_d8r8["result"];

				print "<option value='$result'>$result</option>";
			}

			print "	</select></div>			</div>	";		
		}

//+++	end		Liquid-SLDST

		print "	<div class='form-group'>
				<div class='col-sm-offset-3 col-sm-9'>
					<button type='submit' class='btn btn-primary'> บันทึก </button>
				</div>
			</div>
		</form>
		";
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