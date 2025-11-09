<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$LST   = $_GET['LST'];
//$LST   = htmlspecialchars($_GET['LST']);
                  
	$sql = "INSERT INTO customer 
			(id,
             activated,
			 lang,
			 type,
			 prefix,
			 gender,
			 first_name,
			 last_name,
			 tel1,
			 tel2,
			 adr1,
			 adr2,
			 city,
			 province,
			 country,
			 postal_code,
			 eml1,
			 eml2,
			 note) 
			VALUES 
			" . $LST ." 
			ON DUPLICATE KEY UPDATE 
            activated = VALUES(activated),
			lang  = VALUES(lang),
			type  = VALUES(type),
			prefix = VALUES(prefix),
			gender  = VALUES(gender),
			first_name= VALUES(first_name),
			last_name   = VALUES(last_name),
			tel1  = VALUES(tel1),
			tel2  = VALUES(tel2),
			adr1  = VALUES(adr1),
			adr2  = VALUES(adr2),
			city = VALUES(city),
			province  = VALUES(province),
			country  = VALUES(country),
			postal_code    = VALUES(postal_code),
			eml1  = VALUES(eml1),
			eml2  = VALUES(eml2),
			note  = VALUES(note)
			";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>