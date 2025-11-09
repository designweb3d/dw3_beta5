<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$div_name   = $_GET['N']??"";
$parent_id   = $_GET['P']??"";

//get next sort order
$next_order = 0;
$sql = "SELECT MAX(menu_order) as counter FROM index_head
WHERE parent_id = '" . $parent_id . "';";
$result = mysqli_query($dw3_conn, $sql);
if ($result->num_rows > 0) {
    $data = mysqli_fetch_assoc($result);
    if ($data['counter'] > 0){
        $next_order = $data['counter'];
    }
}
$next_order++;
switch ($div_name) {
//SECTIONS
    case "section_pwa":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'PWA Install Prompt','none','/pub/section/pwa_prompt/index.php','section','false','Ư','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_chatbot":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Chatbot','none','/pub/section/chatbot/index.php','section','false','Ư','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_article":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Articles','none','/pub/section/article/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_infolettre":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Infolettre','none','/pub/section/infolettre/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_profil":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Profil','none','/pub/section/profil/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_tabs2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'2Tabs','none','/pub/section/tabs2/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_tabs3":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'3Tabs','none','/pub/section/tabs3/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_tabs4":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'4Tabs','none','/pub/section/tabs4/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_audio":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Audio','none','/pub/section/audio/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_audio3d":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Audio 3D','none','/pub/section/audio3d/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_calendar":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Calendrier mensuel','none','/pub/section/calendar/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_calendar2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Calendrier annuel','none','/pub/section/calendar2/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_carte":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Carte','none','/pub/section/carte/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_carte2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Carte2','none','/pub/section/carte2/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_carte3":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Carte3','none','/pub/section/carte3/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_contact":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Contact','none','/pub/section/contact1/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_contact2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'no title','none','/pub/section/contact2/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_contact3":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Contact','none','/pub/section/contact3/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_form_link":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Lien vers formulaire','none','/pub/section/form_link/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_retailer":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Détaillants','none','/pub/section/retailer/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_faq":
        $sql = "INSERT INTO index_head (id,title,title_en,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Questions Fréquentes','FAQ','none','/pub/section/faq/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_perso1":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Page perso','none','/pub/section/perso1/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_navigation":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Navigation','none','/pub/section/navigation/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_products":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,boxShadow)
                    VALUES(NULL,'Produits & Services','none','/pub/section/products/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "','1px 1px 3px 1px grey')";
        break;
    case "section_classifieds":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Petites Annonces','none','/pub/section/classifieds/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_product":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Produit','none','/pub/section/product/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_category":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Catégories de produits','none','/pub/section/category/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_category_ad":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Catégories de petites annonces','none','/pub/section/category_ad/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_counter1":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Compteur','none','/pub/section/counter1/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_counter2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Compteurs','none','/pub/section/counter2/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_counter3":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Compteurs','none','/pub/section/counter3/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_attribution":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Attributions','none','/pub/section/attribution/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_affiliate":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Affiliés','none','/pub/section/affiliate/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_welcome":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Bienvenue','none','/pub/section/welcome/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_position":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'job positions','none','/pub/section/position/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_sub":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,opacity,boxShadow,background,max_width)
                    VALUES(NULL,'Sub-section','none','/pub/section/sub/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "','1','','white','')";
        break;
    case "section_sub2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,opacity,boxShadow,background,max_width)
                    VALUES(NULL,'2 Sections','none','/pub/section/sub2/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "','1','','white','')";
        break;
    case "section_sub3":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,opacity,boxShadow,background,max_width)
                    VALUES(NULL,'3 Sections','none','/pub/section/sub3/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "','1','','white','')";
        break;
    case "section_gallery1":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,opacity,boxShadow,background,max_width)
                    VALUES(NULL,'Gallerie','none','/pub/section/gallery1/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "','1','','white','')";
        break;
    case "section_gallery2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,opacity,boxShadow,background,max_width)
                    VALUES(NULL,'Gallerie','none','/pub/section/gallery2/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "','1','','white','')";
        break;
    case "section_gallery3":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,opacity,boxShadow,background,max_width)
                    VALUES(NULL,'Gallerie','none','/pub/section/gallery3/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "','1','','white','')";
        break;
    case "section_slideshow1":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Slideshow','none','/pub/section/slideshow1/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_slideshow2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Slideshow2','none','/pub/section/slideshow2/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_slideshow3":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Card Flip','none','/pub/section/slideshow3/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_slideshow4":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Fading Slide','none','/pub/section/slideshow4/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_texte":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Titre','none','/pub/section/texte/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_historic":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Historique','none','/pub/section/historic/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_realisation":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Réalisations','none','/pub/section/realisation/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_historic2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Historique2','none','/pub/section/historic2/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
    case "section_realisation2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
                    VALUES(NULL,'Réalisations2','none','/pub/section/realisation2/index.php','section','false','ċ','".$next_order."','','','none','" . $parent_id . "')";
        break;
//PAGES
    case "page_home":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
        VALUES(NULL,'Accueil','none','/','page','true','home','100','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_article":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Articles','none','/pub/page/article/index.php','page','true','ċ','33','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_agenda":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Réservation','none','/pub/page/agenda/index.php','page','true','ċ','33','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_jobs":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Carrières','none','/pub/page/jobs/index.php','page','true','ċ','33','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_category":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Catégories de produits','none','/pub/page/category/index.php','page','true','','3','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_calendar":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Calendrier mensuel','none','/pub/page/calendar/index.php','page','true','','3','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_calendar2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Calendrier annuel','none','/pub/page/calendar2/index.php','page','true','','3','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_product":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Produit','none','/pub/page/product/index.php','page','true','','3','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_products":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Produits & Services','none','/pub/page/products/index.php','page','true','','3','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_category":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Catégories de produits','none','/pub/page/category/index.php','page','true','','3','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_classifieds":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Petites Annonces','none','/pub/page/classifieds/index.php','page','true','','3','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_perso":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Landing','none','/pub/page/home/index.php','page','true','ċ','10','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_retailer":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Détaillants','none','/pub/page/location/index.php','page','true','ċ','10','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_location":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Sélection de location','none','/pub/page/location/index.php','page','true','ċ','10','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_submit":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Soumission','none','/pub/page/submit/index.php','page','true','ċ','10','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_contact1":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Landing','none','/pub/page/contact1/index.php','page','true','ċ','17','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_contact2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Landing','none','/pub/page/contact2/index.php','page','true','ċ','17','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_contact3":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Landing','none','/pub/page/contact3/index.php','page','true','ċ','18','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_client":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Espace Client','none','/client','page','true','ċ','19','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_profil":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Profil','none','/pub/page/profil/index.php','page','true','ċ','20','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;
    case "page_tracking":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id,header_path)
                    VALUES(NULL,'Suivi des envois','none','/pub/page/tracking/index.php','page','true','ċ','21','','','none','" . $parent_id . "','".$INDEX_HEADER."')";
        break;

//SUBS
    case "sub":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
        VALUES(NULL,'Nos services','none','','sub','true','pixel','5','','','none','" . $parent_id . "')";
        break;

//JS_ACTION_BUTTONS
    case "button_tel1":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
        VALUES(NULL,'Call','none','dw3_tel1()','button','true','ċ','100','','','none','" . $parent_id . "')";
        break;
    case "button_tel2":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
        VALUES(NULL,'Call','none','dw3_tel2()','button','true','ċ','100','','','none','" . $parent_id . "')";
        break;
    case "button_eml1":
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
        VALUES(NULL,'@". strstr($CIE_EML1, '@', true)."','none','dw3_eml1()','button','true','ċ','100','','','none','" . $parent_id . "')";
        break;

//DEFAULTS
/*     case "":default:
        $sql = "INSERT INTO index_head (id,title,title_display,url,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,parent_id)
        VALUES(NULL,'Accueil','none','/','page','false','ċ','100','','','none','" . $parent_id . "')";
        break; */
}

if ($dw3_conn->query($sql) === TRUE) {
    $new_id = $dw3_conn->insert_id;
    echo $new_id;
    switch ($div_name) {
        case "section_tabs2":case "section_sub2":
            $sql2 = "INSERT INTO index_line (head_id,sort_order) VALUES ('".$new_id."','1');";
            $dw3_conn->query($sql2);
            $sql3 = "INSERT INTO index_line (head_id,sort_order) VALUES ('".$new_id."','2');";
            $dw3_conn->query($sql3);
            break;
        case "section_tabs3":case "section_sub3":
            $sql2 = "INSERT INTO index_line (head_id,sort_order) VALUES ('".$new_id."','1');";
            $dw3_conn->query($sql2);
            $sql3 = "INSERT INTO index_line (head_id,sort_order) VALUES ('".$new_id."','2');";
            $dw3_conn->query($sql3);
            $sql4 = "INSERT INTO index_line (head_id,sort_order) VALUES ('".$new_id."','3');";
            $dw3_conn->query($sql4);
            break;
        case "section_tabs4":
            $sql2 = "INSERT INTO index_line (head_id,sort_order) VALUES ('".$new_id."','1');";
            $dw3_conn->query($sql2);
            $sql3 = "INSERT INTO index_line (head_id,sort_order) VALUES ('".$new_id."','2');";
            $dw3_conn->query($sql3);
            $sql4 = "INSERT INTO index_line (head_id,sort_order) VALUES ('".$new_id."','3');";
            $dw3_conn->query($sql4);
            $sql5 = "INSERT INTO index_line (head_id,sort_order) VALUES ('".$new_id."','4');";
            $dw3_conn->query($sql5);
            break;
    }    
} else {
    echo $dw3_conn->error;
}
$dw3_conn->close();
?>