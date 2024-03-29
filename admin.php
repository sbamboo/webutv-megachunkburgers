<?php
require("./_functions.php");
$sqlargs = array("localhost","root","","megacbur","admin_pg");
$sqlargs2 = array("localhost","root","","megacbur","tb_orders");
$sqlargs3 = array("localhost","root","","megacbur","fd_orders");
?>

<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/admin-page.css">
        <title>Mega Chunk Burgers</title>
    </head>
    <body>
        <div id="loginbox">
        <style type="text/css">#entriesbox {display: None;}</style>
        <form method="post" action="admin.php" id="login-form">
            <h2>Login to admin page:</h2>
            <p>Username:</p><input type="text" name="usrnme" placeholder="Username">
            <p>Password:</p><input type="password" name="usrpsw" placeholder="Password">
            <input type="submit" name="submit" value="Send In">  <a href="./index.php" id="goback-btn">Go Back</a>
        </form>
        <?php
        // If login details are given (sent by form above)
        if ( isset($_POST["usrnme"]) && isset($_POST["usrpsw"]) ) {
            // Validate login details from SQL
            $funcres = validateLoginDetails($sqlargs,$_POST["usrnme"],$_POST["usrpsw"]);
            //echo '<script>alert("' . $funcres[1] . '");</script>';
            if (isset($_POST["submit"])) {
                // if error echo that
                if ($funcres[0] != true) {
                    echo $funcres[1];
                } else {
                    // Show detail-change form
                    echo '<style type="text/css">#login-form {display: None;} #entriesbox {display: Block;}</style>';
                    echo '
                    <form method="post" action="admin.php" id="change-creds">
                        <h2>If you want to change your details do so bellow:</h2>
                        <p>Username:</p><input type="text" name="usrnme_2" value="' . $_POST["usrnme"] . '">
                        <p>Password:</p><input type="password" name="usrpsw_2" value="' . $_POST["usrpsw"] . '">
                        <input type="hidden" name="olduname" value="' . $_POST["usrnme"] .  '">
                        <input type="submit" name="submit_2" value="Save/LogOut">
                    </form></div>
                    ';//      ↑
                      //  Here is the end of the "loginbox" div
                }
            }
        // If not check if a change to user-login details was made and update them in SQL
        } elseif ( isset($_POST["usrnme_2"]) && isset($_POST["usrpsw_2"]) && isset($_POST["submit_2"]) && isset($_POST["olduname"]) ) {
            $funcres = updUserData($sqlargs,$_POST["usrnme_2"],$_POST["usrpsw_2"],$_POST["olduname"]);
            echo $funcres[1] . "</div>";
        }
        // TABLE ORDERS BELLOW
        echo '
        <div id="entriesbox">
            <h2>Current booking entries:</h2>';
        if ( isset($_POST["usrnme"]) && isset($_POST["usrpsw"]) ) {
            echo '
            <form method="post" action="admin.php" id="orders-ops">
                <input type="submit" name="submit_3" value="Clear Orders"><p id="order-clear-warn">(Use with caution, will clear al orders)</p>
                <input type="hidden" name="usrnme" value="' . $_POST["usrnme"] . '">
                <input type="hidden" name="usrpsw" value="' . $_POST["usrpsw"] . '">
                <input type="hidden" name="submit" value="true">
            </form><br>
            ';
        }
        echo '   <table border="1">';
        // Incase the clear button was pressed
        if ( isset($_POST["submit_3"]) ) {
            clearOrders($sqlargs2);
        }
        $orders = getOrders($sqlargs2); // get the orders
        // Create arrays
        $ids = array();
        $tablenrs = array();
        $fullnames = array();
        $telephones = array();
        $emails = array();
        $times = array();
        $details = array();
        $clrbtns = array();
        // Populate arrays
        foreach ($orders as $order) {
            $ids[] = $order["ID"];
            $tablenrs[] = $order["TableNr"];
            $fullnames[] = $order["FullName"];
            $telephones[] = $order["Telephone"];
            $emails[] = $order["Email"];
            $times[] = $order["Time"];
            $details[] = $order["Details"];
        }
        // No entires text
        if (count($ids) == 0) {
            $ids[] = "NO ENTRIES";
        }
        if (count($tablenrs) == 0) {
            $tablenrs[] = "NO ENTRIES";
        }
        if (count($fullnames) == 0) {
            $fullnames[] = "NO ENTRIES";
        }
        if (count($telephones) == 0) {
            $telephones[] = "NO ENTRIES";
        }
        if (count($emails) == 0) {
            $emails[] = "NO ENTRIES";
        }
        if (count($times) == 0) {
            $times[] = "NO ENTRIES";
        }
        if (count($details) == 0) {
            $details[] = "NO ENTRIES";
        }
        // Generate HTML
        echo '<tr>';
        echo '<th class="tab_id tab_title">ID</th>';
        foreach ($ids as $id) {
            echo '<th class="tab_id">' . $id . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_tnr tab_title">TableNr</th>';
        foreach ($tablenrs as $tablenr) {
            echo '<th class="tab_nr">' . $tablenr . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_fnm tab_title">Fullname</th>';
        foreach ($fullnames as $fullname) {
            echo '<th class="tab_fnm">' . $fullname . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_pho tab_title">Phone</th>';
        foreach ($telephones as $telephone) {
            echo '<th class="tab_pho">' . $telephone . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_ema tab_title">Email</th>';
        foreach ($emails as $email) {
            echo '<th class="ema">' . $email . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_tim tab_title">Time</th>';
        foreach ($times as $time) {
            echo '<th class="tab_tim">' . $time . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_det tab_title">Details</th>';
        foreach ($details as $detail) {
            echo '<th class="tab_det">' . $detail . '</th>';
        }
        echo '</tr>';
        echo '</table></div>';

        // TABLE FOOD ORDERS BELLOW
        echo '
        <div id="entriesbox">
            <h2>Current food orders:</h2>';
        if ( isset($_POST["usrnme"]) && isset($_POST["usrpsw"]) ) {
            echo '
            <form method="post" action="admin.php" id="fdorders-ops">
                <input type="submit" name="submit_4" value="Clear Food-Orders"><p id="order-clear-warn">(Use with caution, will clear al orders)</p>
                <input type="hidden" name="usrnme" value="' . $_POST["usrnme"] . '">
                <input type="hidden" name="usrpsw" value="' . $_POST["usrpsw"] . '">
                <input type="hidden" name="submit" value="true">
            </form><br>
            ';
        }
        echo '   <table border="1">';
        // incase clear was pressed
        if ( isset($_POST["submit_4"]) ) {
            clearOrders($sqlargs3);
        }
        // get orders
        $orders = getOrders($sqlargs3);
        // Create arrays
        $ids = array();
        $tablenrs = array();
        $prices = array();
        $times = array();
        $foods = array();

        #$raw = file_get_contents("./js/food.js");
        #$raw = str_replace("let food = ","",$raw);
        #$data = json_decode(strval($raw),False);
        #$data = json_decode($string,True);
        #print_r($data);

        // Populate
        foreach ($orders as $order) {
            $ids[] = $order["ID"];
            $tablenrs[] = $order["TableNr"];
            $prices[] = $order["Price"];
            $times[] = $order["Time"];
            $foods[] = $order["Food"];
        }
        // no entires text
        if (count($ids) == 0) {
            $ids[] = "NO ENTRIES";
        }
        if (count($tablenrs) == 0) {
            $tablenrs[] = "NO ENTRIES";
        }
        if (count($prices) == 0) {
            $prices[] = "NO ENTRIES";
        }
        if (count($times) == 0) {
            $times[] = "NO ENTRIES";
        }
        if (count($foods) == 0) {
            $foods[] = "NO ENTRIES";
        }
        // Generate HTML
        echo '<tr>';
        echo '<th class="tab_id tab_title">ID</th>';
        foreach ($ids as $id) {
            echo '<th class="tab_id">' . $id . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_tnr tab_title">TableNr</th>';
        foreach ($tablenrs as $tablenr) {
            echo '<th class="tab_nr">' . $tablenr . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_fnm tab_title">Price</th>';
        foreach ($prices as $price) {
            echo '<th class="tab_fnm">' . $price . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_tim tab_title">Time</th>';
        foreach ($times as $time) {
            echo '<th class="tab_tim">' . $time . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_det tab_title">Foods</th>';
        foreach ($foods as $food) {
            echo '<th class="tab_det">' . $food . '</th>';
        }
        echo '</tr><tr>';
        echo '<th class="tab_rem tab_title">Remove</th>';
        if ($id == "NO ENTRIES") {
            echo '<th class="tab_rem">' . $id . '</th>';
        // Remove form
        } else {
            foreach ($times as $time) {
                echo '<th class="tab_rem">
                <form method="post" action="admin.php" id="fdorders-ops">
                    <input type="submit" name="submit_5" value="Press to remove">
                    <p>(Reload page to update)</p>
                    <input type="hidden" name="usrnme" value="' . $_POST["usrnme"] . '">
                    <input type="hidden" name="usrpsw" value="' . $_POST["usrpsw"] . '">
                    <input type="hidden" name="toremid" value="' . $id . '">
                    <input type="hidden" name="submit" value="true">
                </form>
                </th>';
            }
        }
        // With action to above clear form for specific order
        if ( isset($_POST["submit_5"]) && isset($_POST["toremid"]) ) {
            clearOrdersId($sqlargs3,$_POST["toremid"]);
        }
        echo '</tr>';
        echo '</table></div>';
        ?>
    </body>
</html>
