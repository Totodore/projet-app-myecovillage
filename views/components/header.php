<header>
	<div class="progressbar">
		<div class="indeterminate"></div>
	</div>
	<div class="toolbar">

		<a class="home" title="Home">
			<img id="logo" src="/<?php echo $baseUrl ?>/public/images/MyEcoVillage_png.png" alt="logo my EcoVillage" />
		</a>
		<div class="By">
			<span>By</span>
			</br>
			<a class="logo-link" title="PlaneteWise">
				<img id="logo_2" src="/<?php echo $baseUrl ?>/public/images/planete_wise.png" alt="logo planete wise" />
			</a>
		</div>
		<div class="centercolumn">
			<div class="search-wrapper">
				<a class="acceuil">Accueil</a>
				<a class="game">Aller au jeu</a>
				<a class="forum">Forum</a>
				<div class="search-user" style="display: <?php echo ($isLogged ? "flex" : "none") ?>">
					<input autocomplete="off" type="text" name="user" id="user-input" placeholder="Recherche un utilisateur" />
					<button><span class="material-icons">search</span></button>
					<div id="user-list"></div>
				</div>
			</div>
			<div class="button">
				<a class="connexion">Connexion</a>
				<a class="inscription">Inscription</a>
				<a class="account">Mon compte</a>
			</div>
		</div>
		<nav>
			<div class="menu">
				<div class="bar-1"></div>
				<div class="bar-2"></div>
				<div class="bar-3"></div>
				<div class="bar-4"></div>
				<div class="bar-5"></div>

				<div class="dropdown-menu">

					<a class="item mobile-connexion">Connexion</a>
					<a class="item mobile-inscription">Inscription</a>
					<a class="item mobile-account">Mon compte</a>
					<a class="item mobile-game">Aller au jeu</a>
					<a class="item mobile-contact">Contact</a>
					<a class="item mobile-forum">Forum</a>
				</div>

			</div>
		</nav>

</header>