<div class="container">

    <h1>Connexion</h1>

    <?php if (!empty($succes)) : ?>
        <p class="success"><?= htmlspecialchars($succes) ?></p>
    <?php endif; ?>

    <?php if (!empty($erreur)) : ?>
        <p class="error"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?action=connexion">
        <label for="login">Login</label>
        <input type="text" id="login" name="login" placeholder="Votre login" required>

        <label for="mdp">Mot de passe</label>
        <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required>

        <button type="submit">Se connecter</button>
    </form>

    <p class="link-secondary">
        Pas encore de compte ? <a href="index.php?action=inscription">S'inscrire</a>
    </p>

</div>
