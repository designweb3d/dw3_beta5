<?php
require_once 'security_db.php';
$schedule_id  = $_GET['ID'];
?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<title><?php echo $CIE_NOM; ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Orelega+One&family=Roboto:wght@100&display=swap" rel="stylesheet">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<meta name="msapplication-TileImage" content="https://dw3.ca/img/favicon.png" />
    <link rel="icon" type="image/png" href="/img/favicon.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/img/favicon-192.png" sizes="192x192">

    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/css/main.css.php'; ?>
    </style>
</head>
<body style='text-align:center;'>

<div id="divHEAD" style='left:0px;'>
	<table width="100%"><tr>
        <td style="width:40px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;">
				<a href='https://<? echo $_SERVER["SERVER_NAME"]; ?>'><button style="margin:0px 0px 0px 2px;padding:8px;background:#555555;">
				<span class="material-icons">arrow_back</span></button></a>
		</td>
        <td width="*"><h1><img id='imgLOGO_TOP' src="../img/logo.png?t=<?php echo(rand(100,100000)); ?>" style="width:32px;height:32px;"> Ajouter à votre calendrier</h1></td>
		<td width="30" onclick='openLANG();' style="width:40px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;"> 
        <button style="margin:0px 0px 0px 2px;padding:8px;background:#555555;">
				<span class="material-icons">translate</span></button>
        </td>
	</tr></table>
</div>
<div id="divFADE"></div>
<div id="divMSG"></div>
<div id="divOPT"></div>

<!--Add buttons to initiate auth sequence and sign out-->
<a href='https://outlook.live.com/calendar/0/deeplink/compose?allday=false&body=This%20is%20event%20description&enddt=2023-06-29T15%3A15%3A00%2B00%3A00&path=%2Fcalendar%2Faction%2Fcompose&rru=addevent&startdt=2023-06-29T14%3A45%3A00%2B00%3A00&subject=TestEvent'>
    <button style='padding:10px;'><img src='/png-transparent-blue-office-logo-computer-icons-outlook-com-microsoft-outlook-email-symbol-outlook-miscellaneous-blue-angle-thumbnail.png' style='height:50px;'><br>Outlook Calendar</button><br>
</a>    
<button id="authorize_button" onclick="handleAuthClick()" style='padding:10px;'><img src='/google-logo-png-google-icon-logo-png-transparent-svg-vector-bie-supply-14.png' style='height:50px;'><br>Google Calendar</button><br>
<button id="signout_button" onclick="handleSignoutClick()">Sign Out</button>

<pre id="content" style="white-space: pre-wrap;"></pre>

<?php 
$html = "";
$sql = "SELECT A.id as schedule_id, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name, A.customer_id, CONCAT(B.first_name, ' ',B.middle_name, ' ',B.last_name) as customer_name, B.eml1 as customer_email, A.product_id, C.name_fr as product_name,C.price1 as product_price,C.service_length as service_length,C.inter_length as inter_length, A.start_date as start_date, A.end_date as end_date
  FROM schedule_line A
  LEFT JOIN customer B ON B.id = A.customer_id
  LEFT JOIN product C ON C.id = A.product_id
  LEFT JOIN user D ON C.id = A.user_id
  WHERE A.id = '" . $schedule_id . "' ";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {	
  while($row = $result->fetch_assoc()) {
    $html = "<b style='float:left;padding:5px;'> ".substr($row["start_date"],0,10)."</b><table class='tblDATA' ><tr><th style='width:40px;'>De</th><th style='width:50px;'>À</th><th>Client</th><th>Produit/Service</th></tr>";
    $html .= "<tr><td>" . substr($row["start_date"],11,5)  . "</td><td>" . substr($row["end_date"],11,5)  . "</td><td>" . $row["customer_name"]  . "</td><td>" . $row["product_name"]  . "</td></tr>";
    $start_date = $row["start_date"];
    $end_date = $row["end_date"];
    $customer_name = $row["customer_name"];
    $customer_email = $row["customer_email"];
    $product_name = $row["product_name"];
  }
} else {
        $html .= "<tr><td colspan=5>Aucuns rendez-vous trouvé, il a probablement été annulé.</td></tr>";
}
echo $html . "</table>";
?><br></br>
<div style='float:right;'>Google Calandar<br style='margin:0;'>
  <a href='https://calendar.google.com/calendar/u/0/r/month' target='_blank'><img src='https://ssl.gstatic.com/calendar/images/dynamiclogo_2020q4/calendar_30_2x.png'></a>
</div>

<script type="text/javascript">
  /* exported gapiLoaded */
  /* exported gisLoaded */
  /* exported handleAuthClick */
  /* exported handleSignoutClick */

  // TODO(developer): Set to client ID and API key from the Developer Console
  const CLIENT_ID = '';
  const API_KEY = '';

  // Discovery doc URL for APIs used by the quickstart
  const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest';

  // Authorization scopes required by the API; multiple scopes can be
  // included, separated by spaces.
  const SCOPES = 'https://www.googleapis.com/auth/calendar';

  let tokenClient;
  let gapiInited = false;
  let gisInited = false;

  document.getElementById('authorize_button').style.visibility = 'hidden';
  document.getElementById('signout_button').style.visibility = 'hidden';
  //document.getElementById('add_event_button').style.visibility = 'hidden';

  /**
   * Callback after api.js is loaded.
   */
  function gapiLoaded() {
    gapi.load('client', initializeGapiClient);
  }

  /**
   * Callback after the API client is loaded. Loads the
   * discovery doc to initialize the API.
   */
  async function initializeGapiClient() {
    await gapi.client.init({
      apiKey: API_KEY,
      discoveryDocs: [DISCOVERY_DOC],
    });
    gapiInited = true;
    maybeEnableButtons();
  }

  /**
   * Callback after Google Identity Services are loaded.
   */
  function gisLoaded() {
    tokenClient = google.accounts.oauth2.initTokenClient({
      client_id: CLIENT_ID,
      scope: SCOPES,
      callback: '', // defined later
    });
    gisInited = true;
    maybeEnableButtons();
  }

  /**
   * Enables user interaction after all libraries are loaded.
   */
  function maybeEnableButtons() {
    if (gapiInited && gisInited) {
      document.getElementById('authorize_button').style.visibility = 'visible';
    }
  }

  /**
   *  Sign in the user upon button click.
   */
  function handleAuthClick() {
    tokenClient.callback = async (resp) => {
      if (resp.error !== undefined) {
        throw (resp);
      }
      //document.getElementById('add_event_button').style.visibility = 'visible';
      //document.getElementById('add_event_button').click();
      addEvent();
      document.getElementById('signout_button').style.visibility = 'visible';
      document.getElementById('authorize_button').innerText = 'Refresh';
      
    };

    if (gapi.client.getToken() === null) {
      // Prompt the user to select a Google Account and ask for consent to share their data
      // when establishing a new session.
      tokenClient.requestAccessToken({prompt: 'consent'});
    } else {
      // Skip display of account chooser and consent dialog for an existing session.
      tokenClient.requestAccessToken({prompt: ''});
    }
  }

  /**
   *  Sign out the user upon button click.
   */
  function handleSignoutClick() {
    const token = gapi.client.getToken();
    if (token !== null) {
      google.accounts.oauth2.revoke(token.access_token);
      gapi.client.setToken('');
      document.getElementById('content').innerText = '';
      document.getElementById('authorize_button').innerText = 'Authorize';
      document.getElementById('signout_button').style.visibility = 'hidden';
    }
  }

  /**
   * Print the summary and start datetime/date of the next ten events in
   * the authorized user's calendar. If no events are found an
   * appropriate message is printed.
   */
  async function listUpcomingEvents() {
    let response;
    try {
      const request = {
        'calendarId': 'primary',
        'timeMin': (new Date()).toISOString(),
        'showDeleted': false,
        'singleEvents': true,
        'maxResults': 10,
        'orderBy': 'startTime',
      };
      response = await gapi.client.calendar.events.list(request);
    } catch (err) {
      document.getElementById('content').innerText = err.message;
      return;
    }

    const events = response.result.items;
    if (!events || events.length == 0) {
      document.getElementById('content').innerText = 'No events found.';
      return;
    }
    // Flatten to string to display
    const output = events.reduce(
        (str, event) => `${str}${event.summary} (${event.start.dateTime || event.start.date}) ${event.description}\n`,
        "\n10 prochains rendez-vous dans l'agenda Google\n");
    document.getElementById('content').innerText = output;
  }

//add event
async function addEvent() {
  
  let s = new Date('<?php echo $start_date; ?>');
  s.setMinutes(s.getMinutes() - s.getTimezoneOffset());
  var schedule_start = s.toISOString();
  let e = new Date('<?php echo $end_date; ?>');
  e.setMinutes(e.getMinutes() - e.getTimezoneOffset());
  var schedule_end = e.toISOString();
  //let schedule_end = new Date('<?php echo $end_date; ?>').toLocaleString("en-US", {timeZone: "America/New_York"}).toISOString();

    const event = {
    'summary': '<?php echo $product_name; ?>',
    'location': '<?php echo $CIE_ADR1." ".$CIE_ADR2." ".$CIE_VILLE." ".$CIE_PROV." ".$CIE_PAYS." ".$CIE_CP; ?>',
    'description': '<?php echo $user_name; ?>',
    'start': {
        'dateTime': schedule_start,
        'timeZone': 'America/New_York'
    },
    'end': {
        'dateTime': schedule_end,
        'timeZone': 'America/New_York'
    },
    //'recurrence': [
    //    'RRULE:FREQ=DAILY;COUNT=2'
    //],
    'attendees': [
        {'email': '<?php echo $customer_email; ?>'}
    ],
    'reminders': {
        'useDefault': false,
        'overrides': [
        {'method': 'email', 'minutes': 24 * 60},
        {'method': 'popup', 'minutes': 10}
        ]
    }
    };

    //const request = gapi.client.calendar.events.insert({
    //'calendarId': 'primary',
    //'resource': event
    //});
    let response;
    try {
        const request = {
            'calendarId': 'primary',
            'resource': event
        };
        response = await gapi.client.calendar.events.insert(request);
    } catch (err) {
        document.getElementById('content').innerText = err.message;
        return;
    }
    //request.execute(function(event) {
    //appendPre('Event created: ' + event.htmlLink);
    //});

    const events = response;
    if (!events || events.length == 0) {
      //document.getElementById('content').innerText = 'No events found.';
      return;
    } else {
      //window.open('https://calendar.google.com/calendar/u/0/r/month','_self');
      addNotif("Rendez-vous ajouté à Google Calandar");
      setTimeout(listUpcomingEvents, 3000);
    }
    
  }

  dateWithTimeZone = (timeZone, year, month, day, hour, minute, second) => {
  let date = new Date(Date.UTC(year, month, day, hour, minute, second));

  let utcDate = new Date(date.toLocaleString('en-US', { timeZone: "UTC" }));
  let tzDate = new Date(date.toLocaleString('en-US', { timeZone: timeZone }));
  let offset = utcDate.getTime() - tzDate.getTime();

  date.setTime( date.getTime() + offset );

  return date;
};


function addNotif(text) { //rename to dw3_notif(text);
    const newDiv = document.createElement("div");
    //const newContent = document.createTextNode(String());
    //const newContent2 = document.createTextNode(" X ");
    newDiv.style.position = "fixed";
    newDiv.style.right = "0px";
    newDiv.style.top = "10px";
    newDiv.style.background = "#EEE";
    newDiv.style.borderRadius = "5px";
    newDiv.style.color = "darkgreen";
    newDiv.style.border = "1px dotted darkgreen";
    newDiv.style.zIndex = "300";
    newDiv.style.transition ="opacity 1s linear";
    newDiv.style.fontWeight ="bold";
    newDiv.style.fontSize ="24px";
    newDiv.style.textShadow ="2px 2px #DDDDDD";
    newDiv.style.padding ="5px 10px 5px 10px";
    newDiv.style.margin ="10px";
    //newContent2.style.background = "white";
    //newContent2.style.color = "darkgreen";
    //newDiv.appendChild(newContent2);
    newDiv.innerHTML = "&#x26A0; " + text;
    const currentDiv = document.getElementById("divHEAD");
    document.body.insertBefore(newDiv, currentDiv);
    setTimeout(function () {
		newDiv.style.opacity = "0";
	}, 5000);
    setTimeout(function () {
		newDiv.style.display = "none";
        newDiv.remove();
	}, 6000);
}


function detectCLICK(event,that){  //rename to dw3_input_click(event,that);
	var x = event.offsetX;
	if (x > (that.offsetWidth-25)){
        that.select();
	}
}

</script>
<script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
<script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>
</body>
</html><?php 
die("");
?>
