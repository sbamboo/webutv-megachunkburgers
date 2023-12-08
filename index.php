<?php
require("_functions.php");
$sqlargs = array("localhost","root","","megacbur","tb_orders");
$tables = [1,10];
$retargs = ["./index.php","./index.php"];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MegeChomp Burger</title>
        <link type="text/css" rel="stylesheet" href="css/main-page.css">
    </head>
    <body>
        <header>
            <img src="">
        </header>
        <main>
            <aside id="sidebar-menu">
                <input type="checkbox" id="cb3">
                <div class="sidebar-tab" id="tab3">
                    <div class="tab-button">
                        <label for="cb3" class="sidebar-label">
                            <p>Admin</p>
                        </a>
                    </div>
                    <div class="sidebar-content">
                        <a href="admin.php" id="admin-button">Go to admin page</a>
                    </div>
                </div>

                <?php
                if (isset($_GET["ret-msg"]) && !empty($_GET["ret-msg"]) && strpos($_GET["ret-msg"], "KeepTab:") !== false) {
                    echo '<input type="checkbox" id="cb2" checked="checked">';
                    $_GET["ret-msg"] = str_replace("KeepTab:", "", $_GET["ret-msg"]);
                } else {
                    echo '<input type="checkbox" id="cb2">';
                }
                ?>
                <div class="sidebar-tab" id="tab2">
                    <div class="tab-button">
                        <label for="cb2" class="sidebar-label">
                            <p>Book</p>
                        </label>
                    </div>
                    <div class="sidebar-content">
                        <form method="post" action="index.php" class="booking-form">
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
                    </div>
                </div>

                <input type="checkbox" id="cb1">
                <div class="sidebar-tab" id="tab1">
                    <div class="tab-button">
                        <label for="cb1" class="sidebar-label">
                            <p>Meny</p>
                        </label>
                    </div>
                    <div class="sidebar-content"></div>
                </div>
            </aside>
            <section>
                <div id="employees">
                    <div class="employee" id="owner">
                        <img src="" class="employee-img">
                        <div class="employee-info">
                            <h2>Ägare</h2>
                            <p>Vi är ett företag som gör saker</p>
                        </div>
                    </div>
                    <div class="employee" id=chef1">
                        <img src="" class="employee-img">
                        <div class="employee-info">
                            <h2>Kock 1</h2>
                            <p>Vi är ett företag som gör saker</p>
                        </div>
                    </div>
                    <div class="employee" id="chef2">
                        <img src="" class="employee-img">
                        <div class="employee-info">
                            <h2>Kock 2</h2>
                            <p>Vi är ett företag som gör saker</p>
                        </div>
                    </div>
                    <div class="employee" id="chef3">
                        <img src="" class="employee-img">
                        <div class="employee-info">
                            <h2>Kock 3</h2>
                            <p>Vi är ett företag som gör saker</p>
                        </div>
                    </div>
                </div>
                <div id="about">
                    <h2>Om oss</h2>
                    <p>Vi är ett företag som gör saker</p>
                </div>
                <div id="produce">
                    <h2>Råvaror</h2>
                    <p>Vi är ett företag som gör saker</p>
                </div>
                <div id="contact">
                    <h2>Kontakt</h2>
                    <p>Vi är ett företag som gör saker</p>
                </div>
            </section>
        </main>
        <footer>

        </footer>
    </body>
</html>