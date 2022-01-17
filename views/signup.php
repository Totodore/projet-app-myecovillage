<div class="container">
	<form>
		<div id="titreconnexion">Inscription</div>
		<div class="logoconnexion">
			<a href="Test2.html" title="Home"><img id="logo" src="/<?php echo $baseUrl ?>/public/images/MyEcoVillage_png.png" alt="logo my EcoVillage" /></img>
			</a>
		</div>
		<div class="inputs">
			<input name="name" type="text" placeholder="Nom"></input>
			<input name="firstname" type="text" placeholder="Prénom"></input>
			<input name="email" type="email" placeholder="Email"></input>
			<div class="password-wrapper">
				<input name="password" type="password" placeholder="Mot de passe"></input>
				<span class="material-icons">visibility</span>
			</div>
			<div class="password-wrapper">
				<input name="repeatPassword" type="password" placeholder="Confirmer le mot de passe"></input>
				<span class="material-icons">visibility</span>
			</div>
			<div class="datenaissance">
				<p id="datenaissance">Date de naissance</p>
				<input name="birthdate" type="date"></input>
			</div>
			<input name="height" type="number" min="10" max="300" placeholder="Taille (cm)"></input>
			<input name="weight" type="number" min="10" max="200"  placeholder="Poids (kg)"></input>

		</div>
		<p class="inscription">J'ai déjà un <a id="creer" href="connexion.html">compte.</a> Je me <a id="creer" href="connexion.html">connecte</a></p>
		<div class="buttonconnexion">
			<button class="buttonins" type="submit">S'inscrire</button>
		</div>
	</form>
</div>