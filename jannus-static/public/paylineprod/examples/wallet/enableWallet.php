<!DOCTYPE html PUBLIC "-//IETF//DTD HTML 2.0//EN">
<?php
// INITIALIZE
include "../../include.php";
$array = array();
$payline = new paylineSDK();


// CONTRACT NUMBER
$array['contractNumber'] = $_POST['contractNumber'];
$array['walletId'] = $_POST['walletId'];    

// EXECUTE
$response = $payline->enable_Wallet($array);
require('../demos/result/header.html');
echo '<H3>REQUEST</H3>';
print_a($array);
echo '<H3>RESPONSE</H3>';
print_a($response, 0, true);
require('../demos/result/footer.html');

?>
