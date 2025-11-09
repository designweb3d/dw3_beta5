<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$index_id   = $_GET['ID'];
		
	$sql = "SELECT * FROM slideshow WHERE index_id = '" . $index_id . "' ORDER BY sort_by ASC, id ASC;";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
            echo "<div class='divBOX' style='vertical-align:top;'><button onclick=\"delSLIDE('".$row["id"]."','".$index_id."');closeMSG();\" style='float:right;'> X </button>
             Ordre: <input style='width:50%;' type='text' value=\"".$row["sort_by"]."\" onblur=\"updSL_SORT('".$row["id"]."',this)\">
             <br>FR: <input style='width:80%;' type='text' value=\"".$row["name_fr"]."\" onblur=\"updSL_NAME('".$row["id"]."',this)\">
             <hr>EN: <input style='width:80%;' type='text' value=\"".$row["name_en"]."\" onblur=\"updSL_NAME_EN('".$row["id"]."',this)\">
             <hr>url:<input style='width:80%;' type='text' value=\"".$row["media_url"]."\" onblur=\"updSL_URL('".$row["id"]."',this)\">";
            if ($row["media_type"] == "image"){
                echo "<img src='".$row["media_link"]."' style='height:auto;width:320px;border:1px solid black;margin:0px 3px;'>";
            } else if ($row["media_type"] == "video"){
                echo "<video width='320' height='240' controls><source src='".$row["media_link"]."' type='video/mp4'></video>";
            }
            echo "<div>".$row["media_link"] . "</div>";
            $file = $_SERVER['DOCUMENT_ROOT'] . "/" . $row["media_link"];
            if (filesize($file) <= 1024){ 
                echo "<div><u>Size:</u> <b>" . filesize($file) . " bytes</b></div>";
            }else if (filesize($file) >= 1048576){
                echo "<div><u>Size:</u> <b>" . round((filesize($file)/1024)/1024,2) . "MB</b></div>";
            }
            else if (filesize($file) >= 1073741824){
                echo "<div><u>Size:</u> <b>" . round((filesize($file)/1024)/1024/1024,2) . "GB</b></div>";
            } else {
                echo "<div><u>Size:</u> <b>" . round(filesize($file)/1024) . "KB</b></div>";
            }
            list($width, $height) = getimagesize($file);
            if($width !== false){
               echo"<div><u>Width:</u> <b>" . $width . " pixels</b></div>";
               echo"<div><u>Height:</u> <b>" . $height . " pixels</b></div>";
            }
            echo"<div><u>Last modified:</u> <b>" . date("Y-m-d", filemtime($file)) . "</b></div>";
            echo "</div>";
        }
    }

$dw3_conn->close();
?>