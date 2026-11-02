<?php
// session_start() est déjà appelé dans index.php

require_once RACINE . '/controleur/verifAcces.php';
require_once RACINE . '/modele/utilisateur.php';
require_once RACINE . '/modele/role.php';

// Seul l'admin peut affecter des rôles (fait partie de "tous les droits")
exigerPermission('affecter_role');

$message        = "";
$message_classe = "";

// Traitement du formulaire d'affectation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['user'] ?? null;
    $idRole = $_POST['role'] ?? null;

    if ($idUser && $idRole) {
        affecterRole($idUser, $idRole);
        $message        = "Le rôle a bien été affecté.";
        $message_classe = "success";
    } else {
        $message        = "Erreur : veuillez sélectionner un utilisateur et un rôle.";
        $message_classe = "error";
    }
}

// Récupération des données pour la vue
$users = getUtilisateurs();
$roles = getRoles();

// Affichage
require RACINE . '/vue/entete.php';
require RACINE . '/vue/vueAffectation.php';
require RACINE . '/vue/pied.php';
?>