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
const cartContent = document.querySelector('#cart-content');

//const acontent = '<audio autoplay id="music"><source src="media/buttonsound.mp3" type="audio/mp3"></audio>';
//const parent = document.querySelector('#music');

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

// This function is used to change the amount of an item in the cart
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
        catch(error){

        }
    }

    if(parseFloat(priceDisplay.innerHTML.split(": ")[1].replace("kr","")) + foodCopy[item].price * increment <= 0) {
        priceDisplay.innerHTML = `Price: 0kr`;
    }else {
        priceDisplay.innerHTML = `Price: ${parseFloat(priceDisplay.innerHTML.split(": ")[1].replace("kr","")) + foodCopy[item].price * increment}kr`;
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
    window.location.href = "?" + params.toString();
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

function foodContentDisplay(flex){
    hamburgerContent.style.display = "none";
    meatContent.style.display = "none";
    saladContent.style.display = "none";
    drinkContent.style.display = "none";
    desertContent.style.display = "none";
    cartContent.style.display = "none";
    cartContent.innerHTML = "";
    switch(flex){
        case 'hamburger':
            hamburgerContent.style.display = "flex"
            break;
        case 'meat':
            meatContent.style.display = "flex"
            break;
        case 'salad':
            saladContent.style.display = "flex"
            break;
        case 'drink':
            drinkContent.style.display = "flex"
            break;
        case 'desert':
            desertContent.style.display = "flex"
            break;
        case 'cart':
            cartContent.style.display = "flex"
            break;
    }
}

hamburgerButton.addEventListener('mousedown', () => {
   foodContentDisplay("hamburger")
});
meatButton.addEventListener('mousedown', () => {
    foodContentDisplay("meat")
});
saladButton.addEventListener('mousedown', () => {
    foodContentDisplay("salad")
});
drinkButton.addEventListener('mousedown', () => {
    foodContentDisplay("drink")
});
desertButton.addEventListener('mousedown', () => {
    foodContentDisplay("desert")
});
cartButton.addEventListener('mousedown', () => {
    foodContentDisplay("cart")
    for(let item in foodCopy) {
        if(foodCopy[item].Amount > 0) {
            cartContent.innerHTML += `
            <div class="menu-item" id="${item}-cart">
                <img src="media/food/${foodCopy[item].category}/${item}.png">
                <div class="menu-item-info">
                    <h2>Spicy ${item}</h2>
                    <div class="menu-items-btn-div">
                        <button class="menu-items-btn-negative" onclick="changeAmount('${item}','.${item}-counter', -1)">-</button>
                        <p class="increment-counter ${item}-counter">${document.querySelectorAll("." + item + "-counter")[0].innerHTML}</p>
                        <button class="menu-items-btn-positive" onclick="changeAmount('${item}','.${item}-counter', 1)">+</button>
                    </div>
                    <p>${foodCopy[item].price}kr</p>
                </div>
            </div>`
        }
    }
});

let togen_use_category;

// Menu HTML generator
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
            <h2>${togen_item.name}</h2>
            <div class="menu-items-btn-div">
                <button class="menu-items-btn-negative" onclick="changeAmount('${togen_id}','.${togen_id}-counter', -1)">-</button>
                <p class="increment-counter ${togen_id}-counter">0 st</p>
                <button class="menu-items-btn-positive" onclick="changeAmount('${togen_id}','.${togen_id}-counter', 1)">+</button>
            </div>
            <p>${togen_item.price}kr</p>
        </div>
    </div>
    `
}
console.log("Done!");
console.groupEnd();