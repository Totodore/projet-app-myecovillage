<div class="formulaire">
    <form method="post" >
        <h1>Contactez-nous</h1>

        <label for="prénom">Prénom :</label>
        <input type="text" name="prénom" id="prénom" value="<?php echo $isLogged ? $user->firstname : ''; ?>"autofocus />

        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" />

        <label for="email">E-mail :</label>
        <input type="email" name="email" id="email" />

        <label for="objet">Objet :</label>
        <input type="text" name="objet" id="objet" />

        <label for="message">Message :</label>
        <textarea class="message" type="text" name="message" id="message"></textarea>

        <input type="submit" value="Envoyer" />
    </form>
</div>