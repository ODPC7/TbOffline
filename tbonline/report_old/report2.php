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
<p><b>นิยาม : จำนวนตัวอย่างที่ส่งตรวจและได้ลงทะเบียน แยกตามประเภทผู้ป่วยตามโรงพยาบาลของแต่ละจังหวัด
	<br>N/A หมายถึง ไม่ได้ระบุมาในใบส่งตรวจ
	<br>ตัวอย่างที่ได้ลงทะเบียน หมายถึง ลงทะเบียนตรวจในระบบ TB Online ของ สคร.7 จังหวัดขอนแก่น	</b>
	<br>(บางตัวอย่างที่ส่งตรวจแต่ยังไม่ได้ลงทะเบียน อาจเนื่องเพราะเจ้าหน้าที่ตรวจวิเคราะห์ยังไม่ได้ลงทะเบียน อาจทำให้ตัวเลขเปลี่ยนแปลงได้)</p>

<?PHP		include("../tblab_connector.php");
$start_date =$_GET["date1"];
$end_date =$_GET["date2"];

$sql_pttype =mysql_query("select distinct pttype from culture
where date_in>='$start_date' and date_in<='$end_date' order by pttype");
$rows_pttype =mysql_num_rows($sql_pttype);
	$rows_pttype =($rows_pttype+1);
	$row_head =($rows_pttype+3);
	$row_footer =($rows_pttype+2);

print "<div class='table-responsive'>	<br>
	<table class='table table-hover' style='font-size:0.8em; border:1px solid #000;'>";

$i =1;	
$sql_province =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
while ($list_province =mysql_fetch_array($sql_province))	{
	$off_ssj =$list_province["off_ssj"];
	print "<thead>";
	print "<tr class='success'>";
	print "<th style='text-align:center;color:#2F70A8; vertical-align:middle; border:1px solid #000;' colspan='$row_head'>
		จังหวัด $off_ssj ตั้งแต่วันที่ $start_date ถึงวันที่ $end_date</th>";
	print "</tr>";
	print "</thead><tbody>";
	print "<tr class='success'>";
	print "<td style='text-align:center;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>ลำดับสะสม </td>";
	print "<td style='text-align:center;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>ลำดับ </td>";
	print "<td style='text-align:center;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>โรงพยาบาล </td>";

	$sql_pttype =mysql_query("select distinct pttype from culture
	where date_in>='$start_date' and date_in<='$end_date' order by pttype");
	while ($list_pttype =mysql_fetch_array($sql_pttype))	{
		$pttype =$list_pttype["pttype"];
		print "<td style='text-align:center;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>$pttype </td>";
	}

	print "<td style='text-align:center;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>รวม </td>";
	print "</tr>";

	$j =1;		$final_total =0;
	$sql_froms =mysql_query("select distinct c.froms from culture c, hospcode h 
		where h.off_name1=c.froms and	h.off_ssj='$off_ssj' and date_in>='$start_date' and date_in<='$end_date'
		order by c.froms");
	while ($list_froms =mysql_fetch_array($sql_froms)){
		$froms =$list_froms["froms"];

		print "<tr>";
		print "<td style='text-align:center;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>$i </td>";
		print "<td style='text-align:center;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>$j </td>";
		print "<td style='text-align:left;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>$froms </td>";

		$s =0;		
		$sql_pttype =mysql_query("select distinct pttype from culture
		where date_in>='$start_date' and date_in<='$end_date' order by pttype");
		while ($list_pttype =mysql_fetch_array($sql_pttype))	{
			$pttype =$list_pttype["pttype"];

			$sql =mysql_query("select count(*)as count_ptt_from from culture
				where froms='$froms' and pttype='$pttype' and date_in>='$start_date' and date_in<='$end_date'	");
			$show_rec =mysql_fetch_array($sql);
				$count_ptt_from =$show_rec["count_ptt_from"];

				print "<td style='text-align:left;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>$count_ptt_from </td>";
			
				$s=$s+$count_ptt_from;
		}

		print "<td style='text-align:left;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>$s </td>";
		print "</tr>";

		$i++;	$j++;	
		$final_total =$final_total+$s;
	}

	print "<tr>";
	print "<td style='text-align:center;color:#2F70A8; vertical-align:middle; border:1px solid #000;' colspan='$row_footer'>รวม </td>";
	print "<td style='text-align:center;color:#2F70A8; vertical-align:middle; border:1px solid #000;'>$final_total </td>";
	print "</tr>";
}

print "</tbody>";
print "</table></div>";

mysql_close($tb_conn);

?>

<p><b>นิยาม : จำนวนตัวอย่างที่ส่งตรวจและได้ลงทะเบียน แยกตามประเภทผู้ป่วยตามโรงพยาบาลของแต่ละจังหวัด
	<br>N/A หมายถึง ไม่ได้ระบุมาในใบส่งตรวจ
	<br>ตัวอย่างที่ได้ลงทะเบียน หมายถึง ลงทะเบียนตรวจในระบบ TB Online ของ สคร.7 จังหวัดขอนแก่น	</b>
	<br>(บางตัวอย่างที่ส่งตรวจแต่ยังไม่ได้ลงทะเบียน อาจเนื่องเพราะเจ้าหน้าที่ตรวจวิเคราะห์ยังไม่ได้ลงทะเบียน อาจทำให้ตัวเลขเปลี่ยนแปลงได้)</p>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

</body>
</html>