<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';

$sql = "SELECT COUNT(*) AS late_task_count FROM event WHERE user_id = '" . $USER . "' AND event_type='TASK'  AND end_date < NOW() AND status <> '' AND status <> 'DONE' AND status <> 'N/A'";
$result = $dw3_conn->query($sql);
$data = mysqli_fetch_assoc($result);
$LATE_TASKS_COUNT = $data['late_task_count'];

?>

<div id='divHEAD'>
<table style="width:100%;margin:0px;white-space:nowrap;"><tr style="margin:0px;padding:0px;">
    <td width="*" style="margin:0px;padding:0px;text-align:left;">
        <?php
            if ($USER_AUTH == "ADM" || $USER_AUTH == "GES") {
                echo "<button onclick='openSEL_USER();' id='ts_user_name' style='font-size:20px;'>".$USER_FULLNAME."</button><input type='text' id='ts_user_id' value='" . $USER . "' style='display:none;'>";
            } else if ($USER_AUTH == "USR") {
                echo $USER_FULLNAME;
            }
        ?>
    </td>
    <td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
        <?php
        if ($USER_AUTH == "ADM" || $USER_AUTH == "GES" || $APREAD_ONLY == false) {
            echo "<button class='blue' style='margin:0px 2px 0px 2px;padding:8px;' onclick='openNEW_HEAD();'><span class='material-icons'>calendar_month</span></button>";
        }
        if ($USER_AUTH == "ADM" || $USER_AUTH == "GES") {
            echo "<button class='blue' style='margin:0px 2px 0px 2px;padding:8px;' onclick='newTASK();'><span class='material-icons'>task</span></button>";
        }
        ?>
		<button class='red' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openLATE_TASK();"><span class="material-icons">assignment_late</span></button>
    </td></tr></table>
</div>

<div id='divCAL' style='margin-top:50px;'>           
    <h3><button class='clear1' onclick="previous();" style='margin-right:0px;'><span class="material-icons">skip_previous</span></button> 
			<span id="monthAndYear" style='min-width:175px;background:rgba(0,0,0,0.5);color:#FFF;padding:5px;'></span>
	 	<button class='clear1' onclick="next();" style='margin-left:0px;'><span class="material-icons">skip_next</span></button></h3>
        <table id="calendar" class='tblCAL'>
            <thead>
            <tr>
                <th width='14%'>Dim</th>
                <th width='15%'>Lun</th>
                <th width='15%'>Mar</th>
                <th width='14%'>Mer</th>
                <th width='14%'>Jeu</th>
                <th width='14%'>Ven</th>
                <th width='14%'>Sam</th>
            </tr>
            </thead>

            <tbody id="calendar-body">

            </tbody>
        </table>
</div>

    <select id="ts_month" onchange="jump();" style="display:none;width:auto;">
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
    <select id="ts_year" onchange="jump()" style="display:none;width:auto;">
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

<div id='divMAIN' class='divMAIN'  style='padding-top:20px;max-width:1024px;'></div>
<div id="divEDIT" class="divEDITOR" style='min-height:651px;'></div>

<div id="divLATE_TASK" class="divSELECT" style='min-width:330px;min-height:90%;z-index:1000;'>
    <div id="divLATE_TASK_HEADER" class='dw3_form_head'>
        <h3>Tâche(s) en retard</h3>
        <button onclick='closeLATE_TASK();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selLATE_TASK" oninput="getLATE_TASK('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divLATE_TASK_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver une tâche en retard.
            </div>
    </div>
	<div class='dw3_form_foot'>
        <button onclick="ExportToPDF('tblLATE_TASKS','ToDo');"><span class='material-icons'>picture_as_pdf</span></button>
		<button onclick="ExportToExcel('tblLATE_TASKS','xlsx','ToDo');"><span class='material-icons'>table_view</span></button>
		<button class='grey' onclick="closeLATE_TASK();getElementById('divLATE_TASK_DATA').innerHTML='Inscrire votre recherche pour trouver une tâche en retard.';"><span class="material-icons">cancel</span> Fermer</button>
        

	</div><br>
</div>

<!-- NOUVELLE PLAGE HORAIRES -->
<div id="divNEW_HEAD" class="divEDITOR" style='width:290px;min-height:570px; text-align:center;'>
    <div id='divNEW_HEAD_HEADER' class='dw3_form_head'>
        <h3>Nouvelle plage horaire</h3>
		<button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeNEW_HEAD(this);'><span class='material-icons'>close</span></button>
    </div>
    <div style='position:absolute;top:40px;left:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;text-align:left;'>
        <div style='width:30px;vertical-align:middle;display:inline-block;'><input id='chkTYPE_V' name='chkTYPE' type='checkbox' style='margin:5px;'></div> <label for='chkTYPE_V'>Virtuel</label><br>
        <div style='width:30px;vertical-align:middle;display:inline-block;'><input id='chkTYPE_R' name='chkTYPE' type='checkbox' style='margin:5px;'></div> <label for='chkTYPE_R'>Chez le client</label><br>
        <div style='width:30px;vertical-align:middle;display:inline-block;'><input id='chkTYPE_L' name='chkTYPE' type='checkbox' style='margin:5px;' checked></div> <label for='chkTYPE_L'>Dans nos locaux</label><br>
        <div style='width:30px;vertical-align:middle;display:inline-block;'><input id='chkTYPE_P' name='chkTYPE' type='checkbox' style='margin:5px;'></div> <label for='chkTYPE_P'>Par téléphone</label><br>
        <div id='divNEW_LOC' class="divBOX">Emplacement:
            <select id='newLOC'>
                <option value='-1'>Télétravail</option>
                <?php
                    $sql = "SELECT * FROM location ORDER  BY name";
                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            if ($row["id"] == $USER_LOC){
                                echo "<option value='" . $row["id"]  . "' selected>" . $row["name"]  . " *</option>";
                            } else {
                                echo "<option value='" . $row["id"]  . "'>" . $row["name"]  . "</option>";
                            }
                        }
                    }
                ?>
            </select>
            <small>* Emplacement par défaut pour cet utilisateur</small>
        </div>
        <div class="divBOX">Jour:
            <input id="newHEAD_DAY" type="date">
        </div>
        <div class="divBOX">De:
            <input id="newHEAD_START" type="time">
        </div>
        <div class="divBOX">À:
            <input id="newHEAD_END" type="time">
        </div>
        <div class="divBOX">Blocs de temps en minutes:
            <input id="newBLOCK_SIZE" type="number" value="30" min="1" style='background:#FFF;color:#000;'>
        </div>	
        <div style='width:30px;vertical-align:middle;display:inline-block;'><input id='chkPUB' name='chkPUB' type='checkbox' style='margin:5px;' checked></div> <label for='chkPUB'>Accessible au publique pour prendre rendez-vous</label><br>
    </div>
    <div class='dw3_form_foot' style='padding:3px;background:rgba(200, 200, 200, 0.7);'>
        <button class='grey' onclick="closeNEW_HEAD();"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>
        <button onclick="newHEAD();"><span class="material-icons">save</span><?php echo $dw3_lbl["CREATE"]; ?></button>
	</div>
</div>

<!-- PLAGE HORAIRE PERIODIQUE -->
<div id="divTS_REPEAT"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;min-height:295px;max-width:350px;">
    <div id='divTS_REPEAT_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>Répéter la plage horaire</h2>
        <button class='dw3_form_close' onclick='closeTS_REPEAT();'><span class='material-icons'>cancel</span></button>
    </div>
    <input id='tsID' type='text' value='' style='display:none;'>
    <div class='dw3_form_data' id="divPARAM_DATA">
        <div class='divBOX'>Type de répétition:
            <select id='tsTYPE' style='width:100%;' onchange='detectCLICK(event,this);'>
                <option value='DAILY'>Tous les jours</option>
                <option value='WEEKDAYS'>Jours de semaine</option>
                <option value='WEEKLY'>Hebdomadaire</option>
                <option value='BI-WEEKLY'>Aux deux semaines</option>
                <option value='MONTHLY'>Mensuel</option>
                <option value='MONTHLY3'>Trimestriel (3 mois)</option>
                <option value='MONTHLY6'>Semestriel (6 mois)</option>
                <option value='YEARLY'>Annuel</option>
            </select>
        </div><br>
        <div class='divBOX'>Nombre d'occurrences additionnelles:
            <input id='tsTO_YEAR_END' type='checkbox' checked onclick='if (this.checked) { document.getElementById("tsDURATION").value = ""; document.getElementById("tsDURATION").disabled = true; } else { document.getElementById("tsDURATION").disabled = false; document.getElementById("tsDURATION").value = "1"; document.getElementById("tsDURATION").focus(); document.getElementById("tsDURATION").select(); }'><label for='tsTO_YEAR_END' style='vertical-align:middle;padding:0px 0px 0px 8px;'>Jusqu'à la fin de l'année</label><br>
            <input id='tsDURATION' disabled type='number' style='width:100%;' onclick='detectCLICK(event,this);'>
        </div>
    </div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='grey' onclick='closeTS_REPEAT()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='setTS_REPEAT();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>event_repeat</span> Créer l'horaire</button>
    </div>
</div>

<!-- SELECTION UTILISATEUR -->
<div id="divSEL_USER" class="divSELECT" style='min-width:330px;min-height:90%;'>
    <div id="divSEL_USER_HEADER" class='dw3_form_head'><h3>
	    Sélection ID </h3>
        <button onclick='closeSEL_USER();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selUSER" oninput="getSEL_USER('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_USER_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un utilisateur.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_USER();getElementById('divSEL_USER_DATA').innerHTML='Inscrire votre recherche pour trouver un utilisateur.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<!-- PERIODIC EVENTS -->
<div id="divPERIODIC"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;min-height:250px;max-width:350px;">
    <div id='divPERIODIC_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>Répéter la tâche</h2>
        <button class='dw3_form_close' onclick='closePERIODIC();'><span class='material-icons'>cancel</span></button>
    </div>
    <input id='eventID' type='text' value='' style='display:none;'>
    <div class='dw3_form_data' id="divPARAM_DATA">
        <div class='divBOX'>Type de répétition:
            <select id='periodTYPE' style='width:100%;' onchange='detectCLICK(event,this);'>
                <option value='DAILY'>Quotidien</option>
                <option value='WEEKLY'>Hebdomadaire</option>
                <option value='BI-WEEKLY'>Aux deux semaines</option>
                <option value='MONTHLY'>Mensuel</option>
                <option value='MONTHLY3'>Trimestriel (3 mois)</option>
                <option value='MONTHLY6'>Semestriel (6 mois)</option>
                <option value='YEARLY'>Annuel</option>
            </select>
        </div><br>
        <div class='divBOX'>Nombre d'occurrences additionnelles:
            <input id='periodDURATION' type='number' value='1' min='1' style='width:100%;' onclick='detectCLICK(event,this);'>
        </div>
    </div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='grey' onclick='closePERIODIC()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='setPERIODIC();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>event_repeat</span> Créer les tâches</button>
    </div>
</div>


<div id="divMSG"></div>
<div id="divOPT"></div>
<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;"></div>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var LATE_TASKS_COUNT = '<?php echo($LATE_TASKS_COUNT); ?>';

//Dimanche
var J0_H1 = "<?php echo $CIE_OPEN_J0_H1; ?>";
var J0_H2 = "<?php echo $CIE_OPEN_J0_H2; ?>";
var J0_H3 = "<?php echo $CIE_OPEN_J0_H3; ?>";
var J0_H4 = "<?php echo $CIE_OPEN_J0_H4; ?>";
//Lundi
var J1_H1 = "<?php echo $CIE_OPEN_J1_H1; ?>";
var J1_H2 = "<?php echo $CIE_OPEN_J1_H2; ?>";
var J1_H3 = "<?php echo $CIE_OPEN_J1_H3; ?>";
var J1_H4 = "<?php echo $CIE_OPEN_J1_H4; ?>";
//Mardi
var J2_H1 = "<?php echo $CIE_OPEN_J2_H1; ?>";
var J2_H2 = "<?php echo $CIE_OPEN_J2_H2; ?>";
var J2_H3 = "<?php echo $CIE_OPEN_J2_H3; ?>";
var J2_H4 = "<?php echo $CIE_OPEN_J2_H4; ?>";
//Mercredi
var J3_H1 = "<?php echo $CIE_OPEN_J3_H1; ?>";
var J3_H2 = "<?php echo $CIE_OPEN_J3_H2; ?>";
var J3_H3 = "<?php echo $CIE_OPEN_J3_H3; ?>";
var J3_H4 = "<?php echo $CIE_OPEN_J3_H4; ?>";
//Jeudi
var J4_H1 = "<?php echo $CIE_OPEN_J4_H1; ?>";
var J4_H2 = "<?php echo $CIE_OPEN_J4_H2; ?>";
var J4_H3 = "<?php echo $CIE_OPEN_J4_H3; ?>";
var J4_H4 = "<?php echo $CIE_OPEN_J4_H4; ?>";
//Vendredi
var J5_H1 = "<?php echo $CIE_OPEN_J5_H1; ?>";
var J5_H2 = "<?php echo $CIE_OPEN_J5_H2; ?>";
var J5_H3 = "<?php echo $CIE_OPEN_J5_H3; ?>";
var J5_H4 = "<?php echo $CIE_OPEN_J5_H4; ?>";
//Samedi
var J6_H1 = "<?php echo $CIE_OPEN_J6_H1; ?>";
var J6_H2 = "<?php echo $CIE_OPEN_J6_H2; ?>";
var J6_H3 = "<?php echo $CIE_OPEN_J6_H3; ?>";
var J6_H4 = "<?php echo $CIE_OPEN_J6_H4; ?>";

$(document).ready(function ()
    {
		getM();
		getD(currentDay);
        dragElement(document.getElementById('divNEW_HEAD'));
        dragElement(document.getElementById('divLATE_TASK'));
        dragElement(document.getElementById('divSEL_USER'));
        dragElement(document.getElementById('divPERIODIC'));
        var now = new Date();
        let week_day = now.getDay();
        if (week_day == 0){
            document.getElementById("newHEAD_START").value = J0_H1;
            document.getElementById("newHEAD_END").value = J0_H2;
        } else if (week_day == 1){
            document.getElementById("newHEAD_START").value = J1_H1;
            document.getElementById("newHEAD_END").value = J1_H2;
        } else if (week_day == 2){
            document.getElementById("newHEAD_START").value = J2_H1;
            document.getElementById("newHEAD_END").value = J2_H2;
        } else if (week_day == 3){
            document.getElementById("newHEAD_START").value = J3_H1;
            document.getElementById("newHEAD_END").value = J3_H2;
        } else if (week_day == 4){
            document.getElementById("newHEAD_START").value = J4_H1;
            document.getElementById("newHEAD_END").value = J4_H2;
        } else if (week_day == 5){
            document.getElementById("newHEAD_START").value = J5_H1;
            document.getElementById("newHEAD_END").value = J5_H2;
        } else if (week_day == 6){
            document.getElementById("newHEAD_START").value = J6_H1;
            document.getElementById("newHEAD_END").value = J6_H2;
        }
        document.getElementById("newHEAD_DAY").value = now.toISOString().slice(0,10);
        
        if (LATE_TASKS_COUNT > 0){
            addNotif("Vous avez " + LATE_TASKS_COUNT + " tâche(s) en retard.");
            openLATE_TASK();
        }

});
let current_schedule = [];
let selectedDate = new Date();
let today = new Date();
let currentDay = today.getDate();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let currentUser = <?php echo $USER; ?>;
let selectYear = document.getElementById("ts_year");
let selectMonth = document.getElementById("ts_month");
let selectedDispo = "90";
let selectedPrd = "";
let selectedDesc = "";
let months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aôut", "Septembre", "Octobre", "Novembre", "Décembre"];

let monthAndYear = document.getElementById("monthAndYear");
monthAndYear.innerHTML = months[currentMonth] + " " + currentYear;
//showCalendar(currentMonth, currentYear);
//getM();


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
    var line_text = "";
    var task_text = "";
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

        //creating individual cells, filing them up with data.
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) {
                let cell = document.createElement("td");
                let cellText = document.createTextNode("");
                cell.style.backgroundColor = "rgba(255,255,255,0)";
                cell.style.borderRight = "1px solid #fff";
                cell.style.borderLeft = "1px solid #fff";
                cell.appendChild(cellText);
                row.appendChild(cell);
            }
            else if (date > daysInMonth) {
                break;
            }
            else {
                var cell = document.createElement("td");
				cell.style.height = "40px";
				cell.style.textAlign = "center";
                cell.style.padding = "1px";
                cell.style.maxWidth = "14%";
                if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                    //cell
                    cell.style.backgroundColor = "rgba(255,200,100,0.5)";
                } // color today's date

				cell.innerHTML = "<div style='padding-left:3px;text-align:left;'>" + date + "</div>";
				cell.style.cursor = "pointer";
				let tmpday = date;
				cell.onclick = function () {
					//this.parentElement.removeChild(this);
					getD(tmpday);
				};
				for (iloop=0; iloop<current_schedule.length; iloop++) {
                    line_text = "";
                    task_text = "";
                    let tmpDateStart = new Date(current_schedule[iloop].start_date);
                    let tmpDateEnd = new Date(current_schedule[iloop].end_date);
                    if (tmpDateStart.getDate() == date && tmpDateStart.getFullYear() == year && tmpDateStart.getMonth() == month) {
                        //rendez-vous
                        if (current_schedule[iloop].line_count > 0){
                            line_text = "<div style='text-align:left;padding-left:3px;font-weight:normal;color:#444;'><span class='material-icons' style='font-size:16px;'>schedule</span> <b>" + current_schedule[iloop].line_count + "</b> RENDEZ-VOUS</div>";
                        } else {
                            line_text = "";
                        }
                        //tasks
                        if (current_schedule[iloop].events_count > 0){
                            if (current_schedule[iloop].events_count == 1){
                                task_text = "<div style='text-align:left;padding-left:3px;font-weight:normal;color:#444;'><span class='material-icons' style='font-size:16px;'>check_circle_outline</span> <b>" + current_schedule[iloop].events_count + "</b> TÂCHE</div>";
                            } else {
                                task_text = "<div style='text-align:left;padding-left:3px;font-weight:normal;color:#444;'><span class='material-icons' style='font-size:16px;'>check_circle_outline</span> <b>" + current_schedule[iloop].events_count + "</b> TÂCHES</div>";
                            }
                        } else {
                            task_text = "";
                        }
                        //tasks and meetings with or without schedule
                        if (current_schedule[iloop].head_id > 0){
                            cell.innerHTML += "<div style='font-size:0.7em;padding-bottom:10px;'>" + current_schedule[iloop].start_date.substr(11, 5) + "-" + current_schedule[iloop].end_date.substr(11, 5) + "<br>" +  line_text + task_text + "</div>";
                        } else if (current_schedule[iloop].head_id == 0 && (line_text != "" || task_text != "")){
                            cell.innerHTML += "<div style='font-size:0.7em;padding:10px 0px;'>Hors planning" + line_text + task_text + "</div>";
                        } else if (current_schedule[iloop].head_id == -1){
                            cell.innerHTML += "<div style='font-size:0.7em;padding:0px 0px 10px 0px;'>Hors planning" + line_text + task_text + "</div>";
                        }

                        //cell.style.backgroundColor = "rgba(50,250,20,0.5)";
                    }
				}

                //let cellText = document.createTextNode(date);

                //cell.appendChild(cellText);
                row.appendChild(cell);
                
                date++;
            }


        }

        tbl.appendChild(row); // appending each row into calendar body.
    }

}
    
function openNEW_HEAD() {
	document.getElementById("divNEW_HEAD").style.display = "inline-block";
    document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divFADE").style.opacity = "0.5"
/* 	var now = new Date();
	now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
	//document.getElementById('dt').value = now.toISOString().slice(0,16);
	//alert (now.toISOString().slice(0,16));
	document.getElementById("newHEAD_START").value = now.toISOString().slice(0,11) + "08:00";
	document.getElementById("newHEAD_END").value = now.toISOString().slice(0,11) + "20:00"; */
}

function closeNEW_HEAD() {
	document.getElementById("divNEW_HEAD").style.display = "none";
    document.getElementById("divFADE").style.display = "none";
    document.getElementById("divFADE").style.opacity = "0";
}

function delHEAD(headID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.5";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons'>cancel</span> Annuler</button> <button onclick='delHEAD2(" + headID + ",0);closeMSG();' class='red'><span class='material-icons' style='vertical-align:middle;'>delete</span> Effacer</button>";
}
function delHEAD2(headID,confirmed_delete = '0') {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
				getM();
				getD(currentDay);
                closeEDITOR();
		  } else {
            if (this.responseText == "Err1"){
                document.getElementById("divFADE2").style.display = "inline-block";
                document.getElementById("divFADE2").style.opacity = "0.5";
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = "Cette plage horaire est répétée, voulez vous supprimer seulement celui-ci ou tous les suivants ou toute la série depuis le début? <div style='height:20px;'> </div>"
                        +"<button onclick='delHEAD2(" + headID + ",1);closeMSG();' class='red'><span class='material-icons' style='vertical-align:middle;'>delete</span> Effacer celui-ci</button>"
                        +"<br><button onclick='delTS_REPEAT(" + headID + ",2);closeMSG();' class='red'><span class='material-icons' style='vertical-align:middle;'>delete</span> Effacer tous les suivants</button>"
                        +"<br><button onclick='delTS_REPEAT(" + headID + ",1);closeMSG();' class='red'><span class='material-icons' style='vertical-align:middle;'>delete</span> Effacer toute la série depuis le début</button>"
                        +"<br><button onclick='closeMSG();' class='grey'><span class='material-icons'>cancel</span> Annuler</button>";

            } else {
                document.getElementById("divFADE2").style.display = "inline-block";
                document.getElementById("divFADE2").style.opacity = "0.5";
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
            }
		  } 
	  }
	};
    xmlhttp.open('GET', 'delHEAD.php?KEY=' + KEY + '&ID=' + headID + '&CF=' + confirmed_delete, true);
    xmlhttp.send();	
}
function delTS_REPEAT(headID,delTYPE = '0') {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
				getM();
				getD(currentDay);
                closeEDITOR();
		  } else {
			document.getElementById("divFADE2").style.display = "inline-block";
			document.getElementById("divFADE2").style.opacity = "0.5";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delTS_REPEAT.php?KEY=' + KEY + '&ID=' + headID + '&TYPE=' + delTYPE, true);
		xmlhttp.send();	
}

function delLINE(ID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.5";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons'>cancel</span> Annuler</button> <button onclick='delLINE2(" + ID + ");closeMSG();' class='red'><span class='material-icons' style='vertical-align:middle;'>delete</span> Delete</button>";
}
function delLINE2(ID) {
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
				getM();
				getD(currentDay);
                closeEDITOR();
		  } else {
				document.getElementById("divFADE2").style.display = "inline-block";
				document.getElementById("divFADE2").style.opacity = "0.5";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delLINE.php?KEY=' + KEY + '&ID=' + ID , true);
		xmlhttp.send();
		
}
function getDISPO(){

    if (!document.querySelector('input[name="prd"]:checked')){
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divFADE2").style.opacity = "0.5";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez choisir un produit ou un service pour vérifier les disponibilités.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
        return false;
    }

    var xloc = document.querySelector('input[name="service_type"]:checked').value;
    var xprd = document.querySelector('input[name="prd"]:checked').value;
    //var xusr = document.querySelector('input[name="service_user"]:checked').value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divDISPO").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getDISPO.php?KEY=' + KEY + '&M=' + currentMonth + '&Y=' + currentYear + '&D=' + currentDay + '&P=' + xprd + '&L=' + xloc + '&USER_ID=' + currentUser 
										,true);
		xmlhttp.send();
}
function sendConfirmationSMS(schedule_id){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        const JSONresponse = JSON.parse(this.responseText);
        if (JSONresponse.success == "true"){	
				addNotif("Demande de confirmation envoyée.");
				updMsgID(schedule_id,JSONresponse.message_id);
		  } else {
				document.getElementById("divFADE2").style.display = "inline-block";
				document.getElementById("divFADE2").style.opacity = "0.5";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = JSONresponse.message + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'sendConfirmationSMS.php?KEY=' + KEY + '&sid=' + schedule_id
										,true);
		xmlhttp.send();
}
function updLINE(line_id){
    var GRPBOX = document.getElementById("linePLATFORM");
    platform = GRPBOX.options[GRPBOX.selectedIndex].value;	
    var link = document.getElementById("lineLINK").value.trim();
    var password = document.getElementById("linePW").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Infos mis à jour.");
        closeEDITOR();
	  }
	};
    xmlhttp.open('GET', 'updLINE.php?KEY=' + KEY + '&ID=' + line_id + '&PLATFORM=' + platform + '&LINK=' + encodeURIComponent(link) + '&PW=' + encodeURIComponent(password)
                                    ,true);
    xmlhttp.send();
}

function sendLinkEmail(line_id){
    var GRPBOX = document.getElementById("linePLATFORM");
    platform = GRPBOX.options[GRPBOX.selectedIndex].value;	
    var link = document.getElementById("lineLINK").value.trim();
    var password = document.getElementById("linePW").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText != ""){
            document.getElementById("divFADE2").style.display = "inline-block";
            document.getElementById("divFADE2").style.opacity = "0.5";
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
        } else {
            addNotif("Email envoyé.");
        }
	  }
	};
    xmlhttp.open('GET', 'sendLinkEmail.php?KEY=' + KEY + '&ID=' + line_id + '&PLATFORM=' + encodeURIComponent(platform) + '&LINK=' + encodeURIComponent(link) + '&PW=' + encodeURIComponent(password) + '&USER_ID=' + currentUser 
    ,true);
    xmlhttp.send();
}

function updMsgID(schedule_id,message_id){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        //updated
	  }
	};
    xmlhttp.open('GET', 'updMsgID.php?KEY=' + KEY + '&sid=' + schedule_id + '&mid=' + message_id + '&USER_ID=' + currentUser 
                                    ,true);
    xmlhttp.send();
}


function getM() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		current_schedule = JSON.parse(this.responseText);
		showCalendar(currentMonth, currentYear);
	  }
	};
		xmlhttp.open('GET', 'getHEAD.php?KEY=' + KEY + '&M=' + (currentMonth+1) + '&Y=' + currentYear  + '&USER_ID=' + currentUser  , true);
		xmlhttp.send();	
}

function getD(day=currentDay) {
	currentDay=day;
	var xday = new Date(currentYear + "/" + (currentMonth+1) + "/" + day);
    //var month_no = (currentMonth+1).toString().padStart(2, "0");
    //var day_no = day.toString().padStart(2, "0");
    //var newday = currentYear + "-" + month_no + "-" + day_no;
    //var newday = day_no + "/" + month_no + "/" + currentYear;
    var newday = new Date(currentYear + "/" + (currentMonth+1) + "/" + day);
    //newday.setMinutes(newday.getMinutes() - newday.getTimezoneOffset());
    //document.getElementById("newHEAD_DAY").value = newday;
    document.getElementById("newHEAD_DAY").value = newday.toISOString().slice(0,10);
        let week_day = newday.getDay();
        if (week_day == 0){
            document.getElementById("newHEAD_START").value = J0_H1;
            document.getElementById("newHEAD_END").value = J0_H2;
        } else if (week_day == 1){
            document.getElementById("newHEAD_START").value = J1_H1;
            document.getElementById("newHEAD_END").value = J1_H2;
        } else if (week_day == 2){
            document.getElementById("newHEAD_START").value = J2_H1;
            document.getElementById("newHEAD_END").value = J2_H2;
        } else if (week_day == 3){
            document.getElementById("newHEAD_START").value = J3_H1;
            document.getElementById("newHEAD_END").value = J3_H2;
        } else if (week_day == 4){
            document.getElementById("newHEAD_START").value = J4_H1;
            document.getElementById("newHEAD_END").value = J4_H2;
        } else if (week_day == 5){
            document.getElementById("newHEAD_START").value = J5_H1;
            document.getElementById("newHEAD_END").value = J5_H2;
        } else if (week_day == 6){
            document.getElementById("newHEAD_START").value = J6_H1;
            document.getElementById("newHEAD_END").value = J6_H2;
        }
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
		document.getElementById("divMAIN").innerHTML = "<h1>" + dayname_of_week + " <b>" + day + "</b> " + monthAndYear.innerHTML + "</h1>" + this.responseText;
		getCLIS('');
		dspTASK_CHART();
	  }
	};
		xmlhttp.open('GET', 'getDAY.php?KEY=' + KEY + '&D=' + day + '&M=' + (currentMonth+1) + '&Y=' + currentYear  + '&USER_ID=' + currentUser , true);
		xmlhttp.send();	
}

function dspTASK_CHART() {
	const ctx = document.getElementById('task_chart');
	const var_label = document.getElementById('var_label').value.split(",");
	const var_data = document.getElementById('var_data').value.split(",");
	const var_colors = document.getElementById('var_colors').value.split(";");
	if (var_label != ""){
		new Chart(ctx, {
			type: 'polarArea',
			data: {
			labels: var_label,
			datasets: [{
				label: 'Progression des tâches',
				data: var_data,
				backgroundColor: var_colors,
				borderWidth: 1
			}]
			},
				options: {
					responsive: false,    
                    scales: {
                    r: { // Radial scale
                        beginAtZero: true, // Ensure the scale starts at zero
                        ticks: {
                            stepSize: 1 // Set the step size to 5 units
                        }
                    }
                },
			}
		});
		ctx.style.display = "inline-block";
	} else {
		ctx.style.display = "none";
	}
}
function getLINE(lineID) {
    document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divFADE").style.opacity = "0.5";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divEDIT").style.display = "inline-block";
        document.getElementById("divEDIT").innerHTML = this.responseText;
    }
    };
        xmlhttp.open('GET', 'getLINE.php?KEY=' + KEY + '&ID=' + lineID , true);
        xmlhttp.send();
}
function getTASK(taskID) {
    document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divFADE").style.opacity = "0.5";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divEDIT").style.display = "inline-block";
        document.getElementById("divEDIT").innerHTML = this.responseText;
		dragElement(document.getElementById('divEDIT'));
    }
    };
    <?php if ($USER_AUTH == "GES" || $USER_AUTH == "ADM"){ ?>
        xmlhttp.open('GET', 'getTASK_ADM.php?KEY=' + KEY + '&ID=' + taskID, true);
    <?php } else { ?>
        xmlhttp.open('GET', 'getTASK.php?KEY=' + KEY + '&ID=' + taskID, true);
    <?php } ?>  
        xmlhttp.send();
}
function getCLIS(sS) {
	if (document.getElementById("selCLI")!=undefined){
		if(sS==""){sS = document.getElementById("selCLI").value.trim();}
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divCLI").innerHTML = this.responseText;
		}
		};
			xmlhttp.open('GET', 'getCLIS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) , true);
			xmlhttp.send();
	}
}
function validateCLI(clID,that) {
	var table = document.getElementById("dataCLIS");
		for (var i = 0, row; row = table.rows[i]; i++) {
		      //alert (row.className + " len: " + rows.length);           
			  if (i % 2 == 0) { 
				row.classList.remove("selected");
				row.classList.remove("odd");
				row.className = "even";
			  } else { 
				row.classList.remove("selected"); 
				row.classList.remove("even"); 
				row.className = "odd"; 
			  }       
		} 
	that.className = "selected";
	document.getElementById("newCLI").value = clID;
	//document.getElementById("btnNEW").enabled = true;
	//var is_prd = false;
	//if (document.querySelector('input[name="prd"]:checked')!=undefined){is_prd = true;}
	//var is_cli = false;
	//if (document.querySelector('input[name="prd"]:checked')!=undefined){is_prd = true;}
	//var is_prd = false;
	//if (document.querySelector('input[name="prd"]:checked')!=undefined){is_prd = true;}
	document.getElementById("divCONFIRM").innerHTML = "Placer rendez-vous pour " + that.firstChild.innerText;
}
function dw3_set_dispo(dispo=selectedDispo,descr=selectedDesc) { 
    selectedDispo=dispo;    
    selectedDesc=descr;    
}
function delTASK(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "0.5";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Les tâches ne peuvent êtres supprimés que par l'application 'Évènements'.<div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons'>cancel</span> Annuler</button>";
}
function addRDV(){
	if (document.querySelector('input[name="prd"]:checked')==undefined){
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuilez choisir un service.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	}
	if (document.querySelector('input[name="selBLOCK"]:checked')==undefined){
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuillez choisir une disponibilité.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	}

	var xxcl = document.getElementById("newCLI").value;
	if (xxcl == "" || xxcl == undefined){
		document.getElementById("selCLI").style.borderColor = "red";
		document.getElementById("selCLI").focus();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuilez choisir un client.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else {
		document.getElementById("selCLI").style.borderColor = "lightgrey";
	}

	var xloc = document.querySelector('input[name="service_type"]:checked').value;
	var xprd = document.querySelector('input[name="prd"]:checked').value;
	var xblock_from = document.querySelector('input[name="selBLOCK"]:checked').value;
	var date_rdv_from = new Date(currentYear + "-" + (currentMonth+1) + "-" + currentDay + " " + xblock_from + ":00");
	var d1 = currentYear + "-" + (currentMonth+1) + "-" + currentDay + " " + xblock_from + ":00";
    var date_rdv_to = new Date(date_rdv_from.getTime() + selectedDispo*60000);
	var d2 = date_rdv_to.getFullYear() + "-" + (date_rdv_to.getMonth()+1) + "-" + date_rdv_to.getDate() + " " +  date_rdv_to.getHours()+ ":" +  date_rdv_to.getMinutes()+ ":00";
	
    switch(xloc) {
	case "V":
        var xxloc="Rencontre virtuelle";
		break;
	case "R":
        var xxloc="À votre domicile";
		break;
	case "L0":case "L":
        var xxloc="<?php echo $CIE_ADR; ?>";
		break;
	default:
        var xxloc="Dans nos locaux";
	}
    
    if (xprd == "" || xprd == undefined){
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuilez choisir un service.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else {
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (xblock_from == "" || xblock_from == undefined){
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuillez choisir une disponibilité.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	}	

    //document.getElementById("divMSG").style.display = "inline-block";
	//document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/img/load.gif'>";
	addNotif("Création du rendez-vous..<img style='height:30px;width:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>");
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){	
				addNotif("<?php echo $dw3_lbl["CREATED"]; ?>");
				getM();
				getD(currentDay);
		  } else {
				document.getElementById("divFADE2").style.display = "inline-block";
				document.getElementById("divFADE2").style.opacity = "0.5";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
    var id1 = new Date(d1);
	var id2 = new Date(d2);
		xmlhttp.open('GET', 'newLINE.php?KEY=' + KEY + '&'
										+ 'START=' + encodeURIComponent(d1)  
										+ '&END=' + encodeURIComponent(d2)    
										+ '&P=' + xprd    
										+ '&L=' + xloc    
										+ '&C=' + xxcl
                                        + '&USER_ID=' + currentUser ,    
										true);
		xmlhttp.send();
		//document.getElementById("divFADE").style.display = "inline-block";
		//document.getElementById("divFADE").style.opacity = "1";
        var formattedD1 = id1.getFullYear() + "-" + ('0' + parseInt(id1.getMonth() + 1)).slice(-2) + "-" + ('0' + id1.getDate()).slice(-2)+"T"+ ('0' + id1.getHours()).slice(-2)+ ":" + ('0' + id1.getMinutes()).slice(-2)+ ":" + ('0' + id1.getSeconds()).slice(-2);
        var formattedD2 = id2.getFullYear() + "-" + ('0' + parseInt(id2.getMonth() + 1)).slice(-2) + "-" + ('0' + id2.getDate()).slice(-2)+"T"+ ('0' + id2.getHours()).slice(-2)+ ":" + ('0' + id2.getMinutes()).slice(-2)+ ":" + ('0' + id2.getSeconds()).slice(-2);

        addEVENT(selectedDesc,xxloc,xxcl,formattedD1,formattedD2,'<?php echo $USER; ?>');
}


function addEVENT(summary,location,description,date_from,date_to,user_id){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        //
	};
    }   
		xmlhttp.open('GET', '/api/google/addEvent.php'
                                        + '?S=' + encodeURIComponent(summary)  
										+ '&U=' + encodeURIComponent(user_id)
										+ '&D=' + encodeURIComponent(description)
										+ '&F=' + encodeURIComponent(date_from)    
										+ '&T=' + encodeURIComponent(date_to)
                                        + '&USER_ID=' + currentUser ,    
										true);
		xmlhttp.send();
  
}
function newHEAD(){
    var GRPBOX = document.getElementById("newLOC");
    sLOC = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sHEAD_DAY = document.getElementById("newHEAD_DAY").value;
	var sHEAD_START = sHEAD_DAY + " " + document.getElementById("newHEAD_START").value;
	var sHEAD_END = sHEAD_DAY + " " + document.getElementById("newHEAD_END").value;
	var sBLOCK_SIZE = document.getElementById("newBLOCK_SIZE").value;
	var sPUB = document.getElementById("chkPUB").checked;
	var sTYPE_V= document.getElementById("chkTYPE_V").checked;
	var sTYPE_R= document.getElementById("chkTYPE_R").checked;
	var sTYPE_L= document.getElementById("chkTYPE_L").checked;
	var sTYPE_P= document.getElementById("chkTYPE_P").checked;
	
	if (sTYPE_V == false && sTYPE_R == false && sTYPE_L == false && sTYPE_P == false){
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Veuillez choisir un lieu.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	}
	if (sTYPE_V == false){sTYPE_V = "0";} else {sTYPE_V = "1";}
	if (sTYPE_R == false){sTYPE_R = "0";} else {sTYPE_R = "1";}
	if (sTYPE_L == false){sTYPE_L = "0";} else {sTYPE_L = "1";}
	if (sTYPE_P == false){sTYPE_P = "0";} else {sTYPE_P = "1";}

    if(sPUB == true){ sPUB = '1';} else {sPUB = '0';}

	var xstart = new Date(sHEAD_START);
	var xend = new Date(sHEAD_END);

	if (xstart >= xend){
		document.getElementById("newHEAD_END").style.borderColor = "red";
		document.getElementById("newHEAD_END").focus();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "L'heure de fin doit être supérieure à l'heure de début.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else {
		document.getElementById("newHEAD_END").style.borderColor = "lightgrey";
	}	
	if (Number(sBLOCK_SIZE) <= 0){
		document.getElementById("newBLOCK_SIZE").style.borderColor = "red";
		document.getElementById("newBLOCK_SIZE").focus();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Le temps par bloc doit être supérieur à 1 minute.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else {
		document.getElementById("newBLOCK_SIZE").style.borderColor = "lightgrey";
	}	

	addNotif("Création de la plage horaire..<img style='height:30px;width:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>");
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){	
				addNotif("<?php echo $dw3_lbl["CREATED"]; ?>");
				getM();
				getD(currentDay);
				closeNEW_HEAD();
		  } else {
				document.getElementById("divFADE2").style.display = "inline-block";
				document.getElementById("divFADE2").style.opacity = "0.5";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newHEAD.php?KEY=' + KEY + '&'
										+ 'LOC=' + encodeURIComponent(sLOC)  
										+ '&START=' + encodeURIComponent(sHEAD_START)  
										+ '&END=' + encodeURIComponent(sHEAD_END)   
										+ '&P=' + encodeURIComponent(sPUB)   
										+ '&V=' + encodeURIComponent(sTYPE_V)   
										+ '&R=' + encodeURIComponent(sTYPE_R)   
										+ '&L=' + encodeURIComponent(sTYPE_L)   
										+ '&U=' + encodeURIComponent(sTYPE_P)   
										+ '&BLOCK=' + sBLOCK_SIZE
                                        + '&USER_ID=' + currentUser ,    
										true);
		xmlhttp.send();
}
function updTASK(task_id){
    var GRPBOX = document.getElementById("taskSTATUS");
    sSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;	
    var sDESC = document.getElementById("taskDESC").value;
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){	
				addNotif("<?php echo $dw3_lbl["UPDATED"]; ?>");
                getD();
				if (document.getElementById("divLATE_TASK").style.display == "inline-block"){
					getLATE_TASK('');
				}
				closeEDITOR();
		  } else {
				document.getElementById("divFADE2").style.display = "inline-block";
				document.getElementById("divFADE2").style.opacity = "0.5";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updTASK.php?KEY=' + KEY + '&'
										+ 'ID=' + task_id 
										+ '&STAT=' + encodeURIComponent(sSTAT)  
										+ '&DESC=' + encodeURIComponent(sDESC),    
										true);
		xmlhttp.send();
}


function newTASK(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				addNotif("<?php echo $dw3_lbl["CREATED"]; ?>");
                getTASK(this.responseText);
		  }
	  }
	};
    xmlhttp.open('GET', 'newTASK.php?KEY=' + KEY + '&UID=' + currentUser + '&Y='+ currentYear + '&M=' + (currentMonth+1) + '&D=' + currentDay, true);
    xmlhttp.send();
}

//SELECTION LATE_TASK
function getLATE_TASK(sS) {
	if(sS==""){sS = document.getElementById("selLATE_TASK").value.trim();}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divLATE_TASK_DATA").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getLATE_TASK.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + '&USER_ID=' + currentUser, true);
    xmlhttp.send();
}
function openLATE_TASK() {
    document.getElementById('divLATE_TASK').style.display = "inline-block";
    getLATE_TASK('');
}
function closeLATE_TASK() {
    document.getElementById('divLATE_TASK').style.display = "none";
}

//SELECTION DE USER
function getSEL_USER(sS) {
	if(sS==""){sS = document.getElementById("selUSER").value.trim();}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_USER_DATA").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getSEL_USER.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) , true);
    xmlhttp.send();
}

function openSEL_USER() {
    document.getElementById('divSEL_USER').style.display = "inline-block";
    getSEL_USER('');
}

function closeSEL_USER() {
    document.getElementById('divSEL_USER').style.display = "none";
}

function validateUSER(sID,sNAME) {
    currentUser = sID;
    document.getElementById('ts_user_id').value = sID;
    document.getElementById('ts_user_name').innerHTML = sNAME;
    closeSEL_USER();
    jump();
    getD(currentDay);
    getUSER_LOC(sID);
}

function getUSER_LOC(uID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divNEW_LOC").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getNEW_LOC.php?KEY=' + KEY + '&currentUSER=' + uID.trim() , true);
    xmlhttp.send();
}

//ADM
function calculateDuration(){
	var sDATE_START = document.getElementById("evDATE_START").value;
	var sDATE_END = document.getElementById("evDATE_END").value;
	var from_time = new Date("1970-01-01 " + sDATE_START);
	var to_time = new Date("1970-01-01 " + sDATE_END);
	var diff = Math.round((to_time - from_time) / 60000);
	document.getElementById("evDURATION").value = diff;
}

function updEVENT(sID, updNEXT = ''){
	var GRPBOX = document.getElementById("evPRIORITY");
	var sPRIORITY = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("evSTATUS");
	var sSTATUS = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("evLOC_ID");
	var sLOC_ID = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sCLI_ID  = document.getElementById("evCLI_ID").value;
	var sPRJ_ID  = document.getElementById("evPRJ_ID").value;
	var sNAME  = document.getElementById("evNAME").value;
	var sNAME_EN  = document.getElementById("evNAME_EN").value;
	var sDATE  = document.getElementById("evDATE").value;
	var sDATE_START  = sDATE + " " + document.getElementById("evDATE_START").value;
	var sDATE_END  = sDATE + " " + document.getElementById("evDATE_END").value;
	var sDURATION  = document.getElementById("evDURATION").value;
	var sDESC  = document.getElementById("evDESC_FR").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
	var sDESC_EN  = document.getElementById("evDESC_EN").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
	var sHREF  = document.getElementById("evHREF").value;
	var sIMG  = document.getElementById("evIMG").value;
	
    //verification si un nom d'évènement a été entré
	if (sNAME == ""){
		document.getElementById("evNAME").style.boxShadow = "5px 10px 15px red";
		document.getElementById("evNAME").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("evNAME").style.boxShadow = "5px 10px 15px #333";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	//vérification si la date de fin est après la date de début
	if (document.getElementById("evDATE_START").value > document.getElementById("evDATE_END").value){
		document.getElementById("evDATE_END").style.boxShadow = "0px 10px 15px red";
		document.getElementById("evDATE_END").focus();
		document.getElementById("lblEV_DATE_END").innerHTML = "L'heure de fin doit être après l'heure de début.";
		return;
	} else {
		document.getElementById("evDATE_END").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		document.getElementById("lblEV_DATE_END").innerHTML = "";
	}	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
          if (this.responseText.substr(0, 3) != "Err"){
				addNotif("<?php echo $dw3_lbl["UPDATED"]; ?>");
                jump();
                getD(currentDay);
				if (document.getElementById("divLATE_TASK").style.display == "inline-block"){
					getLATE_TASK('');
				}
                closeMSG();
                closeEDITOR();
		  } else {
             if (this.responseText == "Err_PARENT"){
				document.getElementById("divMSG").style.display = "inline-block";
	            document.getElementById("divMSG").innerHTML = "Évenement périodique. Mettre à jour les événements suivants aussi?<br><br><button class='green' onclick='updEVENT(" + sID + ",2);'><span class='material-icons' style='vertical-align:middle;'>save</span> Oui tout mettre à jour</button> <button class='green' onclick='updEVENT(" + sID + ",1);'><span class='material-icons'>save</span> Seulement celui-ci</button>";
             } else {
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
             }
		  }
	  }
	};
	xmlhttp.open('GET', 'updEVENT.php?KEY=' + KEY 
									+ '&ID=' + encodeURIComponent(sID)       
									+ '&PRIORITY=' + encodeURIComponent(sPRIORITY)    
									+ '&STATUS=' + encodeURIComponent(sSTATUS)    
									+ '&NAME=' + encodeURIComponent(sNAME)    
									+ '&NAME_EN=' + encodeURIComponent(sNAME_EN)    
									+ '&DESC=' + encodeURIComponent(sDESC)   
									+ '&DESC_EN=' + encodeURIComponent(sDESC_EN)   
									+ '&CLI=' + encodeURIComponent(sCLI_ID)   
									+ '&PRJ=' + encodeURIComponent(sPRJ_ID)   
									+ '&LOC=' + encodeURIComponent(sLOC_ID)   
									+ '&START=' + encodeURIComponent(sDATE_START)   
									+ '&END=' + encodeURIComponent(sDATE_END)   
									+ '&DURATION=' + encodeURIComponent(sDURATION)   
									+ '&IMG=' + encodeURIComponent(sIMG)   
									+ '&HREF=' + encodeURIComponent(sHREF)
									+ '&UPD_NEXT=' + updNEXT,                 
									true);
	xmlhttp.send();
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}

//REPEAT TIMESHEET
function closeTS_REPEAT() {
    document.getElementById('divTS_REPEAT').style.display = "none";
    document.getElementById("divFADE2").style.display = "none";
    document.getElementById("divFADE2").style.opacity = "0";
}
function openTS_REPEAT(headID) {
    document.getElementById('divTS_REPEAT').style.display = "inline-block";
    document.getElementById('tsID').value = headID;
}
function setTS_REPEAT(){
    var tsID =  document.getElementById('tsID').value;
    var GRPBOX = document.getElementById("tsTYPE");
    var tsTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
    var tsDURATION = document.getElementById("tsDURATION").value;
    if (document.getElementById("tsTO_YEAR_END").checked == false){ var tsYEAR_END = 0; } else { var tsYEAR_END = 1; }

    if (tsTO_YEAR_END == 0 && (isNaN(tsDURATION) || tsDURATION < 1 || tsDURATION > 999)){
        if (sNOM == ""){
            document.getElementById("tsDURATION").style.boxShadow = "5px 10px 15px red";
            document.getElementById("tsDURATION").focus();
            //document.getElementById("spanDURATION").innerHTML = "Veuillez entrer un nombre entre 1 et 999.";
            return;
        } else {
            document.getElementById("tsDURATION").style.boxShadow = "5px 10px 15px goldenrod";
            //document.getElementById("spanDURATION").innerHTML = "";
        }	
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          if (this.responseText == ""){
            closeTS_REPEAT();
            jump();
            getD(currentDay);
            addNotif("Le créneau horaire a été créé.");
          } else {
              	document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
          } 
      }
    };
    xmlhttp.open('GET', 'setTS_REPEAT.php?KEY=' + KEY 
                                    + '&UID=' 	+ currentUser
                                    + '&ID=' 	+ tsID
                                    + '&TYPE='	+ tsTYPE
                                    + '&YEAR_END='	+ tsYEAR_END
                                    + '&DURATION='	+ tsDURATION,true);
    xmlhttp.send();
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "0.4";
}

//PERIODIC TASK
function closePERIODIC() {
    document.getElementById('divPERIODIC').style.display = "none";
    document.getElementById("divFADE2").style.display = "none";
    document.getElementById("divFADE2").style.opacity = "0";
}
function openPERIODIC(taskID) {
    document.getElementById('divPERIODIC').style.display = "inline-block";
    document.getElementById('eventID').value = taskID;
}
function setPERIODIC(){
    var taskID =  document.getElementById('eventID').value;
    var GRPBOX = document.getElementById("periodTYPE");
    var periodTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
    var periodDURATION = document.getElementById("periodDURATION").value;

    if (isNaN(periodDURATION) || periodDURATION < 1 || periodDURATION > 999){
        if (sNOM == ""){
            document.getElementById("periodDURATION").style.boxShadow = "5px 10px 15px red";
            document.getElementById("periodDURATION").focus();
            //document.getElementById("spanDURATION").innerHTML = "Veuillez entrer un nombre entre 1 et 999.";
            return;
        } else {
            document.getElementById("periodDURATION").style.boxShadow = "5px 10px 15px goldenrod";
            //document.getElementById("spanDURATION").innerHTML = "";
        }	
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          if (this.responseText == ""){
            closePERIODIC();
            jump();
            getD(currentDay);
            getTASK(taskID);
            addNotif("Les tâches périodiques ont été créées.");
          } else {
              	document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
          } 
      }
    };

        xmlhttp.open('GET', 'setPERIODIC.php?KEY=' + KEY 
                                        + '&ID=' 	+ taskID
                                        + '&TYPE='	+ periodTYPE
                                        + '&DURATION='	+ periodDURATION,true);
        xmlhttp.send();
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divFADE2").style.opacity = "0.4";
}

function deletePERIODIC(taskID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment effacer toutes les tâches périodiques associées à cet événement ?<br><br><button class='red' onclick='delPERIODIC(" + taskID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}
function delPERIODIC(taskID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
                addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
                jump();
                getD(currentDay);
                closeMSG();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delPERIODIC.php?KEY=' + KEY + '&ID=' + taskID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

function deleteEVENT(ID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button class='red' onclick='delEVENT(" + ID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}

function delEVENT(ID, DEL_NEXT='') {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
                addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
                if (document.getElementById("divLATE_TASK").style.display == "inline-block"){
                    getLATE_TASK('');
                } 
                jump();
                getD(currentDay);
                closeMSG();
                closeEDITOR();
		  } else {
             if (this.responseText == "Err_PARENT"){
				document.getElementById("divMSG").style.display = "inline-block";
	            document.getElementById("divMSG").innerHTML = "Évenement périodique. Effacer les événements suivants aussi?<br><br><button class='red' onclick='delEVENT(" + ID + ",2);'><span class='material-icons' style='vertical-align:middle;'>delete</span>Oui tout effacer</button> <button class='red' onclick='delEVENT(" + ID + ",1);'><span class='material-icons'>cancel</span>Seulement celui-ci</button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>";
             } else {
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
             }
		  }
	  }
	};
		xmlhttp.open('GET', 'delEVENT.php?KEY=' + KEY + '&ID=' + ID + '&DEL_NEXT=' + DEL_NEXT, true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}


//PUNCH IN
function workSTART(headID, editDT = false) {
    if (editDT == undefined || editDT == false){
        var currentdate = new Date(); 
        //var DT = currentdate.getDate() + "/" + (currentdate.getMonth()+1)  + "/"   + currentdate.getFullYear() + " "    + currentdate.getHours() + ":"   + currentdate.getMinutes() + ":"  + currentdate.getSeconds();
        var DT = currentYear + "-" + ('0' + parseInt(currentMonth + 1)).slice(-2) + "-" + ('0' + currentDay).slice(-2) + " "    + currentdate.getHours() + ":"   + currentdate.getMinutes() + ":"  + currentdate.getSeconds();
    } else if (editDT == true){
        var DT = currentYear + "-" + ('0' + parseInt(currentMonth + 1)).slice(-2) + "-" + ('0' + currentDay).slice(-2) + " " + document.getElementById("editStartTime").value;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          if (this.responseText == ""){
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                closeMSG();
                getD(currentDay);
          } else {
              	document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
          } 
      }
    };
    xmlhttp.open('GET', 'workSTART.php?KEY=' + KEY  + '&ID=' + headID + '&DT=' + DT,true);
    xmlhttp.send();
}
function editSTART(ID,DT) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<h3>Modifier l'heure de début</h3><input type='time' id='editStartTime' value='"+DT+"'><br><br><button class='blue' onclick='workSTART(" + ID + ",true);'><span class='material-icons' style='vertical-align:middle;'>save</span><?php echo $dw3_lbl["MODIFY"]; ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}

//PUNCH OUT
function workEND(headID, editDT = false) {
    if (editDT == undefined || editDT == false){
        var currentdate = new Date(); 
        //var DT = currentdate.getDate() + "/" + (currentdate.getMonth()+1)  + "/"   + currentdate.getFullYear() + " "    + currentdate.getHours() + ":"   + currentdate.getMinutes() + ":"  + currentdate.getSeconds();
        var DT = currentYear + "-" + ('0' + parseInt(currentMonth + 1)).slice(-2) + "-" + ('0' + currentDay).slice(-2) + " "    + currentdate.getHours() + ":"   + currentdate.getMinutes() + ":"  + currentdate.getSeconds();
    } else if (editDT == true){
        var DT = currentYear + "-" + ('0' + parseInt(currentMonth + 1)).slice(-2) + "-" + ('0' + currentDay).slice(-2) + " " +document.getElementById("editEndTime").value;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          if (this.responseText == ""){
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                closeMSG();
                getD(currentDay);
          } else {
              	document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
          } 
      }
    };
    xmlhttp.open('GET', 'workEND.php?KEY=' + KEY  + '&ID=' + headID + '&DT=' + DT,true);
    xmlhttp.send();
}
function editEND(ID,DT) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<h3>Modifier l'heure de fin</h3><input type='time' id='editEndTime' value='"+DT+"'><br><br><button class='blue' onclick='workEND(" + ID + ",true);'><span class='material-icons' style='vertical-align:middle;'>save</span><?php echo $dw3_lbl["MODIFY"]; ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}

//CALL OFF
function workOFF(ID,DT) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<h3>Indisponibilité</h3>Voulez-vous vraiment déclarer une indisponibilité pour cette plage horaire?<br><i><span style='font-size:12px;'>La plage horaire sera retirée des disponibilités de l'agenda publique si applicable.</span></i><br><br><button class='red' onclick='callOFF(" + ID + ",true);'><span class='material-icons' style='vertical-align:middle;'>alarm_off</span>Indisponible</button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}
function callOFF(headID) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          if (this.responseText == ""){
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                closeMSG();
                getD(currentDay);
          } else {
              	document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
          } 
      }
    };
    xmlhttp.open('GET', 'callOFF.php?KEY=' + KEY  + '&ID=' + headID,true);
    xmlhttp.send();
}

</script>
</body>
</html>
