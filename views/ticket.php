<div class="block-ticket">
	<h2>J'ai un problème</h2>
	<div class="block-ticket-content">
		<form>
			<input type="text" name="title" id="title" required placeholder="Courte description du problème"><br>
			<textarea name="question" id="question" required maxlength="5000" placeholder="Détails du problème"></textarea><br>
			<input type="submit" value="Envoyer">
		</form>
	</div>
</div>
<?php if (count($openedTickets) > 0) { ?>
	<div class="block-ticket">
		<div class="current-tickets">
			<h2>Mes tickets ouverts</h2>
			<?php foreach ($openedTickets as $ticket) { ?>
				<div class="ticket">
					<h4 class="name"><?php echo htmlspecialchars($ticket->title) ?></h4>
					<p class="question"><?php echo htmlspecialchars($ticket->question) ?></p>
					<span class="ticket-date">Le <?php echo $ticket->date->format('d/m/Y') ?></span>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>
<?php if (count($closedTickets) > 0) { ?>
	<div class="block-ticket">
		<div class="closed-tickets">
			<h2>Mes tickets résolus</h2>
			<?php foreach ($closedTickets as $ticket) { ?>
				<div class="ticket">
					<h4 class="name"><?php echo htmlspecialchars($ticket->title) ?></h4>
					<p class="question"><?php echo htmlspecialchars($ticket->question) ?></p>
					<h4 class="admin">Réponse de : <?php echo htmlspecialchars($ticket->getAdmin()->getFullName()) ?></h4>
					<p class="answer"><?php echo htmlspecialchars($ticket->answer) ?></p>
					<span class="ticket-date">Réponse le <?php echo $ticket->date->format('d/m/Y') ?></span>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>