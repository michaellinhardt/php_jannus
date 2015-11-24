<?php
// INITIALIZE
include "../../include.php";
$array = array();
$payline = new paylineSDK();

$array['transactionID'] = $_POST['transactionID'];
$array['comment'] = $_POST['comment'];

// RESPONSE FORMAT
$response = $payline->do_reset($array);
if(isset($response)){
    require('../demos/result/header.html');
    echo '<H3>RESPONSE</H3>';
    print_a($response, 0, true);
    require('../demos/result/footer.html');
}

?>

