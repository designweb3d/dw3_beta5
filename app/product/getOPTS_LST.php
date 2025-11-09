<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$html = "<h3>Options existantes</h3><table class='tblSEL'>";
    /* $sql2 = "SELECT A.id, DISTINCT(A.name_fr, GROUP_CONCAT(B.name_fr SEPARATOR ', ')) AS con_line
    FROM product_option A
    LEFT JOIN (SELECT * FROM product_option_line) B ON A.id = B.option_id 
    GROUP BY A.id, A.name_fr
    ORDER BY A.name_fr ASC;"; */
    /* $sql2 = "SELECT A.id, A.name_fr, IFNULL(B.lines) as line_count
    FROM product_option A
    LEFT JOIN (SELECT option_id, COUNT(*) FROM product_option_line GROUP BY option_id) B ON A.id = B.option_id
    WHERE A.id IN ( SELECT MIN(id) FROM product_option GROUP BY name_fr);"; */
    $sql2 = "SELECT A.id, A.name_fr, IFNULL(B.clines,0) AS lines_count, GROUP_CONCAT(IFNULL(E.name_fr,'') SEPARATOR ', ') AS lines_cat
    FROM product_option A
    LEFT JOIN (SELECT option_id, COUNT(*) AS clines FROM product_option_line GROUP BY option_id) B ON A.id = B.option_id
    LEFT JOIN (SELECT option_id, name_fr FROM product_option_line) E ON A.id = E.option_id
    WHERE A.id IN ( SELECT MIN(id) FROM product_option C
                   LEFT JOIN (SELECT option_id, COUNT(*) AS dlines FROM product_option_line GROUP BY option_id) D ON C.id = D.option_id
                   GROUP BY name_fr, dlines)
   GROUP BY A.id, A.name_fr, B.clines;";
    $result2 = $dw3_conn->query($sql2);
    if ($result2->num_rows > 0) {
         $html .= "<tr><th>Option</th><th>Lignes</th></tr>";
        while($row2 = $result2->fetch_assoc()) {
            $html .= "<tr><td onclick=\"setOPT_PRDS('". $row2["id"] . "');\">". $row2["name_fr"] . "</td><td>". $row2["lines_cat"] . "</td></tr>";		
        }
    }
$html .= "</table>";
$dw3_conn->close();
header('Status: 200');
die($html);
?>
