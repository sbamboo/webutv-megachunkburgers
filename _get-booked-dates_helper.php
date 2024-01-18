<?php
require("_functions.php");

$sqlargs = array("localhost","root","","megacbur","tb_orders");

$tables = range(1,10);

$date = $_GET["datetime"];
$dateMatches = array();
$orders = getOrders($sqlargs);

function customErrorHandler($errno, $errstr, $errfile, $errline) {
    throw new Exception("Warning: $errstr in $errfile on line $errline\n");
}
set_error_handler('customErrorHandler', E_WARNING);

try {
    foreach ($orders as $order) {
        $ordTime = explode("T",$order["Time"])[0];
        if ($ordTime == $date) {
            $dateMatches[] = $order["TableNr"];
        }
    }

    // Filter out al tableNrs that was found on the matching date
    $tables = array_diff($tables, $dateMatches);
    $returnData = $tables;
} catch (Exception $e) {
    $returnData = $orders;
}
restore_error_handler();
echo json_encode($returnData);

?>