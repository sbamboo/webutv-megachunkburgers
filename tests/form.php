<?php
require("../_functions.php");
$sqlargs = array("localhost","root","","megacbur","tb_orders");
$tables = [1,10];
$retargs = ["./form.php","./form.php"];
?>

<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mega Chunk Burgers</title>
    </head>
    <body>
        <form method="post" action="form.php">
            <h1>Book a table:</h1>
            <p>Which table?</p><select name="tablenr" size="5">
                <?php
                for ($i = $tables[0]; $i <= $tables[1]; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>
            <p>Your full name:</p><input type="text" name="fullname" placeholder="Full name">
            <p>Phone Number:</p><input type="text" name="telephone" placeholder="Phone Number">
            <p>Email:</p><input type="text" name="email" placeholder="Email">
            <p>When do you want to be there?</p><input type="datetime-local" name="time">
            <p>Any additional details you want to provide: (Optional)</p><input type="text" name="details">
            <input type="submit" value="Send In">
        </form>
        <?php
        if ( isset($_POST["fullname"]) && isset($_POST["telephone"]) && isset($_POST["email"]) && isset($_POST["time"]) && isset($_POST["details"]) ) {
            addOrder($sqlargs,$retargs,$_POST["tablenr"],$_POST["fullname"],$_POST["telephone"],$_POST["email"],$_POST["time"],$_POST["details"]);
        }
        if (isset($_GET["ret-msg"]) && !empty($_GET["ret-msg"])) {
            echo $_GET["ret-msg"];
        }
        ?>
    </body>
</html>