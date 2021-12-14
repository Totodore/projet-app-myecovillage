<div class="container">
	<form>
		<div id="titreconnexion">Inscription</div>
		<div class="logoconnexion">
			<a href="Test2.html" title="Home"><img id="logo" src="/<?php echo $baseUrl ?>/public/images/MyEcoVillage_png.png" alt="logo my EcoVillage" /></img>
			</a>
		</div>
		<div class="inputs">
			<input type="text" placeholder="Nom"></input>
			<input type="text" placeholder="Prénom"></input>
			<input type="email" placeholder="Email"></input>
			<input type="password" placeholder="Mot de passe"></input>
			<input type="password" placeholder="Confirmer le mot de passe"></input>
			<div class="datenaissance">
				<p id="datenaissance">Date de naissance</p>
				<input type="date"></input>
			</div>
			<input type="number" min="10" max="300" placeholder="Taille (cm)"></input>
			<input type="number" min="10" max="200"  placeholder="Poids (kg)"></input>

		</div>
		<p class="inscription">J'ai déjà un <a id="creer" href="connexion.html">compte.</a> Je me <a id="creer" href="connexion.html">connecte</a></p>
		<div class="buttonconnexion">
			<a class="buttonins" href="connexion.html">S'inscrire</a>
		</div>
	</form>
</div>