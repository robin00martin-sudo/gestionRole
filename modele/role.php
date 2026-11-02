<?php
require_once 'bd.inc.php';

function getRoles() {
    $bd = connexionPDO();
    return $bd->query("SELECT * FROM role")->fetchAll();
}

function affecterRole($idUser, $idRole) {
    $bd = connexionPDO();
    try {
        $bd->beginTransaction(); //démarre une transaction explicite 

        $req = $bd->prepare("DELETE FROM utilisateur_role WHERE idUtilisateur = ?");
        $req->execute([$idUser]);

        $req = $bd->prepare("INSERT INTO utilisateur_role (idUtilisateur, idRole) VALUES (?, ?)");
        $req->execute([$idUser, $idRole]);

        $bd->commit(); // Valider la transaction en cours
    } catch (Exception $e) {
        if ($bd->inTransaction()) {
            $bd->rollBack(); //annule la transaction en cours et toutes les modifications effectuées lors de cette transaction. 
        }
        throw $e;
    }
}

/**
 * Retourne le rôle (id + nom) affecté à un utilisateur, ou false s'il n'en a pas.
 */
function getRoleUtilisateur($idUser) {
    $bd = connexionPDO();
    $req = $bd->prepare("
        SELECT r.id, r.nom
        FROM role r
        INNER JOIN utilisateur_role ur ON ur.idRole = r.id
        WHERE ur.idUtilisateur = ?
    ");
    $req->execute([$idUser]);
    return $req->fetch();
}

/**
 * Crée un nouveau rôle. Retourne true si l'insertion a réussi.
 */
function ajouterRole($nom) {
    try {
        $bd = connexionPDO();
        $req = $bd->prepare("INSERT INTO role(nom) VALUES (?)");
        $req->execute([$nom]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

