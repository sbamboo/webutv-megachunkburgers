<?php
require("_functions.php");
$sqlargs = array("localhost","root","","megacbur","tb_orders");
$tables = [1,10];
$retargs = ["./index.php","./index.php"];
$formUse = "index.php";
$keeptab1 = "KeepTab:cb1:";
$keeptab2 = "KeepTab:cb2:";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MegaChomp Burgers</title>
        <link type="text/css" rel="stylesheet" href="css/main-page.css">
        <link type="text/css" rel="stylesheet" href="css/sidebar.css">
        <link type="text/css" rel="stylesheet" href="css/page-decor.css">
    </head>
    <body>
        <header>
            <img src="">
        </header>
        <aside class="page-decor" id="page-decor-left">
            <div class="side-decor-img">
            </div>
        </aside>
        <main>
            <aside id="sidebar-menu">
                <!-- Section Content -->
                <div class="sidebar-tab" id="tab2">
                    <div class="tab-button">
                        <div class="sidebar-label">
                            <p>Book</p>
                        </div>
                    </div>
                </div>
                <div class="sidebar-content">
                    <form method="post" action=<?php echo $formUse?> class="booking-form">
                        <h1>Book a table:</h1>
                        <div id="booking-form-wrapper">
                            <div id="booking-form-seg1">
                                <p>When do you want to be there?</p><input type="datetime-local" name="time" id="booking-form-inp-dt">
                            </div>
                            <div id="booking-form-seg2">
                                <p>Which table?</p><select name="tablenr" size="5" id="booking-form-inp-tb">
                                </select>
                            </div>
                            <div id="booking-form-seg3">
                                <p>Your full name:</p><input type="text" name="fullname" placeholder="Full name">
                                <p>Phone number or Email:</p><input type="text" name="telephone" placeholder="Phone Number"><input type="text" name="email" placeholder="Email">
                                <p>Any additional details you want to provide: (Optional)</p><input type="text" name="details">
                            </div>
                            <div id="booking-form-btns">
                                <input type="button" value="Back" onclick="decrementBookingFormSegment()" id="form-decrement-btn">
                                <input type="button" value="Next" onclick="incrementBookingFormSegment()" id="form-increment-btn">
                                <input type="submit" value="Send In" id="form-send-btn">
                            </div>
                        </div>
                    </form>
                    <?php
                    if ( isset($_POST["tablenr"]) && isset($_POST["fullname"]) && isset($_POST["telephone"]) && isset($_POST["email"]) && isset($_POST["time"]) && isset($_POST["details"]) ) {
                        addTbOrder($sqlargs,$retargs,$_POST["tablenr"],$_POST["fullname"],$_POST["telephone"],$_POST["email"],$_POST["time"],$_POST["details"]);
                    }
                    if (isset($_GET["ret-msg"]) && !empty($_GET["ret-msg"])) {
                        $retmsg = str_replace($keeptab2,"",$_GET["ret-msg"]);
                        if (str_contains($retmsg,"failed")) {
                            echo '<p id="ret-msg" class="book-tab-ret-msg ret-msg-failed">' . $retmsg . '</p>';
                        } elseif (str_contains($retmsg,'Please')) {
                            echo '<p id="ret-msg" class="book-tab-ret-msg ret-msg-warning">' . $retmsg . '</p>';
                        } else {
                            echo '<p id="ret-msg" class="book-tab-ret-msg ret-msg-success">' . $retmsg . '</p>';
                        }
                    }
                    ?>
                </div>
                <!-- Section Content -->
                <div class="sidebar-tab" id="tab1">
                    <div class="tab-button">
                        <div class="sidebar-label">
                            <p>Meny</p>
                        </div>
                    </div>
                </div>
                <div class="sidebar-content">
                    <form id="menu-order-form">    
                        <div class="menu-header">
                            <p>Meny</p>
                            <div class="vert-div-smal">
                            </div><p>Bord:</p>
                            <input type="text" name="tablenr" placeholder="xx">
                            <input type="submit" name="food-submit" value="Beställ">
                        </div>
                        <div class="menu-main">
                            <nav class="menu-catsel">
                                <div class="menu-category" id="menu-cat-hamburgare">
                                    <p>Hamburgare</p>
                                </div>
                                <div class="menu-category" id="menu-cat-annat-kott">
                                    <p>Andra Kött Rätter</p>
                                </div>
                                <div class="menu-category" id="menu-cat-drinks">
                                    <p>Dryck</p>
                                </div>
                                <div class="menu-category" id="menu-cat-deserts">
                                    <p>Desert</p>
                                </div>
                            </nav>
                            <div class="menu-foodsel" id="menu-food-hamburgare">
                            </div>
                            <div class="menu-foodsel" id="menu-food-annat-kott">
                            </div>
                            <div class="menu-foodsel" id="menu-food-drinks">
                            </div>
                            <div class="menu-foodsel" id="menu-food-deserts">
                            </div>
                        </div>
                    </form>
                </div>
            </aside>
            <section>
                <div id="title">
                    <h1 id="title-text">MegaChomp Burgers</h1>
                </div>
                <div class="group-picture-wrapper">
                    <img src="./media/group-picture.png" class="group-picture">
                </div>
                <div id="employees">
                    <div class="employee" id="chef1">
                        <img src="./media/employee-1.png" class="employee-img">
                        <div class="employee-info">
                            <h2>Kock 1</h2>
                            <p>Vi är ett företag som gör saker</p>
                        </div>
                    </div>
                    <div class="employee" id="chef2">
                        <img src="./media/employee-2.png" class="employee-img">
                        <div class="employee-info">
                            <h2>Kock 2</h2>
                            <p>Vi är ett företag som gör saker</p>
                        </div>
                    </div>
                    <div class="employee" id="chef3">
                        <img src="./media/employee-3.png" class="employee-img">
                        <div class="employee-info">
                            <h2>Kock 3</h2>
                            <p>Vi är ett företag som gör saker</p>
                        </div>
                    </div>
                </div>
                <div id="produces">
                    <div class="produce" id="meat">
                        <img src="./media/produce_meat.png" class="meat-img">
                        <div class="produce-meat info">
                            <h2> Kött </h2>
                            <p> Vi har bra kött </p>
                        </div>
                    </div>
                    <div class="produce" id="greens">
                        <img src="./media/produce_greens.png" class="greens-img">
                        <div class="produce-greens info">
                            <h2> Grönsaker </h2>
                            <p> Vi har bra grönsaker </p>
                        </div>
                    </div>
                </div>
                <div id="about">
                    <h2> Om oss </h2>
                    <p> Vi har dom största och bästa burgarna </p>
                </div>
                <div id="contact">
                    <h2>Kontakt</h2>
                    <p>*Telefon *instagram *facebook *mm</p>
                </div>
            </section>
            <section>
                <p class="vert-space-top">Här är lite tråkig information om oss</p>
                <a href="./admin.php" class="vert-space-top">Admin</a>
            </section>
        </main>
        <aside class="page-decor" id="page-decor-right">
            <div class="side-decor-img">
            </div>
        </aside>
        <footer>
        </footer>
        <div id="music"></div>
        <script type="text/javascript" src="./js/food.js"></script>
        <script type="text/javascript" src="./js/script.js"></script>
        <script src="./js/booking-form-switch.js"></script>
    </body>
</html>