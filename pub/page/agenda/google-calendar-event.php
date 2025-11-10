<?php
echo "done access<br>";

/**
 * Plugin Name: Google Calendar Event
 * Description: create custom google calendar events.
 * Version: 1.0.0
 * Author: Finegap
 * Author URI: https://finegap.com
 * Text Domain: Google Calendar
 */

// Exit if accessed directly
//defined('ABSPATH') || exit;
echo "done define<br>";

ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');
ini_set('display_errors', 1);
echo "done set<br>";
/**
 *  update google code
 */
//add_action('wp_footer', 'create_google_calendar_events');
create_google_calendar_events();
echo "done action<br>";
function create_google_calendar_events()
{
    $credentials = __DIR__ . '/credentials.json';
    require '/api/google/vendor/autoload_calendar.php';
    
    $client = new Google_Client();
    $client->setApplicationName('testoo');
    $client->setScopes(array(Google_Service_Calendar::CALENDAR));
    $client->setAuthConfig($credentials);
    $client->setAccessType('offline');
    $client->getAccessToken();
    $client->getRefreshToken(); 

    $service = new Google_Service_Calendar($client);

    $event   = new Google_Service_Calendar_Event(array(
        'summary' => 'testing',
        'location' => '800 Howard St., San Francisco, CA 94103',
        'description' => 'A chance to hear more about Google\'s developer products.',
        'start' => array(
        'dateTime' => '2023-06-28T09:00:00-07:00',
        'timeZone' => 'America/New_York',
        ),
        'end' => array(
        'dateTime' => '2023-06-28T17:00:00-07:00',
        'timeZone' => 'America/New_York',
        ),
        'recurrence' => array(
            'RRULE:FREQ=DAILY;COUNT=2'
        ),
        'attendees' => array(),  
        'reminders' => array(
        'useDefault' => FALSE,
        'overrides' => array(
            array('method' => 'email', 'minutes' => 24 * 60),
            array('method' => 'popup', 'minutes' => 10),
        ),
        ),
    ));
    
    $calendarId = 'firescript@gmail.com'; //labelleannie17@gmail.com
    $event      = $service->events->insert($calendarId, $event);
    echo "done insert<br>";
    print_r($event->htmlLink);
    echo "done print<br>";
}
// array('method' => 'popup', 'minutes' =>  $now_diff-5)
//
//array('email' => $calendar)//labelleannie17@gmail.com
          