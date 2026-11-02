<?php
require_once RACINE . '/modele/bd.inc.php';

/**
 * Retourne la liste de tous les utilisateurs.
 */
function getUtilisateurs() {
    try {
        $bd = connexionPDO();
        return $bd->query("
            SELECT u.*, r.nom AS role
            FROM utilisateur u
            LEFT JOIN utilisateur_role ur ON ur.idUtilisateur = u.id
            LEFT JOIN role r ON r.id = ur.idRole
            ORDER BY u.login
            ")->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Crée un nouvel utilisateur avec le mot de passe hashé.
 * Retourne true si l'insertion a réussi, false sinon.
 */
function ajouterUtilisateur($prenom, $nom, $email, $login, $mdp) {
    try {
        $bd      = connexionPDO();
        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
        $req     = $bd->prepare("INSERT INTO utilisateur(prenom, nom, mail, login, mdp) VALUES (?, ?, ?, ?, ?)");
        $req->execute([$prenom, $nom, $email, $login, $mdpHash]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function getUtilisateurParId($id) {
    try {
        $bd  = connexionPDO();
        $req = $bd->prepare("
            SELECT u.*, r.nom AS role
            FROM utilisateur u
            LEFT JOIN utilisateur_role ur ON ur.idUtilisateur = u.id
            LEFT JOIN role r ON r.id = ur.idRole
            WHERE u.id = ?
        ");
        $req->execute([$id]);
        return $req->fetch();
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Indique si un login est déjà utilisé par un AUTRE utilisateur que $idExclu.
 */
function loginDejaUtilise($login, $idExclu) {
    try {
        $bd  = connexionPDO();
        $req = $bd->prepare("SELECT COUNT(*) FROM utilisateur WHERE login = ? AND id <> ?");
        $req->execute([$login, $idExclu]);
        return (int) $req->fetchColumn() > 0;
    } catch (Exception $e) {
        return true; // en cas de doute, on bloque
    }
}

/**
 * Modifie un utilisateur. Le mot de passe n'est changé que si $mdp n'est pas vide.
 * Retourne true si la mise à jour a réussi.
 */
function modifierUtilisateur($id, $prenom, $nom, $email, $login, $mdp = '') {
    try {
        $bd = connexionPDO();

        if ($mdp !== '') {
            $req = $bd->prepare("UPDATE utilisateur SET prenom = ?, nom = ?, mail = ?, login = ?, mdp = ? WHERE id = ?");
            $req->execute([$prenom, $nom, $email, $login, password_hash($mdp, PASSWORD_DEFAULT), $id]);
        } else {
            $req = $bd->prepare("UPDATE utilisateur SET prenom = ?, nom = ?, mail = ?, login = ? WHERE id = ?");
            $req->execute([$prenom, $nom, $email, $login, $id]);
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Recherche des utilisateurs par login ou par mail (recherche partielle, insensible à la casse).
 */
function rechercherUtilisateurs($terme) {
    try {
        $bd = connexionPDO();
        $recherche = "%$terme%";
        $req = $bd->prepare("
            SELECT u.*, r.nom AS role
            FROM utilisateur u
            LEFT JOIN utilisateur_role ur ON ur.idUtilisateur = u.id
            LEFT JOIN role r ON r.id = ur.idRole
            WHERE u.login LIKE ? OR u.mail LIKE ?
            ORDER BY u.login
        ");
        $req->execute([$recherche, $recherche]);
        return $req->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Supprime un utilisateur (et son affectation de rôle éventuelle).
 * Retourne true si la suppression a réussi.
 */
function supprimerUtilisateur($id) {
    try {
        $bd = connexionPDO();
        $bd->beginTransaction();

        $req = $bd->prepare("DELETE FROM utilisateur_role WHERE idUtilisateur = ?");
        $req->execute([$id]);

        $req = $bd->prepare("DELETE FROM utilisateur WHERE id = ?");
        $req->execute([$id]);

        $bd->commit();
        return true;
    } catch (Exception $e) {
        if ($bd->inTransaction()) {
            $bd->rollBack();
        }
        return false;
    }
}

?>
