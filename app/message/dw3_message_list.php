<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn,$_GET['SS']??""); //RECHERCHE 
$usID = $_GET['usID']??"";

$sql = "SELECT * FROM message WHERE user_from = '" . $usID . "' AND user_to = '" . $USER ."' OR user_from = '" . $USER . "' AND user_to = '" . $usID ."' ";
    $sql = $sql . "	ORDER BY date_time ";		
    $result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
    $html = ""; 
    if ($numrows > 0) {	
        while($row = $result->fetch_assoc()) {
            if ($row["user_from"] == $USER){
                $html .=  "<tr><td colspan='2' style='width:100%;text-align:right;font-size:1.7em;'><div style='width:100%;font-size:0.6em;color:#666;text-shadow:1px 1px 2px #444;'><i>" . $row["date_time"] . "</i></div><div style='display:inline-block;padding:15px 20px 20px 20px;max-width:75%;border-top-left-radius:20px;border-bottom-left-radius:20px;background-color:rgba(255,255,255,0.5);color:#333;'>" . $row["message"] . "</div></td></tr>"; 
            }else{
                $html .=  "<tr><td colspan='2' style='width:100%;text-align:left;font-size:1.7em;'><div style='width:100%;font-size:0.6em;color:#666;text-shadow:1px 1px 2px #444;'><i>" . $row["date_time"] . "</i></div><div style='display:inline-block;padding:15px 20px 20px 20px;max-width:75%;border-top-right-radius:20px;border-bottom-right-radius:20px;background-color:rgba(255,255,255,0.6);color:#000;'>" . $row["message"] . "</div></td></tr>"; 
            }
        }
        $html .=  "</table>";       

    } else{

    }
    //$html .=  "";
$dw3_conn->close();
die($html);
?>
