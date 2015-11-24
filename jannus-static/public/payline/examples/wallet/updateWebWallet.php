<?php
// INITIALIZE
include "../../include.php";
$array = array();
$payline = new paylineSDK();

// CONTRACT NUMBER
$array['contractNumber'] = $_POST['contractNumber'];

//WALLET ID
$array['walletId'] = $_POST['walletId'];

//UPDATE PERSONNAL DETAIL
$array['updatePersonalDetails'] = isset($_POST['updatePersonalDetails']) ? 1 : 0;

//UPDATE PAYMENT DETAIL
$array['updatePaymentDetails'] = isset($_POST['updatePaymentDetails']) ? 1 : 0;
	
// TRANSACTION OPTIONS
$array['notificationURL'] = $_POST['notificationURL'];
$array['returnURL'] = $_POST['returnURL'];
$array['cancelURL'] = $_POST['cancelURL'];
$array['customPaymentPageCode'] = $_POST['customPaymentPageCode'];
$array['customPaymentTemplateURL'] = $_POST['customPaymentTemplateURL'];
$array['securityMode'] = $_POST['securityMode'];
$array['languageCode'] = $_POST['languageCode'];

// PRIVATE DATA (optional)
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

// EXECUTE
$response = $payline->update_WebWallet($array);
require('../demos/result/header.html');
echo '<H3>REQUEST</H3>';
print_a($array);
echo '<H3>RESPONSE</H3>';
print_a($response, 0, true);
require('../demos/result/footer.html');
?>

	