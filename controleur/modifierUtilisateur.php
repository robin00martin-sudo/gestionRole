<?php
// session_start() est déjà appelé dans index.php

require_once RACINE . '/controleur/verifAcces.php';
require_once RACINE . '/modele/utilisateur.php';

// Seuls les admins et les modérateurs peuvent modifier un utilisateur
exigerPermission('modifier_utilisateur');

$message        = "";
$message_classe = "";

$id          = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$utilisateur = getUtilisateurParId($id);

if (!$utilisateur) {
    $_SESSION['message_erreur'] = "Utilisateur introuvable.";
    header('Location: index.php?action=listeUtilisateurs');
    exit();
}

// Un modérateur ne peut pas modifier un compte admin (sinon il pourrait
// changer son mot de passe et prendre le contrôle du compte).
if (!peutAgirSur($utilisateur)) {
    $_SESSION['message_erreur'] = "Vous n'avez pas le droit de modifier un administrateur.";
    header('Location: index.php?action=listeUtilisateurs');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = trim($_POST['prenom'] ?? '');
    $nom    = trim($_POST['nom'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $login  = trim($_POST['login'] ?? '');
    $mdp    = $_POST['mdp'] ?? '';

    // On garde les valeurs saisies pour réafficher le formulaire en cas d'erreur
    $utilisateur['prenom'] = $prenom;
    $utilisateur['nom']    = $nom;
    $utilisateur['mail']   = $email;
    $utilisateur['login']  = $login;

    if ($prenom === '' || $nom === '' || $login === '') {
        $message        = "Veuillez remplir le prénom, le nom et le login.";
        $message_classe = "error";
    } elseif (loginDejaUtilise($login, $id)) {
        $message        = "Ce login est déjà utilisé par un autre utilisateur.";
        $message_classe = "error";
    } elseif (modifierUtilisateur($id, $prenom, $nom, $email, $login, $mdp)) {
        // Si on modifie son propre compte, on met à jour la session
        if ($id === (int) $_SESSION['user']['id']) {
            $_SESSION['user']['prenom'] = $prenom;
            $_SESSION['user']['nom']    = $nom;
            $_SESSION['user']['mail']   = $email;
            $_SESSION['user']['login']  = $login;
        }
        $_SESSION['message_succes'] = "Utilisateur modifié avec succès.";
        header('Location: index.php?action=listeUtilisateurs');
        exit();
    } else {
        $message        = "Erreur lors de la modification de l'utilisateur.";
        $message_classe = "error";
    }
}

require RACINE . '/vue/vueModifierUtilisateur.php';
?>
