<div class="container">

    <h1>Inscription</h1>

    <?php if (!empty($erreur)) : ?>
        <p class="error"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?action=inscription">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" placeholder="Veuillez indiquer votre prénom" required>
        
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" placeholder="Veuillez indiquer votre nom" required>
        
        <label for="email">Email</label>
        <input type="mail" id="email" name="email" placeholder="Veuillez indiquer votre Email"" required>
        
        <label for="login">Login</label>
        <input type="text" id="login" name="login" placeholder="Choisissez un login" required>

        <label for="mdp">Mot de passe</label>
        <input type="password" id="mdp" name="mdp" placeholder="Choisissez un mot de passe" required>

        <button type="submit">Créer mon compte</button>
    </form>

    <p class="link-secondary">
        Déjà un compte ? <a href="index.php?action=connexion">Se connecter</a>
    </p>

</div>
