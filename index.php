<?php
// La session doit être démarrée AVANT tout affichage HTML
session_start();

require_once __DIR__ . '/getRacine.php';
require_once RACINE . '/controleur/controleurprincipal.php';

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "defaut";
}

$fichier = controleurPrincipal($action);
include RACINE . "/controleur/$fichier";
?>
