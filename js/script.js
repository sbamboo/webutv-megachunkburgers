// Overlap function between two sidebar buttons and also make them work
const menuButton = document.querySelector('#tab2');
const bookButton = document.querySelector('#tab1');

// Get labels to be able to change their position for visibility
const menuLabel = document.querySelector('#tab1-label');
const bookLabel = document.querySelector('#tab2-label');

let content = document.querySelectorAll('.sidebar-content');

const hamburgerButton = document.querySelector('#hamburger-category-button');
const meatButton = document.querySelector('#meat-category-button');
const saladButton = document.querySelector('#salad-category-button');
const drinkButton = document.querySelector('#drinks-category-button');
const desertButton = document.querySelector('#deserts-category-button');
const cartButton = document.querySelector('#cart-button');

const hamburgerContent = document.querySelector('#hamburger-content');
const meatContent = document.querySelector('#meat-content');
const saladContent = document.querySelector('#salad-content');
const drinkContent = document.querySelector('#drinks-content');
const desertContent = document.querySelector('#deserts-content');
let cartContent = document.querySelector('#cart-content');

//const acontent = '<audio autoplay id="music"><source src="media/buttonsound.mp3" type="audio/mp3"></audio>';
//const parent = document.querySelector('#music');

// Checks for KeepTab:cb<id> in url and if it is there, it will keep the tab open
let url = new URL(window.location.href);
let params = new URLSearchParams(url.search);
let paramstring = "?";
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

const listButton = document.querySelector('#listButton');

let foodCopy = food;

// Add a variable called "Amount" to every item in foodCopy
for (let item in foodCopy) {
    foodCopy[item].Amount = 0;
}
if (params.get("order") != null) { // SM: Added check to fix null-issue
    for(let param in params.get("order").split("§")) {
    }
}

// This function is used to change the amount of an item in the cart
function changeAmount(item, displayName, increment) {
    let displays = document.querySelectorAll(displayName);
    let priceDisplay = document.querySelector('#price-display');

    for(let i = 0; i < displays.length; i++) {
        displays[i].innerHTML = parseInt(displays[i].innerHTML) + increment <= 0 ? 0 : parseInt(displays[i].innerHTML) + increment;
    }
    foodCopy[item].Amount += increment;

    if(foodCopy[item].Amount <= 0) {
        document.querySelector('#' + item + '-cart').remove();
    }

    if(parseFloat(priceDisplay.innerHTML.split("$")[1]) + foodCopy[item].price * increment <= 0) {
        priceDisplay.innerHTML = `Price: $0`;
    }else {
        priceDisplay.innerHTML = `Price: $${parseFloat(priceDisplay.innerHTML.split("$")[1]) + foodCopy[item].price * increment}`;
    }
}
// When order is ready and shipped, convert items into url param and send to index.php to be caught using GET
function order() {
    let result = params.get("order");
    if(result != null) {
        result = result.toString();
    }else {
        result = "";
    }
    for(let item in foodCopy) {
        for(let i = 0; i < foodCopy[item].Amount; i++) {
            result += item + "§";
        }
    }
    params.set("order", result);
    if(string.length == 0 && string.includes("order=") == false) {
        window.location.href = "?" + params.toString();
    }else {
        window.location.href = "&" + params.toString();
    }
}

menuButton.addEventListener('mousedown', () => {
    if(content[0].style.scale == 1) {
        content[0].style.scale = 0;
        content[0].style.zIndex = 0;
        menuButton.style.right = '-1vw';
        //parent.innerHTML = acontent;
    }else{
        content[0].style.scale = 1;
        content[0].style.zIndex = 1;
        menuButton.style.right = '0vw';
        menuButton.style.zIndex = 1;
        //parent.innerHTML = acontent;

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

bookButton.addEventListener('mousedown', () => {
    if(content[1].style.scale == 1) {
        content[1].style.scale = 0;
        content[1].style.zIndex = 0;
        bookButton.style.right = '-1vw';
        //parent.innerHTML = acontent;
    }else{
        content[1].style.scale = 1;
        content[1].style.zIndex = 1;
        bookButton.style.right = '0vw';
        bookButton.style.zIndex = 1;
        //parent.innerHTML = acontent;

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


hamburgerButton.addEventListener('mousedown', () => {
    hamburgerContent.style.display = "flex";
    meatContent.style.display = "none";
    saladContent.style.display = "none";
    drinkContent.style.display = "none";
    desertContent.style.display = "none";
    cartContent.style.display = "none";
    cartContent.innerHTML = "";
});
meatButton.addEventListener('mousedown', () => {
    hamburgerContent.style.display = "none";
    meatContent.style.display = "flex";
    saladContent.style.display = "none";
    drinkContent.style.display = "none";
    desertContent.style.display = "none";
    cartContent.style.display = "none";
    cartContent.innerHTML = "";
});
saladButton.addEventListener('mousedown', () => {
    hamburgerContent.style.display = "none";
    meatContent.style.display = "none";
    saladContent.style.display = "flex";
    drinkContent.style.display = "none";
    desertContent.style.display = "none";
    cartContent.style.display = "none";
    cartContent.innerHTML = "";
});
drinkButton.addEventListener('mousedown', () => {
    hamburgerContent.style.display = "none";
    meatContent.style.display = "none";
    saladContent.style.display = "none";
    drinkContent.style.display = "flex";
    desertContent.style.display = "none";
    cartContent.style.display = "none";
    cartContent.innerHTML = "";
});
desertButton.addEventListener('mousedown', () => {
    hamburgerContent.style.display = "none";
    meatContent.style.display = "none";
    saladContent.style.display = "none";
    drinkContent.style.display = "none";
    desertContent.style.display = "flex";
    cartContent.style.display = "none";
    cartContent.innerHTML = "";
});
cartButton.addEventListener('mousedown', () => {
    hamburgerContent.style.display = "none";
    meatContent.style.display = "none";
    saladContent.style.display = "none";
    drinkContent.style.display = "none";
    desertContent.style.display = "none";
    cartContent.style.display = "flex";
    for(let item in foodCopy) {
        if(foodCopy[item].Amount > 0) {
            console.log(item)
            cartContent.innerHTML += `
            <div class="menu-item" id="${item}-cart">
                <img src="media/food/${foodCopy[item].category}/${item}.png">
                <div class="menu-item-info">
                    <h2>Spicy ${item}</h2>
                    <div class="menu-items-btn-div">
                        <button class="menu-items-btn-positive" onclick="changeAmount('${item}','.${item}-counter', 1)">+</button>
                        <p class="increment-counter ${item}-counter">${document.querySelectorAll("." + item + "-counter")[0].innerHTML}</p>
                        <button class="menu-items-btn-negative" onclick="changeAmount('${item}','.${item}-counter', -1)">-</button>
                    </div>
                    <p>${foodCopy[item].price}</p>
                </div>
            </div>`
        }
    }
});
