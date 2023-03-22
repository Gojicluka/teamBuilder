var expanded = false;

function showRanks() {
    var ranks = document.getElementById("ranks");
    if (!expanded) {
        ranks.style.display = "none";
        expanded = true;
    } else {
        ranks.style.display = "block";
        expanded = false;
    }
}