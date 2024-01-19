<?php
require("_functions.php");
// SQL setup
$sqlargs3 = array("localhost","root","","megacbur","fd_orders");
$retargs = ["./index.php","./index.php"];

// if order is sent through POST get it and use the saveFoodOrder to save it to SQL
if (isset($_POST["order"]) && !empty($_POST["order"])) {
    $tempData = parseOrderStr($_POST["order"]);
    saveFoodOrder($sqlargs3,$retargs,$tempData[0],$tempData[1],$tempData[2]);
}
?>