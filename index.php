<?php
require("_functions.php");
$sqlargs = array("localhost","root","","megacbur","tb_orders");
$sqlargs3 = array("localhost","root","","megacbur","fd_orders");
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
        <noscript>
            <style type="text/css">
                header {display:none;}
                main {display:none;}
                aside {display:none;}
                footer {display:none;}
            </style>
            <div class="noscriptmsg">
                <div><p>You don't have javascript enabled, this website sadly relies on javascript to function.<br></p></div>
            </div>
        </noscript>
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
                    <div id="booking-form-wrapper-outer">
                        <div id="booking-form-wrapper-mid">
                            <form method="post" action=<?php echo $formUse?> class="booking-form">
                                <h1>Boka ett bord:</h1>
                                <div id="booking-form-wrapper">
                                    <div id="booking-form-seg1">
                                        <p>När vill du va där?</p><input type="datetime-local" name="time" id="booking-form-inp-dt">
                                    </div>
                                    <div id="booking-form-seg2">
                                        <p>Vilket bord?<i>  (Filtrerat efter tillgänglighet denna dag)</i></p><select name="tablenr" size="5" id="booking-form-inp-tb" selected?>
                                        </select>
                                    </div>
                                    <div id="booking-form-seg3">
                                        <p>Ditt fulla namn:</p><input type="text" name="fullname" placeholder="Full name">
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
                            <div id="booking-form-wrapper-retmsg">
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
                        </div>
                        <div id="booking-form-img-wrapper">
                            <img id="booking-form-img" alt="Booking form image" src="./media/book-table1.png"></img>
                        </div>
                    </div>
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
                        <div id="menu-category-segment" class="menu-category-segment">
                            <h2 id="menu-order-title">Kategorier</h2>
                            <img id="hamburger-category-button" class="selected-menu-category" src="media/food/hamburgers/hamb1.png" draggable="false">
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
                            <p id="price-display">Pris: 0kr</p>
                            <input type="number" id="order-code" placeholder="Beställnings Kod" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
                            <button id="order-button" onclick="order()">Beställ</button>
                        </div>
                        <?php
                            if (isset($_GET["ret-msg"]) && !empty($_GET["ret-msg"])) {
                                $retmsg = str_replace($keeptab1,"",$_GET["ret-msg"]);
                                if (str_contains($retmsg, $keeptab2)) {
                                } else {
                                    if (str_contains($retmsg,"failed") || str_contains($retmsg,"Failed")) {
                                        echo '<div id="menu-ret-msg"><p id="ret-msg-p">Order Info:</p><p id="ret-msg-m" class="menu-tab-ret-msg ret-msg-failed">' . $retmsg . '</p></div>';
                                    } elseif (str_contains($retmsg,'Please') || str_contains($retmsg,'please') || str_contains($retmsg,'Warning: ')) {
                                        echo '<div id="menu-ret-msg"><p id="ret-msg-p">Order Info:</p><p id="ret-msg-m" class="menu-tab-ret-msg ret-msg-warning">' . $retmsg . '</p></div>';
                                    } else {
                                        echo '<div id="menu-ret-msg"><p id="ret-msg-p">Order Info:</p><p id="ret-msg-m" class="menu-tab-ret-msg ret-msg-success">' . $retmsg . '</p></div>';
                                    }
                                }
                            }
                        ?>
                    </div>
                    <form id="menu-form" action="./_foodHelper.php" method="POST">
                        <input name="order" id="order-input" type="hidden" value="">
                    </form>
                </div>
            </aside>
            <section>
                <div id="title">
                    <div id="title-wrapper">
                        <img alt="MegaChomp BurgersLogo" src="./media/logo_lucas_big_bunger.png" id="title-img"></img>
                        <h1 id="title-text" class="whiteText">MegaChomp Burgers</h1>
                    </div>
                </div>
                <div class="group-picture-wrapper">
                    <img src="./media/group-picture.png" class="group-picture main-img" alt="Grupp bild av våra anställda.">
                </div>
                <div id="employees">
                    <div class="employee" id="chef1">
                        <img src="./media/employee-1.png" class="employee-img main-img" alt="Bild på en av våra kockar.">
                        <div class="employee-info">
                            <h2>Lena Bergström</h2>
                            <p>Professionell kock. har studerat I Frankrike och har 25 år av yrkeserfarenhet där hon har jobbat i diverse topp restauranger i Frankrike, även skaparen av "Fuego Kick" burgaren. Lena har varigt huvudkock på vår restaurang i 4 år.</p>
                        </div>
                    </div>
                    <div class="employee" id="chef2">
                        <img src="./media/employee-2.png" class="employee-img main-img" alt="Bild på en av våra kockar.">
                        <div class="employee-info">
                            <h2>Rita Lindqvist</h2>
                            <p>Vinnare av Sveriges mästerkock år 2013. Rita hoppade omkring mellan restauranger inuti Stockholm i 19 tills hon landade hos oss, skaparen av "Firestorm" och "Cajun Kick" burgarna. Älskar allt grönt och odlar även egna örter till restaurangen.</p>
                        </div>
                    </div>
                    <div class="employee" id="chef3">
                        <img src="./media/employee-3.png" class="employee-img main-img" alt="Bild på en av våra kockar.">
                        <div class="employee-info">
                            <h2>Viktor Nilsson</h2>
                            <p>Har rest världen i utforskande om mat scenen i alla världens hörn. Har jobbat på ett flertal toppresturanger världen över och skaparen av "Salsa Blaze" och "Buffalo Heatwave" burgarna. Älskar djur och föder egen kyckling till restaurangen.</p>
                        </div>
                    </div>
                </div>
                <div id="produces">
                    <div class="produce" id="meat">
                        <img src="./media/produce_meat.png" class="meat-img main-img" alt="Bild som visar vårt fina kött.">
                        <div class="produce-meat info">
                            <h2>Kött</h2>
                            <p>Vårt kött är inköpt lokalt från Berghagens bondgård där kossorna är får ströva fritt och är bra omhändertagna. Vi köper in fläskkött från PrärieSvinet som är känt för deras kvalité och humanitära behandlande av grisarna. Vår kyckling bistår vår egen kock Viktor Nilsson med då han Föder egna. </p>
                        </div>
                    </div>
                    <div class="produce" id="greens">
                        <img src="./media/produce_greens.png" class="greens-img main-img" alt="Bild som visar våra fina grönsaker.">
                        <div class="produce-greens info">
                            <h2>Grönsaker</h2>
                            <p>Våra grönsaker är inköpta lokalt från flera bondgårdar runt om i Sverige. Våra anställda odlar även några grönsaker själv som sedan används av oss. Dom bondgårdar vi köper in ifrån är EkoÄngen Gård, Solhaga Gård och Bondens Paradis </p>
                        </div>
                    </div>
                </div>
                <div id="about">
                    <h2>Om oss</h2>
                    <p>Vi är en resturang som tar hållbarhet och kvalitet på allvar och därför köper vi endast från väletablerade gårdar i Sverige med fokus på lokalt. Vi har en större inriktning på kryddiga rätter men vi har även det traditionella som alla tycker om. Vi har några av dom mest omtalade kockarna i Sverige Emil Bergström, Oscar Lindqvist och Viktor Nilsson som alla jobbar hårt för att ge alla besökande en oförglömlig upplevelse.  </p>
                </div>
                <div id="contact">
                    <h2>Kontakt oss</h2>
                    <p>*Telefon: +46 (0)7 23 64 90 *instagram: @MegaChopBurgers *Mail: megachop@burgers.com</p>
                </div>
            </section>
                <p class="vert-space-top"></p>
                <a href="./admin.php" class="vert-space-top btlink">Admin</a>
                <button onclick="removeRetMsg()" id="relWithoutRetMsg" class="btlink">Reload Without Messages</button>
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