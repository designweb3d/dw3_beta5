<?php
header("X-Robots-Tag: noindex, nofollow", true);
$PAGE1 = strtok(substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],"/")+1),'?'); 
$PAGE2 = strtok(substr(dirname($_SERVER["REQUEST_URI"]),strrpos(dirname($_SERVER["REQUEST_URI"]),"/")+1),'?') . ".php"; 
$RIP = $_SERVER['REMOTE_ADDR'];
$USER = $_GET['USER']??"";
$PW = $_GET['PW']??"";
date_default_timezone_set('America/New_York');
$time = date("H:i:s");
$today = date("Y-m-d");
$datetime = date("Y-m-d H:i:s"); 
$user_type = "";
$body = file_get_contents('php://input');
$headers = apache_request_headers();
$log = $RIP . " ACCESS DENIED -> USER: " . $USER . " PW: " . $PW . " ";
foreach ($headers as $header => $value) {$log .= " $header: $value ";}
if(!empty($_POST)) { $log .= "POST: " . implode(",", $_POST); }
$log .= " BODY:" . $body;
$key_expire = date('Y-m-d H:i:s', strtotime( date("Y-m-d H:i:s") . ' + 2 days'));
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");
	if ($dw3_conn->connect_error) {
		$dw3_conn->close();
		die("1");
	}	
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
$total_attempt=0;
$sql = "SELECT COUNT(id) AS ipcount FROM blacklist WHERE ip = '" . $RIP . "' AND day_created='".$today."'";
$result = $dw3_conn->query($sql);  
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $total_attempt=$row["ipcount"];
        if($total_attempt>5){			
            //error_log("+5 tentatives.. ".$log);
            die("4");
        }
    }
}
//check user if ($result->num_rows > 0) {
if ($USER!="" && $PW!="") {
		$sql = "SELECT *, user.id as USER_ID FROM user LEFT JOIN app ON app.id = user.app_id WHERE UCASE(name)= '" . trim(strtoupper($USER)) . "' AND pw = '" . $PW . "' OR LCASE(eml1)= '" . trim(strtolower($USER)) . "' AND pw = '" . $PW . "' AND stat = 0 LIMIT 1";
		$sql2 = "SELECT * FROM customer WHERE eml1= '" . dw3_crypt(trim(strtolower($USER))) . "' AND pw = '" . dw3_crypt($PW) . "' AND stat = 0 OR UCASE(user_name)= '" . trim(strtoupper($USER)) . "' AND pw = '" . dw3_crypt($PW) . "' AND stat = 0 LIMIT 1";
		$KEY = dw3_make_key(128) ;
} else if (isset($_COOKIE["KEY"]) && $_COOKIE["KEY"] != "") {
		$KEY = $_COOKIE["KEY"];
		$sql = "SELECT *, user.id as USER_ID FROM user LEFT JOIN app ON app.id = user.app_id WHERE key_128 = '" . $KEY . "' AND stat = 0 LIMIT 1";
		$sql2 = "SELECT * FROM customer WHERE key_128 = '" . $KEY . "' LIMIT 1";
} else { 
        //error_log($log);
        $sql = "INSERT INTO blacklist (ip,type,day_created) VALUES('".$RIP."','','". $today ."')";
        $result = $dw3_conn->query($sql); 
		die("0".$total_attempt);
       // header('Content-Type: application/json; charset=UTF-8');
        //echo json_encode(['code' => 500, 'message' => "Internal Server Error"]);
}
    //check user first
	$result = $dw3_conn->query($sql);
	if ($result->num_rows == 0) {
        //if not a user maybe a customer
        $result2 = $dw3_conn->query($sql2);
        if ($result2->num_rows == 0) { //no user and no customer found exit 
            $sql = "INSERT INTO blacklist (ip,type,day_created) VALUES('".$RIP."','','". $today ."')";
            $result = $dw3_conn->query($sql);         
            $sql = "INSERT INTO event (event_type,name,description,date_start) VALUES('LOGIN','Tentative de connexion échoué.','".$log."','". $datetime ."')";
            $result = $dw3_conn->query($sql);         
            $dw3_conn->close();
            //error_log($log); 
            die("0".$total_attempt);
        } else { //a customer was found
            while($row2 = $result2->fetch_assoc()) {
                $date1=date_create(date("Y-m-d"));
                $date2=date_create($row2["key_expire"]);
                $diff=date_diff($date1,$date2);
                $num_days = (int) $diff->format("%a");
                if ($USER=="" && $PW=="" && $num_days > 2){
                    $dw3_conn->close();
                    die("2");
                }
                $USER = $row2["id"]; 
                if ($row2["activated"] == "0"){
                    $dw3_conn->close();
                    die("2.1");     
                }  
                if ($row2["two_factor_req"] == "1"){
                    $output = "/client/two-factor.php?KEY=" . $KEY ;
                } else {
                    $output = "/client/dashboard.php?KEY=" . $KEY ;
                }
                
				//key cookie for customer
				$cookie_name = "KEY";
				$cookie_value = $KEY;
                $cookie_domain = $_SERVER["SERVER_NAME"];
                setcookie($cookie_name, $cookie_value, [
                    'expires' => time() + 86400,
                    'path' => '/',
                    'domain' => $cookie_domain,
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'None',
                ]);
				//setcookie($cookie_name, $cookie_value, time() + 86400 , "/"); 
				//language cookie for customer
				//$cookie_name = "LANG";
				//$cookie_value = $row2["lang"]??'fr';
				//setcookie($cookie_name, $cookie_value, time() + 86400 , "/"); 
                $sql = "UPDATE customer SET key_128= '" .  $KEY . "', key_expire = '". $key_expire . "', two_factor_valid='0', last_login = '".$today."'
                        WHERE id= '" . $USER . "' LIMIT 1";
                if ($dw3_conn->query($sql) === FALSE) {
                    $dw3_conn->close();
                    die("3");
                }

                echo($output);
                $dw3_conn->close();
            }
        }
    } else { //a user was found	
		while($row = $result->fetch_assoc()) {
            $date1=date_create(date("Y-m-d"));
            $date2=date_create($row["key_expire"]);
            $diff=date_diff($date1,$date2);
            $num_days = (int) $diff->format("%a");
            if ($USER=="" && $PW=="" && $num_days > 2){
                $dw3_conn->close();
                die("3");
            }
            //key cookie for user
            $cookie_name = "KEY";
            $cookie_value = $KEY;
            $cookie_domain =  $_SERVER["SERVER_NAME"];
            setcookie($cookie_name, $cookie_value, [
                'expires' => time() + 86400,
                'path' => '/',
                'domain' => $cookie_domain,
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None',
            ]);
            //setcookie($cookie_name, $cookie_value, time() + 86400 , "/"); 
            //language cookie for user
            //$cookie_name = "LANG";
            //$cookie_value = $row["lang"];
            //setcookie($cookie_name, $cookie_value, time() + 86400 , "/"); 
			$USER = $row["USER_ID"]; 		
			if ( $row["filename"] != "") {
				$output = "/app/" . $row["filename"] . "/" . $row["filename"] .".php?KEY=" . $KEY ;
			} else {
				//die("2");
                //$output = "/app/" . $row["filename"] . "/" . $row["filename"] .".php?KEY=" . $KEY ;
				$output = "/app/message/message.php?KEY=" . $KEY;
			}
		}

		$sql = "UPDATE user SET key_128= '" .  $KEY . "', key_expire = '". $key_expire . "' WHERE id= '" . $USER . "'  LIMIT 1";
		if ($dw3_conn->query($sql) === FALSE) {
			$dw3_conn->close();
			die("3");
		}
		//echo $sql;
		echo($output);
		$dw3_conn->close();
	}

?>	
