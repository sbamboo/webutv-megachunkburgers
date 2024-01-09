<?php
$sqlargs = array("localhost","root","","megacbur","tb_orders");
$tables = [1,10];
echo json_encode(array_merge( array($_GET["datetime"]), range(1,10)));
?>