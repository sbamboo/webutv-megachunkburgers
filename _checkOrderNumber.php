<?php
require("_functions.php");
$sqlargs3 = array("localhost","root","","megacbur","tb_orders");

$ordercode = file_get_contents('php://input');

echo checkOrderCode(json_decode($ordercode,true)["ordercode"], $sqlargs3);

?>