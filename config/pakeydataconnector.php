  <meta http-equiv="content-type" content="text/html; charset=utf-8">
<?PHP
$servername="127.0.0.1";
$loginname="admin";
$loginpassword="94pnOr";
$databasename="pakeynetwork";

$conn=mysql_connect($servername,$loginname,$loginpassword) or die("`ไม่สามารถติดต่อ Server ได้.!!");
mysql_select_db($databasename,$conn) or die("ไม่สามารถติดต่อฐานข้อมูลได้.!!");

//date_default_timezone_set('Asia/Bangkok');
putenv("Asia/Bangkok");

mysql_query("SET NAMES UTF-8");

//mysql_query("SET character_set_results=tis620");
//mysql_query("SET character_set_client=tis620");
//mysql_query("SET character_set_connection=tis620");

?>