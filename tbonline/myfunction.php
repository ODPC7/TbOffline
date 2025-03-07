<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?PHP

function NumberFormat($num){
	$num=intval($num);
	$numstr=strlen($num);	
   $i=0;
	if ($numstr<=3){
		$str=$num;
	}else{
		$ed=($numstr % 3);	
		switch ($ed){
			case 1:
				$str=substr($num,0,$ed);	
				for ($i==1;$i<$numstr-$ed;$i+=3){					
					$str=$str.",".substr($num,$i+$ed,3);
				}
				break;
			case 2:
				$str=substr($num,0,$ed);	
				for ($i==1;$i<$numstr-$ed;$i+=3){					
					$str=$str.",".substr($num,$i+$ed,3);
				}
				break;
			default :
				$str=substr($num,0,3);	
				for ($i==1;$i<$numstr-3;$i+=3){					
					$str=$str.",".substr($num,$i+3,3);
				}
				break;
			}
		}
		return $str;
}

function DayOfYear($date){
	$yy=substr($date,0,4);
	$mm=substr($date,5,2);
	$dd=substr($date,8,2);
	$m=array();
	$m['01']=0;	$m['02']=31;		$m['03']=59;	$m['04']=90;	$m['05']=120;	$m['06']=151;
	$m['07']=181;	$m['08']=212;		$m['09']=243;	$m['10']=273;	$m['11']=304;	$m['12']=334;
	$day=$m[$mm];
	if ((($yy%4)==0)&&($mm>"02")){
		$dayofyear=$day+$dd+1;
	}else{
		$dayofyear=$day+$dd;
	}
	
	return $dayofyear;
}

function SerialDate($startdate,$enddate){
	$startyear=substr($startdate,0,4);
	$endyear=substr($enddate,0,4);
	$startdayofyear=dayofyear($startdate);
	$enddayofyear=dayofyear($enddate);
	if ($startyear<>$endyear){
		for ($i==$startyear;$i<=$endyear;$i++){
				if (($i%4)==0){
					$day=366;
				}else{
					$day=365;
				}
				if ($i==$startyear){
					$day=$day - $startdayofyear;
				}
				if ($i==$endyear){
					$day=$enddayofyear;
					$num=$num+$day;
				}
		}
	}else{
		$num=$enddayofyear - $startdayofyear;
	}
	
	return $num;
}

Function Datediff($datefrom,$dateto)      {
         $startDate = strtotime($datefrom);
         $lastDate = strtotime($dateto);
        
        $differnce = $lastDate - $startDate;

//        $differnce = (($differnce / (60*60*24)) + 1); //กรณืที่ต้องการให้ return ค่าเป็นวันนะครับ

        return $differnce;
}

function ThaiDateTime($date){
$longname=array("01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","0
8"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");

	$yy=substr($date,0,4);
	$mm=substr($date,5,2);
	$dd=substr($date,8,2);
	$time=substr($date,11,8);
	
	$yy+=543;
	$thaidate=intval($dd)." ".$longname[$mm]." ".$yy."&nbsp;&nbsp;&nbsp;".$time;
	
	return $thaidate;
}

function getDateTime($date){
$longname=array("01"=>"ม.ค.","02"=>"ก.พ.","03"=>"มี.ค.","04"=>"เม.ย.","05"=>"พ.ค.","06"=>"มิ.ย.","07"=>"ก.ค.","0
8"=>"ส.ค.","09"=>"ก.ย.","10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");

	$yy=substr($date,0,4);
	$mm=substr($date,5,2);
	$dd=substr($date,8,2);
	$time=substr($date,11,8);
	
	$yy+=543;

   if (($mm=="00") or ($mm=="0")){
      $thaidate="-";
   }else{
	$thaidate=intval($dd)." ".$longname[$mm]." ".$yy."&nbsp;&nbsp;&nbsp;".$time;
	}	
	
	return $thaidate;
}

function ThaiLongDate($date){
$longname=array("01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","0
8"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");

	$yy=substr($date,0,4);
	$mm=substr($date,5,2);
	$dd=substr($date,8,2);
	
	$yy+=543;
	$thailongdate=intval($dd)." ".$longname[$mm]." ".$yy;
	
	return $thailongdate;
}

function ThaiShortDate($date){
$shortname=array("01"=>"ม.ค.","02"=>"ก.พ.","03"=>"มี.ค.","04"=>"เม.ย.","05"=>"พ.ค.","06"=>"มิ.ย.","07"=>"ก.ค.","08"=>"ส.ค.","09"=>"ก.ย.",
"10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");

	$yy=substr($date,0,4);
	$mm=substr($date,5,2);
	$dd=substr($date,8,2);

	$yy+=543;

   if (($mm=="00") or ($mm=="0")){
      $thaishortdate="-";
   }else{
	
	$thaishortdate=intval($dd)." ".$shortname[$mm]." ".$yy;

	}	

	return $thaishortdate;
}

function  CheckForm($formdata){
	foreach($formdata as $key => $value){
		if (! isset($key) or $value==""){
			return false;
		}else{
			return true;
		}
	}
}

function  CheckAdmin($admin){
		switch ($admin){
			case 1:
				$admin="admin";
				break;
			case 2:
				$admin= "user";
				break;
			case 3:
				$admin= "guest";
				break;
			}
	return $admin;
}

function ThaiDate($date){
$shortname=array("01"=>"ม.ค.","02"=>"ก.พ.","03"=>"มี.ค.","04"=>"เม.ย.","05"=>"พ.ค.","06"=>"มิ.ย.","07"=>"ก.ค.","08"=>"ส.ค.","09"=>"ก.ย.",
"10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");

	$yy=substr($date,0,4);
	$mm=substr($date,5,2);
	$dd=substr($date,8,2);
	
   if (($mm=="00") or ($mm=="0")){
      $thaidate="-";
   }else{
      $thaidate=intval($dd)." ".$shortname[$mm]." ".$yy;
   }	
	return $thaidate;
}

function ThaiMonth($m){
$longname=array("01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม",
	"08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");

	$thaimonth=$longname[$m];
	
	return $thaimonth;
}

function today(){

$w=array("1"=>"จันทร์","2"=>"อังคาร","3"=>"พุธ","4"=>"พฤหัสบดี","5"=>"ศุกร์","6"=>"เสาร์","0"=>"อาทิตย์");
$m=array("01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิง
หาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");

$today="วัน" . $w[date("w")] . "ที่ " . (date("j")) . " " . $m[date("m")] . "  " . (date("Y")+543) . " เป็นสัปดาห์ที่ " . (date("W")) . " ของปี";

return $today;

}

function RegisterFormat($id){
	$str1=substr($id,0,1);
	$str2=substr($id,1,3);
	$str3=substr($id,4,2);
	$str4=substr($id,6,1);
	$str5=substr($id,7,3);

	$registerformat = $str1 . "-" . $str2 . "-" . $str3 . "-" . $str4 . "-" . $str5;
	return $registerformat;

}

function sectionname($id){
		switch ($id){
			case "10":
				$sectionname="กลุ่มพัฒนาภาคีเครือข่าย";
				$nickname="กลุ่มเครือข่ายฯ";
				break;
			case "20":
				$sectionname="กลุ่มพัฒนาวิชาการ";
				$nickname="กลุ่มวิชาการฯ";
				break;
			case "21":
				$sectionname="งานชันสูตรโรค";
				$nickname="LAB";
				break;
			case "30":
				$sectionname="กลุ่มสื่อสารความเสี่ยง";
				$nickname="กลุ่มสื่อสารฯ";		
				break;
			case "40":
				$sectionname="กลุ่มระบาดวิทยาและข่าวกรอง";
				$nickname="กลุ่มระบาดฯ";		
				break;
			case "50":
				$sectionname="กลุ่มแผนงานและประเมินผล";
				$nickname="กลุ่มแผนฯ";		
				break;
			case "60":
				$sectionname="กลุ่มพัฒนาองค์กร";
				$nickname="กลุ่มพัฒน์ฯ";		
				break;
			case "70":
				$sectionname="กลุ่มปฏิบัติการควบคุมและตอบโต้ภาวะฉุกเฉิน";
				$nickname="กลุ่มปฏิบัติการฯ";		
				break;
			case "71":
				$sectionname="ศูนย์ควบคุมโรคติดต่อนำโดยแมลงที่ 6.1 ขอนแก่น";
				$nickname="ศตม.6.1";		
				break;
			case "72":
				$sectionname="ศูนย์ควบคุมโรคติดต่อนำโดยแมลงที่ 6.2 อุดรธานี";
				$nickname="ศตม.6.2";		
				break;
			case "73":
				$sectionname="ศูนย์ควบคุมโรคติดต่อนำโดยแมลงที่ 6.3 เลย";
				$nickname="ศตม.6.3";		
				break;
			case "80":
				$sectionname="กลุ่มบริหารงานทั่วไป";
				$nickname="กลุ่มบริหารฯ";		
				break;
			case "81":
				$sectionname="งานธุรการ";
				$nickname="ธุรการ";		
				break;
			case "82":
				$sectionname="งานการเจ้าหน้าที่";
				$nickname="งานการเจ้าหน้าที่";		
				break;
			case "83":
				$sectionname="งานการเงินและบัญชี";
				$nickname="การเงินฯ";		
				break;
			case "84":
				$sectionname="งานพัสดุอาคารสถานที่";
				$nickname="พัสดุฯ";		
				break;
			case "85":
				$sectionname="งานยานพาหนะ";
				$nickname="ยานฯ";		
				break;
			case "99":
				$sectionname="หน่วยงานอื่น";
				$nickname="หน่วยงานอื่น";		
				break;
		}

	return $sectionname; 

}

function adddate($dat){
   $yy=substr($dat,0,4);
   $mm=substr($dat,5,2);
   $dd=substr($dat,8,2);

   $dd+=1;
   $adddate=$yy. "-" .$mm. "-" .$dd;
	
   return $adddate;
}


function local($folderid){
	$result=mysql_query("select location from folder where folderid='$folderid' ");
	$row=mysql_fetch_array($result);
		$location=$row["location"];

	return $location;
}

function dbname($datno){
	switch ($datno){
		case 1 :
			$datname="ฐานข้อมูลยุทธศาสตร์ นโยบาย กฎหมาย และระเบียบคำสั่ง";
			break;
		case 2 :
			$datname="ฐานข้อมูลแผนงาน/โครงการ";
			break;
		case 3 :
			$datname="ฐานข้อมูลศึกษา วิจัย พัฒนาองค์ความรู้";
			break;
		case 4 :
			$datname="ฐานข้อมูลถ่ายทอดองค์ความรู้";
			break;
		case 5 :
			$datname="ฐานข้อมูลเฝ้าระวังป้องกันควบคุมโรค";
			break;
		case 6 :
			$datname="ฐานข้อมูลสนับสนุนการดำเนินงาน (งานบริหารทั่วไป)";
			break;
		case 7 :
			$datname="ฐานข้อมูลเครือข่ายหน่วยงานองค์กรที่เกี่ยวข้อง/ผู้เชี่ยวชาญ";
			break;
		case 8 :
			$datname="ฐานข้อมูลนิเทศ ติดตาม ประเมินผล";
			break;
	}

	return $datname;

}

function sectionpath($sectionid){

	switch ($sectionid ){
		case "1" :
			$sectionpath="../psofiles/Administrative/";
			break;
		case "2" :
			$sectionpath="../psofiles/Technic Support/";
			break;
		case "3" :
			$sectionpath="../psofiles/General Communicable Disease/";
			break;
		case "4" :
			$sectionpath="../psofiles/STD AIDS Lep TB/";
			break;
		case "5" :
			$sectionpath="../psofiles/EPIDEMIOLOGY/";
			break;
		case "6" :
			$sectionpath="../psofiles/Vector Born Disease Center/";
			break;
		case "7" :
			$sectionpath="../psofiles/Non Communicable Disease/";
			break;
		case "8" :
			$sectionpath="../psofiles/Environment Occupat/";
			break;
			
	}

	return $sectionpath;

}


function randigit(){
   srand((double)microtime()*1000000); 
   $random_digit ="";

   for($i=0; $i<6; $i++) { 
	   $random_digit .= rand(0,9); 
   } 

	return $random_digit;

}

function checkID($id) {
	if (is_numeric($id)){			//	 ตรวจสอบว่าต้องเป็นตัวเลขเท่านั้น
		if (strlen($id)==13) {		//	 ตรวจสอบว่าต้องเป็น 13 หลักเท่านั้น
//			if ((substr($id, 1, 2) >=38) and (substr($id, 1, 2) <=46))	{		//		ตรวจสอบว่าอยู่ในเขตพื้นที่รับผิดชอบหรือไม่
				$_1 =substr($id,0,1) *13	;
				$_2 =substr($id,1,1) *12	;
				$_3 =substr($id,2,1) *11	;
				$_4 =substr($id,3,1) *10	;
				$_5 =substr($id,4,1) *9		;
				$_6 =substr($id,5,1) *8		;
				$_7 =substr($id,6,1) *7		;
				$_8 =substr($id,7,1) *6		;
				$_9 =substr($id,8,1) *5		;
				$_10 =substr($id,9,1) *4	;
				$_11 =substr($id,10,1) *3	;
				$_12 =substr($id,11,1) *2	;
				$thirteen =substr($id, 12, 1);

				$_sum =$_1+ $_2+ $_3+ $_4+ $_5+ $_6+ $_7+ $_8+ $_9+ $_10+ $_11+ $_12	;
				$_mod =$_sum % 11;

				if ($_mod <=1){
					$_13 =1-$_mod;
				}else{
					$_13 =11-$_mod;
				}

				if ($thirteen==$_13){
					return true;
				}else{
					return false;
				}

//			}else{
//				return false;
//			}
		}else{
			return false;
		}

	}else{
		return false;	
	}

}

function calage($pbday){
	if ($pbday=="0000-00-00" or $pbday==NULL){
		$your_age ="-";
	}else{
		$today = date("Y-m-d");
		list($byear , $bmonth , $bday) = explode("-" , $pbday);
		list($tyear , $tmonth , $tday) = explode("-" , $today);

		$byear =$byear;		//ถ้า ปี พ.ศ.ให้ ลบด้วย 543
		if ($byear < 1970){
			$yearad =1970 - $byear;
			$byear =1970;
		}else{
			$yearad = 0;}
	 
			$mbirth = mktime(0,0,0,$bmonth,$bday,$byear);
			$mnow = mktime(0,0,0,$tmonth,$tday,$tyear);

			$mage= ($mnow - $mbirth);
			$your_age = (date("Y",$mage)-1970 + $yearad)." ปี " . (date("m", $mage)-1) ." เดือน " . (date("d", $mage)-1) ." วัน" ; 
	}	
	return($your_age);
}

function retireday($birthday){
	if ($birthday=="0000-00-00"){
		$_retireday ="-";
	}else{
		$_byear =substr($birthday,0,4);
		$_bmonth =substr($birthday,5,2);

		if ($_bmonth=="10" or $_bmonth=="11" or $_bmonth=="12"){
				$_retireday ="1  ตุลาคม " . ($_byear + 61);
		}else{
				$_retireday ="1  ตุลาคม " . ($_byear + 60);	
		}
	}

	return $_retireday;

}


function TestSearch($_idcard){

$sql_person =mysql_query("select * from test where idcard='$_idcard'	");
$num_rows =mysql_num_rows($sql_person);

return $num_rows;

}

function getExtension($str) {
	 $i = strrpos($str,".");
	 if (!$i) { return ""; }
	 $l = strlen($str) - $i;
	 $ext = substr($str,$i+1,$l);
	 return $ext;
}












?>