<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$TYPE = $_GET['TYPE'];
$CAT = $_GET['CAT'];
$CTYPE = $_GET['CTYPE'];
$CCAT = $_GET['CCAT'];
$CAPERCU = $_GET['CAPERCU'];
$APERCU	= mysqli_real_escape_string($dw3_conn,$_GET['APERCU']);
$CONVENTION	= mysqli_real_escape_string($dw3_conn,$_GET['CONVENTION']);
$CIBLE	= mysqli_real_escape_string($dw3_conn,$_GET['CIBLE']);
$TERRITOIRE	= mysqli_real_escape_string($dw3_conn,$_GET['TERRITOIRE']);
$OCCASION	= mysqli_real_escape_string($dw3_conn,$_GET['OCCASION']);
$CONCURENTS	= mysqli_real_escape_string($dw3_conn,$_GET['CONCURENTS']);
$AVANTAGE_CONCUR	= mysqli_real_escape_string($dw3_conn,$_GET['AVANTAGE_CONCUR']);
$ESTIMATION_VENTES	= mysqli_real_escape_string($dw3_conn,$_GET['ESTIMATION_VENTES']);
$PRODUITS	= mysqli_real_escape_string($dw3_conn,$_GET['PRODUITS']);
$STRATEGIE	= mysqli_real_escape_string($dw3_conn,$_GET['STRATEGIE']);
$CANAUX	= mysqli_real_escape_string($dw3_conn,$_GET['CANAUX']);
$ACTIONS	= mysqli_real_escape_string($dw3_conn,$_GET['ACTIONS']);
$ESTIMATION_PUB	= mysqli_real_escape_string($dw3_conn,$_GET['ESTIMATION_PUB']);
$PRODUCTION	= mysqli_real_escape_string($dw3_conn,$_GET['PRODUCTION']);
$QUALITE	= mysqli_real_escape_string($dw3_conn,$_GET['QUALITE']);
$SOURCE	= mysqli_real_escape_string($dw3_conn,$_GET['SOURCE']);
$AMENAGEMENT	= mysqli_real_escape_string($dw3_conn,$_GET['AMENAGEMENT']);
$IMMOBILIER_AQUIS	= mysqli_real_escape_string($dw3_conn,$_GET['IMMOBILIER_AQUIS']);
$IMMOBILIER_REQUIS	= mysqli_real_escape_string($dw3_conn,$_GET['IMMOBILIER_REQUIS']);
$INVESTISSEMENT	= mysqli_real_escape_string($dw3_conn,$_GET['INVESTISSEMENT']);
$RECHERCHE	= mysqli_real_escape_string($dw3_conn,$_GET['RECHERCHE']);
$NORMES	= mysqli_real_escape_string($dw3_conn,$_GET['NORMES']);
$EMPLOIS	= mysqli_real_escape_string($dw3_conn,$_GET['EMPLOIS']);
$PARTENAIRES	= mysqli_real_escape_string($dw3_conn,$_GET['PARTENAIRES']);
$PERMIS_REQUIS	= mysqli_real_escape_string($dw3_conn,$_GET['PERMIS_REQUIS']);
$PERMIS_AQUIS	= mysqli_real_escape_string($dw3_conn,$_GET['PERMIS_AQUIS']);
$ENTENTES	= mysqli_real_escape_string($dw3_conn,$_GET['ENTENTES']);
$RH	= mysqli_real_escape_string($dw3_conn,$_GET['RH']);
$ESTIMATION_COUT	= mysqli_real_escape_string($dw3_conn,$_GET['ESTIMATION_COUT']);
$CAPITAL	= mysqli_real_escape_string($dw3_conn,$_GET['CAPITAL']);
$PRET_REQUIS	= mysqli_real_escape_string($dw3_conn,$_GET['PRET_REQUIS']);
$BILAN_ANTERIEUR	= mysqli_real_escape_string($dw3_conn,$_GET['BILAN_ANTERIEUR']);
$PREVISIONS	= mysqli_real_escape_string($dw3_conn,$_GET['PREVISIONS']);
$BUDGET	= mysqli_real_escape_string($dw3_conn,$_GET['BUDGET']);
$OFFRES	= mysqli_real_escape_string($dw3_conn,$_GET['OFFRES']);
$CAPITAL_RISQUE	= mysqli_real_escape_string($dw3_conn,$_GET['CAPITAL_RISQUE']);
$EMPRUNTS	= mysqli_real_escape_string($dw3_conn,$_GET['EMPRUNTS']);
$SUBVENTION	= mysqli_real_escape_string($dw3_conn,$_GET['SUBVENTION']);
$SCENARIO_OPTI	= mysqli_real_escape_string($dw3_conn,$_GET['SCENARIO_OPTI']);
$SCENARIO_PESS	= mysqli_real_escape_string($dw3_conn,$_GET['SCENARIO_PESS']);
$SCENARIO_PROB	= mysqli_real_escape_string($dw3_conn,$_GET['SCENARIO_PROB']);
$CONTAB_PASSE	= mysqli_real_escape_string($dw3_conn,$_GET['CONTAB_PASSE']);
$CONTAB_FUTUR	= mysqli_real_escape_string($dw3_conn,$_GET['CONTAB_FUTUR']);
$OUTILS	= mysqli_real_escape_string($dw3_conn,$_GET['OUTILS']);

	$sql = "INSERT INTO config
    (kind, code,text1,text2)
    VALUES 
        ('CIE', 'TYPE', '" . $TYPE  . "','" . $CTYPE  . "'),
        ('CIE', 'CAT', '" . $CAT  . "','" . $CCAT  . "'),
        ('PLAN', 'APERCU', '" . $APERCU  . "','" . $CAPERCU  . "'),
        ('PLAN', 'CONVENTION', '" . $CONVENTION  . "',''),
        ('PLAN', 'CIBLE', '" . $CIBLE  . "',''),
        ('PLAN', 'TERRITOIRE', '" . $TERRITOIRE  . "',''),
        ('PLAN', 'OCCASION', '" . $OCCASION  . "',''),
        ('PLAN', 'CONCURENTS', '" . $CONCURENTS  . "',''),
        ('PLAN', 'AVANTAGE_CONCUR', '" . $AVANTAGE_CONCUR  . "',''),
        ('PLAN', 'ESTIMATION_VENTES', '" . $ESTIMATION_VENTES  . "',''),
        ('PLAN', 'PRODUITS', '" . $PRODUITS  . "',''),
        ('PLAN', 'STRATEGIE', '" . $STRATEGIE  . "',''),
        ('PLAN', 'CANAUX', '" . $CANAUX  . "',''),
        ('PLAN', 'ACTIONS', '" . $ACTIONS  . "',''),
        ('PLAN', 'ESTIMATION_PUB', '" . $ESTIMATION_PUB  . "',''),
        ('PLAN', 'PRODUCTION', '" . $PRODUCTION  . "',''),
        ('PLAN', 'QUALITE', '" . $QUALITE  . "',''),
        ('PLAN', 'SOURCE', '" . $SOURCE  . "',''),
        ('PLAN', 'AMENAGEMENT', '" . $AMENAGEMENT  . "',''),
        ('PLAN', 'IMMOBILIER_AQUIS', '" . $IMMOBILIER_AQUIS  . "',''),
        ('PLAN', 'IMMOBILIER_REQUIS', '" . $IMMOBILIER_REQUIS  . "',''),
        ('PLAN', 'INVESTISSEMENT', '" . $INVESTISSEMENT  . "',''),
        ('PLAN', 'RECHERCHE', '" . $RECHERCHE  . "',''),
        ('PLAN', 'NORMES', '" . $NORMES  . "',''),
        ('PLAN', 'EMPLOIS', '" . $EMPLOIS  . "',''),
        ('PLAN', 'PARTENAIRES', '" . $PARTENAIRES  . "',''),
        ('PLAN', 'PERMIS_REQUIS', '" . $PERMIS_REQUIS  . "',''),
        ('PLAN', 'PERMIS_AQUIS', '" . $PERMIS_AQUIS  . "',''),
        ('PLAN', 'ENTENTES', '" . $ENTENTES  . "',''),
        ('PLAN', 'RH', '" . $RH  . "',''),
        ('PLAN', 'ESTIMATION_COUT', '" . $ESTIMATION_COUT  . "',''),
        ('PLAN', 'CAPITAL', '" . $CAPITAL  . "',''),
        ('PLAN', 'PRET_REQUIS', '" . $PRET_REQUIS  . "',''),
        ('PLAN', 'BILAN_ANTERIEUR', '" . $BILAN_ANTERIEUR  . "',''),
        ('PLAN', 'PREVISIONS', '" . $PREVISIONS  . "',''),
        ('PLAN', 'BUDGET', '" . $BUDGET  . "',''),
        ('PLAN', 'OFFRES', '" . $OFFRES  . "',''),
        ('PLAN', 'CAPITAL_RISQUE', '" . $CAPITAL_RISQUE  . "',''),
        ('PLAN', 'EMPRUNTS', '" . $EMPRUNTS  . "',''),
        ('PLAN', 'SUBVENTION', '" . $SUBVENTION  . "',''),
        ('PLAN', 'SCENARIO_OPTI', '" . $SCENARIO_OPTI  . "',''),
        ('PLAN', 'SCENARIO_PESS', '" . $SCENARIO_PESS  . "',''),
        ('PLAN', 'SCENARIO_PROB', '" . $SCENARIO_PROB  . "',''),
        ('PLAN', 'CONTAB_PASSE', '" . $CONTAB_PASSE  . "',''),
        ('PLAN', 'CONTAB_FUTUR', '" . $CONTAB_FUTUR  . "',''),
        ('PLAN', 'OUTILS', '" . $OUTILS  . "','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1), text2 = VALUES(text2);";
	if ($dw3_conn->query($sql) === TRUE) {
        header('Status: 200');
	    echo "Le plan d'affaire a été mis &#224; jour.";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>