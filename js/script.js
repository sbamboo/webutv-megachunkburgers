// Overlap function between two sidebar buttons and also make them work
const menuButton = document.querySelectorAll('#tab1, #tab1 label');
const bookButton = document.querySelectorAll('#tab2, #tab2 label');
const adminButton = document.querySelectorAll('#tab3, #tab3 label');

menuButton.forEach(button => button.addEventListener('mousedown', () => {

    //set every index to 0 other than targeted button
    menuButton[0].style.zIndex = 1;
    bookButton[0].style.zIndex = 0;
    adminButton[0].style.zIndex = 0;

    //uncheck every other checkbox
    document.getElementById('#cb3').checked = false;
    document.getElementById('#cb2').checked = false;
}));
bookButton.forEach(button => button.addEventListener('mousedown', () => {

    //set every index to 0 other than targeted button
    menuButton[0].style.zIndex = 0;
    bookButton[0].style.zIndex = 1;
    adminButton[0].style.zIndex = 0;

    //uncheck every other checkbox
    document.getElementById('#cb1').checked = false;
    document.getElementById('#cb3').checked = false;
}));
adminButton.forEach(button => button.addEventListener('mousedown', () => {

    //set every index to 0 other than targeted button
    menuButton[0].style.zIndex = 0;
    bookButton[0].style.zIndex = 0;
    adminButton[0].style.zIndex = 1;

    //uncheck every other checkbox
    document.getElementById('#cb1').checked = false;
    document.getElementById('#cb2').checked = false;
}));
