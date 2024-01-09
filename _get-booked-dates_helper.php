<?php
require("_functions.php");

$sqlargs = array("localhost","root","","megacbur","tb_orders");

$tables = range(1,10);

$date = $_GET["datetime"];
$dateMatches = array();
$orders = getOrders($sqlargs);

foreach ($orders as $order) {
    $ordTime = explode("T",$order["Time"])[0];
    if ($ordTime == $date) {
        $dateMatches[] = $order["TableNr"];
    }
}

// Filter out al tableNrs that was found on the matching date
$tables = array_diff($tables, $dateMatches);

echo json_encode($tables);
?>