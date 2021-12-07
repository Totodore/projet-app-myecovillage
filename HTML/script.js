document.addEventListener("DOMContentLoaded", () => {
    var n = +document.querySelector("#compteur").getAttribute("data-value");
    var cpt = 0;
    var duree = 2;
    var delta = Math.ceil((duree * 1000) / n);
    var node = document.getElementById("compteur");

    function countdown() {
        node.innerHTML = ++cpt + "%";
        if (cpt < n) {
            setTimeout(countdown, delta);
        }
    }

    setTimeout(countdown, 2000);
})