<?PHP
//+++ ตรวจสอบการเข้าระบบ
if ( ! isset($_SESSION["user_name"]))	{
	print "<script>
		alert('ท่านไม่ได้รับสิทธิ์ในการใช้งานหน้านี้ ..'); 
		window.location='./';
	</script>";

}else{

	require_once('./mpdf/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
	ob_start(); // ทำการเก็บค่า html นะครับ

	include("./myfunction.php");
	include("./tblab_connector.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
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


<?PHP
$user_name =$_SESSION["user_name"];
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

$pt_name =$_GET["pt_name"];
$cno =$_GET["cno"];
$space ="&nbsp;&nbsp;&nbsp;";

$sql_profile =mysql_query("select * from ptt_profile where fname='$pt_name'	");
	$show_profile =mysql_fetch_array($sql_profile);
		$id =$show_profile["id_card"];
		$sex =$show_profile["sex"];
		$age =$show_profile["age"];
		$right_care =$show_profile["right_care"];

$sql_culture =mysql_query("select c.*, p.fname as reporter
from culture c, person p 
where c.report_by=p.id_card and c.fname='$pt_name' and c.cul_no='$cno'	");
	$show_culture =mysql_fetch_array($sql_culture);
		$date_in =$show_culture["date_in"];
		$froms =$show_culture["froms"];
		$hn =$show_culture["hn"];
		$afb =$show_culture["afb"];
		$specimen =$show_culture["specimen"];
		$pttype =$show_culture["pttype"];
		$method =$show_culture["method"];
		$culture_result =$show_culture["result"];
		$cul_datereport =$show_culture["datereport"];
		$cul_report_by =$show_culture["reporter"];


//+++	ส่วนหัวรายงาน
print "<p style='margin:1rem 0 0 0; text-align:center; font-weight:bold; font-size:1.2em;'>
	รายงานผลการตรวจทางห้องปฏิบัติการวัณโรค
</p>";
print "<p style='margin:0 0 1rem 0; text-align:center; font-weight:bold; font-size:1.2em;'>
	การตรวจสอบเชื้อมัยโคแบคทีเรีย (Mycobacterium examination)
</p>";
print "<p style='margin:0 0 1rem 0; text-align:center; font-size:0.75em;'>
	สำนักงานป้องกันควบคุมโรคที่ 7 จังหวัดขอนแก่น กรมควบคุมโรค กระทรวงสาธารณะสุข	<br>
	181/37  ซ.ราชประชา  ถ.ศรีจันทร์  ต.ในเมือง  อ.เมือง  จ.ขอนแก่น  40000  <br>	
	โทรศัพท์ : 043222818-9 ต่อ 302  โทรสาร : 043226164
</p>";
//+++	จบ	ส่วนหัวรายงาน

//+++	ส่วนเนื้อหารายงาน
print "<p style='font-size:0.9em; border:1px solid #000; padding:0.75rem;'>
เลขบัตรประชาชน : $id $space ชื่อ-สกุล : $pt_name $space เพศ : $sex $space อายุ : $age $space <br> 
สิทธิการรักษา : $right_care $space โรงพยาบาล : $froms $space HN : $hn $space ตัวอย่างส่งตรวจ : $specimen $space <br>
วันที่รับตัวอย่าง : $date_in $space ประเภทผู้ป่วย : $pttype $space AFB : $afb
</p>";
print "<p style='font-size:0.9em; border:1px solid #000; padding:0.75rem;'>
Culture No. : <b>$cno </b>$space Culture Method : <b>$method </b>$space 
Culture Result : <b>$culture_result </b>$space <br>
ผู้รายงานผล : $cul_report_by $space วันที่รายงานผล : $cul_datereport
</p>";

$sql_iden =mysql_query("select i.* , p.fname as reporter
	from identification i, person p
	where i.report_by=p.id_card and i.fname='$pt_name' and i.cul_no='$cno'	");
$show_rec =mysql_fetch_array($sql_iden);
	$iden_result =$show_rec["result"];
	$iden_datereport =$show_rec["datereport"];
	$iden_reporter =$show_rec["reporter"];

print "<p style='font-size:0.9em; border:1px solid #000; padding:0.75rem;'>
Identification Result : <b>$iden_result</b>	
ผู้รายงานผล : $iden_reporter $space วันที่รายงานผล : $iden_datereport
</p>";

$sql_dst1 =mysql_query("select distinct dst.anal_method,dst.test_date,dst.datereport, 
		dst.anal_result, dst.level_result, p.fname as reporter from dst , person p
	where dst.report_by=p.id_card and dst.fname='$pt_name' and dst.cul_no='$cno'	");
while ($list_dst1 =mysql_fetch_array($sql_dst1))	{
	$method =$list_dst1["anal_method"];
	$anal_result =$list_dst1["anal_result"];
	$level_result =$list_dst1["level_result"];
	$test_date =$list_dst1["test_date"];
	$datereport =$list_dst1["datereport"];
	$reporter =$list_dst1["reporter"];

	if ($method=="Solid-FLDST" or $method=="Solid-SLDST" or $method=="Liquid-FLDST MGIT"
		 or $method=="Liquid-FLDST MTT" or $method=="Liquid-SLDST")	{
		$sql_dst2 =mysql_query("select dst.* from dst where dst.fname='$pt_name' and dst.cul_no='$cno' 
			and dst.anal_method='$method' and dst.anal_method in('Solid-FLDST','Solid-SLDST','Liquid-FLDST MGIT',
		   'Liquid-FLDST MTT','Liquid-SLDST')	");

		print "<div style='font-size:0.9em; border:1px solid #000; padding:0.75rem;'>
			Drug Susceptibility Test (DST) Result : <b>$method</b> $space Test Date : $test_date
		<p>";

	}else{

		if ($method=="Gene-Xpert FLDST" or $method=="Gene-Xpert SLDST")	{
			$sql_dst2 =mysql_query("select dst.* from dst where dst.fname='$pt_name' and dst.cul_no='$cno' 
				and dst.anal_method='$method' and dst.anal_method in('Gene-Xpert FLDST','Gene-Xpert SLDST')	");

			print "<div style='font-size:0.9em; border:1px solid #000; padding:0.75rem;'>
				Molecular Assay Result : <b>$method</b> $space Test Date : $test_date	<br>
				Gene-Xpert Result : <b>$anal_result $space </b> Level result : <b>$level_result  </b>
			<p>";

		}else{
			$sql_dst2 =mysql_query("select dst.* from dst where dst.fname='$pt_name' and dst.cul_no='$cno' 
				and dst.anal_method='$method' and dst.anal_method in('LPA-FLDST','LPA-SLDST','Real-time PCR FLDST',
			   'Real-time PCR SLDST')	");

			print "<div style='font-size:0.9em; border:1px solid #000; padding:0.75rem;'>
				Molecular Assay Result : <b>$method</b> $space Test Date : $test_date	<br>
				Molecular Result : <b>$anal_result $space </b> 
			<p>";
		}
	}

	while ($list_dst2 =mysql_fetch_array($sql_dst2))	{
		$drug =$list_dst2["drug"];
		$result =$list_dst2["result"];

		print "		<b>$drug : $result	</b><br>		";
	}

	print "</p>	ผู้รายงานผล : $reporter $space วันที่รายงาน : $datereport	</div>";
}

$sql_appr =mysql_query("select appr.*, p.fname as reporter from approve appr, person p 
where appr.report_by=p.id_card and appr.fname='$pt_name' and appr.cul_no='$cno'	");
$show_approve =mysql_fetch_array($sql_appr);
	$approve_result =$show_approve["result"];
	$note =$show_approve["note"];
	$datereport =$show_approve["datereport"];
	$reporter =$show_approve["reporter"];

print "<p style='font-size:1em; padding:1rem; border:1px solid #000;'>
	หมายเหตุ : $note	<br>
	ผู้รับรองผล : $reporter $space วันที่ : $datereport
</p>";











//+++	จบ	ส่วนเนื้อหารายงาน

}

?>


</div>	<!-- end container-01 -->

<?PHP	mysql_close($tb_conn);	

	$html = ob_get_contents();        //เก็บค่า html ไว้ใน $html
	ob_end_clean();
	$pdf = new mPDF('th', 'A4', '0', '');   //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L เปลี่ยนฟอนท์ใส่ช่องสุดท้าย THSaraban
	$pdf->SetAutoFont();
	$pdf->SetDisplayMode('fullpage');
	$pdf->WriteHTML($html, 2);
	$pdf_file =$login_id . "_$m_$y" . ".pdf";
	$pdf->Output();         // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสดง

?>

</body>
</html>