<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
?>
<table class='tblSIMPLE' style='width:100%;'>
    <tr><th colspan='2'>Polices installées</th></tr>
<?php
        $dir = new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . '/pub/font');
        $files = new RecursiveIteratorIterator($dir);
        $fnx = 0;
        foreach($files as $file){
            $fn=basename($file->getFileName(), ".ttf");
            if ($fn!="." && $fn!=".." && $fn!="MaterialIcons-Regular" && $fn!="dw3" && $fn!="Imperial" && $fn!="Boldonse" && $fn!="Julius" ){
                $fnx++;
                $fsize = filesize($file->getPathname());
                if ($fsize>1048576){$fsize=round($fsize/1048576,2)." Mo";}
                elseif ($fsize>1024){$fsize=round($fsize/1024,2)." Ko";}
                else {$fsize=$fsize." o";}
                echo "<tr id='font_".$fnx."'><td style='font-family:".$fn.";'>". $fn. " <span style='font-family:arial;font-size:12px;'>(" .$fsize. ")</span> ";
                if ($CIE_FONT1 == $fn || $CIE_FONT2 == $fn || $CIE_FONT3 == $fn || $CIE_FONT4 == $fn) {echo " <span style='color:green;' title='Police utilisée' class='material-icons'>check_circle</span>";}
                echo "</td><td width='46px'><button class='red' onclick=\"delFONT('".basename($file->getFileName()) ."','".$fnx."');\"><span class='material-icons'>delete</span></button></td></tr>";
            }
        }
$dw3_conn->close();
?>
</table>
