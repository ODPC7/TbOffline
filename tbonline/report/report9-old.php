<?PHP
	if (isset($_GET["exp_type"]) and $_GET["exp_type"]=="file")	{
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename=report1.xls');
		print "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">	";
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

<div class="container-fluid">	<!-- container-02 -->

<?PHP		include("../tblab_connector.php");
$start_date =$_GET["date1"];
$end_date =$_GET["date2"];

print "<p><b>นิยาม : จำนวนตัวอย่าง Turnaround Time ของการตรวจวิเคราะห์แต่ละวิธี
	<br>(บางตัวอย่างที่ส่งตรวจแต่ยังไม่ได้ลงทะเบียน อาจเนื่องเพราะเจ้าหน้าที่ตรวจวิเคราะห์ยังไม่ได้ลงทะเบียน อาจทำให้ตัวเลขเปลี่ยนแปลงได้)</p>
";

//+++	Solid Culture ++++++++++++++

$sql_cul =mysql_query("select distinct result from culture 
	where method='solid' and date_in>='$start_date' and date_in<='$end_date' order by result	");
$rows_cul =mysql_num_rows($sql_cul);
	$rows_cul =($rows_cul+1);

print "<div class='table-responsive'>	<br>
	<table class='table table-hover' style='font-size:0.8em;'>";
print "<thead>";
print "<tr class='success'>";
print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;' rowspan='2'>Turnaround Time <br> (Week)</th>";
print "<th style='text-align:center;color:#2F70A8;' colspan='$rows_cul'>ประเภทการตรวจวิเคราะห์ Solid Culture ตั้งแต่วันที่ $start_date ถึงวันที่ $end_date</th>";
print "</tr>";
print "<tr class='success'>";

while ($list_cul =mysql_fetch_array($sql_cul))	{
	$result =$list_cul["result"];

	print "<th style='text-align:center;color:#2F70A8;'>$result</th>";
}

print "<th style='text-align:center;color:#2F70A8;'>รวม</th>";
print "</tr></thead><tbody>";

//	หลักการคิดสัปดาห์(Week) : หาวันระหว่าง start_date-end_date ด้วย function datediff 
//	แล้วหาร 7 แล้วใช้ function ceiling เพื่อปัดเศษทศนิยมขึ้น  ตัวอย่างเช่น 0-7 วันคือ 1 สัปดาห์
//	7.1-14 คือ 2 สัปดาห์,  14.1-21 วัน คือ 3 สัปดาห์ ....

$sql_trt =mysql_query("SELECT distinct ceiling((datediff(datereport,date_in)/7))as trt FROM culture 
where method='solid' and date_in>='$start_date' and date_in<='$end_date' order by trt	");
while ($list_trt =mysql_fetch_array($sql_trt))	{
	$trt =$list_trt["trt"];

	print "<tr>";
	print "<td style='text-align:center;'>$trt</td>";

	$sql_cul =mysql_query("select distinct result from culture 
		where method='solid' and date_in>='$start_date' and date_in<='$end_date' order by result	");

	$tt_trt_am =0;
	while ($list_cul =mysql_fetch_array($sql_cul)){
		$result =$list_cul["result"];

		$sql_trt_mol =mysql_query("SELECT count(fname)as count_trt FROM culture where result='$result' and method='solid' 
			and date_in>='$start_date' and date_in<='$end_date' and (ceiling((datediff(datereport,date_in)/7)))=$trt ");
		$show_rec =mysql_fetch_array($sql_trt_mol);
			$count_trt =$show_rec["count_trt"];

		print "<td style='text-align:center;'>$count_trt</td>";

		$tt_trt_am =($tt_trt_am+$count_trt);
	}

	print "<td style='text-align:center;'>$tt_trt_am</td>";
	print "</tr>";
}

print "</tbody></table></div>";

//+++	จบ	Solid Culture ++++++++++++++

//+++	Liquid Culture ++++++++++++++

$sql_cul =mysql_query("select distinct result from culture 
	where method='Liquid' and date_in>='$start_date' and date_in<='$end_date' order by result	");
$rows_cul =mysql_num_rows($sql_cul);
	$rows_cul =($rows_cul+1);

print "<div class='table-responsive'>	<br>
	<table class='table table-hover' style='font-size:0.8em;'>";
print "<thead>";
print "<tr class='success'>";
print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;' rowspan='2'>Turnaround Time <br> (Week)</th>";
print "<th style='text-align:center;color:#2F70A8;' colspan='$rows_cul'>ประเภทการตรวจวิเคราะห์ Liquid Culture ตั้งแต่วันที่ $start_date ถึงวันที่ $end_date</th>";
print "</tr>";
print "<tr class='success'>";

while ($list_cul =mysql_fetch_array($sql_cul))	{
	$result =$list_cul["result"];

	print "<th style='text-align:center;color:#2F70A8;'>$result</th>";
}

print "<th style='text-align:center;color:#2F70A8;'>รวม</th>";
print "</tr></thead><tbody>";

$sql_trt =mysql_query("SELECT distinct ceiling((datediff(datereport,date_in)/7))as trt FROM culture 
where method='Liquid' and date_in>='$start_date' and date_in<='$end_date' order by trt	");
while ($list_trt =mysql_fetch_array($sql_trt))	{
	$trt =$list_trt["trt"];

	print "<tr>";
	print "<td style='text-align:center;'>$trt</td>";

	$sql_cul =mysql_query("select distinct result from culture 
		where method='Liquid' and date_in>='$start_date' and date_in<='$end_date' order by result	");

	$tt_trt_am =0;
	while ($list_cul =mysql_fetch_array($sql_cul)){
		$result =$list_cul["result"];

		$sql_trt_mol =mysql_query("SELECT count(fname)as count_trt FROM culture where result='$result' and method='Liquid' 
			and date_in>='$start_date' and date_in<='$end_date' and (ceiling((datediff(datereport,date_in)/7)))=$trt ");
		$show_rec =mysql_fetch_array($sql_trt_mol);
			$count_trt =$show_rec["count_trt"];

		print "<td style='text-align:center;'>$count_trt</td>";

		$tt_trt_am =($tt_trt_am+$count_trt);
	}

	print "<td style='text-align:center;'>$tt_trt_am</td>";
	print "</tr>";
}

print "</tbody></table></div>";

//+++	จบ	Liquid Culture ++++++++++++++

//+++	Identification ++++++++++++++

$sql_iden =mysql_query("select distinct i.result from culture c, identification i 
	where c.fname=i.fname and c.cul_no=i.cul_no and c.date_in>='$start_date' and c.date_in<='$end_date' order by i.result	");
$rows_iden =mysql_num_rows($sql_iden);
	$rows_iden =($rows_iden+1);

print "<div class='table-responsive'>	<br>
	<table class='table table-hover' style='font-size:0.8em;'>";
print "<thead>";
print "<tr class='success'>";
print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;' rowspan='2'>Turnaround Time <br> (Week)</th>";
print "<th style='text-align:center;color:#2F70A8;' colspan='$rows_iden'>ผล Identification ตั้งแต่วันที่ $start_date ถึงวันที่ $end_date</th>";
print "</tr>";
print "<tr class='success'>";

while ($list_iden =mysql_fetch_array($sql_iden))	{
	$result =$list_iden["result"];

	print "<th style='text-align:center;color:#2F70A8;'>$result</th>";
}

print "<th style='text-align:center;color:#2F70A8;'>รวม</th>";
print "</tr></thead><tbody>";

$sql_trt =mysql_query("SELECT distinct ceiling((datediff(i.datereport,c.date_in)/7))as trt 
FROM culture c, identification i 
where c.fname=i.fname and c.cul_no=i.cul_no and c.date_in>='$start_date' and c.date_in<='$end_date' order by trt	");
while ($list_trt =mysql_fetch_array($sql_trt))	{
	$trt =$list_trt["trt"];

	print "<tr>";
	print "<td style='text-align:center;'>$trt</td>";

	$sql_iden =mysql_query("select distinct i.result from culture c, identification i 
		where c.fname=i.fname and c.cul_no=i.cul_no and c.date_in>='$start_date' and c.date_in<='$end_date' order by i.result	");

	$tt_trt_am =0;
	while ($list_iden =mysql_fetch_array($sql_iden)){
		$result =$list_iden["result"];

		$sql_trt_mol =mysql_query("SELECT count(i.fname)as count_trt 
			FROM culture c, identification i
			where c.fname=i.fname and c.cul_no=i.cul_no and i.result='$result' 
				and c.date_in>='$start_date' and c.date_in<='$end_date' and (ceiling((datediff(i.datereport, c.date_in)/7)))=$trt ");
		$show_rec =mysql_fetch_array($sql_trt_mol);
			$count_trt =$show_rec["count_trt"];

		print "<td style='text-align:center;'>$count_trt</td>";

		$tt_trt_am =($tt_trt_am+$count_trt);
	}

	print "<td style='text-align:center;'>$tt_trt_am</td>";
	print "</tr>";
}

print "</tbody></table></div>";

//+++	จบ	Identification ++++++++++++++

/*
//+++	DST ++++++++++++++

$sql_mol =mysql_query("select distinct dst.anal_method from dst, culture c 
	where c.fname=dst.fname and c.cul_no=dst.cul_no and dst.anal_method in('Solid-FLDST', 'Solid-SLDST', 
	'Liquid-FLDST MGIT', 'Liquid-FLDST MTT', 'Liquid-SLDST') and c.date_in>='$start_date'  
	and c.date_in<='$end_date' order by dst.anal_method");
$rows_mol =mysql_num_rows($sql_mol);
	$rows_mol =($rows_mol+1);

print "<div class='table-responsive'>	<br>
	<table class='table table-hover' style='font-size:0.8em;'>";
print "<thead>";
print "<tr class='success'>";
print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;' rowspan='2'>Turnaround Time <br> (Week)</th>";
print "<th style='text-align:center;color:#2F70A8;' colspan='$rows_mol'>ประเภทการตรวจวิเคราะห์ DST ตั้งแต่วันที่ $start_date ถึงวันที่ $end_date</th>";
print "</tr>";
print "<tr class='success'>";

while ($list_mol =mysql_fetch_array($sql_mol))	{
	$method =$list_mol["anal_method"];

	print "<th style='text-align:center;color:#2F70A8;'>$method</th>";
}

print "<th style='text-align:center;color:#2F70A8;'>รวม</th>";
print "</tr></thead><tbody>";

$sql_trt =mysql_query("SELECT distinct datediff(dst.datereport,c.date_in)as trt FROM culture c,dst
	where c.fname=dst.fname and c.cul_no=dst.cul_no and dst.anal_method in('Solid-FLDST', 'Solid-SLDST',
	'Liquid-FLDST MGIT', 'Liquid-FLDST MTT', 'Liquid-SLDST')
	and c.date_in>='$start_date' and c.date_in<='$end_date' order by trt");
while ($list_trt =mysql_fetch_array($sql_trt))	{
	$trt =$list_trt["trt"];

	if ($trt>=1 and $trt<=7)	{
		$trt ="1 Week";
	}

	if ($trt>=8 and $trt<=14)	{
		$trt ="2 Week";
	}

	if ($trt>=15 and $trt<=21)	{
		$trt ="3 Week";
	}

	if ($trt>=22 and $trt<=28)	{
		$trt ="4 Week";
	}

	if ($trt>=29 and $trt<=35)	{
		$trt ="5 Week";
	}

	if ($trt>=36 and $trt<=42)	{
		$trt ="6 Week";
	}

	if ($trt>=43 and $trt<=49)	{
		$trt ="7 Week";
	}

	if ($trt>=50 and $trt<=56)	{
		$trt ="8 Week";
	}

	if ($trt >56)	{
		$trt ="มากกว่า 8 Week";
	}

	print "<tr>";
	print "<td style='text-align:center;'>$trt</td>";

	$sql_mol =mysql_query("select distinct dst.anal_method from dst, culture c 
		where c.fname=dst.fname and c.cul_no=dst.cul_no and dst.anal_method in('Solid-FLDST', 'Solid-SLDST', 
		'Liquid-FLDST MGIT', 'Liquid-FLDST MTT', 'Liquid-SLDST') and c.date_in>='$start_date'  
		and c.date_in<='$end_date' order by dst.anal_method");

	$tt_trt_am =0;
	while ($list_mol =mysql_fetch_array($sql_mol)){
		$am =$list_mol["anal_method"];

		$sql_trt_mol =mysql_query("SELECT count(dst.fname)as count_trt FROM culture c,dst 
			where c.fname=dst.fname and c.cul_no=dst.cul_no and dst.anal_method='$am' 
			and c.date_in>='$start_date' and c.date_in<='$end_date' and (datediff(dst.datereport,c.date_in)=$trt) ");
		$show_rec =mysql_fetch_array($sql_trt_mol);
			$count_trt =$show_rec["count_trt"];

		print "<td style='text-align:center;'>$count_trt</td>";

		$tt_trt_am =($tt_trt_am+$count_trt);
	}

	print "<td style='text-align:center;'>$tt_trt_am</td>";
	print "</tr>";
}

print "</tbody></table></div>";

//+++	จบ	DST ++++++++++++++
*/

//+++	Molecular ++++++++++++++

$sql_mol =mysql_query("select distinct dst.anal_method from dst, culture c 
	where c.fname=dst.fname and c.cul_no=dst.cul_no and dst.anal_method in('LPA-FLDST', 'LPA-SLDST',
	'Real-time PCR FLDST', 'Real-time PCR SLDST', 'Gene-Xpert FLDST', 'Gene-Xpert SLDST') 
	and c.date_in>='$start_date' and c.date_in<='$end_date' order by dst.anal_method");
$rows_mol =mysql_num_rows($sql_mol);
	$rows_mol =($rows_mol+1);

print "<div class='table-responsive'>	<br>
	<table class='table table-hover' style='font-size:0.8em;'>";
print "<thead>";
print "<tr class='success'>";
print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;' rowspan='2'>Turnaround Time <br> (Day)</th>";
print "<th style='text-align:center;color:#2F70A8;' colspan='$rows_mol'>ประเภทการตรวจวิเคราะห์ Molecular ตั้งแต่วันที่ $start_date ถึงวันที่ $end_date</th>";
print "</tr>";
print "<tr class='success'>";

while ($list_mol =mysql_fetch_array($sql_mol))	{
	$method =$list_mol["anal_method"];

	print "<th style='text-align:center;color:#2F70A8;'>$method</th>";
}

print "<th style='text-align:center;color:#2F70A8;'>รวม</th>";
print "</tr></thead><tbody>";

$sql_trt =mysql_query("SELECT distinct datediff(dst.datereport,c.date_in)as trt FROM culture c,dst
	where c.fname=dst.fname and c.cul_no=dst.cul_no and dst.anal_method in('LPA-FLDST', 'LPA-SLDST',
	'Real-time PCR FLDST', 'Real-time PCR SLDST', 'Gene-Xpert FLDST', 'Gene-Xpert SLDST')
	and c.date_in>='$start_date' and c.date_in<='$end_date' order by trt");

while ($list_trt =mysql_fetch_array($sql_trt))	{
	$trt =$list_trt["trt"];

	print "<tr>";
	print "<td style='text-align:center;'>$trt</td>";

	$sql_mol =mysql_query("select distinct dst.anal_method from dst, culture c 
		where c.fname=dst.fname and c.cul_no=dst.cul_no and dst.anal_method in('LPA-FLDST', 'LPA-SLDST',
		'Real-time PCR FLDST', 'Real-time PCR SLDST', 'Gene-Xpert FLDST', 'Gene-Xpert SLDST') 
		and c.date_in>='$start_date' and c.date_in<='$end_date' order by dst.anal_method");

	$tt_trt_am =0;
	while ($list_mol =mysql_fetch_array($sql_mol)){
		$am =$list_mol["anal_method"];

		$sql_trt_mol =mysql_query("SELECT count(dst.fname)as count_trt FROM culture c,dst 
			where c.fname=dst.fname and c.cul_no=dst.cul_no and dst.anal_method='$am' 
			and c.date_in>='$start_date' and c.date_in<='$end_date' and (datediff(dst.datereport,c.date_in)=$trt) ");
		$show_rec =mysql_fetch_array($sql_trt_mol);
			$count_trt =$show_rec["count_trt"];

		print "<td style='text-align:center;'>$count_trt</td>";

		$tt_trt_am =($tt_trt_am+$count_trt);
	}

	print "<td style='text-align:center;'>$tt_trt_am</td>";
	print "</tr>";
}

print "</tbody></table></div>";

//+++	จบ	Molecular ++++++++++++++












mysql_close($tb_conn);

?>

<p><b>นิยาม : จำนวนตัวอย่าง Turnaround Time ของการตรวจวิเคราะห์แต่ละวิธี
	<br>(บางตัวอย่างที่ส่งตรวจแต่ยังไม่ได้ลงทะเบียน อาจเนื่องเพราะเจ้าหน้าที่ตรวจวิเคราะห์ยังไม่ได้ลงทะเบียน อาจทำให้ตัวเลขเปลี่ยนแปลงได้)</p>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

</body>
</html>