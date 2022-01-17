<h2>Bonjour <?php echo $user->firstname; ?>, voici vos informations quotidiennes.</h2>
<div Class="Donnee">
	<div Class="rond1">
		<p id="Txtrond1">Température</p>
		<div class="flex-wrapper">
			<div class="single-chart">
				<svg viewBox="0 0 36 36" class="circular-chart Temp">
					<path class="circle-bg" d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
					<path class="circle" stroke-dasharray="30, 100" d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
					<text x="18" y="20.35" class="percentage">30°C</text>
				</svg>
			</div>
		</div>
	</div>
	<div Class="rond2">
		<p id="Txtrond2">Co2</p>
		<div class="flex-wrapper">
			<div class="single-chart">
				<svg viewBox="0 0 36 36" class="circular-chart CO2">
					<path class="circle-bg" d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
					<path class="circle" stroke-dasharray="60, 100" d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
					<text x="18" y="20.35" class="percentage">50 µg</text>

				</svg>
			</div>
		</div>
	</div>
	<div Class="rond3">
		<p id="Txtrond3">Bruit</p>
		<div class="flex-wrapper">
			<div class="single-chart">
				<svg viewBox="0 0 36 36" class="circular-chart Decibel">
					<path class="circle-bg" d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
					<path class="circle" stroke-dasharray="80, 100" d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
					<text x="18" y="20.35" class="percentage">100Db</text>

				</svg>
			</div>
		</div>
	</div>
</div>

<?php if ($hasWeekStat) { ?>
	<div class="Emptableau">
		<div class="Tableau">
			<?php foreach ($dataStat as $score) { ?>
				<div id="graph1">
					<div id="ptab1">
						<p class="compteur" data-value="80">0</p>
					</div>
				</div>
				<div id="barre_tableausmall"></div>
			<?php } ?>
			<div id="barre_tableau"></div>


			<div class="Txttableau">
				<div id="Txtgraph1">Lundi</div>
				<div id="Txtgraph2">Mardi</div>
				<div id="Txtgraph2">Mercredi</div>
				<div id="Txtgraph2">Jeudi</div>
				<div id="Txtgraph2">Vendredi</div>
				<div id="Txtgraph2">Samedi</div>
				<div id="Txtgraph2">Dimanche</div>
			</div>
		</div>
	</div>
<?php } else { ?>
	<h2 class="no-data">
		Impossible d'établir votre profil au sein de votre écoquartier, nous vous invitons à participer à
		<button class="no-data-link">un minijeu quotidien.</button>
	</h2>
<?php } ?>