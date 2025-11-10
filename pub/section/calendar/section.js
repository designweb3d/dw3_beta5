//calendar
function getEVENT(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		var jsonEVENT = JSON.parse(this.responseText);
        //document.getElementById("divDATE_OUTPUT").innerHTML = "<h3><span style='color:darkred;'>Date non-défini</span></h3>";
        //document.getElementById("divDISPO").innerHTML = "<div style='display:inline-block;width:auto;text-align:center;font-weight:bold;background-image: linear-gradient(180deg, rgba(255,255,255,0), rgba(155,200,255,0.3),rgba(255,255,255,0));padding:10px;font-size:23px;'>Veuillez choisir un jour de disponible.</div>";
        //currentDay=0;
        if (jsonEVENT[0].href !=""){
            if(LANG=="FR"){
                dw3_msg_open("<h3>"+jsonEVENT[0].name_fr+"</h3>"+jsonEVENT[0].description + "<br style='margin:0;'><a href='"+jsonEVENT[0].href+"' target='_blank'><button><span style='font-size:1.3em;' class='material-icons'>help_center</span> Plus d'informations</button></a>"
                    +" <button onclick=\"dw3_msg_close();\"><span style='font-size:1.3em;' class='material-icons'>disabled_by_default</span> Fermer</button>");
            }else{
                dw3_msg_open("<h3>"+jsonEVENT[0].name_en+"</h3>"+jsonEVENT[0].description_en + "<br style='margin:0;'><a href='"+jsonEVENT[0].href+"' target='_blank'><button><span style='font-size:1.3em;' class='material-icons'>help_center</span> More informations</button></a>"
                    +" <button onclick=\"dw3_msg_close();\"><span style='font-size:1.3em;' class='material-icons'>disabled_by_default</span> Close</button>");
            }
        } else {
            if(LANG=="FR"){
                dw3_msg_open("<h3>"+jsonEVENT[0].name_fr+"</h3>"+jsonEVENT[0].description + "<br style='margin:0;'> <button onclick=\"dw3_msg_close();\"><span style='font-size:1.3em;' class='material-icons'>disabled_by_default</span> Fermer</button>");
            }else{
                dw3_msg_open("<h3>"+jsonEVENT[0].name_en+"</h3>"+jsonEVENT[0].description_en + "<br style='margin:0;'> <button onclick=\"dw3_msg_close();\"><span style='font-size:1.3em;' class='material-icons'>disabled_by_default</span> Close</button>");
            }
            }
        //getDISPO();
	  }
	};
		xmlhttp.open('GET', '/pub/page/getEVENT.php?ID=' + ID, true);
		xmlhttp.send();	
}

//function getCDS(){
	var cds = document.getElementsByClassName("count_down");
	for (var i = 0; i < cds.length; i++) {
		var countDownDate = new Date(cds[i].innerHTML).getTime();
		var countDownID = cds[i].id;
		setInterval(setCD, 1000,countDownID,countDownDate);
	}
//}
function setCD(id,cdate){
			// Get today's date and time
			var now = new Date().getTime();
		
			// Find the distance between now and the count down date
			var distance = cdate - now;
		
			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
			// Display the result in the element with id="demo"
			document.getElementById(id).innerHTML = "<span style='font-size:1em;' class='material-icons'>alarm</span> <b>" + days + "</b>j <b>" + hours + "</b>h <b>" + minutes + "</b>m <b>" + seconds + "</b>s ";
		
			// If the count down is finished, write some text
			if (distance < 0) {
			//clearInterval(x);
			document.getElementById(id).innerHTML = "C'est parti!";
			}
}