<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$LID = $_GET['LID'];

$sql = "SELECT * FROM prototype_line WHERE id = '".$LID."' LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($USER_LANG == "FR"){
            $line_name = $row["name_fr"];
            $button_close = "Fermer";
            $line_c1 = $row["choice_name1"];
            $line_c2 = $row["choice_name2"];
            $line_c3 = $row["choice_name3"];
            $line_c4 = $row["choice_name4"];
            $line_c5 = $row["choice_name5"];
            $line_c6 = $row["choice_name6"];
            $line_c7 = $row["choice_name7"];
            $line_c8 = $row["choice_name8"];
            $line_c9 = $row["choice_name9"];
            $line_c0 = $row["choice_name0"];
        } else {
            $line_name = $row["name_en"];
            $button_close = "Close";
            $line_c1 = $row["choice_name1_en"];
            $line_c2 = $row["choice_name2_en"];
            $line_c3 = $row["choice_name3_en"];
            $line_c4 = $row["choice_name4_en"];
            $line_c5 = $row["choice_name5_en"];
            $line_c6 = $row["choice_name6_en"];
            $line_c7 = $row["choice_name7_en"];
            $line_c8 = $row["choice_name8_en"];
            $line_c9 = $row["choice_name9_en"];
            $line_c0 = $row["choice_name0_en"];
        }
        echo "<h4 style='margin-top:-5px;margin-left:-5px;padding-right:25px;'>".$line_name."</h4><div style='height:15px;'> </div>";
        if ($row["choice_img1"]!="" && $line_c1 != ""){echo "<button onclick=\"choosedImage('".$LID."','".$line_c1."')\" class='no-effect' style=\"background-image: url('/pub/upload/".$row["choice_img1"]."');background-repeat: no-repeat;background-position: center;background-size: cover;width:150px;height:150px;\"><span style='position: absolute;top: 0px;left:0px;right:0px;padding:5px;border-top-right-radius:var(--dw3_button_radius);border-top-left-radius:var(--dw3_button_radius);color:#222;text-shadow:0px 0px 3px #eee;background:rgba(255,255,255,0.75)'>".$line_c1."</span></button>";}
        if ($row["choice_img2"]!="" && $line_c2 != ""){echo "<button onclick=\"choosedImage('".$LID."','".$line_c2."')\" class='no-effect' style=\"background-image: url('/pub/upload/".$row["choice_img2"]."');background-repeat: no-repeat;background-position: center;background-size: cover;width:150px;height:150px;\"><span style='position: absolute;top: 0px;left:0px;right:0px;padding:5px;border-top-right-radius:var(--dw3_button_radius);border-top-left-radius:var(--dw3_button_radius);color:#222;text-shadow:0px 0px 3px #eee;background:rgba(255,255,255,0.75)'>".$line_c2."</span></button>";}
        if ($row["choice_img3"]!="" && $line_c3 != ""){echo "<button onclick=\"choosedImage('".$LID."','".$line_c3."')\" class='no-effect' style=\"background-image: url('/pub/upload/".$row["choice_img3"]."');background-repeat: no-repeat;background-position: center;background-size: cover;width:150px;height:150px;\"><span style='position: absolute;top: 0px;left:0px;right:0px;padding:5px;border-top-right-radius:var(--dw3_button_radius);border-top-left-radius:var(--dw3_button_radius);color:#222;text-shadow:0px 0px 3px #eee;background:rgba(255,255,255,0.75)'>".$line_c3."</span></button>";}
        if ($row["choice_img4"]!="" && $line_c4 != ""){echo "<button onclick=\"choosedImage('".$LID."','".$line_c4."')\" class='no-effect' style=\"background-image: url('/pub/upload/".$row["choice_img4"]."');background-repeat: no-repeat;background-position: center;background-size: cover;width:150px;height:150px;\"><span style='position: absolute;top: 0px;left:0px;right:0px;padding:5px;border-top-right-radius:var(--dw3_button_radius);border-top-left-radius:var(--dw3_button_radius);color:#222;text-shadow:0px 0px 3px #eee;background:rgba(255,255,255,0.75)'>".$line_c4."</span></button>";}
        if ($row["choice_img5"]!="" && $line_c5 != ""){echo "<button onclick=\"choosedImage('".$LID."','".$line_c5."')\" class='no-effect' style=\"background-image: url('/pub/upload/".$row["choice_img5"]."');background-repeat: no-repeat;background-position: center;background-size: cover;width:150px;height:150px;\"><span style='position: absolute;top: 0px;left:0px;right:0px;padding:5px;border-top-right-radius:var(--dw3_button_radius);border-top-left-radius:var(--dw3_button_radius);color:#222;text-shadow:0px 0px 3px #eee;background:rgba(255,255,255,0.75)'>".$line_c5."</span></button>";}
        if ($row["choice_img6"]!="" && $line_c6 != ""){echo "<button onclick=\"choosedImage('".$LID."','".$line_c6."')\" class='no-effect' style=\"background-image: url('/pub/upload/".$row["choice_img6"]."');background-repeat: no-repeat;background-position: center;background-size: cover;width:150px;height:150px;\"><span style='position: absolute;top: 0px;left:0px;right:0px;padding:5px;border-top-right-radius:var(--dw3_button_radius);border-top-left-radius:var(--dw3_button_radius);color:#222;text-shadow:0px 0px 3px #eee;background:rgba(255,255,255,0.75)'>".$line_c6."</span></button>";}
        if ($row["choice_img7"]!="" && $line_c7 != ""){echo "<button onclick=\"choosedImage('".$LID."','".$line_c7."')\" class='no-effect' style=\"background-image: url('/pub/upload/".$row["choice_img7"]."');background-repeat: no-repeat;background-position: center;background-size: cover;width:150px;height:150px;\"><span style='position: absolute;top: 0px;left:0px;right:0px;padding:5px;border-top-right-radius:var(--dw3_button_radius);border-top-left-radius:var(--dw3_button_radius);color:#222;text-shadow:0px 0px 3px #eee;background:rgba(255,255,255,0.75)'>".$line_c7."</span></button>";}
        if ($row["choice_img8"]!="" && $line_c8 != ""){echo "<button onclick=\"choosedImage('".$LID."','".$line_c8."')\" class='no-effect' style=\"background-image: url('/pub/upload/".$row["choice_img8"]."');background-repeat: no-repeat;background-position: center;background-size: cover;width:150px;height:150px;\"><span style='position: absolute;top: 0px;left:0px;right:0px;padding:5px;border-top-right-radius:var(--dw3_button_radius);border-top-left-radius:var(--dw3_button_radius);color:#222;text-shadow:0px 0px 3px #eee;background:rgba(255,255,255,0.75)'>".$line_c8."</span></button>";}
        if ($row["choice_img9"]!="" && $line_c9 != ""){echo "<button onclick=\"choosedImage('".$LID."','".$line_c9."')\" class='no-effect' style=\"background-image: url('/pub/upload/".$row["choice_img9"]."');background-repeat: no-repeat;background-position: center;background-size: cover;width:150px;height:150px;\"><span style='position: absolute;top: 0px;left:0px;right:0px;padding:5px;border-top-right-radius:var(--dw3_button_radius);border-top-left-radius:var(--dw3_button_radius);color:#222;text-shadow:0px 0px 3px #eee;background:rgba(255,255,255,0.75)'>".$line_c9."</span></button>";}
        if ($row["choice_img0"]!="" && $line_c0 != ""){echo "<button onclick=\"choosedImage('".$LID."','".$line_c0."')\" class='no-effect' style=\"background-image: url('/pub/upload/".$row["choice_img0"]."');background-repeat: no-repeat;background-position: center;background-size: cover;width:150px;height:150px;\"><span style='position: absolute;top: 0px;left:0px;right:0px;padding:5px;border-top-right-radius:var(--dw3_button_radius);border-top-left-radius:var(--dw3_button_radius);color:#222;text-shadow:0px 0px 3px #eee;background:rgba(255,255,255,0.75)'>".$line_c0."</span></button>";}
        echo "<button onclick='dw3_editor_close();' style='position:absolute;top:5px;right:5px;padding:5px 4px 3px 5px;border-radius: 16px;' class='no-effect grey'><span class='dw3_font' style='vertical-align:middle;'>ď</span></button>";
        
    }
}
$dw3_conn->close();
?>