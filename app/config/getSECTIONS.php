<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 

echo "<button onclick=\"newSECTION('page','0');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Page</span></button>
<button onclick=\"newSECTION('section','0');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Section</span></button>
<button onclick=\"newSECTION('sub','0');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Sous-menu</span></button>
<button onclick=\"newSECTION('button','0');\"><span class='material-icons' style='vertical-align:middle;'>add</span><span style='vertical-align:middle;margin-top:2px;'> Boutton</span></button> ";

    $sql = "SELECT * FROM index_head where parent_id = 0 ORDER BY menu_order ASC";
    $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table class='tblSEL'><tr><th>Titre</th><th>Url</th><th>Type</th><th>au Menu</th><th>Visites</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo '<tr onclick="getSECTION(\''.$row["id"].'\',\''.$row["target"].'\');"><td><span class="dw3_font" style="color:'.$row["icon_color"].';text-shadow:'.$row["icon_textShadow"].';">'.$row["icon"].'</span> '.$row["menu_order"].'- '.$row["title"].'</td>'
                                . '<td style="max-width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$row["url"].'</td>'
                                . '<td>'.$row["target"].'</td>'
                                . '<td>'.$row["is_in_menu"].'</td>'
                                . '<td>';
                if ($row["target"]=="page"){
                    echo $row["total_visited"]; 
                }else{
                    echo "n/a";
                }
                echo '</td></tr>';
            }
            echo "</table>";
        } else {
            echo "<h3>Aucune page/section trouvée.</h3>";
        }

    ?>