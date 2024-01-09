// Function that checks if a sidebar-content element contains a PHP error and then changes some CSS to make the tab visible since the page won't always load correctly when PHP hits an error.
// this is to help with debugging and to more easily see if PHP hits an error since it would otherwise be hidden in pagesource/Elements inspector.
// It also changes some CSS styling to be more clear that an error has occured, it makes the background transparent so you can see how the page looks behind it,
// aswell as adding a message that this script caused the changes.

let errorType = false;

function checkElement() {
    var contents = document.getElementsByClassName('sidebar-content');
    if (contents) {
        for (let content of contents) {
            if (content.innerHTML.includes("Fatal error")) {
                errorType = "Fatal error";
            } else if (content.innerHTML.includes("Uncaught Error:")) {
                errorType = "<Any> Uncaught Error";
            }
            if (errorType != false) {
                console.group("FOUND PHP ERROR!");
                console.log("Printed and changed CSS on page to display more information, but additional information is available bellow:")
                console.log("errorType: ",errorType)
                console.groupCollapsed("innerText %c(Of content element)", "font-style: italic;");
                console.log(content.innerText);
                console.groupEnd();
                console.groupCollapsed("innerHTML %c(Of content element)", "font-style: italic;");
                console.log(content.innerHTML)
                console.groupEnd();
                console.log('%c(ConOut by %cphpErrorCheck.js%c)', 'font-style: italic;', 'font-style: normal; background-color: black; color: white;', 'font-style: italic;');
                console.groupEnd();
                content.style.scale = 1;
                content.style.backgroundColor = "rgba(255, 0, 0, 0.5)";
                content.innerHTML += '\n<i style="color: black">(Interactive elements on this page is likely to be frozen)<br>[Error catched by <i style="background-color: rgba(0,0,0,0.2); color: black">phpErrorCheck.js</i>, so if CSS is broken check what it changes.]</i>'
            }
        }
        clearInterval(checkInterval);
    }
}
  
var checkInterval = setInterval(checkElement, 1000);
  