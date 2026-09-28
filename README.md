# gestionRole
Site web permetant de créer, supprimer, lire et gérer les utilisateurs et des rôles.

Page d'acceuil avec inscription et connexion, une fois connecter en fonction du rôle attribuer, accès à une vue qui est différente entre admin et consultant

consultant : permet de voir les utilisateurs et les rôles existant.

admin : même droit que les consultants mais en plus capacité de créer et supprimer des utilisateurs idem pour les rôles, ainsi que d'affecter un rôle à des utilisateurs.



gestionRole.sql -> sript de la BDD ansi qu'un jeu de donnée.

getRacine.php -> permet de centraliser _DIR_.

index.php -> point d'accés.

modele/ -> on y retrouve la connexion à la BDD (bd.inc.php) mais aussi les DAO pour les accés aux données.

vue/ -> permet d'afficher les différents pages web et on y retrouve le CSS.

controleur/ -> permet la liaison entre les vue et le modele.
