<?PHP
	if (isset($_GET["exp_type"]) and $_GET["exp_type"]=="file")	{
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename=report2.xls');
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
<p><b>นิยาม : จำนวนตัวอย่างที่ส่งตรวจและได้ลงทะเบียน แยกตามโรงพยาบาลของแต่ละจังหวัด กับผลการทดสอบยาของแต่ละวิธีที่ตรวจทาง Molecular
	<br>N/A หมายถึง ไม่ได้ระบุมาในใบส่งตรวจ หรือไม่สามารถแปรผลได้
	<br>ตัวอย่างที่ได้ลงทะเบียน หมายถึง ลงทะเบียนตรวจในระบบ TB Online ของ สคร.7 จังหวัดขอนแก่น	</b>
	<br>(บางตัวอย่างที่ส่งตรวจแต่ยังไม่ได้ลงทะเบียน อาจเนื่องเพราะเจ้าหน้าที่ตรวจวิเคราะห์ยังไม่ได้ลงทะเบียน อาจทำให้ตัวเลขเปลี่ยนแปลงได้)</p>

<?PHP		include("../tblab_connector.php");
$start_date =$_GET["date1"];
$end_date =$_GET["date2"];

$sql_method =mysql_query("select distinct anal_method from dst 
	where datereport >='$start_date' and datereport<='$end_date' and 
		anal_method in('LPA-FLDST','LPA-SLDST','Real-time PCR FLDST',
										'Real-time PCR SLDST','Gene-Xpert FLDST','Gene-Xpert SLDST')
	order by anal_method");

print "<div class='table-responsive'>	<br>
	<table class='table table-hover' style='font-size:1em;'>";

while ($list_method =mysql_fetch_array($sql_method))	{
	$method =$list_method["anal_method"];

	$sql_result =mysql_query("select distinct result from dst 
		where datereport >='$start_date' and datereport<='$end_date' and 
			anal_method ='$method' order by result");
	$cols_result =mysql_num_rows($sql_result);
		$head =($cols_result+2);

	print "<thead>";
	print "<tr class='success'>";
	print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;' colspan='$head'>
		ผลการตรวจทาง Molecular วิธี <font color='#f00'><b>$method </b></font> ระหว่างวันที่ $start_date ถึงวันที่ $end_date</th>";
	print "</tr>";

	$sql_pv =mysql_query("select h.off_ssj from hospcode h,culture c, dst 
		where h.off_name1=c.froms and c.fname=dst.fname and c.cul_no=dst.cul_no
			and dst.datereport >='$start_date' and dst.datereport<='$end_date' and
			dst.anal_method='$method'
		group by h.off_ssj order by h.region_nhso,h.off_ssj");
	while ($list_pv =mysql_fetch_array($sql_pv))	{
		$_offssj =$list_pv["off_ssj"];

		print "<tr class='success'>";
		print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;'>สถานพยาบาล <br>จังหวัด $_offssj</th>";

		$sql_result =mysql_query("select distinct result from dst 
			where datereport >='$start_date' and datereport<='$end_date' and 
				anal_method ='$method' order by result");
		while ($list_result =mysql_fetch_array($sql_result))	{
			$mol_result =$list_result["result"];

			print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;'>$mol_result</th>";
		}

		print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;'>รวม</th>";
		print "</tr>
				";

		$sql_ofn1 =mysql_query("select distinct c.froms from hospcode h,culture c,dst
			where h.off_name1=c.froms and c.fname=dst.fname and c.cul_no=dst.cul_no
				and h.off_ssj='$_offssj' and dst.datereport >='$start_date' and dst.datereport<='$end_date'
				and dst.anal_method='$method'
		order by h.region_nhso,h.off_ssj,c.froms");
		while ($list_ofn1 =mysql_fetch_array($sql_ofn1))	{
			$ofn1 =$list_ofn1["froms"];

			print "<tr><td>$ofn1</td>		";

			$tt =0;
			$sql_result =mysql_query("select distinct result from dst 
				where datereport >='$start_date' and datereport<='$end_date' and 
					anal_method ='$method' order by result");
			while ($list_result =mysql_fetch_array($sql_result))	{
				$mol_result =$list_result["result"];

				$sql =mysql_query("select count(*)as count_rows from culture c, dst	
					where c.fname=dst.fname and c.cul_no=dst.cul_no and c.froms='$ofn1' and dst.anal_method='$method' and 
						dst.result='$mol_result' and dst.datereport>='$start_date' and dst.datereport<='$end_date'	");
				$show_rec =mysql_fetch_array($sql);
					$count_rows =$show_rec["count_rows"];

					print "<td style='text-align:center;'>$count_rows</td>";
					$tt =($tt+$count_rows);
			}

			print "<td style='text-align:center;'>$tt</td>";
		}

		print "</tr>";
	}

}

print "</table></div>";

mysql_close($tb_conn);

?>

<p><b>นิยาม : จำนวนตัวอย่างที่ส่งตรวจและได้ลงทะเบียน แยกตามโรงพยาบาลของแต่ละจังหวัด กับผลการทดสอบยาของแต่ละวิธีที่ตรวจทาง Molecular
	<br>N/A หมายถึง ไม่ได้ระบุมาในใบส่งตรวจ หรือไม่สามารถแปรผลได้
	<br>ตัวอย่างที่ได้ลงทะเบียน หมายถึง ลงทะเบียนตรวจในระบบ TB Online ของ สคร.7 จังหวัดขอนแก่น	</b>
	<br>(บางตัวอย่างที่ส่งตรวจแต่ยังไม่ได้ลงทะเบียน อาจเนื่องเพราะเจ้าหน้าที่ตรวจวิเคราะห์ยังไม่ได้ลงทะเบียน อาจทำให้ตัวเลขเปลี่ยนแปลงได้)</p>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

</body>
</html>