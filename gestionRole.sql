CREATE DATABASE gestion_role;
USE gestion_role;

CREATE TABLE utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(50),
    nom VARCHAR(50),
    mail VARCHAR(100),
    login VARCHAR(50),
    mdp VARCHAR(255)
);

CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50)
);

CREATE TABLE utilisateur_role (
    idUtilisateur INT,
    idRole INT,

    PRIMARY KEY (idUtilisateur, idRole),

    CONSTRAINT fk_utilisateur_role_utilisateur
        FOREIGN KEY (idUtilisateur)
        REFERENCES utilisateur(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_utilisateur_role_role
        FOREIGN KEY (idRole)
        REFERENCES role(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE fonction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50)
);

CREATE TABLE fonction_role (
    idFonction INT,
    idRole INT,

    PRIMARY KEY (idFonction, idRole),

    CONSTRAINT fk_fonction_role_fonction
        FOREIGN KEY (idFonction)
        REFERENCES fonction(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_fonction_role_role
        FOREIGN KEY (idRole)
        REFERENCES role(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

INSERT INTO role(nom)
VALUES
    ('admin'),
    ('consultant'),
    ('moderateur');

INSERT INTO utilisateur(prenom, nom, mail, login, mdp)
VALUES ('Robin', 'Martin', 'test@sio', 'root', '');

INSERT INTO utilisateur_role(idUtilisateur, idRole) VALUES ('1','1');