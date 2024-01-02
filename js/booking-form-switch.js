const formSeg1 = document.getElementById('booking-form-seg1');
const formSeg2 = document.getElementById('booking-form-seg2');
const formSeg3 = document.getElementById('booking-form-seg3');

const decrBtn = document.getElementById('form-decrement-btn');
const incrBtn = document.getElementById('form-increment-btn');
const sendBtn = document.getElementById('form-send-btn');

const datepic = document.getElementById('booking-form-inp-dt');
const tablpic = document.getElementById('booking-form-inp-tb')

let segIndex = 0;
const min = 0;
const max = 2;

function updateTbAvaliability(index) {
    unavaliable = [];
    if (index == 1) {
        // Get date
        choosenDate = datepic.value.split("T")[0]  //yyyy-MM-ddThh-mm  =>  yyyy-MM-dd T hh-mm  =>  yyyy-MM-dd
        // Get Dates from php by calling
        fetch("_get-booked-dates_helper.php?datetime=".concat(choosenDate), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(response => {
            strBuild = "";
            for (let elem in response) {
                elem = response[elem];
                strBuild += '<option value="'.concat(elem,'">',elem,'</option>')
            }
            console.log(response);
            console.log(strBuild);
            tablpic.innerHTML = strBuild
        }
        )
    }
    console.log(unavaliable);
}

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

function incrementBookingFormSegment() {
    segIndex += 1;
    if (segIndex > max) { segIndex = max };
    setSegment(segIndex);
    updBtns(segIndex);
    updateTbAvaliability(segIndex);
}

function decrementBookingFormSegment() {
    segIndex -=1 ;
    if (segIndex < min) { segIndex = min };
    setSegment(segIndex);
    updBtns(segIndex);
}