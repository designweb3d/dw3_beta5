<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
    if 	($PAGE_FONT!=""){$font_family = "font-family:".$PAGE_FONT.";";} else {$font_family = "";}
echo "<div class='dw3_page' style='min-height:70vh;background:".$PAGE_BG.";color:".$PAGE_FG.";line-height:1;".$font_family."'>";
echo "<h2 style='padding:15px;background-color: var(--dw3_line_background);color:var(--dw3_line_color);'>".$PAGE_TITLE."</h2>";
$sql = "SELECT A.*, B.adr1 AS loc_adr1, B.city AS loc_city, B.province AS loc_prov, B.postal_code AS loc_cp FROM position A
LEFT JOIN (SELECT * FROM location) B ON B.id = A.location_id
WHERE A.active='1' AND A.date_end_post >= CURRENT_DATE();";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        //if($today <= $row["date_end_post"]){
            echo "<div style='margin:10px 0px;border-radius:5px;box-shadow:1px 1px 4px 2px grey;'>";
            echo "<table class='tblSIMPLE2'><tr><td style='width:50%;font-size:'><b>".$row["name"]."</b></td><td style='width:50%;'>";
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
            echo "</td><td rowspan=2 style='width:75px;background-color: var(--dw3_line_background)'><a class='hover-style-3' href='/pub/page/jobs/job.php?PID=".$PAGE_ID."&ID=".$row["id"]."' style='margin-top:-5px;padding:10px 15px 15px 15px;'> Détails </a></td>";
            echo "</tr><tr><td style='width:50%;'>";
            if ($row["telecommute"] == "0"){echo "Sur Place</td><td style='width:50%;'>".$row["loc_city"].", ".$row["loc_prov"].", ".$row["loc_cp"]."</td>";}
            if ($row["telecommute"] == "1"){echo "Télétravail<td style='width:50%;'>Canada</td>";}
            if ($row["telecommute"] == "2"){echo "Télétravail & Sur Place </td><td style='width:50%;'>".$row["loc_city"].", ".$row["loc_prov"].", ".$row["loc_cp"]."</td>";}
            echo "</td></tr></table></div>";        
        //}
    }
} else {
    if ($USER_LANG == "FR"){
        echo "<div class='dw3_box' style='text-align:center;min-height:0px;margin-top:40px;>Aucuns emplois disponible pour le moment.</div>";
    } else {
        echo "<div class='dw3_box' style='text-align:center;min-height:0px;margin-top:40px;'>No jobs  available at the moment.</div>";
    }
}

echo "</div>";

?>
<script>
//$(document).ready(function (){
    document.getElementById("dw3_body").innerHTML = "";
//});
</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
?>