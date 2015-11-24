<?php

	ini_set('display_errors', 1);
	require_once ('include.php');

	$array = array();
	$payline = new paylineSDK();

	$uid = 450 ;
	
	// RESPONSE FORMAT
	
	
	if (isset($_GET['token'])) $response = $payline->get_webWallet($_GET['token']) ;
	else $response = 'Pas de token reçu' ;
	if (isset($_GET['token'])) $response2 = $payline->get_webPaymentDetails($token);
	else $response2 = 'Pas de token reçu' ;
	if (!isset($_GET['token']))
	{
		$aArray = array() ;
		$aArray['paymentRecordId'] = $_GET['paymentRecordId'] ;
		$aArray['contractNumber'] = CONTRACT_NUMBER ;
		$response3 = $payline->get_payment_record($aArray);
	} else $response3 = 'Pas de paymentRecordId' ;
	
	    ob_start();
		
	    
	    echo '<p>Request URL = ' . 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] .'</p>';
		echo '<H3>RESPONSE GET_WEBWALLET</H3>';
		print_a($response, 0, true);
		echo '<H3>RESPONSE GET_WEBPAYMENTDETAILS</H3>';
		print_a($response2, 0, true);
		echo '<H3>RESPONSE GET_PAYMENTRECORD</H3>';
		print_a($response3, 0, true);
	    
	    $sLog = ob_get_clean();
	    
	    echo $sLog ;



	/*
	 * Chemin d'acces du fichier
	 */
	$sPath = 'track/'. date('Y.m.d.H.i') .'-notification.html' ;
	/*
	 * Formatage du log
	 */
	$oFile = fopen( $sPath, 'a+' ) ;
	fwrite( $oFile, $sLog ) ;
	fclose( $oFile ) ;
?>