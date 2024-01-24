<?php
require("_functions.php");
// SQL setup
$sqlargs3 = array("localhost","root","","megacbur","fd_orders");

// Receive the order from the client and parse it
$order = file_get_contents('php://input');
$order = json_encode(json_decode($order, true));
$order = str_replace("\u00a7","§",$order);
$order = str_replace("order","",$order);
$order = str_replace("\"","",$order);
$order = str_replace("{","",$order);
$order = str_replace("}","",$order);
$order = substr($order, 1);

$tempData = parseOrderStr($order);
// Clean up string to be used in SQL
$foodString = str_replace("{\"order\":\"","",str_replace("&quot;","",json_encode($tempData[0])));
$foodString = str_replace("{","",$foodString);
$foodString = str_replace("}","",$foodString);
$foodString = str_replace("\"","",$foodString);
$foodString = str_replace("\\","",$foodString);
$foodString = str_replace("order","",$foodString);
$foodString = str_replace(":","",$foodString);

// Save the order to the database and return the result back to the client
$result = saveFoodOrder($sqlargs3,$foodString,$tempData[1],$tempData[2]);
if(str_contains($result,"successfully")) {
    echo $result;
}else{
    echo $result;
}

?>