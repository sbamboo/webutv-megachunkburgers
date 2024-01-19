// Overlap function between two sidebar buttons and also make them work
const menuButton = document.querySelector('#tab2');
const bookButton = document.querySelector('#tab1');

// Get labels to be able to change their position for visibility
const menuLabel = document.querySelector('#tab1-label');
const bookLabel = document.querySelector('#tab2-label');

// Get content to be able to change their scale and z-index
let content = document.querySelectorAll('.sidebar-content');

// Get sidebar buttons to be able to change their z-index and add/remove selected-menu-category
const hamburgerButton = document.querySelector('#hamburger-category-button');
const meatButton = document.querySelector('#meat-category-button');
const saladButton = document.querySelector('#salad-category-button');
const drinkButton = document.querySelector('#drinks-category-button');
const desertButton = document.querySelector('#deserts-category-button');
const cartButton = document.querySelector('#cart-button');

// Get sidebar content to be able to change their display
const hamburgerContent = document.querySelector('#hamburger-content');
const meatContent = document.querySelector('#meat-content');
const saladContent = document.querySelector('#salad-content');
const drinkContent = document.querySelector('#drinks-content');
const desertContent = document.querySelector('#deserts-content');
const cartContent = document.querySelector('#cart-content');

// Get table number input to be able to check if it is valid
const tableNumbers = [1,10] // If changed, change tables variable in _get-booked-dates_helper.php aswell

// Set this string to cart content if no items are in the cart
const cartContentString = `
    <div id="cart-info">
        <h1 id="cart-info-title">Har hamnar det rätter du beställer.</h1>
        <p>Gå in på en kategori till vänster ock klicka på + för att lägga till i korgen och - för att ta bort från korgen. Smaklig måltid! </p>
    </div>
    `

// Get form to be able to submit order
const menuForm = document.querySelector('#menu-form');

// Checks for KeepTab:cb<id> in url and if it is there, it will keep the tab open
let url = new URL(window.location.href);
let params = new URLSearchParams(url.search);
const string = params.get("ret-msg") || "";
if(string.includes("KeepTab:cb2")) {
    console.log(string.split(":")[2]);
    content[0].style.scale = 1;
    content[0].style.zIndex = 1;
    menuButton.style.right = '0vw';
    menuButton.style.zIndex = 1;
    bookButton.style.zIndex = 0;
    content[1].style.zIndex = 0;
    content[1].style.scale = 0;
}
if(string.includes("KeepTab:cb1")) {
    content[1].style.scale = 1;
    content[1].style.zIndex = 1;
    bookButton.style.right = '0vw';
    bookButton.style.zIndex = 1;
    menuButton.style.zIndex = 0;
    content[0].style.zIndex = 0;
    content[0].style.scale = 0;
}

let foodCopy = food;

// Add a variable called "Amount" to every item in foodCopy
for (let item in foodCopy) {
    foodCopy[item].Amount = 0;
}

// This function is used to change the amount of an item in the cart and also handle a bunch of updates when an item is 
// added or removed from the order
function changeAmount(item, displayName, increment) {
    let displays = document.querySelectorAll(displayName);
    let priceDisplay = document.querySelector('#price-display');

    for(let i = 0; i < displays.length; i++) {
        displays[i].innerHTML = parseInt(displays[i].innerHTML.split(" ")[0]) + increment <= 0 ? 0 : parseInt(displays[i].innerHTML.split(" ")[0]) + increment + " st";
    }
    foodCopy[item].Amount += increment;

    if(foodCopy[item].Amount <= 0) {
        try{
            document.querySelector('#' + item + '-cart').remove();
        }
        catch(error){}
        if(document.querySelector('.cart-item') == null) {
            cartContent.innerHTML = cartContentString;
        }
    }

    if(parseFloat(priceDisplay.innerHTML.split(": ")[1].replace("kr","")) + foodCopy[item].price * increment <= 0) {
        priceDisplay.innerHTML = `Price: 0kr`;
    }else {
        priceDisplay.innerHTML = `Price: ${parseFloat(priceDisplay.innerHTML.split(": ")[1].replace("kr","")) + foodCopy[item].price * increment}kr`;
    }
}

async function fetchData(fetchUrl, objectToSend) {
    try {
        const response = await fetch(fetchUrl, {
            method: "POST",
            body: JSON.stringify(objectToSend)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const resultFromPHP = await response.text();
        // Process or use the resultFromPHP as needed
        console.log(resultFromPHP);
        return resultFromPHP;

    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
}

// When order is ready and shipped, convert items into string and send that to _foodHelper using POST to be handled and put into database
async function order() {
    let response = "";
    var fetchUrl = window.location.origin + window.location.pathname;
    if(window.location.href.includes("index.php")){
        fetchUrl = redirectLink.split("index.php")[0] + "_checkOrderNumber.php?ordercode=";
    }else{
        fetchUrl += "_checkOrderNumber.php?ordercode=";
    }

    var dataToSend = document.querySelector("#order-code").value; // Set the value you want to send to PHP
    var fetchUrl = fetchUrl + encodeURIComponent(dataToSend);

    response = await fetchData(fetchUrl, {ordercode: dataToSend});
    if(response == "SUCCESS") {
        let result = ""
        for(let item in foodCopy) {
            for(let i = 0; i < foodCopy[item].Amount; i++) {
                result += foodCopy[item].name + "§";
            }
        }
        if(result.length > 0) {
            fetchUrl = window.location.origin + window.location.pathname;
            if(window.location.href.includes("index.php")){
                fetchUrl = fetchurl.split("index.php")[0] + "_foodHelper.php";
            }else{
                fetchUrl += "_foodHelper.php";
            }
            let orderState = "";
            orderState = await fetchData(fetchUrl, {order: result});
            console.log(orderState)
            if(orderState == "SUCCESS") {
                for(let item in foodCopy) {
                    foodCopy[item].Amount = 0;
                    document.querySelectorAll("." + item + "-counter")[0].innerHTML = "0 st";
                }
                document.querySelector('#price-display').innerHTML = "Price: 0kr";
                document.querySelector('#order-code').value = "";
                document.querySelector("#menu-order-bottom").innerHTML = `<div id="menu-order-main"><p id="price-display">Price: 0kr</p><input type="number" id="order-code" placeholder="Order Code" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"><button id="order-button" onclick="order()">Order</button></div><div id="menu-ret-msg"><p id="ret-msg-p">Order Info:</p><p id="ret-msg-m" class="menu-tab-ret-msg ret-msg-success"> Order successfully placed!</p></div>`;
            }else{
                document.querySelector("#menu-order-bottom").innerHTML = `<div id="menu-order-main"><p id="price-display">Price: ${document.querySelector('#price-display').innerHTML.split(": ")[1].replace("kr","")}kr</p><input type="number" id="order-code" placeholder="Order Code" value="${document.querySelector('#order-code').value}" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"><button id="order-button" onclick="order()">Order</button></div><div id="menu-ret-msg"><p id="ret-msg-p">Order Info:</p><p id="ret-msg-m" class="menu-tab-ret-msg ret-msg-failed"> Order was not placed</p></div>`;
            }

            
        }else{
            alert("You have no items in your cart!");
        }
    }else {
        alert("Order code invalid!")
    }
}

//Open up the menu content and close the book content
menuButton.addEventListener('mousedown', () => {
    if(content[0].style.scale == 1) {
        content[0].style.scale = 0;
        content[0].style.zIndex = 0;
        menuButton.style.right = '-1vw';
    }else{
        content[0].style.scale = 1;
        content[0].style.zIndex = 10;
        menuButton.style.right = '0vw';
        menuButton.style.zIndex = 1;

        //To move the other buttons label up to be visible
        menuLabel.style.position = "absolute";
        menuLabel.style.top = "15px";
        bookLabel.style.position = "relative";
    }

    bookButton.style.right = '-1vw';
    bookButton.style.zIndex = 0;
    content[1].style.zIndex = 0;
    content[1].style.scale = 0;
});

//Open up the book content and close the menu content
bookButton.addEventListener('mousedown', () => {
    if(content[1].style.scale == 1) {
        content[1].style.scale = 0;
        content[1].style.zIndex = 0;
        bookButton.style.right = '-1vw';
    }else{
        content[1].style.scale = 1;
        content[1].style.zIndex = 10;
        bookButton.style.right = '0vw';
        bookButton.style.zIndex = 1;

        //To move the other buttons label down to be visible
        bookLabel.style.position = "absolute";
        bookLabel.style.bottom = "15px";
        menuLabel.style.position = "relative";
    }

    menuButton.style.right = '-1vw';
    menuButton.style.zIndex = 0;
    content[0].style.zIndex = 0;
    content[0].style.scale = 0;
});

// Function to display the correct content when a sidebar button is pressed
function foodContentDisplay(flex){
    hamburgerContent.style.display = "none";
    meatContent.style.display = "none";
    saladContent.style.display = "none";
    drinkContent.style.display = "none";
    desertContent.style.display = "none";
    cartContent.style.display = "none";

    // Remove selected-menu-category from all buttons and add it to the one that was pressed, also set the display to flex for the correct content
    hamburgerButton.classList.remove("selected-menu-category")
    meatButton.classList.remove("selected-menu-category")
    saladButton.classList.remove("selected-menu-category")
    drinkButton.classList.remove("selected-menu-category")
    desertButton.classList.remove("selected-menu-category")
    cartButton.classList.remove("selected-menu-category")
    cartContent.innerHTML = "";
    switch(flex){
        case 'hamburger':
            hamburgerContent.style.display = "flex"
            hamburgerButton.classList.add("selected-menu-category")
            break;
        case 'meat':
            meatContent.style.display = "flex"
            meatButton.classList.add("selected-menu-category")
            break;
        case 'salad':
            saladContent.style.display = "flex"
            saladButton.classList.add("selected-menu-category")
            break;
        case 'drink':
            drinkContent.style.display = "flex"
            drinkButton.classList.add("selected-menu-category")
            break;
        case 'desert':
            desertContent.style.display = "flex"
            desertButton.classList.add("selected-menu-category")
            break;
        case 'cart':
            cartContent.style.display = "flex"
            cartButton.classList.add("selected-menu-category")
            break;
    }
}

// Add event listeners to all sidebar buttons and also generate the cart content when the cart button is pressed
hamburgerButton.addEventListener('mousedown', () => {foodContentDisplay("hamburger")});
meatButton.addEventListener('mousedown', () => {foodContentDisplay("meat")});
saladButton.addEventListener('mousedown', () => {foodContentDisplay("salad")});
drinkButton.addEventListener('mousedown', () => {foodContentDisplay("drink")});
desertButton.addEventListener('mousedown', () => {foodContentDisplay("desert")});
cartButton.addEventListener('mousedown', () => {
    foodContentDisplay("cart")
    for(let item in foodCopy) {
        if(foodCopy[item].Amount > 0) {
            cartContent.innerHTML += `
            <div class="menu-item cart-item" id="${item}-cart">
                <img src="media/food/${foodCopy[item].category}/${item}.png">
                <div class="menu-item-info">
                    <h2 class="whiteText">${foodCopy[item].name}</h2>
                    <div class="menu-items-btn-div">
                        <button class="menu-items-btn-negative" onclick="changeAmount('${item}','.${item}-counter', -1)">-</button>
                        <p class="increment-counter ${item}-counter">${document.querySelectorAll("." + item + "-counter")[0].innerHTML}</p>
                        <button class="menu-items-btn-positive" onclick="changeAmount('${item}','.${item}-counter', 1)">+</button>
                    </div>
                    <p class="item-price-display">${foodCopy[item].price}kr</p>
                </div>
            </div>`
        }
    }
    if(cartContent.innerHTML == "") {
        cartContent.innerHTML = cartContentString;
    }
});

let togen_use_category;

// Menu HTML generator, generate the whole menu content from food.js (foodCopy variable)
console.groupCollapsed("Menu generator:");
console.log("Starting generation/population of food items...");
for (let togen_item in foodCopy) {
    togen_id = togen_item
    togen_item = foodCopy[togen_item]
    // Hamburger
    if (togen_item.category === "hamburgers") {
        togen_use_category = hamburgerContent
    }
    // Meat
    if (togen_item.category === "meat") {
        togen_use_category = meatContent
    }
    // Salad
    if (togen_item.category === "salad") {
        togen_use_category = saladContent
    }
    // Drinks
    if (togen_item.category === "drinks") {
        togen_use_category = drinkContent
    }
    // Deserts
    if (togen_item.category === "deserts") {
        togen_use_category = desertContent
    }
    
    // Generate
    console.log("Populating '"+togen_item.category+"' with item: '"+togen_id+"', name: '"+togen_item.name+"'")
    togen_use_category.innerHTML += `
    <div class="menu-item">
        <img src="${togen_item.picture}">
        <div class="menu-item-info">
            <h2 class="whiteText">${togen_item.name}</h2>
            <div class="menu-items-btn-div">
                <button class="menu-items-btn-negative" onclick="changeAmount('${togen_id}','.${togen_id}-counter', -1)">-</button>
                <p class="increment-counter ${togen_id}-counter">0 st</p>
                <button class="menu-items-btn-positive" onclick="changeAmount('${togen_id}','.${togen_id}-counter', 1)">+</button>
            </div>
            <p class="item-price-display">${togen_item.price}kr</p>
        </div>
    </div>
    `
}
console.log("Done!");
console.groupEnd();