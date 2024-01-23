<?php
require("_functions.php");
// SQL setup
$sqlargs3 = array("localhost","root","","megacbur","fd_orders");

$order = file_get_contents('php://input');
$order = json_encode(json_decode($order, true));
$order = str_replace("\u00a7","§",$order);

if ($order == Null || $order = "null") {
    if (isset($_POST["order"]) && !empty($_POST["order"])) {
        $order = $_GET["order"];
    } else if (isset($_GET["order"]) && !empty($_GET["order"])) {
        $order = $_GET["order"];
    }
}

$tempData = parseOrderStr($order);

print_r($tempData);

$result = saveFoodOrder($sqlargs3,$tempData[0],$tempData[1],$tempData[2]);
if(str_contains($result,"successfully")) {
    echo $result;
}else{
    echo $result;
}

?>