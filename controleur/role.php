<?php
// session_start() est déjà appelé dans index.php

require_once RACINE . '/controleur/verifAcces.php';
require_once RACINE . '/modele/role.php';

// Admin et modérateur peuvent consulter les rôles ; seul l'admin peut en créer
exigerPermission('voir_roles');

$peutCreer = peut('creer_role');

$message        = "";
$message_classe = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nomRole'])) {
    $nomRole = trim($_POST['nomRole']);

    if (!$peutCreer) {
        $message        = "Vous n'avez pas le droit de créer un rôle.";
        $message_classe = "error";
    } elseif (empty($nomRole)) {
        $message        = "Veuillez indiquer un nom de rôle.";
        $message_classe = "error";
    } elseif (ajouterRole($nomRole)) {
        $message        = "Rôle créé avec succès.";
        $message_classe = "success";
    } else {
        $message        = "Erreur lors de la création du rôle.";
        $message_classe = "error";
    }
}

$roles = getRoles();
require RACINE . '/vue/vueListeRoles.php';
?>

