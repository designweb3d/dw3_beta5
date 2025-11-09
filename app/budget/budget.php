<?php /**
 +---------------------------------------------------------------------------------+
 | DW3 PME Kit BETA                                                                |
 | Version 0.1                                                                     |
 |                                                                                 | 
 |  The MIT License                                                                |
 |  Copyright © 2023 Design Web 3D                                                 | 
 |                                                                                 |
 |  Permission is hereby granted, free of charge, to any person obtaining a copy   |
 |   of this software and associated documentation files (the "Software"), to deal |
 |   in the Software without restriction, including without limitation the rights  |
 |   to use, copy, modify, merge, publish, distribute, sublicense, and/or sell     |
 |   copies of the Software, and to permit persons to whom the Software is         |
 |   furnished to do so, subject to the following conditions:                      | 
 |                                                                                 |
 |   The above copyright notice and this permission notice shall be included in    | 
 |   all copies or substantial portions of the Software.                           |
 |                                                                                 | 
 |   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR    |
 |   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,      |
 |   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE   | 
 |   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER        |
 |   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, | 
 |   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN     |
 |   THE SOFTWARE.                                                                 |
 |                                                                                 |
 +---------------------------------------------------------------------------------+
 | Author: Julien Béliveau <info@dw3.ca>                                           |
 +---------------------------------------------------------------------------------+*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php'; 
?>

<div id='divHEAD'>
	<table style="width:100%;margin:0px;white-space:nowrap;">
		<tr style="margin:0px;padding:0px;">
            <td style="margin:0px;padding:0px;text-align:center;font-size:1.2em;font-weight:bold;">
                Budget
                <select id="budyear" onchange="getBUDS()" style="display:inline-block;width:100px;">
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
                </select>
            </td>
			<td width="40" style="margin:0px;padding:0px;text-align:right;">
				<?php if($APREAD_ONLY == false) { ?><button class='blue' style="margin:0px 2px 0px 2px;padding:8px;" onclick="clearNEW();openNEW();"><span class="material-icons">add</span></button><?php } ?>
			 </td>
		</tr>
	</table>
</div>

<div id='divMAIN' class='divMAIN' style="padding-top:50px;">
<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>
</div>

<div id="divEDIT" class="divEDITOR" style='min-width:100px;max-width:400px;min-height:570px;'></div>

<div id="divNEW" class="divEDITOR" style='min-width:100px;max-width:400px;min-height:250px;'>
    <div id="divNEW_HEADER" class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>Nouveau</div></h3>
        <button onclick='closeNEW();' class='dw3_form_close grey'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">Nom:
            <input id="newNAME_FR" type="text">
        </div><br>
        <div class="divBOX">Type:
            <div style="display:inline-block;float:right;">
                <input id="newREVENU_1" name="newREVENU" type="radio" value="1" checked style='vertical-align: middle;'> <label for="newREVENU_1"> Revenu</label>
                <input id="newREVENU_0" name="newREVENU" type="radio" value="0" style='vertical-align: middle;'> <label for="newREVENU_0"> Dépense</label>
            </div>
        </div><br>
    </div>
	<div  class='dw3_form_foot'>
		<button class="grey" onclick="closeNEW();"><span class="material-icons">cancel</span> Annuler</button>
		<button class="green" onclick="newBUD();"><span class="material-icons">add</span> Créer</button>
	</div>
</div>


<div id="divMSG"></div>
<div id="divOPT"></div>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
    let today = new Date();
let currentYear = today.getFullYear();
var KEY = '<?php echo($_GET['KEY']); ?>';

$(document).ready(function ()
    {
        document.getElementById("budyear").value = currentYear;				   
		getBUDS();
        dragElement(document.getElementById("divNEW"));
	});

function getBUDS() {
    var GRPBOX = document.getElementById("budyear");
    var budyear = GRPBOX.options[GRPBOX.selectedIndex].value;		
	currentYear = budyear;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getBUDS.php?KEY=' + KEY + '&YEAR=' + encodeURIComponent(budyear), true);
    xmlhttp.send();		
}

function updOpening() {
    var sAMOUNT = document.getElementById("bud_year_opening").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Mise à jour du solde d'ouverture terminée.");
		getBUDS();
	  }
	};
	xmlhttp.open('GET', 'updOpening.php?KEY=' + KEY
    + '&A=' + encodeURIComponent(sAMOUNT)
    , true);
	xmlhttp.send();	
}

function newBUD() {
    var sNAME = document.getElementById("newNAME_FR").value.trim();
    var sREV = document.querySelector('input[name="newREVENU"]:checked').value;
    var GRPBOX = document.getElementById("budyear");
    var budyear = GRPBOX.options[GRPBOX.selectedIndex].value;	

    if (sNAME == "") {
        document.getElementById("newNAME_FR").style.border = "2px solid red";
        document.getElementById("newNAME_FR").focus();
        return;
    } else {
        document.getElementById("newNAME_FR").style.border = "";
    }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divNEW").style.display = "none";
        //closeNEW();
        addNotif("Création du record est terminée");
		getBUD(this.responseText);
	  }
	};
	xmlhttp.open('GET', 'newBUD.php?KEY=' + KEY
    + '&NAME=' + encodeURIComponent(sNAME)
    + '&REV=' + sREV
    + '&YEAR=' + budyear
    , true);
	xmlhttp.send();	
}

function getBUD(budID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEDIT").innerHTML = this.responseText;
         dragElement(document.getElementById("divEDIT"));
         document.getElementById("divEDIT").style.display = "inline-block";}
	};
    xmlhttp.open('GET', 'getBUD.php?KEY=' + KEY + '&ID=' + budID, true);
    xmlhttp.send();
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
}

function updBUD(xID){
    var sNAME = document.getElementById("budNAME_FR").value.trim();
    var sREV = document.querySelector('input[name="budREVENU"]:checked').value;
    var sSTART = document.getElementById("budSTART").value;
    var sEND = document.getElementById("budEND").value;
    var GRPBOX = document.getElementById("budFREQ");
    var sFREQ = GRPBOX.options[GRPBOX.selectedIndex].value;
    var sAMOUNT = document.getElementById("budMONTANT").value.trim();  

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
                addNotif("Mise à jour du record est terminée");
                closeEDITOR();
                getBUDS();
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
    xmlhttp.open('GET', 'updBUD.php?KEY=' + KEY 
                                    + '&ID=' + xID 
                                    + '&NAME=' + encodeURIComponent(sNAME)   
                                    + '&REV=' + encodeURIComponent(sREV)  
                                    + '&START=' + encodeURIComponent(sSTART)  
                                    + '&END=' + encodeURIComponent(sEND)  
                                    + '&FREQ=' + encodeURIComponent(sFREQ)  
                                    + '&AMOUNT=' + encodeURIComponent(sAMOUNT) ,   
                                    true);
    xmlhttp.send();
}

function deleteBUD(xID){
  	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.6";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button> <button class='red' onclick='delBUD(" + xID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span> Supprimer</button> ";
}
function delBUD(xID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
                addNotif("Suppression du record est terminée");
				getBUDS();
                closeEDITOR();
                closeMSG();
		  } else  {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
    xmlhttp.open('GET', 'delBUD.php?KEY=' + KEY + '&ID=' + xID, true);
    xmlhttp.send();
}

function clearNEW(){
    document.getElementById("newNAME_FR").value = "";
    document.getElementById("newREVENU_1").checked = true;
    document.getElementById("newNAME_FR").style.border = "";
}

function calcEnd(){
    var xStart = document.getElementById("budSTART").value;
    var GRPBOX = document.getElementById("budFREQ");
    var xFreq = GRPBOX.options[GRPBOX.selectedIndex].value;
    var xAmount = document.getElementById("budMONTANT").value.trim(); 

    if (xFreq == "") {
        document.getElementById("budFREQ").style.border = "2px solid red";
        document.getElementById("budFREQ").focus();
        return;
    } else {
        document.getElementById("budFREQ").style.border = "";
    }

    if (xAmount == "" || isNaN(xAmount) || Number(xAmount) == 0){ 
        document.getElementById("budMONTANT").style.border = "2px solid red";
        document.getElementById("budMONTANT").focus();
        return;
    } else {
        document.getElementById("budMONTANT").style.border = "";
    }

    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Combien reste-t-il à payer? <br><input type='number' id='inputToPay'><br><br><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button> <button class='blue' onclick=\"closeMSG();calcEndResult('"+xFreq+"','" +xAmount+"','" +xStart+"')\"><span class='material-icons' style='vertical-align:middle;'>calculate</span> Calculer</button>";
}

function calcEndResult(xFreq, xAmount, xStart){
    var xToPay = document.getElementById("inputToPay").value;
    if (xToPay.trim() == "" || isNaN(xToPay)){
        document.getElementById("inputToPay").style.border = "2px solid red";
        document.getElementById("inputToPay").focus();
        return;
    }
    closeMSG();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("budEND").value = this.responseText;
        addNotif("Calcul de la date de fin est terminée");
	  }
	};
    xmlhttp.open('GET', 'calcEnd.php?KEY=' + KEY + '&FREQ=' + xFreq + '&TO_PAY=' + xToPay + '&AMOUNT=' + xAmount + '&START=' + xStart, true);
    xmlhttp.send();
}

function toggleMonth(sub,up){
	if(document.getElementById(sub).style.height=="0px"){
		document.getElementById(up).innerHTML="calendar_month";
		document.getElementById(sub).style.height="auto";
		document.getElementById(sub).style.display="inline-block";
	} else {
		document.getElementById(up).innerHTML="calendar_today";
		document.getElementById(sub).style.height="0px";
		document.getElementById(sub).style.display="none";
	}
}
</script>
</body>
</html>
<?php $dw3_conn->close(); ?>