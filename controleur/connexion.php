<?php
// session_start() est déjà appelé dans index.php

require_once RACINE . '/modele/authentification.php';

$erreur  = "";  // message d'erreur affiché dans la vue si échec
$succes  = "";  // message de succès (ex : compte créé)

// Récupération d'un message transmis depuis l'inscription via la session
if (isset($_SESSION['message_succes'])) {
    $succes = $_SESSION['message_succes'];
    unset($_SESSION['message_succes']); // on l'efface après l'avoir lu
}

// Récupération d'un message d'erreur (ex : accès refusé faute de droits) via la session
if (isset($_SESSION['message_erreur'])) {
    $erreur = $_SESSION['message_erreur'];
    unset($_SESSION['message_erreur']);
}

// L'utilisateur est déjà connecté → on le redirige directement
if (isset($_SESSION['user'])) {
    header('Location: index.php?action=listeUtilisateurs');
    exit();
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = trim($_POST['login'] ?? '');
    $mdp   = $_POST['mdp'] ?? '';

    if (empty($login) || empty($mdp)) {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        $user = login($login, $mdp);

        if ($user) {
            // Connexion réussie : on stocke l'utilisateur en session
            $_SESSION['user'] = $user;
            // Redirection vers la liste des utilisateurs
            header('Location: index.php?action=listeUtilisateurs');
            exit();
        } else {
            $erreur = "Identifiants incorrects. Vérifiez votre login et mot de passe.";
        }
    }
}

// Affichage du formulaire (avec éventuellement $erreur ou $succes)
require RACINE . '/vue/entete.php';
require RACINE . '/vue/vueConnexion.php';
require RACINE . '/vue/pied.php';
?>