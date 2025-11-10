<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/js/Multiavatar.php';
 $multiavatar = new Multiavatar();
date_default_timezone_set('America/New_York');
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

if(isset($_COOKIE["LANG"])) { 
    $USER_LANG = $_COOKIE["LANG"];
} else {
    $USER_LANG  = "FR";
}

$result = $dw3_conn->query("SELECT DISTINCT user_id as user_id, location_id FROM schedule_head WHERE is_public = 1");
$row_count_user = $result->num_rows;

$service_type  = mysqli_real_escape_string($dw3_conn, $_GET['T']);
if($service_type == "V"){ $col_req = " virtual_enable = 1 "; }
else if($service_type == "R"){ $col_req = " road_enable = 1 "; }
else if($service_type == "L"){ $col_req = " local_enable = 1 "; }
else if($service_type == "P"){ $col_req = " phone_enable = 1 "; }
else { $col_req = " local_enabled = 1 "; }

    $sql2 = "SELECT A.*, B.adr1 as loc_adr1, B.adr2 as loc_adr2, B.city as loc_city, B.name as loc_name FROM user A
        LEFT JOIN (SELECT * FROM location) B ON A.location_id = B.id
    WHERE A.id IN (SELECT user_id FROM schedule_head WHERE is_public = 1 AND ".$col_req.")
    AND A.stat = 0";
        $result2 = $dw3_conn->query($sql2);
        if ($result2->num_rows > 0) {
            if ($USER_LANG == "FR"){
                echo "<h2 style='text-align:left;'>Choisir le personel:</h2>";	
            } else {
                echo "<h2 style='text-align:left;'>Choose the staff:</h2>";	
            }
            while($row2 = $result2->fetch_assoc()) {
                echo "<div onmouseup=\"document.getElementById('service_user_".$row2["id"]."').checked = true;getServiceType('" . $row2["id"] . "','" . $row2["location_id"] . "');\" class='dw3_box' style='background:#fff;color:#333;width:auto;padding:10px;min-height:50px;text-align:center;max-width:250px;'>
                <input style='cursor:pointer;' name='service_user' id='service_user_".$row2["id"]."' type='radio' ";
                if ($result2->num_rows == 1 && $row_count_user == 1) { echo " checked ";}
                echo " value='".$row2["id"]."'><label for='service_user_".$row2["id"]."' style='cursor:pointer;'> ";
                    if ($row2["picture_type"] == "AVATAR"){
                        $avatarsvg = $multiavatar($row2["name"], null, null);
                        echo "<div style='width:149px;height:149px;border-radius:4px;display: inline-block;vertical-align:middle;margin-bottom: 10px;'>" . $avatarsvg . "</div>";
                    } else if ($row2["picture_type"] == "PHOTO"){
                        echo "<img src='/fs/user/" . $row2["id"] . ".png?t=".rand(1,9999999)."' style='width:150px;height:auto;border-radius:4px;display: inline-block;margin-bottom: 10px;' />";
                    } else if ($row2["picture_type"] == "PICTURE"){
                        echo "<img src='/pub/upload/" . $row2["picture_url"] . "?t=".rand(1,9999999)."' style='width:150px;height:auto;border-radius:4px;display: inline-block;margin-bottom: 10px;' />";
                    } else if ($row2["picture_type"] == "PICTURE2"){
                        echo "<img src='/pub/img/avatar/" . $row2["picture_url"] . "?t=".rand(1,9999999)."' style='width:150px;height:auto;border-radius:4px;display: inline-block;margin-bottom: 10px;' />";
                    }
                echo "<br>".$row2["first_name"];
                if($service_type == "L"){
                    echo "<br><b>".$row2["loc_name"]."</b> (".$row2["loc_city"].")";
                }
                echo "</label></div>";
            }
        }

?>