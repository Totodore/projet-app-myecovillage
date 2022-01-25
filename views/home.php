<?php setlocale(LC_TIME, "fr_FR"); ?>
<h2>Bonjour <?php echo $user->firstname; ?>, voici vos informations quotidiennes.</h2>
<div Class="Donnee">
	<div class="rond">
		<p class="txt-rond">Température</p>
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
	<div class="rond">
		<p class="txt-rond">Taux de particule fines</p>
		<div class="flex-wrapper">
			<div class="single-chart">
				<svg viewBox="0 0 36 36" class="circular-chart Temp">
					<path class="circle-bg" d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
					<path class="circle" stroke-dasharray="30, 100" d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
					<text x="18" y="20.35" class="percentage">40 µg/m3</text>
				</svg>
			</div>
		</div>
	</div>
	<div class="rond">
		<p class="txt-rond">Co2</p>
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
	<div class="rond">
		<p class="txt-rond">Bruit</p>
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

<?php if ($hasWeekStat && $dataStat[intval(date('w'))][1] == 0) { ?>
	<h2 class="no-data">
		Vous n'avez pas encore participé au <button class="no-data-link">minijeu</button> aujourd'hui!
	</h2>
<?php } ?>
<h2 style="margin-top: 0;">Vos statistiques de bien-être au sein de l'écoquartier&nbsp;:</h2>
<?php if ($hasWeekStat) { ?>
	<div class="Emptableau">
		<div class="Tableau">
			<?php foreach ($dataStat as $score) { ?>
				<div class="graph">
					<div class="ptab">
						<?php if ($score[1] > 0) { ?>
							<p class="compteur" data-value="<?php echo $score[1] ?>">0</p>
						<?php } ?>
					</div>
					<div class="day-graph"><?php echo $score[2] ?></div>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } else { ?>
	<h2 class="no-data">
		Impossible d'établir votre profil au sein de votre écoquartier, nous vous invitons à participer à
		<button class="no-data-link">un minijeu quotidien.</button>
	</h2>
<?php } ?>

<h2>Trouver une borne MyEcoVillage dans votre écoquartier&nbsp;:</h2>
<div class="map-wrapper">
	<div id="map"></div>
</div>
