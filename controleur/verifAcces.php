<?php
/**
 * Vérifie que l'utilisateur est connecté, sinon redirige vers la connexion.
 */
function exigerConnexion()
{
    if (!isset($_SESSION['user'])) {
        $_SESSION['message_erreur'] = "Vous devez être connecté pour accéder à cette page.";
        header('Location: index.php?action=connexion');
        exit();
    }
}

/**
 * Vérifie que le rôle de l'utilisateur connecté fait partie des rôles autorisés.
 * Redirige vers la liste des utilisateurs si l'accès est refusé.
 *
 * @param array $rolesAutorises Liste des noms de rôles autorisés (ex: ['admin', 'moderateur'])
 */
function exigerRole(array $rolesAutorises)
{
    exigerConnexion();

    $role = $_SESSION['user']['role'] ?? null;

    if (!in_array($role, $rolesAutorises, true)) {
        $_SESSION['message_erreur'] = "Vous n'avez pas les droits nécessaires pour accéder à cette page.";
        header('Location: index.php?action=listeUtilisateurs');
        exit();
    }
}

/**
 * Indique si l'utilisateur connecté possède un des rôles donnés.
 * Utile dans les vues pour afficher/masquer certains éléments.
 *
 * @param array $roles
 * @return bool
 */
function aLeRole(array $roles)
{
    $role = $_SESSION['user']['role'] ?? null;
    return in_array($role, $roles, true);
}
?>