var n = 100; // Nombre final du compteur
var cpt = 0; // Initialisation du compteur
var duree = 5; // Durée en seconde pendant laquel le compteur ira de 0 à 15
var delta = Math.ceil((duree * 1000) / n); // On calcule l'intervalle de temps entre chaque rafraîchissement du compteur (durée mise en milliseconde)
var node = document.getElementById("compteur"); // On récupère notre noeud où sera rafraîchi la valeur du compteur

function countdown() {
    node.innerHTML = ++cpt * 10;
    if (cpt * 10 < n) { // Si on est pas arrivé à la valeur finale, on relance notre compteur une nouvelle fois
        setTimeout(countdown, delta);
    }
}

setTimeout(countdown, delta);