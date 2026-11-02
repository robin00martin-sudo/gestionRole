<?php
require_once 'bd.inc.php';

/**
 * Vérifie les identifiants et retourne l'utilisateur si correct, false sinon.
 */
function login($login, $mdp) {
    try {
        $bd = connexionPDO();
        $req = $bd->prepare("
            SELECT u.*, r.nom AS role
            FROM utilisateur u
            LEFT JOIN utilisateur_role ur ON ur.idUtilisateur = u.id
            LEFT JOIN role r ON r.id = ur.idRole
            WHERE u.login = ?");
        $req->execute([$login]);
        $user = $req->fetch();

        if ($user && password_verify($mdp, $user['mdp'])) {
            return $user;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Déconnecte l'utilisateur en détruisant la session.
 * session_start() est déjà appelé dans index.php, pas besoin de le rappeler.
 */
function logout() {
    // On vide le tableau de session
    $_SESSION = [];

    // On supprime le cookie de session dans le navigateur
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // On détruit la session côté serveur
    session_destroy();
}
?>
