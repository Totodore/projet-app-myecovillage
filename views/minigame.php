
<div class="Txtsmiley">
    Comment vous sentez-vous aujourd'hui ?
</div>
<div class='empsmiley'>

    <div class="smiley1">
        <?php include __DIR__ . "/../public/images/1smiley.svg"
        ?>
    </div>
    <div class="smiley2">
        <?php include __DIR__ . "/../public/images/2smiley.svg"
        ?>
    </div>
    <div class='smiley3'>
        <?php include __DIR__ . "/../public/images/3smiley.svg"
        ?>

    </div>
    <div class='smiley4'>
        <?php include __DIR__ . "/../public/images/4smiley.svg"
        ?>

    </div>
    <div class='smiley5'>
        <?php include __DIR__ . "/../public/images/5smiley.svg"
        ?>

    </div>

</div>
<div class="Txtsmiley">
    Combien d'heures avez-vous dormis ?
</div>
<div>
<div class="rangesleep">
    <input type="range" id="Sleep" name="" value="0" min="0" max="24">
    <span id="rangevaluesleep">0 heure</span>
</div>
<div class="Txtsmiley">
    Comment le son vous à affecté la nuit dernière ?
</div>
<div class='empsoundnight'>
<div class="moon">
        <?php include __DIR__ . "/../public/images/moon.svg"
        ?>
</div>
    <div class='soundicon'>
    <div class='sound1'>
    <?php include __DIR__ . "/../public/images/1sound.svg"
        ?>

    </div>
    <div class='sound2'>
    <?php include __DIR__ . "/../public/images/2sound.svg"
        ?>

    </div>
    <div class='sound3'>
    <?php include __DIR__ . "/../public/images/3sound.svg"
        ?>

    </div>
    <div class='sound4'>
    <?php include __DIR__ . "/../public/images/4sound.svg"
        ?>

    </div>
    <div class='sound5'>
    <?php include __DIR__ . "/../public/images/5sound.svg"
        ?>

    </div>
</div>

</div>
<div class="Txtsmiley">
    Comment le son vous à affecté dans la journée?
</div>
<div class='empsoundday'>
<div class="moon">
        <?php include __DIR__ . "/../public/images/sun.svg"
        ?>
</div>
<div class='soundicon'>
    <div class='sound1'>
    <?php include __DIR__ . "/../public/images/1sound.svg"
        ?>

    </div>
    <div class='sound2'>
    <?php include __DIR__ . "/../public/images/2sound.svg"
        ?>

    </div>
    <div class='sound3'>
    <?php include __DIR__ . "/../public/images/3sound.svg"
        ?>

    </div>
    <div class='sound4'>
    <?php include __DIR__ . "/../public/images/4sound.svg"
        ?>

    </div>
    <div class='sound5'>
    <?php include __DIR__ . "/../public/images/5sound.svg"
        ?>

    </div>

</div>
</div>
<div class='Txtsmiley'>
    Comment avez-vous respirez aujourd'hui ?
</div>
<div class="rangebreathing">
    <input type="range" id="breathing" name="" value="0" min="0" max="100">
    <span id="rangevalue">0 %</span>
    <div id="Easy">facilement</div>
    <div id="Hard">Difficilement</div>
</div>


<div class="Txtsmiley">
    Etes-vous sortis aujourd'hui ?
</div>
<div class="Qwent">

<div class='iconoutside'>
    <?php include __DIR__ . "/../public/images/icon_outside.svg"
        ?>
    <span class="repicon"> Oui ?</span>
    </div>
    <div class='iconinside'>
    <?php include __DIR__ . "/../public/images/icon_inside.svg"
        ?>
        <span class="repicon"> Non ?</span>

    </div>

</div>
<div class="Txtsmiley">
    Combien d'intéractions avez vou eu ?
</div>
<div>
<div class="rangeinter">
    <input type="range" id="Inter" name="" value="0" min="0" max="5">
    <span id="rangevaluesinter">0 Interactions</span>
</div>
<div class="Txtsmiley">
    Avez vous fait du sport ?
</div>
<div class="repsport">
<input type="radio" name="sport1" class="sport1" id="sport1-a" checked>
<label for="sport1-a">Oui</label>
<input type="radio" name="sport1" class="sport1" id="sport1-b" >
<label for="sport1-b">Non</label>
  
</div>
<div class="Txtsmiley">
    Sport en exterieur ou en interieur ?
</div>
<div class="Qsport">

<div class='icon_sport_outside'>
    <?php include __DIR__ . "/../public/images/sport_outside.svg"
        ?>
        <span class="repicon"> Dehors ?</span>

    </div>
    <div class='icon_sport_inside'>
    <?php include __DIR__ . "/../public/images/sport_inside.svg"
        ?>
        <span class="repicon"> Intérieur ?</span>

    </div>

</div>
<div class="Txtsmiley">
    Le sport était dure ?
</div>
<div class="repsport">
<input type="checkbox" class="sport2" id="sport2">
<label for="sport2"></label>
</div>
  <div class="Txtsmiley">
    Conbien de temps avez vous fait du sport ?
</div>
<div class="Duration">
<input name="Duration" type="number" placeholder="En minute" />
</div>
<div class="bouton_game">
			<button class="buttongame" type="submit">Envoyer</button>
		</div>