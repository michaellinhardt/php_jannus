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
$array['payment']['contractNumber'] =  $_POST['paymentContractNumber'];
$array['payment']['differedActionDate'] = $_POST['paymentDifferedActionDate'] ; 

// ORDER
$array['orderRef'] = $_POST['orderRef'];
$array['orderDate'] = $_POST['orderDate'];

//ORDER
$array['order']['ref'] = $_POST['orderRef'];
$array['order']['origin'] = $_POST['orderOrigin'];
$array['order']['country'] = $_POST['orderCountry'];
$array['order']['taxes'] = $_POST['orderTaxes'];
$array['order']['amount'] = $_POST['orderAmount'];
$array['order']['date'] = $_POST['orderDate'];
$array['order']['currency'] = $_POST['orderCurrency'];

//ORDER DETAILS (optional)
$item1 = array();
$item1['ref'] = $_POST['orderDetailRef1'];
$item1['price'] = $_POST['orderDetailPrice1'];
$item1['quantity'] = $_POST['orderDetailQuantity1'];
$item1['comment'] = $_POST['orderDetailComment1'];
$payline->setItem($item1);

$item2 = array();
$item2['ref'] = $_POST['orderDetailRef2'];
$item2['price'] = $_POST['orderDetailPrice2'];
$item2['quantity'] = $_POST['orderDetailQuantity2'];
$item2['comment'] = $_POST['orderDetailComment2'];
$payline->setItem($item2);
	
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

// WALLET ID
$array['walletId'] = $_POST['walletId'];

// scheduled
$array['scheduled'] = $_POST['ScheduledDate'];

// RECCURENT	
$array['recurring']['firstAmount'] = $_POST['recurringFirstAmount'];
$array['recurring']['amount'] = $_POST['recurringAmount'];
$array['recurring']['billingCycle'] = $_POST['recurringBillingCycle'];
$array['recurring']['billingLeft'] = $_POST['recurringBillingLeft'];
$array['recurring']['billingDay'] = $_POST['recurringBillingDay'];
$array['recurring']['startDate'] = $_POST['recurringStartDate'];

// EXECUTE
$response = $payline->do_recurrent_wallet_payment($array);
require('../demos/result/header.html');
echo '<H3>REQUEST</H3>';
print_a($array);
echo '<H3>RESPONSE</H3>';
print_a($response, 0, true);
require('../demos/result/footer.html');
?>