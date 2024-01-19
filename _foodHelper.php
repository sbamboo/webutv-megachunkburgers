<?php
require("_functions.php");
$sqlargs3 = array("localhost","root","","megacbur","fd_orders");
$retargs = ["./index.php","./index.php"];

if (isset($_POST["order"]) && !empty($_POST["order"])) {
    $tempData = parseOrderStr($_POST["order"]);
    saveFoodOrder($sqlargs3,$retargs,$tempData[0],$tempData[1],$tempData[2]);
}
?>