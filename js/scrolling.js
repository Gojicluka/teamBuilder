
window.addEventListener("scroll", function () {
    
    let offset = window.pageYOffset;
    var header = document.getElementById("header");
    if (offset >( 1)) {
        
        header.style.transition = "all 0.3s ease 0s";
        header.style.backgroundColor = "#101823";
    } else if(window.innerWidth>951) {
        header.style.transition = "all 0.3s ease 0s";
        header.style.backgroundColor = "rgba(255, 255, 255, 0)";
        
    }
    //document.getElementById("drugidiv").style.backgroundPositionY = -offset * 0.2 + "px";
});

