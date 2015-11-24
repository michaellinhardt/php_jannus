<?php
// INITIALIZE
include "../../include.php";
$array = array();
$payline = new paylineSDK();

// PAYMENT
$array['payment']['amount'] = $_POST['paymentAmount'];
$array['payment']['currency'] = $_POST['paymentCurrency'];
$array['payment']['action'] = $_POST['paymentFonction'];
$array['payment']['mode'] =  $_POST['paymentMode'];
$array['payment']['contractNumber'] = $_POST['paymentContractNumber'];
$array['payment']['differedActionDate'] = $_POST['paymentDifferedActionDate'] ; 

// TRANSACTION INFO
$array['transactionID'] = $_POST['transactionID'];
$array['comment'] = $_POST['comment'];

//PRIVATE DATA (optional)
$privateData1 = array();
$privateData1['key'] = $_POST['privateDataKey1'];
$privateData1['value'] = $_POST['privateDataValue1'];
$payline->setPrivate($privateData1);

$privateData2 = array();
$privateData2['key'] = $_POST['privateDataKey2'];
$privateData2['value'] = $_POST['privateDataValue2'];
$payline->setPrivate($privateData2);

$privateData3 = array();
$privateData3['key'] = $_POST['privateDataKey3'];
$privateData3['value'] = $_POST['privateDataValue3'];
$payline->setPrivate($privateData3);

//SEQUENCE NUMBER
$array['sequenceNumber'] = $_POST['sequenceNumber'];

// RESPONSE
$response = $payline->do_refund($array);

require('../demos/result/header.html');
echo '<H3>REQUEST</H3>';
print_a($array);
echo '<H3>RESPONSE</H3>';
print_a($response, 0, true);
require('../demos/result/footer.html');
?>