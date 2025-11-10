<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
 ?>

<div id='divCAL'>           
    <h3><button onclick="previous();"><span class="material-icons">skip_previous</span></button> 
			<span id="monthAndYear" style='min-width:175px;'></span>
	 	<button onclick="next();"><span class="material-icons">skip_next</span></button></h3>
        <table id="calendar" class='tblCAL'>
            <thead>
            <tr>
                <th width='14.28%'>Dim</th>
                <th width='14.28%'>Lun</th>
                <th width='14.28%'>Mar</th>
                <th width='14.28%'>Mer</th>
                <th width='14.28%'>Jeu</th>
                <th width='14.28%'>Ven</th>
                <th width='14.28%'>Sam</th>
            </tr>
            </thead>

            <tbody id="calendar-body">

            </tbody>
        </table>
</div>
<div style='display:none;'>
                    <label for='month'>Jump To: </label>
                    <select name='month' id='month' onchange='jump();'>
                        <option value=0>Jan</option>
                        <option value=1>Feb</option>
                        <option value=2>Mar</option>
                        <option value=3>Apr</option>
                        <option value=4>May</option>
                        <option value=5>Jun</option>
                        <option value=6>Jul</option>
                        <option value=7>Aug</option>
                        <option value=8>Sep</option>
                        <option value=9>Oct</option>
                        <option value=10>Nov</option>
                        <option value=11>Dec</option>
                    </select>
                    <label for='year'></label>
                    <select name='year' id='year' onchange='jump()'>
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
                    </select>
                </div>

<script>
<?php if($USER_LANG == "FR"){ ?>
    let months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aôut", "Septembre", "Octobre", "Novembre", "Décembre"];
<?php }else{ ?>
    let months = ["January", "February", "March", "April", "May", "June", "Jully", "August", "September", "October", "November", "December"];
<?php } ?>
let current_schedule = [];
let today = new Date();
let currentDay = today.getDate();
let currentMonth = today.getMonth()+1;
let currentYear = today.getFullYear();
let selectYear = document.getElementById("year");
let selectMonth = document.getElementById("month");

$(document).ready(function (){
    //if (USER_NAME !=""){dw3_avatar_change(USER_NAME,'dw3_menu_avatar');}
    if (LANG == ""){
        var language = window.navigator.userLanguage || window.navigator.language;
        if (language.toLowerCase().indexOf("fr") >= 0){
            LANG = "FR";
        } else {
            LANG = "EN";
        }
    }
    getM();
    dw3_body.innerHTML = "";
});
function next() {
    //currentYear = (parseInt(currentMonth-1) === 11) ? currentYear + 1 : currentYear;
    //currentMonth = (parseInt(currentMonth-1) + 1) % 12;
    if (currentMonth==12){currentMonth=1;currentYear++}else{currentMonth++;}
    getM();
    //document.getElementById("divDISPO").innerHTML = "";
    //showCalendar(currentMonth, currentYear);
}

function previous() {
    //currentYear = (parseInt(currentMonth-1) === 0) ? currentYear - 1 : currentYear;
    //currentMonth = (parseInt(currentMonth-1) === 0) ? 11 : parseInt(currentMonth-1) - 1;
    if (currentMonth==1){currentMonth=12;currentYear--}else{currentMonth--;}
    getM();
    //document.getElementById("divDISPO").innerHTML = "";
    //showCalendar(currentMonth, currentYear);
}

function getM() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		current_schedule = JSON.parse(this.responseText);
        //document.getElementById("divDATE_OUTPUT").innerHTML = "<h3><span style='color:darkred;'>Date non-défini</span></h3>";
        //document.getElementById("divDISPO").innerHTML = "<div style='display:inline-block;width:auto;text-align:center;font-weight:bold;background-image: linear-gradient(180deg, rgba(255,255,255,0), rgba(155,200,255,0.3),rgba(255,255,255,0));padding:10px;font-size:23px;'>Veuillez choisir un jour de disponible.</div>";
        //currentDay=0;
		showCalendar(currentMonth, currentYear);
        //getDISPO();
	  }
	};
		xmlhttp.open('GET', 'getMonth.php?M=' + currentMonth + '&Y=' + currentYear  , true);
		xmlhttp.send();	
}

function getD(day=currentDay) {

}

function showCalendar(month, year) {
let firstDate = new Date(parseInt(year), parseInt(month)-1,01)
let firstDay = (firstDate).getDay();
let daysInMonth = 32 - new Date(year, parseInt(month)-1, 32).getDate();
let tbl = document.getElementById("calendar"); 
let monthAndYear = document.getElementById("monthAndYear");

<?php if ($USER_LANG == "FR"){ ?>
    tbl.innerHTML = "<thead style='position:sticky;top:0px;'><tr><th width='14%'>Dim</th><th width='15%'>Lun</th><th width='15%'>Mar</th><th width='14%'>Mer</th><th width='14%'>Jeu</th><th width='14%'>Ven</th><th width='14%'>Sam</th></tr></thead>";
<?php } else{ ?>
    tbl.innerHTML = "<thead style='position:sticky;top:0px;'><tr><th width='14%'>Sun</th><th width='15%'>Mon</th><th width='15%'>Tue</th><th width='14%'>Wed</th><th width='14%'>Thu</th><th width='14%'>Fri</th><th width='14%'>Sat</th></tr></thead>";
<?php } ?>

monthAndYear.innerHTML = months[month-1] + " " + year;
selectYear.value = year;
selectMonth.value = month;
let date = 1;
for (let i = 0; i < 6; i++) {
    let row = document.createElement("tr");
    for (let j = 0; j < 7; j++) {
        if (i === 0 && j < firstDay) {
            let cell = document.createElement("td");
            let cellText = document.createTextNode("");
            cell.style.backgroundColor = "rgba(255,255,255,0)";
            cell.appendChild(cellText);
            row.appendChild(cell);
        }
        else if (date > daysInMonth) {
            for (let jj = j; jj < 7; jj++) {
                var cell = document.createElement("td");
                let cellText = document.createTextNode("");
                cell.style.backgroundColor = "rgba(255,255,255,0)";
                cell.style.height = "60px";
                cell.appendChild(cellText);
                row.appendChild(cell);
            }
            break;
        }
        else {
            var cell = document.createElement("td");
            cell.style.textAlign = "center";
            cell.style.padding = "2px";
            cell.style.height = "60px";
            cell.style.whiteSpace = "pre-wrap";

            if (parseInt(date) === today.getDate() && parseInt(year) === today.getFullYear() && parseInt(month) === (today.getMonth()+1)) {
                cell.style.backgroundColor = "rgba(255,200,100,0.5)";
            }
            if (parseInt(date) === parseInt(currentDay) && parseInt(year) === parseInt(currentYear) && parseInt(month) === parseInt(currentMonth)) {
                cell.style.backgroundColor = "rgba(50,200,255,0.5)";
            } 
            if (parseInt(date) < today.getDate() && parseInt(year) <= today.getFullYear() && parseInt(month) <= (today.getMonth()+1)){
                cell.innerHTML = "<div style='color:#999;padding-left:3px;width:100%;text-align:left;margin-bottom:-3px;'>" + date + "</div>";
            }else{
                cell.innerHTML = "<div style='padding-left:3px;width:100%;text-align:left;margin-bottom:3px;'>" + date + "</div>";
            }
                cell.style.cursor = "pointer";
                let tmpday = date;
            var iloop = 0;
            for (var iloop=0; iloop<current_schedule.length; iloop++) {
                        let tmpDateStart = new Date(current_schedule[iloop].date_start.replace(/-/g, "/"));
                        let tmpDateEnd = new Date(current_schedule[iloop].end_date.replace(/-/g, "/"));
                        if ((parseInt(date) === tmpDateStart.getDate() && parseInt(year) === tmpDateStart.getFullYear() && parseInt(month) === tmpDateStart.getMonth()+1) || (parseInt(date) === tmpDateEnd.getDate() && parseInt(year) === tmpDateStart.getFullYear() && parseInt(month) === tmpDateStart.getMonth()+1) || (parseInt(date) > tmpDateStart.getDate() && parseInt(date) < tmpDateEnd.getDate() && parseInt(year) === tmpDateStart.getFullYear() && parseInt(month) === tmpDateStart.getMonth()+1)) {
                            //isOff = false;
                            if ((parseInt(date) < today.getDate() && parseInt(year) <= today.getFullYear() && parseInt(month) <= (today.getMonth()+1)) || (parseInt(year) <= today.getFullYear() && parseInt(month) < (today.getMonth()+1)) || (parseInt(year) < today.getFullYear() )) {
                                cell.innerHTML += "<div style='font-size:0.7em;color:#555;margin-top:-4px;'><?php if ($USER_LANG == "FR"){ echo "Terminé";}else{echo "Finished";} ?></div>";
                                break;
                            } else {
                                var hour_from = current_schedule[iloop].date_start.substr(11, 5);
                                if (hour_from.substr(0, 1)=="0"){
                                    hour_from = hour_from.substr(1, 4);
                                }
                                var hour_to = current_schedule[iloop].end_date.substr(11, 5);
                                if (hour_to.substr(0, 1)=="0"){
                                    hour_to = hour_to.substr(1, 4);
                                }
                                    <?php if ($USER_LANG == "FR"){ ?>
                                        cell.innerHTML += "<div onclick=\"getEVENT('"+current_schedule[iloop].id+"');\" style='line-height:1em;max-height:100px;overflow:hidden;text-overflow:ellipsis;'><div style='font-size:0.7em;color:black;font-weight:bold;'>" + current_schedule[iloop].name_fr + "</div><hr style='margin:0px;'><div style='font-size:0.55em;color:#333;text-align:left;'>"+hour_from+"-"+hour_to+"<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='material-icons'>open_in_new</span></div></div>";
                                    <?php } else{ ?>
                                        cell.innerHTML += "<div onclick=\"getEVENT('"+current_schedule[iloop].id+"');\" style='line-height:1em;max-height:100px;overflow:hidden;text-overflow:ellipsis;'><div style='font-size:0.7em;color:black;font-weight:bold;'>" + current_schedule[iloop].name_en + "</div><hr style='margin:0px;'><div style='font-size:0.55em;color:#333;text-align:left;'>"+hour_from+"-"+hour_to+"<br style='margin:0px;'>Details..<span style='font-size:1em;' class='material-icons'>open_in_new</span></div></div>";
                                    <?php } ?>
                            }
                        }
            }
            row.appendChild(cell);
            date++;
        }
    }
    tbl.appendChild(row);
}
}


</script>

<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
    exit; 
?>