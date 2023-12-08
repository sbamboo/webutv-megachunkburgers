// Overlap function between two sidebar buttons and also make them work
let menuButton = document.querySelector('#menu-button, #menu-button p');
let bookButton = document.querySelector('#book-button, #book-button p');

const menuPage = document.querySelector('#menu-content');
const bookPage = document.querySelector('#book-content');

let menuActive = false;
let bookActive = false;

menuButton.addEventListener('mouseover', () => { 
    menuButton.style.zIndex = 1;
    bookButton.style.zIndex = 0;
},false);
bookButton.addEventListener('mouseover', () => {
    bookButton.style.zIndex = 1;
    menuButton.style.zIndex = 0;
},false);


menuButton.addEventListener('mousedown', () => {
    if(menuActive == true) {
        menuActive = false;
        menuPage.style.left = "-1500px";
    }
    else {
        menuActive = true;
        menuPage.style.left = "10%";
        bookActive = false;
        bookPage.style.left = "-1500px";
    }
},false);

bookButton.addEventListener('mousedown', () => {
    if(bookActive == true) {
        bookActive = false;
        bookPage.style.left = "-1500px";
    }
    else {
        bookActive = true;
        bookPage.style.left = "10%";
        menuActive = false;
        menuPage.style.left = "-1500px";
    }
},false);
