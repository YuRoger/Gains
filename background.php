<?php
require_once 'app/Mage.php';

if (!Mage::isInstalled()) {
    echo "Application is not installed yet, please complete install wizard first.";
    exit;
}

// Only for urls
// Don't remove this
$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);

Mage::app('admin')->setUseSessionInUrl(false);

try {
    Mage::getConfig()->init();
	$general_customer=Mage::getModel('customer/customer')->getCollection()
	->addAttributeToSelect( '*' )
	->addAttributeToFilter('group_id','1')// only load general customer
	->load();
	$birthday_customer=new ArrayObject();
	$order_annual_customer=new ArrayObject();
	$order_annual_purchase_date=new ArrayObject();
	//iterate all customers
	foreach($general_customer as $c){
var_dump ($c->getData());
		if(is_birthday_alert($c)){
			$birthday_customer->append($c);
		}
		$first_order_date=is_order_annual($c);
		if($first_order_date){
			$order_annual_customer->append($c);
			$order_annual_purchase_date->append($first_order_date);
		}
		if(count($birthday_customer)>0 || count($order_annual_customer)>0){
			sendMailtoAdmin($birthday_customer,$order_annual_customer,$order_annual_purchase_date);
		}
	}
	print "Backend Check successful";
    
} catch (Exception $e) {
    Mage::printException($e);
	print "Backend Check fail";
}
//check if today is 7 days before a customer's birthday
function is_birthday_alert($customer){
	if($customer->getData('dob')){
		$today_mon=date('m');
		$today_mday=date('d');
		$dob=$customer->getData('dob');
		$dob_date = strtotime($dob);
//echo date_format($dob_date, 'Y-m-d');
		$inform_date=$dob_date-60*60*24*7;
		$inform_mon=date('m',$inform_date);
		$inform_mday=date('d',$inform_date);
//print $inform_mon;
//print $inform_mday;
		return $inform_mon==$today_mon && $inform_mday==$today_mday ;
	}else{
		return false;
	}

}
 //check if today is 7 days before a customer's first order 's anniversry
function is_order_annual($customer){
	$today_year=date('y');
	$today_mon=date('m');
	$today_mday=date('d');
	$customer_id=$customer->getData('entity_id');
	//get first order 
	$orders=Mage::getModel('sales/order')->getCollection()
	->addAttributeToSelect( '*' )
	->addAttributeToFilter('status','complete')// only load complete 
	->addAttributeToFilter('customer_id',$customer_id)// only load complete 
	->addAttributeToSort('created_at')
	->load();
	$first_order=$orders->getFirstItem();
	if($first_order){
//var_dump ($first_order->getData());
		$first_order_date = strtotime($first_order->getData('created_at'));
		$inform_date=$first_order_date-60*60*24*7;
		$inform_mon=date('m',$inform_date);
		$inform_mday=date('d',$inform_date);
		$inform_year=date('y',$inform_date);
//print $inform_mon==$today_mon && $inform_mday==$today_mday && ((int)$today_year)>((int)$inform_year);
		if($inform_mon==$today_mon && $inform_mday==$today_mday && ((int)$today_year)>((int)$inform_year)){
			return $first_order_date;
		} else{
			return false;
		}
		
	} else{
//print "no";
		return false;
	}
}
function sendMailtoAdmin($birthday_customer_arrays,$order_annual_customer_arrays,$order_annual_purchase_date){
	$mail = new Zend_Mail();
	$mail->setFrom('non_reply_backend@gainsboroughhome.com');
	$mail->addTo('john_c_cooper2005@hotmail.com', 'admin');
	$mail->setSubject('customer birthday and first order anniversary alert');
	if(count($birthday_customer_arrays)>0){
		$birthdayTable=generateBirthdayAlertHtml($birthday_customer_arrays);
//print $birthdayTable;
	}
	if(count($order_annual_customer_arrays)>0){
		$purchaseTable=generateFirstPurchaseAlertHtml($order_annual_customer_arrays,$order_annual_purchase_date);
//print $purchaseTable;
	}
	$mail->setBodyHtml($birthdayTable."<br/>".$purchaseTable);
	$mail->send();
	print "send successful<br/>";
}
function generateBirthdayAlertHtml($birthday_customer_arrays){
	$birthday=time()+60*60*24*7;
	$result="This is a list of customers whose birthday will be on ".date('Y-m-d',$birthday)."<br/>" ;
	$result.=
" <TABLE border=1 id='birthdaytable'>
  <TR>
	<TH>customer_id</TH>
	<TH>customer_name</TH>
	<TH>customer_email</TH>
  </TR>
";
	foreach($birthday_customer_arrays as $customer){
		$result.="<TR>";
		$result.="<TD>".$customer->getData('entity_id')."</TD>";
		$result.="<TD>".$customer->getName()."</TD>";
		$result.="<TD>".$customer->getData('email')."</TD>";
		$result.="</TR>";
	}
	$result.="</TABLE>";
	return $result;
}

function generateFirstPurchaseAlertHtml($order_annual_customer_arrays,$order_annual_purchase_date){
	$annual_day=time()+60*60*24*7;
	$result="This is a list of customers whose first purchase on annuiversary will be on ".date('Y-m-d',$annual_day)."<br/>" ;
	$result.=
" <TABLE border=1 id='purcharsetable'>
  <TR>
	<TH>customer_id</TH>
	<TH>customer_name</TH>
	<TH>customer_email</TH>
	<TH>first_purchase_date</TH>
  </TR>
";
	for($i=0;$i<$order_annual_customer_arrays->count();$i++){
		$customer=$order_annual_customer_arrays->offsetGet ($i);
		$result.="<TR>";
		$result.="<TD>".$customer->getData('entity_id')."</TD>";
		$result.="<TD>".$customer->getName()."</TD>";
		$result.="<TD>".$customer->getData('email')."</TD>";
		$result.="<TD>".date('Y-m-d',$order_annual_purchase_date->offsetGet($i))."</TD>";
		$result.="</TR>";
	}
	$result.="</TABLE>";
	return $result;
}
