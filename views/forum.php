<div class="block_forum">
	<h1>Forum</h1>
	<div class="forum-wrapper">
		<h2>Poser votre question à la communauté</h2>
		<div class="block-forum-content">
			<form id="ask-form">
				<textarea name="question" id="question" placeholder="Votre question" maxlength="300"></textarea>
				<input type="submit" value="Envoyer">
			</form>
		</div>
	</div>
	<?php foreach ($forums as $forum) { ?>
		<div class="forum-wrapper">
			<div class="questions">
				<p class="question-content"><?php echo $forum->question ?></p>
				<p class="question-by"><?php echo $forum->getAuthor()->getFullName() ?> le <?php echo $forum->date->format('d/m/Y') ?></p>
				<span class="material-icons">expand_more</span>
			</div>
			<div class="réponse">
				<?php if ($forum->answer != null) { ?>
					<p class="answer-p">
						<?php echo $forum->answer ?>
					</p>
					<p class="answer-date"><?php echo $forum->getAnswer()->getFullName() ?> le <?php echo $forum->answerdate->format('d/m/Y') ?></p>
				<?php } else { ?>
					<form id="answer-form">
						<input type="text" name="id" readonly style="display: none" value="<?php echo $forum->id ?>">
						<textarea name="answer" id="answer" placeholder="Votre réponse" ></textarea>
						<input type="submit" value="Répondre">
					</form>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>