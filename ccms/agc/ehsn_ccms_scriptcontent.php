<?php
	session_start();
	//var_dump($_SESSION);exit;
	include("./ehsn_et1_config.php");

	$pre_url	= $_SESSION['et1url'];

	$option_type		= $_GET['OptionType'];
	$option_value		= $_GET['OptionValue'];
	$phone_type			= $_GET['PhoneType'];
	$area_code_YN		= $_GET['AreaCode_YN'];
	$item_id			= $_GET['ItemID'];

	$pre_url_bak= "http://10.201.209.204/AgentID";

	$userloginid	= $_GET['userloginid'];
	$dn				= $_GET['dn'];
	$vdn			= $_GET['vdn'];
	$ivrpath		= $_GET['ivrpath'];
	$ani			= $_GET['ani'];
	$connid			= $_GET['connid'];
	$contacttype	= $_GET['contacttype'];
	
	$phone_number	= $ani;

	$phone_len		= strlen($phone_number);
	// 手机号码如果是0开头，将0去掉
	if($phone_len == 12 && substr($phone_number,0,2) == '01'){
		$phone_number = substr($phone_number,1,strlen($phone_number));
		$phone_len		= strlen($phone_number);
	}

	$leadphone = $phone_number;


	$phone_key = getPhoneCode($phone_number);
	if($phone_key != "0"){
		$phone_key_code  = $phone_key[0];
		$phone_key_phone = $phone_key[1];
		$phone_len		= strlen($phone_key_phone);
		
		$phone_key = "1";
	}

	$insert_history		= $pre_url."/insertContactHistory.".$_SESSION['etlsuffix']."?userloginid=$userloginid&dn=$dn&vdn=$vdn&ivrpath=$ivrpath&ani=$ani&connid=$connid&contacttype=$contacttype";
	//echo $insert_history;
	$insert_history_bak	= $pre_url_bak."/insertContactHistory.asp?userloginid=$userloginid&dn=$dn&vdn=$vdn&ivrpath=$ivrpath&ani=$ani&connid=$connid&contacttype=$contacttype";
	$greeting_url	= $pre_url."/getGreetingbyANI.".$_SESSION['etlsuffix']."?ani=$ani&ivrpath=$ivrpath";
	$greeting_url_bak	= $pre_url_bak."/getGreetingbyANI.asp?ani=$ani&ivrpath=$ivrpath";
//	echo $greeting_url."<hr>";

function getPhoneCode($phone){
	$phonecode = array('010','021','020','022','023','852','853','0310','0311','0312','0313','0314','0315','0316','0317','0318','0319','0335','0570','0571','0572','0573','0574','0575','0576','0577','0578','0579','0580','024','0410','0411','0412','0413','0414','0415','0416','0417','0418','0419','0421','0427','0429','027','0710','0711','0712','0713','0714','0715','0716','0717','0718','0719','0722','0724','0728','025','0510','0511','0512','0513','0514','0515','0516','0517','0517','0518','0519','0523','0470','0471','0472','0473','0474','0475','0476','0477','0478','0479','0482','0483','0790','0791','0792','0793','0794','0795','0796','0797','0798','0799','0701','0350','0351','0352','0353','0354','0355','0356','0357','0358','0359','0930','0931','0932','0933','0934','0935','0936','0937','0938','0941','0943','0530','0531','0532','0533','0534','0535','0536','0537','0538','0539','0450','0451','0452','0453','0454','0455','0456','0457','0458','0459','0591','0592','0593','0594','0595','0595','0596','0597','0598','0599','020','0751','0752','0753','0754','0755','0756','0757','0758','0759','0760','0762','0763','0765','0766','0768','0769','0660','0661','0662','0663','028','0810','0811','0812','0813','0814','0816','0817','0818','0819','0825','0826','0827','0830','0831','0832','0833','0834','0835','0836','0837','0838','0839','0840','0730','0731','0732','0733','0734','0735','0736','0737','0738','0739','0743','0744','0745','0746','0370','0371','0372','0373','0374','0375','0376','0377','0378','0379','0391','0392','0393','0394','0395','0396','0398','0870','0871','0872','0873','0874','0875','0876','0877','0878','0879','0691','0692','0881','0883','0886','0887','0888','0550','0551','0552','0553','0554','0555','0556','0557','0558','0559','0561','0562','0563','0564','0565','0566','0951','0952','0953','0954','0431','0432','0433','0434','0435','0436','0437','0438','0439','0440','0770','0771','0772','0773','0774','0775','0776','0777','0778','0779','0851','0852','0853','0854','0855','0856','0857','0858','0859','029','0910','0911','0912','0913','0914','0915','0916','0917','0919','0971','0972','0973','0974','0975','0976','0977','0890','0898','0899','0891','0892','0893');

	for($i=0;$i<count($phonecode);$i++){
		if(substr($phone,0,strlen($phonecode[$i])) == $phonecode[$i]){
			return array($phonecode[$i],substr($phone,strlen($phonecode[$i]),strlen($phone)-strlen($phonecode[$i])));
		}else{
			
		}
	}
	return "0";
}
#######################################ehsn.php php code end###################################

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/javascript" src="./common.js"></script>
<script language="JavaScript" type="text/javascript" src="./general.js"></script>
<script language="javascript">
function killErrors(){
return true;
}
window.onerror = killErrors;
</script>
<script language="JavaScript" type="text/javascript">


function slect_phone()
{
	SystemModalDialog2('slect_phone_number.php',700,220);
}

function checkData(form)
{
	with(form)
	{
		ECHOSOFT.Http.upload(id,fnCallBack);
	}
}

function fnCallBack(pNode)
{
	var pRetXml = ECHOSOFT.Dom.actionReturnXml(pNode);
	alert(pRetXml.sContent);
	if(pRetXml.iFlag == 1)
	{
		window.close();
	}
}
function startCall( ){
	//alert(callid);
	if ( (parent.AutoDialWaiting == 1) || (parent.VD_live_customer_call==1) || (parent.alt_dial_active==1) || (parent.MD_channel_look==1) )
	{
			//alert("YOU MUST BE PAUSED TO MANUAL DIAL A NEW LEAD IN AUTO-DIAL MODE");
			alert("在暂停状态下才可外拨！");
			return false;
	}
	var callnum = document.getElementById('phone_num').value;
	//alert(callnum);
	if(callnum == ""){
		alert("请输入手机号码！");
		return false;
	}
	parent.document.vicidial_form.MDPhonENumbeR.value = callnum;
	parent.NeWManuaLDiaLCalLSubmiT("NEW");
}
function startCall2( ){
	//alert(callid);
	//取消提示，直接关闭
	/*
	if ( (parent.AutoDialWaiting == 1) || (parent.VD_live_customer_call==1) || (parent.alt_dial_active==1) || (parent.MD_channel_look==1) )
	{
			//alert("YOU MUST BE PAUSED TO MANUAL DIAL A NEW LEAD IN AUTO-DIAL MODE");
			alert("在暂停状态下才可外拨");
			return false;
	}
	*/
	var callnum = document.getElementById('phone_value2').value;
	//alert(callnum);
	
	if(callnum == ""){
		alert("请输入电话号码！");
		return false;
	}
	var isNum = isNumber(callnum);
	if(!isNum){
		alert("电话号码必须为数字！");
		return false;
	}
	parent.document.vicidial_form.MDPhonENumbeR.value = callnum;
	parent.NeWManuaLDiaLCalLSubmiT("NEW");
}
function isNumber(oNum) 
{ 
  if(!oNum) return false; 
  var strP=/^\d+(\.\d+)?$/; 
  if(!strP.test(oNum)) return false; 
  try{ 
  if(parseFloat(oNum)!=oNum) return false; 
  } 
  catch(ex) 
  { 
   return false; 
  } 
  return true; 
}

</script>

<title>Manual Dial</title>
</head>
<body>

<!--ensn.php html code start-->

<script language="JavaScript" type="text/javascript">

var phone = '<?=$phone_number?>';
var phone_len = '<?=$phone_len?>';
var phone_key = '<?=$phone_key?>';
var insert_history = '<?=$insert_history?>'

//清空C:/CConnector/目录
getEnum("C:/CConnector/",0);
function create_file(cid)
{
	//alert("hello");
	
	
	var fso, f1,fpath,ts;
	fso = new ActiveXObject("Scripting.FileSystemObject");
	if(cid == 0){
		if(phone_key == '0')
		{
			if(!fso.FileExists("C:/CConnector/" + "p;"+ phone + ";" + phone_len))
			{
				f1 = fso.CreateTextFile("C:/CConnector/" + "p;"+ phone + ";" + phone_len ,true);
			}
			//fpath = "C:/CConnector/" + "p;"+ phone + ";" + phone_len;
		}
		else
		{
			if(!fso.FileExists("C:/CConnector/" + "p;<?= $phone_key_phone ?>;" + phone_len + ";<?= $phone_key_code ?>"))
			{
				f1 = fso.CreateTextFile("C:/CConnector/" + "p;<?= $phone_key_phone ?>;" + phone_len + ";<?= $phone_key_code ?>" ,true);
			//fpath = "C:/CConnector/" + "p;"+ phone + ";" + phone_len + ";" + phone_key;
			}
		}
	}else{
		
		if(!fso.FileExists("C:/CConnector/" + "c;"+ cid))
		{
			f1 = fso.CreateTextFile("C:/CConnector/" + "c;"+ cid ,true);
		}
		//fpath = "C:/CConnector/" + "c;"+ cid;
	}
	f1.Close();
}
function getEnum(srcFolder,enumType)   
{   
    var fs,f,fc,fd;   
    srcFolder=srcFolder.replace(/\\/g,'\\\\');   
    fs=new ActiveXObject("Scripting.FileSystemObject");   
    f=fs.GetFolder(srcFolder);   
    fc=new Enumerator(enumType==0? f.Files: f.SubFolders);   
    for (;!fc.atEnd();fc.moveNext())   
    {   
       fc.item().Delete();   
    }   
    if(f.SubFolders.Count!==0){   
        fd=new Enumerator(f.SubFolders);   
        for(; !fd.atEnd(); fd.moveNext()){   
            getEnum(fd.item()+'',enumType);   
        }   
    }   
}
</script>
<title>web form</title>
</head>

<body>
<?php
	function insert_history($url,$insert_history_bak) 
	{
		//echo $url."<hr>";//file
		//echo "bbbbbbbbbbbbb".$url."bbbbbbbbbbbbb";
		$arr_job	= @file($url);
		//var_dump($arr_job);
		if(!$arr_job){
			$arr_job	=@file($insert_history_bak);
		}

		$contactid	= $arr_job[11];
		$contactid = str_replace("<CONTACTID>", "", $contactid);
		$contactid = str_replace("</CONTACTID>", "", $contactid);
		//echo $contactid;
		$_SESSION['contactid'] = trim($contactid);
//		print_r($arr_job);
//		echo "---------<hr>"; 
		//echo date("Y-m-d H:i:s")."----".rand(10,100);
	}
	if(!empty($connid) && $_SESSION['connid'] != $connid){
		//鏂板涓€涓鎴疯仈绯诲巻鍙茬邯褰?
		
		
			insert_history($insert_history,$insert_history_bak);
			$_SESSION['connid'] = $connid;
		
		//鑾峰彇闂€欒
		$arr_greeting	= @file($greeting_url);
		//var_dump($arr_greeting);
		if(!$arr_greeting){
				$arr_greeting	=@file($greeting_url_bak);
		}
		$xml_value		=  $arr_greeting[12];
		//echo $xml_value;
		$greeting_str	= str_replace("<CUSTOMERID>", "", "$xml_value");
		$greeting_str	= str_replace("</GREETING>", "", "$greeting_str");
	//	$greeting_str	= str_replace("</CUSTOMERID><GREETING>", ",", "$greeting_str");

		$arr_greeting_value	= explode('</CUSTOMERID><GREETING>',$greeting_str);
		$customerid		= $arr_greeting_value[0];
		//var_dump($customerid);
		if(empty($customerid)){
			$cid = 0;
		}else{
			$cid = $customerid;
		}
		if(!empty($ani)){
			echo "<script>";
			echo "create_file(".$cid.");";
			echo "</script>";
		}
		$greeting		= $arr_greeting_value[1];
	//	echo 'CUSTOMERID: ',$customerid,"\n<hr>";
	//	echo 'greeting: ',  $greeting,"\n<hr>";

		
		$_SESSION['customerid'] = $customerid;
		
		$contactid = $_SESSION['contactid'];
		$update_history_url = $pre_url."/updateContactHistory.".$_SESSION['etlsuffix']."?contactid=$contactid&actioncode=1&customerid=$customerid";
		//echo $update_history_url;
		$update_history_url_bak = $pre_url_bak."/updateContactHistory.asp?contactid=$contactid&actioncode=1&customerid=$customerid";
	//		echo $update_history_url."<hr>";//file
		$arr_job	=@file($update_history_url);
		if(!$arr_job){
			$arr_job	=@file($update_history_url_bak);
		}
		$_SESSION['greeting']	= $greeting;
		$_SESSION['greetingtmp']	= $greeting;
	}
	//Inbount第二次访问页面时执行创建文件操作
	if($_SESSION['connid'] == $connid && !empty($_SESSION['greetingtmp']) && !empty($ani) ){
		$customerid = $_SESSION['customerid'];
		if(empty($customerid)){
			$cid = 0;
		}else{
			$cid = $customerid;
		}
		echo "<script>";
		echo "create_file(".$cid.");";
		echo "</script>";
	}
?>
<style>
.script_content_input{border:1px #676767 solid; color:#C00; text-align:left; padding-left:2px; height:20px; padding-top:5px;}
.script_content_form{padding:0px 0px; margin:0px 0px; text-align:left; vertical-align:top;}
.script_content_form table.main_tb{ font-size:13px; color:#C00; border:1px solid #F0C515;}
.script_content_form table.main_tb tr{line-height:22px; height:25px;}
.script_content_form table.main_tb td{text-align:left; background:#FAE6A0; vertical-align:top;}
.btn3_mouseout { 
BORDER-RIGHT: #2C59AA 1px solid; PADDING-RIGHT: 2px; BORDER-TOP: #2C59AA 1px solid; PADDING-LEFT: 2px; FONT-SIZE: 12px; FILTER: progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#ffffff, EndColorStr=#C3DAF5); BORDER-LEFT: #2C59AA 1px solid; CURSOR: hand; COLOR: black; PADDING-TOP: 2px; BORDER-BOTTOM: #2C59AA 1px solid 
} 
.btn3_mouseover { 
BORDER-RIGHT: #2C59AA 1px solid; PADDING-RIGHT: 2px; BORDER-TOP: #2C59AA 1px solid; PADDING-LEFT: 2px; FONT-SIZE: 12px; FILTER: progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#ffffff, EndColorStr=#D7E7FA); BORDER-LEFT: #2C59AA 1px solid; CURSOR: hand; COLOR: black; PADDING-TOP: 2px; BORDER-BOTTOM: #2C59AA 1px solid 
} 
.btn3_mousedown 
{ 
BORDER-RIGHT: #FFE400 1px solid; PADDING-RIGHT: 2px; BORDER-TOP: #FFE400 1px solid; PADDING-LEFT: 2px; FONT-SIZE: 12px; FILTER: progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#ffffff, EndColorStr=#C3DAF5); BORDER-LEFT: #FFE400 1px solid; CURSOR: hand; COLOR: black; PADDING-TOP: 2px; BORDER-BOTTOM: #FFE400 1px solid 
} 
.btn3_mouseup { 
BORDER-RIGHT: #2C59AA 1px solid; PADDING-RIGHT: 2px; BORDER-TOP: #2C59AA 1px solid; PADDING-LEFT: 2px; FONT-SIZE: 12px; FILTER: progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#ffffff, EndColorStr=#C3DAF5); BORDER-LEFT: #2C59AA 1px solid; CURSOR: hand; COLOR: black; PADDING-TOP: 2px; BORDER-BOTTOM: #2C59AA 1px solid 
} 
</style>

<!--ensn.php html code end-->

<form  class="script_content_form" id="form" action="A_ehsn_finish.php"  name="logging" method='POST' onSubmit="return checkData(this)">

<table class="main_tb" width="100%" height="450px" border="0"  cellpadding="1" cellspacing="1" align="left">
  <tr>
    <td>
    <?php if(!empty($connid)){ echo iconv("gbk", "UTF-8", $_SESSION['greeting']); } //,"\n<hr>";?>
    </td>
  </tr>
  <tr>
    <td width="100%"> 
    <table width="100%">
     <Tr>
       <Td style="border:none;"><input class="script_content_input" size="18" maxlength="13" name="phone_value" type="text" id="phone_value" value="点击此处进行客户查询"  readonly="readonly" style="background-color:#eee; cursor:pointer;" onclick="slect_phone();"/> 
       </Td>
     </Tr>
     <tr>
      <td style="border:none;" width="100%">
      <button  class="btn3_mouseout" onmouseover="this.className='btn3_mouseover'" onmouseout="this.className='btn3_mouseout'" onmousedown="this.className='btn3_mousedown'" onClick="startCall()"  onmouseup="this.className='btn3_mouseup'" title="查询外拨">查询外拨</button> 
      </td>
     </tr>
    </table>
    
    
    <br/>
    <table width="100%">
      <Tr>
        <td style="border:none;">
        <input type="hidden" name="phone_num" id="phone_num" value="" />
    <input class="script_content_input" name="phone_value2" type="text" size="18" maxlength="13" id="phone_value2" value="" />
        </td>
      </Tr>
      <tr>
       <td style="border:none;">
       <button class="btn3_mouseout" onmouseover="this.className='btn3_mouseover'" onmouseout="this.className='btn3_mouseout'" onmousedown="this.className='btn3_mousedown'" onClick="startCall2()"  onmouseup="this.className='btn3_mouseup'" title="手动外拨">手动外拨</button> 
       </td>
      </tr>
    </table>
    
   
  <!--  <a href="../joomlaehsn/"  target="_blank" style="font-size:13px;">转到知识库</a>-->
    </td>
  </tr>
</table>
</form>
</body>
</html>