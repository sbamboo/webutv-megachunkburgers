<?php
require("_functions.php");
// SQL setup
$sqlargs3 = array("localhost","root","","megacbur","fd_orders");
/*
$order = file_get_contents('php://input');
$order = json_encode(json_decode($order, true));
$order = str_replace("\u00a7","§",$order);
*/
$order = "Cajun_Kick§Cajun_Kick§Cajun_Kick§Cajun_Kick§Cajun_Kick§Fuego_Kick§Fuego_Kick§Salsa_Blaze§price:700§tablenr:3";
$tempData = parseOrderStr($order);
$foodString = str_replace("{\"order\":\"","",str_replace("&quot;","",json_encode($tempData[0])));
$foodString = str_replace("{","",$foodString);
$foodString = str_replace("}","",$foodString);
$foodString = str_replace("\"","",$foodString);
$result = saveFoodOrder($sqlargs3,$foodString,$tempData[1],$tempData[2]);
if(str_contains($result,"successfully")) {
    echo $result;
}else{
    echo $result;
}

?>