// global variable to hold session data
let sessionData = {
    fruits: [],
    note: '',
    balance: 0,
    sessionId: ''
};

// spinning base speed in ms
let spinSpeed = 1000;

// all the elements on the page to reuse them later on
let balance = document.getElementById('balance');
let sessionId = document.getElementById('session-id');
let fruit3 = document.getElementById('fruit3');
let fruit2 = document.getElementById('fruit2');
let fruit1 = document.getElementById('fruit1');
let note = document.getElementById('note');
let spinButton = document.getElementById("spinButton");

async function init(){
    try {
        const res = await fetch('init.php');
        sessionData = await res.json();
        balance.innerText=sessionData.balance;
        sessionId.innerText=sessionData.sessionId;
        note.innerText=sessionData.note;

        fruit3.innerText=sessionData.fruits[0];
        fruit2.innerText=sessionData.fruits[1];
        fruit1.innerText=sessionData.fruits[2];
    } catch(err){
        console.error("Error:", err);
    }
}

async function spin(){
    spinButton.disabled = true;
    note.textContent = 'spinning...';

    // show X while spinning in each block
    [fruit1, fruit2, fruit3].forEach(el => el.innerText = 'X');


    try{
        const res = await fetch('game.php');
        sessionData = await res.json();

        setTimeout(function() {
            fruit3.innerText=sessionData.fruits[0];
        }, spinSpeed);

        setTimeout(function() {
            fruit2.innerText=sessionData.fruits[1];
        }, spinSpeed*2);

        setTimeout(function() {
            fruit1.innerText=sessionData.fruits[2];
            note.innerText=sessionData.note;
            spinButton.disabled = false;
            balance.innerText=sessionData.balance;
        }, spinSpeed*3);


    } catch(err){
        console.error("Error:", err);
    }
}

window.addEventListener("DOMContentLoaded", init);

// force init if the user navigates "back" to game after cashing out
window.addEventListener( "pageshow", function ( event ) {
    let historyTraversal = event.persisted ||
        ( typeof window.performance != "undefined" &&
            window.performance.navigation.type === 2 );
    if ( historyTraversal ) {
        init()
    }
});