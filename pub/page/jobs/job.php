<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$JOB_ID = $_GET['ID']??'';
if ($JOB_ID == ""){
    header("HTTP/1.0 404 Not Found");
    //require_once($_SERVER['DOCUMENT_ROOT'] ."/sbin/error.php?e=401");
    exit;
}

$sql = "SELECT A.*, B.adr1 AS loc_adr1, B.city AS loc_city, B.province AS loc_prov, B.postal_code AS loc_cp FROM position A
LEFT JOIN (SELECT * FROM location) B ON B.id = A.location_id
WHERE A.id='".$JOB_ID."' LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows == 0) {
    header("HTTP/1.0 404 Not Found");
    //require_once($_SERVER['DOCUMENT_ROOT'] ."/sbin/error.php?e=401");
    exit;
} else {
    while($row = $result->fetch_assoc()) {
        if($today > $row["date_end_post"] || $row["active"] == "0"){
            header("HTTP/1.0 404 Not Found");
            //require_once($_SERVER['DOCUMENT_ROOT'] ."/sbin/error.php?e=401");
            exit;
        }
        echo '<html lang="fr"><head><title>'.$row["name"]. " - " . $CIE_NOM.'</title><script type="application/ld+json">';
        echo '{
        "@context" : "https://schema.org/",
        "@type" : "JobPosting",
        "title" : "'.$row["name"].'",
        "description" : "<p>'.$row["description"].'</p>",
        "identifier": {
        "@type": "PropertyValue",
        "name": "'.$CIE_NOM.'",
        "value": "'.$row["id"].'"
        },
        "datePosted" : "'.$row["date_created"].'",
        "validThrough" : "'.$row["date_end_post"].'T00:00",';
        echo '"employmentType" : [';
        $job_type = "";
        if ($row["full_time"] == "1"){ $job_type .= '"FULL_TIME",';}
        if ($row["part_time"] == "1"){ $job_type .= '"PART_TIME",';}
        if ($row["contractor"] == "1"){ $job_type .= '"CONTRACTOR",';}
        if ($row["temporary"] == "1"){ $job_type .= '"TEMPORARY",';}
        if ($row["intern"] == "1"){ $job_type .= '"INTERN",';}
        if ($row["volunteer"] == "1"){ $job_type .= '"VOLUNTEER",';}
        if ($row["per_diem"] == "1"){ $job_type .= '"PER_DIEM",';}
        if ($row["other"] == "1"){ $job_type .= '"OTHER",';}
        echo rtrim($job_type,",") . '],
        "hiringOrganization" : {
        "@type" : "Organization",
        "name" : "'.$CIE_NOM.'",
        "sameAs" : "https://'.$_SERVER["SERVER_NAME"].'",
        "logo" : "https://'.$_SERVER["SERVER_NAME"].'/favicon.png"
        },';
        if ($row["telecommute"] == "1"){
            echo '"jobLocationType": "TELECOMMUTE",';
            echo '"applicantLocationRequirements": {
                    "@type": "Country",
                    "name": "CA"
                    },';
        } else if ($row["telecommute"] == "2"){
            echo '"jobLocationType": "TELECOMMUTE",';
            echo '"jobLocation": {
                "@type": "Place",
                "address": {
                "@type": "PostalAddress",
                "streetAddress": "'.$row["loc_adr1"].'",
                "addressLocality": "'.$row["loc_city"].'",
                "addressRegion": "'.$row["loc_prov"].'",
                "postalCode": "'.$row["loc_cp"].'",
                "addressCountry": "CA"
                }
                },';
        } else {
            echo '"jobLocation": {
                "@type": "Place",
                "address": {
                "@type": "PostalAddress",
                "streetAddress": "'.$row["loc_adr1"].'",
                "addressLocality": "'.$row["loc_city"].'",
                "addressRegion": "'.$row["loc_prov"].'",
                "postalCode": "'.$row["loc_cp"].'",
                "addressCountry": "CA"
                }
                },';
        }
        echo '"baseSalary": {
        "@type": "MonetaryAmount",
        "currency": "CAD",
        "value": {
            "@type": "QuantitativeValue",
            "value": '.$row["salary_min"].',
            "unitText": "'.$row["salary_type"].'"
        }
        }
    }';
    echo "</script><style>";
    
    include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/index.css.php';

    ?>
    .tblJOB {
        width:100%;
        margin:0px;
        background: rgba(255, 255, 255, 0.1);
        white-space:nowrap;
        border-collapse: collapse;
        font-family:  var(--dw3_form_font);
        line-height: 1;
    }
    .tblJOB td{
        text-align:left;
        border-bottom: 1px solid #999;
        padding: 8px;
        color: #333333;
        overflow:hidden;
    }
    .tblJOB th{
        text-align:left;
        vertical-align:top;
        padding: 8px 8px 6px 8px;
        user-select:none;	
        background: linear-gradient(180deg, var(--dw3_head_background), var(--dw3_head_background2));
        color:  var(--dw3_head_color);
        position: sticky;
        top: 0; /* Don't forget this, required for the stickiness */
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        /* text-shadow: 0px 0px 2px #222; */
    }
    .tblJOB tr:nth-child(even){background-color: var(--dw3_line_background);}
    .tblJOB tr:nth-child(odd){background-color: var(--dw3_line_background2);}

    </style>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0" />
        <link rel="apple-touch-icon" sizes="180x180" href="/pub/img/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/pub/img/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/pub/img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/pub/img/favicon-16x16.png">
        <link rel="icon" type="image/svg+xml" href="/pub/img/favicon.svg">
        <link rel="shortcut icon" href="/pub/img/favicon.ico">
    <?php 
    echo "</head><body>";
    echo "<div style='width:100%;text-align:center;margin:10px 0px;'><a href='/'><span style='font-size:32px;color:var(--dw3_head_color);text-shadow:0px 0px 4px var(--dw3_head_color);background-image:linear-gradient(to bottom,transparent,var(--dw3_head_background),var(--dw3_head_background),transparent);padding:15px 25px;border-right:3px solid var(--dw3_head_color);border-left:3px solid var(--dw3_head_color);'><img src='/favicon.png' style='width:32px;height:32px;'> ".$CIE_NOM."</span></a></div>";
    echo "<div style='width:100%;text-align:center;'>
            <div style='display:inline-block;width:97%;max-width:800px;border-radius:5px;box-shadow:1px 1px 4px 2px grey;background:var(--dw3_line_background);color:#333;'>
            <h1>".$row["name"]."</h1><table class='tblJOB' style='white-space: wrap;font-size:1em;margin:15px 0px;'>";
    echo "<tr><th>Date de publication</th><td>".$row["date_created"]."</td></tr>";
    //echo "<tr><th>Titre du poste</th><td>".$row["name"]."</td></tr>";
    echo "<tr><th>Description du poste</th><td>".$row["description"]."</td></tr>";
    echo "<tr><th>Lieu</th><td>";
        if ($row["telecommute"] == "0"){echo "Sur Place <div style='display:inline-block;float:right;'>".$row["loc_city"].", ".$row["loc_prov"].", ".$row["loc_cp"]."</div>";}
        if ($row["telecommute"] == "1"){echo "Télétravail";}
        if ($row["telecommute"] == "2"){echo "Télétravail & Sur Place <div style='display:inline-block;float:right;'>".$row["loc_city"].", ".$row["loc_prov"].", ".$row["loc_cp"]."</div>";}
    echo "</td></tr>";
    echo "<tr><th>Type de travail</th><td>";
    $job_type = "";
    if ($row["full_time"] == "1"){ $job_type .= 'Temps plein,';}
    if ($row["part_time"] == "1"){ $job_type .= ' Temps partiel,';}
    if ($row["contractor"] == "1"){ $job_type .= ' Contractuel,';}
    if ($row["temporary"] == "1"){ $job_type .= ' Temporaire,';}
    if ($row["intern"] == "1"){ $job_type .= ' Stage,';}
    if ($row["volunteer"] == "1"){ $job_type .= ' Bénévole,';}
    if ($row["per_diem"] == "1"){ $job_type .= ' Payé à la journée,';}
    if ($row["other"] == "1"){ $job_type .= ' Autre,';}
    echo rtrim($job_type,",");
    echo "</td></tr>";
    echo "<tr><th>Salaire de base</th><td>".$row["salary_min"]." / ";
        if ($row["salary_type"]=="HOUR"){ echo "heure";}
        if ($row["salary_type"]=="DAY"){ echo "jour";}
        if ($row["salary_type"]=="WEEK"){ echo "semaine";}
        if ($row["salary_type"]=="MONTH"){ echo "mois";}
        if ($row["salary_type"]=="YEAR"){ echo "année";}
    echo "</td></tr>";
    if ($row["responsibilities"] != ""){
        echo "<tr><th>Responsabilités</th><td>".$row["responsibilities"]."</td></tr>";
    }
    if ($row["skills"] != ""){
        echo "<tr><th>Habiletés</th><td>".$row["skills"]."</td></tr>";
    }
    if ($row["qualifications"] != ""){
        echo "<tr><th>Qualifications</th><td>".$row["qualifications"]."</td></tr>";
    }
    if ($row["education"] != ""){
        echo "<tr><th>Éducation</th><td>".$row["education"]."</td></tr>";
    }
    if ($row["experience"] != ""){
        echo "<tr><th>Expérience</th><td>".$row["experience"]."</td></tr>";
    }
    echo "</table><div style='height:20px;'> </div><a class='hover-style-1' href='/pub/page/jobs/index.php?PID=".$PAGE_ID."' style='padding:10px 15px 15px 15px;margin-right:15px;'><span class='material-icons'>undo</span> Sommaire </a> <a class='hover-style-3' href='/pub/page/quiz/index.php?ID=".$row["document_id"]."' style='padding:10px 15px 15px 15px;'><span class='material-icons'>work</span> Postuler </a><div style='height:20px;'> </div></div>";
    }
}
?></body></html>