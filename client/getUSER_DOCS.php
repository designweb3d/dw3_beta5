<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$is_files = false;
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/fs/customer/'.$USER)){
    $dir = new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . '/fs/customer/'.$USER);
    $files = new RecursiveIteratorIterator($dir);
    foreach($files as $file){
        //$fn=basename($file->getFileName(), ".pdf");
        $fn=basename($file->getFileName());
        $file_wpath=$_SERVER['DOCUMENT_ROOT'] . '/fs/customer/'.$USER.'/'.$fn;
        $file_ppath= '/fs/customer/'.$USER.'/'.$fn;
        if ($fn!="." && $fn!=".."){
            $daFileType = strtolower(pathinfo($file_wpath,PATHINFO_EXTENSION));
            $file_size = filesize($file_wpath);
            if ($file_size <= 1024){ 
               $file_size = $file_size . " bytes";
            }else if ($file_size >= 1048576){
                $file_size = round(($file_size/1024)/1024,2) . "MB";
            } else {
                $file_size = round($file_size/1024) . "KB";
            }
            if (strlen($fn) > 30){
                $fn_txt = substr($fn,0,26) . ".." . substr($fn,-4);
            } else {
                $fn_txt = substr($fn,0,30); 
            }
            echo "<div class='divBOX' style='height:auto;background:rgba(255,255,255,0.7);color:#222;margin:12px;border-radius:7px;text-align:center;'>";
            if ($USER_LANG == "FR"){ 
                echo "<table class='tblDATA'>
                        <tr><td>Fichier</td><td  style='white-space: normal;text-align:left;'><b>". $fn_txt ."</b></td></tr>
                        <tr><td>Taille</td><td style='text-align:right;'><b>". $file_size."</b></td></tr>
                        <tr><td>Date modifié</td><td style='text-align:center;'><b>". date("Y-m-d", filemtime($file_wpath))."</b></td></tr>";
                echo "</table>";
            }else{
                echo "<table class='tblDATA'>
                        <tr><td>Filename</td><td  style='white-space: normal;text-align:left;'><b>". $fn_txt ."</b></td></tr>
                        <tr><td>Size</td><td style='text-align:right;'><b>". $file_size."</b></td></tr>
                        <tr><td>Modified date</td><td style='text-align:center;'><b>". date("Y-m-d", filemtime($file_wpath))."</b></td></tr>";
                echo "</table>";
           }
            echo "<button class='red' onclick=\"deleteFILE('".$fn."');\" style='float:left;'><span class='material-icons'>delete</span></button>";
            if($daFileType == "jpg" || $daFileType == "png" || $daFileType == "jpeg" || $daFileType == "gif" || $daFileType == "svg" || $daFileType == "tiff" || $daFileType == "bmp" || $daFileType == "webp" || $daFileType == "avif" || $daFileType == "ico" || $daFileType == "apng" ) {
                echo "<img src='".$file_ppath."' style='height:50px;width:auto;max-width:150px;'>";
            } else if ($daFileType == "pdf"){
                echo "<span class='material-icons' style='font-size:50px;'>picture_as_pdf</span>";
            } else {
                echo "<span class='material-icons' style='font-size:50px;'>description</span>";
            }
            echo "<button onclick=\"downloadFILE('".$USER."','".$fn."');\" style='float:right;'><span class='material-icons'>cloud_download</span></button>";
            echo "</div>";
            $is_files = true;
        }
    }
}
    $sql = "SELECT A.*, B.name_fr as name_fr, B.description_fr as description_fr, B.total_type AS total_type, B.total_max AS total_max, B.next_id AS next_id , B.allow_user_reedit AS allow_user_reedit , B.allow_user_view AS allow_user_view 
    FROM prototype_report A
    LEFT JOIN prototype_head B ON B.id = A.head_id
    WHERE A.parent_id = '" . $USER . "' AND allow_user_view='1' ORDER BY A.date_completed DESC";
    $result = $dw3_conn->query($sql);
    $QTY_ROWS = $result->num_rows??0;
    if ($QTY_ROWS > 0) { 
        while($row = $result->fetch_assoc()) {
            echo "<div class='divBOX' style='height:auto;background:rgba(255,255,255,0.7);color:#222;margin:12px;border-radius:7px;'>";
            if ($USER_LANG == "FR"){ 
                echo "<table class='tblDATA'>
                            <tr><td>Formulaire</td><td  style='white-space: normal;text-align:left;'><b>". $row["name_fr"] ."</b></td></tr>
                            <tr><td>Description</td><td style='white-space: normal;text-align:left;font-size:0.7em;'><b>". $row["description_fr"] ."</b></td></tr>
                            <tr><td>Date complété</td><td style='text-align:center;'><b>". substr($row["date_completed"],0,10) ."</b></td></tr>";
                    /*     if ($row["total_type"]=="POINTS"){
                            echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],0). "</b></td></tr>";
                        } else if ($row["total_type"]=="CASH"){
                            echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],2,"."," "). "</b>$</td></tr>";
                        } else if ($row["total_type"]=="POURCENT"){
                            echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],0). "</b>%</td></tr>";
                        } */
                        echo "</table>";
                        if ($row["allow_user_reedit"]=="1"){
                            echo "<button style='cursor:pointer;float:right;' onclick='editDOCUMENT(".$row["head_id"].",".$row["id"].")'><span class='material-icons'>note_alt</span> Modifier le document</button>"; 
                        } else {
                            echo "<button style='cursor:pointer;float:right;' onclick='editDOCUMENT(".$row["head_id"].",".$row["id"].")'><span class='material-icons'>preview</span> Voir le document</button>"; 
                        }
            }else{
                echo "<table class='tblDATA'>
                            <tr><td>Document</td><td  style='white-space: normal;text-align:left;'><b>". $row["name_fr"] ."</b></td></tr>
                            <tr><td>Description</td><td style='white-space: normal;text-align:left;font-size:0.7em;'><b>". $row["description_fr"] ."</b></td></tr>
                            <tr><td>Date completed</td><td style='text-align:center;'><b>". substr($row["date_completed"],0,10) ."</b></td></tr>";
                /*   if ($row["total_type"]=="POINTS"){
                            echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],0). "</b></td></tr>";
                        } else if ($row["total_type"]=="CASH"){
                            echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],2,"."," "). "</b>$</td></tr>";
                        } else if ($row["total_type"]=="POURCENT"){
                            echo "<tr><td>Total</td><td style='text-align:right;'><b>". number_format($row["result"],0). "</b>%</td></tr>";
                        } */
                        echo "</table>";
                        //if ()
                        echo "<button style='cursor:help;float:right;' onclick='editDOCUMENT(".$row["head_id"].",".$row["id"].")'><span class='material-icons'>note_alt</span> Modify the document</button>"; 
            }
            echo "</div>";
        }
    } else if ($is_files == false) {
        echo "<div class='divBOX' style='text-align:center;'>"; if ($USER_LANG == "FR"){ echo "Aucun document dans le dossier."; }else{echo "No document found.";} echo "</div>";            
    }
$dw3_conn->close();
?>