<?php
require("_functions.php");
// SQL setup
$sqlargs3 = array("localhost","root","","megacbur","fd_orders");

$order = file_get_contents('php://input');
$order = json_encode(json_decode($order, true));
$order = str_replace("\u00a7","§",$order);

$tempData = parseOrderStr($order);
var_dump($tempData);
$result = saveFoodOrder($sqlargs3,$tempData[0],$tempData[1],$tempData[2]);
if(str_contains($result,"successfully")) {
    echo "SUCCESS:" . $result;
}else{
    echo "FAILED:" . $result;
}

?>