<?php
// session_start() est déjà appelé dans index.php

include RACINE . '/modele/utilisateur.php';

$erreur = "";

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    
    $prenom =   $_POST['prenom'] ?? '';
    $nom =      $_POST['nom'] ?? '';
    $email =    $_POST['email'] ?? '';
    $login = trim($_POST['login'] ?? '');
    $mdp   =    $_POST['mdp']   ?? '';

    if (empty($login) || empty($mdp) || empty($prenom) || empty($nom)) {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        // Création du compte
        $ok = ajouterUtilisateur($prenom, $nom, $email, $login, $mdp);

        if ($ok) {
            // On stocke un message de succès en session pour l'afficher sur la page de connexion
            $_SESSION['message_succes'] = "Votre compte a bien été créé. Vous pouvez maintenant vous connecter.";
            // Redirection vers la page de connexion
            header('Location: index.php?action=connexion');
            exit();
        } else {
            $erreur = "Une erreur est survenue lors de la création du compte. Veuillez réessayer.";
        }
    }
}

// Affichage du formulaire d'inscription (avec éventuellement $erreur)
require RACINE . '/vue/entete.php';
require RACINE . '/vue/vueInscription.php';
require RACINE . '/vue/pied.php';
?>
