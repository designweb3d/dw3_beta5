<?php 
$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_ALL & ~MYSQLI_REPORT_INDEX;
//ini_set('memory_limit', '256M'); 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$DW3_VERSION = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/VERSION');
//if ( $_SERVER["SERVER_NAME"] == "dev.ww7.ca" ){die("Mise à jour impossible pour ce site.");}
if ( $_SERVER["SERVER_NAME"] == "dev.ww7.ca"){
    $DW3_UPDATE_VERSION = file_get_contents('https://ww7.ca/dw3/VERSION_DEV');
}else{
    $DW3_UPDATE_VERSION = file_get_contents('https://ww7.ca/dw3/VERSION');
}

if ($DW3_VERSION == $DW3_UPDATE_VERSION){
    $dw3_conn->close();
    die("La mise à jour a déja été complétée. (".$_SERVER["SERVER_NAME"].")");
}

if (trim($DW3_VERSION) == "" || trim($DW3_UPDATE_VERSION) == ""){
    $dw3_conn->close();
    die("Mise à jour non disponible pour le moment.");
}

if ( $_SERVER["SERVER_NAME"] == "dev.ww7.ca"){
    $DW3_UPDATE_LINK = file_get_contents('https://ww7.ca/dw3/getLINK.php?V='.$DW3_VERSION."&M=DEV");
}else{
    $DW3_UPDATE_LINK = file_get_contents('https://ww7.ca/dw3/getLINK.php?V='.$DW3_VERSION);
}

if (substr($DW3_UPDATE_LINK,0,2)=="E1"){die("<div style='width:100%;text-align:center;font-size:15px'><h2>Accès requis</h2><br>Contactez-nous <a href='https://DesignWeb3D.com'>DesignWeb3D.com</a><br><a href='mailto:info@dw3.ca'>info@dw3.ca</a><br><a href='tel:15147422894'>1-514-742-2894</a><hr><br>Nous aurons besoin de l'adresse IP <br>de votre serveur qui est :<br><h3>".substr($DW3_UPDATE_LINK,2)."</h3></div>");}
if ($DW3_UPDATE_LINK=="E2"){die("Mise à jour non disponible.");}
if ($DW3_UPDATE_LINK=="E3"){die("La mise à jour a déja été complété.");}
if ($DW3_UPDATE_LINK==""){die("Erreur de mise à jour.");}

$update_file = fopen($_SERVER['DOCUMENT_ROOT'] . '/sbin/update.txt', "w");

    //header
    header('Content-Type: text/octet-stream');
    header('Cache-Control: no-cache');
    $dw3_source_path = "https://ww7.ca/dw3/".$DW3_UPDATE_VERSION;
    $dw3_target_path = $_SERVER['DOCUMENT_ROOT'];
    echo "Timezone: " . date_default_timezone_get(). "\n";
    echo "Local: " . $dw3_target_path. "\n";
    echo "Source: " . $dw3_source_path. "\n";
  
    //update 
    $DW3_UPDATE_LIST = explode("\n",file_get_contents($DW3_UPDATE_LINK));
    $dw3_upd_list_count = count($DW3_UPDATE_LIST)-15;
    $dw3_upd_count = 0;
    echo "Début de la mise à jour: " . date('l, F j, Y') . " <b>" .date("h:i:sa") . "</b>\n\n";
    ob_flush();
    flush();
    sleep(1);
    $update_txt = "Début de la mise à jour: " . date('l, F j, Y') . " <b>" .date("h:i:sa") . "</b>\n\n";
    fwrite($update_file, $update_txt);
    foreach ($DW3_UPDATE_LIST as $dw3_filename) {

        //get file sourcefile name
        if (substr(trim($dw3_filename),-4)==".php"){
            if (trim($dw3_filename)=="/sbin/security.php"){
                $dw3_source_file_name = trim($dw3_source_path . "/sbin/security2.php.new");
            }else{
                $dw3_source_file_name = trim($dw3_source_path . trim($dw3_filename). ".new");
            }
        } else if (substr(trim($dw3_filename),-9)==".htaccess"){
            $dw3_source_file_name = trim($dw3_source_path . trim($dw3_filename). "new");
        }else{      
            $dw3_source_file_name = trim($dw3_source_path . trim($dw3_filename));
        }
  
        //check if update needed
        if (substr(trim($dw3_filename),0,1) != "#" && trim($dw3_filename) != ""){
            //get date modified
            $curl = curl_init($dw3_source_file_name);
            curl_setopt($curl, CURLOPT_NOBODY, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FILETIME, true);
            $result = curl_exec($curl);
            if ($result === false) {
                echo (curl_error($curl)); 
            }
            $remotetimestamp = curl_getinfo($curl, CURLINFO_FILETIME);
/*             $h = get_headers($dw3_source_file_name, 1);
            if (isset($h['Last-Modified'])){
                $remotetimestamp = strtotime($h['Last-Modified']);//php 5.3
            } else {
                $remotetimestamp = -1;
            } */
  
            if (substr(trim($dw3_filename),0,1) == "+"){
                if (!file_exists($dw3_target_path . ltrim(trim($dw3_filename), '+'))){
                    //mkdir
                    echo "Création du répertoire: " . trim($dw3_target_path . ltrim(trim($dw3_filename), '+')) . "\n";
                    mkdir(trim($dw3_target_path . ltrim(trim($dw3_filename), '+')));
                    $update_txt = "Création du répertoire: " . trim($dw3_target_path . ltrim(trim($dw3_filename), '+')) . "\n";
                    fwrite($update_file, $update_txt);
                }
            }else{
                $file_to_update = false;
                if(!file_exists(trim($dw3_target_path . $dw3_filename))){
                    $file_to_update = true;
                } else if($remotetimestamp > filemtime(trim($dw3_target_path . $dw3_filename))){{
                        $file_to_update = true;
                    }
                }
                if (!file_exists(trim(dirname($dw3_target_path.$dw3_filename)))){
                    echo("<b style='color:red;'>Erreur répertoire inexistant ". trim(dirname($dw3_target_path.$dw3_filename)). "</b>\n");
                    ob_flush();
                    flush();
                    $update_txt = "<b style='color:red;'>Erreur répertoire inexistant ". trim(dirname($dw3_target_path.$dw3_filename)). "</b>\n";
                    fwrite($update_file, $update_txt);
                }
                if($file_to_update == true && file_exists(trim(dirname($dw3_target_path.$dw3_filename)))){
                    //download
                    echo "Téléchargement: " . trim($dw3_source_path . $dw3_filename) ."\n";
                    ob_flush();
                    flush(); 
                    $update_txt = "Téléchargement: " . trim($dw3_source_path . $dw3_filename) . "\n";
                    fwrite($update_file, $update_txt);
                    //check if remote file exists
                    $headers = @get_headers($dw3_source_file_name);
                    if ($headers && strpos($headers[0], '200 OK') !== false) {
                        $dw3_source_file = file_get_contents($dw3_source_file_name);
                    } else {
                        $dw3_source_file = "";
                    }
                    $dw3_source_size = strlen($dw3_source_file);
                    if ($dw3_source_size==0){
                        echo("<b style='color:red;'>Erreur lors du téléchargement de ". trim($dw3_source_path . $dw3_filename). "</b>\n");
                        ob_flush();
                        flush();
                        $update_txt = "<b style='color:red;'>Erreur lors du téléchargement de ". trim($dw3_source_path . $dw3_filename). "</b>\n";
                        fwrite($update_file, $update_txt);
                    } else {
                        if ($dw3_source_size < 1024){
                            $dw3_source_size = $dw3_source_size . "b";
                        } else if ($dw3_source_size >= 1024 && $dw3_source_size < (1024*1024)){
                            $dw3_source_size = round($dw3_source_size/1024,2). "Kb";
                        } else if ($dw3_source_size >= (1024*1024)){
                            $dw3_source_size = round($dw3_source_size/(1024*1024),2). "Mb";
                        }
                        //install
                        echo "Installation: " . trim($dw3_target_path . $dw3_filename) . " (" . $dw3_source_size . ") \n";
                        ob_flush();
                        flush();
                        $update_txt = "Installation: " . trim($dw3_target_path . $dw3_filename) . " (" . $dw3_source_size . ") \n";
                        fwrite($update_file, $update_txt);
                        if (file_exists(trim(dirname($dw3_target_path.$dw3_filename)))){
                            $dw3_target_file = fopen(trim($dw3_target_path . $dw3_filename),"w");
                            fwrite($dw3_target_file, $dw3_source_file);
                            fclose($dw3_target_file);
                            $dw3_upd_count++;
                        }else{
                            echo("Erreur lors de l'installation dans <b style='color:red;'>". trim($dw3_target_path). "</b>\n");
                            ob_flush();
                            flush();
                            $update_txt = "Erreur lors de l'installation dans <b style='color:red;'>". trim($dw3_target_path). "</b>\n";
                            fwrite($update_file, $update_txt);
                        }
                    }
                }
            }
        }
    }
   
    //update database
    $DW3_UPDATE_SQL = explode("\n",file_get_contents('https://ww7.ca/dw3/UPDATE_SQL_'.$DW3_VERSION.'-'.$DW3_UPDATE_VERSION));
    echo "\n\nMise à jour de la base de données:\n";
    $update_txt = "\n\nMise à jour de la base de données:\n";
    fwrite($update_file, $update_txt);
    foreach ($DW3_UPDATE_SQL as $dw3_sql_line) {
        if (substr($dw3_sql_line,0,1) != "#" && trim($dw3_sql_line) != ""){
            try {
                mysqli_multi_query($dw3_conn, $dw3_sql_line);
/*                 do {
                    if ($result = mysqli_use_result($dw3_conn)) {
                    while ($row = mysqli_fetch_row($result)) {
                        echo($row[0]."\n");
                        echo($row[1]."\n");
                        echo($row[2]."\n");
                        echo($row[3]."\n");
                        echo($row[4]."\n");
                        echo($row[5]."\n\n");
                    }
                    mysqli_free_result($result);
                    }
                    if (mysqli_more_results($dw3_conn)) {
                    echo("\n");
                    }
                } while (mysqli_next_result($dw3_conn)); */

            } catch (mysqli_sql_exception $e) {
                echo($e->__toString());
                $update_txt = $e->__toString() . "\n";
                fwrite($update_file, $update_txt);
            }
            ob_flush();
            flush();
            //sleep(1);
            usleep( 250000 ); // 250000 = 1/4 sec
        }
    }
/*     if(!mysqli_multi_query($dw3_conn, $DW3_UPDATE_SQL)){
        echo(" Erreur ; \n" . mysqli_error($dw3_conn));
    }else {
        //echo " Complétée avec succès.". "\n";
        do {
            if ($result = mysqli_use_result($dw3_conn)) {
               while ($row = mysqli_fetch_row($result)) {
                  echo($row[0]."\n");
                  echo($row[1]."\n");
                  echo($row[2]."\n");
                  echo($row[3]."\n");
                  echo($row[4]."\n");
                  echo($row[5]."\n\n");
               }
               mysqli_free_result($result);
            }
            if (mysqli_more_results($dw3_conn)) {
               echo("\n");
            }
         } while (mysqli_next_result($dw3_conn));
    } */

    //update VERSION
    if ($_SERVER["SERVER_NAME"] != "designweb3d.com"  
    && $_SERVER["SERVER_NAME"] != "www.designweb3d.com" 
    && $_SERVER["SERVER_NAME"] != "ww7.ca" 
    && $_SERVER["SERVER_NAME"] != "dev.ww7.ca" 
    && $_SERVER["SERVER_NAME"] != "www.dev.ww7.ca" 
    && $_SERVER["SERVER_NAME"] != "demo2.ww7.ca" 
    && $_SERVER["SERVER_NAME"] != "demo3.ww7.ca" 
    && $_SERVER["SERVER_NAME"] != "annie-tanguay.ca" 
    && $_SERVER["SERVER_NAME"] != "lesmuseauxdecosse.com" 
    && $_SERVER["SERVER_NAME"] != "lapenseemarketing.ca" 
    && $_SERVER["SERVER_NAME"] != "pgfsi.ca" 
    && $_SERVER["SERVER_NAME"] != "systemix.ca" 
    && $_SERVER["SERVER_NAME"] != "appaparanormal.com" 
    && $_SERVER["SERVER_NAME"] != "cloturescsta.ca" 
    && $_SERVER["SERVER_NAME"] != "zenithhitech.ca" 
    && $_SERVER["SERVER_NAME"] != "mvaentreprises.com" 
    && $_SERVER["SERVER_NAME"] != "toitureskl.com" 
    && $_SERVER["SERVER_NAME"] != "cvqvintage.ca" 
    && $_SERVER["SERVER_NAME"] != "menageaucarre.ca" 
    && $_SERVER["SERVER_NAME"] != "marjolene.ca" 
    && $_SERVER["SERVER_NAME"] != "shopycanada.com" 
    && $_SERVER["SERVER_NAME"] != "demo.ww7.ca"){
        $dw3_file = fopen($_SERVER["DOCUMENT_ROOT"]."/VERSION", "w");
        $dw3_text = $DW3_UPDATE_VERSION;
        fwrite($dw3_file, $dw3_text);
        fclose($dw3_file);        
    } 

$sql = "INSERT INTO event (event_type,name,description,date_start) VALUES('UPDATE','Mise à jour du système.','". date('l, F j, Y') . " " .date("h:i:sa") . "','". date("Y-m-d H:i:s") ."')";
$result = $dw3_conn->query($sql); 

//si BETA 5 crypter eml et pw de customer
if ($DW3_UPDATE_VERSION == "BETA5"){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
    $sql4 = "SELECT * FROM customer WHERE crypted = 0";
	$result4 = $dw3_conn->query($sql4);
	if ($result4->num_rows > 0) {
		while($row4 = $result4->fetch_assoc()) {
            $crypted_eml1 = dw3_crypt($row4["eml1"]);
            $crypted_eml2 = dw3_crypt($row4["eml2"]);
            $crypted_pw = dw3_crypt($row4["pw"]);

            //update customer
            $sql5 = "UPDATE customer SET eml1 = '".$crypted_eml1."',eml2 = '".$crypted_eml2."',pw = '".$crypted_pw."',crypted=1 WHERE id = '".$row4["id"]."' LIMIT 1; ";
            $result5 = $dw3_conn->query($sql5);
            
            //update commandes
            $sql6 = "UPDATE order_head SET eml = '".$crypted_eml1."' WHERE eml = '".$row4["id"]."'; ";
            $result6 = $dw3_conn->query($sql6);

            //update factures
            $sql7 = "UPDATE invoice_head SET eml = '".$crypted_eml1."' WHERE eml = '".$row4["id"]."'; ";
            $result7 = $dw3_conn->query($sql7);

        }
    }
    //update province QC
    $sql8 = "UPDATE order_head SET prov = 'QC' WHERE prov = 'Québec' OR prov = 'Quebec'; ";
    $result8 = $dw3_conn->query($sql8);
    $sql8 = "UPDATE order_head SET province_sh = 'QC' WHERE province_sh = 'Québec' OR province_sh = 'Quebec'; ";
    $result8 = $dw3_conn->query($sql8);
    $sql8 = "UPDATE invoice_head SET prov = 'QC' WHERE prov = 'Québec' OR prov = 'Quebec'; ";
    $result8 = $dw3_conn->query($sql8);
    $sql8 = "UPDATE invoice_head SET province_sh = 'QC' WHERE province_sh = 'Québec' OR province_sh = 'Quebec'; ";
    $result8 = $dw3_conn->query($sql8);
}
echo "\n\n"."Nb de fichiers MAJ: <b>" . $dw3_upd_count ."/".max((int)$dw3_upd_list_count, 0). "</b>\n";
$update_txt = "\n\nFin de la mise à jour: " . date('l, F j, Y') . " <b>" .date("h:i:sa") . "</b>";
fwrite($update_file, $update_txt);
$dw3_conn->close();
fclose($update_file);
die("\n\nFin de la mise à jour: " . date('l, F j, Y') . " <b>" .date("h:i:sa") . "</b>");
?>