<form>
	<div class="Txtsmiley">
		Comment vous sentez-vous aujourd'hui ?
	</div>
	<div class='empsmiley'>

		<div class="smiley1" data-value="0">
			<?php include __DIR__ . "/../public/images/1smiley.svg"
			?>
		</div>
		<div class="smiley2" data-value="1">
			<?php include __DIR__ . "/../public/images/2smiley.svg"
			?>
		</div>
		<div class='smiley3 smiley-selected' data-value="2">
			<?php include __DIR__ . "/../public/images/3smiley.svg"
			?>

		</div>
		<div class='smiley4' data-value="3">
			<?php include __DIR__ . "/../public/images/4smiley.svg"
			?>

		</div>
		<div class='smiley5' data-value="4">
			<?php include __DIR__ . "/../public/images/5smiley.svg"
			?>

		</div>

	</div>
	<div class="Txtsmiley">
		Combien d'heure(s) avez-vous dormi ?
	</div>
	<div>
		<div class="rangesleep">
			<input type="range" id="Sleep" name="daysleep" value="9" min="0" max="24">
			<span id="rangevaluesleep">9 heures</span>
		</div>
		<div class="Txtsmiley">
			Comment le son vous a affecté la nuit dernière ?
		</div>
		<div class='empsoundnight'>
			<div class="moon">
				<?php include __DIR__ . "/../public/images/moon.svg"
				?>
			</div>
			<div class='soundicon' data-key="noisenightmood">
				<div class='sound1' data-value="0">
					<?php include __DIR__ . "/../public/images/1sound.svg"
					?>

				</div>
				<div class='sound2' data-value="1">
					<?php include __DIR__ . "/../public/images/2sound.svg"
					?>

				</div>
				<div class='sound3 sound-selected' data-value="2">
					<?php include __DIR__ . "/../public/images/3sound.svg"
					?>

				</div>
				<div class='sound4' data-value="3">
					<?php include __DIR__ . "/../public/images/4sound.svg"
					?>

				</div>
				<div class='sound5' data-value="4">
					<?php include __DIR__ . "/../public/images/5sound.svg"
					?>

				</div>
			</div>

		</div>
		<div class="Txtsmiley">
			Comment le son vous a affecté dans la journée ?
		</div>
		<div class='empsoundday'>
			<div class="moon">
				<?php include __DIR__ . "/../public/images/sun.svg"
				?>
			</div>
			<div class='soundicon' data-key="noisedaymood">
				<div class='sound1' data-value="0">
					<?php include __DIR__ . "/../public/images/1sound.svg"
					?>

				</div>
				<div class='sound2' data-value="1">
					<?php include __DIR__ . "/../public/images/2sound.svg"
					?>

				</div>
				<div class='sound3 sound-selected' data-value="2">
					<?php include __DIR__ . "/../public/images/3sound.svg"
					?>

				</div>
				<div class='sound4' data-value="3">
					<?php include __DIR__ . "/../public/images/4sound.svg"
					?>

				</div>
				<div class='sound5' data-value="4">
					<?php include __DIR__ . "/../public/images/5sound.svg"
					?>

				</div>

			</div>
		</div>
		<div class='Txtsmiley'>
			Comment avez-vous respiré aujourd'hui ?
		</div>
		<div class="rangebreathing">
			<input type="range" id="breathing" name="breathing" value="20" min="0" max="100">
			<span id="rangevalue">20 %</span>
			<div id="Easy">Facilement</div>
			<div id="Hard">Difficilement</div>
		</div>


		<div class="Txtsmiley">
			Êtes-vous sorti aujourd'hui ?
		</div>
		<div class="Qwent" data-key="wentoutside">

			<div class='iconoutside' data-value="on">
				<?php include __DIR__ . "/../public/images/icon_outside.svg"
				?>
				<span class="repicon"> Oui ?</span>
			</div>
			<div class='iconinside' data-value="off">
				<?php include __DIR__ . "/../public/images/icon_inside.svg"
				?>
				<span class="repicon"> Non ?</span>

			</div>

		</div>
		<div class="Txtsmiley">
			Combien d'intéractions avez vous-eu aujourd'hui ?
		</div>
		<div class="rangeinter">
			<input type="range" id="Inter" name="interactiveday" value="3" min="0" max="5">
			<span id="rangevaluesinter">3 Interaction</span>
		</div>
		<div class="Txtsmiley">
			Avez-vous fait du sport aujourd'hui ?
		</div>
		<div class="repsport">
			<input type="radio" name="sport" class="sport1" id="sport1-a" value="on" checked>
			<label for="sport1-a">Oui</label>
			<input type="radio" name="sport" class="sport1" id="sport1-b" value="off">
			<label for="sport1-b">Non</label>

		</div>
		<div class="sport-wrapper">
			<div class="Txtsmiley">
				Sport en extérieur ou en intérieur ?
			</div>
			<div class="Qsport" data-key="sportindoor">

				<div class='icon_sport_outside' data-value="off">
					<?php include __DIR__ . "/../public/images/sport_outside.svg"
					?>
					<span class="repicon2"> Dehors ?</span>

				</div>
				<div class='icon_sport_inside' data-value="on">
					<?php include __DIR__ . "/../public/images/sport_inside.svg"
					?>
					<span class="repicon2"> Intérieur ?</span>

				</div>

			</div>
			<div class="Txtsmiley">
				Le sport était-il dur ?
			</div>
			<div class="repsport" style="justify-content: center;">
				<input type="checkbox" name="sportharder" class="sport2" id="sport2" checked>
				<label for="sport2"></label>
			</div>
			<div class="Txtsmiley">
				Conbien de temps avez-vous fait du sport ?
			</div>
			<div class="Duration">
				<input name="sportduration" type="number" placeholder="En minute" min="0" max="600" />
			</div>
		</div>
		<div class="bouton_game">
			<button class="buttongame" type="submit">Envoyer</button>
		</div>
</form>