<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Utilisateurs & Rôles</title>
    <link rel="stylesheet" href="vue/CSS/style.css">
</head>
<body>

<nav>
    <?php if (isset($_SESSION['user'])) :
        $role = $_SESSION['user']['role'] ?? null;
    ?>
        <!-- Liens visibles à tous les utilisateurs connectés -->
        <a href="index.php?action=listeUtilisateurs">Utilisateurs</a>

        <?php if ($role === 'admin') : ?>
            <!-- Liens réservés à l'admin : gestion des rôles et affectation -->
            <a href="index.php?action=roles">Rôles</a>
            <a href="index.php?action=affectation">Affectation</a>
        <?php endif; ?>

        <a href="index.php?action=deconnexion">Déconnexion</a>

        <span class="role-badge">
            Connecté : <?= htmlspecialchars($_SESSION['user']['login']) ?>
            (<?= htmlspecialchars($role ?? 'aucun rôle') ?>)
        </span>
    <?php else : ?>
        <!-- Liens visibles quand on n'est pas connecté -->
        <a href="index.php?action=connexion">Connexion</a>
        <a href="index.php?action=inscription">Inscription</a>
    <?php endif; ?>
</nav>