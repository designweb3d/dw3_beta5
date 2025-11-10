______________ PLATEFORME DW3 BETA5 __________________

Cette application web fonctionne comme un CRM/ERP hybride, offrant des fonctionnalités complètes de planification, de comptabilité, d’évaluation et de gestion logistique.

___________ INSTALLATION AVEC COMPOSER _______________

* 1. Dans le terminal taper la commande suivante: composer require designweb3d/dw3_beta5:@dev

* 2. Déplacer les fichiers à la racine du dossier publique et continuez avec l'étape 3 de la section suivante.

_________ INSTALLATION AVEC LE FICHIER ZIP ___________

Vous pouvez le trouver sur [GitHub][https://github.com/designweb3d/dw3_beta5][version minimale] ou sur [DesignWeb3D][https://designweb3d.com][version complète]

* 1. Déplacer les fichiers et les dossiers décompréssés de DW3_BETAX.zip à la racine du site web, habituellement [/public_html].

* 2. Importer [/sbin/database.sql] sur le serveur MySQL avec les valeurs de phpMyAdmin par défaut.

* 3. Ouvrir [/sbin/config.ini] et ajouter les valeurs correspondantes
        mysqli_servername=
        mysqli_username=
        mysqli_password=
        mysqli_dbname=
        <!-- la variable 'mysqli_servername' peut être 'localhost' ou un serveur distant si l'environement le permet -->

* 4. Ouvrir [/.htaccess] pour entrer le nom de votre domaine au lieu de dw3.ca.

* 5. Si vous avez téléchargé les fichiers par composer ou github, vous devrez installer les API's manuellement. Ouvrir le terminal et aller dans le répertoire [/api] ensuite tapez le commandes suivantes:
      composer require twilio/sdk
      composer require stripe/stripe-php
      composer require dompdf/dompdf
      composer require google/apiclient
      composer require phpmailer/phpmailer
      composer require square/square
      composer require picqer/picqer-php

* 6. Ouvrir le navigateur web pour accèder au système. Utilisateur par défaut pour se connecter <username:>dev <pw:>DesignWeb3D


_____________ CONFIGURATION INITIALE _______________

* Dans l'application Configuration suivre les instructions pour compléter la configuration initiale.

++++++++++++++++++++++
Sur la page d'accueil du site si vous avez un message qui 
dit "Serveur en maintenance" c'est que [/sbin/config.ini]
a été mal configuré. 
Vérifiez si les informations correspondentà celles entrés
lors de la création de la base de donnée, du mot de passe 
et si l'utilisateur a accès a la basede donnée avec le 
maximum de privilèges.+++++++++++++++++++++++

Pour de l'aide n'hésitez pas à contacter Design Web 3D - DesignWeb3D.com
