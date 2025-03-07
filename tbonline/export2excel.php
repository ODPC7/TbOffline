<?PHP

if (isset($_POST["export_type"]) and $_POST["export_type"]=="file")	{
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename=tb.xls');
	print "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">	";
}

include("./tblab_connector.php");

if (isset($_POST["bigin_date"]) and isset($_POST["end_date"])){

	$date1 =$_POST["bigin_date"];
	$date2 =$_POST["end_date"];

	print "<p><font size='2'>นำออกข้อมูลระหว่างวันที่ $date1 ถึงวันที่ $date2</font></p>		";
	print "
		<table border='1' width='100%' bordercolor='#000000' cellpadding='0' cellspacing='0'>
			<tr>
				<td align='center' bordercolour='#000000'><font size='2'><b>ลำดับ</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>เลขบัตร ปชช.</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>ชื่อ - สกุล</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>เพศ</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>อายุ</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>สิทธิการรักษา</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>วันที่รับ ตย.</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>รับ ตย. จาก</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>ชนิดตัวอย่าง</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>ประเภท ผป.</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>Culture NO.</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>วันที่รายงาน<br>Culture</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>Culture</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>วันที่รายงาน<br>Identification</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>Identification</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>Analysis Method</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>Analysis Result</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>Level Result</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>วันที่รายงาน<br>DST</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>DST</b></font></td>
				<td align='center' bordercolour='#000000'><font size='2'><b>Result</b></font></td>
		</tr>		
	";

//+++	ประกาศตัวแปรเพื่อตรวจสอบ ชื่อ, cul_no,anal_method ว่าซ้ำหรือไม่
	$pt ="";
	$cn ="";
	$m ="";
//++++++++++++++

	$i =1;		//+++	หมายเลข running

	//+++	ประวัติพื้นฐาน
	$sql_profile =mysql_query("select pp.*, c.date_in, c.froms, c.specimen, c.pttype, c.cul_no, c.datereport, c.result as cul_result
		from ptt_profile pp, culture c 
		where pp.fname=c.fname and c.date_in >='$date1' and c.date_in <='$date2'
		order by c.cul_no");
	while ($list_profile =mysql_fetch_array($sql_profile))	{
		$id =$list_profile["id_card"];
		$ptname =$list_profile["fname"];		
		$sex =$list_profile["sex"];
		$age =$list_profile["age"];
		$right_care =$list_profile["right_care"];
		$date_in =$list_profile["date_in"];
		$froms =$list_profile["froms"];
		$specimen =$list_profile["specimen"];
		$pttype =$list_profile["pttype"];
		$cul_no =$list_profile["cul_no"];		
		$cul_datereport =$list_profile["datereport"];
		$cul_result =$list_profile["cul_result"];

		//+++	ผล Identification
		$sql_iden =mysql_query("select datereport, result as iden_result
			from identification where fname='$ptname' and cul_no='$cul_no'	");
		$show_iden =mysql_fetch_array($sql_iden);
			$iden_datereport =$show_iden["datereport"];
			$iden_result =$show_iden["iden_result"];

		//+++	ผล DST, Molecular
		$sql_dst =mysql_query("select * from dst where fname='$ptname' and cul_no='$cul_no'	");
		$rows_dst =mysql_num_rows($sql_dst);

		if ($rows_dst >0)	{		//+++	กรณี No growth culture ไม่ต้อง Iden, DST

			while ($show_dst =mysql_fetch_array($sql_dst))	{
				$anal_method =$show_dst["anal_method"];		
				$anal_result =$show_dst["anal_result"];
				$level_result =$show_dst["level_result"];
				$drug =$show_dst["drug"];
				$dst_datereport =$show_dst["datereport"];
				$dst_result =$show_dst["result"];

				if ($pt==$ptname and $cn==$cul_no and $m==$anal_method)	{
					print "<tr>
						<td align='center' bordercolour='#000000'><font size='2'>$i</font></td>
						<td align='center' bordercolour='#000000' colspan='18'><font size='2'></font></td>
					";
					print "	<td align='left' bordercolour='#000000'><font size='2'>$drug</font></td>
								<td align='left' bordercolour='#000000'><font size='2'>$dst_result</font></td>
					</tr>";

				}else{

					print "<tr style='background-color:#eee;'>
						<td align='center' bordercolour='#000000'><font size='2'>$i</font></td>
						<td align='center' bordercolour='#000000'><font size='2'>$id</font></td>
						<td align='left' bordercolour='#000000'><font size='2'>$ptname</font></td>
						<td align='center' bordercolour='#000000'><font size='2'>$sex</font></td>
						<td align='center' bordercolour='#000000'><font size='2'>$age</font></td>
						<td align='center' bordercolour='#000000'><font size='2'>$right_care</font></td>
						<td align='center' bordercolour='#000000'><font size='2'>$date_in</font></td>
						<td align='left' bordercolour='#000000'><font size='2'>$froms</font></td>
						<td align='left' bordercolour='#000000'><font size='2'>$specimen</font></td>
						<td align='left' bordercolour='#000000'><font size='2'>$pttype</font></td>
						<td align='center' bordercolour='#000000'><font size='2'>$cul_no</font></td>
						<td align='left' bordercolour='#000000'><font size='2'>$cul_datereport</font></td>
						<td align='left' bordercolour='#000000'><font size='2'>$cul_result</font></td>
					";
					print "<td align='left' bordercolour='#000000'><font size='2'>$iden_datereport</font></td>";
					print "<td align='left' bordercolour='#000000'><font size='2'>$iden_result</font></td>";
					print "	<td align='left' bordercolour='#000000'><font size='2'>$anal_method</font></td>
								<td align='left' bordercolour='#000000'><font size='2'>$anal_result</font></td>
								<td align='left' bordercolour='#000000'><font size='2'>$level_result</font></td>
								<td align='left' bordercolour='#000000'><font size='2'>$dst_datereport</font></td>
								<td align='left' bordercolour='#000000'><font size='2'>$drug</font></td>
								<td align='left' bordercolour='#000000'><font size='2'>$dst_result</font></td>
					</tr>";
				}

				$pt =$ptname;
				$cn =$cul_no;
				$m =$anal_method;
				$i++;
			}
		}else{

			print "<tr style='background-color:#eee;'>
				<td align='center' bordercolour='#000000'><font size='2'>$i</font></td>
				<td align='center' bordercolour='#000000'><font size='2'>$id</font></td>
				<td align='left' bordercolour='#000000'><font size='2'>$ptname</font></td>
				<td align='center' bordercolour='#000000'><font size='2'>$sex</font></td>
				<td align='center' bordercolour='#000000'><font size='2'>$age</font></td>
				<td align='center' bordercolour='#000000'><font size='2'>$right_care</font></td>
				<td align='center' bordercolour='#000000'><font size='2'>$date_in</font></td>
				<td align='left' bordercolour='#000000'><font size='2'>$froms</font></td>
				<td align='left' bordercolour='#000000'><font size='2'>$specimen</font></td>
				<td align='left' bordercolour='#000000'><font size='2'>$pttype</font></td>
				<td align='center' bordercolour='#000000'><font size='2'>$cul_no</font></td>
				<td align='left' bordercolour='#000000'><font size='2'>$cul_datereport</font></td>
				<td align='left' bordercolour='#000000'><font size='2'>$cul_result</font></td>
			";
			print "<td align='left' bordercolour='#000000'><font size='2'>$iden_datereport</font></td>";
			print "<td align='left' bordercolour='#000000'><font size='2'>$iden_result</font></td>";
			print "	<td align='left' bordercolour='#000000'><font size='2'></font></td>
						<td align='left' bordercolour='#000000'><font size='2'></font></td>
						<td align='left' bordercolour='#000000'><font size='2'></font></td>
						<td align='left' bordercolour='#000000'><font size='2'></font></td>
						<td align='left' bordercolour='#000000'><font size='2'></font></td>
						<td align='left' bordercolour='#000000'><font size='2'></font></td>
			</tr>";

			$i++;
		}
	}

}else{
		print "<script>		window.location='./export_data.php';		</script>";
}

mysql_close($tb_conn);

?>

</table>