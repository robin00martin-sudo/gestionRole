<?php require 'entete.php'; ?>
<div class="container">
    <h2>Rôles</h2>

    <?php if (!empty($message)) : ?>
        <p class="<?= htmlspecialchars($message_classe) ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <ul>
    <?php foreach ($roles as $r) { ?>
        <li><?= htmlspecialchars($r['nom']) ?></li>
    <?php } ?>
    </ul>

    <?php if ($peutCreer) : ?>
    <h3>Créer un nouveau rôle</h3>
    <form method="POST" action="index.php?action=roles">
        <label for="nomRole">Nom du rôle</label>
        <input type="text" id="nomRole" name="nomRole" required>
        <button type="submit">Créer</button>
    </form>
    <?php endif; ?>
</div>
<?php require 'pied.php'; ?>
