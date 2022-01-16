<div class="container_profil">
	<div id="conteneurPE">

		<div class="elementPE">
			<div class="titreinformation">Informations utilisateur</div>
			<!-- <span class="text_info">Identifiant : (debug)
						<?php
						// echo $user->id; 
						?> 
					</span> -->
			</p>
			<span class="text_info">Nom :
				<?php
				echo $user->name;
				?>
			</span>
			</p>
			<span class="text_info">Prenom :
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
			<span class="text_info">Mail :
				<?php
				echo $user->email;
				?>
			</span>
			</p>
			<span class="text_info">Administrateur :
				<?php
				if ($user->isadmin == true) {
					echo "admin";
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