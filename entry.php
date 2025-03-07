<?PHP
if (isset($_GET["get"]) and $_GET["get"]=="out"){			//=== ตรวจสอบการออกจากระบบ
	session_unset();
	session_destroy(); 

	print "<script>window.location='./entry.php';</script>";	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>สำนักงานป้องกันควบคุมโรคที่ 7 จังหวัดขอนแก่น</title>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="./css/bootstrap.css">
	<link rel="stylesheet" href="./css/bootstrap-theme.css">
	<link rel="stylesheet" href="./css/css_plugin.css">
</head>
<body>
<script src="https://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap_plugin.js"></script>

<div class="container-fluid"><!-- container-01 -->
	<?PHP		include("./menu.php");		?>
	<?PHP		include("./head.php");		?>

</div>	<!-- end container-01 -->
<?PHP
include("./config/dataconnector.php");

print "<div class='container'> <br><br><br>	";	//<!-- container-02 -->

if (isset($_SESSION["fname"])){
	print "<script>window.location='./home.php';</script>";	
}else{

	if (isset($_POST["password"]))	{
		$password =$_POST["password"];
		$userid =$_POST["user_id"];
		$sql_person =mysql_query("select * from person where user_id='$userid' and user_pwd='$password'	");
		$rows =mysql_num_rows($sql_person);
		if ($rows >0)	{
				$show_reccord =mysql_fetch_array($sql_person);
					$_SESSION["idcard"] =$show_reccord["id_card"] ;
					$_SESSION["fname"] =$show_reccord["fname"] ;
					$_SESSION["sex"] =$show_reccord["sex"] ;
					$_SESSION["birthday"] =$show_reccord["birthday"] ;
					$_SESSION["workday"] =$show_reccord["workday"] ;
					$_SESSION["address"] =$show_reccord["address"] ;
					$_SESSION["tel"] =$show_reccord["tel"] ;
					$_SESSION["position_id"] =$show_reccord["position_id"] ;
					$_SESSION["position"] =$show_reccord["position"] ;
					$_SESSION["level"] =$show_reccord["level"] ;
					$_SESSION["worktype"] =$show_reccord["worktype"] ;
					$_SESSION["workgroup"] =$show_reccord["workgroup"] ;
					$_SESSION["permit"] =$show_reccord["permit"] ;
					$_SESSION["user_id"] =$show_reccord["user_id"] ;
					$_SESSION["user_pwd"] =$show_reccord["user_pwd"] ;
					$_SESSION["email"] =$show_reccord["email"] ;
					$_SESSION["status"] =$show_reccord["status"] ;
					$_SESSION["note"] =$show_reccord["note"] ;

				$id =$_SESSION["idcard"];		
				$sql_permit =mysql_query("select * from permit where id_card='$id' ");
				$rows_permit =mysql_num_rows($sql_permit);
				if ($rows_permit >0)	{
					while ($list_permit =mysql_fetch_array($sql_permit))	{
						$ws =$list_permit["work_system"] ;
						$pm =$list_permit["permit"] ;

						$_SESSION["$ws"] =$pm;
					}

					print "<script>window.location='./home.php';</script>";	

				}else{
					session_unset();
					session_destroy(); 
					print "<script>
						alert('คุณยังไม่ได้รับสิทธิใช้งาน Back Office ..');
						window.location='./entry.php';
					</script>";	
				}
		
		}else{
				print "<script>alert('รหัสผ่าน ไม่ถูกต้อง ไม่สามารถเข้าระบบได้ ..'); window.location='./index.php';</script>";
		}

	}else{

			if (isset($_POST["user_id"]))	{
				$userid =$_POST["user_id"];
				$count =$_POST["count"];

				$sql_person =mysql_query("select * from person where user_id='$userid'	");
				$rows =mysql_num_rows($sql_person);
				if ($rows >0)	{
						print "	<form class='form-horizontal' role='form' name='pwd_form' method='post' action='./entry.php'>
								<div class='form-group'>
									<label for='password' class='col-sm-2 control-label'>รหัสผ่าน</label>
									<div class='col-sm-10'>
										<input type='password' class='form-control' name='password' placeholder='โปรดระบุ ..' required autofocus>
										<input type='hidden' class='form-control' name='user_id' value='$userid'>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-offset-2 col-sm-10'>
										<button type='submit' class='btn btn-primary'> ตกลง </button>
									</div>
								</div>
							</form>
						";
				
				}else{

						if ($count >=3)	{
							print "<script>alert('ชื่อผ่าน ไม่ถูกต้อง ไม่สามารถเข้าระบบได้ ..'); window.location='./index.php';</script>";
						}else{	//++++++++	login name	ครั้งต่อมา
							$count +=1;
							print "<script>alert('ชื่อผ่าน ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง ..'); </script>";

							print "	<form class='form-horizontal' role='form' name='firstname_form' method='post' action='./entry.php'>
									<div class='form-group'>
										<label for='firstname' class='col-sm-2 control-label'>ชื่อผ่าน</label>
										<div class='col-sm-10'>
											<input type='text' class='form-control' name='user_id' placeholder='โปรดระบุ ..' required autofocus>
											<input type='hidden' class='form-control' name='count' value='$count'>
										</div>
									</div>
									<div class='form-group'>
										<div class='col-sm-offset-2 col-sm-10'>
											<button type='submit' class='btn btn-primary'> ตกลง </button>
										</div>
									</div>
								</form>
							";
						}
					}

			}else{		//++++++++	login name	ครั้งแรก

				print "	<form class='form-horizontal' role='form' name='firstname_form' method='post' action='./entry.php'>
						<div class='form-group'>
							<label for='firstname' class='col-sm-2 control-label'>ชื่อผ่าน</label>
							<div class='col-sm-10'>
								<input type='text' class='form-control' name='user_id' placeholder='โปรดระบุ ..' required autofocus>
								<input type='hidden' class='form-control' name='count' value='1'>
							</div>
						</div>
						<div class='form-group'>
							<div class='col-sm-offset-2 col-sm-10'>
								<button type='submit' class='btn btn-primary'> ตกลง </button>
							</div>
						</div>
						</form>
						<div class='col-sm-offset-2 col-sm-10'>
							<p style='font-size:1.5em; color:#2F70A8;'><u>การสมัครสมาชิก</u>(กรุณาทำให้ครบทุกขั้นตอน)</p>
							<p style='font-size:1em; color:#2F70A8;'>
								<ol>
									<li>คลิกปุ่ม \" สมัครสมาชิก \" เพื่อลงทะเบียนเข้าใช้งาน</li>
									<li>พร้อมส่งอีเมล์มาที่ <font color='#f00'><b>thorpong.k@ddc.mail.go.th</b></font> เพื่อ 
											<font color='#f00'><b>ระบุความต้องการใช้งานระบบใด</b></font> เช่น ดูผลแล็ปวัณโรค เป็นต้น</li>
									<li>หน่วยงานจะตอบกลับในการรับเป็นสมาชิกตามที่อยู่อีเมล์ที่ส่งมานี้</li>
									<li>ผู้สมัครสมาชิกจะได้รับ <font color='#f00'><b>บัญชี(Account)สำหรับใช้งานระบบ</b></font> ทางอีเมล์ เพื่อเป็นการยืนยันการเปิดใช้สิทธิ์</li>
								</ol>
							</p>
							<a href='./member.php' class='btn btn-info btn-lg' role='button'> สมัครสมาชิก </a>
						</div>
				";
			}
	}
}

print "	</div>	";		// <!-- end container-02 -->

mysql_close($conn);

?>

</body>
</html>