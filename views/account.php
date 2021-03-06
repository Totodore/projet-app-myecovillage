<div class="container_profil">
	<div id="conteneurPE">

		<div class="elementPE">
			<div class="titreinformation"><strong>Mes Informations</strong></div>
			</p>
			<span class="text_info">Nom :
				<?php
				echo $user->name;
				?>
			</span>
			</p>
			<span class="text_info">Prénom :
				<?php
				echo $user->firstname;
				?>
			</span>
			</p>
			<span class="text_info">Date de naissance :
				<?php
				echo $user->birthdate->format('d/m/Y');
				?>
			</span>
			</p>
			<span class="text_info">Taille :
				<?php
				echo $user->height . " cm";
				?>
			</span>
			</p>
			<span class="text_info">Poids :
				<?php
				echo $user->weight . " kg";
				?>
			</span>
			</p>
			<span class="text_info">Email :
				<?php
				echo $user->email;
				?>
			</span>
			</p>
			<span class="text_info">Statut :
				<?php
				if ($user->isadmin == true) {
					echo "administrateur";
				} else {
					echo "utilisateur";
				}
				?>
			</span>
		</div>

		<div class="elementPE">
		<img src="./public/images/user_profil.png" class="image_user" />
		</div>
	</div>

	<?php if ($personal) { ?>
		<div>
			<button class="boutonconnexion1">Editer profil</button>
			<button class="boutondeconnexion">Déconnexion</button>
		</div>
	<?php } ?>
</div>