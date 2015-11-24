<?php

	ini_set('display_errors', 1);
	$token = $_GET["token"];
	require_once ('include.php');

	$array = array();
	$payline = new paylineSDK();

	$uid = 450 ;
	
	// RESPONSE FORMAT
	
	
	$response = $payline->get_webWallet($token);
	$response2 = $payline->get_webPaymentDetails($token);
	
	    ob_start();
		
	    
	    echo '<p>Request URL = ' . 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] .'</p>';
		echo '<H3>RESPONSE GET_WEBWALLET</H3>';
		print_a($response, 0, true);
		echo '<H3>RESPONSE GET_WEBPAYMENTDETAILS</H3>';
		print_a($response2, 0, true);
	    
	    $sLog = ob_get_clean();
	    
	    echo $sLog ;



	/*
	 * Chemin d'acces du fichier
	 */
	$sPath = 'track/'. date('Y.m.d.H.i') .'-return.html' ;
	/*
	 * Formatage du log
	 */
	$oFile = fopen( $sPath, 'a+' ) ;
	fwrite( $oFile, $sLog ) ;
	fclose( $oFile ) ;
?>