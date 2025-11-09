<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$section_id   = $_GET['ID'];
$page_id   = $_GET['PAGE'];

$sql = "SELECT A.*, IFNULL(B.parent_page_id,'') AS parent_page_id, IFNULL(B.parent_page_name,'') AS parent_page_name FROM index_head A
LEFT JOIN (SELECT id AS parent_page_id, title AS parent_page_name FROM index_head) B ON A.parent_id = B.parent_page_id
WHERE target = 'page' AND url = '/pub/page/home/index.php'
ORDER BY parent_page_name ASC, menu_order ASC";
$result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Copier la section vers:<br><table class='tblSEL'><tr><th>Titre</th><th>Page parent</th></tr>";
        echo "<tr onclick=\"copySECTION('".$section_id."','0')\"></td><td><b>Index</b></td><td><b>/</b></td></tr>";
        while($row = $result->fetch_assoc()) {
            if($page_id == $row["id"]){
                echo "<tr onclick=\"copySECTION('".$section_id."','".$page_id."')\"></td><td><b>".$row["title"]."</b></td><td><b>Page actuelle</b></td></tr>";
            } else {
                echo "<tr onclick=\"copySECTION('".$section_id."','".$row["id"]."')\" style='border:1px solid blue;'><td>".$row["title"]."</td><td>".$row["parent_page_name"]."</td></tr>";
            }
        }
        echo "<table>";
    } else {
        echo "Aucunes pages trouvés";
    }
echo "<br><button onclick='closeMSG();'><span class='material-icons'>close</span>Annuler</button>";
$dw3_conn->close();
?>