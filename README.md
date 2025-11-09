======================================
PLATEFORME DW3 BETA5 (designweb3d.com)
======================================
Cette application web fonctionne comme un CRM/ERP hybride, offrant des fonctionnalités complètes de planification, de comptabilité, d’évaluation et de gestion logistique.

============
INSTALLATION
============

* 1. Déplacer les fichiers et les dossiers décompréssés de DW3_BETAX.zip à la racine du site web. Habituellement [/public_html] sur le serveur web. Si vous avez déjà un site existant et vous voulez le conserver vous pouvez ignorer le fichier index.php et conserver votre version tout en utilisant les outils de DW3 en parallèle.

* 2. Importer [/sbin/database.sql] sur le serveur MySQL avec les valeurs de phpMyAdmin par défaut.
        - Vous pouvez déjà modifier la table [user] pour modifier le mot de passe de l'utilisateur 0. Qui ne peut pas être supprimé par le système seulement en SQL. 
        - Valeurs par défaut pour se connecter <username:>dev <pw:>DesignWeb3D

* 3. Ouvrir [/sbin/config.ini] et ajouter les valeurs correspondantes
        mysqli_servername=
        mysqli_username=
        mysqli_password=
        mysqli_dbname=
        <!-- la variable 'mysqli_servername' peut être égale à 'localhost' ou un serveur distant si l'environement le permet -->

* 4. Ouvrir [/.htaccess] pour entrer le nom de votre domaine au lieu de dw3.ca.

* 5. Ouvrir le navigateur web pour accèder au système.

======================
CONFIGURATION INITIALE
======================

* Dans l'application Configuration suivre les instructions pour compléter la configuration initiale.

+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Sur la page d'accueil du site si vous avez un message qui 
dit "Serveur en maintenance" c'est que [/sbin/config.ini]
a été mal configuré. 
Vérifiez si les informations correspondentà celles entrés
lors de la création de la base de donnée, du mot de passe 
et si l'utilisateur a accès a la basede donnée avec le 
maximum de privilèges.
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

Pour de l'aide n'hésitez pas à contacter Design Web 3D - DesignWeb3D.com

