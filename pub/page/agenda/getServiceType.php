<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

if(isset($_COOKIE["LANG"])) { 
    $USER_LANG = $_COOKIE["LANG"];
} else {
    $USER_LANG  = "FR";
}

$user_id  = mysqli_real_escape_string($dw3_conn, $_GET['U']);
$product_id  = mysqli_real_escape_string($dw3_conn, $_GET['P']??'0');
    $sql2 = "SELECT * FROM product WHERE web_dsp='1' AND is_scheduled = '1' AND stat=0 AND id IN (SELECT product_id FROM user_service WHERE user_id = '".$user_id."') ORDER BY category_id LIMIT 100";
        $result2 = $dw3_conn->query($sql2);
        if ($result2->num_rows > 0) {	
            if ($USER_LANG == "FR"){
                echo "<h2 style='text-align:left;padding-top:10px;'>Choisir le service:</h2>";	
            } else {
                echo "<h2 style='text-align:left;padding-top:10px;'>Choose the service:</h2>";	
            }
            while($row2 = $result2->fetch_assoc()) {
                $filenames = []; //asort(dw3_dir_to_array($_SERVER['DOCUMENT_ROOT'] ."/product/" .$row["id"] . "/"));
                $folder=scandir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" .$row2["id"] . "/");
                foreach($folder as $file) {
                    if (!is_dir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $file) && $file != "." && $file != ".."){
                        $filenames[] = $file;
                    }
                }
                $filename= $row2["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row2["id"] . "/" . $filename)){
                    $filename = "/pub/img/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row2["id"] . "/" . $filename)){
                        $filename = "/pub/img/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row2["id"] . "/" . $filename;
                    }
                }
                if ($USER_LANG == "FR"){
                    echo "<div class='dw3_box' onclick=\"document.getElementById('product_".$row2["id"]."').checked = true;dw3_set_dispo('".floor($row2["service_length"]+$row2["inter_length"])."')\" style='background:#fff;color:#333;width:auto;padding:10px;min-height:50px;text-align:center;cursor:pointer;'><input style='cursor:pointer;' name='prd' id='product_".$row2["id"]."' type='radio' value='".$row2["id"]."'"; if ( $product_id == $row2["id"]){echo ' checked';} echo "><label for='product_".$row2["id"]."' style='cursor:pointer;'> <img src='".$filename."?t=" . rand(100,100000)."' style='width:150px;height:auto;border-radius:4px;margin-bottom: 10px;'><br>".$row2["name_fr"]."</label></div>";
                }else{
                    echo "<div class='dw3_box' onclick=\"document.getElementById('product_".$row2["id"]."').checked = true;dw3_set_dispo('".floor($row2["service_length"]+$row2["inter_length"])."')\" style='background:#fff;color:#333;width:auto;padding:10px;min-height:50px;text-align:center;cursor:pointer;'><input style='cursor:pointer;' name='prd' id='product_".$row2["id"]."' type='radio' value='".$row2["id"]."'"; if ( $product_id == $row2["id"]){echo ' checked';} echo "><label for='product_".$row2["id"]."' style='cursor:pointer;'> <img src='".$filename."?t=" . rand(100,100000)."' style='width:150px;height:auto;border-radius:4px;margin-bottom: 10px;'><br>".$row2["name_en"]."</label></div>";
                }
            }
        }

?>    