<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';
?>

<div id='divHEAD'>
<table style="width:100%;margin:0px;white-space:nowrap;"><tr style="margin:0px;padding:0px;"><td width="*" style="margin:0px;padding:0px;text-align:middle;">
<div>
            <select name="month" id="month" onchange="jump();" style="display:inline-block;width:45%;">
                <option value=0>Janvier</option>
                <option value=1>Février</option>
                <option value=2>Mars</option>
                <option value=3>Avril</option>
                <option value=4>Mai</option>
                <option value=5>Juin</option>
                <option value=6>Juillet</option>
                <option value=7>Août</option>
                <option value=8>Septembre</option>
                <option value=9>Octobre</option>
                <option value=10>Novembre</option>
                <option value=11>Décembre</option>
            </select>
            <select name="year" id="year" onchange="jump()" style="display:inline-block;width:45%;">
                <option value=2023>2023</option>
                <option value=2024>2024</option>
                <option value=2025>2025</option>
                <option value=2026>2026</option>
                <option value=2027>2027</option>
                <option value=2028>2028</option>
                <option value=2029>2029</option>
                <option value=2030>2030</option>
                <option value=2031>2031</option>
                <option value=2032>2032</option>
                <option value=2033>2033</option>
                <option value=2034>2034</option>
                <option value=2035>2035</option>
                <option value=2036>2036</option>
                <option value=2037>2037</option>
                <option value=2038>2038</option>
                <option value=2039>2039</option>
                <option value=2040>2040</option>
                <option value=2041>2041</option>
                <option value=2042>2042</option>
                <option value=2043>2043</option>
                <option value=2044>2044</option>
                <option value=2045>2045</option>
                <option value=2046>2046</option>
                <option value=2047>2047</option>
                <option value=2048>2048</option>
                <option value=2049>2049</option>
                <option value=2050>2050</option>
                <option value=2051>2051</option>
                <option value=2052>2052</option>
                <option value=2053>2053</option>
                <option value=2054>2054</option>
                <option value=2055>2055</option>
                <option value=2056>2056</option>
                <option value=2057>2057</option>
                <option value=2058>2058</option>
                <option value=2059>2059</option>
                <option value=2060>2060</option>
                <option value=2061>2061</option>
                <option value=2062>2062</option>
                <option value=2063>2063</option>
                <option value=2064>2064</option>
                <option value=2065>2065</option>
                <option value=2066>2066</option>
                <option value=2067>2067</option>
                <option value=2068>2068</option>
                <option value=2069>2069</option>
                <option value=2070>2070</option>
                <option value=2071>2071</option>
                <option value=2072>2072</option>
                <option value=2073>2073</option>
                <option value=2074>2074</option>
                <option value=2075>2075</option>
                <option value=2076>2076</option>
                <option value=2077>2077</option>
                <option value=2078>2078</option>
                <option value=2079>2079</option>
                <option value=2080>2080</option>
                <option value=2081>2081</option>
                <option value=2082>2082</option>
                <option value=2083>2083</option>
                <option value=2084>2084</option>
                <option value=2085>2085</option>
                <option value=2086>2086</option>
                <option value=2087>2087</option>
                <option value=2088>2088</option>
                <option value=2089>2089</option>
                <option value=2090>2090</option>
                <option value=2091>2091</option>
                <option value=2092>2092</option>
                <option value=2093>2093</option>
                <option value=2094>2094</option>
                <option value=2095>2095</option>
                <option value=2096>2096</option>
                <option value=2097>2097</option>
                <option value=2098>2098</option>
                <option value=2099>2099</option>
                <option value=2100>2100</option>
            <select>
        </div>	  </td><td width="100" style="margin:0px;padding:0px;text-align:right;">
		<button style="margin:0px 2px 0px 2px;padding:8px;font-size:0.8em;" onclick="openFILTRE();"><span class="material-icons">filter_alt</span></button>
		<button style="margin:0px 2px 0px 2px;padding:8px;background:#555555;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
	  </td></tr></table>
</div>

<div id='divFILTRE' style='top:5px;max-height:95%;'>
<h3>Filtre</h3>
		<table style='width:100%'>
            <tr><td width='*'>Évenements</td><td><input type='checkbox' checked id='dsp_event'></td></tr>
            <tr><td width='*'>Courriels</td><td><input type='checkbox' checked id='dsp_email'></td></tr>
            <tr><td width='*'>Commandes clients</td><td><input type='checkbox' checked id='dsp_order'></td></tr>
            <tr><td width='*'>Plages horaires</td><td><input type='checkbox' checked id='dsp_schedule_head'></td></tr>
            <tr><td width='*'>Rendez-vous</td><td><input type='checkbox' checked id='dsp_schedule_line'></td></tr>
            <tr><td width='*'>Nouveaux clients</td><td><input type='checkbox' checked id='dsp_new_customer'></td></tr>
        </table><br>
        <div style='box-shadow:0px 0px 3px 3px grey;margin:5px;display:inline-block;width:100%;max-width:100%;max-height:150px;overflow-x:hidden;overflow-y:auto;'>
            
            <form id='frm_dsp_user'><table style='width:100%;max-width:100%;max-height:150px;'>
            <tr style='position:sticky;top:0px;background:rgba(255,255,255,0.8);'><td><h3>Employés</h3></td></tr><tr><td>
                <input checked id='dsp_user_all' onclick='check_user_all();' type='checkbox'> <label for='dsp_user_all'>Tous</label><br>
                <?php
                    $sql = "SELECT * FROM user ORDER BY last_name, first_name";
                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            echo "<input name='dsp_user' id='dsp_user".$row["id"]."' value='".$row["id"]."' type='checkbox' checked> <label for='dsp_user".$row["id"]."'>" . $row["last_name"]  .", ".$row["first_name"]  . "</label><br>";
                        }
                    }
                ?>
            </td></tr>
            </table></form>
        </div>
        <div style='box-shadow:0px 0px 3px 3px grey;margin:5px;display:inline-block;width:100%;max-width:100%;max-height:150px;overflow-x:hidden;overflow-y:auto;'>
            <form id='frm_dsp_customer'><table style='width:100%;max-width:100%;max-height:150px;'>
            <tr style='position:sticky;top:0px;background:rgba(255,255,255,0.8);'><td><h3>Clients</h3></td></tr><tr><td>
                <input checked id='dsp_customer_all'  onclick='check_customer_all();' type='checkbox'> <label for='dsp_customer_all'>Tous</label><br>
                <?php
                    $sql = "SELECT * FROM customer ORDER BY last_name, first_name";
                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            echo "<input name='dsp_customer' id='dsp_customer".$row["id"]."' value='".$row["id"]."' type='checkbox' checked> <label for='dsp_customer".$row["id"]."'>" . dw3_decrypt($row["last_name"])  .", ".dw3_decrypt($row["first_name"])  . "</label><br>";
                        }
                    }
                ?>
            </td></tr>
            </table></form>
        </div>
		<div style='width:100%;text-align:center;'><button style='background:#444;' onclick="closeFILTRE();"><span class="material-icons">cancel</span> Annuler</button><button onclick="closeFILTRE();getM();"><span class="material-icons">filter_alt</span> Filtrer</button></div>
</div>

<div id='divCAL' style='margin-top:46px;'>           
    <h3><button onclick="previous();"><span class="material-icons">skip_previous</span></button> 
			<span id="monthAndYear" style='min-width:175px;'></span>
	 	<button onclick="next();"><span class="material-icons">skip_next</span></button></h3>
        <table id="calendar" class='tblCAL'>
            <thead>
            <tr>
                <th width='7%'>Dim</th>
                <th width='17%'>Lun</th>
                <th width='17%'>Mar</th>
                <th width='17%'>Mer</th>
                <th width='17%'>Jeu</th>
                <th width='17%'>Ven</th>
                <th width='8%'>Sam</th>
            </tr>
            </thead>

            <tbody id="calendar-body">

            </tbody>
        </table>
</div>

<div id='divMAIN' class='divMAIN' style='background:rgba(0,0,0,0);min-height:30vh;'></div>
<div id='divMAIN2' class='divMAIN' style='background:rgba(255,255,255,0.5);min-height:30vh;'></div>
<div id="divEDIT" class="divEDITOR"></div>

<div id="divMSG"></div>
<div id="divOPT"></div>
<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;"></div>
<script src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
$(document).ready(function ()
    {
		getM();
		getD(currentDay);
        //dragElement(document.getElementById('divNEW_HEAD'));
});
let current_schedule = [];
let selectedDate = new Date();
let today = new Date();
let currentDay = today.getDate();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let selectYear = document.getElementById("year");
let selectMonth = document.getElementById("month");
let selectedDispo = "90";
let selectedPrd = "";
let selectedDesc = "";
let months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aôut", "Septembre", "Octobre", "Novembre", "Décembre"];

let monthAndYear = document.getElementById("monthAndYear");

//showCalendar(currentMonth, currentYear);
//getM();

function  check_user_all() {
    var is_checked = document.getElementById("dsp_user_all").checked;
    var elements = document.getElementById("frm_dsp_user").elements;
    for (var i = 0, element; element = elements[i++];) {
        if (element.type === "checkbox" && element.name === "dsp_user") {        
            if (is_checked == true){
                element.checked = true;
            }else {
                element.checked = false;
            }
        }
    }
}

function  check_customer_all() {
    var is_checked = document.getElementById("dsp_customer_all").checked;
    var elements = document.getElementById("frm_dsp_customer").elements;
    for (var i = 0, element; element = elements[i++];) {
        if (element.type === "checkbox" && element.name === "dsp_customer") {        
            if (is_checked == true){
                element.checked = true;
            }else {
                element.checked = false;
            }
        }
    }
}

function next() {
    currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    getM();
}

function previous() {
    currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    getM();
}

function jump() {
    currentYear = parseInt(selectYear.value);
    currentMonth = parseInt(selectMonth.value);
    getM();
}

function showCalendar(month, year) {

    let firstDay = (new Date(year, month)).getDay();
    let daysInMonth = 32 - new Date(year, month, 32).getDate();

    let tbl = document.getElementById("calendar-body"); // body of the calendar

    // clearing all previous cells
    tbl.innerHTML = "";

    // filing data about month and in the page via DOM.
    monthAndYear.innerHTML = months[month] + " " + year;
    selectYear.value = year;
    selectMonth.value = month;

    // creating all cells
    let date = 1;
    for (let i = 0; i < 6; i++) {
        // creates a table row
        let row = document.createElement("tr");
        row.style.maxHeight = "none";
        //creating individual cells, filing them up with data.
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) {
                let cell = document.createElement("td");
                let cellText = document.createTextNode("");
                cell.style.backgroundColor = "rgba(255,255,255,0)";
                cell.style.borderRight = "1px solid #fff";
                cell.style.borderLeft = "1px solid #fff";
                //cell.style.height = "0px";
				cell.style.maxHeight = "none";
                cell.appendChild(cellText);
                row.appendChild(cell);
            }
            else if (date > daysInMonth) {
                break;
            }
            else {
                var cell = document.createElement("td");
				//cell.style.height = "20px";
				cell.style.maxHeight = "none";
				cell.style.textAlign = "center";
                cell.style.padding = "1px";
                cell.style.maxWidth = "14%";
                if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                    //cell
                    cell.style.backgroundColor = "rgba(255,200,100,0.5)";
                } // color today's date
                if (parseInt(date) === today.getDate() && parseInt(year) === today.getFullYear() && parseInt(month) === (today.getMonth()+1)) {
                    //cell
                    cell.style.backgroundColor = "rgba(255,200,100,0.5)";
                } // color today's date
                if (parseInt(date) === parseInt(currentDay) && parseInt(year) === parseInt(currentYear) && parseInt(month) === parseInt(currentMonth)) {
                    //cell
                    cell.style.backgroundColor = "rgba(50,200,255,0.5)";
                }
                
                var xhtml = "<div style='padding-left:3px;width:100%;text-align:left;margin-bottom:5px;'>" + date + "</div><div style='height:60px;'>";
				cell.style.cursor = "pointer";
				let tmpday = date;
                let dayEmails = 0;
                let daySchedules = 0;
                let dayAppointments = 0;
                let dayEvents = 0;
				cell.onclick = function () {
					//this.parentElement.removeChild(this);
					getD(tmpday);
                    showCalendar(month, year);
				};
				var iloop = 0;
				for (var iloop=0; iloop<current_schedule.length; iloop++) {
					//for (var head_id in current_schedule[iloop]) {
							//console.log(current_schedule[iloop][schedule_id]);
							let tmpDateStart = new Date(current_schedule[iloop].start_date);
							let tmpDateEnd = new Date(current_schedule[iloop].end_date);
			                if (date === tmpDateStart.getDate() && year === tmpDateStart.getFullYear() && month === tmpDateStart.getMonth()) {
                                if (current_schedule[iloop].type == "schedule_line"){
                                    dayAppointments++;
                                    if (current_schedule[iloop].user_pic_type == "AVATAR"){
                                        //var svgCode = multiavatar(current_schedule[iloop].user_face);
                                        //xhtml += "<div style='font-size:0.7em;text-align:left;'><div style='width:16px;height:16px;'>"+svgCode+"</div> " + current_schedule[iloop].start_date.substr(11, 5) + "-" + current_schedule[iloop].description + "</div>";
                                    }else if (current_schedule[iloop].user_pic_type == "PHOTO"){
                                        //xhtml += "<div style='font-size:0.7em;text-align:left;'><img style='width:16px;height:16px;' src='/fs/user/" + current_schedule[iloop].user_id +".png' /> " + current_schedule[iloop].start_date.substr(11, 5) + "-" + current_schedule[iloop].description + "</div>";
                                    }else if (current_schedule[iloop].user_pic_type == "PICTURE"){
                                        //xhtml += "<div style='font-size:0.7em;text-align:left;'><img style='width:16px;height:16px;' src='/pub/upload/" + current_schedule[iloop].user_pic + "' /> " + current_schedule[iloop].start_date.substr(11, 5) + "-" + current_schedule[iloop].description + "</div>";
                                    }else if (current_schedule[iloop].user_pic_type == "PICTURE2"){
                                        //xhtml += "<div style='font-size:0.7em;text-align:left;'><img style='width:16px;height:16px;' src='/pub/img/avatar/" + current_schedule[iloop].user_pic+ "' /> " + current_schedule[iloop].start_date.substr(11, 5) + "-" + current_schedule[iloop].description + "</div>";
                                    }
                                }else if (current_schedule[iloop].type == "schedule_head"){
                                    daySchedules++
                                }else if (current_schedule[iloop].type == "event"){
                                    dayEvents++;
                                    //xhtml += "<div style='font-size:0.7em;text-align:left;'><span class='material-icons' style='font-size:16px;'>settings</span> " + current_schedule[iloop].start_date.substr(11, 5) + "-" + current_schedule[iloop].description + "</div>";
                                }else if (current_schedule[iloop].type == "email"){
                                    dayEmails++;
                                    //xhtml += "<div style='font-size:0.7em;text-align:left;'><span class='material-icons' style='font-size:16px;'>mail</span> " + current_schedule[iloop].start_date.substr(11, 5) + "-" + current_schedule[iloop].customer_name + "</div>";
                                }
								//cell.style.backgroundColor = "rgba(50,250,20,0.5)";
							}
					//}
				}
                if (dayEmails>0){
                    xhtml += "<div style='font-size:0.7em;text-align:left;'><span class='material-icons' style='font-size:16px;'>mail</span><span style='min-width:15px;text-align:center;'>"+dayEmails+"</span> Courriels</div>";
                }
                if (daySchedules>0){
                    xhtml += "<div style='font-size:0.7em;text-align:left;'><span class='material-icons' style='font-size:16px;'>schedule</span><span style='min-width:15px;text-align:center;'>"+daySchedules+"</span> Plages horaires</div>";
                }
                if (dayAppointments>0){
                    xhtml += "<div style='font-size:0.7em;text-align:left;'><span class='material-icons' style='font-size:16px;'>face</span><span style='min-width:15px;text-align:center;'>"+dayAppointments+"</span> Rendez-vous</div>";
                }
                if (dayEvents>0){
                    xhtml += "<div style='font-size:0.7em;text-align:left;'><span class='material-icons' style='font-size:16px;'>settings</span><span style='min-width:15px;text-align:center;'>"+dayEvents+"</span> Évenements</div>";
                }
                //let cellText = document.createTextNode(date);
                cell.innerHTML = xhtml + "</div>";
                //cell.appendChild(cellText);
                row.appendChild(cell);
                
                date++;
            }


        }

        tbl.appendChild(row); // appending each row into calendar body.
    }

}
  
function getM() {
    var dspEvent = document.getElementById("dsp_event").checked;
    var dspEmail = document.getElementById("dsp_email").checked;
    var dspOrder = document.getElementById("dsp_order").checked;
    var dspSL = document.getElementById("dsp_schedule_line").checked;
    var dspSH = document.getElementById("dsp_schedule_head").checked;
    var dspNewC = document.getElementById("dsp_new_customer").checked;

    var dspUser = "";
    if (!document.getElementById("dsp_user_all").checked){
        var elements = document.getElementById("frm_dsp_user").elements;
        var ii=0;
        for (var i = 0, element; element = elements[i++];) {
            if (element.type === "checkbox" && element.name === "dsp_user" && element.checked == true) {  
                ii++;
                if (ii!=1){
                    dspUser += ",";
                }      
                dspUser +=  element.value;
            }
        }
    }

    var dspCustomer = "";
    if (!document.getElementById("dsp_customer_all").checked){
        var elements = document.getElementById("frm_dsp_customer").elements;
        var ii=0;
        for (var i = 0, element; element = elements[i++];) {
            if (element.type === "checkbox" && element.name === "dsp_customer" && element.checked == true) {        
                ii++;
                if (ii!=1){
                    dspCustomer += ",";
                }      
                dspCustomer +=  element.value;
            }
        }
    }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim() !=''){
            current_schedule = JSON.parse(this.responseText);
            current_schedule = current_schedule.sort((a, b) => {
                if (a.start_date < b.start_date) {
                    return -1;
                }
            });
            showCalendar(currentMonth, currentYear);
        }
	  }
	};
		xmlhttp.open('GET', 'getMONTH.php?KEY=' + KEY + 
                                '&DU=' + dspUser + 
                                '&DC=' + dspCustomer +
                                '&E=' + dspEvent +
                                '&A=' + dspEmail +
                                '&O=' + dspOrder +
                                '&SH=' + dspSH +
                                '&SL=' + dspSL +
                                '&NC=' + dspNewC +
                                '&M=' + (currentMonth+1) +
                                '&Y=' + currentYear  
                                , true);
		xmlhttp.send();	
}

function getEMAILS(this_date) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMAIN2").innerHTML = "<h1 style='text-shadow:1px 1px 3px rgba(0,0,0,0.5);color:#ddd;'>Courriels</h1>" + this.responseText;
		//getCLIS('');
	  }
	};
		xmlhttp.open('GET', 'getEMAILS.php?KEY=' + KEY + '&D=' + encodeURIComponent(this_date), true);
		xmlhttp.send();	
}

function getD(day=currentDay) {
    var dspEvent = document.getElementById("dsp_event").checked;
    var dspEmail = document.getElementById("dsp_email").checked;
    var dspOrder = document.getElementById("dsp_order").checked;
    var dspSL = document.getElementById("dsp_schedule_line").checked;
    var dspSH = document.getElementById("dsp_schedule_head").checked;
    var dspNewC= document.getElementById("dsp_new_customer").checked;


    var dspUser = "";
    if (!document.getElementById("dsp_user_all").checked){
        var elements = document.getElementById("frm_dsp_user").elements;
        var ii=0;
        for (var i = 0, element; element = elements[i++];) {
            if (element.type === "checkbox" && element.name === "dsp_user" && element.checked == true) {  
                ii++;
                if (ii!=1){
                    dspUser += ",";
                }      
                dspUser +=  element.value;
            }
        }
    }

    var dspCustomer = "";
    if (!document.getElementById("dsp_customer_all").checked){
        var elements = document.getElementById("frm_dsp_customer").elements;
        var ii=0;
        for (var i = 0, element; element = elements[i++];) {
            if (element.type === "checkbox" && element.name === "dsp_customer" && element.checked == true) {        
                ii++;
                if (ii!=1){
                    dspCustomer += ",";
                }      
                dspCustomer +=  element.value;
            }
        }
    }

	currentDay=day;
	var xday = new Date(currentYear + "/" + (currentMonth+1) + "/" + day);
	switch(xday.getDay()) {
	case 0:
		// dimanche
		var dayname_of_week = "Dimanche";
		break;
	case 1:
		// lundi
		var dayname_of_week = "Lundi";
		break;
	case 2:
		// lundi
		var dayname_of_week = "Mardi";
		break;
	case 3:
		// lundi
		var dayname_of_week = "Mercredi";
		break;
	case 4:
		// lundi
		var dayname_of_week = "Jeudi";
		break;
	case 5:
		// lundi
		var dayname_of_week = "Vendredi";
		break;
	case 6:
		// lundi
		var dayname_of_week = "Samedi";
		break;
	default:
		// code block
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divMAIN").innerHTML = "<h3 style='text-shadow:1px 1px 3px rgba(0,0,0,0.5);color:#ddd;'>" + dayname_of_week + " <b>" + day + "</b> " + months[(currentMonth+1)] + " " + currentYear + "</h3>" + this.responseText;
		//getCLIS('');
	  }
	};
        var txtDate = currentYear + "-" + String("00" + (currentMonth+1)).slice(-2) + "-" + String("00" + day).slice(-2);
		xmlhttp.open('GET', 'getDAY.php?KEY=' + KEY +
        '&DU=' + dspUser + 
        '&DC=' + dspCustomer +
        '&E=' + dspEvent +
        '&A=' + dspEmail +
        '&O=' + dspOrder +
        '&SH=' + dspSH +
        '&SL=' + dspSL +
        '&NC=' + dspNewC +
        '&D=' + encodeURIComponent(txtDate), true);
		xmlhttp.send();	
}


</script>
</body>
</html>
