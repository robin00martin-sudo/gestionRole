<div class="container">

    <h2>Affecter un rôle</h2>

    <?php if (!empty($message)) : ?>
        <p class="<?= htmlspecialchars($message_classe) ?>">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="index.php?action=affectation">

        <div class="affectation-selects">
            <div>
                <label for="user">Utilisateur</label>
                <select id="user" name="user">
                    <?php foreach ($users as $u) : ?>
                        <option value="<?= htmlspecialchars($u['id']) ?>">
                            <?= htmlspecialchars($u['login']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="role">Rôle</label>
                <select id="role" name="role">
                    <?php foreach ($roles as $r) : ?>
                        <option value="<?= htmlspecialchars($r['id']) ?>">
                            <?= htmlspecialchars($r['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="submit">Affecter</button>

    </form>

</div>
