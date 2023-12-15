// Overlap function between two sidebar buttons and also make them work
const menuButton = document.querySelector('#tab2');
const bookButton = document.querySelector('#tab1');

let content = document.querySelectorAll('.sidebar-content');

const acontent = '<audio autoplay><source src="../media/sound.mp3" type="audio/mp3"></audio>';

menuButton.addEventListener('mousedown', () => {
    if(document.getElementById('cb2').checked == true) {
        content[0].style.scale = 0;
        content[0].style.zIndex = 0;
    }else{
        content[0].style.scale = 1;
        content[0].style.zIndex = 1;

    }

    //uncheck every other checkbox
    document.getElementById('cb1').checked = false;
    content[1].style.scale = 0;
});
bookButton.addEventListener('mousedown', () => {
    if(document.getElementById('cb1').checked == true) {
        content[1].style.scale = 0;
        content[1].style.zIndex = 0;
    }else{
        content[1].style.scale = 1;
        content[1].style.zIndex = 1;
    }

    document.getElementById('cb2').checked = false;
    content[0].style.scale = 0;
});
