<?PHP	
include("./tblab_connector.php");

$space ='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	';

if (isset($_GET["keyword"])) {
	$keyword =$_GET["keyword"];

	$sql =mysql_query("select id_card, fname from ptt_profile where ((fname like '$keyword%') or (id_card like '$keyword%')) order by fname asc	");
	while ($list_row =mysql_fetch_array($sql)){
		$id =$list_row["id_card"];
		$ptt_name =$list_row["fname"];
		print "<option value='$ptt_name'>$id $ptt_name</option>";
	}
}

if (isset($_GET["fn"])){
	$name_search =$_GET["fn"];
	$sql =mysql_query("select * from ptt_profile where fname like '$name_search'	");
	$list_row =mysql_fetch_array($sql);
		$id =$list_row["id_card"];
		$sex =$list_row["sex"];
		$age =$list_row["age"];
		$right_care =$list_row["right_care"];

		print "	เลขบัตรประชาชน : $id $space ชื่อ - สกุล : $name_search $space เพศ : $sex $space อายุ : $age $space สิทธิการรักษา : $right_care		";

		return ;
}

if (isset($_GET["getdata"])){
	$name_search =$_GET["getdata"];
	$sql =mysql_query("select * from ptt_profile where fname like '$name_search'	");
	$list_row =mysql_fetch_array($sql);
		$id =$list_row["id_card"];
		$sex =$list_row["sex"];
		$age =$list_row["age"];
		$right_care =$list_row["right_care"];

		print "	เลขบัตรประชาชน : $id $space ชื่อ - สกุล : $name_search $space เพศ : $sex $space อายุ : $age $space สิทธิการรักษา : $right_care		";

		return ;
}










mysql_close($tb_conn);

?>