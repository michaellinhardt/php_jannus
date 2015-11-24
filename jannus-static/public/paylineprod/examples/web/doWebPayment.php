<?php
// INITIALIZE
require_once("../../include.php");
$array = array();
$payline = new paylineSDK();

// PAYMENT
$array['payment']['amount'] = $_POST['amount'];
$array['payment']['currency'] = $_POST['currency'];

// ORDER
$array['order']['ref'] = $_POST['ref'];
$array['order']['amount'] = $_POST['amount'];
$array['order']['currency'] = $_POST['currency'];


// CONTRACT NUMBERS
if (isset($_POST['paymentContractNumber'])){
	$contracts = explode(";",$_POST['paymentContractNumber']);
	$array['contracts'] = $contracts;
}

// EXECUTE
$result = $payline->do_webpayment($array);

// RESPONSE
if(isset($_POST['debug'])){
	require('../demos/result/header.html');
	echo '<H3>REQUEST</H3>';
	print_a($array, 0, true);
	echo '<H3>RESPONSE</H3>';
	print_a($result, 0, true);
	require('../demos/result/footer.html');
}
else{
	if(isset($result) && $result['result']['code'] == '00000'){
		header("location:".$result['redirectURL']);
		exit();
	}
	elseif(isset($result)) {
	echo 'ERROR : '.$result['result']['code']. ' '.$result['result']['longMessage'].' <BR/>';
	}

}
?>
