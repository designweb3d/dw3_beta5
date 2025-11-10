<!-- 
 


//a effacer



-->
















<script>
const dw3_section = JSON.parse('[<?php echo $dw3_section; ?>]');
var timelines ;
var CounterVal1 = "<?php echo $COUNTER1_VAL??0; ?>";
var CounterVal2 = "<?php echo $COUNTER2_VAL??0; ?>";
var CounterVal3 = "<?php echo $COUNTER3_VAL??0; ?>";
var CounterVisitors = "<?php echo $INDEX_VISITED??0; ?>";
var CounterReady = true;

function isInViewport(element,y_margin=0) {
    const rect = element.getBoundingClientRect();
    return (
        (rect.top + y_margin >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)) ||
        (rect.bottom >= 0 &&
        rect.right >= 0 &&
        rect.top - y_margin <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.left <= (window.innerWidth || document.documentElement.clientWidth))
    );
}


//COUNTERS
function startCounterAnim() {
    if (CounterReady == false){return false;}
    CounterReady = false;
    if (typeof(document.getElementById('txtCounter3')) != 'undefined' && document.getElementById('txtCounter3') != null){
        let counterText1 = document.getElementById('txtCounter1');
        let counterText2 = document.getElementById('txtCounter2');
        let counterText3 = document.getElementById('txtCounter3');
        animateCounter(counterText1, 0, CounterVal1, 3000);
        animateCounter(counterText2, 0, CounterVal2, 3000);
        animateCounter(counterText3, 0, CounterVal3, 3000);
    } else if (typeof(document.getElementById('txtCounter1')) != 'undefined' && document.getElementById('txtCounter1') != null){
      let counterText1 = document.getElementById('txtCounter1');
      animateCounter(counterText1, 0, CounterVisitors, 3000);
    }
}
function animateCounter(obj, initVal, lastVal, duration) {
    let startTime = null;

    //get the current timestamp and assign it to the currentTime variable
    let currentTime = Date.now();

    //pass the current timestamp to the step function
    const step = (currentTime ) => {
        //if the start time is null, assign the current time to startTime
        if (!startTime) {
            startTime = currentTime ;
        }

        //calculate the value to be used in calculating the number to be displayed
        const progress = Math.min((currentTime - startTime)/ duration, 1);

        //calculate what to be displayed using the value gotten above
        obj.innerHTML = Math.floor(progress * (lastVal - initVal) + initVal);

        //checking to make sure the counter does not exceed the last value (lastVal)
        if (progress < 1) {
            window.requestAnimationFrame(step);
        } else {
            window.cancelAnimationFrame(window.requestAnimationFrame(step));
            CounterReady = true;
        }
    };
    //start animating
    window.requestAnimationFrame(step);
}


// Gallery 2
function dw3_gal2_show(that){
  var scroll_top = document.getElementById("dw3_scroll_top");
  var modal = document.getElementById("gal2_modal");
  var modalImg = document.getElementById("gal2_model_img");
  var captionText = document.getElementById("gal2_caption");
  scroll_top.style.display = "none";
  document.body.style.overflowY = 'hidden';
  modal.style.display = "block";
  modalImg.src = that.src;
  captionText.innerHTML = that.alt;
}

function dw3_gal2_close(){
  var scroll_top = document.getElementById("dw3_scroll_top");
  scroll_top.style.display = "inline-block";
  document.body.style.overflowY = 'auto';
  var modal = document.getElementById("gal2_modal");
  modal.style.display = "none";
}

// Gallery 3
/* function dw3_gal3_show(images_array,img_tag_id,title){
    //dw3_gal3_rotation = 0;
    dw3_gal3_ready = true;
      dw3_gal3_images_array = images_array;
      dw3_gal3_current_img_id = img_tag_id;
      //dw3_gal3_titles_array = document.getElementById(img_tag_id).alt;
    var scroll_top = document.getElementById("dw3_scroll_top");
    var modal = document.getElementById("gal3_modal");
    var modalImg = document.getElementById("gal3_model_img");
    var captionText = document.getElementById("gal3_caption");
    scroll_top.style.display = "none";
    document.body.style.overflowY = 'hidden';
    modal.style.display = "block";
    modalImg.src = images_array[dw3_gal3_current_index];
    captionText.innerHTML = "<h2>"+title+"</h2>";
  
      modal.addEventListener('touchstart', e => {
          dw3_gal3_touchstartX = e.changedTouches[0].screenX;
      })
  
      modal.addEventListener('touchend', e => {
        //alert("end");
          dw3_gal3_touchendX = e.changedTouches[0].screenX;
          if (dw3_gal3_ready == true){
            dw3_gal3_swipe();
            setTimeout(() => {
              dw3_gal3_ready = true;
            }, 1000);
          }
      })
  }
  let dw3_gal3_ready = true;
  let dw3_gal3_rotation = 0;
  let dw3_gal3_touchstartX = 0;
  let dw3_gal3_touchendX = 0;
  let dw3_gal3_images_array = [];
  let dw3_gal3_current_index = 0;
  let dw3_gal3_current_img_id = "";
  function dw3_gal3_swipe() {
    if (dw3_gal3_touchendX < dw3_gal3_touchstartX){
      //alert('swiped left!');
      dw3_gal3_back();
      dw3_gal3_ready = false;
    }
    if (dw3_gal3_touchendX > dw3_gal3_touchstartX) {
      //alert('swiped right!');
      dw3_gal3_next();
      dw3_gal3_ready = false;
    }
  }
  function dw3_change_image3(filename,element,current_index) {
      //dw3_gal3_current_index = current_index;
      document.getElementById(element).src=filename;
      document.getElementById(element).alt=current_index;
      //var modalImg = document.getElementById("gal3_model_img");
      //modalImg.src=filename;
  }
  function dw3_gal3_next(){
    if (dw3_gal3_ready == false){return false;}
    var modalImg = document.getElementById("gal3_model_img");
      dw3_gal3_rotation = dw3_gal3_rotation + 360;
      //modalImg.style.transformOrigin = "center right";
      modalImg.style.transform = "rotateY("+dw3_gal3_rotation+"deg)";
      if (dw3_gal3_current_index == dw3_gal3_images_array.length-1){
          dw3_gal3_current_index = 0;
          setTimeout(() => {
            //dw3_change_image3(dw3_gal3_images_array[dw3_gal3_current_index],dw3_gal3_current_img_id,dw3_gal3_current_index);
            modalImg.src=dw3_gal3_images_array[dw3_gal3_current_index];
          }, 500);
      } else {
          dw3_gal3_current_index++;
          setTimeout(() => {
            //dw3_change_image3(dw3_gal3_images_array[dw3_gal3_current_index],dw3_gal3_current_img_id,dw3_gal3_current_index);
            modalImg.src=dw3_gal3_images_array[dw3_gal3_current_index];
          }, 500);
      }
  }
  function dw3_gal3_back(){
    if (dw3_gal3_ready == false){return false;}
    var modalImg = document.getElementById("gal3_model_img");
      dw3_gal3_rotation = dw3_gal3_rotation - 360;
      //modalImg.style.transformOrigin = "center left";
      modalImg.style.transform = "rotateY("+dw3_gal3_rotation+"deg)";
      if (dw3_gal3_current_index == 0){
          dw3_gal3_current_index = dw3_gal3_images_array.length-1;
          setTimeout(() => {
            //dw3_change_image3(dw3_gal3_images_array[dw3_gal3_current_index],dw3_gal3_current_img_id,dw3_gal3_current_index);
            modalImg.src=dw3_gal3_images_array[dw3_gal3_current_index];
          }, 500);
      } else {
          dw3_gal3_current_index = dw3_gal3_current_index -1;
          setTimeout(() => {
            //dw3_change_image3(dw3_gal3_images_array[dw3_gal3_current_index],dw3_gal3_current_img_id,dw3_gal3_current_index);
            modalImg.src=dw3_gal3_images_array[dw3_gal3_current_index];
          }, 500);
      }
  }
  function dw3_gal3_close(){
    var scroll_top = document.getElementById("dw3_scroll_top");
    scroll_top.style.display = "inline-block";
    document.body.style.overflowY = 'auto';
    var modal = document.getElementById("gal3_modal");
    modal.style.display = "none";
    dw3_gal3_rotation = 0;
    var modalImg = document.getElementById("gal3_model_img");
    modalImg.style.transform = "rotateY("+dw3_gal3_rotation+"deg)";
  }
  
//SECTION SLIDESHOW3
function dw3_card_to_back(cardID){
    document.getElementById(cardID).classList.add("dw3_card_flip");
}
function dw3_card_to_front(cardID){
    document.getElementById(cardID).classList.remove("dw3_card_flip");
}
 */
//SECTION TABS 2,3,4
function dw3_change_tab(evt, tabName, tabClass, btnClass) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName(tabClass);
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName(btnClass);
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "inherit";
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.style.backgroundColor = "#ccc";
}

//SECTION AUDIO
function InitAudio (current_id) {

    // The number of bars that should be displayed
    const NBR_OF_BARS = 36;

    // Get the audio element tag
    const audio = document.getElementById("audio_control_"+current_id);
    audio.style.display = "inline-block";
    document.getElementById("audio_start_"+current_id).style.display = "none";
    // Create an audio context
    const ctx = new AudioContext();

    // Create an audio source
    const audioSource = ctx.createMediaElementSource(audio);

    // Create an audio analyzer
    const analayzer = ctx.createAnalyser();

    // Connect the source, to the analyzer, and then back the the context's destination
    audioSource.connect(analayzer);
    audioSource.connect(ctx.destination);

    // Print the analyze frequencies
    const frequencyData = new Uint8Array(analayzer.frequencyBinCount);
    analayzer.getByteFrequencyData(frequencyData);
    //console.log("frequencyData", frequencyData);

    // Get the visualizer container
    const visualizerContainer = document.getElementById("audio_container_"+current_id);

    // Create a set of pre-defined bars
    for( let i = 0; i < NBR_OF_BARS; i++ ) {

        const bar = document.createElement("DIV");
        bar.setAttribute("id", "bar_"+current_id+"_" + i);
        bar.style.display = "inline-block";
        bar.style.margin = "0 2px";
        bar.style.width = "1.4vw";
        bar.style.backgroundColor = "#FFF";
        bar.style.mixBlendMode = "invert(80%)";
        bar.style.verticalAlign = "top";
        visualizerContainer.appendChild(bar);

    }

    // This function has the task to adjust the bar heights according to the frequency data
    function renderFrame() {

        // Update our frequency data array with the latest frequency data
        analayzer.getByteFrequencyData(frequencyData);

        for( let i = 0; i < NBR_OF_BARS; i++ ) {

            // Since the frequency data array is 1024 in length, we don't want to fetch
            // the first NBR_OF_BARS of values, but try and grab frequencies over the whole spectrum
            const index = (i + 10) * 2;
            // fd is a frequency value between 0 and 255
            const fd = frequencyData[index];

            // Fetch the bar DIV element
            const bar = document.querySelector("#bar_"+current_id + "_" + i);
            if( !bar ) {
                continue;
            }

            // If fd is undefined, default to 0, then make sure fd is at least 4
            // This will make make a quiet frequency at least 4px high for visual effects
            const barHeight = Math.max(4, fd || 0);
            bar.style.height = barHeight + "px";

        }

        // At the next animation frame, call ourselves
        window.requestAnimationFrame(renderFrame);

        }

    renderFrame();

    audio.volume = 0.10;
    audio.play();

}

//SECTION AFFILIATE
if (document.getElementById('slide_textA')){
    window.addEventListener('resize', function(event) {
        slidesContainerA.scrollLeft = 0;
        current_slideA = 1;
        document.getElementById('slide_textA').innerHTML = document.getElementById('slideAnum'+current_slideA).innerHTML;
    });
    var current_slideA = 1; 
    document.getElementById('slide_textA').innerHTML = document.getElementById('slideAnum'+current_slideA).innerHTML;
    const slidesContainerA = document.getElementById("slides-container-affiliate");
    const slideA = slidesContainerA.querySelector(".slideA");
    const prevButtonA = document.getElementById("slide-arrow-prevA");
    const nextButtonA = document.getElementById("slide-arrow-nextA");
    const slideA_num = document.getElementById("slideA_num").value;

    nextButtonA.addEventListener("click", () => {
    const slideWidthA = slideA.clientWidth;
        if ((slidesContainerA.scrollLeft+slideWidthA+10)>=slidesContainerA.scrollWidth){
            slidesContainerA.scrollLeft = 0;
            current_slideA = 1;
        }else {
            slidesContainerA.scrollLeft += slideWidthA;
            current_slideA += 1;
            //current_slideA = 3-Math.floor(slidesContainerA.scrollWidth/slidesContainerA.scrollLeft);
        }
        document.getElementById('slide_textA').innerHTML = document.getElementById('slideAnum'+current_slideA).innerHTML;
    });

    prevButtonA.addEventListener("click", () => {
    const slideWidthA = slideA.clientWidth;
    if (slidesContainerA.scrollLeft==0){
            slidesContainerA.scrollLeft = slidesContainerA.scrollWidth-slideWidthA;
            current_slideA = slideA_num;
        }else {
            slidesContainerA.scrollLeft -= slideWidthA;
            //current_slideA = 3-Math.floor(slidesContainerA.scrollWidth/slidesContainerA.scrollLeft);
            current_slideA -= 1;
        }
        document.getElementById('slide_textA').innerHTML = document.getElementById('slideAnum'+current_slideA).innerHTML;
    });
}

//SECTION CALENDRIER
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
//SECTION SLIDESHOW
if (document.getElementById("slides-container")){
    window.addEventListener('resize', function(event) {
        var newWidth = window.innerWidth;
        if (newWidth !== prevWidth) {
            prevWidth = newWidth;
            if (document.getElementById('slide_dot'+current_slide)){
                document.getElementById('slide_dot'+current_slide).style.background = "rgba(155,155,155,0.5)";
            }
            slidesContainer.scrollLeft = 0;
            current_slide = 1;
            document.getElementById('slide_dot'+current_slide).style.background = "rgba(255,255,255,1)";
        }
    });
    var prevWidth = window.innerWidth;
    var Slide1Interval = setInterval(autoSlide, 4000);

    var current_slide = 1; 
    const slidesContainer = document.getElementById("slides-container");
    const slide = document.querySelector(".slide");
    const prevButton = document.getElementById("slide-arrow-prev");
    const nextButton = document.getElementById("slide-arrow-next");
    const slide_num = document.getElementById("slide1_num").value;

    nextButton.addEventListener("click", () => {
        clearInterval(Slide1Interval);
        const slideWidth = slide.clientWidth;
        if (document.getElementById('slide_dot'+current_slide)){
                document.getElementById('slide_dot'+current_slide).style.background = "rgba(155,155,155,0.5)";
        }
        if ((slidesContainer.scrollLeft+slideWidth)>=slidesContainer.scrollWidth){
            slidesContainer.scrollLeft = 0;
            current_slide = 1;
        }else {
            //slidesContainer.scrollLeft += slideWidth;
            slidesContainer.scrollLeft = slideWidth*current_slide;
            current_slide += 1;
            //current_slide = 3-Math.floor(slidesContainer.scrollWidth/slidesContainer.scrollLeft);
        }
        if (document.getElementById('slide-text'+current_slide)){
            document.getElementById('slide_text').innerHTML = document.getElementById('slide-text'+current_slide).innerHTML;
            document.getElementById('slide_dot'+current_slide).style.background = "rgba(255,255,255,1)";
        }
        Slide1Interval = setInterval(autoSlide, 4000);
    });

    prevButton.addEventListener("click", () => {
        clearInterval(Slide1Interval);
        const slideWidth = slide.clientWidth;
        if (document.getElementById('slide_dot'+current_slide)){
            document.getElementById('slide_dot'+current_slide).style.background = "rgba(155,155,155,0.5)";
        }
        if (slidesContainer.scrollLeft==0){
            slidesContainer.scrollLeft = slidesContainer.scrollWidth-slideWidth;
            current_slide = slide_num;
        }else {
            //slidesContainer.scrollLeft -= slideWidth;
            current_slide -= 1;
            slidesContainer.scrollLeft = slideWidth*(current_slide-1);
            //current_slide = 3-Math.floor(slidesContainer.scrollWidth/slidesContainer.scrollLeft);
    
        }
        if (document.getElementById('slide-text'+current_slide)){
            document.getElementById('slide_text').innerHTML = document.getElementById('slide-text'+current_slide).innerHTML;
            document.getElementById('slide_dot'+current_slide).style.background = "rgba(255,255,255,1)";
        }
        Slide1Interval = setInterval(autoSlide, 4000);
    });

    function changeSlideTo(slide_num){
        clearInterval(Slide1Interval);
        document.getElementById('slide_dot'+current_slide).style.background = "rgba(155,155,155,0.5)";
        const slideWidth = slide.clientWidth;
        slidesContainer.scrollLeft = slideWidth*(slide_num-1);
        current_slide = slide_num;
        document.getElementById('slide_dot'+current_slide).style.background = "rgba(255,255,255,1)";
        Slide1Interval = setInterval(autoSlide, 8000);
    }

    function autoSlide(){
        nextButton.click(); 
    }

    let touchstartX = 0
    let touchendX = 0
        
    function checkDirection() {
    if (touchendX < touchstartX) nextButton.click()
    if (touchendX > touchstartX) prevButton.click()
    }

    document.addEventListener('touchstart', e => {
    touchstartX = e.changedTouches[0].screenX
    })

    document.addEventListener('touchend', e => {
    touchendX = e.changedTouches[0].screenX
    checkDirection()
    })
}
</script>