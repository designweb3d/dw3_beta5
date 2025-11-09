<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
        $sql = "SELECT *
                FROM product_category				
                ORDER BY name_fr";

        $result = $dw3_conn->query($sql);
        $html = "[ ";
        $xy=0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                //$html .= '{"' . $xy . '":';
                $html .= '["'. $row['name_fr'] .'","' . $row['parent_name'] .'","' .str_replace('&quot;','\"',$row['description_fr']) . '","' .$row['img_url'] . '","'. $row['name_en'] .'","' .$row['description_en'] . '","' .$row['id'] . '"],';
                $xy = $xy + 1;
            }
        }
        $html = substr($html,0,strlen($html)-1) . " ]";
    echo $html ;
    //echo '[{"0":"Directeur du développement","1":"Fondateur", "2":"sdvfev"},{"0":"thgrt","1":"Directeur du développement", "2":""},{"0":"Fondateur","1":"", "2":"wcwe"}]';
    //echo '[["Tester","Fondateur","1"],["Tester2","Fondateur","2"],["Fondateur","","3"]]';
    $dw3_conn->close();
?>