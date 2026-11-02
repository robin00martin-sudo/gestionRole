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

/**
 * Matrice des droits : pour chaque permission, la liste des rôles autorisés.
 * Pour changer les droits d'un rôle, il suffit de modifier ce tableau.
 *
 *  - admin      : tous les droits
 *  - moderateur : voir/rechercher, modifier et supprimer les utilisateurs, voir les rôles
 *  - consultant : voir et rechercher les utilisateurs uniquement
 */
function permissions()
{
    return [
        'voir_utilisateurs'    => ['admin', 'moderateur', 'consultant'],
        'ajouter_utilisateur'  => ['admin'],
        'modifier_utilisateur' => ['admin', 'moderateur'],
        'supprimer_utilisateur'=> ['admin', 'moderateur'],
        'voir_roles'           => ['admin', 'moderateur'],
        'creer_role'           => ['admin'],
        'affecter_role'        => ['admin'],
    ];
}

/**
 * Indique si l'utilisateur connecté possède une permission donnée.
 */
function peut($permission)
{
    $role = $_SESSION['user']['role'] ?? null;
    $matrice = permissions();
    return isset($matrice[$permission]) && in_array($role, $matrice[$permission], true);
}

/**
 * Exige une permission, sinon redirige vers la liste des utilisateurs avec un message.
 */
function exigerPermission($permission)
{
    exigerConnexion();

    if (!peut($permission)) {
        $_SESSION['message_erreur'] = "Vous n'avez pas les droits nécessaires pour accéder à cette page.";
        header('Location: index.php?action=listeUtilisateurs');
        exit();
    }
}

/**
 * Un modérateur ne peut pas agir (modifier / supprimer) sur un compte admin :
 * seul un admin le peut. Retourne true si l'action est permise sur cet utilisateur.
 */
function peutAgirSur($utilisateur)
{
    return aLeRole(['admin']) || ($utilisateur['role'] ?? null) !== 'admin';
}
?>