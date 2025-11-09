<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$prID  = $_GET['prID'];
$link_img = "";
$html = "";
$sql = "SELECT *
			FROM product 
			WHERE id = " . $prID . "
			LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
            $link_img = $row["url_img"];
        }
    }

$folder=scandir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" .$prID . "/");
            foreach($folder as $file) {
                if (!is_dir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $file) && $file != "." && $file != ".."){
                    $filenames[] = $file;
                }
            }
if(isset($filenames) && count($filenames)>=1){
    foreach($filenames as $file) {
        if ($link_img == $file){
            $html .= "<button onclick='getFILE_INFO(\"".$prID."\",\"".$file."\");' class='image' style='margin:3px;color:#111;height:100px;width:auto;max-width:200px;background-image: url(\"/fs/product/".$prID."/" . $file . "?t=".rand(1,100000)."\");'><span class='material-icons' style='margin:-15px 0px 0px -15px;color:goldenrod;text-shadow: 1px 1px #000;font-size:25px;float:left;'>grade</span><br><div style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;margin-top:70px;text-shadow: 1px 1px #1baff3;'>" . $file . "</div></button>";
        }else{
            $html .= "<button onclick='getFILE_INFO(\"".$prID."\",\"".$file."\");' class='image' style='margin:3px;color:#111;text-shadow: 1px 1px #1baff3;height:100px;width:auto;max-width:200px;background-image: url(\"/fs/product/".$prID."/" . $file . "?t=".rand(1,100000)."\");'><div style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;margin-top:70px;'>" . $file . "</div></button>";
        }
    }
}
$dw3_conn->close();
header('Status: 200');
die($html);
?>