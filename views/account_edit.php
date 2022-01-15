<div class="container_profil">
    <div id="conteneurPE">
        <div class="elementPE">
            <form class="form_edit_P">
                <div class="titreinformation">Editer profil</div>

                <span class="text_info">Nom :
                    <?php
                    echo $usered->name;
                    ?>
                </span>
                <input type="text" class="barresaisie" id="nomchange" name="nomchange">
                </p>

                <span class="text_info">Prenom :
                    <?php
                    echo $usered->firstname;
                    ?>
                </span>
                <input type="text" class="barresaisie" id="prenomchange" name="prenomchange">
                </p>

                <span class="text_info">Date de naissance :
                    <?php
                    echo $usered->birthdate->format('d/m/Y');
                    ?>
                </span>
                <input type="text" class="barresaisie" id="anniverssairechange" name="anniverssairechange">
                </p>

                <span class="text_info">Taille :
                    <?php
                    echo $usered->height . " cm";
                    ?>
                </span>
                <input type="number" class="barresaisie" id="taillechange" name="taillechange">
                </p>

                <span class="text_info">Poids :
                    <?php
                    echo $usered->weight . " kg";
                    ?>
                </span>
                <input type="number" class="barresaisie" id="poidschange" name="poidschange">
                </p>

                <span class="text_info">Mail :
                    <?php
                    echo $usered->email;
                    ?>
                </span>
                <input type="email" class="barresaisie" id="mailchange" name="mailchange">
                </p>
                <span class="text_info">mot de passe :

                </span>
                <input type="password" class="barresaisie" id="passwordchange" name="passwordchange">
            </form>
        </div>

        <div class="elementPE">
            <img src="../public/images/user_profil.png" class="image_user_edit" />
            <button class="editer_photo">editer photo</button>
        </div>
    </div>



    <div>
        <a class="boutonvalider">Valider</a>
    </div>

</div>