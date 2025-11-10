<?php 
if (!headers_sent()){header('Content-Type: application/javascript');}
    $KEY=$_GET['KEY']??'';
    if (!isset($USER_INACTIVE)){
        $USER_INACTIVE=$_GET['INACTIVE']??''; 
    }
    if($KEY == ''){
        die("alert('Error loading JavaScript');");
    } 
    echo "var KEY='".$KEY."';";
    echo "var USER_INACTIVE='".$USER_INACTIVE."';";
if (!isset($CIE_LOAD)){$CIE_LOAD = "";}
?> 
//rename KEY to dw3_user_key
var dw3_fade_obj    = document.getElementById("divFADE");
//var dw3_fade2_obj    = document.getElementById("divFADE2");

//APIS
//import * as THREE from 'three';
//const scene = new THREE.Scene();


//DETECT INACTIVITY
var dw3_inactivity_time = new Date().getTime();
if (USER_INACTIVE!= "" && USER_INACTIVE!= "0"){
    window.addEventListener("focus", dw3_check_inactivity, false);
    window.addEventListener("blur", dw3_set_activity, false);
    window.addEventListener("click", dw3_set_activity, false);
    window.addEventListener("mousemove", dw3_set_activity, false);
    window.addEventListener("keypress", dw3_set_activity, false);
    window.addEventListener("scroll", dw3_set_activity, false);
    document.addEventListener("touchMove", dw3_set_activity, false);
    document.addEventListener("touchEnd", dw3_set_activity, false);
    document.addEventListener("popstate", dw3_check_inactivity, false);
    setInterval(function () {dw3_check_inactivity();}, 5000);
}
function dw3_set_activity() {
    dw3_inactivity_time = new Date().getTime();
}
function dw3_check_inactivity() {
    var dw3_inactivity_now = new Date().getTime();
    if(dw3_inactivity_now - dw3_inactivity_time >= Math.floor(60000 * Number(USER_INACTIVE))) {
        if (document.hidden) {
            window.close();
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //
                }
            };
            xmlhttp.open('GET', '/sbin/logout.php?KEY='+KEY, true);
            xmlhttp.send();
            history.pushState("", document.title, window.location.pathname);
            setInterval(function () {window.open("/client","_self");}, 1000);
        }
    }
}
//DATAIA FUNCTIONS
function dataia_desc_set(db_name,dataia_index,output_to){
    var da_desc = "";
    if (db_name=="PLANT"){
        da_desc = "<table class='tblDATA' style='white-space: normal;'>"
        + "<tr><th style='text-align:center;'>&#128289;</th><th>Autres noms</th><td>"+dataia_data[dataia_index][3]+"</td></tr>"
        + "<tr><th style='text-align:center;'>&#128300;</th><th>Nom Latin</th><td>"+dataia_data[dataia_index][2]+"</td></tr>"
        + "<tr><th style='text-align:center;'>&#129516;</th><th>Famille</th><td>"+dataia_data[dataia_index][4]+"</td></tr>"
        + "<tr><th style='text-align:center;'>&#128166;</th><th>Arrosage</th><td>"+dataia_data[dataia_index][6]+"</td></tr>"
        + "<tr><th style='text-align:center;'>&#127777;</th><th>Zone</th><td>"+dataia_data[dataia_index][10]+" <a title='Trouver ma zone' href='https://www.planthardiness.gc.ca/?m=22&prov=Quebec&val=A&lang=fr' target='_blank' style='float:right;'>🔎<span style='vertical-align:middle;font-size:12px;'>Trouver ma zone</span></a></td></tr>"
        + "<tr><th style='text-align:center;'>&#127774;</th><th>Luminosité</th><td>"+dataia_data[dataia_index][8]+"</td></tr>"
        + "<tr><th style='text-align:center;'>&#128195;</th><th>Notes</th><td>"+dataia_data[dataia_index][11]+"</td></tr></table>"
        + "<div style='text-align:center;width:100%;'><a href='"+dataia_data[dataia_index][12]+"' target='_blank'><img src='/pub/upload/wiki.svg' style='width:30px;height:30px'></a></div>";
        addNotif(dataia_data[dataia_index][1]);
    } else {
        da_desc = "La base de donnée n'est pas compléte.";
    }
    document.getElementById(output_to).value = da_desc;
    var event = new Event('change');
    document.getElementById(output_to).dispatchEvent(event);
    closeMSG();
}
var dataia_data;
function dataia_desc_get(what_db,look_for,output_to){
    var GRPBOX  = document.getElementById(what_db);
	var db_name  = GRPBOX.options[GRPBOX.selectedIndex].value;
    if (document.getElementById(look_for)){
        var find = document.getElementById(look_for).value.trim();
    } else {
        var find = "";
    }
    var endpoint = '/api/dataia/dataia_'+db_name.toLowerCase()+'.php';
    let plants;
    let msg_text = "";
    //$("#"+output).empty();
    $.ajax({
        url: endpoint + "?KEY=" + KEY + "&k=e5ea4dd002761040457fb55fee0e012960e24e9506724752bd419bf3f9a15806e5ea4dd002761040457fb55fee0e012960e24e9506724752bd419bf3f9a15806&s=" + encodeURIComponent(find) + "&l=10",
        contentType: "application/json",
        type: 'GET',
        dataType: 'json',
        success: function(result){
            if (result.result == "ok" && result.row_count != "0"){
                plants = result.data; 
                dataia_data = result.data;
                    document.getElementById("divFADE2").style.opacity = "1";
                    document.getElementById("divFADE2").style.display = "inline-block";
                    document.getElementById("divMSG").style.display = "inline-block";
                    msg_text = "Veuillez choisir une description:<br><input type='text' id='dataia_desc_text' oninput=\"(dataia_desc_get('"+what_db+"',this.id,'"+output_to+"'))\"  value='"+find+"'><br><table id='tblDIA_DESC' class='tblSEL'>";
                    setTimeout(function(){ 
                      //that.selectionStart = that.selectionEnd = 10000; 
                      if (document.getElementById("dataia_desc_text")){
                        const dataia_find_text = document.getElementById("dataia_desc_text");
                        dataia_find_text.focus();
                        dataia_find_text.selectionStart = dataia_find_text.selectionEnd = dataia_find_text.value.length;
                      }
                    }, 500);
                
                plants.forEach(function(obj,index){
                    msg_text += "<tr onclick=\"dataia_desc_set('"+db_name+"','"+index+"','"+output_to+"')\"><td>"+ obj["1"]+"</td></tr>";
                })
                msg_text += "</table><br><span style='font-size:14px;'>Résultats limités à 10 veuillez faire une<br> recherche pour trouver d'autres descriptions.</span><button class='grey' onclick='closeMSG();'> Annuler</button>";
                document.getElementById("divMSG").innerHTML = msg_text ;
            } else if(look_for != ""){
                dataia_desc_get(what_db,"",output_to);
            } else if (result.result == "error"){
                document.getElementById("divFADE2").style.opacity = "1";
                document.getElementById("divFADE2").style.display = "inline-block";
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = result[0].data+"<br><button class='grey' onclick='closeMSG();'> Fermer</button>" ;
            }
        }
    })
}

//GLOBAL FUNCTIONS
function dw3_capitalize(word) {
    return word.charAt(0).toUpperCase() + word.slice(1);
}

function dw3_removeBR(str) {
    return str.split(/\r?\n|\r/).join('');
}

function dw3_remove_input_BR(input_name) {
    element = document.getElementById(input_name)
    //element.value = element.value.split(/\r?\n|\r/).join('');
    element.value = element.value.replace(/[\r\n]+/gm, "");
}

function dw3_beep() {
    var snd = new Audio("data:audio/wav;base64,//uQRAAAAWMSLwUIYAAsYkXgoQwAEaYLWfkWgAI0wWs/ItAAAGDgYtAgAyN+QWaAAihwMWm4G8QQRDiMcCBcH3Cc+CDv/7xA4Tvh9Rz/y8QADBwMWgQAZG/ILNAARQ4GLTcDeIIIhxGOBAuD7hOfBB3/94gcJ3w+o5/5eIAIAAAVwWgQAVQ2ORaIQwEMAJiDg95G4nQL7mQVWI6GwRcfsZAcsKkJvxgxEjzFUgfHoSQ9Qq7KNwqHwuB13MA4a1q/DmBrHgPcmjiGoh//EwC5nGPEmS4RcfkVKOhJf+WOgoxJclFz3kgn//dBA+ya1GhurNn8zb//9NNutNuhz31f////9vt///z+IdAEAAAK4LQIAKobHItEIYCGAExBwe8jcToF9zIKrEdDYIuP2MgOWFSE34wYiR5iqQPj0JIeoVdlG4VD4XA67mAcNa1fhzA1jwHuTRxDUQ//iYBczjHiTJcIuPyKlHQkv/LHQUYkuSi57yQT//uggfZNajQ3Vmz+Zt//+mm3Wm3Q576v////+32///5/EOgAAADVghQAAAAA//uQZAUAB1WI0PZugAAAAAoQwAAAEk3nRd2qAAAAACiDgAAAAAAABCqEEQRLCgwpBGMlJkIz8jKhGvj4k6jzRnqasNKIeoh5gI7BJaC1A1AoNBjJgbyApVS4IDlZgDU5WUAxEKDNmmALHzZp0Fkz1FMTmGFl1FMEyodIavcCAUHDWrKAIA4aa2oCgILEBupZgHvAhEBcZ6joQBxS76AgccrFlczBvKLC0QI2cBoCFvfTDAo7eoOQInqDPBtvrDEZBNYN5xwNwxQRfw8ZQ5wQVLvO8OYU+mHvFLlDh05Mdg7BT6YrRPpCBznMB2r//xKJjyyOh+cImr2/4doscwD6neZjuZR4AgAABYAAAABy1xcdQtxYBYYZdifkUDgzzXaXn98Z0oi9ILU5mBjFANmRwlVJ3/6jYDAmxaiDG3/6xjQQCCKkRb/6kg/wW+kSJ5//rLobkLSiKmqP/0ikJuDaSaSf/6JiLYLEYnW/+kXg1WRVJL/9EmQ1YZIsv/6Qzwy5qk7/+tEU0nkls3/zIUMPKNX/6yZLf+kFgAfgGyLFAUwY//uQZAUABcd5UiNPVXAAAApAAAAAE0VZQKw9ISAAACgAAAAAVQIygIElVrFkBS+Jhi+EAuu+lKAkYUEIsmEAEoMeDmCETMvfSHTGkF5RWH7kz/ESHWPAq/kcCRhqBtMdokPdM7vil7RG98A2sc7zO6ZvTdM7pmOUAZTnJW+NXxqmd41dqJ6mLTXxrPpnV8avaIf5SvL7pndPvPpndJR9Kuu8fePvuiuhorgWjp7Mf/PRjxcFCPDkW31srioCExivv9lcwKEaHsf/7ow2Fl1T/9RkXgEhYElAoCLFtMArxwivDJJ+bR1HTKJdlEoTELCIqgEwVGSQ+hIm0NbK8WXcTEI0UPoa2NbG4y2K00JEWbZavJXkYaqo9CRHS55FcZTjKEk3NKoCYUnSQ0rWxrZbFKbKIhOKPZe1cJKzZSaQrIyULHDZmV5K4xySsDRKWOruanGtjLJXFEmwaIbDLX0hIPBUQPVFVkQkDoUNfSoDgQGKPekoxeGzA4DUvnn4bxzcZrtJyipKfPNy5w+9lnXwgqsiyHNeSVpemw4bWb9psYeq//uQZBoABQt4yMVxYAIAAAkQoAAAHvYpL5m6AAgAACXDAAAAD59jblTirQe9upFsmZbpMudy7Lz1X1DYsxOOSWpfPqNX2WqktK0DMvuGwlbNj44TleLPQ+Gsfb+GOWOKJoIrWb3cIMeeON6lz2umTqMXV8Mj30yWPpjoSa9ujK8SyeJP5y5mOW1D6hvLepeveEAEDo0mgCRClOEgANv3B9a6fikgUSu/DmAMATrGx7nng5p5iimPNZsfQLYB2sDLIkzRKZOHGAaUyDcpFBSLG9MCQALgAIgQs2YunOszLSAyQYPVC2YdGGeHD2dTdJk1pAHGAWDjnkcLKFymS3RQZTInzySoBwMG0QueC3gMsCEYxUqlrcxK6k1LQQcsmyYeQPdC2YfuGPASCBkcVMQQqpVJshui1tkXQJQV0OXGAZMXSOEEBRirXbVRQW7ugq7IM7rPWSZyDlM3IuNEkxzCOJ0ny2ThNkyRai1b6ev//3dzNGzNb//4uAvHT5sURcZCFcuKLhOFs8mLAAEAt4UWAAIABAAAAAB4qbHo0tIjVkUU//uQZAwABfSFz3ZqQAAAAAngwAAAE1HjMp2qAAAAACZDgAAAD5UkTE1UgZEUExqYynN1qZvqIOREEFmBcJQkwdxiFtw0qEOkGYfRDifBui9MQg4QAHAqWtAWHoCxu1Yf4VfWLPIM2mHDFsbQEVGwyqQoQcwnfHeIkNt9YnkiaS1oizycqJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");  
    snd.play();
}

function dw3_json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}

function dw3_element_to_clipboard(source_element) {
    var copyText = document.getElementById(source_element);
    navigator.clipboard.writeText(copyText.innerHTML);
    addNotif("Le texte a été copié dans le presse-papier.");
}
function dw3_input_to_clipboard(source_input) {
    var copyText = document.getElementById(source_input);
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    navigator.clipboard.writeText(copyText.value);
    addNotif("Le texte a été copié dans le presse-papier.");
}
function dw3_text_to_clipboard(source_text) {
    navigator.clipboard.writeText(source_text);
    addNotif("Le texte a été copié dans le presse-papier.");
}

function dw3_translate(from,source='FR',target='EN',object='dw3_msg') {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
    if (source == "FR" || source == "fr"){var source_name = "Français"; var target_name = "Anglais"; } else {var source_name = "Anglais"; var target_name = "Français";}
    document.getElementById("divMSG").innerHTML = "Traduire de <b>"+ source_name +"</b> vers <b>" + target_name + "</b>?<div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button> <button class='blue' onclick=\"dw3_translate_func('"+from+"','"+source+"','"+target+"','"+object+"')\"><span class='material-icons' style='vertical-align:middle;'>translate</span> Traduire</button>" ;
}
function dw3_translate_func(from,source='FR',target='EN',object='dw3_msg') {
    var quest = document.getElementById(from).value;
    if (quest == "" || quest == undefined){return false;}
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(object).value = this.responseText;
        closeMSG();
      }
    };
    xmlhttp.open('GET', '/sbin/traduction_deepl.php?KEY=' + KEY 
                                    + '&t=' + target  
                                    + '&m=' + encodeURIComponent(quest),    
                                    true);
    xmlhttp.send();
}

function dw3_secure_download(fn) {
    window.open("/sbin/secure_download.php?KEY=" + KEY + "&fn="+encodeURIComponent(fn),"_blank");
}

//EXPORT TO PDF FUNCTION
function ExportToPDF_old(tb,fn) {
    html2canvas(document.getElementById(tb), {
        onrendered: function (opt_canvas) {
            var data = opt_canvas.toDataURL();
            var docDefinition = {
                content: [{
                    image: data,
                    width: 500
                }]
            };
            pdfMake.createPdf(docDefinition).download(fn);
        }
    });
}

function ExportToPDF(tableId,fn) {
    const table = document.getElementById(tableId);
    const tableRows = table.querySelectorAll('tr');
    const data = [];

    // Extract header row
    const headerRow = tableRows[0];
    const headers = Array.from(headerRow.querySelectorAll('th')).map(th => th.innerText);
    data.push(headers);

    // Extract data rows
    for (let i = 1; i < tableRows.length; i++) {
        const row = tableRows[i];
        const rowData = Array.from(row.querySelectorAll('td')).map(td => td.innerText);
        data.push(rowData);
    }

    const docDefinition = {
        content: [
            { text: fn, style: 'header' },
            {
                style: 'tableExample',
                table: {
                    headerRows: 1,
                    body: data
                }
            }
        ],
        styles: {
            header: {
                fontSize: 18,
                bold: true,
                margin: [0, 0, 0, 10]
            },
            tableExample: {
                margin: [0, 5, 0, 15]
            }
        }
    };

    pdfMake.createPdf(docDefinition).download(fn+'.pdf');
}

function ExportToPDF_old(tableId,fn) {
        const input = document.getElementById(tableId);

        html2canvas(input, { scale: 2 }).then(canvas => { // Adjust scale for better resolution
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jspdf.jsPDF('p', 'mm', 'a4'); // 'p' for portrait, 'mm' for units, 'a4' for page size
            const imgWidth = 210; // A4 width in mm
            const pageHeight = 297; // A4 height in mm
            const imgHeight = canvas.height * imgWidth / canvas.width;
            let heightLeft = imgHeight;
            let position = 0;

            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            pdf.save(fn+'.pdf');
        });
}

//EXPORT TO EXCEL FUNCTIONS
function ExportToExcel(table,type, fn, dl) {//rename to dw3_table_to_xlsx(table,type, fn, dl);
       var elt = document.getElementById(table);
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn + ('.' + type || '.xlsx') || ('MySheetName.' + (type || 'xlsx')));
}

function fnExcelReport(tableId,filename) { //rename to dw3_table_to_xls(tableId,filename);
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById(tableId); 

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
    return (sa);
}

function sendSMS(phone,message_id){ //rename to dw3_sms_send(phone,message_id);
    if (phone==""||phone=="0"){return false;}
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
               //alert (this.responseText);
              if (this.responseText == ""){
                //no-error
                addNotif("SMS envoyé a: " + phone);
              } else {
                //error
                addNotif(this.responseText);
              } 
          }
        };
        xmlhttp.open('GET', '/sbin/sms.php?KEY=' + KEY 
                                        + '&p=' + phone  
                                        + '&m=' + encodeURIComponent(message_id),    
                                        true);
        xmlhttp.send();
}

function openchatGPT(){
    document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<input type='text' id='chatGPT_input'><br><br><button class='grey' onclick='closeMSG();'> Fermer</button><button class='grey' onclick='dw3_chatGPT();'> Envoyer</button>" ;
}
function dw3_chatGPT(message){ 
    if (message == ""){message = document.getElementById("chatGPT_input").value;}
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            addMsg(this.responseText + "<br><br><input type='text' id='chatGPT_input'><button class='grey' onclick='closeMSG();'> Fermer</button><button class='grey' onclick='dw3_chatGPT();'> Envoyer</button>");
        }
    };
    xmlhttp.open('GET', '/sbin/chatGPT.php?KEY=' + KEY 
                                    + '&m=' + encodeURIComponent(message),    
                                    true);
    xmlhttp.send();
}

function dw3_gpt_chat(input_obj,output_obj){
	var sROLE = "You are a test assistant.";
	var sQUESTION = document.getElementById(input_obj).value;

    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;border-radius:5px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'><br>";

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById(output_obj).value = this.responseText;
        closeMSG();
	  }
	};
    xmlhttp.open('GET', '/api/chatGPT/chat.php?KEY=' + KEY + "&S="+encodeURIComponent(sROLE)+"&Q=" + encodeURIComponent(sQUESTION), true);
    xmlhttp.send();
}

function dw3_gpt_image(input_obj,output_img,output_fn,upload_path){
	var sPROMPT = document.getElementById(input_obj).value;
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;border-radius:5px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'><br>";

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substring(0,3) == "Err"){
            document.getElementById("divMSG").innerHTML = this.responseText+"<br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
        } else {
            document.getElementById(output_img).src = upload_path + this.responseText;
            document.getElementById(output_fn).value = this.responseText;
            closeMSG();
        }
	  }
	};
    xmlhttp.open('GET', '/api/chatGPT/image.php?KEY=' + KEY + "&Q=" + encodeURIComponent(sPROMPT) + "&P=" + encodeURIComponent(upload_path), true);
    xmlhttp.send();
}

function dw3_prompt_gpt_image(output_img,output_fn,upload_path){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Décrire l'image pour chatGPT:<br><input id='dw3_prompt_fai' type='text' style='width:250px;'><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button><button class='grey' onclick=\"dw3_gpt_image('dw3_prompt_fai','"+output_img+"','"+output_fn+"','"+upload_path+"');\"><span class='material-icons' style='vertical-align:middle;'>send</span> Envoyer</button>";
}
function dw3_prompt_grok_image(output_img,output_fn,upload_path){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Décrire l'image pour Grok:<br><input id='dw3_prompt_fai' type='text' style='width:250px;'><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button><button class='grey' onclick=\"dw3_grok_image('dw3_prompt_fai','"+output_img+"','"+output_fn+"','"+upload_path+"');\"><span class='material-icons' style='vertical-align:middle;'>send</span> Envoyer</button>";
}

function dw3_grok_chat(input_obj,output_obj){
	var sROLE = "You are a test assistant.";
	var sQUESTION = document.getElementById(input_obj).value;

    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;border-radius:5px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'><br>";

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById(output_obj).value = this.responseText;
        closeMSG();
	  }
	};
    xmlhttp.open('GET', '/api/Grok/chat.php?KEY=' + KEY + "&S="+encodeURIComponent(sROLE)+"&Q=" + encodeURIComponent(sQUESTION), true);
    xmlhttp.send();
}

function dw3_grok_image(input_obj,output_img,output_fn,upload_path){
	var sQUESTION = document.getElementById(input_obj).value;

    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;border-radius:5px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'><br>";

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substring(0,3)=="Err"){
            addMsg(this.responseText+ "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            if (this.responseText.substring(0,3) == "Err"){
                document.getElementById("divMSG").innerHTML = this.responseText+"<br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
            } else {
                document.getElementById(output_img).src = upload_path + this.responseText;
                document.getElementById(output_fn).value = this.responseText;
                closeMSG();
            }
        }
	  }
	};
    xmlhttp.open('GET', '/api/Grok/image.php?KEY=' + KEY + "&P=&Q=" + encodeURIComponent(sQUESTION)+ "&P=" + encodeURIComponent(upload_path), true);
    xmlhttp.send();
}

function dw3_mail_new(){}
function dw3_mail_del(msgid){

}
function dw3_mail_read(msgid){ 
    if (crit == ""){$crit="ALL";}
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200 && this.responseText != "") {
            addMsg(this.responseText + "<br><br><button class='grey' onclick='closeMSG();'> Fermer</button><button class='grey' onclick='dw3_new_mail();'> Nouveau</button>");
      }
    };
    xmlhttp.open('GET', '/sbin/readMail.php?KEY=' + KEY + '&m=' + msgid,true);
    xmlhttp.send();
}
function dw3_mail_open(crit){ 
    if (crit == ""){$crit="ALL";}
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200 && this.responseText != "") {
                addMsg(this.responseText + "<br><br><button class='grey' onclick='closeMSG();'> Fermer</button><button class='grey' onclick='dw3_new_mail();'> Nouveau</button>");
          }
        };
        xmlhttp.open('GET', '/sbin/openMail.php?KEY=' + KEY + '&c=' + crit,true);
        xmlhttp.send();
}

function addMsg(text) { //rename to dw3_alert(text);
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = text ;
}
function addTool(text) { //rename to dw3_tool(text);
	document.getElementById("divTOOL").style.display = "inline-block";
	document.getElementById("divTOOL").innerHTML = text ;
}
//sNotifCount = 0;
function addNotif(text) { //rename to dw3_notif(text);
    const newDiv = document.createElement("div");
    newDiv.style.background = "#FFF";
    //newDiv.style.borderRadius = "5px";
    newDiv.style.color = "#333";
    newDiv.style.borderLeft = "5px solid #226622";
    newDiv.style.transition ="all 1s";
    //newDiv.style.fontWeight ="bold";
    newDiv.style.fontSize ="0.8em";
    newDiv.style.maxWidth ="95%";
    newDiv.style.minWidth ="200px";
    newDiv.style.width ="auto";
    newDiv.style.padding ="8px 10px 10px 10px";
    newDiv.style.fontFamily ="Tahoma";
    newDiv.style.margin ="5px";
    newDiv.style.cursor ="pointer";
    newDiv.style.display ="table";
    newDiv.style.textAlign ="left";
    newDiv.style.float ="right";
    newDiv.innerHTML = " <sup><span style='float:right;margin:-5px -5px 5px 5px;font-size:1em;font-weight:normal;color:#333'>X</span></sup> <span style='vertical-align:middle;width:90%;'>" + text + "</span>";
    const currentDiv = document.getElementById("dw3_notif_container");
	currentDiv.appendChild(newDiv);
    newDiv.addEventListener("click", function(event) {
            newDiv.style.opacity = "0";
            setTimeout(function () {
                newDiv.style.display = "none";
            }, 1000);
    });
    setTimeout(function () {
		newDiv.style.opacity = "0";
	}, 5000);
    setTimeout(function () {
		newDiv.style.display = "none";
        newDiv.remove();
		//sNotifCount = sNotifCount-1;
	}, 6000);
}

function detectCLICK(event,that){  //rename to dw3_input_click(event,that);
	var x = event.offsetX;
	if (x > (that.offsetWidth-25)){
        that.select();
	}
}
function dataia_loc_select(event,that){ 
	var x = event.offsetX;
	if (x > (that.offsetWidth-25)){
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
    newDiv.style.textShadow ="2px 2px #DDDDDD";
    newDiv.style.padding ="5px 10px 5px 10px";
    newDiv.style.margin ="10px";
    //newContent2.style.background = "white";
    //newContent2.style.color = "darkgreen";
    //newDiv.appendChild(newContent2);
    newDiv.innerHTML = "test " + this.responseText;
    const currentDiv = document.getElementById("divMENU_BTN");
    document.body.insertBefore(newDiv, currentDiv);
	}
}

function selCHK(sID) {  //rename to dw3_checkbox_click(sID);
	if (document.getElementById(sID).checked){
		document.getElementById(sID).checked = false;
	} else {                    
		document.getElementById(sID).checked = true;
	}
}

function selALL(oFORM,sTYPE) { //rename to dw3_select_all(event,that);
	var daFORM  = document.getElementById(oFORM);
	for (var i = 0; i < daFORM.elements.length; i++ )
	{ 
		if (daFORM.elements[i].type == sTYPE)
		{
			if (sTYPE == 'checkbox'){
				daFORM.elements[i].checked = true;
			} else if(sTYPE == '') {
				//todo
				//daFORM.elements[i].
			}
		}
	}
    checkBatch(daFORM);
	//document.getElementById('btnBatch').disabled = false;
	//document.getElementById('btnBatch').style.background = '#444';
}
function selNONE(oFORM,sTYPE) { //rename to dw3_select_none(oFORM,sTYPE);
	var daFORM  = document.getElementById(oFORM);
	for (var i = 0; i < daFORM.elements.length; i++ )
	{ 
		if (daFORM.elements[i].type == sTYPE)
		{
			if (sTYPE == 'checkbox'){
				daFORM.elements[i].checked = false;
			} else if(sTYPE == '') {
				//todo
				//daFORM.elements[i].
			}
		}
	}
	//document.getElementById('btnBatch').disabled = true;
	//document.getElementById('btnBatch').style.background = '#666';
    closeBatch();
}

function showPW(event,that) {  //rename to dw3_pw_show(event,that);
  	var x = event.offsetX;
	if (x > (that.offsetWidth-25)){
	  that.classList.toggle("eye_off");
	  if (that.type === "password") {
        addMsg("Choisissez une methode d'authentification<br><br><button onclick='authBySMS();'>Message texte</button><button onclick='authByEmail();'>Courriel</button><hr>Entrez le code reçu:<br><form><input style='width:120px;' type='password' id='authViewPw'></form><br><button class='grey' onclick='closeMSG();'>Annuler</button><button onclick='document.getElementById(\""+that.id+"\").type =\"text\";closeMSG();'>Valider</button>");
	  } else {
		that.type = "password";
	  }
	}
}
function logOUT() { //rename to dw3_logout(event,that);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		//location.reload();
        window.open("/","_self");
	  }
	};
		xmlhttp.open('GET', '/sbin/logout.php?KEY='+KEY, true);
		xmlhttp.send();
		
}
function clearINPUT(that) { //rename to dw3_input_clear(that);
	document.getElementById(that).value = "";
	focusINPUT(that);
}
function focusINPUT(that) { //rename to dw3_input_focus(that);
	document.getElementById(that).focus();
}

function openTOOLS() {  //rename to dw3_input_tools_open();
	if (document.getElementById("divTOOLS").style.display == "none") {
		document.getElementById("divTOOLS").style.display = "inline-block";
	} else {
		document.getElementById("divTOOLS").style.display = "none";
	}
}

function openFILTRE() {  //rename to dw3_filter_open();
	document.getElementById("divFILTRE").style.display = "inline-block";
	document.getElementById("divFILTRE").style.opacity = "1";
	divFADE.style.display = "inline-block";
	divFADE.style.opacity = "0.6";
	if (document.getElementById('divBATCH')){closeBatch();}
}
function openBatch(){ //rename to dw3_batch_open();
    if (document.getElementById('divBATCH').style.bottom == "-300px"){
        document.getElementById('divBATCH').style.bottom = "50px";
    }else{
        document.getElementById('divBATCH').style.bottom = "-300px";
    }
}
function closeBatch(){  //rename to dw3_batch_close();
    var obj = document.getElementById('divBATCH'); 
	if (typeof obj != 'undefined' && obj != null) {
		obj.style.bottom = "-300px";
	} 
}

function checkBatch(that){ 
    if (document.getElementById('btnBatch')){     //rename to dw3_batch_click(that);
        if (isSelection(that.id) == true){
            document.getElementById('btnBatch').disabled = false;
            //document.getElementById('btnBatch').style.background = '#444';
        } else {
            document.getElementById('btnBatch').disabled = true;
            //document.getElementById('btnBatch').style.background = '#666';
        }
    }
}

function isSelection(formName){ //rename to dw3_is_selected(oFORM);
    var form  = document.getElementById(formName);
	for (var i = 0; i < form.elements.length; i++ ) 
	{
		if (form.elements[i].type == 'checkbox')
		{
			if (form.elements[i].checked == true)
			{
				return true;
			}
		}
	}	
}

function closeFILTRE() { //rename to dw3_filter_close();
	divFADE.style.opacity = "0";
	document.getElementById("divFILTRE").style.display = "none";
    setTimeout(function () {
		divFADE.style.display = "none";
	}, 500);
}


//public vars for video/photo from cam
const opt_width = 320;    // We will scale the photo width to this
var opt_height = 0;     // This will be computed based on the input stream
var opt_streaming = false;
let opt_video = null;
let opt_camera = null;
let opt_canvas = null;
let opt_photo = null;
let opt_output = null;
let opt_startbutton = null;
function opt_stop_cam() {
    localStream.getTracks().forEach( (track) => {
        track.stop();
        });
        // stop only audio
        //localStream.getAudioTracks()[0].stop();
        // stop only video
        //localStream.getVideoTracks()[0].stop();
}
function opt_open_cam() {
    document.getElementById('divPHOTO').style.display = "inline-block";
    document.getElementById('divAVATAR').style.display = "none";
    navigator.mediaDevices
    .getUserMedia({ video: true, audio: false })
    .then((stream) => {
        opt_camera.style.display = "inline-block";
        opt_output.style.display = "none";
        opt_video.srcObject = stream;
        opt_video.play();
        window.localStream = stream;
    })
    .catch((err) => {
      console.error(`An error occurred: ${err}`);
    });
    opt_video.addEventListener(
        "canplay",
        (ev) => {
          if (!opt_streaming) {
            opt_height = (opt_video.videoHeight / opt_video.videoWidth) * opt_width;
            opt_video.setAttribute("width", opt_width);
            opt_video.setAttribute("height", opt_height);
            opt_canvas.setAttribute("width", opt_width);
            opt_canvas.setAttribute("height", opt_height);
            opt_streaming = true;
          }
        },
        false
      );
      opt_startbutton.addEventListener(
        "click",
        (ev) => {
            opt_takephoto();
          ev.preventDefault();
        },
        false
      );
      //opt_clearphoto();
}
function opt_clearphoto() {
    const context = opt_canvas.getContext("2d");
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, opt_canvas.width, opt_canvas.height);
    const data = opt_canvas.toDataURL("image/png");
    opt_photo.setAttribute("src", data);
}

function uploadPhoto(data){
    fetch('/sbin/uploadPHOTO.php?KEY=' + KEY, { method: "post", headers:{'Content-Type': 'multipart/form-data'}, body: data })
        .then(function() {
            addNotif("Image transférée");
        })
    .catch(err => console.log(err));
}

function opt_takephoto() {
    const context = opt_canvas.getContext("2d");
    if (opt_width && opt_height) {
        opt_canvas.width = opt_width;
        opt_canvas.height = opt_height;
      context.drawImage(opt_video, 0, 0, opt_width, opt_height);
      const data = opt_canvas.toDataURL("image/png");
      opt_photo.setAttribute("src", data);
      opt_camera.style.display = "none";
      opt_output.style.display = "inline-block";
      uploadPhoto(data);
      opt_stop_cam();
      dw3_beep();
      upd_picture_type('PHOTO','');
    } else {
        opt_clearphoto();
    }
  }

  function upd_picture_type(picture_type,picture_url) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', '/sbin/updPICTURE.php?KEY='+KEY+'&T='+picture_type+'&U='+picture_url, true);
		xmlhttp.send();
}

//MULTIAVATAR
function dw3_avatar_change(avatarId,outputId){  //rename to dw3_text_to_avatar(avatarId,outputId)
	if (avatarId == ""){avatarId = " ";}
	var svgCode = multiavatar(avatarId);
    if (document.getElementById(outputId)){
        document.getElementById(outputId).innerHTML=svgCode;
    }
}

function dw3_opt_picture(target,img) {
    document.getElementById("divAVATAR").style.display = "none";
    document.getElementById("divPHOTO").style.display = "inline-block";
    document.getElementById(target).src = "/pub/upload/"+img;
    upd_picture_type("PICTURE",img);
}
function dw3_opt_picture2(target,img) {
    document.getElementById("divAVATAR").style.display = "none";
    document.getElementById("divPHOTO").style.display = "inline-block";
	document.getElementById(target).src = "/pub/img/avatar/"+img;
  upd_picture_type("PICTURE2",img);
}

function choosePICTURE(target) {
  var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', '/sbin/getUPLOADS.php?KEY=' + KEY + "&TARGET=" + target, true);
		xmlhttp.send();	
}
function choosePICTURE2(target) {
  var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', '/sbin/getUPLOADS2.php?KEY=' + KEY + "&TARGET=" + target, true);
		xmlhttp.send();	
}

function defaultAVATAR() {
    document.getElementById('divAVATAR').style.display = "inline-block";
    document.getElementById('divPHOTO').style.display = "none";
    upd_picture_type('AVATAR','');
}

function openNEW() { //rename to dw3_new_open();
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.5";
	document.getElementById("divNEW").style.zIndex = "1101";
	document.getElementById("divNEW").style.display = "inline-block";
	window.scrollTo(0, 0);
	document.getElementById('divNEW').scrollTop = 0;
    closeBatch();
}
function openHEAD_POPUP() { //rename to dw3_popup_open();
	if (document.getElementById("divHEAD_POPUP").style.display == "none") {
		document.getElementById("divHEAD_POPUP").style.display = "inline-block";
		document.getElementById("divHEAD_POPUP").style.opacity = "1";	
		document.getElementById("divHEAD_POPUP").style.height = "auto";	
	} else {
		document.getElementById("divHEAD_POPUP").style.display = "none";
		document.getElementById("divHEAD_POPUP").style.opacity = "0";	
		document.getElementById("divHEAD_POPUP").style.height = "0px";	
	}
}
function openMENU() { //rename to dw3_menu_open();
	window.scrollTo(0, 0);
	//document.getElementById("divMENU").style.width = "275px";
    //document.getElementById("divMENU").style.height = "auto";
    document.getElementById("divMENU").style.transform = "initial";
    //document.getElementById("divMENU").style.transform = "translate(0px,0px) scale3d(1,1,1)";
    document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.5";
	//document.getElementById("divFADE").classList.add('visible');
	closeBatch();
}
function closeMENU() { //rename to dw3_menu_close();
	document.getElementById("divMSG").style.display = "none";
	document.getElementById("divMENU").style.transform = "translate(-275px,-275px) scale3d(0,0,0)";
	//document.getElementById("divMENU").style.transform = "scaleX(0)";
	
	var xxx = document.getElementById('divEDIT');
	if (typeof xxx != 'undefined' && xxx != null) {
		if (xxx.style.display == 'inline-block'){
			//alert (document.getElementById('divEDIT').style.display);
			return;
		}
	}
	var xxx = document.getElementById('divOPT'); 
	if (typeof xxx != 'undefined' && xxx != null) {
		if (xxx.style.display == 'inline-block'){
			return;
		}
	} 
	var xxx = document.getElementById('divFILES_MANAGER'); 
	if (typeof xxx != 'undefined' && xxx != null) {
		if (xxx.style.display == 'inline-block'){
			return;
		}
	} 
	var xxx = document.getElementById('divNEW'); 
	if (typeof xxx != 'undefined' && xxx != null) {
		if (xxx.style.display == 'inline-block'){
			return;
		}
	} 
	var xxx = document.getElementById('divCLI_LST'); 
	if (typeof xxx != 'undefined' && xxx != null) {
		if (xxx.style.display == 'inline-block'){
			return;
		}
	} 
	var xxx = document.getElementById('divSECTION'); 
	if (typeof xxx != 'undefined' && xxx != null) {
		if (xxx.style.display == 'inline-block'){
			return;
		}
	} 
	var xxx = document.getElementById('divFILTRE');
	if (typeof xxx != undefined && xxx != null) {
		xxx.style.display = 'none';
	} 
	var xxx = document.getElementById('divPARAM');
	if (typeof xxx != 'undefined' && xxx != null) {
		xxx.style.display = 'none';
	} 
	document.getElementById("divFADE").style.opacity = "0";
	setTimeout(function () {
		document.getElementById("divFADE").style.display = "none";
        //document.getElementById("divMENU").style.height = "0px";
		}, 500);
	
}
function closeMSG() { //rename to dw3_alert_close();
	document.getElementById("divFADE2").style.opacity = "0";
	document.getElementById("divFADE2").classList.remove('divFADE_IN');
    setTimeout(function () {
		document.getElementById("divFADE2").style.display = "none";

		}, 500);
	document.getElementById('divMSG').style.display = 'none';
}
function closeTOOL() { //rename to dw3_tool_close();
	document.getElementById('divTOOL').style.display = 'none';
    document.onkeydown = null;
}
function closeMSG_STRIPE() { //rename to dw3_alert_close();
	document.getElementById("divFADE2").style.opacity = "0";
	document.getElementById("divFADE2").classList.remove('divFADE_IN');
    setTimeout(function () {
		document.getElementById("divFADE2").style.display = "none";

		}, 500);
	document.getElementById('divMSG').style.display = 'none';
    window.history.pushState('', 'Espace-Client', '/client/dashboard.php?KEY='+KEY);
    if (window.history.replaceState) {
    //prevents browser from storing history with each change:
        window.history.replaceState('', 'Espace-Client', '/client/dashboard.php?KEY='+KEY);
    }
}
function closeMAP() { //rename to dw3_map_close();
	document.getElementById('divMAP').style.display = 'none';
		document.getElementById("divFADE").style.opacity = "0";
	document.getElementById("divFADE").classList.remove('divFADE_IN');
    setTimeout(function () {
		document.getElementById("divFADE").style.display = "none";

		}, 500);
}
function closeNEW() { //rename to dw3_new_close();
	document.getElementById('divNEW').style.display = 'none';
	document.getElementById("divFADE").style.opacity = "0";
	document.getElementById("divFADE").classList.remove('divFADE_IN');
	setTimeout(function () {
		document.getElementById("divFADE").style.display = "none";
	}, 500);
}

function closeEDITOR() { //rename to dw3_editor_close();
	document.getElementById("divFADE").style.opacity = "0";
	setTimeout(function () {
		document.getElementById("divFADE").style.display = "none";
	}, 500);
	if ($('#divPARAM').length > 0) {
		document.getElementById('divPARAM').style.display = 'none';
	}
	if ($('#divEDIT').length > 0) {
		document.getElementById("divEDIT").style.display = 'none';
	}
	if ($('#divPARAM').length > 0) {
		document.getElementById('divPARAM').style.display = 'none';
	}
	if ($('#divNEW').length > 0) {
		document.getElementById('divNEW').style.display = 'none';
	}
}
function showTB(tbID) { //rename to dw3_table_body_show(tbID);
var sID = 'TBody' + tbID.toString();
var xID = '#hiddenDiv' + tbID.toString();
    let element = document.getElementById(sID);
    let hidden = element.getAttribute("hidden");
	
    if (hidden) {
       element.removeAttribute("hidden");
	   	if ($(xID).length > 0) {
			$(xID).show();
		}
    } else {
       element.setAttribute("hidden", "hidden");
	   	if ($(xID).length > 0) {
			$(xID).hide();
		}
    }
}


dw3_fade_obj.addEventListener("click", function(event) {
    closeMENU();
});
var element2 = document.getElementById("divMENU_BTN");
element2.addEventListener("mousedown", function(event) {
    openMENU();
});
var element3 = document.getElementById("divMENU_TOP");
element3.addEventListener("click", function(event) {
	window.open("/","_self");
    closeMENU();
});
window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || ( typeof window.performance != "undefined" && window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    //window.location.reload();
  }
});

function sortTable(COL=0) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("dataTABLE");
  switching = true;
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[COL];
      y = rows[i + 1].getElementsByTagName("TD")[COL];
      // Check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        // If so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
var currentSORTway="ASC";
function sortTable2(COL=0,tableNAME) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(tableNAME);
  switching = true;
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[COL];
      y = rows[i + 1].getElementsByTagName("TD")[COL];
      if (y == undefined){break;}
      // Check if the two rows should switch place:
      if (currentSORTway == "ASC"){
            if (!isNaN(x.innerHTML.replace("$", "").trim()) && !isNaN(y.innerHTML.replace("$", "").trim())){
                if (parseInt(x.innerHTML.replace("$", "").trim()) > parseInt(y.innerHTML.replace("$", "").trim())) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        } else {
            if (!isNaN(x.innerHTML.replace("$", "").trim()) && !isNaN(y.innerHTML.replace("$", "").trim())){
                if (parseInt(x.innerHTML.replace("$", "").trim()) < parseInt(y.innerHTML.replace("$", "").trim())) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
  if (currentSORTway == "ASC"){currentSORTway = "DESC";}else{currentSORTway = "ASC";}
}
function filterTable3(sTBL,sCol,sVal) {
  var filter, table, tr, td, i, txtValue;
  filter = sVal.toUpperCase();
  table = document.getElementById(sTBL);
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[sCol];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1 || sVal == "") {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function filterTable2(sCol,sVal) {
  var filter, table, tr, td, i, txtValue;
  filter = sVal.toUpperCase();
  table = document.getElementById("dataTABLE");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[sCol];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1 || sVal == "") {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function filterTable() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("inputSEARCH");
  filter = input.value.toUpperCase();
  table = document.getElementById("dataTABLE");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function openOPT() { //rename to dw3_options_open();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divOPT").innerHTML = this.responseText;
		dragElement(document.getElementById('divOPT'));
        opt_video = document.getElementById('opt_video');
        opt_canvas = document.getElementById('opt_canvas');
        opt_photo = document.getElementById('opt_photo');
        opt_camera = document.getElementById('opt_camera');
        opt_output = document.getElementById('opt_output');
        opt_startbutton = document.getElementById('opt_startbutton');

        //signature user
        var canvas_tag = document.getElementById("user_signature_pad");
        var signaturePad = new SignaturePad(canvas_tag, {
            backgroundColor: 'rgb(200,200,200)'
            });
        document.getElementById("user_signature_clear").addEventListener('click', function(){
            document.getElementById('user_signature_img').style.display = "none";
            document.getElementById('user_signature_pad').style.display = "inline-block";
            document.getElementById('user_signature_pad').style.width = "335px";
            document.getElementById('user_signature_pad').style.height = "90px";
            signaturePad.clear();
        });
	  }
	};
		xmlhttp.open('GET', '/sbin/getUSER_OPT.php?KEY='+KEY, true);
		xmlhttp.send();
	//document.getElementById("divMENU").style.width = "0px";
	//document.getElementById("divMENU").style.height = "0px";
    document.getElementById("divMENU").style.transform = "translate(-275px,-275px) scale3d(0,0,0)";
	document.getElementById("divOPT").style.display = "inline-block";
	document.getElementById("divOPT").style.opacity = "1";
}


function makeUSER_SIGNATURE(USER_FULLNAME){
    var tCtx = document.getElementById('user_signature_pad').getContext('2d'),
    imageElem = document.getElementById('user_signature_img');
    var font = '400 40px "Imperial", "Imperial"';
    //const myFont = new FontFace('Sacramento', 'url(/pub/font/Sacramento)');
    document.fonts.load(font)
      .then(function() {
          // Set it before getting the size
          tCtx.font = font
          // this will reset all our context's properties
          tCtx.canvas.width = tCtx.measureText(USER_FULLNAME).width+5;
          // so we need to set it again
          tCtx.font = font;
          // set the color only now
          tCtx.fillStyle = '#000c23';
          tCtx.fillText(USER_FULLNAME, 0, 50);
          imageElem.src = tCtx.canvas.toDataURL();
    });
}

function closeOPT() { //rename to dw3_options_close();
	document.getElementById("divFADE").style.opacity = "0";
	document.getElementById("divFADE").classList.remove('divFADE_IN');
    setTimeout(function () {
			document.getElementById("divFADE").style.display = "none";
			document.getElementById('divOPT').style.display = 'none';
		}, 900);
	
	document.getElementById("divOPT").style.opacity = "0";
}


function updUSER_OPT(){ //rename to dw3_options_update();
	var GRPBOX  = document.getElementById("usLANG_OPT");
	var sLANG  = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("usAPLC_OPT");
	var sAPLC  = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var sUSERNAME  = document.getElementById("usUSER_OPT").value;
	var sPW  = document.getElementById("usPW_OPT").value;
	var sEML1  = document.getElementById("usEML1_OPT").value;
	var sEML2  = document.getElementById("usEML2_OPT").value;
	var sTEL1   = document.getElementById("usTEL1_OPT").value;
	       
	if (sPW == ""){
		document.getElementById("usPW_OPT").style.borderColor = "red";
		document.getElementById("usPW_OPT").focus();
		return;
	} else {
		document.getElementById("usPW_OPT").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	if (sUSERNAME == ""){
		document.getElementById("usUSER_OPT").style.borderColor = "red";
		document.getElementById("usUSER_OPT").focus();
		return;
	} else {
		document.getElementById("usUSER_OPT").style.borderColor = "lightgrey";
	}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  	if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == ""){
				sendUSER_SIGNATURE();
				addNotif("Mise à jour des options terminée");
                closeOPT();
			}else{
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
			}
		}
	};
		xmlhttp.open('GET', '../../sbin/updUSER_OPT.php?KEY='+KEY
										+ '&EML1=' + encodeURIComponent(sEML1)  
										+ '&EML2=' + encodeURIComponent(sEML2)  
										+ '&USERNAME=' + encodeURIComponent(sUSERNAME)   
										+ '&PW=' + encodeURIComponent(sPW) 
										+ '&APLC=' + sAPLC
										+ '&TEL1=' + sTEL1
										+ '&LANG=' + sLANG,    
										true);
		xmlhttp.send();
		document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "0.6";
}

function sendUSER_SIGNATURE(){
    //var signaturePad = document.getElementById("user_signature_pad");
    var signaturePad = document.getElementById("user_signature_pad").getContext('2d');
        var data = signaturePad.canvas.toDataURL();
        fetch('/sbin/uploadUSER_SIGNATURE.php?KEY=' + KEY, { method: "post", body: data })
        .then(function() {
            //window.open("https://infotronix.ca/technicien/dossier/-CopieClient.pdf","_self");
        })
    .catch(err => console.log(err));

}



// Function to make an element/element_HEADER draggable
function dragElement(elmnt) { //rename to dw3_drag_set(elmnt);
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    if (document.getElementById(elmnt.id + "_HEADER")) {
        // if present, the header is where you move the DIV from:
        document.getElementById(elmnt.id + "_HEADER").onmousedown = dragMouseDown;
    } else if (document.getElementById(elmnt.id + "_HEAD")){
        document.getElementById(elmnt.id + "_HEAD").onmousedown = dragMouseDown;
    } else {
        // otherwise, move the DIV from anywhere inside the DIV:
        elmnt.onmousedown = dragMouseDown;
    }
    function dragMouseDown(e) { //rename to dw3_drag_start(e);
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
    }
    function elementDrag(e) { //rename to dw3_drag_move(e);
        e = e || window.event;
        e.preventDefault();
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }
    function closeDragElement() { //rename to dw3_drag_end();
        document.onmouseup = null;
        document.onmousemove = null;
    }
}

function numberToBarCode(number){ //rename to dw3_num_to_barcode(number);
    JsBarcode("#barcode", number, {
    text: number.match(/.{1,4}/g).join("  "),
    width: 2,
    height: 50,
    fontSize: 15,
    });

    var svg = $("#barcode")[0];
    var xml = new XMLSerializer().serializeToString(svg);
    var base64 = 'data:image/svg+xml;base64,' + btoa(xml);
    var img = $("#image")[0];
    img.src = base64;
}

$('#frmUPLOAD_OPT').on('submit',function(e){
  e.preventDefault();
  var fileInput = document.getElementById('fileToOpt');   
  var uploaded_filename = fileInput.files[0].name;
  data = new FormData();
  data.append('fileToOpt', $('#fileToOpt')[0].files[0]);
  data.append('fileNameOpt', document.getElementById("fileNameOpt").value); //filename without .&extention

  $.ajax({
      type : 'post',
      url : '/app/config/upload_opt.php?KEY='+KEY,
      data : data,
      dataTYpe : 'multipart/form-data',
      processData: false,
      contentType: false, 
      beforeSend : function(){
          document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divFADE").style.opacity = "0.6";
      },
      success : function(response){
        closeMSG();
        if (document.getElementById("opt_output")){
            document.getElementById("divAVATAR").style.display = "none";
            document.getElementById("divPHOTO").style.display = "inline-block";
            document.getElementById("opt_output").innerHTML = "<img src='/pub/upload/" + uploaded_filename + "' style='width:100%;height:auto;'>";
        }
        addNotif(response);
      }
  });

});

//TOOLS
function dw3_tool_menu(){
    addTool("<div id='divTOOL_HEADER'><h4><span class='material-icons' style='vertical-align:middle;'>apps</span> Outils</h4></div>"
        + "<button class='gold' onclick='dw3_tool_icon()' style='width:175px;text-align:left;'><span class='material-icons' style='vertical-align:middle;'>add_box</span> Icones</button><br>"
        + "<button class='gold' onclick='dw3_tool_calc()' style='width:175px;text-align:left;'><span class='material-icons' style='vertical-align:middle;'>calculate</span> Calculatrice</button><br>"
        + "<button class='gold' onclick='dw3_tool_conv()' style='width:175px;text-align:left;'><span class='material-icons' style='vertical-align:middle;'>swap_horiz</span> Convertisseurs</button><br>"
        + "<br><button onclick='closeTOOL();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer </button>");
        dragElement(document.getElementById('divTOOL'));
        document.onkeydown = null;
}
//CONVERTISSEURS
function dw3_tool_conv(){
    addTool("<div id='divTOOL_HEADER'><h4><span class='material-icons' style='vertical-align:middle;'>swap_horiz</span> Convertisseurs</h4></div>"
        + "<button class='gold' onclick='dw3_tool_conv1()' style='width:150px;text-align:center;'>Livre <span class='material-icons' style='vertical-align:middle;'>swap_horiz</span> KG</button><br>"
        + "<button class='gold' onclick='dw3_tool_conv2()' style='width:150px;text-align:center;'>Pouces <span class='material-icons' style='vertical-align:middle;'>swap_horiz</span> CM</button><br>"
        + "<br><br><button onclick='dw3_tool_menu();' class='gold'><span class='material-icons' style='vertical-align:middle;'>apps</span> Menu </button><button onclick='closeTOOL();' class='grey'><span class='material-icons' style='vertical-align:middle;'>close</span> Fermer </button>");
        dragElement(document.getElementById('divTOOL'));
}
//L to KG
function dw3_tool_conv1(){
    addTool("<div id='divTOOL_HEADER'><h4>L <span class='material-icons' style='vertical-align:middle;'>swap_horiz</span> KG</h4></div><div style='text-align:right;'>"
        + "Litres: <input oninput='dw3_conv_l(this.value)' type='number' id='dw3_cvl' style='width:150px;text-align:center;font-size:20px'><br>"
        + "Kilogrammes: <input oninput='dw3_conv_kg(this.value)' type='number' id='dw3_cvk' style='width:150px;text-align:center;font-size:20px'>"
        + "</div><br><br><button onclick='dw3_tool_menu();' class='gold'><span class='material-icons' style='vertical-align:middle;'>apps</span> Menu </button><button onclick='closeTOOL();' class='grey'><span class='material-icons' style='vertical-align:middle;'>close</span> Fermer </button>");
        dragElement(document.getElementById('divTOOL'));
}

    function dw3_conv_kg(value) {
        document.getElementById("dw3_cvl").value = value / 0.45359237;
    }
    function dw3_conv_l(value) {
        document.getElementById("dw3_cvk").value = value * 0.45359237;
    }

//po to cm
function dw3_tool_conv2(){
    addTool("<div id='divTOOL_HEADER'><h4>PO <span class='material-icons' style='vertical-align:middle;'>swap_horiz</span> CM</h4></div><div style='text-align:right;'>"
        + "Pouces: <input oninput='dw3_conv_po(this.value)' type='number' id='dw3_cvp' style='width:150px;text-align:center;font-size:20px'><br><small><i><span id='dw3_cvf' style='margin:0px 0px 5px 0px;'>0 pieds et 0 pouces</span></i></small><br>"
        + "Centimètres: <input oninput='dw3_conv_cm(this.value)' type='number' id='dw3_cvc' style='width:150px;text-align:center;font-size:20px'>"
        + "</div><br><br><button onclick='dw3_tool_menu();' class='gold'><span class='material-icons' style='vertical-align:middle;'>apps</span> Menu </button><button onclick='closeTOOL();' class='grey'><span class='material-icons' style='vertical-align:middle;'>close</span> Fermer </button>");
        dragElement(document.getElementById('divTOOL'));
}

    function dw3_conv_po(value) {
        var formated = parseFloat(value * 2.54).toFixed(2);
        document.getElementById("dw3_cvc").value = formated;

        var pieds = Math.floor(value / 12);
        var pouces = Math.floor(value - (Math.floor(value / 12) * 12));
        //var quarts = Math.floor(((value - Math.floor(value - (Math.floor(value / 12) * 12)))*100)/25);
        var quarts = Math.floor(((value - Math.floor(value))*100)/3.125);
        if (quarts != 0){
            if (quarts == 2){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 1/16"  ;
            } else if (quarts == 4){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 1/8"  ;
            } else if (quarts == 6){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 3/16"  ;
            } else if (quarts == 8){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 1/4"  ;
            } else if (quarts == 10){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 5/16"  ;
            } else if (quarts == 12){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 3/8"  ;
            } else if (quarts == 14){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 7/16"  ;
            } else if (quarts == 16){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 1/2"  ;
            } else if (quarts == 18){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 9/16"  ;
            } else if (quarts == 20){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 5/8"  ;
            } else if (quarts == 22){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 11/16"  ;
            } else if (quarts == 24){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 3/4"  ;
            } else if (quarts == 26){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 13/16"  ;
            } else if (quarts == 28){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 7/8"  ;
            } else if (quarts == 30){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 15/16"  ;
            } else {
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et " + quarts + "/32"  ;
            }
        } else {
            document.getElementById("dw3_cvf").innerHTML = pieds + " pieds et " + pouces + " pouces" ;
        }
    }
    function dw3_conv_cm(value) {
        var formated = parseFloat(value / 2.54).toFixed(2);
        document.getElementById("dw3_cvp").value = formated;

        var pieds = Math.floor((value / 2.54) / 12);
        var pouces = Math.floor((value / 2.54) - (pieds * 12));
        //var quarts = Math.floor((((value / 2.54) - Math.floor((value / 2.54) - (Math.floor((value / 2.54) / 12) * 12)))*100)/25);
        var quarts = Math.floor((((value / 2.54) - Math.floor((value / 2.54)))*100)/3.125);        
        if (quarts != 0){
if (quarts == 2){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 1/16"  ;
            } else if (quarts == 4){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 1/8"  ;
            } else if (quarts == 6){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 3/16"  ;
            } else if (quarts == 8){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 1/4"  ;
            } else if (quarts == 10){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 5/16"  ;
            } else if (quarts == 12){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 3/8"  ;
            } else if (quarts == 14){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 7/16"  ;
            } else if (quarts == 16){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 1/2"  ;
            } else if (quarts == 18){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 9/16"  ;
            } else if (quarts == 20){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 5/8"  ;
            } else if (quarts == 22){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 11/16"  ;
            } else if (quarts == 24){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 3/4"  ;
            } else if (quarts == 26){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 13/16"  ;
            } else if (quarts == 28){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 7/8"  ;
            } else if (quarts == 30){
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et 15/16"  ;
            } else {
                document.getElementById("dw3_cvf").innerHTML = pieds + " pieds, " + pouces  + " pouces et " + quarts + "/32"  ;
            }
        } else {
            document.getElementById("dw3_cvf").innerHTML = pieds + " pieds et " + pouces + " pouces" ;
        }
    }

//CALCULATRICE
function dw3_tool_calc(){
	addTool("<div id='divTOOL_HEADER'><h4><span class='material-icons' style='vertical-align:middle;'>calculate</span> Calculatrice</h4></div>"
    + "<button class='grey' style='padding:10px;font-size:20px;width:50px;' onclick=\"memDisplayClear()\">MC</button>"
    + "<button class='grey' style='padding:10px;font-size:20px;width:50px;' onclick=\"memDisplaySet()\">M+</button>"
    + "<button class='grey' style='padding:10px;font-size:20px;width:50px;' onclick=\"memDisplayPut()\">M></button>"
    + "<i><span id='mem_display' style='margin-top:-3px;font-size:12px;color:lightgrey;text-align:center;width:95%;max-width:95%;'>"+displayMem+"</span></i>"
    + "<br>"
    + "<input type='text' readonly id='display' style='width:220px;text-align:center;font-size:16px' value='"+displayValue+"'>"
    + "<br>"
    + "<button class='grey' style='padding:10px;font-size:20px;width:50px;' onclick=\"clearDisplay()\">C</button>"
    + "<button class='grey' style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('(')\">(</button>"
    + "<button class='grey' style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay(')')\">)</button>"
    + "<button class='blue' style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('/')\">&divide;</button>"
    + "<br>"
    + "<button style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('1')\">1</button>"
    + "<button style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('2')\">2</button>"
    + "<button style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('3')\">3</button>"
    + "<button class='blue' style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('+')\">+</button>"
    + "<br>"
    + "<button style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('4')\">4</button>"
    + "<button style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('5')\">5</button>"
    + "<button style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('6')\">6</button>"
    + "<button class='blue' style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('-')\">-</button>"
    + "<br>"
    + "<button style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('7')\">7</button>"
    + "<button style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('8')\">8</button>"
    + "<button style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('9')\">9</button>"
    + "<button class='blue' style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('*')\">x</button>"
    + "<br>"
    + "<button class='grey' style='padding:10px;font-size:20px;width:50px;' onclick=\"calculateTX()\">+Tx</button>"
    + "<button style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('0')\">0</button>"
    + "<button class='grey' style='padding:10px;font-size:20px;width:50px;' onclick=\"appendToDisplay('.')\">.</button>"
    + "<button class='green' style='padding:10px;font-size:20px;width:50px;' onclick=\"calculateResult()\">=</button>"
    + "<br><br><button onclick='dw3_tool_menu();' class='gold'><span class='material-icons' style='vertical-align:middle;'>apps</span> Menu </button><button onclick='closeTOOL();' class='grey'><span class='material-icons' style='vertical-align:middle;'>close</span> Fermer </button>");

    document.onkeydown = function(event) {
        //console.log("Key pressed:", event.key);
        if (event.key == "1" || event.key == "2" || event.key == "3" || event.key == "4" || event.key == "5" || event.key == "6" || event.key == "7" || event.key == "8" || event.key == "9" || event.key == "0" || event.key == "*" || event.key == "-" || event.key == "+" || event.key == "/"){
            appendToDisplay(event.key);
        }
        if (event.key == "Enter"){
            calculateResult();
        }
        if (event.key == "Backspace"){
            clearDisplay();
        }
    };
    dragElement(document.getElementById('divTOOL'));
}
let displayValue = "";
let displayMem = "";

    function memDisplayClear() {
        displayMem = "";
        document.getElementById("mem_display").innerText = "";
    }
    function memDisplaySet() {
        if (document.getElementById("display").value.trim() != "") {
            displayMem = document.getElementById("display").value.trim();
            document.getElementById("mem_display").innerText = "M: "+displayMem;
            document.getElementById("display").value = "";
            displayValue = "";
        }
    }
    function memDisplayPut() {
        displayValue += displayMem;
        document.getElementById("display").value = displayValue;
    }
    function appendToDisplay(value) {
      displayValue += value;
      document.getElementById("display").value = displayValue;
    }

    function clearDisplay() {
      displayValue = "";
      document.getElementById("display").value = "";
    }

    function eraseDisplay() {
        displayValue = displayValue.slice(0, -1);
        //displayValue.substring(0, displayValue.length - 1)
      document.getElementById("display").value = displayValue;
    }

    function truncateToFifteenDecimals(num) {
        const numString = num.toString();
        const decimalIndex = numString.indexOf('.');
        if (decimalIndex === -1) {
            // If no decimal point, return the original number (or string)
            return numString;
        }
        // Find the index where the 15th decimal place ends
        const endIndex = decimalIndex + 1 + 15;
        if (numString.length <= endIndex) {
        // If the number has 15 or fewer decimal places, return it as is
        return numString;
        }
        // Truncate the string at the 15th decimal place
        return numString.substring(0, endIndex);
    }

    function calculateTX() {
        displayValue = eval("(" + displayValue + ")*1.14975");
        displayValue = displayValue.toFixed(2);
        document.getElementById("display").value = displayValue;
    }
    function calculateResult() {
      try {
        const result = eval(displayValue);
        displayValue = parseFloat(truncateToFifteenDecimals(result.toString()));
        document.getElementById("display").value = displayValue;
        /* let codeString = "return (" + displayValue + ");";
        let dynamicFunction = new Function(codeString);
        displayValue = dynamicFunction(); */
        //document.getElementById("display").value = displayValue;
      } catch (error) {
        document.getElementById("display").value = error.message;
        //document.getElementById("display").value = "Erreur";
        displayValue = "";
      }
    }
//ICONS
function dw3_tool_icon(){
	addTool("<div id='divTOOL_HEADER'><h4><span class='material-icons' style='vertical-align:middle;'>add_box</span> Icons</h4></div><div style='max-width:600px;'>"
		  +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#33;</span>"
		  +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#35;</span>"
		  +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#36;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#40;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#41;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#42;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#43;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#45;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#46;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#47;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#48;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#49;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#51;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#52;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#53;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#54;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#55;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#56;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#57;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#58;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#59;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#60;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#61;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#62;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#63;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#64;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#65;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#66;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#67;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#68;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#69;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#70;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#71;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#72;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#73;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#74;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#75;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#76;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#77;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#78;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#79;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#80;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#81;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#82;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#83;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#84;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#85;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#86;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#87;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#88;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#89;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#90;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#91;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#92;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#93;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#94;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#95;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#96;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#97;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#98;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#99;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#101;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#102;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#103;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#104;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#105;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#106;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#107;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#108;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#109;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#110;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#111;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#112;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#113;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#114;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#115;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#116;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#117;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#118;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#119;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#120;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#121;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#122;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#123;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#124;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#125;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#126;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#127;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#161;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#162;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#163;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#164;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#165;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#166;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#167;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#168;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#169;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#170;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#171;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#172;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#173;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#174;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#175;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#176;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#177;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#178;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#179;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#180;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#181;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#182;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#183;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#184;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#185;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#194;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#195;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#196;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#197;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#198;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#199;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#201;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#202;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#203;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#204;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#205;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#206;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#207;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#208;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#209;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#210;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#211;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#212;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#213;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#214;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#215;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#216;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#217;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#218;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#219;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#220;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#221;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#222;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#223;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#224;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#228;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#229;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#230;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#231;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#232;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#233;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#234;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#235;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#236;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#237;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#238;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#239;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#253;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#254;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#255;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#256;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#257;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#258;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#259;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#260;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#261;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#262;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#263;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#264;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#265;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#266;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#267;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#268;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#269;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#270;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#271;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#272;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#273;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#274;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#275;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#276;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#277;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#278;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#279;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#280;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#281;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#282;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#283;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#304;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#305;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#306;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#307;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#308;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#309;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#310;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#311;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#312;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#313;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#314;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#315;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#316;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#317;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#318;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#319;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#320;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#321;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#322;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#323;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#324;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#325;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#326;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#327;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#328;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#329;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#342;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#343;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#380;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#381;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#382;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#383;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#384;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#385;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#386;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#387;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#388;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#389;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#390;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#391;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#392;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#393;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#394;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#395;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#396;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#397;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#398;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#399;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#400;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#418;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#419;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#420;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#421;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#422;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#423;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#424;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#425;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#426;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#427;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#428;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#429;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#430;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#431;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick='dw3_tool_icon_cp(this.innerText);closeMSG();'>&#432;</span>"
		  +"</div><br><br><button onclick='dw3_tool_menu();' class='gold'><span class='material-icons' style='vertical-align:middle;'>apps</span> Menu </button><button onclick='closeTOOL();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer </button>");
          dragElement(document.getElementById('divTOOL'));
}

function dw3_tool_icon_cp(text){
    navigator.clipboard.writeText("<span class='dw3_font'>"+text+"</span>");
    addNotif("Icône copié.");
}
