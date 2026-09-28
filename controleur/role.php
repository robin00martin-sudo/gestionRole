<?php
// session_start() est déjà appelé dans index.php

require_once RACINE . '/controleur/verifAcces.php';
require_once RACINE . '/modele/role.php';

// Seul l'admin gère les rôles (consultation ET création)
exigerRole(['admin']);

$message        = "";
$message_classe = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nomRole'])) {
    $nomRole = trim($_POST['nomRole']);

    if (empty($nomRole)) {
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

