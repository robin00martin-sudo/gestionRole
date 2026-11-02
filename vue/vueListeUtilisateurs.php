<?php require 'entete.php'; ?>
<div class="container">
    <h2>Utilisateurs</h2>

    <?php if (!empty($message)) : ?>
        <p class="<?= htmlspecialchars($message_classe) ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="GET" action="index.php" class="recherche">
        <input type="hidden" name="action" value="listeUtilisateurs">
        <label for="recherche">Rechercher par login ou mail</label>
        <input type="text" id="recherche" name="recherche" placeholder="login ou email..." value="<?= htmlspecialchars($recherche ?? '') ?>">
        <button type="submit">Rechercher</button>
        <?php if (!empty($recherche)) : ?>
            <a href="index.php?action=listeUtilisateurs">Réinitialiser</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>Login</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Rôle</th>
                <?php if ($peutModifier || $peutSupprimer) : ?><th>Actions</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($utilisateurs)) : ?>
            <tr><td colspan="<?= ($peutModifier || $peutSupprimer) ? 6 : 5 ?>">Aucun utilisateur trouvé.</td></tr>
        <?php endif; ?>
        <?php foreach ($utilisateurs as $u) : ?>
            <tr>
                <td><?= htmlspecialchars($u['login']) ?></td>
                <td><?= htmlspecialchars($u['nom']) ?></td>
                <td><?= htmlspecialchars($u['prenom']) ?></td>
                <td><?= htmlspecialchars($u['mail']) ?></td>
                <td><?= htmlspecialchars($u['role'] ?? 'Aucun rôle') ?></td>
                <?php if ($peutModifier || $peutSupprimer) : ?>
                <td class="actions">
                    <?php if ($peutModifier && peutAgirSur($u)) : ?>
                        <a class="bouton-modifier" href="index.php?action=modifierUtilisateur&amp;id=<?= (int) $u['id'] ?>">Modifier</a>
                    <?php endif; ?>
                    <?php if ($peutSupprimer && peutAgirSur($u) && (int) $u['id'] !== (int) $_SESSION['user']['id']) : ?>
                    <form method="POST" action="index.php?action=listeUtilisateurs" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                        <input type="hidden" name="supprimer" value="<?= htmlspecialchars($u['id']) ?>">
                        <button type="submit" class="danger">Supprimer</button>
                    </form>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($peutAjouter) : ?>
    <h3>Ajouter un utilisateur</h3>
    <form method="POST" action="index.php?action=listeUtilisateurs">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email">

        <label for="login">Login</label>
        <input type="text" id="login" name="login" required>

        <label for="mdp">Mot de passe</label>
        <input type="password" id="mdp" name="mdp" required>

        <button type="submit" name="ajouter" value="1">Ajouter l'utilisateur</button>
    </form>
    <?php endif; ?>
</div>
<?php require 'pied.php'; ?>
