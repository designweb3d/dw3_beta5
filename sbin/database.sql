
CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL DEFAULT '',
  `account_number` varchar(64) NOT NULL DEFAULT '',
  `amount` float NOT NULL DEFAULT 0,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `montly_fees` float NOT NULL DEFAULT 0,
  `description` varchar(128) NOT NULL DEFAULT '',
  `notes` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `affiliate` (
  `id` int(11) NOT NULL,
  `parent_type` varchar(20) NOT NULL DEFAULT 'supplier',
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `name_fr` varchar(64) NOT NULL DEFAULT '',
  `name_en` varchar(64) NOT NULL DEFAULT '',
  `description_fr` varchar(256) NOT NULL DEFAULT '',
  `description_en` varchar(256) NOT NULL DEFAULT '',
  `href` varchar(512) NOT NULL DEFAULT '',
  `img_link` varchar(512) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `affiliate` (`id`, `parent_type`, `parent_id`, `user_id`, `name_fr`, `name_en`, `description_fr`, `description_en`, `href`, `img_link`) VALUES
(1, 'supplier', 0, 0, 'Hébergement Web Canada', 'Web Hosting Canada', 'Hébergement de site web et achat de domaines.', 'Web hosting and domain purchase.', 'https://clients.whc.ca/aff.php?aff=55', 'https://whc.ca/wp-content/themes/whc/css-modules/images/logo_fr-normal.svg'),
(2, 'supplier', 0, 0, 'SMS.to', 'SMS.to', 'SMS Api ', '', 'https://sms.to/register?referral=c81bf338-c068-4900-b797-34a69b381aa3', 'https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/43006727247/logo/VAKfn28eoMQ3jTHtLJ-lBfCgXhMToM2vDQ.png'),
(4, 'supplier', 0, 0, 'Google Workspace', 'Google Workspace', '', '', 'https://referworkspace.app.goo.gl/6YAq', 'https://refergoogleworkspace.withgoogle.com/assets/imgs/logo.svg'),
(5, 'supplier', 0, 0, 'Multiavatar', 'Multiavatar', '', '', 'https://multiavatar.com/', 'https://multiavatar.com/img/logo-animated.gif?v=003'),
(6, 'supplier', 0, 0, 'Sectigo', 'Sectigo', '', '', 'https://sectigo.com/trust-seal', 'https://sectigo.com/images/seals/sectigo_trust_seal_lg.png'),
(7, 'supplier', 0, 0, 'BrandCrowd', 'BrandCrowd', '', '', 'https://www.brandcrowd.com/maker/drafts/134a9891-9856-4ad3-b18a-336135f54d7b/share', 'https://dcstatic.com/images/brandcrowd/logos/brandcrowd-logo-c481e55e67.svg');

CREATE TABLE `app` (
  `id` int(11) NOT NULL,
  `name_fr` varchar(64) NOT NULL DEFAULT '',
  `name_en` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `auth` varchar(32) NOT NULL DEFAULT '',
  `filename` varchar(1024) NOT NULL DEFAULT '',
  `sort_number` int(4) NOT NULL DEFAULT 0,
  `icon` varchar(128) NOT NULL DEFAULT '',
  `color` varchar(16) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `app` (`id`, `name_fr`, `name_en`, `description`, `auth`, `filename`, `sort_number`, `icon`, `color`) VALUES
(1, 'Messagerie', 'Messaging', 'Messagerie', 'USR', 'message', 510, 'mail_outline', '#0066cc'),
(2, 'Employés', 'Staff', 'Gestion des utilisateurs', 'USR', 'user', 500, 'face', '#0055ee'),
(3, 'Configurations', 'Configs', 'Configurations système', 'GES', 'config', 999, 'settings', '#555555'),
(4, 'Projets', 'Projects', 'Gestion de projets', 'ADM', 'project', 700, 'work', '#555555'),
(5, 'Calendrier', 'Calendar', 'Calendrier des évènements', 'USR', 'calendar', 502, 'calendar_today', '#0055ee'),
(6, 'Inventaire', 'Inventory', 'Gestion de l’nventaire', 'USR', 'inventory', 201, 'view_in_ar ', '#ffbb00'),
(7, 'Feuille de temps', 'Timesheet', 'Feuille de temps utilisateur', 'USR', 'timesheet', 511, 'schedule', '#0066cc'),
(8, 'Fournisseurs', 'Suppliers', 'Gestion des fournisseurs', 'ADM', 'supplier', 300, 'flight_land', '#00dd11'),
(9, 'Clients', 'Customers', 'Gestion des clients', 'USR', 'customer', 100, 'assignment_ind', '#ee3300'),
(10, 'Achats', 'Acquiring', 'Gestion des achats', 'ADM', 'purchase', 301, 'preview', '#00b300'),
(11, 'Commandes', 'Orders', 'Commandes et soumissions', 'USR', 'order', 101, 'request_quote', '#d10000'),
(12, 'Statistiques', 'Statistics', 'Statistiques comptables', 'ADM', 'statistic', 888, 'leaderboard', '#555555'),
(13, 'Grand Livre', 'General Ledger', 'Écritures au Grand Livre', 'ADM', 'gl', 890, 'account_balance', '#555555'),
(14, 'Livre de route', 'Road Book', 'Routes par utilisateur', 'USR', 'road', 550, 'mode_of_travel', '#0066cc'),
(15, 'Produits & Services', 'Products & Services', 'Gestion des produits', 'USR', 'product', 200, 'widgets', '#ffea00'),
(16, 'Gestion des routes', 'Routes Management', 'Gestion des routes', 'ADM', 'road_manager', 720, 'my_location', '#555555'),
(17, 'Caisse', 'Cashier', 'Caisse enregistreuse', 'USR', 'pos', 110, 'point_of_sale', '#cc3300'),
(18, 'Catalogue', 'Catalog', 'Catalogue utilisateur', 'USR', 'catalog', 210, 'style', 'gold'),
(19, 'Importation de données', 'Data Import', 'Importation de donnees', 'ADM', 'import', 900, 'file_upload', '#555555'),
(20, 'Exportation de données', 'Data Export', 'Exportation de données', 'ADM', 'export', 901, 'download', '#555555'),
(21, 'Concurrents', 'Concurrents', 'Infos sur les concurrents', 'ADM', 'concurent', 650, 'do_not_disturb_on', '#555555'),
(22, 'Boîte à outils', 'Toolbox', 'Outils web, conversion de données, listes de caractères spéciaux, etc..', 'USR', 'toolbox', 0, 'square_foot', '#41103d'),
(24, 'Facture client', 'Customer Invoice', '', 'ADM', 'invoice', 102, 'receipt_long', '#a30000'),
(25, 'Facture d’achat', 'Purchase Bill', '', 'ADM', 'bill', 210, 'credit_score', 'green'),
(26, 'Gestion entrepot', 'Warehouse Management', '', 'ADM', 'storage', 710, 'warehouse', 'darkred'),
(27, 'Évenements', 'Events', 'Tâches et évenements', 'USR', 'event', 987, 'event', '#4a4a4a'),
(29, 'Courriels', 'Emails', 'Gestion des courriels', 'ADM', 'email', 1, 'mail', '#333333'),
(30, 'Documents', 'Documents', '', 'USR', 'quiz', 730, 'quiz', '#555'),
(33, 'Éditeur 3D', '3D Editor', '\'\'', 'USR', 'editor', 1, 'token', 'gold'),
(34, 'Budget', 'Budget', '', 'ADM', 'budget', 892, 'savings', '#555555'),
(35, 'Production', 'Production', '', 'ADM', 'production', 202, 'precision_manufacturing', '#ff9500'),
(36, 'Expéditions', 'Shipping', '', 'ADM', 'shipping', 115, 'local_shipping', '#800000'),
(132, 'Articles et Infolettres', 'Articles et Newslettres', 'Éditeur de nouvelles', 'USR', 'article', 782, 'newspaper', '#555555');

CREATE TABLE `app_prm` (
  `app_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` varchar(256) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `app_user` (
  `app_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `read_only` int(1) NOT NULL,
  `used` int(9) NOT NULL DEFAULT 0,
  `favorite` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `app_user` (`app_id`, `user_id`, `read_only`, `used`, `favorite`) VALUES
(1, 0, 0, 0, 0),
(2, 0, 0, 0, 0),
(3, 0, 0, 0, 0),
(4, 0, 0, 0, 0),
(5, 0, 0, 0, 0),
(6, 0, 0, 0, 0),
(7, 0, 0, 0, 0),
(8, 0, 0, 0, 0),
(9, 0, 0, 0, 0),
(10, 0, 0, 0, 0),
(11, 0, 0, 0, 0),
(12, 0, 0, 0, 0),
(13, 0, 0, 0, 0),
(14, 0, 0, 0, 0),
(15, 0, 0, 0, 0),
(16, 0, 0, 0, 0),
(19, 0, 0, 0, 0),
(20, 0, 0, 0, 0),
(22, 0, 0, 0, 0),
(24, 0, 0, 0, 0),
(27, 0, 0, 0, 0),
(30, 0, 0, 0, 0),
(34, 0, 0, 0, 0),
(35, 0, 0, 0, 0),
(36, 0, 0, 0, 0),
(132, 0, 0, 0, 0);

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `category_fr` varchar(30) NOT NULL,
  `category_en` varchar(30) NOT NULL,
  `title_fr` varchar(256) NOT NULL,
  `title_en` varchar(256) NOT NULL,
  `description_fr` varchar(512) NOT NULL DEFAULT '',
  `description_en` varchar(512) NOT NULL DEFAULT '',
  `html_fr` text NOT NULL DEFAULT '\'\'',
  `html_en` text NOT NULL DEFAULT '\'\'',
  `img_link` varchar(256) NOT NULL,
  `author_name` varchar(128) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `allow_comments` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `article_comment` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `comment` varchar(512) NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `article_readings` (
  `article_id` int(11) NOT NULL,
  `minuts` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `attribution` (
  `id` int(11) NOT NULL,
  `name_fr` varchar(64) NOT NULL DEFAULT '',
  `description_fr` varchar(256) NOT NULL DEFAULT '',
  `name_en` varchar(64) NOT NULL DEFAULT '',
  `description_en` varchar(256) NOT NULL DEFAULT '',
  `href` varchar(256) NOT NULL DEFAULT '',
  `img_link` varchar(256) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `attribution` (`id`, `name_fr`, `description_fr`, `name_en`, `description_en`, `href`, `img_link`) VALUES
(1, 'Design Web 3D', 'Créateurs de sites et d’applications web', '', '', 'https://dw3.ca', 'https://designweb3d.com/pub/img/logo2.png');

CREATE TABLE `blacklist` (
  `id` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `eml` varchar(128) NOT NULL DEFAULT '',
  `type` varchar(16) NOT NULL,
  `day_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `budget` (
  `id` int(11) NOT NULL,
  `revenu` int(1) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `freq` varchar(10) NOT NULL,
  `name_fr` varchar(256) NOT NULL,
  `amount` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `cart_line` (
  `id` int(11) NOT NULL,
  `device_id` varchar(64) NOT NULL DEFAULT '',
  `product_id` int(11) NOT NULL DEFAULT 0,
  `quantity` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `ship_type` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `cart_option` (
  `id` int(11) NOT NULL,
  `line_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL DEFAULT 0,
  `option_line_id` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL DEFAULT 0.00,
  `description_fr` varchar(60) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `classified` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `etat` int(1) NOT NULL DEFAULT 1 COMMENT '1NEW, 2ALMOST NEW, 3USED, 4REFURBISHED',
  `drop_shipped` tinyint(1) NOT NULL DEFAULT 0,
  `name_fr` varchar(64) NOT NULL,
  `name_en` varchar(64) NOT NULL,
  `description_fr` varchar(256) NOT NULL,
  `description_en` varchar(256) NOT NULL,
  `qty_available` decimal(9,2) NOT NULL DEFAULT 1.00,
  `price` decimal(9,2) NOT NULL DEFAULT 0.00,
  `tax_fed` tinyint(1) NOT NULL DEFAULT 0,
  `tax_prov` tinyint(1) NOT NULL DEFAULT 0,
  `ship_type` varchar(20) NOT NULL DEFAULT '0',
  `kg` decimal(9,4) NOT NULL DEFAULT 0.0000,
  `height` int(7) NOT NULL DEFAULT 0,
  `width` int(7) NOT NULL DEFAULT 0,
  `depth` int(7) NOT NULL DEFAULT 0,
  `img_link` varchar(256) NOT NULL DEFAULT '',
  `brand` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `year_production` int(4) NOT NULL DEFAULT 0,
  `recommended` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `concurent` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT '',
  `adr1` varchar(128) NOT NULL DEFAULT '',
  `city` varchar(64) NOT NULL DEFAULT '',
  `province` varchar(64) NOT NULL DEFAULT 'Quebec',
  `country` varchar(64) NOT NULL DEFAULT 'Canada',
  `postal_code` varchar(16) NOT NULL DEFAULT '',
  `tel1` varchar(16) NOT NULL DEFAULT '',
  `eml1` varchar(128) NOT NULL DEFAULT '',
  `longitude` float NOT NULL DEFAULT 0,
  `latitude` float NOT NULL DEFAULT 0,
  `note` text NOT NULL DEFAULT '',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `user_modified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `config` (
  `kind` varchar(30) NOT NULL,
  `code` varchar(30) NOT NULL,
  `text1` mediumtext NOT NULL DEFAULT '',
  `text2` mediumtext NOT NULL DEFAULT '',
  `text3` mediumtext NOT NULL DEFAULT '',
  `text4` mediumtext NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `config` (`kind`, `code`, `text1`, `text2`, `text3`, `text4`) VALUES
('AUTH', 'ADM', 'Administrateur', 'Administrator', '', ''),
('AUTH', 'AUD', 'Auditeur', 'Auditor', '', ''),
('AUTH', 'GES', 'Gestionnaire', 'Owner', '', ''),
('AUTH', 'RBT', 'Robot ou IA', 'Robot or AI', '', ''),
('AUTH', 'USR', 'Utilisateur', 'Users', '', ''),
('AUTH', 'VIS', 'Visiteur', 'Visitor', '', ''),
('CIE', 'ADR1', 'Adresse ligne 1', '', '', ''),
('CIE', 'ADR2', '', '', '', ''),
('CIE', 'ADR_PUB', 'true', '', '', ''),
('CIE', 'ADR_PUB2', 'false', '', '', ''),
('CIE', 'BG1', '', '', '', ''),
('CIE', 'BG2', 'IMG_1093.JPG', '', '', ''),
('CIE', 'BG3', 'just_white.png', '', '', ''),
('CIE', 'BG4', '', '', '', ''),
('CIE', 'BG5', '', '', '', ''),
('CIE', 'BTN_BORDER', '', '', '', ''),
('CIE', 'BTN_RADIUS', '10px', '', '', ''),
('CIE', 'BTN_SHADOW', '0px 0px 3px 1px var(--dw3_button_color)', '', '', ''),
('CIE', 'CAT', '18', '', '', ''),
('CIE', 'CODE_POSTAL', 'J5M 1Y2', '', '', ''),
('CIE', 'COLOR0', '545454', '', '', ''),
('CIE', 'COLOR0_1', '4fb832', '', '', ''),
('CIE', 'COLOR1', '3286b5', '', '', ''),
('CIE', 'COLOR10', 'ffffff', '', '', ''),
('CIE', 'COLOR11', '3286b5', '1d5e87', 'ffffff', ''),
('CIE', 'COLOR11_1', '#FFF', '', '', ''),
('CIE', 'COLOR11_2', '#FFF', '', '', ''),
('CIE', 'COLOR11_3', '#444', '', '', ''),
('CIE', 'COLOR1_2', '1d5e87', '', '', ''),
('CIE', 'COLOR1_3', '3ebfd0', '', '', ''),
('CIE', 'COLOR2', 'ffffff', '', '', ''),
('CIE', 'COLOR3', 'fff2e0', '', '', ''),
('CIE', 'COLOR4', '000000', '', '', ''),
('CIE', 'COLOR5', 'ffffff', '', '', ''),
('CIE', 'COLOR6', '3286b5', '1d5e87', '', ''),
('CIE', 'COLOR7', 'ffffff', 'ffffff', 'd1edff', '212121'),
('CIE', 'COLOR8', '3286b5', '', '', ''),
('CIE', 'COLOR8_2', '1d5e87', '', '', ''),
('CIE', 'COLOR8_3', '0d0d0d', '', '', ''),
('CIE', 'COLOR8_3S', '0', '', '', ''),
('CIE', 'COLOR8_4', '262626', '', '', ''),
('CIE', 'COLOR8_4S', '0', '', '', ''),
('CIE', 'COLOR9', 'ffffff', '', '', ''),
('CIE', 'COOKIE_MSG', 'Nous utilisons des cookies pour améliorer votre expérience de navigation, diffuser des publicités ou des contenus personnalisés et analyser notre trafic. En cliquant sur «<b> Tout accepter </b>», vous consentez à notre utilisation des cookies.', 'We use cookies to enhance your browsing experience, deliver personalized ads or content, and analyze our traffic. By clicking \"Accept All\", you consent to our use of cookies.', 'cookies5.png', ''),
('CIE', 'COOKIE_MSG_EN', 'We use cookies to enhance your browsing experience and to improve our website. Click «<b> Accept All </b>» to agree and continue browsing or manage your preferences.', '', '', ''),
('CIE', 'CP', 'H0H 0H0', '', '', ''),
('CIE', 'DEEPL', '', '', '', ''),
('CIE', 'DFT_ADR1', '1', '', '', ''),
('CIE', 'DFT_ADR2', '1', '', '', ''),
('CIE', 'DFT_ADR3', '1', '', '', ''),
('CIE', 'DTLVDU', '7', 'day', '0', 'day'),
('CIE', 'EML1', 'info@dw3.ca', '', '', ''),
('CIE', 'EML2', 'info@dw3.ca', '', '', ''),
('CIE', 'EML3', 'info@dw3.ca', '', '', ''),
('CIE', 'EML4', 'info@dw3.ca', '', '', ''),
('CIE', 'FADE', 'Anim-Quadra.gif', '', '', ''),
('CIE', 'FONT1', 'Tajawal', '', '', ''),
('CIE', 'FONT2', 'Montserrat', '', '', ''),
('CIE', 'FONT3', 'Tajawal', '', '', ''),
('CIE', 'FONT4', 'Julius', '', '', ''),
('CIE', 'FONT_SERIF', 'sans-serif', '', '', ''),
('CIE', 'FRAME', 'frame1.png', '', '', ''),
('CIE', 'FREE_MIN', '', 'CALL', '', 'hour'),
('CIE', 'GANALYTICS', '', '', '', ''),
('CIE', 'GMAP_KEY', '', '', '', ''),
('CIE', 'GMAP_MAP', '', '', '', ''),
('CIE', 'GOOGLE_MAP', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2776.843224072613!2d-73.75730105358828!3d45.894448545800415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc8c95cefffffe7%3A0xfe1024983019ad10!2sMuseaux%20d&#39;%C3%89cosse%20(Les)!5e0!3m2!1sfr!2sca!4v1732589647707!5m2!1sfr!2sca', '', '', ''),
('CIE', 'GRAB', 'false', '0', '0', 'false'),
('CIE', 'G_ID', '', '', '', ''),
('CIE', 'G_IMG', 'google_login_4.svg', '', '', ''),
('CIE', 'G_SECRET', '', '', '', ''),
('CIE', 'HOME', '', 'ORDER', '', ''),
('CIE', 'INVOICE_NOTE', '', '', '', ''),
('CIE', 'LIVAR_KEY', '', '', '', ''),
('CIE', 'LIVAR_MODE', 'DEV', '', '', ''),
('CIE', 'LOAD', 'load08.gif', '', '', ''),
('CIE', 'LOGO1', 'favicon.svg', '', '', ''),
('CIE', 'LOGO2', 'favicon.svg', '', '', ''),
('CIE', 'LOGO3', 'logo2.png', '', '', ''),
('CIE', 'LOGO4', 'favicon.svg', '', '', ''),
('CIE', 'LOGO5', '16', '', '', ''),
('CIE', 'MAG_INTERAC', 'true', '', '', ''),
('CIE', 'NE', '', '', '', ''),
('CIE', 'NEQ', '', '', '', ''),
('CIE', 'NOM', 'Plateforme DW3 BETA 5', '', '2025', 'false'),
('CIE', 'NOM_HTML', '', '', '', ''),
('CIE', 'OPEN_J0', '00:00', '00:00', '00:00', '00:00'),
('CIE', 'OPEN_J03', '', '', '', ''),
('CIE', 'OPEN_J1', '08:00', '17:00', '00000', '00000'),
('CIE', 'OPEN_J2', '08:00', '17:00', '00000', '00000'),
('CIE', 'OPEN_J3', '08:00', '17:00', '00000', '00000'),
('CIE', 'OPEN_J4', '08:00', '17:00', '00000', '00000'),
('CIE', 'OPEN_J46', '', '', '', ''),
('CIE', 'OPEN_J5', '08:00', '17:00', '00000', '00000'),
('CIE', 'OPEN_J6', '00:00', '00:00', '00000', '00000'),
('CIE', 'OPEN_JEN1', '', '', '', ''),
('CIE', 'OPEN_JEN2', '', '', '', ''),
('CIE', 'OPEN_JFR1', '', '', '', ''),
('CIE', 'OPEN_JFR2', '', '', '', ''),
('CIE', 'PAYS', 'Canada', '', '', ''),
('CIE', 'PAYS_ID', '47', '', '', ''),
('CIE', 'PICKUP', 'undefined', '', '', ''),
('CIE', 'POSTE_KEY', '', '', '', ''),
('CIE', 'POSTE_MODE', 'DEV', '', '', ''),
('CIE', 'POSTE_PW', '', '', '', ''),
('CIE', 'POSTE_USER', '', '', '', ''),
('CIE', 'PROTECTOR', '-1', '', '', ''),
('CIE', 'PROV', 'QC', '', '', ''),
('CIE', 'PROV_ID', '738', '', '', ''),
('CIE', 'PTPS', '5.000', '', '', ''),
('CIE', 'PTVQ', '9.975', '', '', ''),
('CIE', 'PUB_HTML', 'https://dw3.ca', '', '', ''),
('CIE', 'RBQ', '', '', '', ''),
('CIE', 'RS_FB', 'https:/facebook.com', '', '', ''),
('CIE', 'RS_LINKEDIN', 'https://linkedin.com', '', '', ''),
('CIE', 'SMS_KEY', '', '', '', ''),
('CIE', 'SMS_SENDER', '', '', '', ''),
('CIE', 'STRIPE_KEY', '', '', '', ''),
('CIE', 'STRIPE_SECRET', '', '', '', ''),
('CIE', 'TEL1', '555-555-5555', '', '', ''),
('CIE', 'TEL2', '', '', '', ''),
('CIE', 'TITRE', 'Titre', '', '', ''),
('CIE', 'TPS', 'RT0001', '', '', ''),
('CIE', 'TRANSPORT', 'INTERNAL', '', '', ''),
('CIE', 'TRANSPORT_PRICE', '', 'true', '', ''),
('CIE', 'TVQ', 'TQ0001', '', '', ''),
('CIE', 'TWILIO_AUTH', '', '', '', ''),
('CIE', 'TWILIO_SENDER', '', '', '', ''),
('CIE', 'TWILIO_SID', '', '', '', ''),
('CIE', 'TX_AB', '5', '0', '0', ''),
('CIE', 'TX_BC', '5', '7', '0', ''),
('CIE', 'TX_MB', '5', '7', '0', ''),
('CIE', 'TX_NB', '0', '0', '15', ''),
('CIE', 'TX_NL', '0', '0', '15', ''),
('CIE', 'TX_NS', '0', '0', '15', ''),
('CIE', 'TX_NT', '5', '0', '0', ''),
('CIE', 'TX_NU', '5', '0', '0', ''),
('CIE', 'TX_ON', '13', '0', '0', ''),
('CIE', 'TX_PE', '0', '0', '15', ''),
('CIE', 'TX_QC', '5', '9.975', '0', ''),
('CIE', 'TX_SK', '5', '6', '0', ''),
('CIE', 'TX_YT', '5', '0', '0', ''),
('CIE', 'TYPE', '1', '', '', ''),
('CIE', 'VILLE', 'Ville', '', '', ''),
('CIE', 'VILLE_ID', '0', '', '', ''),
('CIE_CAT', '10', 'Finance et assurances', 'Finance et assurances', '', ''),
('CIE_CAT', '11', 'Gestion de sociétés et d’entreprises', 'Gestion de sociétés et d’entreprises', '', ''),
('CIE_CAT', '12', 'Hébergement et services de restauration', 'Hébergement et services de restauration', '', ''),
('CIE_CAT', '13', 'Industrie de l’information et industrie culturelle', 'Industrie de l’information et industrie culturelle', '', ''),
('CIE_CAT', '14', 'Services administratifs, services de soutien, services de gestion des déchets et services d’assainissement', 'Services administratifs, services de soutien, services de gestion des déchets et services d’assainissement', '', ''),
('CIE_CAT', '15', 'Services d’enseignement', '', '', ''),
('CIE_CAT', '16', 'Services de restauration et débit de boisson', 'Services de restauration et débit de boisson', '', ''),
('CIE_CAT', '17', 'Services immobiliers et services de location et de location ', 'Services immobiliers et services de location et de location', '', ''),
('CIE_CAT', '18', 'Services professionnels, scientifiques et techniques', 'Services professionnels, scientifiques et techniques', '', ''),
('CIE_CAT', '19', 'Soins de santé et assistance sociale', 'Soins de santé et assistance sociale', '', ''),
('CIE_CAT', '2', 'Agriculture, foresterie, pêche et chasse', 'Agriculture, foresterie, pêche et chasse', '', ''),
('CIE_CAT', '20', 'Transport et entreposage', 'Transport et entreposage', '', ''),
('CIE_CAT', '21', 'Transport par camion', 'Transport par camion', '', ''),
('CIE_CAT', '3', 'Arts, spectacles et loisirs', 'Arts, spectacles et loisirs', '', ''),
('CIE_CAT', '4', 'Autres services (sauf les administrations publiques)', 'Autres services (sauf les administrations publiques)', '', ''),
('CIE_CAT', '5', 'Commerce de détail', 'Commerce de détail', '', ''),
('CIE_CAT', '6', 'Commerce de gros', 'Commerce de gros', '', ''),
('CIE_CAT', '7', 'Construction', 'Construction', '', ''),
('CIE_CAT', '8', 'Extraction minière, exploitation en carrière, et extraction de pétrole et de gaz', 'Extraction minière, exploitation en carrière, et extraction de pétrole et de gaz', '', ''),
('CIE_CAT', '9', 'Fabrication', 'Fabrication', '', ''),
('CIE_TYPE', '1', 'Entreprise individuelle (travailleur autonome)', 'Entreprise individuelle', '', ''),
('CIE_TYPE', '2', 'Société en nom collectif (S.E.N.C.)', 'Necessite un contrat de société verbal ou écrit incluant la part de chaque associés,répartition des pouvoirs de gestion et responsabilité, ', '', ''),
('CIE_TYPE', '3', 'Société en commandite (S.E.C.)', '1 commandité (gestionnaire) et des commanditaires (investisseurs sans pouvoirs)', '', ''),
('CIE_TYPE', '4', 'Société par actions (INCorporée - personne morale)', 'Société par actions (INCorporée - personne morale)', '', ''),
('CIE_TYPE', '5', 'Coopérative (INCorporée - personne morale)', 'Coopérative (INCorporée - personne morale)', '', ''),
('CIE_TYPE', '6', 'Organisme a but non lucratif', 'Organisme a but non lucratif', '', ''),
('DEPT', 'ACHAT', 'Achats et planifications', 'Achats et planifications', '', ''),
('DEPT', 'COMPT', 'Comptabilité', 'Comptabilité', '', ''),
('DEPT', 'CONCEPT', 'Conception', 'Conception', '', ''),
('DEPT', 'FAB', 'Fabrication', 'Fabrication', '', ''),
('DEPT', 'ING', 'Ingénérie', 'Ingénérie', '', ''),
('DEPT', 'MARK', 'Marketing', 'Marketing', '', ''),
('DEPT', 'PR', 'Relations publiques et juridiques', 'Relations publiques et juridiques', '', ''),
('DEPT', 'RECH', 'Recherches et développement', 'Recherches et développement', '', ''),
('DEPT', 'VENTE', 'Ventes et services', 'Ventes et services', '', ''),
('DIVISION', 'COMM-LAVAL', 'Commercial - Laval', 'Commercial - Laval', '', ''),
('DIVISION', 'COMM-TERREBONNE', 'Commercial - Terrebonne', 'Commercial - Terrebonne', '', ''),
('DIVISION', 'RES-LAVAL', 'R?sidentiel - Laval', 'R?sidentiel - Laval', '', ''),
('FRN_TYPE', '', 'Type de fournisseur', 'Supplier type', '', ''),
('FRN_TYPE', 'APP', 'Logiciels', 'Applications', '', ''),
('FRN_TYPE', 'BANK', 'Banque', 'Bank', '', ''),
('FRN_TYPE', 'COMM', 'Internet,  téléphonie, site web.', 'Internet,  téléphonie, site web.', '', ''),
('FRN_TYPE', 'CREDIT', 'Compte de crédit', 'Credit account', '', ''),
('FRN_TYPE', 'FOURNI', 'Fournitures', 'Fournitures', '', ''),
('FRN_TYPE', 'IMMOB', 'Location immobiliere', 'Location immobiliere', '', ''),
('FRN_TYPE', 'MAINT', 'Entretien', 'Maintenance', '', ''),
('FRN_TYPE', 'POWER', 'Électricité', 'Electricity', '', ''),
('FRN_TYPE', 'REP', 'Réparations', 'Reparations', '', ''),
('FRN_TYPE', 'TRANSPORT', 'Transporteur', 'Carrier', '', ''),
('GL', 'DATE_END', '2023-12-31', '', '', ''),
('GL', 'DATE_START', '2023-01-01', '2023', '', ''),
('GL', 'P10_END', '2023-10-31', '', '', ''),
('GL', 'P10_START', '2023-10-01', 'Octobre', '', ''),
('GL', 'P11_END', '2023-11-30', '', '', ''),
('GL', 'P11_START', '2023-11-01', 'Novembre', '', ''),
('GL', 'P12_END', '2023-12-31', '', '', ''),
('GL', 'P12_START', '2023-12-01', 'Décembre', '', ''),
('GL', 'P1_END', '2023-01-31', '', '', ''),
('GL', 'P1_START', '2023-01-01', 'Janvier', '', ''),
('GL', 'P2_END', '2023-02-28', '', '', ''),
('GL', 'P2_START', '2023-02-01', 'Fevrier', '', ''),
('GL', 'P3_END', '2023-03-31', '', '', ''),
('GL', 'P3_START', '2023-03-01', 'Mars', '', ''),
('GL', 'P4_END', '2023-04-30', '', '', ''),
('GL', 'P4_START', '2023-04-01', 'Avril', '', ''),
('GL', 'P5_END', '2023-05-31', '', '', ''),
('GL', 'P5_START', '2023-05-01', 'Mai', '', ''),
('GL', 'P6_END', '2023-06-30', '', '', ''),
('GL', 'P6_START', '2023-06-01', 'Juin', '', ''),
('GL', 'P7_END', '2023-07-31', '', '', ''),
('GL', 'P7_START', '2023-07-01', 'Juillet', '', ''),
('GL', 'P8_END', '2023-08-30', '', '', ''),
('GL', 'P8_START', '2023-08-01', 'Août', '', ''),
('GL', 'P9_END', '2023-09-31', '', '', ''),
('GL', 'P9_START', '2023-09-01', 'Septembre', '', ''),
('GL', 'YEAR', '2023', '', '', ''),
('INDEX', 'CART', 'false', 'false', '', ''),
('INDEX', 'COUNTER1', 'Configuration', 'Counter 1', '237194', 'screenshot_monitor'),
('INDEX', 'COUNTER2', 'Structure de l’entreprise', 'Counter 2', '17994', 'business_center'),
('INDEX', 'COUNTER3', 'Variables d’environement', 'Counter 3', '455', 'sentiment_satisfied_alt'),
('INDEX', 'DASHBOARD_DSP', '10111111111111010', '', '', ''),
('INDEX', 'FACEBOOK', 'https://www.facebook.com/people/Design-Web-3D/61556822940580/', '', '', ''),
('INDEX', 'FOOTER', '/pub/section/footer18.php', 'false', '', ''),
('INDEX', 'FOOT_MARGIN', '0', 'false', '', ''),
('INDEX', 'HEADER', '/pub/section/header22.php', 'false', '', ''),
('INDEX', 'INDEX_DSP_LANG', 'false', 'false', '', ''),
('INDEX', 'INDEX_LANG', 'FR', '', '', ''),
('INDEX', 'INDEX_META_DESC', '', '', '', ''),
('INDEX', 'INDEX_META_KEYW', '', '', '', ''),
('INDEX', 'INDEX_TITLE_EN', 'Index Title', '', '', ''),
('INDEX', 'INDEX_TITLE_FR', 'Titre Index', '', '', ''),
('INDEX', 'INDEX_TOP_EN', '', '', '', ''),
('INDEX', 'INDEX_TOP_FR', '', '', '', ''),
('INDEX', 'INSTAGRAM', '', '', '', ''),
('INDEX', 'LINKEDIN', '', '', '', ''),
('INDEX', 'PERSO1', '', '', '', ''),
('INDEX', 'PERSO2', '', '', '', ''),
('INDEX', 'PERSO3', '', '', '', ''),
('INDEX', 'PERSO4', '', '', '', ''),
('INDEX', 'PERSO5', '', '', '', ''),
('INDEX', 'PINTEREST', '', '', '', ''),
('INDEX', 'SCENE', '', 'false', '', ''),
('INDEX', 'SNAPCHAT', '', '', '', ''),
('INDEX', 'TIKTOK', 'https://www.tiktok.com/@designweb3d', '', '', ''),
('INDEX', 'TOTAL_VISITED', '80', '', '', ''),
('INDEX', 'TWITTER', '', '', '', ''),
('INDEX', 'YOUTUBE', '', '', '', ''),
('LBL', 'ACH', 'Achat', 'Purchase', '', ''),
('LBL', 'ACTIF', 'Actif', 'Active', '', ''),
('LBL', 'ADD_PRD', 'Scannez un code bare ou recherchez un produit', 'Scan a barcode or search for a product', '', ''),
('LBL', 'ADM', 'Administrateur', 'Administrateur', '', ''),
('LBL', 'ADR', 'Adresse compl&#232;te', 'Complete adress', '', ''),
('LBL', 'ADR1', 'Adresse ligne 1', 'Adress line 1', '', ''),
('LBL', 'ADR2', 'Adresse ligne 2', 'Adress line 2', '', ''),
('LBL', 'ALL', 'Tous', 'All', '', ''),
('LBL', 'AMOUNT', 'Montant', 'Amount', '', ''),
('LBL', 'ANOTHER', 'Cr&#233;er un autre', 'Create another', '', ''),
('LBL', 'APLC_COMPLETE', 'Toutes les applications sont associ&#233;es', 'All available applications added', '', ''),
('LBL', 'APLC_DFT', 'Application par d&#233;faut', 'Launch this application after login', '', ''),
('LBL', 'APLC_NOTFOUND', 'Aucunes applications associ&#233;es', 'No application found', '', ''),
('LBL', 'AUTH', 'Authorisations', 'Authorisations', '', ''),
('LBL', 'BILL', 'Facture d’achat', 'Purchase invoice', '', ''),
('LBL', 'CALC', 'Calculatrice', 'Calculator', '', ''),
('LBL', 'CANCEL', 'Annuler', 'Cancel', '', ''),
('LBL', 'CANCELED', 'Annulé', 'Canceled', '', ''),
('LBL', 'CAT', 'Cat&#233;gorie', 'Category', '', ''),
('LBL', 'CLI', 'Client', 'Customer', '', ''),
('LBL', 'CLIS', 'Clients', 'Customers', '', ''),
('LBL', 'CLOCK', 'Horloge', 'Clock', '', ''),
('LBL', 'CLOSE', 'Fermer', 'Close', '', ''),
('LBL', 'CONVD', 'Ligne de temps', 'Timeline', '', ''),
('LBL', 'CONVM', 'Conversion', 'Converter', '', ''),
('LBL', 'CP', 'Code Postal', 'Postal Code', '', ''),
('LBL', 'CREATE', 'Cr&#233;er', 'Create', '', ''),
('LBL', 'CREATED', 'Cr&#233;ation termin&#233;e.', 'Created', '', ''),
('LBL', 'CUSTOMER_ID', 'No de client', 'Customer ID', '', ''),
('LBL', 'DEL', 'Supprimer', 'Delete', '', ''),
('LBL', 'DELETED', 'Supprimé', 'Deleted', '', ''),
('LBL', 'DEL_ASK', 'Voulez-vous vraiment effacer ces donn&#233;es ?', 'Are you sure to delete this data ?', '', ''),
('LBL', 'DEL_ERR0', 'Le client par d&#233;faut ne peut &#234;tre supprim&#233;.', 'This customer can’t be deleted.', '', ''),
('LBL', 'DEL_ERR1', 'Ces donn&#233;es ne peuvent &#234;tre supprim&#233;es.', 'This data can&#8216;t be deleted', '', ''),
('LBL', 'DEL_OK', 'Suppression termin&#233;e.', 'Deleted', '', ''),
('LBL', 'DEPTH', 'Profondeur en cm', 'Depth (cm)', '', ''),
('LBL', 'DESC', 'Description', 'Description', '', ''),
('LBL', 'DESC_EN', 'Description ANGLAIS', 'Description ENGLISH', '', ''),
('LBL', 'DESC_FR', 'Description FRANÇAIS', 'Description FRENCH', '', ''),
('LBL', 'DOCUMENT', 'Document justificatif', 'Documentary evidence', '', ''),
('LBL', 'DONE', 'Termin&#233;', 'Done', '', ''),
('LBL', 'DSP_INV', 'Afficher les quantiés disponibles', 'Display available quantities', '', ''),
('LBL', 'DSP_OPT', 'Afficher les options du produit', 'Display product options', '', ''),
('LBL', 'DSP_STATUS', 'Afficher le status du produit', 'Display product status', '', ''),
('LBL', 'DSP_UPC', 'Afficher le code UPC', 'Display UPC code', '', ''),
('LBL', 'DTAD', 'Date de cr&#233;ation', 'Created', '', ''),
('LBL', 'DTCR', 'Age du compte', 'Account age', '', ''),
('LBL', 'DTDU', 'Date due', 'Due date', '', ''),
('LBL', 'DTMD', 'Derni&#232;res modifications', 'Last modification', '', ''),
('LBL', 'DTXP', 'Date exp&#233;dition', 'Expedition Date', '', ''),
('LBL', 'EML', 'Courriel', 'Email', '', ''),
('LBL', 'EML1', 'Adresse e-mail principale', 'Email 1', '', ''),
('LBL', 'EML2', 'Adresse e-mail secondaire', 'Email 2', '', ''),
('LBL', 'EN', 'Anglais', 'English', '', ''),
('LBL', 'ENCY', 'Encyclop&#233;die', 'Encyclopedia', '', ''),
('LBL', 'ERR', 'Erreur', 'Error', '', ''),
('LBL', 'ERROR', 'Erreur ', 'Error', '', ''),
('LBL', 'ERR_SEL1', 'Aucune selection', 'Nothing selected', '', ''),
('LBL', 'ES', 'Espagnol', 'Spanish', '', ''),
('LBL', 'FEMALE', 'Femme', 'Woman', '', ''),
('LBL', 'FILTER', 'Filtrer', 'Filter', '', ''),
('LBL', 'FLNAM', 'Nom & Pr&#233;nom', 'First name & last name', '', ''),
('LBL', 'FNAM', 'Pr&#233;nom', 'First name', '', ''),
('LBL', 'FR', 'Fran&#231;ais', 'French', '', ''),
('LBL', 'FRN', 'Fournisseur', 'Supplier', '', ''),
('LBL', 'FRN1', 'Fournisseur principal', 'Main supplier', '', ''),
('LBL', 'FULLNAME', 'Nom complet', 'Complete name', '', ''),
('LBL', 'GES', 'Gestionnaire', 'Gestionnaire', '', ''),
('LBL', 'GL_CODE', 'Code GL', 'GL Code', '', ''),
('LBL', 'HEIGHT', 'Hauteur en cm', 'Height (cm)', '', ''),
('LBL', 'ID', '#ID', 'ID#', '', ''),
('LBL', 'INACTIF', 'Inactif', 'Inactive', '', ''),
('LBL', 'INIT', 'Initiales', 'Initiales', '', ''),
('LBL', 'INVOICE', 'Facture client', 'Customer Invoice', '', ''),
('LBL', 'JOURS_CONSERV', 'Jours de conservation', 'Storage days', '', ''),
('LBL', 'KG', 'Poid en KG', 'Weight (kg)', '', ''),
('LBL', 'LANG', 'Langue', 'Language', '', ''),
('LBL', 'LAT', 'Latitude', 'Latitude', '', ''),
('LBL', 'LNAM', 'Nom de famille', 'Last name', '', ''),
('LBL', 'LNG', 'Longitude', 'Longitude', '', ''),
('LBL', 'LOC', 'Lieu de travail', 'Localisation', '', ''),
('LBL', 'LOGIN', 'Ouverture de session', 'Login', '', ''),
('LBL', 'LOGOUT', 'Déconnexion', 'Disconnect', '', ''),
('LBL', 'MAG_DSP', 'Disponible en magasin', 'Available in store', '', ''),
('LBL', 'MALE', 'Homme', 'Male', '', ''),
('LBL', 'MNAM', 'Deuxi&#232;me pr&#233;nom', 'Mid name', '', ''),
('LBL', 'MODIFIED', 'Modification terminée', 'Done updating record', '', ''),
('LBL', 'MODIFY', 'Modifier', 'Modify', '', ''),
('LBL', 'NAME', 'Nom', 'Name', '', ''),
('LBL', 'NEW', 'Nouveau', 'New', '', ''),
('LBL', 'NEW_ACH', 'Nouvel achat', 'New purchase', '', ''),
('LBL', 'NEW_CLI', 'Nouveau client', 'New customer', '', ''),
('LBL', 'NEW_CMD', 'Nouvelle commande', 'New order', '', ''),
('LBL', 'NEW_ECR', 'Nouvelle écriture', 'New writing', '', ''),
('LBL', 'NEW_FRN', 'Nouveau fournisseur', 'New supplier', '', ''),
('LBL', 'NEW_LOC', 'Nouvelle adresse', 'New address', '', ''),
('LBL', 'NEW_PRD', 'Nouveau produit', 'New product', '', ''),
('LBL', 'NEW_USR', 'Nouvel utilisateur', 'New user', '', ''),
('LBL', 'NOM', 'Nom', 'Name', '', ''),
('LBL', 'NOM_COMPAGNIE', 'Nom de la compagnie', 'Company name', '', ''),
('LBL', 'NOM_CONTACT', 'Nom du contact', 'Contact name', '', ''),
('LBL', 'NONE', 'Aucun', 'None', '', ''),
('LBL', 'NOTE', 'Notes', 'Notes', '', ''),
('LBL', 'NOTEB', 'Calpin de notes', 'Notebook', '', ''),
('LBL', 'ORDER', 'Commande', 'Commande', '', ''),
('LBL', 'ORDERBY', 'Trier par', 'Order by', '', ''),
('LBL', 'ORDERS', 'Commandes', 'Commandes', '', ''),
('LBL', 'ORDER_ID', '#ID Commande', 'Order ID#', '', ''),
('LBL', 'ORDV', 'Pays, province, ville et rue', 'Country, state, city and street', '', ''),
('LBL', 'ORD_ASC', '&Delta; Ascendent', '&Delta; Ascending', '', ''),
('LBL', 'ORD_DESC', '&nabla; Descendent', '&nabla; Descending', '', ''),
('LBL', 'PACK', 'Qté/boite', 'Qty/box', '', ''),
('LBL', 'PARAM', 'Param&#232;tres de l’application', 'Application parameters', '', ''),
('LBL', 'PAYS', 'Pays', 'Country', '', ''),
('LBL', 'PERIOD', 'Période', 'Period', '', ''),
('LBL', 'PRD', '#Produit', 'Product#', '', ''),
('LBL', 'PRD_ALL', 'Tous', 'All', '', ''),
('LBL', 'PRD_FCT', 'Type de facturation', 'Type of billing', '', ''),
('LBL', 'PRD_FCT_ACCES', 'Droit d’accès permanent (ou jusqu’à résiliation du contrat)', 'Droit d’accès permanent (ou jusqu’à résiliation du contrat)', '', ''),
('LBL', 'PRD_FCT_ANNUEL', 'Abonnement et paiments annuel', 'Abonnement et paiments annuel', '', ''),
('LBL', 'PRD_FCT_CREDIT', 'Facturer une fois, livré et un mois pour payer.', 'Facturer une fois, livré et un mois pour payer.', '', ''),
('LBL', 'PRD_FCT_DECOMPTE', 'Droit d’accès quantifié', 'Droit d’accès quantifié', '', ''),
('LBL', 'PRD_FCT_FINAL', 'Facturé une fois, livré une fois le paiment reçu.', 'Facturé une fois, livré une fois le paiment reçu.', '', ''),
('LBL', 'PRD_FCT_FINANCE1', 'Livré et payé en 1 mois', '', '', ''),
('LBL', 'PRD_FCT_FINANCE12', 'Livré et payé en 12 mois', 'Livré et payé en 12 mois', '', ''),
('LBL', 'PRD_FCT_FINANCE24', 'Livré et payé en 24 mois', 'Livré et payé en 24 mois', '', ''),
('LBL', 'PRD_FCT_FINANCE3', 'Livré et payé en 3 mois', '', '', ''),
('LBL', 'PRD_FCT_FINANCE36', 'Livré et payé en 36 mois', 'Livré et payé en 36 mois', '', ''),
('LBL', 'PRD_FCT_FINANCE48', 'Livré et payé en 48 mois', 'Livré et payé en 48 mois', '', ''),
('LBL', 'PRD_FCT_FINANCE6', 'Livré et payé en 6 mois', '', '', ''),
('LBL', 'PRD_FCT_FINANCE60', 'Livré et payé en 60 mois', 'Livré et payé en 60 mois', '', ''),
('LBL', 'PRD_FCT_FINANCE72', 'Livré et payé en 72 mois', '', '', ''),
('LBL', 'PRD_FCT_HEBDO', 'Abonnement et paiements hebdomadaires', '', '', ''),
('LBL', 'PRD_FCT_LOCATION', 'Location (Produit unique avec no de série)', 'Location (Produit unique avec no de série)', '', ''),
('LBL', 'PRD_FCT_MENSUEL', 'Abonnement et paiements mensuel', 'Abonnement et paiements mensuel', '', ''),
('LBL', 'PRD_FCT_SERVICE', 'Service(chargé par heure ou par visite)', 'Service(chargé par heure ou par visite)', '', ''),
('LBL', 'PRD_LINK_BUY', 'Lien pour payer', 'Link to pay', '', ''),
('LBL', 'PRD_LINK_CONTENT', 'Lien vers le contenu', 'Link to content', '', ''),
('LBL', 'PRD_NAME', 'Nom du produit', 'Product name', '', ''),
('LBL', 'PREFIX', 'Titre', 'Title', '', ''),
('LBL', 'PRENOM', 'Pr&#233;nom', 'Firstname', '', ''),
('LBL', 'PRENOM2', 'Deuxième prénom', 'Middle name', '', ''),
('LBL', 'PRIX_ACH', 'Prix achat', 'Cost', '', ''),
('LBL', 'PRIX_SUFFIX', 'Texte après le prix FRANÇAIS', 'Text after the price FRENCH', '', ''),
('LBL', 'PRIX_SUFFIX_EN', 'Texte après le prix ANGLAIS', 'Text after the price ENGLISH', '', ''),
('LBL', 'PRIX_TEXT', 'Texte qui remplace le prix FRANÇAIS', 'Text that replace the price FRENCH', '', ''),
('LBL', 'PRIX_TEXT_EN', 'Texte qui remplace le prix ANGLAIS', 'Text that replace the price ENGLISH', '', ''),
('LBL', 'PRIX_VTE', 'Prix vente', 'Price', '', ''),
('LBL', 'PRODUCT_ID', 'No de produit', 'Product ID', '', ''),
('LBL', 'PROV', 'Province', 'Province', '', ''),
('LBL', 'PURCHASE', 'Achat', 'Purchase', '', ''),
('LBL', 'PW', 'Mot de passe', 'Password', '', ''),
('LBL', 'PWD', 'Mot de passe', 'Password', '', ''),
('LBL', 'QTE', 'Quantit&#233; command&#233;', 'Quantity Ordered', '', ''),
('LBL', 'QTX', 'Quantit&#233; exp&#233;di&#233;', 'Quantity Shipped', '', ''),
('LBL', 'QTY', 'Quantité', 'Quantity', '', ''),
('LBL', 'RECH', 'Rechercher', 'Search', '', ''),
('LBL', 'REMOD', 'Modifier celui-ci', 'Modify this one', '', ''),
('LBL', 'SAVE', 'Sauvegarder', 'Save', '', ''),
('LBL', 'SAVE_DONE', 'Sauvegarde terminée', 'Done saving', '', ''),
('LBL', 'SCAT', 'Sous-catégorie', 'Sub-category', '', ''),
('LBL', 'SEXE', 'Genre', 'Sex', '', ''),
('LBL', 'SKU', '# de produit', 'Product #', '', ''),
('LBL', 'SOURCE', 'Source', 'Source', '', ''),
('LBL', 'STAT', 'Status', 'Status', '', ''),
('LBL', 'STOT', 'Sous-Total', 'Sub total', '', ''),
('LBL', 'SUFFIX', 'Suffix', 'Suffix', '', ''),
('LBL', 'SUFIX', 'Suffixe', 'Suffix', '', ''),
('LBL', 'SUPP', 'Sup&#233;rieur imm&#233;diat', 'Immediat Superior', '', ''),
('LBL', 'SUPPLIER', 'Fournisseur', 'Supplier', '', ''),
('LBL', 'SUPPLIER_ID', 'No de fournisseur', 'Supplier ID', '', ''),
('LBL', 'TEL', 'T&#233;l&#233;phone', 'Phone #', '', ''),
('LBL', 'TEL1', 'T&#233;l&#233;phone 1', 'Phone #1', '', ''),
('LBL', 'TEL2', 'T&#233;l&#233;phone 2', 'Phone #2', '', ''),
('LBL', 'TITRE', 'Initiales', 'Title', '', ''),
('LBL', 'TOOLS', 'Bo&#238;te &#224; outils', 'Toolbox', '', ''),
('LBL', 'TOTAL', 'Total', 'Total', '', ''),
('LBL', 'TRAD', 'Traducteur', 'Traductor', '', ''),
('LBL', 'TYPE', 'Autorisations', 'Authorisations', '', ''),
('LBL', 'UNDEFINED', 'Non définit', 'Undefined', '', ''),
('LBL', 'UPDATE', 'Mise à jour', 'Update', '', ''),
('LBL', 'UPDATED', 'Mis à jour', 'Updated', '', ''),
('LBL', 'USAD', 'Utilisateur création', 'Added by User', '', ''),
('LBL', 'USER', 'Nom d&#8216;utilisateur', 'Username', '', ''),
('LBL', 'USER_ID', 'No d’utilisateur', 'User ID', '', ''),
('LBL', 'USMD', 'Utilisateur modification', 'Modified by User', '', ''),
('LBL', 'USR', 'Utilisateur', 'Utilisateur', '', ''),
('LBL', 'USXP', 'Utilisateur exp&#233;dition', 'Expedition User', '', ''),
('LBL', 'VILLE', 'Ville', 'City', '', ''),
('LBL', 'WEB_BTN_EN', 'Texte du bouton acheter ANGLAIS', 'Buy button text ENGLISH', '', ''),
('LBL', 'WEB_BTN_FR', 'Texte du bouton acheter FRANÇAIS', 'Buy button text FRENCH', '', ''),
('LBL', 'WEB_DSP', 'Disponible sur le site web', 'Available online', '', ''),
('LBL', 'WIDTH', 'Largeur en cm', 'Width (cm)', '', ''),
('LBL', 'YEAR', 'Année', 'Year', '', ''),
('LBL_CONFIG', 'HEADER', 'Configurations', 'Configurations', '', ''),
('LBL_CONFIG', 'STRUCT_RH', 'Hiérarchie des ressources humaines', 'Human ressources tree', '', ''),
('PLAN', 'ACTIONS', '', '', '', ''),
('PLAN', 'AMENAGEMENT', '', '', '', ''),
('PLAN', 'APERCU', '', '', '', ''),
('PLAN', 'AVANTAGE_CONCUR', '', '', '', ''),
('PLAN', 'BILAN_ANTERIEUR', '', '', '', ''),
('PLAN', 'BUDGET', '', '', '', ''),
('PLAN', 'CANAUX', 'Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '', '', ''),
('PLAN', 'CAPITAL', '', '', '', ''),
('PLAN', 'CAPITAL_RISQUE', '', '', '', ''),
('PLAN', 'CIBLE', '', '', '', ''),
('PLAN', 'CONCURENTS', '', '', '', ''),
('PLAN', 'CONTAB_FUTUR', '', '', '', ''),
('PLAN', 'CONTAB_PASSE', '', '', '', ''),
('PLAN', 'CONVENTION', '', '', '', ''),
('PLAN', 'EMPLOIS', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.', '', '', ''),
('PLAN', 'EMPRUNTS', '', '', '', ''),
('PLAN', 'ENTENTES', '', '', '', ''),
('PLAN', 'ESTIMATION_COUT', 'Maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '', '', ''),
('PLAN', 'ESTIMATION_PUB', '', '', '', ''),
('PLAN', 'ESTIMATION_VENTES', '', '', '', ''),
('PLAN', 'IMMOBILIER_AQUIS', '', '', '', ''),
('PLAN', 'IMMOBILIER_REQUIS', '', '', '', ''),
('PLAN', 'INVESTISSEMENT', '', '', '', ''),
('PLAN', 'NORMES', 'Aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '', '', ''),
('PLAN', 'OCCASION', '', '', '', ''),
('PLAN', 'OFFRES', '', '', '', ''),
('PLAN', 'OUTILS', '', '', '', ''),
('PLAN', 'PARTENAIRES', '', '', '', ''),
('PLAN', 'PERMIS', '25', '', '', ''),
('PLAN', 'PERMIS_AQUIS', '', '', '', ''),
('PLAN', 'PERMIS_REQUIS', '', '', '', ''),
('PLAN', 'PRET_REQUIS', 'Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '', '', ''),
('PLAN', 'PREVISIONS', '', '', '', ''),
('PLAN', 'PRODUCTION', '', '', '', ''),
('PLAN', 'PRODUITS', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '', '', ''),
('PLAN', 'QUALITE', '', '', '', ''),
('PLAN', 'RECHERCHE', 'Quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '', '', ''),
('PLAN', 'RH', 'Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '', '', ''),
('PLAN', 'SCENARIO_OPTI', '', '', '', ''),
('PLAN', 'SCENARIO_PESS', '', '', '', ''),
('PLAN', 'SCENARIO_PROB', '', '', '', ''),
('PLAN', 'SOURCE', '', '', '', ''),
('PLAN', 'STRATEGIE', 'Teos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.', '', '', ''),
('PLAN', 'SUBVENTION', '', '', '', ''),
('PLAN', 'TERRITOIRE', '', '', '', ''),
('PRODUCT_PACK', 'CHAQUE', 'ch', 'ea', '', ''),
('PRODUCT_PACK', 'GRAM', 'g', 'g', '', ''),
('PRODUCT_PACK', 'KILOGRAM', 'kg', 'kg', '', ''),
('PRODUCT_PACK', 'LIVRE', 'lb', 'pound', '', ''),
('PRODUCT_STAT', '0', 'Disponible', 'Available', '', ''),
('PRODUCT_STAT', '1', 'Inactif', 'Inactive', '', ''),
('PRODUCT_STAT', '2', 'Rappel', 'Return', '', ''),
('PRODUCT_STAT', '3', 'Bêta', 'Beta', '', ''),
('PRODUCT_STAT', '4', 'À venir bientôt', 'Available soon', '', ''),
('PRODUCT_STAT', '5', 'Discontinué', 'Discontinued', '', ''),
('PRODUCT_STAT', '6', 'En production', 'In production', '', ''),
('PROV', 'CA-AB', 'Alberta', 'Alberta', '', ''),
('PROV', 'CA-BC', 'Colombie-Britannique', 'British Columbia', '', ''),
('PROV', 'CA-MB', 'Manitoba', 'Manitoba', '', ''),
('PROV', 'CA-NB', 'Nouveau-Brunswick', 'New Brunswick', '', ''),
('PROV', 'CA-NL', 'Terre-Neuve-et-Labrador	', 'Newfoundland and Labrador', '', ''),
('PROV', 'CA-NS', 'Nova Scotia', 'Nouvelle-Écosse', '', ''),
('PROV', 'CA-NT', 'Territoires du Nord-Ouest', 'Northwest Territories', '', ''),
('PROV', 'CA-NU', 'Nunavut', 'Nunavut', '', ''),
('PROV', 'CA-ON', 'Ontario', 'Ontario', '', ''),
('PROV', 'CA-PE', 'Île-du-Prince-Édouard', 'Prince Edward Island', '', ''),
('PROV', 'CA-QC', 'Québec', 'Quebec', '', ''),
('PROV', 'CA-YT', 'Yukon', 'Yukon', '', ''),
('PROV', 'CA_SK', 'Saskatchewan', 'Saskatchewan', '', '');

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `name_fr` varchar(64) NOT NULL DEFAULT '',
  `name_en` varchar(64) NOT NULL DEFAULT '',
  `description_fr` varchar(128) NOT NULL DEFAULT '',
  `description_en` varchar(128) NOT NULL DEFAULT '',
  `date_start` datetime NOT NULL DEFAULT current_timestamp(),
  `date_end` datetime NOT NULL DEFAULT current_timestamp(),
  `pourcent_val` int(3) NOT NULL DEFAULT 0,
  `amount_val` decimal(7,2) NOT NULL DEFAULT 0.00,
  `code` varchar(30) NOT NULL DEFAULT '',
  `product_id` int(11) NOT NULL DEFAULT 0,
  `href` varchar(128) NOT NULL DEFAULT '',
  `img_link` varchar(256) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL DEFAULT 1,
  `retailer_loc_id` int(11) NOT NULL DEFAULT 0,
  `stripe_id` varchar(64) NOT NULL DEFAULT '',
  `balance` decimal(11,2) NOT NULL DEFAULT 0.00,
  `balance_before` decimal(11,2) NOT NULL DEFAULT 0.00,
  `login_attempt` int(2) NOT NULL DEFAULT 0,
  `delinquent` tinyint(1) NOT NULL DEFAULT 0,
  `tax_exempt` tinyint(1) NOT NULL DEFAULT 0,
  `shipping` varchar(16) NOT NULL DEFAULT 'PICKUP',
  `activated` tinyint(1) NOT NULL DEFAULT 0,
  `stat` int(2) NOT NULL DEFAULT 0,
  `type` varchar(32) NOT NULL DEFAULT '',
  `company` varchar(128) NOT NULL DEFAULT '',
  `web` varchar(256) NOT NULL DEFAULT '',
  `user_name` varchar(64) NOT NULL,
  `first_name` varchar(128) NOT NULL DEFAULT '',
  `middle_name` varchar(128) NOT NULL DEFAULT '',
  `last_name` varchar(128) NOT NULL DEFAULT '',
  `prefix` varchar(32) NOT NULL DEFAULT '',
  `suffix` varchar(16) NOT NULL DEFAULT '',
  `adr1` varchar(256) NOT NULL DEFAULT '',
  `adr2` varchar(226) NOT NULL DEFAULT '',
  `city` varchar(64) NOT NULL DEFAULT '',
  `province` varchar(64) NOT NULL DEFAULT 'Quebec',
  `country` varchar(64) NOT NULL DEFAULT 'Canada',
  `postal_code` varchar(16) NOT NULL DEFAULT '',
  `adr1_sh` varchar(128) NOT NULL DEFAULT '',
  `adr2_sh` varchar(128) NOT NULL DEFAULT '',
  `city_sh` varchar(128) NOT NULL DEFAULT '',
  `province_sh` varchar(64) NOT NULL DEFAULT '',
  `country_sh` varchar(64) NOT NULL DEFAULT '',
  `postal_code_sh` varchar(20) NOT NULL DEFAULT '',
  `tel1` varchar(40) NOT NULL DEFAULT '',
  `tel2` varchar(40) NOT NULL DEFAULT '',
  `eml1` varchar(256) NOT NULL,
  `pw` varchar(128) NOT NULL,
  `eml2` varchar(256) NOT NULL,
  `longitude` varchar(32) NOT NULL DEFAULT '',
  `latitude` varchar(32) NOT NULL DEFAULT '',
  `sms_stat` tinyint(1) NOT NULL DEFAULT 0,
  `news_stat` tinyint(1) NOT NULL DEFAULT 0,
  `key_128` varchar(128) NOT NULL DEFAULT '',
  `key_expire` timestamp NOT NULL DEFAULT current_timestamp(),
  `key_reset` varchar(128) NOT NULL DEFAULT '',
  `two_factor_req` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_valid` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_code` varchar(6) NOT NULL,
  `two_factor_expire` datetime NOT NULL DEFAULT current_timestamp(),
  `note` text NOT NULL DEFAULT '',
  `lang` varchar(2) NOT NULL DEFAULT 'fr',
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `user_modified` int(11) NOT NULL DEFAULT 0,
  `last_login` date NOT NULL,
  `crypted` tinyint(1) NOT NULL DEFAULT 0,
  `freq_visit_day` int(4) NOT NULL DEFAULT 0,
  `freq_visit_hour` int(4) NOT NULL DEFAULT 4,
  `last_visit_day` varchar(10) NOT NULL DEFAULT '2023-11-01',
  `last_visit_hour` varchar(8) NOT NULL DEFAULT '23:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `customer_app` (
  `id` int(11) NOT NULL,
  `name_fr` varchar(64) NOT NULL DEFAULT '',
  `name_en` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `auth` varchar(32) NOT NULL DEFAULT '',
  `filename` varchar(1024) NOT NULL DEFAULT '',
  `sort_number` int(4) NOT NULL DEFAULT 0,
  `icon` varchar(128) NOT NULL DEFAULT '',
  `color` varchar(16) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `customer_app` (`id`, `name_fr`, `name_en`, `description`, `auth`, `filename`, `sort_number`, `icon`, `color`) VALUES
(1, 'Tableau de bord', 'Dashboard', 'Dashboard', 'CLI', 'dashboard', 1, 'settings', '#555555'),
(2, 'Boite a outils', 'Web Tools', 'Swiss knife web app', 'CLI', 'toolbox', 55, 'home_repair_service', '#555555');

CREATE TABLE `customer_discount` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `escount_pourcent` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `diffusion_head` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `message` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `diffusion_line` (
  `head_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `event_type` varchar(20) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `status` varchar(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(64) NOT NULL DEFAULT '',
  `name_en` varchar(128) NOT NULL DEFAULT '',
  `date_start` timestamp NOT NULL DEFAULT current_timestamp(),
  `duration` int(9) NOT NULL DEFAULT 0,
  `description` varchar(512) NOT NULL DEFAULT '',
  `description_en` varchar(512) NOT NULL DEFAULT '',
  `href` varchar(256) NOT NULL DEFAULT '',
  `img_src` varchar(256) NOT NULL DEFAULT '',
  `periodic` tinyint(1) NOT NULL DEFAULT 0,
  `period_type` varchar(20) NOT NULL DEFAULT '',
  `period_duration` int(9) NOT NULL DEFAULT 0,
  `period_sequence` int(9) NOT NULL,
  `end_date` datetime NOT NULL DEFAULT current_timestamp(),
  `closed` tinyint(1) NOT NULL DEFAULT 0,
  `closed_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `group_name` varchar(30) NOT NULL,
  `kind` varchar(10) NOT NULL,
  `gl_code` varchar(5) NOT NULL,
  `amount` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `sort_index` int(3) NOT NULL DEFAULT 0,
  `q_fr` varchar(256) NOT NULL DEFAULT '',
  `q_en` varchar(256) NOT NULL DEFAULT '',
  `r_fr` varchar(1024) NOT NULL DEFAULT 'Réponse en français',
  `r_en` varchar(1024) NOT NULL DEFAULT 'English answer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `gl` (
  `code` int(11) NOT NULL,
  `kind` varchar(32) NOT NULL DEFAULT '',
  `name_fr` varchar(128) NOT NULL DEFAULT '',
  `name_en` varchar(128) NOT NULL DEFAULT '',
  `desc_fr` varchar(512) NOT NULL DEFAULT '',
  `desc_en` varchar(512) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `gl` (`code`, `kind`, `name_fr`, `name_en`, `desc_fr`, `desc_en`) VALUES
(1000, 'Actif à court terme', 'Actifs à court terme', 'Actifs à court terme', '', ''),
(1020, 'Actif à court terme', 'Trans. au comptant a déposer', 'Trans. au comptant a déposer', '', ''),
(1030, 'Actif à court terme', 'Retraits d’encaisse', 'Retraits d’encaisse', '', ''),
(1050, 'Actif à court terme', 'Petite caisse', 'Petite caisse', '', ''),
(1055, 'Actif à court terme', 'Compte d’épargne', 'Compte d’épargne', '', ''),
(1060, 'Actif à court terme', 'Compte courant', 'Compte courant', '', ''),
(1067, 'Actif à court terme', 'Compte bancaire en devise', 'Compte bancaire en devise', '', ''),
(1075, 'Actif à court terme', 'Total de l’encaisse', 'Total de l’encaisse', '', ''),
(1080, 'Actif à court terme', 'Visa à recevoir', 'Visa à recevoir', '', ''),
(1083, 'Actif à court terme', 'MasterCard à recevoir', 'MasterCard à recevoir', '', ''),
(1087, 'Actif à court terme', 'American Express à recevoir', 'American Express à recevoir', '', ''),
(1089, 'Actif à court terme', 'Autres cartes de credit à recevoir', 'Autres cartes de credit à recevoir', '', ''),
(1090, 'Actif à court terme', 'Total cartes de credit à recevoir', 'Total cartes de credit à recevoir', '', ''),
(1100, 'Actif à court terme', 'Investissements', 'Investissements', '', ''),
(1200, 'Actif à court terme', 'Comptes clients', 'Comptes clients', '', ''),
(1205, 'Actif à court terme', 'Provision pour créances douteuses', 'Provision pour créances douteuses', '', ''),
(1220, 'Actif à court terme', 'Avances & Frêts', 'Avances & Frêts', '', ''),
(1230, 'Actif à court terme', 'Total à recevoir', 'Total à recevoir', '', ''),
(1300, 'Actif à court terme', 'Achats prépayés', 'Achats prépayés', '', ''),
(1320, 'Actif à court terme', 'Charges prépayées', 'Charges prépayées', '', ''),
(1400, 'Actif à court terme', 'Total actifs à court terme', 'Total actifs à court terme', '', ''),
(1500, 'Actif à court terme', 'Actifs de stock', 'Actifs de stock', '', ''),
(1520, 'Actif à court terme', 'Stock A', 'Stock A', '', ''),
(1530, 'Actif à court terme', 'Stock B', 'Stock B', '', ''),
(1540, 'Actif à court terme', 'Stock C', 'Stock C', '', ''),
(1590, 'Actif à court terme', 'Total actifs de stock', 'Total actifs de stock', '', ''),
(1700, 'Actif à court terme', 'Immobilisations', 'Immobilisations', '', ''),
(1810, 'Actif à court terme', 'Améliorations locatives', 'Améliorations locatives', '', ''),
(1820, 'Actif à court terme', 'Mobilier de bureau & materiel', 'Mobilier de bureau & materiel', '', ''),
(1825, 'Actif à court terme', 'Amort. cum. — Matér./mobil./inst.', 'Amort. cum. — Matér./mobil./inst.', '', ''),
(1830, 'Actif à court terme', 'Net - Matériel/mobilier/install.', 'Net - Matériel/mobilier/install.', '', ''),
(1840, 'Actif à court terme', 'Véhicule', 'Véhicule', '', ''),
(1845, 'Actif à court terme', 'Amortissement cumulé - Véhicule', 'Amortissement cumulé - Véhicule', '', ''),
(1850, 'Actif à court terme', 'Net - Véhicule', 'Net - Véhicule', '', ''),
(1860, 'Actif à court terme', 'Batiment', 'Batiment', '', ''),
(1865, 'Actif à court terme', 'Amortissement cumule — Batiment', 'Amortissement cumule — Batiment', '', ''),
(1870, 'Actif à court terme', 'Net - Batiment', 'Net - Batiment', '', ''),
(1880, 'Actif à court terme', 'Terrain', 'Terrain', '', ''),
(1890, 'Actif à court terme', 'Total des immobilisations', 'Total des immobilisations', '', ''),
(1900, 'Actif à court terme', 'Autres éléments d’actif', 'Autres éléments d’actif', '', ''),
(1910, 'Actif à court terme', 'Logiciel ordinateur', 'Logiciel ordinateur', '', ''),
(1920, 'Actif à court terme', 'Achalandage', 'Achalandage', '', ''),
(1930, 'Actif à court terme', 'Frais de constitution', 'Frais de constitution', '', ''),
(1950, 'Actif à court terme', 'Total des autres elements d’actif', 'Total des autres elements d’actif', '', ''),
(2000, 'Passif a court terme', 'Passif a court terme', 'Passif a court terme', '', ''),
(2100, 'Passif a court terme', 'Comptes fournisseurs', 'Comptes fournisseurs', '', ''),
(2115, 'Passif a court terme', 'Droit d’importation provisoire', 'Droit d’importation provisoire', '', ''),
(2120, 'Passif a court terme', 'Emprunt bancaire — portion courante', 'Emprunt bancaire — portion courante', '', ''),
(2130, 'Passif a court terme', 'Facilités de caisse', 'Facilités de caisse', '', ''),
(2133, 'Passif a court terme', 'Visa à payer', 'Visa à payer', '', ''),
(2134, 'Passif a court terme', 'MasterCard à payer', 'MasterCard à payer', '', ''),
(2135, 'Passif a court terme', 'American Express à payer', 'American Express à payer', '', ''),
(2140, 'Passif a court terme', 'Autres cartes de credit à payer', 'Autres cartes de credit à payer', '', ''),
(2145, 'Passif a court terme', 'Total cartes de credit à payer', 'Total cartes de credit à payer', '', ''),
(2160, 'Passif a court terme', 'Impots sur les sociétés à payer', 'Impots sur les sociétés à payer', '', ''),
(2170, 'Passif a court terme', 'Vacances à payer', 'Vacances à payer', '', ''),
(2180, 'Passif a court terme', 'Assurance-emploi à payer', 'Assurance-emploi à payer', '', ''),
(2185, 'Passif a court terme', 'RPC à payer', 'RPC à payer', '', ''),
(2190, 'Passif a court terme', 'Impôt fédéral à payer', 'Impôt fédéral à payer', '', ''),
(2195, 'Passif a court terme', 'Total receveur general', 'Total receveur general', '', ''),
(2200, 'Passif a court terme', 'RRQ à payer', 'RRQ à payer', '', ''),
(2205, 'Passif a court terme', 'Quebec à payer', 'Quebec à payer', '', ''),
(2210, 'Passif a court terme', 'FSSQ à payer', 'FSSQ à payer', '', ''),
(2212, 'Passif a court terme', 'RQAP à payer', 'RQAP à payer', '', ''),
(2215, 'Passif a court terme', 'Total — Ministre des Finances Qué.', 'Total — Ministre des Finances Qué.', '', ''),
(2230, 'Passif a court terme', 'CSST à payer', 'CSST à payer', '', ''),
(2234, 'Passif a court terme', 'Chg 1 à payer definie par usager', 'Chg 1 à payer definie par usager', '', ''),
(2235, 'Passif a court terme', 'Chg 2 à payer définie par usager', 'Chg 2 à payer définie par usager', '', ''),
(2236, 'Passif a court terme', 'Chg 3 à payer definie par usager', 'Chg 3 à payer definie par usager', '', ''),
(2237, 'Passif a court terme', 'Chg.4 à payer définie par usager', 'Chg.4 à payer définie par usager', '', ''),
(2238, 'Passif a court terme', 'Chg 5 à payer définie par usager', 'Chg 5 à payer définie par usager', '', ''),
(2240, 'Passif a court terme', 'Retenue A à payer', 'Retenue A à payer', '', ''),
(2250, 'Passif a court terme', 'Retenue B à payer', 'Retenue B à payer', '', ''),
(2260, 'Passif a court terme', 'Retenue C à payer', 'Retenue C à payer', '', ''),
(2270, 'Passif a court terme', 'Retenue D à payer', 'Retenue D à payer', '', ''),
(2280, 'Passif a court terme', 'Retenue E à payer', 'Retenue E à payer', '', ''),
(2310, 'Passif a court terme', 'TPS percue sur les ventes', 'TPS percue sur les ventes', '', ''),
(2312, 'Passif a court terme', 'TPS percue sur les ventes - taux 2', 'TPS percue sur les ventes - taux 2', '', ''),
(2315, 'Passif a court terme', 'TPS payée sur les achats', 'TPS payée sur les achats', '', ''),
(2320, 'Passif a court terme', 'Retenues de TPS sur avantages', 'Retenues de TPS sur avantages', '', ''),
(2325, 'Passif a court terme', 'Regularisations de TPS', 'Regularisations de TPS', '', ''),
(2330, 'Passif a court terme', 'Régularisations de CIR', 'Régularisations de CIR', '', ''),
(2335, 'Passif a court terme', 'TPS à remettre (Remboursement)', 'TPS à remettre (Remboursement)', '', ''),
(2340, 'Passif a court terme', 'TVQ percue sur les ventes', 'TVQ percue sur les ventes', '', ''),
(2342, 'Passif a court terme', 'TVQ percue sur les ventes — taux 2', 'TVQ percue sur les ventes — taux 2', '', ''),
(2345, 'Passif a court terme', 'TVQ payée sur les achats', 'TVQ payée sur les achats', '', ''),
(2350, 'Passif a court terme', 'Retenues de TVQ sur avantages', 'Retenues de TVQ sur avantages', '', ''),
(2355, 'Passif a court terme', 'Régularisations de TVQ', 'Régularisations de TVQ', '', ''),
(2360, 'Passif a court terme', 'TVQ à remettre (Remboursement)', 'TVQ à remettre (Remboursement)', '', ''),
(2460, 'Passif a court terme', 'Ventes prépayées/Acomptes', 'Ventes prépayées/Acomptes', '', ''),
(2500, 'Passif a court terme', 'Total du passif a court terme', 'Total du passif a court terme', '', ''),
(2600, 'Passif a long terme', 'Passif a long terme', 'Passif a long terme', '', ''),
(2620, 'Passif a long terme', 'Emprunts bancaires', 'Emprunts bancaires', '', ''),
(2630, 'Passif a long terme', 'Hypotheque à payer', 'Hypotheque à payer', '', ''),
(2640, 'Passif a long terme', 'Préts des propriétaires', 'Préts des propriétaires', '', ''),
(2700, 'Passif a long terme', 'Total du passif a long terme', 'Total du passif a long terme', '', ''),
(3000, 'Avoir des propriétaires', 'Avoir des propriétaires', 'Avoir des propriétaires', '', ''),
(3010, 'Avoir des propriétaires', 'Apport des propriétaires', 'Apport des propriétaires', '', ''),
(3015, 'Avoir des propriétaires', 'Retraits — Propriétaires', 'Retraits — Propriétaires', '', ''),
(3560, 'Avoir des propriétaires', 'Bénéfices non répartis- exer. préc.', 'Bénéfices non répartis- exer. préc.', '', ''),
(3600, 'Avoir des propriétaires', 'Bénéfices courants', 'Bénéfices courants', '', ''),
(3700, 'Avoir des propriétaires', 'Total — Avoir des propriétaires', 'Total — Avoir des propriétaires', '', ''),
(4000, 'Ventes', 'Produit des ventes', 'Produit des ventes', '', ''),
(4020, 'Ventes', 'Produit des ventes de stock A', 'Produit des ventes de stock A', '', ''),
(4030, 'Ventes', 'Produit des ventes de stock B', 'Produit des ventes de stock B', '', ''),
(4040, 'Ventes', 'Produit des ventes de stock C', 'Produit des ventes de stock C', '', ''),
(4200, 'Ventes', 'Ventes', 'Ventes', '', ''),
(4220, 'Ventes', 'Retours sur ventes', 'Retours sur ventes', '', ''),
(4240, 'Ventes', 'Pmt anticipé et remise sur ventes', 'Pmt anticipé et remise sur ventes', '', ''),
(4260, 'Ventes', 'Ventes nettes', 'Ventes nettes', '', ''),
(4400, 'Ventes', 'Autre produit', 'Autre produit', '', ''),
(4420, 'Ventes', 'Produit de transport', 'Produit de transport', '', ''),
(4440, 'Ventes', 'Revenu d’intéréts', 'Revenu d’intéréts', '', ''),
(4460, 'Ventes', 'Produit divers.', 'Produit divers.', '', ''),
(4500, 'Ventes', 'Total - Autre produit', 'Total - Autre produit', '', ''),
(5000, 'Fraits', 'Coat des marchandises vendues', 'Coat des marchandises vendues', '', ''),
(5020, 'Fraits', 'Cont du Stock A', 'Cont du Stock A', '', ''),
(5030, 'Fraits', 'Coot du Stock B', 'Coot du Stock B', '', ''),
(5040, 'Fraits', 'Coat du Stock C', 'Coat du Stock C', '', ''),
(5100, 'Fraits', 'Ecart des prix de stock', 'Ecart des prix de stock', '', ''),
(5120, 'Fraits', 'Coats de l’assemblage des articles', 'Coats de l’assemblage des articles', '', ''),
(5130, 'Fraits', 'Radiation d’ajustement', 'Radiation d’ajustement', '', ''),
(5140, 'Fraits', 'Couts de transfert', 'Couts de transfert', '', ''),
(5190, 'Fraits', 'Sous—contrats', 'Sous—contrats', '', ''),
(5200, 'Fraits', 'Achats', 'Achats', '', ''),
(5220, 'Fraits', 'Retours sur achats', 'Retours sur achats', '', ''),
(5240, 'Fraits', 'Pmt anticipé et remise sur achats', 'Pmt anticipé et remise sur achats', '', ''),
(5290, 'Fraits', 'Achats nets', 'Achats nets', '', ''),
(5300, 'Fraits', 'Frais de transport', 'Frais de transport', '', ''),
(5350, 'Fraits', 'Coot total des marchandises vendues', 'Coot total des marchandises vendues', '', ''),
(5400, 'Fraits', 'Charges salariales', 'Charges salariales', '', ''),
(5410, 'Fraits', 'Salaires & traitements', 'Salaires & traitements', '', ''),
(5420, 'Fraits', 'Charge de A-E', 'Charge de A-E', '', ''),
(5425, 'Fraits', 'Charge du RQAP', 'Charge du RQAP', '', ''),
(5430, 'Fraits', 'Charge du RRC', 'Charge du RRC', '', ''),
(5440, 'Fraits', 'Charge de CSST', 'Charge de CSST', '', ''),
(5450, 'Fraits', 'Charge du RRQ', 'Charge du RRQ', '', ''),
(5455, 'Fraits', 'Charge du FSSQ', 'Charge du FSSQ', '', ''),
(5464, 'Fraits', 'Chg 1 a débiter déf. par usager', 'Chg 1 a débiter déf. par usager', '', ''),
(5465, 'Fraits', 'Chg 2 a debiter déf. par usager', 'Chg 2 a debiter déf. par usager', '', ''),
(5466, 'Fraits', 'Chg 3 a debiter déf.par usager', 'Chg 3 a debiter déf.par usager', '', ''),
(5467, 'Fraits', 'Chg 4 a débiter def. par usager', 'Chg 4 a débiter def. par usager', '', ''),
(5468, 'Fraits', 'Chg 5 a débiter def. par usager', 'Chg 5 a débiter def. par usager', '', ''),
(5470, 'Fraits', 'Avantages sociaux', 'Avantages sociaux', '', ''),
(5490, 'Fraits', 'Total des charges salariales', 'Total des charges salariales', '', ''),
(5600, 'Fraits', 'Frais généraux d’administration', 'Frais généraux d’administration', '', ''),
(5610, 'Fraits', 'Frais comptables & judiciaires', 'Frais comptables & judiciaires', '', ''),
(5615, 'Fraits', 'Publicite & promotions', 'Publicite & promotions', '', ''),
(5620, 'Fraits', 'Créances irrécouvrables', 'Créances irrécouvrables', '', ''),
(5625, 'Fraits', 'Frais et licences d’affaires', 'Frais et licences d’affaires', '', ''),
(5630, 'Fraits', 'Ecart de caisse', 'Ecart de caisse', '', ''),
(5640, 'Fraits', 'Courrier & frais postaux', 'Courrier & frais postaux', '', ''),
(5645, 'Fraits', 'Frais de carte de crédit', 'Frais de carte de crédit', '', ''),
(5650, 'Fraits', 'Echange et arrondissement de devise', 'Echange et arrondissement de devise', '', ''),
(5660, 'Fraits', 'Amortissement de l’exercice', 'Amortissement de l’exercice', '', ''),
(5680, 'Fraits', 'Impots sur le revenu', 'Impots sur le revenu', '', ''),
(5685, 'Fraits', 'Assurance', 'Assurance', '', ''),
(5690, 'Fraits', 'Intérét & frais bancaires', 'Intérét & frais bancaires', '', ''),
(5700, 'Fraits', 'Fournitures de bureau', 'Fournitures de bureau', '', ''),
(5720, 'Fraits', 'Impots fonciers', 'Impots fonciers', '', ''),
(5730, 'Fraits', 'Charges de véhicule a moteur', 'Charges de véhicule a moteur', '', ''),
(5740, 'Fraits', 'Divers', 'Divers', '', ''),
(5750, 'Fraits', 'Gains/Pertes de change realises', 'Gains/Pertes de change realises', '', ''),
(5760, 'Fraits', 'Loyer', 'Loyer', '', ''),
(5765, 'Fraits', 'Reparations & entretien', 'Reparations & entretien', '', ''),
(5780, 'Fraits', 'Telephone', 'Telephone', '', ''),
(5784, 'Fraits', 'Voyages & loisirs', 'Voyages & loisirs', '', ''),
(5789, 'Fraits', 'Voyages & loisirs:Non—remboursable', 'Voyages & loisirs:Non—remboursable', '', ''),
(5790, 'Fraits', 'Services publics', 'Services publics', '', ''),
(5890, 'Fraits', 'Commissions de Visa', 'Commissions de Visa', '', ''),
(5892, 'Fraits', 'Commissions de MasterCard', 'Commissions de MasterCard', '', ''),
(5894, 'Fraits', 'Commissions d’American Express', 'Commissions d’American Express', '', ''),
(5896, 'Fraits', 'Commissions d’autres c. de credit', 'Commissions d’autres c. de credit', '', ''),
(5899, 'Fraits', 'Total des commissions- c. de crédit', 'Total des commissions- c. de crédit', '', ''),
(5999, 'Fraits', 'Total — Frais généraux d’admin.', 'Total — Frais généraux d’admin.', '', '');

CREATE TABLE `gls` (
  `id` int(11) NOT NULL,
  `kind` varchar(8) NOT NULL,
  `gl_code` int(11) NOT NULL DEFAULT 0,
  `source` varchar(256) NOT NULL DEFAULT '',
  `source_id` int(11) NOT NULL,
  `year` int(5) NOT NULL DEFAULT 0,
  `period` int(2) NOT NULL DEFAULT 0,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `amount` float NOT NULL DEFAULT 0,
  `document` varchar(512) NOT NULL DEFAULT '',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `historic` (
  `id` int(11) NOT NULL,
  `sort_number` int(3) NOT NULL DEFAULT 0,
  `name_fr` varchar(128) NOT NULL DEFAULT 'Mois / Année',
  `name_en` varchar(128) NOT NULL DEFAULT 'Month / Year',
  `description_fr` varchar(512) NOT NULL DEFAULT 'Description Française',
  `description_en` varchar(512) NOT NULL DEFAULT 'English Description',
  `href` varchar(256) NOT NULL DEFAULT 'Lien / Link',
  `img_link` varchar(256) NOT NULL DEFAULT 'Lien / Link Image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `historic` (`id`, `sort_number`, `name_fr`, `name_en`, `description_fr`, `description_en`, `href`, `img_link`) VALUES
(1, 0, 'Jan 2010', 'Jan 2010', 'Ouverture de l’entreprise', 'Business Opening', 'Lien / Link', 'Lien / Link Image'),
(2, 0, 'Juin 2012', 'June 2012', 'Description Française', 'English Description', 'Lien / Link', 'Lien / Link Image'),
(3, 0, 'Oct 2020', 'Oct 2020', 'Description Française', 'English Description', 'Lien / Link', 'Lien / Link Image'),
(4, 0, 'Mai 2023', 'Mai 2023', 'Description Française', 'English Description', 'Lien / Link', 'Lien / Link Image'),
(5, 0, 'Juil 2024', 'Juil 24', 'Nouveau site web!', 'New web site!', 'https://dw3.ca', 'Lien / Link Image'),
(6, 0, 'Mois / Année', 'Month / Year', 'Description Française', 'English Description', 'Lien / Link', 'Lien / Link Image'),
(7, 0, 'Mois / Année', 'Month / Year', 'Description Française', 'English Description', 'Lien / Link', 'Lien / Link Image'),
(8, 0, 'Mois / Année', 'Month / Year', 'Description Française', 'English Description', 'Lien / Link', 'Lien / Link Image');

CREATE TABLE `index_head` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `header_path` varchar(30) NOT NULL DEFAULT '',
  `title` varchar(128) NOT NULL DEFAULT '',
  `title_en` varchar(128) NOT NULL DEFAULT '',
  `font_family` varchar(32) NOT NULL DEFAULT '',
  `scene` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(256) NOT NULL DEFAULT 'https://',
  `target` varchar(30) NOT NULL DEFAULT 'page',
  `is_in_menu` varchar(5) NOT NULL DEFAULT 'false',
  `icon` varchar(256) NOT NULL,
  `menu_order` int(3) NOT NULL DEFAULT 1,
  `cat_list` varchar(1024) NOT NULL,
  `img_url` varchar(256) NOT NULL DEFAULT '',
  `img_display` varchar(20) NOT NULL DEFAULT 'none',
  `img_anim` varchar(20) NOT NULL DEFAULT '',
  `img_anim_time` int(2) NOT NULL DEFAULT 15,
  `title_display` varchar(20) NOT NULL DEFAULT 'none',
  `icon_display` varchar(20) NOT NULL DEFAULT 'none',
  `icon_color` varchar(20) NOT NULL DEFAULT '#333',
  `icon_textShadow` varchar(30) NOT NULL DEFAULT '2px 2px 4px gold',
  `opacity` varchar(4) NOT NULL DEFAULT '1',
  `background` varchar(40) NOT NULL DEFAULT 'transparent',
  `foreground` varchar(40) NOT NULL DEFAULT '',
  `max_width` varchar(20) NOT NULL DEFAULT '100%',
  `border_radius` varchar(20) NOT NULL DEFAULT '0px',
  `margin` varchar(20) NOT NULL DEFAULT '0px 0px',
  `boxShadow` varchar(40) NOT NULL DEFAULT 'none',
  `html_fr` text NOT NULL DEFAULT '',
  `html_en` text NOT NULL DEFAULT '',
  `total_visited` int(11) NOT NULL DEFAULT 0,
  `meta_description` varchar(256) NOT NULL,
  `meta_keywords` varchar(256) NOT NULL,
  `anim_class` varchar(20) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `index_head` (`id`, `parent_id`, `header_path`, `title`, `title_en`, `font_family`, `scene`, `url`, `target`, `is_in_menu`, `icon`, `menu_order`, `cat_list`, `img_url`, `img_display`, `img_anim`, `img_anim_time`, `title_display`, `icon_display`, `icon_color`, `icon_textShadow`, `opacity`, `background`, `foreground`, `max_width`, `border_radius`, `margin`, `boxShadow`, `html_fr`, `html_en`, `total_visited`, `meta_description`, `meta_keywords`, `anim_class`) VALUES
(141, 0, '/pub/section/header22.php', 'Accueil', '', 'Tajawal', '', '/', 'page', 'true', '!', 1, '', '', 'none', '', 15, 'none', 'none', '#eee', '2px 2px 4px #444', '1', 'transparent', '', '100%', '0px', '0px 0px', 'none', '', '', 0, '', '', 'none'),
(142, 0, '', 'Intro', '', 'Boldonse', '', '/pub/section/perso1/index.php', 'section', 'false', 'ċ', 101, '', 'IMG_1090.JPG', 'background', 'dw3_pan_infinite', 15, 'none', 'none', '#333', '2px 2px 4px gold', '1', 'rgba(0,0,0,0.5)', 'white', '97%', '0px', '70px 0px 80vh 0px', 'none', '<div style=\'padding:40px;font-size:4vw;line-height:9vw;\'>Félicitation vous avez installé la plateforme DW3 BETA 5 avec succès!!</div>', '', 0, '', '', 'none'),
(143, 0, '', 'Affiliés', '', 'Tajawal', '', '/pub/section/affiliate/index.php', 'section', 'false', 'ċ', 102, '', '', 'none', '', 15, 'none', 'none', '#333', '2px 2px 4px gold', '1', 'transparent', '', '100%', '0px', '0px 0px', 'none', '', '', 0, '', '', 'none'),
(144, 0, '/pub/section/header9.php', 'Espace Client', '', 'Verdana', '', '/client', 'page', 'true', '=', 9, '', '', 'none', '', 15, 'none', 'none', '#eee', '2px 2px 4px blue', '1', 'transparent', '', '100%', '0px', '0px 0px', 'none', '', '', 0, '', '', 'none'),
(145, 0, '/pub/section/header0.php', 'Contactez-nous', '', 'Verdana', '', '/pub/page/contact3/index.php', 'page', 'true', 'N', 8, '', 'IMG_1097.JPG', 'none', '', 15, 'none', 'none', '#333', '2px 2px 4px white', '1', 'transparent', '', '100%', '0px', '0px 0px', 'none', '', '', 20, '', '', 'none'),
(146, 0, '/pub/section/header0.php', 'Rendez-vous', '', 'Verdana', '', '/pub/page/agenda/index.php', 'page', 'true', 'Ë', 3, '', '', 'none', '', 15, 'none', 'none', '#eee', '2px 2px 4px #5f5', '1', 'transparent', '', '100%', '0px', '0px 0px', 'none', '', '', 26, '', '', 'none'),
(147, 0, '/pub/section/header0.php', 'Carrières', '', 'Verdana', '', '/pub/page/jobs/index.php', 'page', 'true', 'ƅ', 5, '', '', 'none', '', 15, 'none', 'none', 'gold', '2px 2px 4px #333', '1', 'transparent', '', '100%', '0px', '0px 0px', 'none', '', '', 38, '', '', 'none');

CREATE TABLE `index_line` (
  `head_id` int(11) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL,
  `sort_order` int(4) NOT NULL DEFAULT 1,
  `title_fr` varchar(64) NOT NULL,
  `title_en` varchar(64) NOT NULL DEFAULT '',
  `html_fr` text NOT NULL DEFAULT '',
  `html_en` text NOT NULL DEFAULT '',
  `url` varchar(256) NOT NULL DEFAULT 'https://',
  `target` varchar(30) NOT NULL DEFAULT 'section'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `inventory` (
  `id` int(13) NOT NULL,
  `kind` varchar(32) NOT NULL DEFAULT '',
  `name_fr` varchar(64) NOT NULL DEFAULT '',
  `desc_fr` varchar(512) NOT NULL DEFAULT '',
  `serial_number` varchar(128) NOT NULL DEFAULT '',
  `storage_id` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL,
  `user_created` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL DEFAULT current_timestamp(),
  `purchase_user` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `invoice_head` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `line_source` varchar(10) NOT NULL DEFAULT 'product' COMMENT 'product, classified',
  `location_id` int(11) NOT NULL DEFAULT 0,
  `retailer_loc_id` int(11) NOT NULL DEFAULT 0,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `shipment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `stripe_invoice` varchar(64) NOT NULL,
  `stat` int(2) NOT NULL DEFAULT 0,
  `subscription_stat` varchar(10) NOT NULL,
  `adr1` varchar(128) NOT NULL DEFAULT '',
  `adr2` varchar(64) NOT NULL DEFAULT '',
  `city` varchar(64) NOT NULL DEFAULT '',
  `prov` varchar(64) NOT NULL DEFAULT '',
  `country` varchar(64) NOT NULL DEFAULT '',
  `postal_code` varchar(10) NOT NULL DEFAULT '',
  `adr1_sh` varchar(128) NOT NULL DEFAULT '',
  `adr2_sh` varchar(128) NOT NULL DEFAULT '',
  `city_sh` varchar(64) NOT NULL DEFAULT '',
  `province_sh` varchar(64) NOT NULL DEFAULT '',
  `country_sh` varchar(64) NOT NULL DEFAULT '',
  `postal_code_sh` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `company` varchar(128) NOT NULL,
  `transport` decimal(9,2) NOT NULL DEFAULT 0.00,
  `ship_code` varchar(10) NOT NULL,
  `ship_type` varchar(20) NOT NULL,
  `stotal` decimal(11,2) NOT NULL DEFAULT 0.00,
  `tps` decimal(9,2) NOT NULL DEFAULT 0.00,
  `tvp` decimal(9,2) NOT NULL DEFAULT 0.00,
  `tvh` decimal(9,2) NOT NULL DEFAULT 0.00,
  `total` decimal(11,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(11,2) NOT NULL DEFAULT 0.00,
  `transaction_cost` decimal(7,2) NOT NULL,
  `prepaid` decimal(11,2) NOT NULL DEFAULT 0.00,
  `paid_cash` decimal(11,2) NOT NULL DEFAULT 0.00,
  `paid_stripe` decimal(11,2) NOT NULL DEFAULT 0.00,
  `paid_moneris` decimal(11,2) NOT NULL DEFAULT 0.00,
  `paid_paypal` decimal(11,2) DEFAULT 0.00,
  `paid_check` decimal(11,2) NOT NULL DEFAULT 0.00,
  `paid_balance` decimal(11,2) NOT NULL DEFAULT 0.00,
  `note` varchar(512) NOT NULL DEFAULT '',
  `date_due` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `user_modified` int(11) NOT NULL DEFAULT 0,
  `date_renew` datetime NOT NULL,
  `eml` varchar(64) NOT NULL DEFAULT '',
  `tel` varchar(40) NOT NULL DEFAULT '',
  `stripe_checkout_session_id` varchar(100) NOT NULL,
  `date_email` datetime DEFAULT NULL,
  `user_email` int(11) DEFAULT NULL,
  `user_cancel` int(11) NOT NULL,
  `refunded` decimal(11,2) NOT NULL,
  `cancel_reason` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `invoice_line` (
  `head_id` int(11) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL,
  `line` int(5) NOT NULL DEFAULT 0,
  `classified_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `product_desc` varchar(256) NOT NULL DEFAULT '',
  `product_opt` varchar(60) NOT NULL DEFAULT '',
  `qty_order` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `qty_shipped` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `price` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `tvh` decimal(11,2) NOT NULL DEFAULT 0.00,
  `tps` decimal(11,2) NOT NULL DEFAULT 0.00,
  `tvp` decimal(9,2) NOT NULL DEFAULT 0.00,
  `note` varchar(256) NOT NULL DEFAULT '',
  `date_due` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_modified` int(11) NOT NULL DEFAULT 0,
  `date_shipped` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_shipped` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `location` (
  `name` varchar(64) NOT NULL,
  `id` int(11) NOT NULL,
  `square_id` varchar(20) NOT NULL DEFAULT '',
  `adr1` varchar(128) NOT NULL DEFAULT '',
  `adr2` varchar(64) NOT NULL DEFAULT '',
  `city` varchar(64) NOT NULL DEFAULT '',
  `postal_code` varchar(10) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `value` int(11) NOT NULL DEFAULT 0,
  `date_opening` date NOT NULL DEFAULT current_timestamp(),
  `province` varchar(20) NOT NULL DEFAULT '',
  `country` varchar(20) NOT NULL DEFAULT '',
  `stat` varchar(30) NOT NULL DEFAULT '0',
  `allow_pickup` int(1) NOT NULL DEFAULT 0,
  `tel1` varchar(20) NOT NULL DEFAULT '',
  `description` varchar(256) NOT NULL DEFAULT '',
  `note` varchar(512) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `eml1` varchar(64) NOT NULL DEFAULT '',
  `web` varchar(256) NOT NULL DEFAULT '',
  `latitude` varchar(20) NOT NULL DEFAULT '',
  `longitude` varchar(20) NOT NULL DEFAULT '',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `user_modified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `location` (`name`, `id`, `square_id`, `adr1`, `adr2`, `city`, `postal_code`, `user_id`, `value`, `date_opening`, `province`, `country`, `stat`, `allow_pickup`, `tel1`, `description`, `note`, `type`, `eml1`, `web`, `latitude`, `longitude`, `date_created`, `date_modified`, `user_created`, `user_modified`) VALUES
('Head Office', 1, '', 'Adresse ligne 1', '', 'Ville', 'H0H 0H0', 0, 0, '2024-01-01', 'QC', 'Canada', '0', 1, '1-514-555-5555', '', '', '8', 'info@dw3.ca', '', '45', '-73', '2023-03-08 00:40:44', '2023-03-08 00:40:44', 0, 0);

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `message` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(20) NOT NULL,
  `received` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `option` (
  `id` int(11) NOT NULL,
  `name_fr` varchar(128) NOT NULL,
  `name_en` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `option` (`id`, `name_fr`, `name_en`) VALUES
(1, 'Couleur', 'Color'),
(3, 'Kilomètre', 'Kilometer'),
(4, 'Numéros de Série', 'Serial Number');

CREATE TABLE `order_head` (
  `id` int(9) NOT NULL,
  `project_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `retailer_loc_id` int(11) NOT NULL DEFAULT 0,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `subscription_id` varchar(64) NOT NULL,
  `stat` int(2) NOT NULL DEFAULT 0,
  `subscription_stat` varchar(10) NOT NULL,
  `eml` varchar(128) NOT NULL,
  `tel` varchar(40) NOT NULL,
  `adr1` varchar(256) NOT NULL,
  `adr2` varchar(128) NOT NULL,
  `city` varchar(64) NOT NULL,
  `prov` varchar(64) NOT NULL,
  `country` varchar(64) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `adr1_sh` varchar(256) NOT NULL,
  `adr2_sh` varchar(256) NOT NULL,
  `city_sh` varchar(64) NOT NULL,
  `province_sh` varchar(64) NOT NULL,
  `country_sh` varchar(64) NOT NULL,
  `postal_code_sh` varchar(20) NOT NULL,
  `name` varchar(256) NOT NULL,
  `company` varchar(128) NOT NULL,
  `prepaid_cash` float NOT NULL DEFAULT 0,
  `total` float(11,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(11,2) NOT NULL DEFAULT 0.00,
  `transport` decimal(9,2) NOT NULL DEFAULT 0.00,
  `ship_code` varchar(10) NOT NULL DEFAULT '',
  `ship_type` varchar(20) NOT NULL,
  `stotal` decimal(11,2) NOT NULL DEFAULT 0.00,
  `tps` decimal(9,2) NOT NULL DEFAULT 0.00,
  `tvp` decimal(9,2) NOT NULL DEFAULT 0.00,
  `tvh` decimal(9,2) NOT NULL DEFAULT 0.00,
  `weight` decimal(6,3) NOT NULL DEFAULT 0.000,
  `length` decimal(4,1) NOT NULL DEFAULT 0.0,
  `width` decimal(4,1) NOT NULL DEFAULT 0.0,
  `height` decimal(4,1) NOT NULL DEFAULT 0.0,
  `sh_so` tinyint(1) NOT NULL DEFAULT 0,
  `sh_cov` decimal(6,2) NOT NULL DEFAULT 0.00,
  `sh_pa18` tinyint(1) NOT NULL DEFAULT 0,
  `sh_drop` varchar(4) NOT NULL DEFAULT 'LAD',
  `shipment_id` varchar(20) NOT NULL,
  `tracking_number` varchar(20) NOT NULL DEFAULT '',
  `tracking_url` varchar(128) NOT NULL DEFAULT '',
  `label_link` varchar(128) NOT NULL,
  `notif_shipment` tinyint(1) NOT NULL DEFAULT 1,
  `notif_exception` tinyint(1) NOT NULL DEFAULT 1,
  `notif_delivery` tinyint(1) NOT NULL DEFAULT 1,
  `note` varchar(512) NOT NULL,
  `date_delivery` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'step 5 - delivery done',
  `date_due` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_shipped` datetime NOT NULL COMMENT 'step 3 - out of warehouse',
  `date_packed` datetime NOT NULL COMMENT 'step 2 - packed and ready to ship',
  `date_routed` datetime NOT NULL COMMENT 'step 4 - next delivery on route',
  `date_created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'step 1 - order created',
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `user_modified` int(11) NOT NULL DEFAULT 0,
  `date_renew` datetime NOT NULL,
  `date_email` datetime DEFAULT NULL,
  `user_email` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `order_line` (
  `head_id` int(11) NOT NULL DEFAULT 0,
  `id` int(13) NOT NULL,
  `line` int(5) NOT NULL DEFAULT 0,
  `product_renew` tinyint(1) NOT NULL DEFAULT 0,
  `classified_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `product_desc` varchar(256) NOT NULL DEFAULT '',
  `product_opt` varchar(60) NOT NULL DEFAULT '',
  `pack_id` int(11) NOT NULL DEFAULT 0,
  `qty_order` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `qty_shipped` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `price` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `options_price` decimal(11,2) NOT NULL DEFAULT 0.00,
  `transport` decimal(7,2) NOT NULL DEFAULT 0.00,
  `transport_type` varchar(10) NOT NULL DEFAULT '',
  `tvh` decimal(11,2) NOT NULL DEFAULT 0.00,
  `tps` decimal(11,2) NOT NULL DEFAULT 0.00,
  `tvp` decimal(9,2) NOT NULL DEFAULT 0.00,
  `date_due` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_modified` int(11) NOT NULL DEFAULT 0,
  `date_shipped` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_shipped` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `order_option` (
  `id` int(11) NOT NULL,
  `line_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_line_id` int(11) NOT NULL DEFAULT 0,
  `description_fr` varchar(64) NOT NULL,
  `price` decimal(7,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `location_id` int(11) NOT NULL DEFAULT 1,
  `name` varchar(64) NOT NULL,
  `parent_name` varchar(64) NOT NULL,
  `name_en_m` varchar(64) NOT NULL,
  `name_en_f` varchar(64) NOT NULL,
  `name_fr_m` varchar(64) NOT NULL,
  `name_fr_f` varchar(64) NOT NULL,
  `auth` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `salary_min` decimal(11,2) NOT NULL DEFAULT 0.00,
  `salary_type` varchar(6) NOT NULL DEFAULT '''HOUR''' COMMENT 'MINUTE,HOUR,WEEK,MONTH,YEAR',
  `qty_max` int(9) NOT NULL DEFAULT 1,
  `qty_min` int(9) NOT NULL DEFAULT 0,
  `hours_week` int(3) NOT NULL DEFAULT 40,
  `time_start` time NOT NULL DEFAULT '00:00:00',
  `time_end` time NOT NULL DEFAULT '00:00:00',
  `days` varchar(14) NOT NULL DEFAULT '1,2,3,4,5,6,7',
  `salary_max` decimal(11,2) NOT NULL DEFAULT 0.00,
  `responsibilities` text NOT NULL,
  `skills` text NOT NULL,
  `qualifications` text NOT NULL,
  `education` text NOT NULL,
  `experience` text NOT NULL,
  `telecommute` tinyint(1) NOT NULL DEFAULT 0,
  `full_time` tinyint(1) NOT NULL DEFAULT 1,
  `part_time` tinyint(1) NOT NULL DEFAULT 0,
  `contractor` tinyint(1) NOT NULL DEFAULT 0,
  `temporary` tinyint(1) NOT NULL DEFAULT 0,
  `intern` tinyint(1) NOT NULL DEFAULT 0,
  `volunteer` tinyint(1) NOT NULL DEFAULT 0,
  `per_diem` tinyint(1) NOT NULL DEFAULT 0,
  `other` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `date_end_post` date NOT NULL DEFAULT current_timestamp(),
  `document_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `position` (`id`, `active`, `location_id`, `name`, `parent_name`, `name_en_m`, `name_en_f`, `name_fr_m`, `name_fr_f`, `auth`, `description`, `salary_min`, `salary_type`, `qty_max`, `qty_min`, `hours_week`, `time_start`, `time_end`, `days`, `salary_max`, `responsibilities`, `skills`, `qualifications`, `education`, `experience`, `telecommute`, `full_time`, `part_time`, `contractor`, `temporary`, `intern`, `volunteer`, `per_diem`, `other`, `date_created`, `date_end_post`, `document_id`) VALUES
(1, 0, 1, 'Président', '', '', '', '', '', '', 'Fondateur et président', 0.00, '0', 1, 0, 40, '00:00:00', '00:00:00', '1,2,3,4,5,6,7', 0.00, '', '', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, '2025-02-26', '2025-02-26', 0),
(2, 0, 1, 'Directeur de projet', 'Président', '', '', '', '', '', '', 0.00, '0', 1, 0, 40, '00:00:00', '00:00:00', '1,2,3,4,5,6,7', 0.00, '', '', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, '2025-02-26', '2025-02-26', 0),
(5, 0, 1, 'Commis à l’entrée de données', 'Directeur de projet', '', '', '', '', '', '', 0.00, '0', 1, 0, 40, '00:00:00', '00:00:00', '1,2,3,4,5,6,7', 0.00, '', '', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, '2025-02-26', '2025-02-26', 0),
(6, 0, 1, 'Infographiste', 'Directeur de projet', '', '', '', '', '', 'description ', 0.00, '0', 1, 0, 40, '00:00:00', '00:00:00', '1,2,3,4,5,6,7', 0.00, '', '', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, '2025-02-26', '2025-02-26', 0),
(7, 0, 1, 'Directeur des ventes', 'Président', '', '', '', '', '', '', 0.00, '0', 1, 0, 40, '00:00:00', '00:00:00', '1,2,3,4,5,6,7', 0.00, '', '', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, '2025-02-26', '2025-02-26', 0),
(8, 0, 1, 'Représentant', 'Directeur des ventes', '', '', '', '', '', '', 0.00, '0', 1, 0, 40, '00:00:00', '00:00:00', '1,2,3,4,5,6,7', 0.00, '', '', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, '2025-02-26', '2025-02-26', 0),
(11, 0, 1, 'Programmeur Sénior', 'Directeur de projet', '', '', '', '', '', '', 0.00, '0', 1, 0, 40, '00:00:00', '00:00:00', '1,2,3,4,5,6,7', 0.00, '', '', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, '2025-02-26', '2025-02-26', 0),
(12, 0, 1, 'Programmeur NIV2', 'Directeur de projet', '', '', '', '', '', '', 0.00, '0', 1, 0, 40, '00:00:00', '00:00:00', '1,2,3,4,5,6,7', 0.00, '', '', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, '2025-02-26', '2025-02-26', 0),
(13, 1, 1, 'Programmeur Junior', 'Programmeur Sénior', '', '', '', '', '', 'Description du poste de programmeur junior.', 25.00, 'HOUR', 1, 0, 40, '00:00:00', '00:00:00', '1,2,3,4,5,6,7', 0.00, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in', 0, 1, 1, 0, 0, 0, 0, 0, 0, '2025-02-26', '2026-01-31', 5);

CREATE TABLE `procedure_head` (
  `id` int(11) NOT NULL,
  `name_fr` varchar(128) NOT NULL,
  `product_id` int(11) NOT NULL,
  `supply_id` int(11) NOT NULL,
  `delay_by_unit` int(11) NOT NULL,
  `quality_v1_desc` varchar(64) NOT NULL,
  `quality_v2_desc` varchar(64) NOT NULL,
  `quality_v3_desc` varchar(64) NOT NULL,
  `quality_v4_desc` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `procedure_line` (
  `id` int(11) NOT NULL,
  `procedure_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty_by_unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `stat` int(1) NOT NULL DEFAULT 0,
  `stripe_id` varchar(64) NOT NULL DEFAULT '',
  `moneris_id` varchar(64) NOT NULL,
  `square_id` varchar(32) NOT NULL DEFAULT '',
  `requiered_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(5) NOT NULL DEFAULT 0,
  `category2_id` int(5) NOT NULL DEFAULT 0,
  `category3_id` int(5) NOT NULL DEFAULT 0,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `sku` varchar(20) NOT NULL DEFAULT '',
  `upc` varchar(30) NOT NULL DEFAULT '',
  `upc_box` varchar(32) NOT NULL DEFAULT '',
  `billing` varchar(20) NOT NULL DEFAULT '',
  `name_fr` varchar(64) NOT NULL DEFAULT '',
  `name_en` varchar(64) NOT NULL DEFAULT '',
  `description_fr` text NOT NULL DEFAULT '',
  `description_en` text NOT NULL DEFAULT '',
  `desc_dataia_fr` text NOT NULL DEFAULT '',
  `pack` int(11) NOT NULL DEFAULT 1,
  `qty_box` float NOT NULL DEFAULT 1,
  `qty_max` int(7) NOT NULL DEFAULT 0,
  `type_unique` tinyint(1) NOT NULL DEFAULT 0,
  `is_free` tinyint(1) NOT NULL DEFAULT 0,
  `is_scheduled` tinyint(1) NOT NULL DEFAULT 0,
  `price_decimal` tinyint(2) NOT NULL DEFAULT 2,
  `qty_step` int(4) NOT NULL DEFAULT 1,
  `stripe_price_id` varchar(32) NOT NULL,
  `prod_cost` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `cost` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `price1` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `price2` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `transport_supp` decimal(7,2) NOT NULL DEFAULT 0.00,
  `tax_fed` tinyint(1) NOT NULL DEFAULT 1,
  `tax_prov` tinyint(1) NOT NULL DEFAULT 1,
  `tax_verte` decimal(7,2) NOT NULL DEFAULT 0.00,
  `ship_type` varchar(20) NOT NULL DEFAULT '',
  `allow_pickup` tinyint(1) NOT NULL DEFAULT 0,
  `conservation_days` int(4) NOT NULL DEFAULT 0,
  `service_length` int(11) NOT NULL DEFAULT 15 COMMENT 'first used for mAssage length in minuts',
  `inter_length` int(11) NOT NULL DEFAULT 15 COMMENT 'pause between massages for schedule',
  `liter` float NOT NULL DEFAULT 0,
  `kg` float(14,6) NOT NULL DEFAULT 0.000000,
  `height` int(7) NOT NULL DEFAULT 0,
  `width` int(7) NOT NULL DEFAULT 0,
  `depth` int(7) NOT NULL DEFAULT 0,
  `color_name` varchar(20) NOT NULL DEFAULT '',
  `brand` varchar(32) NOT NULL DEFAULT '',
  `model` varchar(32) NOT NULL DEFAULT '',
  `color_code` varchar(20) NOT NULL DEFAULT '',
  `web_dsp` tinyint(1) NOT NULL DEFAULT 1,
  `web_btn_fr` varchar(64) NOT NULL DEFAULT 'Ajouter au panier',
  `web_btn_en` varchar(64) NOT NULL DEFAULT 'Add to cart',
  `web_btn2_fr` varchar(64) NOT NULL DEFAULT 'Plus d’infos',
  `web_btn2_en` varchar(64) NOT NULL,
  `web_btn_icon` varchar(32) NOT NULL DEFAULT 'Ň',
  `web_btn2_icon` varchar(32) NOT NULL DEFAULT 'w',
  `price_text_fr` varchar(64) NOT NULL DEFAULT ' ',
  `price_text_en` varchar(64) NOT NULL DEFAULT ' ',
  `price_suffix_fr` varchar(64) NOT NULL DEFAULT '<sup>$</sup>',
  `price_suffix_en` varchar(64) NOT NULL DEFAULT '<sup>$</sup>',
  `dsp_status` tinyint(1) NOT NULL DEFAULT 0,
  `mag_dsp` tinyint(1) NOT NULL DEFAULT 1,
  `dsp_opt` tinyint(1) NOT NULL DEFAULT 0,
  `dsp_inv` tinyint(1) NOT NULL DEFAULT 0,
  `dsp_upc` tinyint(1) NOT NULL DEFAULT 0,
  `dsp_description` tinyint(1) NOT NULL DEFAULT 1,
  `dsp_statistics` tinyint(1) NOT NULL DEFAULT 0,
  `url_img` varchar(128) NOT NULL,
  `btn_action1` varchar(64) NOT NULL DEFAULT 'CART',
  `btn_action2` varchar(64) NOT NULL DEFAULT 'INFO',
  `url_action1` varchar(128) NOT NULL DEFAULT '',
  `url_action2` varchar(128) NOT NULL,
  `qty_min_sold` decimal(7,2) NOT NULL DEFAULT 1.00,
  `qty_max_sold` decimal(7,2) NOT NULL DEFAULT 0.00,
  `qty_max_by_inv` tinyint(1) NOT NULL DEFAULT 1,
  `pack_desc` varchar(20) NOT NULL DEFAULT 'un.',
  `import_storage_id` int(11) NOT NULL DEFAULT 0,
  `export_storage_id` int(11) NOT NULL DEFAULT 0,
  `qty_min_price2` int(7) NOT NULL DEFAULT 0,
  `is_bio` tinyint(1) NOT NULL DEFAULT 0,
  `consigne` decimal(5,2) NOT NULL DEFAULT 0.00,
  `price3` float NOT NULL DEFAULT 0,
  `model_year` int(4) NOT NULL DEFAULT 0,
  `dsp_mesure` tinyint(1) NOT NULL DEFAULT 0,
  `dsp_model` tinyint(1) NOT NULL DEFAULT 0,
  `dsp_export_storage` tinyint(1) NOT NULL DEFAULT 0,
  `promo_price` float NOT NULL DEFAULT 0,
  `promo_expire` datetime NOT NULL DEFAULT current_timestamp(),
  `purchase_qty` int(11) NOT NULL DEFAULT 0,
  `qty_visited` int(7) NOT NULL DEFAULT 0,
  `date_start` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_end` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `user_modified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `product` (`id`, `stat`, `stripe_id`, `moneris_id`, `square_id`, `requiered_id`, `user_id`, `category_id`, `category2_id`, `category3_id`, `supplier_id`, `sku`, `upc`, `upc_box`, `billing`, `name_fr`, `name_en`, `description_fr`, `description_en`, `desc_dataia_fr`, `pack`, `qty_box`, `qty_max`, `type_unique`, `is_free`, `is_scheduled`, `price_decimal`, `qty_step`, `stripe_price_id`, `prod_cost`, `cost`, `price1`, `price2`, `transport_supp`, `tax_fed`, `tax_prov`, `tax_verte`, `ship_type`, `allow_pickup`, `conservation_days`, `service_length`, `inter_length`, `liter`, `kg`, `height`, `width`, `depth`, `color_name`, `brand`, `model`, `color_code`, `web_dsp`, `web_btn_fr`, `web_btn_en`, `web_btn2_fr`, `web_btn2_en`, `web_btn_icon`, `web_btn2_icon`, `price_text_fr`, `price_text_en`, `price_suffix_fr`, `price_suffix_en`, `dsp_status`, `mag_dsp`, `dsp_opt`, `dsp_inv`, `dsp_upc`, `dsp_description`, `dsp_statistics`, `url_img`, `btn_action1`, `btn_action2`, `url_action1`, `url_action2`, `qty_min_sold`, `qty_max_sold`, `qty_max_by_inv`, `pack_desc`, `import_storage_id`, `export_storage_id`, `qty_min_price2`, `is_bio`, `consigne`, `price3`, `model_year`, `dsp_mesure`, `dsp_model`, `dsp_export_storage`, `promo_price`, `promo_expire`, `purchase_qty`, `qty_visited`, `date_start`, `date_end`, `date_created`, `date_modified`, `user_created`, `user_modified`) VALUES
(1231, 0, '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', '', 'Consultation', '', '', '', '', 1, 1, 0, 0, 0, 1, 2, 1, '', 0.0000, 0.0000, 0.0000, 0.0000, 0.00, 1, 1, 0.00, 'INTERNAL', 0, 0, 15, 15, 0, 0.000000, 0, 0, 0, '', '0', '0', '', 1, 'Ajouter au panier', 'Add to cart', 'Plus d’infos', '', '&#128722', '&#127320;', ' ', ' ', '<sup>$</sup>', '<sup>$</sup>', 0, 1, 0, 0, 0, 1, 0, 'IMG_1089.JPG', 'CART', 'INFO', '', '', 1.00, 0.00, 1, 'un.', 0, 0, 0, 0, 0.00, 0, 0, 0, 0, 0, 0, '2025-08-08 10:29:52', 0, 0, '2025-08-08 14:29:52', '2025-08-08 14:29:52', '2025-08-08 14:29:52', '2025-08-08 14:30:18', 0, 0);

CREATE TABLE `production` (
  `id` int(11) NOT NULL,
  `procedure_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'TO_DO',
  `qty_needed` decimal(14,4) NOT NULL DEFAULT 0.0000,
  `qty_produced` decimal(14,4) NOT NULL,
  `lot_no` varchar(64) NOT NULL,
  `order_id` int(11) NOT NULL,
  `storage_id` int(11) NOT NULL,
  `quality_val1` varchar(64) NOT NULL,
  `quality_val2` varchar(64) NOT NULL,
  `quality_val3` varchar(64) NOT NULL,
  `quality_val4` varchar(64) NOT NULL,
  `date_start` datetime NOT NULL DEFAULT current_timestamp(),
  `date_due` datetime NOT NULL DEFAULT current_timestamp(),
  `date_end` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `square_id` varchar(30) NOT NULL DEFAULT '',
  `name_fr` varchar(64) NOT NULL DEFAULT '',
  `parent_name` varchar(64) NOT NULL DEFAULT '0',
  `name_en` varchar(64) NOT NULL DEFAULT '',
  `description_fr` text NOT NULL DEFAULT '',
  `description_en` text NOT NULL DEFAULT '',
  `sort_number` int(4) NOT NULL DEFAULT 0,
  `img_url` varchar(256) NOT NULL DEFAULT '',
  `web_dsp` tinyint(1) NOT NULL DEFAULT 1,
  `qty_visited` int(7) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `product_gl` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `gl_code` int(11) NOT NULL,
  `kind` varchar(8) NOT NULL DEFAULT '',
  `amount` float NOT NULL DEFAULT 0,
  `pourcent` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `product_kit` (
  `parent_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `qty` float NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `product_option` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name_fr` varchar(256) NOT NULL,
  `name_en` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `product_option_line` (
  `id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `name_fr` varchar(64) NOT NULL,
  `name_en` varchar(64) NOT NULL,
  `amount` decimal(11,2) NOT NULL DEFAULT 0.00,
  `default_selection` int(1) NOT NULL DEFAULT 0,
  `liter` decimal(14,6) NOT NULL DEFAULT 0.000000,
  `kg` decimal(14,6) NOT NULL DEFAULT 0.000000,
  `height` int(7) NOT NULL DEFAULT 0,
  `width` int(7) NOT NULL DEFAULT 0,
  `depth` int(7) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `product_pack` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `pack_qty` decimal(11,2) NOT NULL DEFAULT 1.00,
  `pack_price` decimal(11,2) NOT NULL DEFAULT 0.00,
  `pack_name_fr` varchar(64) NOT NULL DEFAULT '',
  `pack_name_en` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT current_timestamp(),
  `user_modified` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `date_due` datetime NOT NULL,
  `estimated_end` datetime NOT NULL,
  `estimated_price` decimal(14,2) NOT NULL,
  `estimated_cost` decimal(14,2) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `adr` varchar(256) NOT NULL,
  `city` varchar(60) NOT NULL,
  `province` varchar(2) NOT NULL,
  `postal_code` varchar(7) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `prototype_data` (
  `head_id` int(11) NOT NULL,
  `line_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `value1` varchar(256) NOT NULL DEFAULT '',
  `value2` varchar(256) NOT NULL DEFAULT '',
  `value3` varchar(256) NOT NULL DEFAULT '',
  `value4` varchar(256) NOT NULL DEFAULT '',
  `value5` varchar(256) NOT NULL DEFAULT '',
  `value6` varchar(256) NOT NULL DEFAULT '',
  `value7` varchar(256) NOT NULL DEFAULT '',
  `value8` varchar(256) NOT NULL DEFAULT '',
  `value9` varchar(256) NOT NULL DEFAULT '',
  `value0` varchar(256) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `prototype_head` (
  `id` int(11) NOT NULL,
  `next_id` int(11) NOT NULL DEFAULT 0,
  `parent_table` varchar(32) NOT NULL DEFAULT '',
  `parent_key` varchar(32) NOT NULL DEFAULT '',
  `auto_add` tinyint(1) NOT NULL DEFAULT 0,
  `total_type` varchar(20) NOT NULL DEFAULT 'NONE' COMMENT 'NONE,CASH,POINTS,POURCENT',
  `total_max` decimal(9,2) NOT NULL DEFAULT 0.00,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `link_to_user` tinyint(1) NOT NULL DEFAULT 1,
  `captcha_required` tinyint(1) NOT NULL DEFAULT 1,
  `allow_user_reedit` tinyint(1) NOT NULL DEFAULT 1,
  `allow_user_view` tinyint(1) NOT NULL DEFAULT 1,
  `name_fr` varchar(128) NOT NULL DEFAULT '',
  `name_en` varchar(128) NOT NULL DEFAULT '',
  `description_fr` varchar(256) DEFAULT '',
  `description_en` varchar(256) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `prototype_head` (`id`, `next_id`, `parent_table`, `parent_key`, `auto_add`, `total_type`, `total_max`, `published`, `link_to_user`, `captcha_required`, `allow_user_reedit`, `allow_user_view`, `name_fr`, `name_en`, `description_fr`, `description_en`) VALUES
(5, 0, 'user', '', 0, 'NONE', 0.00, 0, 1, 1, 1, 1, 'Application Programmeur junior', '', 'Description du poste', '');

CREATE TABLE `prototype_line` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `multiplier` tinyint(1) NOT NULL DEFAULT 0,
  `multiplied` int(11) NOT NULL DEFAULT 0,
  `exclude_multiplier` tinyint(1) NOT NULL DEFAULT 0,
  `is_total` tinyint(1) NOT NULL DEFAULT 0,
  `record_name` varchar(20) NOT NULL,
  `mandatory` tinyint(1) NOT NULL DEFAULT 0,
  `position` int(4) NOT NULL,
  `last_on_page` tinyint(1) NOT NULL DEFAULT 0,
  `box_size` varchar(10) NOT NULL DEFAULT 'MEDIUM' COMMENT 'SMALL,MEDIUM,LARGE',
  `response_type` varchar(20) NOT NULL DEFAULT 'TEXT' COMMENT 'TEXT,CHECKBOX,YES/NO,CHOICE,MULTI-CHOICE,MULTI-TEXTE',
  `response_align` varchar(6) NOT NULL DEFAULT 'CENTER',
  `name_fr` varchar(196) NOT NULL,
  `name_en` varchar(196) NOT NULL,
  `description_fr` varchar(512) NOT NULL,
  `description_en` varchar(512) NOT NULL,
  `choice_name1` varchar(196) NOT NULL,
  `choice_value1` decimal(7,2) NOT NULL DEFAULT 0.00,
  `choice_name2` varchar(196) NOT NULL,
  `choice_value2` decimal(7,2) NOT NULL DEFAULT 0.00,
  `choice_name3` varchar(196) NOT NULL,
  `choice_value3` decimal(7,2) NOT NULL DEFAULT 0.00,
  `choice_name4` varchar(196) NOT NULL,
  `choice_value4` decimal(7,2) NOT NULL DEFAULT 0.00,
  `choice_name5` varchar(196) NOT NULL,
  `choice_value5` decimal(7,2) NOT NULL DEFAULT 0.00,
  `choice_name6` varchar(196) NOT NULL,
  `choice_value6` decimal(7,2) NOT NULL DEFAULT 0.00,
  `choice_name7` varchar(196) NOT NULL,
  `choice_value7` decimal(7,2) NOT NULL DEFAULT 0.00,
  `choice_name8` varchar(196) NOT NULL,
  `choice_value8` decimal(7,2) NOT NULL DEFAULT 0.00,
  `choice_name9` varchar(196) NOT NULL,
  `choice_value9` decimal(7,2) NOT NULL DEFAULT 0.00,
  `choice_name0` varchar(196) NOT NULL,
  `choice_value0` decimal(7,2) NOT NULL DEFAULT 0.00,
  `choice_name1_en` varchar(64) NOT NULL DEFAULT '',
  `choice_name2_en` varchar(196) NOT NULL,
  `choice_name3_en` varchar(196) NOT NULL,
  `choice_name4_en` varchar(196) NOT NULL,
  `choice_name5_en` varchar(196) NOT NULL,
  `choice_name6_en` varchar(196) NOT NULL,
  `choice_name7_en` varchar(196) NOT NULL,
  `choice_name8_en` varchar(196) NOT NULL,
  `choice_name9_en` varchar(196) NOT NULL,
  `choice_name0_en` varchar(196) NOT NULL,
  `choice_img1` varchar(128) NOT NULL DEFAULT '',
  `choice_img2` varchar(128) NOT NULL DEFAULT '',
  `choice_img3` varchar(128) NOT NULL DEFAULT '',
  `choice_img4` varchar(128) NOT NULL DEFAULT '',
  `choice_img5` varchar(128) NOT NULL DEFAULT '',
  `choice_img6` varchar(128) NOT NULL DEFAULT '',
  `choice_img7` varchar(128) NOT NULL DEFAULT '',
  `choice_img8` varchar(128) NOT NULL DEFAULT '',
  `choice_img9` varchar(128) NOT NULL DEFAULT '',
  `choice_img0` varchar(128) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `prototype_line` (`id`, `head_id`, `product_id`, `multiplier`, `multiplied`, `exclude_multiplier`, `is_total`, `record_name`, `mandatory`, `position`, `last_on_page`, `box_size`, `response_type`, `response_align`, `name_fr`, `name_en`, `description_fr`, `description_en`, `choice_name1`, `choice_value1`, `choice_name2`, `choice_value2`, `choice_name3`, `choice_value3`, `choice_name4`, `choice_value4`, `choice_name5`, `choice_value5`, `choice_name6`, `choice_value6`, `choice_name7`, `choice_value7`, `choice_name8`, `choice_value8`, `choice_name9`, `choice_value9`, `choice_name0`, `choice_value0`, `choice_name1_en`, `choice_name2_en`, `choice_name3_en`, `choice_name4_en`, `choice_name5_en`, `choice_name6_en`, `choice_name7_en`, `choice_name8_en`, `choice_name9_en`, `choice_name0_en`, `choice_img1`, `choice_img2`, `choice_img3`, `choice_img4`, `choice_img5`, `choice_img6`, `choice_img7`, `choice_img8`, `choice_img9`, `choice_img0`) VALUES
(20, 5, 0, 0, 0, 0, 0, 'NONE', 0, 0, 0, 'MEDIUM', 'TEXT', 'CENTER', 'Annés d’expérience en programmation', '', '', '', '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(21, 5, 0, 0, 0, 0, 0, 'NONE', 0, 1, 0, 'MEDIUM', 'TEXT', 'CENTER', 'Salaire souhaité', '', '', '', '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', 0.00, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

CREATE TABLE `prototype_report` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL DEFAULT 0,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `lang` varchar(2) NOT NULL DEFAULT 'FR',
  `report_eml` varchar(128) NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL,
  `date_submited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_completed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `result` decimal(9,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `purchase_head` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `supplier_pid` varchar(40) NOT NULL DEFAULT '',
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `document` varchar(128) NOT NULL DEFAULT '',
  `location_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `stat` int(2) NOT NULL DEFAULT 0,
  `eml` varchar(128) NOT NULL DEFAULT '',
  `adr1` varchar(128) NOT NULL DEFAULT '',
  `adr2` varchar(64) NOT NULL DEFAULT '',
  `city` varchar(64) NOT NULL DEFAULT '',
  `prov` varchar(64) NOT NULL DEFAULT '',
  `country` varchar(64) NOT NULL DEFAULT '',
  `postal_code` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `total` float(11,4) NOT NULL DEFAULT 0.0000,
  `transport` float NOT NULL DEFAULT 0,
  `prepaid_cash` float NOT NULL DEFAULT 0,
  `date_email` datetime NOT NULL,
  `user_email` int(11) NOT NULL,
  `note` varchar(512) NOT NULL DEFAULT '',
  `date_due` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `user_modified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `purchase_line` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL DEFAULT 0,
  `line` int(5) NOT NULL DEFAULT 0,
  `name_fr` varchar(128) NOT NULL,
  `gl_group` varchar(30) NOT NULL DEFAULT '',
  `product_id` int(11) NOT NULL DEFAULT 0,
  `product_opt` varchar(60) NOT NULL DEFAULT '',
  `qty_order` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `qty_shipped` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `price` float(11,4) NOT NULL DEFAULT 0.0000,
  `tax_prov` tinyint(1) NOT NULL DEFAULT 0,
  `tax_fed` tinyint(1) NOT NULL DEFAULT 0,
  `date_due` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_modified` int(11) NOT NULL DEFAULT 0,
  `date_shipped` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_shipped` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `realisation` (
  `id` int(11) NOT NULL,
  `sort_number` int(3) NOT NULL DEFAULT 0,
  `name_fr` varchar(128) NOT NULL DEFAULT 'Mois / Année',
  `name_en` varchar(128) NOT NULL DEFAULT 'Month / Year',
  `description_fr` varchar(512) NOT NULL DEFAULT 'Description Française',
  `description_en` varchar(512) NOT NULL DEFAULT 'English Description',
  `href` varchar(256) NOT NULL DEFAULT 'Lien / Link',
  `img_link` varchar(256) NOT NULL DEFAULT 'Lien / Link Image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `road_head` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `freq_hour` int(4) NOT NULL,
  `freq_day` int(4) NOT NULL,
  `highway` tinyint(1) NOT NULL DEFAULT 0,
  `ferrie` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `user_modified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `road_line` (
  `id` int(11) NOT NULL,
  `road_id` int(11) NOT NULL DEFAULT 0,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `date_visit` timestamp NOT NULL DEFAULT current_timestamp(),
  `sort_number` int(7) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `road_user` (
  `road_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `scene` (
  `id` int(11) NOT NULL,
  `name_fr` varchar(64) NOT NULL,
  `description_fr` varchar(256) NOT NULL,
  `bg_path` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `schedule_head` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `end_date` datetime NOT NULL DEFAULT current_timestamp(),
  `start_work` datetime NOT NULL,
  `end_work` datetime NOT NULL,
  `block_size` int(7) NOT NULL DEFAULT 30,
  `description` text NOT NULL DEFAULT '',
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `virtual_enable` tinyint(1) NOT NULL DEFAULT 0,
  `road_enable` tinyint(1) NOT NULL DEFAULT 0,
  `local_enable` tinyint(1) NOT NULL DEFAULT 1,
  `phone_enable` tinyint(4) NOT NULL DEFAULT 0,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `local_id` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `schedule_head` (`id`, `parent_id`, `user_id`, `start_date`, `end_date`, `start_work`, `end_work`, `block_size`, `description`, `is_public`, `virtual_enable`, `road_enable`, `local_enable`, `phone_enable`, `location_id`, `local_id`, `created`) VALUES
(1, 0, 0, '2025-12-31 08:00:00', '2025-12-31 20:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 30, '', 1, 1, 1, 1, 1, 0, 0, '2025-08-08 00:00:00'),
(2, 0, 0, '2026-12-31 08:00:00', '2026-12-31 20:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 30, '', 1, 1, 1, 1, 1, 0, 0, '2025-08-08 00:00:00'),
(3, 0, 0, '2027-12-31 08:00:00', '2027-12-31 20:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 30, '', 1, 1, 1, 1, 1, 0, 0, '2025-08-08 00:00:00');

CREATE TABLE `schedule_line` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL DEFAULT 0,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `end_date` datetime NOT NULL DEFAULT current_timestamp(),
  `iso_start` varchar(25) NOT NULL DEFAULT '',
  `iso_end` varchar(25) NOT NULL DEFAULT '',
  `location_type` varchar(10) NOT NULL DEFAULT 'L',
  `confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `link_url` varchar(256) NOT NULL DEFAULT '',
  `is_link_sent` int(1) NOT NULL DEFAULT 0,
  `link_platform` varchar(10) NOT NULL DEFAULT '',
  `link_pw` varchar(20) NOT NULL DEFAULT '',
  `sms_msg_id` varchar(128) NOT NULL DEFAULT '',
  `paid` float(11,2) NOT NULL DEFAULT 0.00,
  `state` varchar(20) NOT NULL DEFAULT 'PANIER',
  `commentaire` varchar(240) NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `shipment_line` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL,
  `line_id` int(11) NOT NULL,
  `qty_shipped` decimal(11,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `slideshow` (
  `id` int(11) NOT NULL,
  `index_id` int(11) NOT NULL,
  `sort_by` int(4) NOT NULL,
  `name_fr` varchar(256) NOT NULL DEFAULT '',
  `name_en` varchar(128) NOT NULL DEFAULT '',
  `media_type` varchar(20) NOT NULL DEFAULT 'image',
  `media_link` varchar(512) NOT NULL DEFAULT '',
  `media_url` varchar(256) NOT NULL DEFAULT '',
  `description_fr` varchar(256) NOT NULL DEFAULT '',
  `description_en` varchar(256) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `level` varchar(30) NOT NULL DEFAULT '1',
  `local` varchar(30) NOT NULL DEFAULT '',
  `row` varchar(30) NOT NULL DEFAULT '',
  `shelf` varchar(30) NOT NULL DEFAULT '',
  `section` varchar(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `storage` (`id`, `location_id`, `level`, `local`, `row`, `shelf`, `section`) VALUES
(1, 1, '1', 'Storage', '1 - Tools', 'A', '1'),
(2, 1, '1', 'Storage', '1 - Tools', 'A', '2'),
(3, 1, '1', 'Bureau', '', '', '');

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `stat` int(2) NOT NULL DEFAULT 0,
  `type` varchar(32) NOT NULL,
  `company_name` varchar(64) NOT NULL,
  `contact_name` varchar(64) NOT NULL,
  `contact_note` varchar(64) NOT NULL,
  `adr1` varchar(128) NOT NULL,
  `adr2` varchar(64) NOT NULL,
  `city` varchar(64) NOT NULL,
  `province` varchar(64) NOT NULL DEFAULT 'Quebec',
  `country` varchar(64) NOT NULL DEFAULT 'Canada',
  `postal_code` varchar(16) NOT NULL,
  `tel1` varchar(16) NOT NULL,
  `tel2` varchar(16) NOT NULL,
  `eml1` varchar(128) NOT NULL,
  `eml2` varchar(128) NOT NULL,
  `longitude` varchar(32) NOT NULL,
  `latitude` varchar(32) NOT NULL,
  `sms_stat` tinyint(1) NOT NULL,
  `key_128` varchar(128) NOT NULL,
  `key_expire` timestamp NOT NULL DEFAULT current_timestamp(),
  `key_reset` varchar(128) NOT NULL,
  `pw` varchar(64) NOT NULL,
  `note` text NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'fr',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `user_modified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `supplier` (`id`, `stat`, `type`, `company_name`, `contact_name`, `contact_note`, `adr1`, `adr2`, `city`, `province`, `country`, `postal_code`, `tel1`, `tel2`, `eml1`, `eml2`, `longitude`, `latitude`, `sms_stat`, `key_128`, `key_expire`, `key_reset`, `pw`, `note`, `lang`, `date_created`, `date_modified`, `user_created`, `user_modified`) VALUES
(1, 0, '', 'Design Web 3D', '', '', '', '', '', 'Quebec', 'Canada', '', '', '', '', '', '', '', 0, '', '2023-03-09 06:16:05', '', '', '', 'fr', '2023-03-09 06:16:05', '2023-03-09 06:16:05', 0, 0),
(3, 0, '', 'Hébergement Web Canada', '', '', '', '', '', 'Quebec', 'Canada', '', '', '', '', '', '', '', 0, '', '2023-04-07 17:00:43', '', '', '', 'fr', '2023-04-07 17:00:43', '2023-04-07 17:00:43', 0, 0),
(4, 0, '', 'Stripe', '', '', '', '', '', 'Quebec', 'Canada', '', '', '', '', '', '', '', 0, '', '2023-04-08 06:49:00', '', '', '', 'fr', '2023-04-08 06:49:00', '2023-04-08 06:49:00', 0, 0),
(5, 0, '', 'SMS.to', '', '', '', '', '', 'Quebec', 'Canada', '', '', '', '', '', '', '', 0, '', '2023-04-08 06:49:19', '', '', '', 'fr', '2023-04-08 06:49:19', '2023-04-08 06:49:19', 0, 0),
(6, 0, '', 'Google', '', '', '', '', '', 'Quebec', 'Canada', '', '', '', '', '', '', '', 0, '', '2023-04-08 06:49:44', '', '', '', 'FR', '2023-04-08 06:49:44', '2023-04-08 07:21:26', 0, 0),
(7, 0, '', 'Poste Canada', '', '', '', '', '', 'Quebec', 'Canada', '', '', '', '', '', '', '', 0, '', '2023-04-08 06:50:57', '', '', '', 'fr', '2023-04-08 06:50:57', '2023-04-08 06:50:57', 0, 0),
(8, 0, '', 'Bell Canada', '', '', '', '', '', 'Quebec', 'Canada', '', '', '', '', '', '', '', 0, '', '2023-04-08 06:51:12', '', '', '', 'fr', '2023-04-08 06:51:12', '2023-04-08 06:51:12', 0, 0);

CREATE TABLE `supply` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `supplier_product_code` varchar(30) NOT NULL DEFAULT '',
  `storage_id` int(11) NOT NULL DEFAULT 0,
  `name_fr` varchar(256) NOT NULL DEFAULT '',
  `name_en` varchar(256) NOT NULL DEFAULT '',
  `supply_type` varchar(20) NOT NULL DEFAULT 'BOX' COMMENT 'BOX,ENVELOPE,CRATE..',
  `depth` decimal(7,3) NOT NULL DEFAULT 0.000,
  `width` decimal(7,3) NOT NULL DEFAULT 0.000,
  `height` decimal(7,3) NOT NULL DEFAULT 0.000,
  `weight` decimal(7,3) NOT NULL DEFAULT 0.000,
  `qty` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `task_head` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `position_id` int(11) NOT NULL DEFAULT 0,
  `periodic` tinyint(1) NOT NULL DEFAULT 0,
  `period_duration` int(11) NOT NULL DEFAULT 0,
  `period_type` varchar(32) NOT NULL DEFAULT 'UNIQUE',
  `href` text NOT NULL DEFAULT '',
  `action` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `task_line` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL,
  `date_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_done` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `stat` int(2) NOT NULL DEFAULT 0,
  `note` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `payment_type` varchar(20) NOT NULL DEFAULT 'CASH',
  `invoice_id` int(11) DEFAULT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_number` varchar(50) NOT NULL,
  `item_price` float(10,2) NOT NULL,
  `item_price_currency` varchar(10) NOT NULL,
  `paid_amount` float(10,2) NOT NULL,
  `paid_amount_currency` varchar(10) NOT NULL,
  `txn_id` varchar(50) NOT NULL,
  `payment_status` varchar(25) NOT NULL,
  `stripe_checkout_session_id` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `transfer` (
  `id` int(11) NOT NULL,
  `kind` varchar(10) NOT NULL DEFAULT 'MOVE',
  `product_id` int(11) NOT NULL DEFAULT 0,
  `lot_no` varchar(64) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `purchase_id` int(11) NOT NULL DEFAULT 0,
  `storage_id` int(11) NOT NULL DEFAULT 0,
  `quantity` float NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `stat` int(2) NOT NULL DEFAULT 0,
  `salary` decimal(7,2) NOT NULL DEFAULT 0.00,
  `auth` varchar(8) NOT NULL DEFAULT 'USR',
  `inactive_minutes` int(5) NOT NULL DEFAULT 5,
  `name` varchar(32) NOT NULL DEFAULT '',
  `pw` varchar(128) NOT NULL,
  `login_attempt` int(3) NOT NULL DEFAULT 0,
  `type` varchar(32) NOT NULL DEFAULT '',
  `location_id` int(11) NOT NULL DEFAULT 0,
  `position_id` int(11) NOT NULL DEFAULT 0,
  `app_id` int(11) NOT NULL DEFAULT 1,
  `road_id` int(11) NOT NULL DEFAULT 0,
  `schedule_id` int(11) NOT NULL DEFAULT 0,
  `picture_type` varchar(20) NOT NULL DEFAULT 'AVATAR',
  `picture_url` varchar(256) NOT NULL DEFAULT '',
  `eml1` varchar(256) NOT NULL,
  `eml2` varchar(256) NOT NULL,
  `eml3` varchar(256) NOT NULL,
  `news_stat` tinyint(1) NOT NULL DEFAULT 0,
  `first_name` varchar(64) NOT NULL DEFAULT '',
  `middle_name` varchar(64) NOT NULL DEFAULT '',
  `last_name` varchar(64) NOT NULL DEFAULT '',
  `prefix` varchar(32) NOT NULL DEFAULT '',
  `suffix` varchar(16) NOT NULL DEFAULT '',
  `adr1` varchar(128) NOT NULL DEFAULT '',
  `adr2` varchar(64) NOT NULL DEFAULT '',
  `city` varchar(64) NOT NULL DEFAULT '',
  `province` varchar(64) NOT NULL DEFAULT 'Quebec',
  `country` varchar(64) NOT NULL DEFAULT 'Canada',
  `postal_code` varchar(16) NOT NULL DEFAULT '',
  `tel1` varchar(16) NOT NULL DEFAULT '',
  `tel2` varchar(16) NOT NULL DEFAULT '',
  `longitude` float NOT NULL DEFAULT 0,
  `latitude` float NOT NULL DEFAULT 0,
  `sms_stat` tinyint(1) NOT NULL DEFAULT 0,
  `sms_rdv` tinyint(1) NOT NULL DEFAULT 0,
  `key_128` varchar(128) NOT NULL DEFAULT '',
  `key_expire` timestamp NOT NULL DEFAULT current_timestamp(),
  `key_reset` varchar(128) NOT NULL DEFAULT '',
  `note` text NOT NULL DEFAULT '',
  `lang` varchar(2) NOT NULL DEFAULT 'fr',
  `timezone_offset` varchar(6) NOT NULL DEFAULT '-05:00',
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `msg_rdv` text NOT NULL DEFAULT '',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` int(11) NOT NULL DEFAULT 0,
  `user_modified` int(11) NOT NULL DEFAULT 0,
  `crypted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `user` (`id`, `stat`, `salary`, `auth`, `inactive_minutes`, `name`, `pw`, `login_attempt`, `type`, `location_id`, `position_id`, `app_id`, `road_id`, `schedule_id`, `picture_type`, `picture_url`, `eml1`, `eml2`, `eml3`, `news_stat`, `first_name`, `middle_name`, `last_name`, `prefix`, `suffix`, `adr1`, `adr2`, `city`, `province`, `country`, `postal_code`, `tel1`, `tel2`, `longitude`, `latitude`, `sms_stat`, `sms_rdv`, `key_128`, `key_expire`, `key_reset`, `note`, `lang`, `timezone_offset`, `gender`, `msg_rdv`, `date_created`, `date_modified`, `user_created`, `user_modified`, `crypted`) VALUES
(0, 0, 0.00, 'GES', 120, 'Dev', 'DesignWeb3D', 0, '', 1, 5, 3, 0, 0, 'AVATAR', '', 'info@dw3.ca', '', 'info@dw3.ca', 0, '', '', 'Dev', '', '', '', '', '', 'QC', 'Canada', '', '', '', 0, 0, 0, 0, 'cgg2T3ybckZABtN6E9XHCJd6Bkvq7MlwKww7THyDqXkUy9Q32X3gFsfGsMpBwfzfC7lNT7d1O9qgidOy6jW4pUBiqia9OlL6ipOSr9QRKZ9c4AZVgdJDjoJam9gGSohd', '2025-11-11 18:59:01', '', '', 'FR', '-05:00', 0, '', '2023-03-02 11:44:57', '2023-03-02 11:44:57', 0, 0, 0);

CREATE TABLE `user_service` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `is_public` int(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `user_service` (`id`, `user_id`, `product_id`, `is_public`, `date_created`) VALUES
(1, 0, 1078, 1, '2024-02-26 13:13:02'),
(2, 0, 1077, 1, '2024-02-26 13:15:48'),
(5, 0, 1231, 1, '2025-08-08 10:30:40');

CREATE TABLE `user_time` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `position_id` int(11) NOT NULL DEFAULT 0,
  `date_from` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_to` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_comment` text NOT NULL DEFAULT '',
  `admin_comment` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `vehicule` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `longitude` float NOT NULL DEFAULT 0,
  `latitude` float NOT NULL DEFAULT 0,
  `model` varchar(32) NOT NULL DEFAULT '',
  `year` varchar(4) NOT NULL DEFAULT '',
  `note` text NOT NULL DEFAULT '',
  `value` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `zone` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT '',
  `longitude` float NOT NULL DEFAULT 0,
  `latitude` float NOT NULL DEFAULT 0,
  `shape` text NOT NULL DEFAULT '',
  `parent_type` varchar(20) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `affiliate`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `app`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `app_prm`
  ADD PRIMARY KEY (`app_id`,`user_id`,`name`);

ALTER TABLE `app_user`
  ADD PRIMARY KEY (`app_id`,`user_id`);

ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `article_comment`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `attribution`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `budget`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cart_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cart_option`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `classified`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `concurent`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `config`
  ADD PRIMARY KEY (`kind`,`code`);

ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customer_app`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customer_discount`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `diffusion_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `diffusion_line`
  ADD PRIMARY KEY (`head_id`,`customer_id`);

ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `gl`
  ADD PRIMARY KEY (`code`);

ALTER TABLE `gls`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `historic`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `index_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `index_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `invoice_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `invoice_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `option`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_option`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `procedure_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `procedure_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `production`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_gl`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_option`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_option_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_pack`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `prototype_data`
  ADD PRIMARY KEY (`head_id`,`line_id`,`parent_id`,`report_id`);

ALTER TABLE `prototype_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `prototype_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `prototype_report`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `purchase_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `purchase_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `realisation`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `road_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `road_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `road_user`
  ADD PRIMARY KEY (`road_id`,`user_id`);

ALTER TABLE `scene`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `schedule_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `schedule_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `shipment_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `slideshow`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `supply`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `task_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `task_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transfer`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_service`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_time`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `zone`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `affiliate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=333;

ALTER TABLE `app_user`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `article_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `attribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

ALTER TABLE `budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cart_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cart_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `classified`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `concurent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `customer_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `customer_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `diffusion_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `gls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `historic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `index_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

ALTER TABLE `index_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inventory`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `invoice_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

ALTER TABLE `invoice_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

ALTER TABLE `option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `order_head`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

ALTER TABLE `order_line`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

ALTER TABLE `order_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `procedure_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `procedure_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1500;

ALTER TABLE `production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

ALTER TABLE `product_gl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_option_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_pack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `prototype_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `prototype_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

ALTER TABLE `prototype_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1500;

ALTER TABLE `purchase_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

ALTER TABLE `purchase_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `realisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `road_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

ALTER TABLE `road_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `scene`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `schedule_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `schedule_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `shipment_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `slideshow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `supply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `task_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `task_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

ALTER TABLE `transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `user_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `user_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `vehicule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
