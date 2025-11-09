<?php
header("X-Robots-Tag: noindex, nofollow", true);
$current_path = (realpath(dirname(__FILE__)));
$root_path = substr($current_path, 0, strpos($current_path, '/sbin'));

parse_str($argv[1], $params);
$KEY = $params['K'];

if (file_exists($current_path  . "/hash_master.ini")) {
    $dw3_read_ini = parse_ini_file($current_path  . "/hash_master.ini");
    if (isset($dw3_read_ini["masterk"])){
        $MASTERKEY = $dw3_read_ini["masterk"];
    } else {
        die("KEY Error");
    }
} else {
    die("KEY Error");
}

if ($KEY != $MASTERKEY || $KEY == "" || $MASTERKEY == ""){
    die("KEY Error");
}
date_default_timezone_set('America/New_York');

$html = "<h2>Liste des fichiers de logs existants :</h2><br>";
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/user/error_log")){$html .= "Application - Utilisateurs<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/transaction/error_log")){$html .= "Application - Transactions<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/task/error_log")){$html .= "Application - Tâches<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/statistic/error_log")){$html .= "Application - Statistiques<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/project/error_log")){$html .= "Application - Projet<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/product/error_log")){$html .= "Application - Produit<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/production/error_log")){$html .= "Application - Production<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/message/error_log")){$html .= "Application - Messagerie Interne<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/road/error_log")){$html .= "Application - Gestion des routes<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/inventory/error_log")){$html .= "Application - Inventaire<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/import/error_log")){$html .= "Application - Importations de données<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/gl/error_log")){$html .= "Application - Grand Livre<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/road_manager/error_log")){$html .= "Application - Gestion des routes<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/supplier/error_log")){$html .= "Application - Fournisseur<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/timesheet/error_log")){$html .= "Application - Feuille de temps<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/invoice/error_log")){$html .= "Application - Facture client<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/export/error_log")){$html .= "Application - Exportations de données<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/shipping/error_log")){$html .= "Application - Expéditions<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/event/error_log")){$html .= "Application - Évènements<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/quiz/error_log")){$html .= "Application - Application - Document<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/email/error_log")){$html .= "Application - Courriel<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/config/error_log")){$html .= "Application - Configuration<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/order/error_log")){$html .= "Application - Commandes<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/customer/error_log")){$html .= "Application - Client<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/calendar/error_log")){$html .= "Application - Calendrier<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/budget/error_log")){$html .= "Application - Budget<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/article/error_log")){$html .= "Application - Articles<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/purchase/error_log")){$html .= "Application - Achats<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/error_log")){$html .= "Scripts communs à toutes les applications<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/error_log")){$html .= "pub/section<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/slideshow1/error_log")){$html .= "Section - Slideshow 1<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/slideshow2/error_log")){$html .= "Section - Slideshow 2<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/slideshow3/error_log")){$html .= "Section - Slideshow 3<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/slideshow4/error_log")){$html .= "Section - Slideshow 4<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/realisation/error_log")){$html .= "Section - Réalisation<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/classifieds/error_log")){$html .= "Section - Annonces classés<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/products/error_log")){$html .= "Section - Produits<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/product/error_log")){$html .= "Section - Produit<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/navigation/error_log")){$html .= "Section - Navigation<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/perso1/error_log")){$html .= "Section - Perso 1<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/historic/error_log")){$html .= "Section - Historique<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/gallery2/error_log")){$html .= "Section - Gallerie 2<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/gallery1/error_log")){$html .= "Section - Gallerie 1<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/counter3/error_log")){$html .= "Section - Counter3<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/contact3/error_log")){$html .= "Section - Contact 3<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/category_ad/error_log")){$html .= "Section - Catégories annonces classés<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/category/error_log")){$html .= "Section - Catégories produits<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/calendar2/error_log")){$html .= "Section - Calendrier annuel publique<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/calendar/error_log")){$html .= "Section - Calendrier mensuel publique<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/section/affiliate/error_log")){$html .= "Section - Affiliés<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/tracking/error_log")){$html .= "Page - Tracking<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/submit/error_log")){$html .= "Page - Soumission<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/quiz/error_log")){$html .= "Page - Quiz<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/product/error_log")){$html .= "Page - Produit<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/products/error_log")){$html .= "Page - Produits<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/home/error_log")){$html .= "Page - Personnalisée<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/jobs/error_log")){$html .= "Page - Carrière<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/profil/error_log")){$html .= "Page - Profil<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/location/error_log")){$html .= "Page - Selection magasin /location<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/contact1/error_log")){$html .= "Page - Contact 1<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/contact2/error_log")){$html .= "Page - Contact 2<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/contact3/error_log")){$html .= "Page - Contact 3<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/calendar/error_log")){$html .= "Page - Calendrier mensuel publique<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/calendar2/error_log")){$html .= "Page - Calendrier annuel publique<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/classifieds2/error_log")){$html .= "Page - Annonces classés /classifieds2<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/classifieds/error_log")){$html .= "Page - Catégories annonces classés /classifieds<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/article/error_log")){$html .= "Page - Articles et Infolettres<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/agenda/error_log")){$html .= "Page - Agenda publique<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/page/error_log")){$html .= "Page - pub/page<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/css/error_log")){$html .= "/pub/css<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pub/js/error_log")){$html .= "/pub/js<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/api/Square/error_log")){$html .= "api/Square<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/api/paypal/error_log")){$html .= "api/paypal<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/api/livar/error_log")){$html .= "api/livar<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/api/google/error_log")){$html .= "api/google<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/api/DoorDash/error_log")){$html .= "api/DoorDash<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/api/chatGPT/error_log")){$html .= "api/chatGPT<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/api/Grok/error_log")){$html .= "api/Grok<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/api/callbacks/error_log")){$html .= "api/callbacks<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/sbin/error_log")){$html .= "/sbin<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/client/error_log")){$html .= "Tableau de bord Client<br style='margin:0px;'>";}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/error_log")){$html .= "/Root<br style='margin:0px;'>";}

$subject = "Error Logs for ".$_SERVER['SERVER_NAME'];
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$html = "<html><head><title>Message Web</title></head> 
                <body><h3>Error Logs for ".$_SERVER['SERVER_NAME']."</h3>
                ".$html. "
                </body></html>";
$mailer = mail("info@dw3.ca", $subject, $html, $headers);
exit();
?>