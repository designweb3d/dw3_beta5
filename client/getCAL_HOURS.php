<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$day    = str_pad(intval($_GET['D']),2,"0",STR_PAD_LEFT);
$month  = str_pad(intval($_GET['M'])+1,2,"0",STR_PAD_LEFT);
$year   = $_GET['Y'];

$is_open = false;

$date_string = $year.'-'.$month.'-'.$day;
$date_object = new DateTime($date_string);
$day_of_week_number = $date_object->format('w');

echo "<br><h4>Choisir une heure de disponible pour le ".$date_string.":</h4>";

if ($day_of_week_number == "0"){
    if (intval(substr($CIE_OPEN_J0_H1,0,2)) != 0 && intval(substr($CIE_OPEN_J0_H2,0,2)) != 0){
        for ($i=intval(substr($CIE_OPEN_J0_H1,0,2)); $i < intval(substr($CIE_OPEN_J0_H2,0,2)); $i++) {
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','00')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":00</div>";
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','30')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":30</div>";
            $is_open = true;
        }
    }
}
if ($day_of_week_number == "1"){
    if (intval(substr($CIE_OPEN_J1_H1,0,2)) != 0 && intval(substr($CIE_OPEN_J1_H2,0,2)) != 0){
        for ($i=intval(substr($CIE_OPEN_J1_H1,0,2)); $i < intval(substr($CIE_OPEN_J1_H2,0,2)); $i++) {
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','00')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":00</div>";
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','30')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":30</div>";
            $is_open = true;
        }
    }
}
if ($day_of_week_number == "2"){
    if (intval(substr($CIE_OPEN_J2_H1,0,2)) != 0 && intval(substr($CIE_OPEN_J2_H2,0,2)) != 0){
        for ($i=intval(substr($CIE_OPEN_J2_H1,0,2)); $i < intval(substr($CIE_OPEN_J2_H2,0,2)); $i++) {
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','00')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":00</div>";
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','30')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":30</div>";
            $is_open = true;
        }
    }
}
if ($day_of_week_number == "3"){
    if (intval(substr($CIE_OPEN_J3_H1,0,2)) != 0 && intval(substr($CIE_OPEN_J3_H2,0,2)) != 0){
        for ($i=intval(substr($CIE_OPEN_J3_H1,0,2)); $i < intval(substr($CIE_OPEN_J3_H2,0,2)); $i++) {
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','00')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":00</div>";
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','30')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":30</div>";
            $is_open = true;
        }
    }
}
if ($day_of_week_number == "4"){
    if (intval(substr($CIE_OPEN_J4_H1,0,2)) != 0 && intval(substr($CIE_OPEN_J4_H2,0,2)) != 0){
        for ($i=intval(substr($CIE_OPEN_J4_H1,0,2)); $i < intval(substr($CIE_OPEN_J4_H2,0,2)); $i++) {
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','00')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":00</div>";
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','30')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":30</div>";
            $is_open = true;
        }
    }
}
if ($day_of_week_number == "5"){
    if (intval(substr($CIE_OPEN_J5_H1,0,2)) != 0 && intval(substr($CIE_OPEN_J5_H2,0,2)) != 0){
        for ($i=intval(substr($CIE_OPEN_J5_H1,0,2)); $i < intval(substr($CIE_OPEN_J5_H2,0,2)); $i++) {
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','00')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":00</div>";
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','30')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":30</div>";
            $is_open = true;
        }
    }
}
if ($day_of_week_number == "6"){
    if (intval(substr($CIE_OPEN_J6_H1,0,2)) != 0 && intval(substr($CIE_OPEN_J6_H2,0,2)) != 0){
        for ($i=intval(substr($CIE_OPEN_J6_H1,0,2)); $i < intval(substr($CIE_OPEN_J6_H2,0,2)); $i++) {
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','00')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":00</div>";
            echo "<div onclick=\"updCAL_HOUR('".$year."','".$month."','".$day."','".str_pad($i,2,"0",STR_PAD_LEFT)."','30')\" class='valid-day' style='cursor:pointer;display:inline-block;padding:10px;border:1px solid #ddd;'>".str_pad($i,2,"0",STR_PAD_LEFT).":30</div>";
            $is_open = true;
        }
    }
}

if ($is_open == false) { 
    echo "<div class='divBOX'>Aucunes disponibilités cette journée. Veuillez en choisir une autre.</div>";
}

$dw3_conn->close();
?>