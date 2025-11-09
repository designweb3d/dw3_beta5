<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$schedule_id = $_GET['ID']??'-1';
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=invite.ics');

$sql = "SELECT A.id as schedule_id, A.iso_start as iso_start, A.iso_end as iso_end, 
A.user_id as user_id,
CONCAT(D.first_name, ' ',D.last_name) as user_name, 
A.customer_id, 
B.eml1 as customer_email, 
CONCAT(B.first_name, ' ',B.middle_name, ' ',B.last_name) as customer_name, 
A.product_id, C.name_fr as product_name,
C.price1 as product_price,
C.service_length as service_length,
C.inter_length as inter_length, 
A.start_date as start_date,
A.end_date as end_date
            FROM schedule_line A
            LEFT JOIN customer B ON B.id = A.customer_id
            LEFT JOIN product C ON C.id = A.product_id
            LEFT JOIN user D ON C.id = A.user_id
			WHERE A.id = '" . $schedule_id . "' ";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
                    $iso_now = str_replace("-","",$datetime);
                    $iso_now = str_replace(":","",$iso_now);
                    $iso_now = str_replace(" ","T",$iso_now);
                    $iso_now .= "0Z";
                    $iso_begin = str_replace("-","",$row["start_date"]);
                    $iso_begin = str_replace(":","",$iso_begin);
                    $iso_begin = str_replace(" ","T",$iso_begin);
                    $iso_end = str_replace("-","",$row["end_date"]);
                    $iso_end = str_replace(":","",$iso_end);
                    $iso_end = str_replace(" ","T",$iso_end);
                    echo "BEGIN:VCALENDAR\n" .
                    "CALSCALE:GREGORIAN\n" .
                    "METHOD:PUBLISH\n" .
                    "PRODID:-//Send project Invite//EN\n" .
                    "VERSION:2.0\n" .
                    "BEGIN:VTIMEZONE\n".
                    "TZID:America/New_York\n".
                    "LAST-MODIFIED:20050809T050000Z\n".
                    "BEGIN:STANDARD\n".
                    "DTSTART:20071104T020000\n".
                    "TZOFFSETFROM:-0400\n".
                    "TZOFFSETTO:-0500\n".
                    "TZNAME:EST\n".
                    "END:STANDARD\n".
                    "BEGIN:DAYLIGHT\n".
                    "DTSTART:20070311T020000\n".
                    "TZOFFSETFROM:-0500\n".
                    "TZOFFSETTO:-0400\n".
                    "TZNAME:EDT\n".
                    "END:DAYLIGHT\n".
                    "END:VTIMEZONE\n".
                    "BEGIN:VEVENT\n" .
                    "UID:VCalendar\n" .
                    "DTSTAMP:" . $iso_now ."\n" .
                    "DTSTART:" . $iso_begin ."\n" .
                    "DTEND:" .  $iso_end .  "\n" .
                    "SUMMARY:" .  $row["product_name"] .  "\n" .
                    "DESCRIPTION:" .  'Rendez-vous' .  "\n" .
                    "LOCATION:" .   $CIE_ADR1." ".$CIE_ADR2.", ".$CIE_VILLE.", ".$CIE_CP.  "\n" .
                    "BEGIN:VALARM" .   "\n" .
                    "TRIGGER:-PT24H" .   "\n" .
                    "ACTION:DISPLAY" .   "\n" .
                    "DESCRIPTION:Reminder" .   "\n" .
                    "END:VALARM\n" .
                    "END:VEVENT\n" .
                    "END:VCALENDAR";  
                    					}
                }

$dw3_conn->close();exit; ?>