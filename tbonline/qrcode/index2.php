<meta charset="utf-8"> 

<?php    

//+++++ function สร้าง qr code +++++++++
include("./qrcode/qrlib.php");    

function CrQRCode($dat)	{

    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'qrcode/temp/';

    if (!file_exists($PNG_TEMP_DIR))	{
        mkdir($PNG_TEMP_DIR);
    }

	$errorCorrectionLevel = 'L';
	$matrixPointSize = 2;

	$filename = $PNG_TEMP_DIR.'tb'.md5($dat.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
       
	QRcode::png($dat, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
	 echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';  
}

//----------------------------------------------------------------------

//+++++ function สร้าง ลบทุกไฟล์ +++++++++

function remove_dir($dir)	{
	if (is_dir($dir))	  {
		$dir = (substr($dir, -1) != "/")? $dir."/":$dir;
		$openDir = opendir($dir);

		while($file = readdir($openDir))	{
			if (!in_array($file, array(".", "..")))	{
				if (!is_dir($dir.$file))	{
					@unlink($dir.$file);
				}else{
					remove_dir($dir.$file);
				}
			}
		}

		closedir($openDir);
		//@rmdir($dir);
	}
} 

//-------------------------------------------------------------------


?>