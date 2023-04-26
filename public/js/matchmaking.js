const decline = document.querySelector(".button-l");
const like = document.querySelector(".button-r");
const move = document.getElementById("move");

decline.addEventListener('click', () => {
    move.classList.toggle("slide-left")
    document.getElementById("pass").submit();
    setTimeout(function(){
        location.reload();
    },600);
});

like.addEventListener('click', () => {
    move.classList.toggle("slide-right")
    document.getElementById("smash").submit();
    setTimeout(function(){
        location.reload();
    },600);
});

document.getElementById("myButton").disabled = true;
setTimeout(function(){
    document.getElementById("myButton").disabled = false;
},2000);

document.getElementById("myButton2").disabled = true;
setTimeout(function(){
    document.getElementById("myButton2").disabled = false;
},2000);


function btnCooldown() {
    document.getElementById("myButton").disabled = true;
    setTimeout(function(){
        document.getElementById("myButton").disabled = false;
    },8000);
    document.getElementById("myButton2").disabled = true;
    setTimeout(function(){
        document.getElementById("myButton2").disabled = false;
    },8000);
}
