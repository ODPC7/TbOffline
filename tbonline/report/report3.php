<?PHP
	if (isset($_GET["exp_type"]) and $_GET["exp_type"]=="file")	{
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename=report3.xls');
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
	<table class='table table-hover' style='font-size:1.0em;'>";
print "<thead>";
print "<tr class='success'>";
print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;' rowspan='2'>ประเภทการทดสอบ</th>";
print "<th style='text-align:center;color:#2F70A8;' colspan='$rows_offssj'>จังหวัดที่ส่งตรวจ ตั้งแต่วันที่ $start_date ถึงวันที่ $end_date</th>";
print "</tr>";
print "<tr class='success'>";

while ($list_offssj =mysql_fetch_array($sql_offssj))	{
	$off_ssj =$list_offssj["off_ssj"];

	print "<th style='text-align:center;color:#2F70A8;'>$off_ssj</th>";
}

print "<th style='text-align:center;color:#2F70A8;'>รวม</th>";
print "</tr></thead><tbody>";

//+++++++	Culture ++++++++++++++
print "<tr>";
print "<td style='text-align:left;'>Culture</td>";

$s_cul =0;
$sql_offssj =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
while ($list_offssj =mysql_fetch_array($sql_offssj))	{
	$off_ssj =$list_offssj["off_ssj"];

	$sql =mysql_query("select count(c.fname)as count_offssj from culture c,hospcode h
	where c.froms=h.off_name1 and h.off_ssj='$off_ssj' and c.date_in>='$start_date' and c.date_in<='$end_date'	");
	$show_rec =mysql_fetch_array($sql);
		$count_offssj =$show_rec["count_offssj"];

		print "<td style='text-align:center;'>$count_offssj</td>";
		$s_cul =($s_cul+$count_offssj);
}

print "<td style='text-align:center; font-weight:bold; font-size:1.2em;'>$s_cul</td>";
print "</tr>";
//+++++++	End	Culture ++++++++++++++

//+++++++	Identification ++++++++++++++
print "<tr>";
print "<td style='text-align:left;'>Identification</td>";

$s_iden =0;
$sql_offssj =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
while ($list_offssj =mysql_fetch_array($sql_offssj))	{
	$off_ssj =$list_offssj["off_ssj"];

	$sql =mysql_query("select count(i.result)as count_offssj from identification i,culture c,hospcode h
where i.fname=c.fname and i.cul_no=c.cul_no and c.froms=h.off_name1 and h.off_ssj='$off_ssj'
	and c.date_in>='$start_date' and c.date_in<='$end_date'	");
	$show_rec =mysql_fetch_array($sql);
		$count_offssj =$show_rec["count_offssj"];

		print "<td style='text-align:center;'>$count_offssj</td>";
		$s_iden =($s_iden+$count_offssj);
}

print "<td style='text-align:center; font-weight:bold; font-size:1.2em;'>$s_iden</td>";
print "</tr>";
//+++++++	End	Identification ++++++++++++++

//+++++++	DST ++++++++++++++
print "<tr>";
print "<td style='text-align:left;'>DST</td>";

$s_dst =0;
$sql_offssj =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
while ($list_offssj =mysql_fetch_array($sql_offssj))	{
	$off_ssj =$list_offssj["off_ssj"];

	$sql =mysql_query("select count(xpert.cul_no)as count_offssj
from (select distinct fname,cul_no,anal_method from dst 
where anal_method in('Solid-FLDST','Solid-SLDST','Liquid-FLDST MGIT','Liquid-FLDST MTT','Liquid-SLDST'))as xpert,culture c,hospcode h
where xpert.fname=c.fname and xpert.cul_no=c.cul_no and c.froms=h.off_name1 
	and h.off_ssj='$off_ssj' and c.date_in>='$start_date' and c.date_in<='$end_date'
order by h.region_nhso,h.off_ssj	");
	$show_rec =mysql_fetch_array($sql);
		$count_offssj =$show_rec["count_offssj"];

		print "<td style='text-align:center;'>$count_offssj</td>";
		$s_dst =($s_dst+$count_offssj);
}

print "<td style='text-align:center; font-weight:bold; font-size:1.2em;'>$s_dst</td>";
print "</tr>";
//+++++++	End	DST ++++++++++++++

//+++++++	Gene-Xpert FLDST ++++++++++++++
print "<tr>";
print "<td style='text-align:left;'>Gene-Xpert FLDST</td>";

$s_xpert =0;
$sql_offssj =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
while ($list_offssj =mysql_fetch_array($sql_offssj))	{
	$off_ssj =$list_offssj["off_ssj"];

	$sql =mysql_query("select count(xpert.cul_no)as count_offssj
from (select distinct fname,cul_no,anal_method from dst where anal_method='Gene-Xpert FLDST')as xpert,culture c,hospcode h
where xpert.fname=c.fname and xpert.cul_no=c.cul_no and c.froms=h.off_name1 
	and h.off_ssj='$off_ssj' and c.date_in>='$start_date' and c.date_in<='$end_date'
order by h.region_nhso,h.off_ssj	");
	$show_rec =mysql_fetch_array($sql);
		$count_offssj =$show_rec["count_offssj"];

		print "<td style='text-align:center;'>$count_offssj</td>";
		$s_xpert =($s_xpert+$count_offssj);
}

print "<td style='text-align:center; font-weight:bold; font-size:1.2em;'>$s_xpert</td>";
print "</tr>";
//+++++++	End	Gene-Xpert FLDST ++++++++++++++

//+++++++	LPA-FLDST ++++++++++++++
print "<tr>";
print "<td style='text-align:left;'>LPA-FLDST</td>";

$s_lpafl =0;
$sql_offssj =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
while ($list_offssj =mysql_fetch_array($sql_offssj))	{
	$off_ssj =$list_offssj["off_ssj"];

	$sql =mysql_query("select count(xpert.cul_no)as count_offssj
from (select distinct fname,cul_no,anal_method from dst where anal_method='LPA-FLDST')as xpert,culture c,hospcode h
where xpert.fname=c.fname and xpert.cul_no=c.cul_no and c.froms=h.off_name1 
	and h.off_ssj='$off_ssj' and c.date_in>='$start_date' and c.date_in<='$end_date'
order by h.region_nhso,h.off_ssj	");
	$show_rec =mysql_fetch_array($sql);
		$count_offssj =$show_rec["count_offssj"];

		print "<td style='text-align:center;'>$count_offssj</td>";
		$s_lpafl =($s_lpafl+$count_offssj);
}

print "<td style='text-align:center; font-weight:bold; font-size:1.2em;'>$s_lpafl</td>";
print "</tr>";
//+++++++	End	LPA-FLDST ++++++++++++++

//+++++++	LPA-SLDST ++++++++++++++
print "<tr>";
print "<td style='text-align:left;'>LPA-SLDST</td>";

$s_lpasl =0;
$sql_offssj =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
while ($list_offssj =mysql_fetch_array($sql_offssj))	{
	$off_ssj =$list_offssj["off_ssj"];

	$sql =mysql_query("select count(xpert.cul_no)as count_offssj
from (select distinct fname,cul_no,anal_method from dst where anal_method='LPA-SLDST')as xpert,culture c,hospcode h
where xpert.fname=c.fname and xpert.cul_no=c.cul_no and c.froms=h.off_name1 
	and h.off_ssj='$off_ssj' and c.date_in>='$start_date' and c.date_in<='$end_date'
order by h.region_nhso,h.off_ssj	");
	$show_rec =mysql_fetch_array($sql);
		$count_offssj =$show_rec["count_offssj"];

		print "<td style='text-align:center;'>$count_offssj</td>";
		$s_lpasl =($s_lpasl+$count_offssj);
}

print "<td style='text-align:center; font-weight:bold; font-size:1.2em;'>$s_lpasl</td>";
print "</tr>";
//+++++++	End	LPA-FLDST ++++++++++++++

//+++++++	Real-time PCR FLDST ++++++++++++++
print "<tr>";
print "<td style='text-align:left;'>Real-time PCR FLDST</td>";

$s_pcrfl =0;
$sql_offssj =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
while ($list_offssj =mysql_fetch_array($sql_offssj))	{
	$off_ssj =$list_offssj["off_ssj"];

	$sql =mysql_query("select count(xpert.cul_no)as count_offssj
from (select distinct fname,cul_no,anal_method from dst where anal_method='Real-time PCR FLDST')as xpert,culture c,hospcode h
where xpert.fname=c.fname and xpert.cul_no=c.cul_no and c.froms=h.off_name1 
	and h.off_ssj='$off_ssj' and c.date_in>='$start_date' and c.date_in<='$end_date'
order by h.region_nhso,h.off_ssj	");
	$show_rec =mysql_fetch_array($sql);
		$count_offssj =$show_rec["count_offssj"];

		print "<td style='text-align:center;'>$count_offssj</td>";
		$s_pcrfl =($s_pcrfl+$count_offssj);
}

print "<td style='text-align:center; font-weight:bold; font-size:1.2em;'>$s_pcrfl</td>";
print "</tr>";
//+++++++	End	Real-time PCR FLDST ++++++++++++++

//+++++++	Real-time PCR SLDST ++++++++++++++
print "<tr>";
print "<td style='text-align:left;'>Real-time PCR SLDST</td>";

$s_pcrsl =0;
$sql_offssj =mysql_query("select distinct off_ssj from hospcode order by region_nhso, off_ssj");
while ($list_offssj =mysql_fetch_array($sql_offssj))	{
	$off_ssj =$list_offssj["off_ssj"];

	$sql =mysql_query("select count(xpert.cul_no)as count_offssj
from (select distinct fname,cul_no,anal_method from dst where anal_method='Real-time PCR SLDST')as xpert,culture c,hospcode h
where xpert.fname=c.fname and xpert.cul_no=c.cul_no and c.froms=h.off_name1 
	and h.off_ssj='$off_ssj' and c.date_in>='$start_date' and c.date_in<='$end_date'
order by h.region_nhso,h.off_ssj	");
	$show_rec =mysql_fetch_array($sql);
		$count_offssj =$show_rec["count_offssj"];

		print "<td style='text-align:center;'>$count_offssj</td>";
		$s_pcrsl =($s_pcrsl+$count_offssj);
}

print "<td style='text-align:center; font-weight:bold; font-size:1.2em;'>$s_pcrsl</td>";
print "</tr>";
//+++++++	End	Real-time PCR FLDST ++++++++++++++



print "</tbody></table></div>";

mysql_close($tb_conn);

?>

<p><b>นิยาม : จำนวนตัวอย่างที่ส่งตรวจและได้ลงทะเบียน แยกตามประเภทการตรวจวิเคราะห์ของแต่ละจังหวัด
	<br>ตัวอย่างที่ได้ลงทะเบียน หมายถึง ลงทะเบียนตรวจในระบบ TB Online ของ สคร.7 จังหวัดขอนแก่น	</b>
	<br>(บางตัวอย่างที่ส่งตรวจแต่ยังไม่ได้ลงทะเบียน อาจเนื่องเพราะเจ้าหน้าที่ตรวจวิเคราะห์ยังไม่ได้ลงทะเบียน อาจทำให้ตัวเลขเปลี่ยนแปลงได้)</p>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

</body>
</html>