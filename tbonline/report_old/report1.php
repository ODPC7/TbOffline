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

$sql_offssj =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
$rows_offssj =mysql_num_rows($sql_offssj);
	$rows_offssj =($rows_offssj+1);

print "<div class='table-responsive'>	<br>
	<table class='table table-hover' style='font-size:0.8em;'>";
print "<thead>";
print "<tr class='success'>";
print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;' rowspan='2'>ประเภทผู้ป่วย</th>";
print "<th style='text-align:center;color:#2F70A8;' colspan='$rows_offssj'>ตั้งแต่วันที่ $start_date ถึงวันที่ $end_date</th>";
print "</tr>";
print "<tr class='success'>";
//print "<th style='text-align:center;color:#2F70A8;'></th>";

while ($list_offssj =mysql_fetch_array($sql_offssj))	{
	$off_ssj =$list_offssj["off_ssj"];

	print "<th style='text-align:center;color:#2F70A8;'>$off_ssj</th>";
}

print "<th style='text-align:center;color:#2F70A8;'>รวม</th>";
print "</tr></thead><tbody>";

$final_row =0;
$sql_pttype =mysql_query("select distinct pttype from culture where date_in>='$start_date' and date_in<='$end_date' order by pttype ");
while ($list_pttype =mysql_fetch_array($sql_pttype))	{
	$pttype =$list_pttype["pttype"];

	print "<tr>";
	print "<td style='text-align:left;'>$pttype</td>";

	$total =0;	
	$sql_offssj =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
	while ($list_offssj =mysql_fetch_array($sql_offssj))	{
		$off_ssj =$list_offssj["off_ssj"];

		$sql =mysql_query("select count(c.fname)as count_pt from culture c, hospcode h
			where c.froms=h.off_name1 and c.pttype='$pttype' and h.off_ssj='$off_ssj'  
			and c.date_in>='$start_date' and c.date_in<='$end_date'	");
		$show_count =mysql_fetch_array($sql);	
			$count_pt =$show_count["count_pt"];

			print "<td style='text-align:center;'>$count_pt</td>";

			$total =$total+$count_pt;
	}

	$final_row =$final_row+$total;
	print "<td style='text-align:center;'><b>$total</b></td>";
	print "</tr>";
}

print "<tr class='success'>";
print "<td style='text-align:center;' colspan='$rows_offssj'><b>รวม</b></td>";
print "<td style='text-align:right;'><b>$final_row</b></td>";
print "</tr>";
print "</table></div>";

mysql_close($tb_conn);

?>

<p><b>นิยาม : จำนวนตัวอย่างที่ส่งตรวจและได้ลงทะเบียน แยกตามประเภทผู้ป่วยของแต่ละจังหวัด
	<br>N/A หมายถึง ไม่ได้ระบุมาในใบส่งตรวจ
	<br>ตัวอย่างที่ได้ลงทะเบียน หมายถึง ลงทะเบียนตรวจในระบบ TB Online ของ สคร.7 จังหวัดขอนแก่น	</b>
	<br>(บางตัวอย่างที่ส่งตรวจแต่ยังไม่ได้ลงทะเบียน อาจเนื่องเพราะเจ้าหน้าที่ตรวจวิเคราะห์ยังไม่ได้ลงทะเบียน อาจทำให้ตัวเลขเปลี่ยนแปลงได้)</p>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

</body>
</html>