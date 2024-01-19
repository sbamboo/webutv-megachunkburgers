<?php
require("_functions.php");

// Setup some SQL things
$sqlargs = array("localhost","root","","megacbur","tb_orders");

// The avaliable table range (if changed change in ./js/script.js aswell)
$tables = range(1,10);

// Get date from incoming data and use that to retrive orders
$date = $_GET["datetime"];
$dateMatches = array();
$orders = getOrders($sqlargs);

// Add a custom error handler for Warnings that throw an Exception, so that they can be catched by try/catched.
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    throw new Exception("Warning: $errstr in $errfile on line $errline\n");
}
set_error_handler('customErrorHandler', E_WARNING);

// try catch
try {
    // Get the orders matching the date and retrive their table-numbers
    foreach ($orders as $order) {
        $ordTime = explode("T",$order["Time"])[0];
        if ($ordTime == $date) {
            $dateMatches[] = $order["TableNr"];
        }
    }

    // Filter out al tableNrs that was found on the matching date
    $tables = array_diff($tables, $dateMatches);
    $returnData = $tables;
// if issue return the data so booking-form-switch.js can catch the error and view it.
} catch (Exception $e) {
    $returnData = $orders;
}
// Restore and return
restore_error_handler();
echo json_encode($returnData);

?>