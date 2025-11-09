<?php 
header("X-Robots-Tag: noindex, nofollow", true);
$current_path = (realpath(dirname(__FILE__)));
$root_path = substr($current_path, 0, strpos($current_path, '/sbin'));

parse_str($argv[1], $params);
$KEY = $params['K'];

if (file_exists($current_path . "/hash_master.ini")) {
    $dw3_read_ini = parse_ini_file($current_path . "/hash_master.ini");
    if (isset($dw3_read_ini["masterk"])){
        $MASTERKEY = $dw3_read_ini["masterk"];
    } else {
        die("KEY Error");
    }
} else {
    die("KEY Error");
}

if ($KEY != $MASTERKEY || $KEY == "" || $MASTERKEY == ""){
    die("KEY Error");
}
date_default_timezone_set('America/New_York');
$datetime = date("Y-m-d H:i:s");
$dw3_ini = parse_ini_file($current_path . "/config.ini");
if (!isset($dw3_ini["mysqli_servername"]) || !isset($dw3_ini["mysqli_username"]) || !isset($dw3_ini["mysqli_password"]) || !isset($dw3_ini["mysqli_dbname"])){
    die("INI Error");
}
#DB Backup
$mysqlUserName      = $dw3_ini["mysqli_username"];
$mysqlPassword      = $dw3_ini["mysqli_password"];
$mysqlHostName      = $dw3_ini["mysqli_servername"];
$DbName             = $dw3_ini["mysqli_dbname"];
$file_time = date("Y-m-d_H.i.s");
$backup_name        = $root_path."/backup/backup_db_".$file_time.".sql";
$tables             = array("config","customer","event","gl","gls","index_head","index_line","invoice_head",
                            "invoice_line","location","order_head","order_line","position","product","product_category",
                            "product_kit","product_option","prototype_data","prototype_head","prototype_line",
                            "purchase_head","purchase_line","road_head","road_line","road_user","schedule_head","schedule_line",
                            "storage","supplier","transaction","transfer","user","user_service");

   //or add 5th parameter(array) of specific tables:    array("mytable1","mytable2","mytable3") for multiple tables

    Export_Database($mysqlHostName,$mysqlUserName,$mysqlPassword,$DbName,  $tables=false, $backup_name=false );

    function Export_Database($host,$user,$pass,$name,  $tables=false, $backup_name=false )
    {
        $mysqli = new mysqli($host,$user,$pass,$name); 
        $mysqli->select_db($name); 
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables    = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0]; 
        }   
        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        //$row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
                        if (isset($row[$j]))
                        {
                            $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
        $file_time = date("Y-m-d_H.i.s");
        $current_path = (realpath(dirname(__FILE__)));
        $root_path = substr($current_path, 0, strpos($current_path, '/sbin'));
        $backup_name = $backup_name ? $backup_name : "backup_db_". $file_time .".sql";
        $db_filename = $root_path . "/backup/" . $backup_name;
        /* header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".basename($backup_name)."\"");   */
        //echo $content; exit;
        $db_file = fopen($db_filename, "w");
        fwrite($db_file, $content);
        fclose($db_file);
    }

#FILES Backup
$zip = new ZipArchive();
$file_time = date("Y-m-d_H.i.s");
$zipFileName = $root_path . '/backup/backup_fs_'.$file_time.'.zip';
if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
    exit("Cannot open <$zipFileName>\n");
}

$directoriesToZip = [$root_path.'/pub/img', $root_path.'/pub/upload', $root_path.'/fs']; // Array of directories to add

    foreach ($directoriesToZip as $sourcePath) {
        // Ensure the path exists and is a directory
        if (!is_dir($sourcePath)) {
            continue;
        }

        // Get the base name of the directory to use as the root in the zip
        $baseDirName = basename($sourcePath);

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourcePath),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($files as $file) {
            // Skip '.' and '..' entries
            if ($file->getFilename() === '.' || $file->getFilename() === '..'  ||  $file->getFilename() === ".htaccess") {
                continue;
            }

            $filePath = $file->getRealPath();
            $relativePath = $baseDirName . '/' . substr($filePath, strlen($sourcePath) + 1); // Relative path inside the zip

            if ($file->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else if ($file->isFile()) {
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    $zip->close();

#Log event
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");
if ($dw3_conn->connect_error) {
    $dw3_conn->close();
    die("DB Error");
}	
$sql = "INSERT INTO event (event_type,name,description,date_start) 
        VALUES('SYSTEM','Tâche planifié - Sauvegarde','Fichiers: /backup/backup_fs_".$file_time.".zip & /backup/".$backup_name."','". $datetime ."')";
$result = $dw3_conn->query($sql); 
$dw3_conn->close();
exit();
?>