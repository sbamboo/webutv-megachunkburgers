// Overlap function between two sidebar buttons
let menuButton = document.querySelector('#menu-button, #menu-button p')
let bookButton = document.querySelector('#book-button, #book-button p')

menuButton.addEventListener('mouseover', (event) => { 
    menuButton.style.zIndex = 1
    bookButton.style.zIndex = 0
},false)
bookButton.addEventListener('mouseover', (event) => {
    bookButton.style.zIndex = 1
    menuButton.style.zIndex = 0
},false)
