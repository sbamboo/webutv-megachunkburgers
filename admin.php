<?php
require("./_functions.php");
$sqlargs = array("localhost","root","","megacbur","admin_pg");
$sqlargs2 = array("localhost","root","","megacbur","tb_orders");
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
            <input type="submit" name="submit" value="Send In">  <a href="./index.html" id="goback-btn">Go Back</a>
        </form>
        <?php
        if ( isset($_POST["usrnme"]) && isset($_POST["usrpsw"]) ) {
            $funcres = validateLoginDetails($sqlargs,$_POST["usrnme"],$_POST["usrpsw"]);
            //echo '<script>alert("' . $funcres[1] . '");</script>';
            if (isset($_POST["submit"])) {
                if ($funcres[0] != true) {
                    echo $funcres[1];
                } else {
                    echo '<style type="text/css">#login-form {display: None;} #entriesbox {display: Block;}</style>';
                    echo '
                    <form method="post" action="admin.php" id="change-creds">
                        <h2>If you want to change your details do so bellow:</h2>
                        <p>Username:</p><input type="text" name="usrnme_2" value="' . $_POST["usrnme"] . '">
                        <p>Password:</p><input type="password" name="usrpsw_2" value="' . $_POST["usrpsw"] . '">
                        <input type="hidden" name="olduname" value="' . $_POST["usrnme"] .  '">
                        <input type="submit" name="submit_2" value="Save/LogOut">
                    </form></div>
                    ';
                }
            }
        } elseif ( isset($_POST["usrnme_2"]) && isset($_POST["usrpsw_2"]) && isset($_POST["submit_2"]) && isset($_POST["olduname"]) ) {
            $funcres = updUserData($sqlargs,$_POST["usrnme_2"],$_POST["usrpsw_2"],$_POST["olduname"]);
            echo $funcres[1] . "</div>";
        }
        echo '
        <div id="entriesbox">
            <h2>Current booking entries:</h2>';
        if ( isset($_POST["usrnme"]) && isset($_POST["usrpsw"]) ) {
            echo '
            <form method="post" action="admin.php" id="orders-ops">
                <input type="submit" name="submit_3" value="Clear Orders">
                <input type="hidden" name="usrnme" value="' . $_POST["usrnme"] . '">
                <input type="hidden" name="usrpsw" value="' . $_POST["usrpsw"] . '">
                <input type="hidden" name="submit" value="true">
            </form><br>
            ';
        }
        echo '   <table border="1">';
        if ( isset($_POST["submit_3"]) ) {
            clearOrders($sqlargs2);
        }
        $orders = getOrders($sqlargs2);
        $ids = array();
        $tablenrs = array();
        $fullnames = array();
        $telephones = array();
        $emails = array();
        $times = array();
        $details = array();
        $clrbtns = array();
        foreach ($orders as $order) {
            $ids[] = $order["ID"];
            $tablenrs[] = $order["TableNr"];
            $fullnames[] = $order["FullName"];
            $telephones[] = $order["Telephone"];
            $emails[] = $order["Email"];
            $times[] = $order["Time"];
            $details[] = $order["Details"];
        }
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
        ?>
    </body>
</html>
