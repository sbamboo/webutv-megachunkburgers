const formSeg1 = document.getElementById('booking-form-seg1');
const formSeg2 = document.getElementById('booking-form-seg2');
const formSeg3 = document.getElementById('booking-form-seg3');

const decrBtn = document.getElementById('form-decrement-btn');
const incrBtn = document.getElementById('form-increment-btn');
const sendBtn = document.getElementById('form-send-btn');

let segIndex = 0;
const min = 0;
const max = 2;

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
}

function decrementBookingFormSegment() {
    segIndex -=1 ;
    if (segIndex < min) { segIndex = min };
    setSegment(segIndex);
    updBtns(segIndex);
}