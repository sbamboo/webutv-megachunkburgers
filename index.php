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
                        <div class="menu-content" id="hamburger-content">
                            <div class="menu-item">
                                <img src="media/food/hamburgers/hamb1.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Borger</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('hamb1','.hamb1-counter', 1)">+</button>
                                        <p class="increment-counter hamb1-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('hamb1','.hamb1-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/hamburgers/hamb2.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Borger</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('hamb2','.hamb2-counter', 1)">+</button>
                                        <p class="increment-counter hamb2-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('hamb2','.hamb2-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/hamburgers/hamb3.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Borger</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('hamb3','.hamb3-counter', 1)">+</button>
                                        <p class="increment-counter hamb3-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('hamb3','.hamb3-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/hamburgers/hamb4.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Borger</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('hamb4','.hamb4-counter', 1)">+</button>
                                        <p class="increment-counter hamb4-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('hamb4','.hamb4-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/hamburgers/hamb5.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Borger</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('hamb5','.hamb5-counter', 1)">+</button>
                                        <p class="increment-counter hamb5-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('hamb5','.hamb5-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                        </div>
                        <div class="menu-content" id="meat-content">
                            <div class="menu-item">
                                <img src="media/food/meat/meat1.png">
                                <div class="menu-item-info">
                                    <h2>Spicy meat</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('meat1','.meat1-counter', 1)">+</button>
                                        <p class="increment-counter meat1-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('meat1','.meat1-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/meat/meat2.png">
                                <div class="menu-item-info">
                                    <h2>Spicy meat</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('meat2','.meat2-counter', 1)">+</button>
                                        <p class="increment-counter meat2-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('meat2','.meat2-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/meat/meat3.png">
                                <div class="menu-item-info">
                                    <h2>Spicy meat</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('meat3','.meat3-counter', 1)">+</button>
                                        <p class="increment-counter meat3-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('meat3','.meat3-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/meat/meat4.png">
                                <div class="menu-item-info">
                                    <h2>Spicy meat</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('meat4','.meat4-counter', 1)">+</button>
                                        <p class="increment-counter meat4-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('meat4','.meat4-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/meat/meat5.png">
                                <div class="menu-item-info">
                                    <h2>Spicy meat</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('meat5','.meat5-counter', 1)">+</button>
                                        <p class="increment-counter meat5-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('meat5','.meat5-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                        </div>
                        <div class="menu-content" id="salad-content">
                            <div class="menu-item">
                                <img src="media/food/salad/salad1.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Salad</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('salad1','.salad1-counter', 1)">+</button>
                                        <p class="increment-counter salad1-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('salad1','.salad1-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/salad/salad2.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Salad</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('salad2','.salad2-counter', 1)">+</button>
                                        <p class="increment-counter salad2-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('salad2','.salad2-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/salad/salad3.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Salad</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('salad3','.salad3-counter', 1)">+</button>
                                        <p class="increment-counter salad3-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('salad3','.salad3-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/salad/salad4.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Salad</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('salad4','.salad4-counter', 1)">+</button>
                                        <p class="increment-counter salad4-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('salad4','.salad4-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/salad/salad5.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Salad</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('salad5','.salad5-counter', 1)">+</button>
                                        <p class="increment-counter salad5-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('salad5','.salad5-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                        </div>
                        <div class="menu-content" id="drinks-content">
                            <div class="menu-item">
                                <img src="media/food/drinks/drink1.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Drink</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('drink1','.drink1-counter', 1)">+</button>
                                        <p class="increment-counter drink1-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('drink1','.drink1-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/drinks/drink2.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Drink</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('drink2','.drink2-counter', 1)">+</button>
                                        <p class="increment-counter drink2-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('drink2','.drink2-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/drinks/drink3.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Drink</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('drink3','.drink3-counter', 1)">+</button>
                                        <p class="increment-counter drink3-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('drink3','.drink3-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/drinks/drink4.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Drink</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('drink4','.drink4-counter', 1)">+</button>
                                        <p class="increment-counter drink4-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('drink4','.drink4-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/drinks/drink5.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Drink</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('drink5','.drink5-counter', 1)">+</button>
                                        <p class="increment-counter drink5-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('drink5','.drink5-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                        </div>
                        <div class="menu-content" id="deserts-content">
                            <div class="menu-item">
                                <img src="media/food/deserts/desert1.png">
                                <div class="menu-item-info">
                                    <h2>Spicy desert</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('desert1','.desert1-counter', 1)">+</button>
                                        <p class="increment-counter desert1-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('desert1','.desert1-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/deserts/desert2.png">
                                <div class="menu-item-info">
                                    <h2>Spicy desert</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('desert2','.desert2-counter', 1)">+</button>
                                        <p class="increment-counter desert2-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('desert2','.desert2-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/deserts/desert3.png">
                                <div class="menu-item-info">
                                    <h2>Spicy desert</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('desert3','.desert3-counter', 1)">+</button>
                                        <p class="increment-counter desert3-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('desert3','.desert3-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/deserts/desert4.png">
                                <div class="menu-item-info">
                                    <h2>Spicy desert</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('desert4','.desert4-counter', 1)">+</button>
                                        <p class="increment-counter desert4-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('desert4','.desert4-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="media/food/deserts/desert5.png">
                                <div class="menu-item-info">
                                    <h2>Spicy desert</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('desert5','.desert5-counter', 1)">+</button>
                                        <p class="increment-counter desert5-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('desert5','.desert5-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                        </div>
                        <div class="menu-content" id="cart-content">
                            <div class="menu-item cart-content" id="hamb1-cart">
                                <img src="media/food/hamburgers/hamb1.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Borger</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('hamb1','.hamb1-counter', 1)">+</button>
                                        <p class="increment-counter hamb1-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('hamb1','.hamb1-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="hamb2-cart">
                                <img src="media/food/hamburgers/hamb2.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Borger</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('hamb2','.hamb2-counter', 1)">+</button>
                                        <p class="increment-counter hamb2-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('hamb2','.hamb2-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="hamb3-cart">
                                <img src="media/food/hamburgers/hamb3.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Borger</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('hamb3','.hamb3-counter', 1)">+</button>
                                        <p class="increment-counter hamb3-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('hamb3','.hamb3-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="hamb4-cart">
                                <img src="media/food/hamburgers/hamb4.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Borger</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('hamb4','.hamb4-counter', 1)">+</button>
                                        <p class="increment-counter hamb4-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('hamb4','.hamb4-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="hamb5-cart">
                                <img src="media/food/hamburgers/hamb5.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Borger</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('hamb5','.hamb5-counter', 1)">+</button>
                                        <p class="increment-counter hamb5-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('hamb5','.hamb5-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="meat1-cart">
                                <img src="media/food/meat/meat1.png">
                                <div class="menu-item-info">
                                    <h2>Spicy meat</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('meat1','.meat1-counter', 1)">+</button>
                                        <p class="increment-counter meat1-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('meat1','.meat1-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="meat2-cart">
                                <img src="media/food/meat/meat2.png">
                                <div class="menu-item-info">
                                    <h2>Spicy meat</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('meat2','.meat2-counter', 1)">+</button>
                                        <p class="increment-counter meat2-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('meat2','.meat2-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="meat3-cart">
                                <img src="media/food/meat/meat3.png">
                                <div class="menu-item-info">
                                    <h2>Spicy meat</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('meat3','.meat3-counter', 1)">+</button>
                                        <p class="increment-counter meat3-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('meat3','.meat3-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="meat4-cart">
                                <img src="media/food/meat/meat4.png">
                                <div class="menu-item-info">
                                    <h2>Spicy meat</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('meat4','.meat4-counter', 1)">+</button>
                                        <p class="increment-counter meat4-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('meat4','.meat4-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="meat5-cart">
                                <img src="media/food/meat/meat5.png">
                                <div class="menu-item-info">
                                    <h2>Spicy meat</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('meat5','.meat5-counter', 1)">+</button>
                                        <p class="increment-counter meat5-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('meat5','.meat5-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="salad1-cart">
                                <img src="media/food/salad/salad1.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Salad</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('salad1','.salad1-counter', 1)">+</button>
                                        <p class="increment-counter salad1-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('salad1','.salad1-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="salad2-cart">
                                <img src="media/food/salad/salad2.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Salad</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('salad2','.salad2-counter', 1)">+</button>
                                        <p class="increment-counter salad2-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('salad2','.salad2-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="salad3-cart">
                                <img src="media/food/salad/salad3.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Salad</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('salad3','.salad3-counter', 1)">+</button>
                                        <p class="increment-counter salad3-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('salad3','.salad3-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="salad4-cart">
                                <img src="media/food/salad/salad4.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Salad</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('salad4','.salad4-counter', 1)">+</button>
                                        <p class="increment-counter salad4-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('salad4','.salad4-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="salad5-cart">
                                <img src="media/food/salad/salad5.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Salad</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('salad5','.salad5-counter', 1)">+</button>
                                        <p class="increment-counter salad5-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('salad5','.salad5-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="drink1-cart">
                                <img src="media/food/drinks/drink1.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Drink</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('drink1','.drink1-counter', 1)">+</button>
                                        <p class="increment-counter drink1-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('drink1','.drink1-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="drink2-cart">
                                <img src="media/food/drinks/drink2.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Drink</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('drink2','.drink2-counter', 1)">+</button>
                                        <p class="increment-counter drink2-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('drink2','.drink2-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="drink3-cart">
                                <img src="media/food/drinks/drink3.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Drink</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('drink3','.drink3-counter', 1)">+</button>
                                        <p class="increment-counter drink3-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('drink3','.drink3-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="drink4-cart">
                                <img src="media/food/drinks/drink4.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Drink</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('drink4','.drink4-counter', 1)">+</button>
                                        <p class="increment-counter drink4-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('drink4','.drink4-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="drink5-cart">
                                <img src="media/food/drinks/drink5.png">
                                <div class="menu-item-info">
                                    <h2>Spicy Drink</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('drink5','.drink5-counter', 1)">+</button>
                                        <p class="increment-counter drink5-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('drink5','.drink5-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="desert1-cart">
                                <img src="media/food/deserts/desert1.png">
                                <div class="menu-item-info">
                                    <h2>Spicy desert</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('desert1','.desert1-counter', 1)">+</button>
                                        <p class="increment-counter desert1-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('desert1','.desert1-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="desert2-cart">
                                <img src="media/food/deserts/desert2.png">
                                <div class="menu-item-info">
                                    <h2>Spicy desert</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('desert2','.desert2-counter', 1)">+</button>
                                        <p class="increment-counter desert2-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('desert2','.desert2-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="desert3-cart">
                                <img src="media/food/deserts/desert3.png">
                                <div class="menu-item-info">
                                    <h2>Spicy desert</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('desert3','.desert3-counter', 1)">+</button>
                                        <p class="increment-counter desert3-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('desert3','.desert3-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="desert4-cart">
                                <img src="media/food/deserts/desert4.png">
                                <div class="menu-item-info">
                                    <h2>Spicy desert</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('desert4','.desert4-counter', 1)">+</button>
                                        <p class="increment-counter desert4-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('desert4','.desert4-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                            <div class="menu-item cart-content" id="desert5-cart">
                                <img src="media/food/deserts/desert5.png">
                                <div class="menu-item-info">
                                    <h2>Spicy desert</h2>
                                    <div class="menu-items-btn-div">
                                        <button class="menu-items-btn-positive" onclick="changeAmount('desert5','.desert5-counter', 1)">+</button>
                                        <p class="increment-counter desert5-counter">0</p>
                                        <button class="menu-items-btn-negative" onclick="changeAmount('desert5','.desert5-counter', -1)">-</button>
                                    </div>
                                    <p>7.99</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="menu-order-bottom">
                        <p id="price-display">Price: $0.00</p>
                        <input type="number" id="table-number" placeholder="Table Number">
                        <button id="order-button" onclick="order()">Order</button>
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