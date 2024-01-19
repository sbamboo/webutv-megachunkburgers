<?php
require("_functions.php");
$sqlargs3 = array("localhost","root","","megacbur","fd_orders");
$retargs = ["./index.php","./index.php"];

if (isset($_GET["order"]) && !empty($_GET["order"])) {
    $tempData = parseOrderStr($_GET["order"]);
    saveFoodOrder($sqlargs3,$retargs,$tempData[0],$tempData[1],$tempData[2]);
}
?>