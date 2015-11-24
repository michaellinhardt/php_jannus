<?php 
	session_start();
	
	ini_set('display_errors', 1);
	
	require_once ('include.php');
	
	$array = array();
	$payline = new paylineSDK(dirname(__FILE__)."/");
	
	$month = 0;
	$first_amount = 1000;
	$all_amount = 10000;
	$date_end = "";

	// RECCURENT
	$array['order']['amount'] = (int)($all_amount); // Montant
	$array['order']['taxes'] = (int)($all_amount * 0.196); // SOMME * 0,195
	$array['recurring']['firstAmount'] = (int)($first_amount);
	$array['recurring']['amount'] = (int)(1000);
	$array['recurring']['billingCycle'] = 10;
	$array['recurring']['billingLeft'] = 10;
	$array['payment']['amount'] = $all_amount; // Montant
	
	$array['recurring']['billingDay'] = 5 ;
	
	$_SESSION['testToken'] = '' ;
	
	$_SESSION['ref'] = 666;
	
	$array['order']['ref'] = "REF666";//Ref unique
	
	// PAYMENT
	$array['payment']['currency'] = PAYMENT_CURRENCY;
	$array['payment']['action'] = PAYMENT_ACTION;
	$array['payment']['mode'] =  PAYMENT_MODE;
	$array['payment']['contractNumber'] = CONTRACT_NUMBER;
	$array['contracts'] = CONTRACT_NUMBER;
	
//	$array['languageCode'] = "fre/fra";
	$array['languageCode'] = LANGUAGE_CODE;
	
	// ORDER
	$array['order']['country'] = "FR";
	$array['order']['date'] = date("d/m/Y H:m");
	$array['order']['currency'] = ORDER_CURRENCY;
	
	// BUYER (optional)
	$array['buyer']['lastName'] = 'Linhardt' ;
	$array['buyer']['firstName'] = 'Michael' ;
	$array['buyer']['origin'] = 1;
	$array['buyer']['walletId'] = 450;
	$array['buyer']['email'] = 'mail@mail.com';
	$array['buyer']['accountCreateDate'] = date("d/m/y");
	$array['buyer']['accountAverageAmount'] = 1;
	$array['buyer']['accountOrderCount'] = 1;
	
	// ADDRESS (optional)
//	$array['address']['name'] = $_POST['addressName'];
//	$array['address']['street1'] = $_POST['addressStreet1'];
//	$array['address']['street2'] = $_POST['addressStreet2'];
//	$array['address']['cityName'] = $_POST['addressCity'];
//	$array['address']['zipCode'] = $_POST['addressZipCode'];
//	$array['address']['country'] = $_POST['addressCountry'];
//	$array['address']['phone'] =  $_POST['addressPhone'];
	
//	$payline->setItem($item2);
	
	// PRIVATE DATA (optional)
	$privateData1 = array();
	$privateData1['key'] = "user";
	$privateData1['value'] = 450;
	$payline->setPrivate($privateData1);
	
	// TRANSACTION OPTIONS
	
	$array['notificationURL'] = NOTIFICATION_URL;
	$array['returnURL'] = RETURN_URL;
	$array['cancelURL'] = CANCEL_URL;
	
	$array['customPaymentTemplateURL'] = CUSTOM_PAYMENT_TEMPLATE_URL;
	$array['customPaymentPageCode'] = CUSTOM_PAYMENT_PAGE_CODE;
	$array['securityMode'] = SECURITY_MODE;

	// EXECUTE
	$result = $payline->do_webpayment($array);
	// RESPONSE
	if (true){
		echo '<H3>REQUEST</H3>';
		print_a($payline->do_webpayment($array,1), 0, true);
		echo '<H3>RESPONSE</H3>';
		print_a($result, 0, true);
		exit();
	}
	else{
		if(isset($result) && $result['result']['code'] == '00000'){
			header("location:".$result['redirectURL']);
			exit();
		}
		elseif(isset($result)) {
			echo 'ERROR : '.$result['result']['code']. ' '.$result['result']['longMessage'].' <BR/>';
			exit();	
		}
	}

?>