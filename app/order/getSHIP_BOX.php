<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$box_id  = trim($_GET['ID']);
$sql = "SELECT * FROM supply WHERE id = '".$box_id."' LIMIT 1;";
$result = $dw3_conn->query($sql);
$data = mysqli_fetch_assoc($result);
if (floor($data['weight']) == $data['weight']) { $data["weight"] = number_format($data["weight"], 0, '.', ','); } else {$data["weight"] = number_format($data["weight"], 2, '.', ',');}
if (floor($data['height']) == $data['height']) { $data["height"] = number_format($data["height"], 0, '.', ','); } else {$data["height"] = number_format($data["height"], 2, '.', ',');}
if (floor($data['depth']) == $data['depth']) { $data["depth"] = number_format($data["depth"], 0, '.', ','); } else {$data["depth"] = number_format($data["depth"], 2, '.', ',');}
if (floor($data['width']) == $data['width']) { $data["width"] = number_format($data["width"], 0, '.', ','); } else {$data["width"] = number_format($data["width"], 2, '.', ',');}
echo '{"weight":"'.$data["weight"].'","height":"'.$data["height"].'","depth":"'.$data["depth"].'","width":"'.$data["width"].'"}';
$dw3_conn->close();
?>