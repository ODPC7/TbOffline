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

print "<div class='table-responsive'>	<br>
	<table class='table table-hover' style='font-size:1.2em;'>";
print "<thead>";
print "<tr class='success'>";
print "<th style='text-align:center;color:#2F70A8; vertical-align:middle;' rowspan='2'>จนท.ปฏิบัติงาน</th>";
print "<th style='text-align:center;color:#2F70A8;' colspan='4'>ผลการปฏิบัติงาน ตั้งแต่วันที่ $start_date ถึงวันที่ $end_date</th>";
print "</tr>";
print "<tr class='success'>";
print "<th style='text-align:center;color:#2F70A8;'>Culture</th>";
print "<th style='text-align:center;color:#2F70A8;'>Identification</th>";
print "<th style='text-align:center;color:#2F70A8;'>DST</th>";
print "<th style='text-align:center;color:#2F70A8;'>Molecular</th>";
print "</tr></thead><tbody>";

$sql_person =mysql_query("select fname from person order by fname ");
while ($list_person =mysql_fetch_array($sql_person))	{
	$officer =$list_person["fname"];

	print "<tr>";
	print "<td style='text-align:left;'>$officer</td>";

	$sql_cul =mysql_query("select count(*)as cul_rows from person p,culture c
		where p.id_card=c.report_by and p.fname='$officer' and c.datereport>='$start_date' and c.datereport<='$end_date'	");
	$show_cul =mysql_fetch_array($sql_cul);
		$cul_rows =$show_cul["cul_rows"];

	$sql_iden =mysql_query("select count(*)as iden_rows from person p,identification i 
		where p.id_card=i.report_by and p.fname='$officer' and i.datereport>='$start_date' and i.datereport<='$end_date'	");
	$show_iden =mysql_fetch_array($sql_iden);
		$iden_rows =$show_iden["iden_rows"];

	$sql_dst =mysql_query("select count(*)as dst_rows from person p,dst
		where p.id_card=dst.report_by and p.fname='$officer' and  dst.datereport>='$start_date' and dst.datereport<='$end_date' and
		dst.anal_method in('Solid-FLDST','Solid-SLDST','Liquid-FLDST MGIT','Liquid-FLDST MTT','Liquid-SLDST') ");
	$show_dst =mysql_fetch_array($sql_dst);
		$dst_rows =$show_dst["dst_rows"];

	$sql_mol =mysql_query("select count(*)as mol_rows from person p,dst
		where p.id_card=dst.report_by and p.fname='$officer' and dst.datereport>='$start_date' and dst.datereport<='$end_date' and
		dst.anal_method in('LPA-FLDST','LPA-SLDST','Real-time PCR FLDST',
						                      'Real-time PCR SLDST','Gene-Xpert FLDST','Gene-Xpert SLDST')	");
	$show_mol =mysql_fetch_array($sql_mol);
		$mol_rows =$show_mol["mol_rows"];


	print "<td style='text-align:center;'>$cul_rows</td>";
	print "<td style='text-align:center;'>$iden_rows</td>";
	print "<td style='text-align:center;'>$dst_rows</td>";
	print "<td style='text-align:center;'>$mol_rows</td>";
	print "</tr>";
}

print "</table></div>";

mysql_close($tb_conn);

?>

<p><b>นิยาม : </b>
	<ol>
		<li>จำนวนผลการปฏิบัติงาน นับจากการรายงานผล</li>
		<li>จากข้อ 1 มีผลให้ยอดรวมของผู้ลงทะเบียนข้อมูลพื้นฐานอาจต่ำกว่าความเป็นจริง</li>
		<li>จากข้อ 1 มีผลให้ยอดรวมของผู้ปฏิบัติงานแต่ละอย่างอาจไม่ตรงความเป็นจริง</li>
	</ol>
</p>

		</div>	<!-- end panel-body -->
	</div>	<!-- end panel-primary -->

</div>	<!-- container-02 -->

</body>
</html>