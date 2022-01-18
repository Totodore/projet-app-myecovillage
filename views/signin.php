<div class="container">
	<form>
		<div id="titreconnexion">Connexion</div>
		<div class="logoconnexion">
			<a href="Test2.html" title="Home"><img id="logo" src="/<?php echo $baseUrl ?>/public/images/MyEcoVillage_png.png" alt="logo my EcoVillage" /></img>
			</a>
		</div>
		<div class="inputs">
			<input name="email" type="email" placeholder="Email" />
			<div class="password-wrapper">
				<input name="password" type="password" placeholder="Mot de passe">
				<span class="material-icons">visibility</span>
			</div>
		</div>

		<p class="inscription">Je n'ai pas de <a id="creer">compte.</a>Je m'en <a id="creer">crée</a> un.</p>
		<div class="buttonconnexion">
			<button type="submit" id="buttonconnexion">Se connecter</button>
		</div>
	</form>
</div>