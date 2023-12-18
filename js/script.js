// Overlap function between two sidebar buttons and also make them work
const menuButton = document.querySelector('#tab2');
const bookButton = document.querySelector('#tab1');

let content = document.querySelectorAll('.sidebar-content');

//const acontent = '<audio autoplay id="music"><source src="media/buttonsound.mp3" type="audio/mp3"></audio>';
//const parent = document.querySelector('#music');


// Checks for keeptabcb? in url and if it is there, it will keep the tab open
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const string = urlParams.get("ret-msg");
if(string.includes("keeptab:cb1")) {
    content[0].style.scale = 1;
    content[0].style.zIndex = 1;
    menuButton.style.right = '0vw';
    menuButton.style.zIndex = 1;
    content[1].style.zIndex = 0;
    content[1].style.scale = 0;
}
if(string.includes("keeptab:cb2")) {
    content[1].style.scale = 1;
    content[1].style.zIndex = 1;
    bookButton.style.right = '0vw';
    bookButton.style.zIndex = 1;
    content[0].style.zIndex = 0;
    content[0].style.scale = 0;
}

function changeAmount(item, displayName, amount) {
    document.querySelector(displayName).innerHTML = parseInt(document.querySelector(displayName).innerHTML) + amount;

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
