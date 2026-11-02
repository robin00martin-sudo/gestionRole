<?php
// session_start() est déjà appelé dans index.php

require_once RACINE . '/controleur/verifAcces.php';
require_once RACINE . '/modele/utilisateur.php';

// La consultation et la recherche sont ouvertes à tout utilisateur connecté.
// L'ajout, la modification et la suppression dépendent du rôle (voir verifAcces.php).
exigerConnexion();

$peutAjouter   = peut('ajouter_utilisateur');
$peutModifier  = peut('modifier_utilisateur');
$peutSupprimer = peut('supprimer_utilisateur');

$message        = "";
$message_classe = "";

// Message transmis par exemple par verifAcces.php (accès refusé à une autre page)
if (isset($_SESSION['message_erreur'])) {
    $message        = $_SESSION['message_erreur'];
    $message_classe = "error";
    unset($_SESSION['message_erreur']);
}

// Message de succès transmis par modifierUtilisateur.php après une modification
if (isset($_SESSION['message_succes'])) {
    $message        = $_SESSION['message_succes'];
    $message_classe = "success";
    unset($_SESSION['message_succes']);
}

// --- Suppression d'un utilisateur (admin, moderateur) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
    if (!$peutSupprimer) {
        $message        = "Vous n'avez pas le droit de supprimer un utilisateur.";
        $message_classe = "error";
    } else {
        $idASupprimer = (int) $_POST['supprimer'];
        $cible        = getUtilisateurParId($idASupprimer);

        if ($cible && !peutAgirSur($cible)) {
            $message        = "Vous n'avez pas le droit de supprimer un administrateur.";
            $message_classe = "error";
        } elseif ($idASupprimer === (int) $_SESSION['user']['id']) {
            $message        = "Vous ne pouvez pas supprimer votre propre compte.";
            $message_classe = "error";
        } elseif (supprimerUtilisateur($idASupprimer)) {
            $message        = "Utilisateur supprimé avec succès.";
            $message_classe = "success";
        } else {
            $message        = "Erreur lors de la suppression de l'utilisateur.";
            $message_classe = "error";
        }
    }
}

// --- Ajout d'un utilisateur (admin uniquement) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    if (!$peutAjouter) {
        $message        = "Vous n'avez pas le droit d'ajouter un utilisateur.";
        $message_classe = "error";
    } else {
        $prenom = trim($_POST['prenom'] ?? '');
        $nom    = trim($_POST['nom'] ?? '');
        $email  = trim($_POST['email'] ?? '');
        $login  = trim($_POST['login'] ?? '');
        $mdp    = $_POST['mdp'] ?? '';

        if (empty($prenom) || empty($nom) || empty($login) || empty($mdp)) {
            $message        = "Veuillez remplir tous les champs obligatoires.";
            $message_classe = "error";
        } elseif (ajouterUtilisateur($prenom, $nom, $email, $login, $mdp)) {
            $message        = "Utilisateur ajouté avec succès.";
            $message_classe = "success";
        } else {
            $message        = "Erreur lors de l'ajout de l'utilisateur (login déjà utilisé ?).";
            $message_classe = "error";
        }
    }
}

// --- Recherche par login ou mail (ouverte à tous les rôles connectés) ---
$recherche = trim($_GET['recherche'] ?? '');

if ($recherche !== '') {
    $utilisateurs = rechercherUtilisateurs($recherche);
} else {
    $utilisateurs = getUtilisateurs();
}

// La vue (vueListeUtilisateurs.php) inclut elle-même entete.php et pied.php
require RACINE . '/vue/vueListeUtilisateurs.php';
?>