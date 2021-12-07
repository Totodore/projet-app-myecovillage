document.addEventListener("DOMContentLoaded", () => {

    setTimeout(barAnimation, 2000);
});

function barAnimation() {
    const compteurs = document.querySelectorAll(".compteur");
    for (let compteur of compteurs) {
        let cpt = 0;
        const n = +compteur.getAttribute("data-value");
        const duree = 2;
        const delta = Math.ceil((duree * 1000) / n);

        function countdown() {
            compteur.innerHTML = ++cpt + "%";
            if (cpt < n) {
                setTimeout(countdown, delta);
            }
        }
        countdown();

    }
}