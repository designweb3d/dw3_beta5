<?php
// Exit if accessed directly
//defined('ABSPATH') || exit;
//require_once 'security_db.php';

ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');
ini_set('display_errors', 1);

create_google_calendar_events();
//echo "done action<br>";
function create_google_calendar_events()
{
    $credentials = __DIR__ . '/credentials.json';
    require '/api/google/vendor/autoload_calendar.php';
    
    $client = new Google_Client();
    $client->setApplicationName('Google_Calendar');
    $client->setScopes(array(Google_Service_Calendar::CALENDAR));
    $client->setAuthConfig($credentials);
    $client->setAccessType('offline');
    $client->getAccessToken();
    $client->getRefreshToken(); 

    $service = new Google_Service_Calendar($client);

    date_default_timezone_set('America/New_York');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
    $conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        $conn->close();
        header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
        exit;
    }
    $summary = mysqli_real_escape_string($conn,$_GET['S']??'Rendez-vous');
    $location = mysqli_real_escape_string($conn,$_GET['L']??'34 Rue Turenne, Saint-Charles-Borromée, QC J6E 7G5');
    $description = mysqli_real_escape_string($conn,$_GET['D']??'');
    $date_from = mysqli_real_escape_string($conn,$_GET['F']??'');
    $date_to = mysqli_real_escape_string($conn,$_GET['T']??'');
    $recurrence = mysqli_real_escape_string($conn,$_GET['R']??'');
    $calendar = mysqli_real_escape_string($conn,$_GET['C']??'firescript@gmail.com');
    $datetime = strtotime(date("Y-m-d H:i:s"));
    $now_diff = floor((strtotime($date_from)-$datetime)/60);
    //echo substr($date_to,0,19).'-04:00';
    //echo  $now_diff;
    echo substr($date_from,0,20);
    $event = new Google_Service_Calendar_Event(array(
        'summary' => $summary,
        'location' => $location,
        'description' => $description,
        'start' => array(
        'dateTime' => substr($date_from,0,20).'-04:00',
        'timeZone' => 'America/Toronto',
        ),
        'end' => array(
        'dateTime' => substr($date_to,0,20).'-04:00',
        'timeZone' => 'America/Toronto',
        )
    ));
    $reminder = new Google_Service_Calendar_EventReminder();
    $reminder->setMethod('email');
    $reminder->setMinutes(24*60);
    $reminders = new Google_Service_Calendar_EventReminders();
    $reminders->setUseDefault(false);
    $reminders->setOverrides(array($reminder));
    $event->setReminders($reminders);

    $optionalParameters = array(
        "sendUpdates" => "all",'sendNotifications' => true
    );
    $calendarId = $calendar; //firescript@gmail.com
    $event      = $service->events->insert($calendarId, $event, $optionalParameters);
    //echo "done insert<br>";
    //print_r($event->htmlLink);
    $parts = parse_url($event->htmlLink);
    parse_str($parts['query'], $query);
    //die($query['eid']);
    die("");
    //echo "done print<br>";
}
