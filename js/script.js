// Overlap function between two sidebar buttons and also make them work
const menuButton = document.querySelector('#tab2');
const bookButton = document.querySelector('#tab1');

let content = document.querySelectorAll('.sidebar-content');

//const acontent = '<audio autoplay id="music"><source src="media/buttonsound.mp3" type="audio/mp3"></audio>';
//const parent = document.querySelector('#music');

// Checks for keeptabcb? in url and if it is there, it will keep the tab open

let url = new URL(window.location.href);
let params = new URLSearchParams(url.search);
let paramstring = "?";
const string = params.get("ret-msg") || "";
if(string.includes("keeptab:cb2")) {
    console.log(string.split(":")[2]);
    content[0].style.scale = 1;
    content[0].style.zIndex = 1;
    menuButton.style.right = '0vw';
    menuButton.style.zIndex = 1;
    bookButton.style.zIndex = 0;
    content[1].style.zIndex = 0;
    content[1].style.scale = 0;
}
if(string.includes("keeptab:cb1")) {
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
for(let param in params.get("order").split("§")) {
    console.log(params.get("order").split("§")[param]);
}

// This function is used to change the amount of an item in the cart
function changeAmount(item, displayName, increment) {
    document.querySelector(displayName).innerHTML = parseInt(document.querySelector(displayName).innerHTML) + increment;
    foodCopy[item].Amount += increment;
}
// When order is ready and shipped, convert items into url param and send to index.php to be caught using GET
function order() {
    let result = params.get("order").toString();
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
        console.log(content[1].style.zIndex)
        bookButton.style.right = '0vw';
        bookButton.style.zIndex = 1;
        //parent.innerHTML = acontent;
    }

    menuButton.style.right = '-1vw';
    menuButton.style.zIndex = 0;
    content[0].style.zIndex = 0;
    content[0].style.scale = 0;
});
