<div class="ticket-wrapper">
	<div class="block-ticket">
		<div class="current-tickets">
			<h2>Administration : Tickets ouverts</h2>
			<?php foreach ($openedTickets as $ticket) { ?>
				<div class="ticket">
					<h4 class="name"><?php echo htmlspecialchars($ticket->getAuthor()->getFullName()) ?> | <?php echo htmlspecialchars($ticket->getAuthor()->email); ?></h4>
					<h4><?php echo htmlspecialchars($ticket->title) ?></h4>
					<p class="question"><?php echo htmlspecialchars($ticket->question) ?></p>
					<span class="ticket-date">Le <?php echo $ticket->date->format('d/m/Y') ?></span>
					<button class="answer-btn">Répondre <span class="material-icons">expand_more</span></button>
					<div class="answer-form">
						<form>
							<textarea name="answer" placeholder="Réponse"></textarea>
							<input type="text" readonly style="display: none" name="id" id="el-id" value="<?php echo $ticket->id ?>" />
							<input type="submit" class="answer-btn" value="Envoyer" />
						</form>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="block-ticket">
		<div class="closed-tickets">
			<h2>Administration : Tickets résolus</h2>
			<?php foreach ($closedTickets as $ticket) { ?>
				<div class="ticket">
					<h4 class="name"><?php echo htmlspecialchars($ticket->getAuthor()->getFullName()) ?> | <?php echo htmlspecialchars($ticket->getAuthor()->email); ?></h4>
					<h4><?php echo htmlspecialchars($ticket->title) ?></h4>
					<p class="question"><?php echo htmlspecialchars($ticket->question) ?></p>
					<h4 class="admin">Réponse de : <?php echo htmlspecialchars($ticket->getAdmin()->getFullName()) ?> (Administrateur)</h4>
					<p class="answer"><?php echo htmlspecialchars($ticket->answer) ?></p>
					<span class="ticket-date">Réponse le <?php echo $ticket->date->format('d/m/Y') ?></span>
				</div>
			<?php } ?>
		</div>
	</div>
</div>