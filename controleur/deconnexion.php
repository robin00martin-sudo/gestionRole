<?php
// session_start() est déjà appelé dans index.php

require_once RACINE . '/modele/authentification.php';

// Déconnexion de l'utilisateur
logout();

// On stocke un message de confirmation pour la page de connexion
// Note : session_start() doit être rappelé car logout() a détruit la session
session_start();
$_SESSION['message_succes'] = "Vous avez été déconnecté avec succès.";

// Redirection vers la page de connexion
header('Location: index.php?action=connexion');
exit();
?>
