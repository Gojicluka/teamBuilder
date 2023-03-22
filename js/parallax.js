var parallax = document.getElementById("pa");
var parallax2 = document.getElementById("pa2");
var parallax3 = document.getElementById("pa3");
var parallax4 = document.getElementById("pa4");
window.addEventListener("scroll",function (){
   let offset = window.pageYOffset;
   parallax.style.backgroundPositionY = -offset * 0.2 + "px";
   
})