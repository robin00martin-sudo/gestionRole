<?php
/**
* Elle sert à déterminer quel contrôleur (fichier PHP) doit être exécuté
* en fonction de l'action demandée par l'utilisateur.
* Plus précisément, elle associe une "action" (par exemple connexion, inscription, liste,
etc.)
* au fichier contrôleur correspondant (par exemple connexion.php, inscription.php, ...).
* @param string $action : Le paramètre correspond à l'action demandée par l'utilisateur
* La fonction va alors chercher dans un tableau associatif si cette action existe, et
retourner le nom du fichier contrôleur à inclure.
* Si l'action n'est pas reconnue, elle renvoie le contrôleur par défaut.
* @return string
*/
function controleurPrincipal($action)
{
$lesActions = array();
$lesActions["defaut"] = "connexion.php";
$lesActions["listeUtilisateurs"] = "utilisateur.php";
$lesActions["roles"] = "role.php";
$lesActions["affectation"] = "affectation.php";
$lesActions["inscription"] = "inscription.php";
$lesActions["connexion"] = "connexion.php";
$lesActions["deconnexion"] = "deconnexion.php";
if (array_key_exists($action, $lesActions))
{
return $lesActions[$action];
}
else
{
return $lesActions["defaut"];
}
}
?>

