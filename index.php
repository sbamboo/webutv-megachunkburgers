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
        <script src="./js/phpErrorCheck.js"></script>
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
                            <p id="tab2-label">Book</p>
                        </div>
                    </div>
                </div>
                <div class="sidebar-content" id="tab2-content">
                    <form method="post" action=<?php echo $formUse?> class="booking-form">
                        <h1>Book a table:</h1>
                        <div id="booking-form-wrapper">
                            <div id="booking-form-seg1">
                                <p>When do you want to be there?</p><input type="datetime-local" name="time" id="booking-form-inp-dt">
                            </div>
                            <div id="booking-form-seg2">
                                <p>Which table?<i>  (Filtered by avaliability for your selected day)</i></p><select name="tablenr" size="5" id="booking-form-inp-tb" selected?>
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
                        if (str_contains($retmsg,"failed") || str_contains($retmsg,"Failed")) {
                            echo '<p id="ret-msg" class="book-tab-ret-msg ret-msg-failed">' . $retmsg . '</p>';
                        } elseif (str_contains($retmsg,'Please') || str_contains($retmsg,'please') || str_contains($retmsg,'Warning: ')) {
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
                            <p id="tab1-label">Meny</p>
                        </div>
                    </div>
                </div>
                <div class="sidebar-content" id="tab1-content">
                    <div id="menu-order-upper">
                        <div id="menu-category-segment">
                            <img id="hamburger-category-button" src="media/food/hamburgers/hamb1.png" draggable="false">
                            <img id="meat-category-button" src="media/food/meat/meat1.png" draggable="false">
                            <img id="salad-category-button" src="media/food/salad/salad1.png" draggable="false">
                            <img id="drinks-category-button" src="media/food/drinks/drink1.png" draggable="false">
                            <img id="deserts-category-button" src="media/food/deserts/desert1.png" draggable="false">
                            <img id="cart-button" src="media/cart-icon.png" draggable="false">
                        </div>
                        <!-- THIS SECTION WILL BE GENERATED BY JAVASCRIPT FROM script.js -->
                        <div class="menu-content" id="hamburger-content">
                        </div>
                        <div class="menu-content" id="meat-content">
                        </div>
                        <div class="menu-content" id="salad-content">
                        </div>
                        <div class="menu-content" id="drinks-content">
                        </div>
                        <div class="menu-content" id="deserts-content">
                        </div>
                        <div class="menu-content" id="cart-content">
                        </div>
                        <!-- END OF GENERATED SECTION -->
                    </div>
                    <div id="menu-order-bottom">
                        <div id="menu-order-main">
                            <p id="price-display">Price: 0.00kr</p>
                            <input type="number" id="table-number" placeholder="Table Number">
                            <button id="order-button" onclick="order()">Order</button>
                        </div>
                    </div>
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
                            <h2>Emil Bergström</h2>
                            <p>Professionel kock. har studerat I frankrike och har 25 år av yrkes erfarenhet där han har jobbat i diverse top resturanger i Frankrike, även skaparen av "Fuego Kick" burgaren.</p>
                        </div>
                    </div>
                    <div class="employee" id="chef2">
                        <img src="./media/employee-2.png" class="employee-img">
                        <div class="employee-info">
                            <h2>Oscar Lindqvist</h2>
                            <p>Vinnare av Sveriges mästerkock år 2013. Oscar hoppade omkring mellan resturanger innuti stockholm i 19 tills han landade hos oss, skaparen av "Firestorm" burgaren.</p>
                        </div>
                    </div>
                    <div class="employee" id="chef3">
                        <img src="./media/employee-3.png" class="employee-img">
                        <div class="employee-info">
                            <h2>Viktor Nilsson</h2>
                            <p>Har rest världen i utforskande om matscenen i alla världens hörn. Har jobbat på ett fleratal toppresturanger världen över och skaparen av "Salsa Blaze" burgaren.</p>
                        </div>
                    </div>
                </div>
                <div id="produces">
                    <div class="produce" id="meat">
                        <img src="./media/produce_meat.png" class="meat-img">
                        <div class="produce-meat info">
                            <h2>Kött</h2>
                            <p>Vi har bra kött</p>
                        </div>
                    </div>
                    <div class="produce" id="greens">
                        <img src="./media/produce_greens.png" class="greens-img">
                        <div class="produce-greens info">
                            <h2>Grönsaker</h2>
                            <p>Vi har bra grönsaker</p>
                        </div>
                    </div>
                </div>
                <div id="about">
                    <h2>Om oss</h2>
                    <p>Vi har dom största och bästa burgarna</p>
                </div>
                <div id="contact">
                    <h2>Kontakt oss</h2>
                    <p>*Telefon: +46 (0)7 23 64 90 *instagram: @MegaChopBurgers *Mail: megachop@burgers.com</p>
                </div>
            </section>
            <section>
                <p class="vert-space-top">Här är lite tråkig information om oss</p>
                <a href="./admin.php" class="vert-space-top">Admin</a>
                <button onclick="removeRetMsg()" id="relWithoutRetMsg">Reload Without Messages</button>
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
        <script src="./js/hideRetMsgPostShow.js"></script>
    </body>
</html>