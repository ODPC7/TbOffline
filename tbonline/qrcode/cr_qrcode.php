<meta charset="utf-8"> 

<?php        
	include("../tblab_connector.php");
    include("./index2.php");    

	$sql =mysql_query("select date_in, name, sex, froms, cul_no 
		from tb_newdb 
		where froms='ภูเรือ'
		order by date_in asc	");

	print "<table style='width:100%;'>
		<tr>
			<td style='border:1px solid #000; text-align:center; font-weight:bold; background-color:#00f; color:#fff; height:50px;' colspan='6'>Create QR Code Test</td>
		</tr>
		<tr>
			<td style='border:1px solid #000; text-align:center; font-weight:bold;'>QR Code</td>
			<td style='border:1px solid #000; text-align:center; font-weight:bold;'>วันที่ส่งตัวอย่าง</td>
			<td style='border:1px solid #000; text-align:center; font-weight:bold;'>ชื่อ-สกุล</td>
			<td style='border:1px solid #000; text-align:center; font-weight:bold;'>เพศ</td>
			<td style='border:1px solid #000; text-align:center; font-weight:bold;'>สถานที่ส่งตรวจ</td>
			<td style='border:1px solid #000; text-align:center; font-weight:bold;'>LAB No.</td>
		</tr>
	";

	while ($list_data =mysql_fetch_array($sql)){
		$datein =$list_data["date_in"];
		$ptname =$list_data["name"];
		$sex =$list_data["sex"];
		$froms =$list_data["froms"];
		$cul_no =$list_data["cul_no"];

		$dat =$datein .",". $ptname .",". $sex .",". $froms .",". $cul_no;
		print "	<tr>			<td style='border:1px solid #000; text-align:center; '>	";

		crqrcode($dat);

		print "	</td>
			<td style='border:1px solid #000; text-align:center; '>$datein</td>
			<td style='border:1px solid #000; text-align:left; '>$ptname</td>
			<td style='border:1px solid #000; text-align:center; '>$sex</td>
			<td style='border:1px solid #000; text-align:left; '>$froms</td>
			<td style='border:1px solid #000; text-align:center; '>$cul_no</td>
		</tr>";

	}

	print "</table>";

?>