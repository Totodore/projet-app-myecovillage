<div class="user-wrapper">
	<h2>Utilisateurs</h2>
	<div class="user-list">
		<div class="search-user-admin user">
			<span class="material-icons search-icon">search</span>
			<input type="text" name="search" autocomplete="off" placeholder="Rechercher un utilisateur" id="search-user">
		</div>
		<?php foreach ($users as $user) { ?>
			<div class="user" data-id="<?php echo $user->id ?>" data-isadmin="<?php echo $user->isadmin ?>" data-name="<?php echo $user->getFullName() ?>">
				<div class="user-info">
					<div class="user-name"><?php echo htmlspecialchars($user->getFullName()) ?></div>
					<div class="user-email"><?php echo htmlspecialchars($user->email) ?></div>
				</div>
				<div class="user-actions">
					<button class="action-admin">Administrateur <span class="material-icons"><?php echo $user->isadmin ? 'done' : 'close' ?></span></button>
					<button class="action-delete"><span class="material-icons">delete</span></button>
				</div>
			</div>
		<?php } ?>
	</div>