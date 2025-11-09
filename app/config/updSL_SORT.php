 <?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$sid   = mysqli_real_escape_string($dw3_conn,$_GET['sid']);
$sort   = mysqli_real_escape_string($dw3_conn,$_GET['sort']);

$sql = "UPDATE `slideshow` SET `sort_by` = '$sort' WHERE id = '".$sid."' LIMIT 1;";
        if ($dw3_conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo $dw3_conn->error;
        }
        $dw3_conn->close();
?>