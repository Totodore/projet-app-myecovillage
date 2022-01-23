<div class="forum-wrapper">
	<h2>Gestion du forum</h2>
	<div class="forum-list">
		<?php foreach ($forums as $forum) { ?>
			<div class="forum" data-id="<?php echo $forum->id ?>">
				<div class="forum-info">
					<div class="forum-name"><?php echo htmlspecialchars($forum->question) ?></div>
					<div class="forum-email"><?php echo htmlspecialchars($forum->getAuthor()->getFullName()) ?> le <?php echo $forum->date->format('d/m/Y') ?></div>
				</div>
				<div class="forum-actions">
					<button class="action-delete"><span class="material-icons">delete</span></button>
				</div>
			</div>
		<?php } ?>
	</div>