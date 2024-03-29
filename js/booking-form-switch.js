// Retrive by id
const formSeg1 = document.getElementById('booking-form-seg1');
const formSeg2 = document.getElementById('booking-form-seg2');
const formSeg3 = document.getElementById('booking-form-seg3');

const decrBtn = document.getElementById('form-decrement-btn');
const incrBtn = document.getElementById('form-increment-btn');
const sendBtn = document.getElementById('form-send-btn');

const datepic = document.getElementById('booking-form-inp-dt');
const tablpic = document.getElementById('booking-form-inp-tb');

const retMsgObj = document.getElementsByClassName('book-tab-ret-msg')[0];
const dtRtMsg = "Please fill-in date before hitting next!";

// Setup vars
let segIndex = 0;
const min = 0;
const max = 2;

// Function to reload the page with a mesage
function reloadPgWithMsg(msg) {
    // Get the current URL
    var currentUrl = window.location.href;

    // Check if the URL already has parameters
    var urlParts = currentUrl.split('?');
    var baseUrl = urlParts[0];
    var params = urlParts[1] ? urlParts[1].split('&') : [];

    var retMsgFound = false;

    // Update or add the "ret-msg" parameter with the provided message
    for (var i = 0; i < params.length; i++) {
        var param = params[i].split('=');
        if (param[0] === 'ret-msg') {
            retMsgFound = true;
            params[i] = "".concat(param[0],"=",encodeURIComponent(msg));
            break;
        }
    }

    // If "ret-msg" parameter is not found, add it
    if (!retMsgFound) {
        params.push('ret-msg=' + encodeURIComponent(msg));
    }

    // Construct the updated URL
    var updatedUrl = baseUrl + (params.length > 0 ? '?' + params.join('&') : '');

    // Reload the page with the updated URL
    window.location.href = updatedUrl;
}

// Function to check table avaliablity by calling php letting php filter and getting the data again
function updateTbAvaliability(index) {
    unavaliable = [];
    if (index == 1) {
        // Get date
        choosenDate = datepic.value.split("T")[0]  //yyyy-MM-ddThh-mm  =>  yyyy-MM-dd [T] hh-mm  =>  yyyy-MM-dd
        // Check validity of choosenDate if invalid return with ret-msg
        if (choosenDate == "") {
            reloadPgWithMsg("KeepTab:cb2:".concat(dtRtMsg))
        } else {
            if (retMsgObj) {
                if (retMsgObj.innerHTML.includes(dtRtMsg)) {
                    retMsgObj.style.display = "None";
                }
            }
        }
        // Get Dates from php by calling
        fetch("_get-booked-dates_helper.php?datetime=".concat(choosenDate), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        })
        // Take it as text so it can be safely parsed bellow rather then response.json()
        .then(response => response.text())
        .then(response => {
            // Try catch errors so they can be displayed incase-of-error
            try {
                // parse the json
                response = JSON.parse(response);
                strBuild = "";
                // loop the elements
                for (let elem in response) {
                    // Preselect first element
                    elem = response[elem];
                    // If the first one is false this means we didn't get the elements and instead got an error-msg from _functions.php piped through _get-booked-dates_helper.php, so throw it so the previous try/catch can catch it.
                    if (response[0] == false) {
                        throw new Error('No elem: '.concat(response));
                    }
                    // generate the HTML
                    if (elem == response[0]) {
                        strBuild = '<option value="'.concat(elem,'" selected>',elem,'</option>');
                    } else {
                        strBuild += '<option value="'.concat(elem,'">',elem,'</option>');
                    }
                }
                // debug
                console.log(response);
                console.log(strBuild);
                tablpic.innerHTML = strBuild;
            } catch (error) {
                // if catched display it
                formSeg2.innerHTML += '<p class="whiteText"><b>PHP Error: </b><p class="book-form-error-php">'.concat(response[1]).concat("</p></p>");
                console.log(error);
            }
        }
        )
       //.then(response => console.log(response.text()))
    }
    console.log(unavaliable);
}

// function to toggle elements for the diff segments
function setSegment(index) {
    if (index == 0) {
        formSeg1.style.display = "block";
        formSeg2.style.display = "None";
        formSeg3.style.display = "None";
        sendBtn.style.display = "None";
    } else if (index == 1) {
        formSeg1.style.display = "None";
        formSeg2.style.display = "block";
        formSeg3.style.display = "None";
        sendBtn.style.display = "None";
    } else if (index == 2) {
        formSeg1.style.display = "None";
        formSeg2.style.display = "None";
        formSeg3.style.display = "block";
        sendBtn.style.display = "inline-block";
    }
}

// update which butons are shown next/back/send
function updBtns(index) {
    if (index == min) {
        decrBtn.style.display = "None";
        incrBtn.style.display = "inline-block";
    } else if (index == max) {
        decrBtn.style.display = "inline-block";
        incrBtn.style.display = "None";
    } else {
        decrBtn.style.display = "inline-block";
        incrBtn.style.display = "inline-block";
    }
}

// go to next segment
function incrementBookingFormSegment() {
    segIndex += 1;
    if (segIndex > max) { segIndex = max };
    setSegment(segIndex);
    updBtns(segIndex);
    updateTbAvaliability(segIndex);
}

// go to previous segment
function decrementBookingFormSegment() {
    segIndex -=1 ;
    if (segIndex < min) { segIndex = min };
    setSegment(segIndex);
    updBtns(segIndex);
}
