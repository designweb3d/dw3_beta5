<?php
//clear all deleted and spam > 1 month from db and dir
$dw3_ini = parse_ini_file("config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
if ($dw3_conn->connect_error) {die("");}
$newdate = date("Y-m-d", strtotime("-1 months"));
$dw3_sql = "SELECT * FROM email WHERE box IN ('DELETED','SPAM','JUNK') AND date_created < '".$newdate."' ;";
$dw3_result = $dw3_conn->query($dw3_sql);
    if ($dw3_result->num_rows > 0) {
        while($row = $dw3_result->fetch_assoc()) {
            $msg_id = $row["id"];
            $dw3_conn->query("DELETE FROM email WHERE id = '".$msg_id."' LIMIT 1;");
            $dir = "../app/email/mail/".$msg_id."/";
            if (is_dir($dir)){
                if ($dh = opendir($dir)){
                    while (($file = readdir($dh)) !== false){
                        if($file !="." && $file !=".."){
                            unlink("../app/email/mail/".$msg_id."/".$file);
                        }
                    }
                    closedir($dh);
                }
                rmdir($dir);
            }
        }
    }
$dw3_conn->close();
exit();
?>