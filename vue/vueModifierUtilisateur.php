<?php require 'entete.php'; ?>
<div class="container">
    <h2>Modifier l'utilisateur</h2>

    <?php if (!empty($message)) : ?>
        <p class="<?= htmlspecialchars($message_classe) ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?action=modifierUtilisateur&amp;id=<?= (int) $utilisateur['id'] ?>">
        <input type="hidden" name="id" value="<?= (int) $utilisateur['id'] ?>">

        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($utilisateur['prenom'] ?? '') ?>" required>

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($utilisateur['nom'] ?? '') ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($utilisateur['mail'] ?? '') ?>">

        <label for="login">Login</label>
        <input type="text" id="login" name="login" value="<?= htmlspecialchars($utilisateur['login'] ?? '') ?>" required>

        <label for="mdp">Nouveau mot de passe (laisser vide pour ne pas le changer)</label>
        <input type="password" id="mdp" name="mdp" autocomplete="new-password">

        <button type="submit">Enregistrer</button>
        <a href="index.php?action=listeUtilisateurs">Annuler</a>
    </form>
</div>
<?php require 'pied.php'; ?>
