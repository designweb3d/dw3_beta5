<script>
const KEY = '<?php echo $KEY; ?>';
var COOKIE_OK = '<?php if(isset($_COOKIE["COOKIES"])) { echo $_COOKIE["COOKIES"]; }  else {echo "no";} ?>';
var POPUP_OK = '<?php if(isset($_COOKIE["POPUP"])) { echo $_COOKIE["POPUP"]; }  else {echo "no";} ?>';
var NEWS_OK = '<?php if(isset($_COOKIE["NEWS"])) { echo $_COOKIE["NEWS"]; }  else {echo "ND";} ?>';
var USER_LANG = '<?php if(isset($_COOKIE["LANG"])) { echo $_COOKIE["LANG"]; } else if ($USER_LANG != "") { echo $USER_LANG; } else { echo $INDEX_LANG; } ?>';
const USER_ID = "<?php echo $USER_ID; ?>";
const USER_NAME = "<?php echo $USER_NAME; ?>"; 
const USER_TYPE = "<?php echo $USER_TYPE??"nd"; ?>"; 
var cookie_msg = "<?php if($USER_LANG == "FR"){echo $CIE_COOKIE_MSG;}else{echo $CIE_COOKIE_MSG_EN;} ?>";
var popup_msg = "<?php if($USER_LANG == "FR"){echo $INDEX_POPUP_FR;}else{echo $INDEX_POPUP_EN;} ?>";
var CART = <?php if(isset($_COOKIE["CART"])) { echo $_COOKIE["CART"]; }  else {echo "[]";} ?>;
var INDEX_HEADER = "<?php echo $PAGE_HEADER; ?>";
var INDEX_NEWS = "<?php echo $INDEX_NEWS; ?>";
var INDEX_BLOCK_DEBUG = "<?php echo $INDEX_BLOCK_DEBUG; ?>";
const dw3_section = JSON.parse('[<?php echo $dw3_section; ?>]');

var dw3_sticky = document.getElementById("dw3_head").offsetTop;
var bREADY = false;

reset_menu_top();
 
window.addEventListener('resize', () => {
    setTimeout(setSubMenusPos, 1000);
});


// PWA INSTALL
// Register Service Worker
/* if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
    .then((registration) => {
        console.log('✅ Service Worker registered successfully:', registration.scope);
    })
    .catch((error) => {
        console.log('❌ Service Worker registration failed:', error);
    });
} */
//let deferredPrompt;
// Listen for the beforeinstallprompt event
/* window.addEventListener('beforeinstallprompt', (e) => {
    console.log('👍', 'beforeinstallprompt event fired');
    // Prevent the mini-infobar from appearing on mobile
    e.preventDefault();
    // Stash the event so it can be triggered later
    deferredPrompt = e;
    window.deferredPrompt = e; // Also set on window object
    // Update UI to show install button if needed
    if (document.getElementById('btn_install_pwa')) {
        document.getElementById('btn_install_pwa').style.display = 'inline-block';
    }
}); */
//console.log('👍', 'page.js loading..');

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});


if (INDEX_HEADER == "/pub/section/header13.php" || INDEX_HEADER == "/pub/section/header6.php"){
    document.body.style.padding = "70px 0px 0px 0px";
}
if (INDEX_HEADER == "/pub/section/header3.php" || INDEX_HEADER == "/pub/section/header16.php" || INDEX_HEADER == "/pub/section/header20.php"){
    document.getElementById("dw3_h3_eml1").style.opacity = "1";
    document.getElementById("dw3_h3_tel1").style.opacity = "1";
    document.getElementById("dw3_head_row").style.height = "100px";
    document.getElementById("imgLOGO").style.height = "100px";
    document.getElementById("dw3_head").style.height = "100px";
    document.getElementById("dw3_head").style.maxHeight = "100px";
    //document.getElementById("dw3_menu_fade").style.top = "100px";
}
//tout les headers sauf le 6 sont sticky
if (INDEX_HEADER == "/pub/section/header6.php" || INDEX_HEADER == "/pub/section/header21.php" || INDEX_HEADER == "/pub/section/header22.php" || INDEX_HEADER == "/pub/section/header23.php"){
    //document.getElementById("dw3_head").style.position = "relative";
} else {
    document.getElementById("dw3_head").classList.add("sticky");
}

if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
    window.scrollTo({top: 0, behavior: 'smooth'});
    checkSectionsView();
}

//load
//function dw3_html_load(){
    if (USER_NAME !=""){dw3_avatar_change(USER_NAME,'dw3_menu_avatar');}
    if (USER_LANG == ""){
        var language = window.navigator.userLanguage || window.navigator.language;
        if (language.toLowerCase().indexOf("fr") >= 0){
            USER_LANG = "FR";
        } else {
            USER_LANG = "EN";
        }
    }

    //window.scrollTo({top: 0, behavior: 'smooth'});
    //dw3_body_load();
    
    if (NEWS_OK != "OK" && NEWS_OK != "NO" && INDEX_NEWS !="" && INDEX_NEWS !="0" && INDEX_NEWS !="false"){ 
        if(USER_LANG == "FR"){ 
            setTimeout(function(){ 
                dw3_msg_open("<div style='font-size:2em;width:100%;text-align:center;'>&#128232;</div><h2>Abonnez-vous à notre infolettre!</h2><p style='text-align:justify;font-weight:normal;margin:15px 0px 5px 0px;'><label for='new_eml_news'>Inscrivez votre adresse courriel:</label></p><br><input type='text' id='new_eml_news' style='margin:0px 0px 20px 0px;'><button class='no-effect' onclick='refuse_eml_news();'><span class='dw3_font'>ď</span> Non merci.</button><button class='no-effect' onclick='add_eml_news();'><span class='dw3_font'>Ē</span> Je m'inscrit!</button>");
            }, 3000);
        } else {
            setTimeout(function(){ 
                dw3_msg_open("<div style='font-size:2em;width:100%;text-align:center;'>&#128232;</div><h2>Subscribe to our Newsletters!</h2><p style='text-align:justify;font-weight:normal;margin:15px 0px 5px 0px;'><label for='new_eml_news'>Type in your email:</label></p><br><input type='text' id='new_eml_news' style='margin:0px 0px 20px 0px;'><button class='no-effect' onclick='refuse_eml_news();'><span class='dw3_font'>ď</span> No Thank You.</button><button class='no-effect' onclick='add_eml_news();'><span class='dw3_font'>Ē</span> Let me in!</button>");
            }, 3000);

        }
    }

    if (COOKIE_OK != "OK" && cookie_msg !=""){  
        if(USER_LANG == "FR"){
            document.getElementById("dw3_cookie_msg").innerHTML = "<div style='padding:15px 10px 0px 10px;display:inline-block;text-align:justify;'>" + cookie_msg + "</div>"
            + "<div style='margin:3px 0px -3px 0px;text-align:center;display:inline-block;vertical-align:middle;padding:10px;'><button style='font-family:Arial;padding:10px;' class='<?php echo $LOGIN_BTN_CLASS; ?> no-effect' onclick=\"dw3_msgc_close();dw3_cookie_ok();\">Tout Accepter</button> <button style='font-family:Arial;padding:10px;' onclick='dw3_msgc_close();dw3_cookie_pref();'>Personnaliser</button>";
        } else { 
            document.getElementById("dw3_cookie_msg").innerHTML = "<div style='padding:15px 10px 0px 10px;display:inline-block;text-align:justify;'>" + cookie_msg + "</div>"
            + "<div style='margin:3px 0px -3px 0px;text-align:center;display:inline-block;vertical-align:middle;padding:10px;'><button style='font-family:Arial;padding:10px;' class='<?php echo $LOGIN_BTN_CLASS; ?> no-effect' onclick=\"dw3_msgc_close();dw3_cookie_ok();\">Accept all</button> <button style='font-family:Arial;padding:10px;' onclick='dw3_msgc_close();dw3_cookie_pref();'>Personnalize</button>";
        } 
        document.getElementById('dw3_cookie_msg').style.height = 'auto';
        document.getElementById('dw3_cookie_msg').style.maxHeight = 'none';
    } else {
        document.getElementById('dw3_cookie_msg').style.height = '0px';
        document.getElementById('dw3_cookie_msg').style.maxHeight = '0px';
    }
    if (POPUP_OK != "OK" && popup_msg !=""){  
        if(USER_LANG == "FR"){
            dw3_msg_open(popup_msg + "<button style='font-family:Arial;padding:10px;' class='no-effect' onclick=\"dw3_msg_close();dw3_popup_ok();\">Fermer</button>");
        } else { 
            dw3_msg_open(popup_msg + "<button style='font-family:Arial;padding:10px;' class='no-effect' onclick=\"dw3_msg_close();dw3_popup_ok();\">Close</button>");
        } 
    }
        if (INDEX_BLOCK_DEBUG == "true"){
            document.addEventListener("contextmenu", function (e) {
                e.preventDefault();
            }, false);
            document.addEventListener("keydown", function (e) {
                //document.onkeydown = function(e) {
                // "I" key
                if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                    disabledEvent(e);
                }
                // "J" key
                if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                    disabledEvent(e);
                }
                // "S" key + macOS
                if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                    disabledEvent(e);
                }
                // "U" key
                if (e.ctrlKey && e.keyCode == 85) {
                    disabledEvent(e);
                }
                // "F12" key
                if (event.keyCode == 123) {
                    disabledEvent(e);
                }
            }, false);
            document.addEventListener("contextmenu", function (e) {        
                e.preventDefault();
                dw3_cp_bar();
            });
        }
        function disabledEvent(e) {
            if (e.stopPropagation) {
                e.stopPropagation();
            } else if (window.event) {
                window.event.cancelBubble = true;
            }
            e.preventDefault();
            dw3_cp_bar();
            return false;
        }
        setTimeout(setSubMenusPos, 1500);
        setTimeout(function () {
            //document.getElementById("dw3_body_load_img").style.display = "none";
            checkSectionsView();
        }, 1000);
//}
/* document.addEventListener('touchmove', function (event) {
  if (event.scale !== 1) { event.preventDefault(); }
}, { passive: false }); */

var dw3_scrolled_down = false;
document.onscroll = function(){
    if (bREADY == true) {
        checkSectionsView();
    } else {
        return false;
    }

    if(document.getElementById('dw3_menu').classList.contains("dw3_menu_change")){
        if ( INDEX_HEADER == "/pub/section/header21.php"){
            document.getElementById("dw3_head21bg").style.opacity = "1";
        }
        if ( INDEX_HEADER == "/pub/section/header22.php"){
            document.getElementById("dw3_head22bg").style.opacity = "1";
        }
        if ( INDEX_HEADER == "/pub/section/header23.php"){
            document.getElementById("dw3_head22bg").style.opacity = "1";
        }
    } else {
        if ( INDEX_HEADER == "/pub/section/header21.php"){
            document.getElementById("dw3_head21bg").style.opacity = (window.scrollY-1)/150;
        }
        if ( INDEX_HEADER == "/pub/section/header22.php"){
            document.getElementById("dw3_head22bg").style.opacity = (window.scrollY-1)/150;
        }    
        if ( INDEX_HEADER == "/pub/section/header23.php"){
            document.getElementById("dw3_head22bg").style.opacity = (window.scrollY-1)/150;
        }    
    }

    if (window.scrollY > dw3_sticky && dw3_scrolled_down == false) {
        dw3_scrolled_down = true;
        document.getElementById("dw3_scroll_top").style.right = "25px";
        if (INDEX_HEADER == "/pub/section/header10.php"){
            document.getElementById("dw3_head").style.background = "#<?php echo $CIE_COLOR8??'FFF'; ?>";
            document.getElementById("dw3_head").style.backgroundImage = "linear-gradient(#<?php echo $CIE_COLOR8??'FFF'; ?> 0%, #<?php echo $CIE_COLOR8_2??'FFF'; ?> 40%)";
            document.getElementById("dw3_menu").style.top = "70px";
           // document.getElementById("dw3_menu_fade").style.top = "70px";
        }
/*         if ( INDEX_HEADER == "/pub/section/header21.php"){
            document.getElementById("dw3_head21bg").style.opacity = "0";
        } */
        if (INDEX_HEADER == "/pub/section/header1.php" || INDEX_HEADER == "/pub/section/header5.php" || INDEX_HEADER == "/pub/section/header17.php"){
            //document.getElementById("dw3_head").style.position = "fixed";
            document.getElementById("dw3_menu").style.top = "70px";
        }
        if (INDEX_HEADER == "/pub/section/header3.php" || INDEX_HEADER == "/pub/section/header16.php" || INDEX_HEADER == "/pub/section/header20.php"){
            document.getElementById("dw3_h3_eml1").style.opacity = "0";
            document.getElementById("dw3_h3_tel1").style.opacity = "0";
            document.getElementById("dw3_head_row").style.height = "70px";
            document.getElementById("imgLOGO").style.height = "70px";
            document.getElementById("dw3_head").style.height = "70px";
            document.getElementById("dw3_head").style.maxHeight = "70px";
            //document.getElementById("dw3_head").classList.add("sticky");
            document.getElementById("dw3_menu").style.top = "70px";
            //document.getElementById("dw3_menu_fade").style.top = "70px";
        } else if (INDEX_HEADER == "/pub/section/header14.php" || INDEX_HEADER == "/pub/section/header18.php" || INDEX_HEADER == "/pub/section/header12.php" || INDEX_HEADER == "/pub/section/header19.php"){
           document.getElementById("dw3_head_row").style.height = "70px"; 
            document.getElementById("imgLOGO").style.height = "70px";
            document.getElementById("dw3_head").style.height = "70px";
            document.getElementById("dw3_head").style.maxHeight = "70px";
            //document.getElementById("dw3_head").classList.add("sticky");
            document.getElementById("dw3_menu").style.top = "70px";
            //document.getElementById("dw3_menu_fade").style.top = "70px";
        }
    } else if (window.scrollY == 0){
        dw3_scrolled_down = false;
        document.getElementById("dw3_scroll_top").style.right = "-105px";
        if (INDEX_HEADER == "/pub/section/header10.php"){
                document.getElementById("dw3_head").style.background = "transparent";
                document.getElementById("dw3_head").style.backgroundImage = "linear-gradient(to right, #<?php echo $CIE_COLOR8; ?> , transparent,transparent,transparent,transparent, transparent , #<?php echo $CIE_COLOR8; ?>)";
            }
        if (INDEX_HEADER == "/pub/section/header1.php" || INDEX_HEADER == "/pub/section/header5.php" || INDEX_HEADER == "/pub/section/header17.php"){
            //document.getElementById("dw3_head").style.position = "relative";
            document.getElementById("dw3_menu").style.top = "100px";
        }
/*         if ( INDEX_HEADER == "/pub/section/header21.php"){
            document.getElementById("dw3_head21bg").style.opacity = "0";
        } */
        if (INDEX_HEADER == "/pub/section/header3.php" || INDEX_HEADER == "/pub/section/header16.php" || INDEX_HEADER == "/pub/section/header20.php"){
            document.getElementById("dw3_h3_eml1").style.opacity = "1";
            document.getElementById("dw3_h3_tel1").style.opacity = "1";
            //document.getElementById("dw3_head_row").style.height = "100px";
            document.getElementById("imgLOGO").style.height = "100px";
            document.getElementById("dw3_head").style.height = "100px";
            document.getElementById("dw3_head").style.maxHeight = "100px";
            //document.getElementById("dw3_menu_fade").style.top = "100px";
        } else if (INDEX_HEADER == "/pub/section/header14.php" || INDEX_HEADER == "/pub/section/header12.php" || INDEX_HEADER == "/pub/section/header19.php"){
            //document.getElementById("dw3_head_row").style.height = "100px";
            document.getElementById("imgLOGO").style.height = "100px";
            document.getElementById("dw3_head").style.height = "100px";
            document.getElementById("dw3_head").style.maxHeight = "100px";
           // document.getElementById("dw3_menu_fade").style.top = "100px";
        } else if (INDEX_HEADER == "/pub/section/header18.php"){
            //document.getElementById("dw3_head_row").style.height = "90px";
            document.getElementById("imgLOGO").style.height = "90px";
            document.getElementById("dw3_head").style.height = "90px";
            document.getElementById("dw3_head").style.maxHeight = "90px";
            //document.getElementById("dw3_menu_fade").style.top = "90px";
        }
        reset_menu_top();
    }
};

function refuse_eml_news(){
    var now = new Date();
    now.setMonth(now.getMonth() + 3)
    //var time = now.getTime();
    //var expireTime = time + 1000*36000;
    //now.setTime(expireTime);
    document.cookie = 'NEWS=NO;expires='+now.toUTCString()+';path=/';
    dw3_msg_close();
}
function add_eml_news(){ //from popup
    var obj_eml_news = document.getElementById("new_eml_news");
    if (obj_eml_news.value == ""){
        obj_eml_news.style.boxShadow = "0px 0px 4px 2px orange";
        obj_eml_news.focus();
        return;
    }
    obj_eml_news.style.boxShadow = "0px 0px 4px 2px grey";
    //set cookie
    var now = new Date();
    now.setMonth(now.getMonth() + 3)
    //var time = now.getTime();
    //var expireTime = time + 1000*36000;
    //now.setTime(expireTime);
    document.cookie = 'NEWS=OK;expires='+now.toUTCString()+';path=/';
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            dw3_msg_close();
            if (USER_LANG == "FR"){
                dw3_notif_add("Votre inscription à l'infolettre est complétée!");
            }else{
                dw3_notif_add("Your subscription to the newsletter is completed!");
            }
        }
    }
    xmlhttp.open('GET', '/pub/page/set_news.php?eml=' + decodeURIComponent(obj_eml_news.value)+"&act=OK", true);
    xmlhttp.send();
    document.getElementById('dw3_msg').innerHTML = "<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>' style='border-radius:10px;max-width:30px;height:auto;margin:5px;'>";
}

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

function reset_menu_top(){
    if (INDEX_HEADER == "/pub/section/header0.php" || INDEX_HEADER == "/pub/section/header6.php" || INDEX_HEADER == "/pub/section/header7.php" || INDEX_HEADER == "/pub/section/header9.php" || INDEX_HEADER == "/pub/section/header10.php" || INDEX_HEADER == "/pub/section/header11.php" || INDEX_HEADER == "/pub/section/header13.php" || INDEX_HEADER == "/pub/section/header22.php" || INDEX_HEADER == "/pub/section/header23.php"){
        document.getElementById("dw3_menu").style.top = "69px";
    }
    if (INDEX_HEADER == "/pub/section/header18.php"){
                    document.getElementById("dw3_menu").style.top = "89px";
    }
    if (INDEX_HEADER == "/pub/section/header3.php" || INDEX_HEADER == "/pub/section/header4.php" || INDEX_HEADER == "/pub/section/header8.php" || INDEX_HEADER == "/pub/section/header12.php" || INDEX_HEADER == "/pub/section/header14.php" || INDEX_HEADER == "/pub/section/header15.php" || INDEX_HEADER == "/pub/section/header17.php" || INDEX_HEADER == "/pub/section/header19.php" || INDEX_HEADER == "/pub/section/header20.php"){
        document.getElementById("dw3_menu").style.top = "100px";
    }
    if (INDEX_HEADER == "/pub/section/header21.php"){
                    document.getElementById("dw3_menu").style.top = "100px";
    }
    if (INDEX_HEADER == "/pub/section/header5.php"){
                    document.getElementById("dw3_menu").style.top = "101px";
    }
    if (INDEX_HEADER == "/pub/section/header2.php"){
                    document.getElementById("dw3_menu").style.top = "104px";
    }
    if (INDEX_HEADER == "/pub/section/header1.php"){
                    document.getElementById("dw3_menu").style.top = "119px";
    }
}

//chatbot toggle on/off
function dw3_chatbot_toggle() {
  var x = document.getElementById("dw3_chatbot_container");
  if (x.style.display == "inline-block"){
    x.style.opacity = "0";
    setTimeout(function(){x.style.display = "none"; }, 1000);
  } else {
    x.style.display = "inline-block";
    setTimeout(function(){x.style.opacity = "1"; }, 10);
  }
}

//copyright msg
function dw3_cp_bar() {
  var x = document.getElementById("dw3_copyright_bar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

//cookies
function dw3_cookie_pref(){
    document.getElementById("dw3_cookie_pref").style.transform="scaleX(100%)";
}
function dw3_cookie_save(){
    if (document.getElementById("dw3_cookie_pref1").checked == true){
        sPREF1 = "OK";
    } else { 
        sPREF1 = "NO";
    }
    if (document.getElementById("dw3_cookie_pref2").checked == true){
        sPREF2 = "OK";
    } else { 
        sPREF2 = "NO";
    }
    if (document.getElementById("dw3_cookie_pref3").checked == true){
        sPREF3 = "OK";
    } else { 
        sPREF3 = "NO";
    }
    if (document.getElementById("dw3_cookie_pref4").checked == true){
        sPREF4 = "OK";
    } else { 
        sPREF4 = "NO";
    }
    document.getElementById("dw3_cookie_pref").style.transform="scaleX(0%)";
    document.cookie="COOKIES=OK";

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText)
        }
    }
    xmlhttp.open('GET', '/pub/page/set_cookies.php?PREF1=' + sPREF1 + '&PREF2=' + sPREF2 + '&PREF3=' + sPREF3+ '&PREF4=' + sPREF4 , true);
	xmlhttp.send();

}
function dw3_cookie_ok(){
    document.cookie="COOKIES=OK" + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
}
function dw3_popup_ok(){
    document.cookie="POPUP=OK" + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
}
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}


function dw3_chatbot_speech() {
    if (document.getElementById("dw3_chatbot_auto").checked == true){
        dw3_chatbot_speek();
    }
}
function dw3_chatbot_speek() {
    var text = document.getElementById("dw3_chatbot_response").innerText;
    if ('speechSynthesis' in window) {
        let utterance = new SpeechSynthesisUtterance(text);
        //utterance.lang = "fr-FR";
        utterance.lang = "<?php echo strtolower($USER_LANG); ?>-CA";
        speechSynthesis.speak(utterance);
    } else {
        if(USER_LANG == "FR"){
            dw3_notif_add("La synthèse vocale n'est pas supporté ou autorisé par votre navigateur.");
        } else {
            dw3_notif_add("Speech synthesis is not supported or allowed by your browser.");
        }
    }

}

function dw3_chatbot_ask() {
    
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();

    recognition.lang = 'en-US'; // Set language
    recognition.continuous = false; // Stop after a single phrase
    recognition.interimResults = false; // Get only final results

    recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript;
        document.getElementById("dw3_chatbot_q").value = transcript;
        console.log('Recognized text:', transcript);
        recognition.stop();
    };

    recognition.onerror = (event) => {
        console.error('Speech recognition error:', event.error);
        recognition.stop();
    };

    // To start recognition:
    recognition.start();

    // To stop recognition:
    // recognition.stop();

}

function taxeVERTE_INFO() {
    if (USER_LANG == "FR"){
        dw3_msg_open("<h2>Que sont les frais environnementaux?</h2><p style='text-align:justify;font-weight:normal;'>Les frais environnementaux sont des montants recueillis pour financer l'élimination et le recyclage des produits ménagers faisant partie de la réglementation provinciale visant la gestion des déchets. <br>En payant ces frais, vous contribuez à la collecte d'articles, à leur recyclage, à leur réutilisation ou dans les cas où cela n'est pas possible, leur élimination de la façon qui respecte le plus l'environnement. Au Québec, la loi 60 indique que le prix affiché d'un article doit comprendre les frais environnementaux et les frais de reprise. <br>Sur le site "+window.location.host +", les clients du Québec pourront voir les frais environnementaux et les frais de reprise clairement indiqués dans le prix total d'un article.</p><br><br><button onclick='dw3_msg_close();'>&#9989; Ok</button>");
    }else{
        dw3_msg_open("<h2>What is an environmental Fee?</h2><p style='text-align:justify;font-weight:normal;'>Sometimes called an Eco Fee, is a fee collected by manufacturers and retails to help fund recycling programs that divert potentially hazardous items, such as fire exinguishers, household cleaners, and paint, from landfills.</p><br><br><button onclick='dw3_msg_close();'>&#9989; Ok</button>");
    }
}

function detectCLICK(event,that){  //rename to dw3_input_click(event,that);
	var x = event.offsetX;
	if (x > (that.offsetWidth-25)){
        that.select();
	}
}
/* subs NOT-MENU */
function dw3_sub_close(that,height="0") {
    if (height == "0"){
        document.getElementById(that).classList.remove("dw3_sub_open_auto");
    } else {
        document.getElementById(that).classList.remove("dw3_sub_open_"+height);
    }
}
function dw3_sub_open(that,height="0") {
    if (height == "0"){
        document.getElementById(that).classList.add("dw3_sub_open_auto");
    } else {
        document.getElementById(that).classList.add("dw3_sub_open_"+height);
    }
}

function dw3_sub_toggle(that_id,height="0",tick_id = "") {
    if (height == "0" || height == ""){
        document.getElementById(that_id).classList.toggle("dw3_sub_open_auto");
    } else {
        document.getElementById(that_id).classList.toggle("dw3_sub_open_"+height);
    }
    //document.getElementById(that_id).classList.toggle("dw3_sub_closed");
    if(document.getElementById(tick_id) && tick_id != ""){
        if(document.getElementById(tick_id).innerHTML == "+"){
            document.getElementById(tick_id).innerHTML = "-"
        }  else if (document.getElementById(tick_id).innerHTML == "-"){
            document.getElementById(tick_id).innerHTML = "+"
        } else if (document.getElementById(tick_id).innerHTML == "▲"){
            document.getElementById(tick_id).innerHTML = "▼"
        } else if (document.getElementById(tick_id).innerHTML == "▼"){
            document.getElementById(tick_id).innerHTML = "▲"
        } else if (document.getElementById(tick_id).innerHTML == '⯇'){
            document.getElementById(tick_id).innerHTML = '⯆';
        } else if (document.getElementById(tick_id).innerHTML == '⯆'){
            document.getElementById(tick_id).innerHTML = '⯇';
        } else if (document.getElementById(tick_id).innerHTML == '⏵'){
            document.getElementById(tick_id).innerHTML = '⏷';
        } else if (document.getElementById(tick_id).innerHTML == '⏷'){
            document.getElementById(tick_id).innerHTML = '⏵';
        }
    }
    setTimeout(checkSectionsView, 700);
}
/* subs MENU */
function dw3_sub_menu_close(that,height="0") {
    if (height == "0"){
        document.getElementById(that).classList.remove("dw3_sub_menu_open_auto");
    } else {
        document.getElementById(that).classList.remove("dw3_sub_menu_open_"+height);
    }
}
function dw3_sub_menu_open(that,height="0") {
    if (height == "0"){
        document.getElementById(that).classList.add("dw3_sub_menu_open_auto");
    } else {
        document.getElementById(that).classList.add("dw3_sub_menu_open_"+height);
    }
}

function dw3_sub_menu_toggle(that_id,height="0") {
    if (height == "0"){
        document.getElementById(that_id).classList.toggle("dw3_sub_menu_open_auto");
    } else {
        document.getElementById(that_id).classList.toggle("dw3_sub_menu_open_"+height);
    }
    checkSectionsView();
}
function checkSectionsView() {
    if (typeof dw3_section == 'undefined'){return false;}
    for (var section_id = 0; section_id < dw3_section.length; section_id++) {
        if (dw3_section[section_id]["target"]=="section"){
            var text1 = document.getElementById("dw3_section_"+section_id);
            if (text1){
                if (isInViewport(text1)){
                    text1.classList.remove("dw3_section_"+ dw3_section[section_id]["anim"]);
                    text1.style.opacity = dw3_section[section_id]["opacity"];
                } else {
                    text1.classList.add("dw3_section_"+dw3_section[section_id]["anim"]);
                    if (dw3_section[section_id]["url"] == "/pub/section/counter3/index.php" || dw3_section[section_id]["url"] == "/pub/section/counter1/index.php"){
                        setTimeout(startCounterAnim, 1000);
                    }
                    if (dw3_section[section_id]["opacity"] != "0"){
                        text1.style.opacity = "0.2";
                    } if (dw3_section[section_id]["opacity"] == "1"){
                        text1.style.opacity = "1";
                    } else {
                        text1.style.opacity = "0";
                    }
                }
            }
        }
    }
}


//product image
function toogleImageView() {
    if (document.getElementById('imgPRD')){
        document.getElementById('imgPRD').classList.toggle("dw3_image_zoom");
    }
}
function dw3_change_image(filename,element) {
    document.getElementById(element).src=filename;
}

function dw3_notif_add(text) { //rename to dw3_notif(text);
    const newDiv = document.createElement("div");
    newDiv.style.background = "#EEE";
    newDiv.style.borderRadius = "5px";
    newDiv.style.color = "#333";
    newDiv.style.borderLeft = "5px solid #226622";
    newDiv.style.transition ="all 1s";
    newDiv.style.fontWeight ="bold";
    newDiv.style.fontSize ="1em";
    newDiv.style.maxWidth ="95%";
    newDiv.style.minWidth ="200px";
    newDiv.style.width ="auto";
    newDiv.style.padding ="10px";
    newDiv.style.margin ="5px";
    newDiv.style.cursor ="pointer";
    newDiv.style.display ="table";
    newDiv.style.textAlign ="left";
    newDiv.style.float ="right";
    newDiv.innerHTML = "<span style='float:right;margin:-5px -5px 5px 5px;font-size:0.9em;font-weight:bold;color:#333'>x</span><sup> <span style='vertical-align:middle;width:90%;'>" + text + "</span></sup>";
    const currentDiv = document.getElementById("dw3_notif_container");
    //document.body.insertBefore(newDiv, currentDiv);
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

//clipboard
function dw3_input_to_clipboard(source_input) {
    var copyText = document.getElementById(source_input);
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    navigator.clipboard.writeText(copyText.value);
    if(USER_LANG == "FR"){
        dw3_notif_add("Le texte a été copié dans le presse-papier.");
    } else {
        dw3_notif_add("The text has been copied to the clipboard.");
    }
}
function dw3_text_to_clipboard(source_text) {
    navigator.clipboard.writeText(source_text);
    if(USER_LANG == "FR"){
        dw3_notif_add("Le texte a été copié dans le presse-papier.");
    } else {
        dw3_notif_add("The text has been copied to the clipboard.");
    }
}

//menu
function dw3_menu_toggle() {
  document.getElementById('dw3_menu_bars').classList.toggle("dw3_menu_bars_change");
  document.getElementById('dw3_menu').classList.toggle("dw3_menu_change");
  document.getElementById('dw3_menu_fade').classList.toggle("dw3_menu_fade_open");
  if(document.getElementById('dw3_menu').classList.contains("dw3_menu_change")){
    if ( INDEX_HEADER == "/pub/section/header21.php"){
        document.getElementById("dw3_head21bg").style.opacity = "1";
    }
    if ( INDEX_HEADER == "/pub/section/header22.php"){
        document.getElementById("dw3_head22bg").style.opacity = "1";
    }
    if ( INDEX_HEADER == "/pub/section/header23.php"){
        document.getElementById("dw3_head22bg").style.opacity = "1";
    }
  } else {
    if ( INDEX_HEADER == "/pub/section/header21.php"){
        document.getElementById("dw3_head21bg").style.opacity = (window.scrollY-1)/150;
    }
    if ( INDEX_HEADER == "/pub/section/header22.php"){
        document.getElementById("dw3_head22bg").style.opacity = (window.scrollY-1)/150;
    }    
    if ( INDEX_HEADER == "/pub/section/header23.php"){
        document.getElementById("dw3_head22bg").style.opacity = (window.scrollY-1)/150;
    }    
  }
}
function dw3_eml1() {
    window.open("mailto:<?php echo $CIE_EML1; ?>","_self");
}
function dw3_tel1() {
    window.open("tel:<?php echo $CIE_TEL1; ?>","_self");
}
function dw3_tel2() {
    window.open("tel:<?php echo $CIE_TEL2; ?>","_self");
}
//editors
function dw3_editor_close() {
    document.getElementById('dw3_editor').style.opacity = '0';
    if (document.getElementById('dw3_cart') != undefined){
        if (document.getElementById('dw3_cart').style.display != "inline-block"){
            document.getElementById("dw3_body_fade").style.opacity = "0";
        }
    } else {
        document.getElementById("dw3_body_fade").style.opacity = "0";
    }
    setTimeout(() => {
        document.getElementById('dw3_editor').style.display = 'none';
        if (document.getElementById('dw3_cart') != undefined){
            if (document.getElementById('dw3_cart').style.display != "inline-block"){
                document.getElementById('dw3_body_fade').style.display = 'none';
            }
        } else {
            document.getElementById('dw3_body_fade').style.display = 'none';
        }
    }, 500);
}
function dw3_editor_open() {
	document.getElementById('dw3_editor').style.opacity = '1';
	document.getElementById('dw3_editor').style.display = 'inline-block';
    document.getElementById("dw3_body_fade").style.opacity = "0.6";
	document.getElementById('dw3_body_fade').style.display = 'inline-block';
}

//msgbox
function dw3_msg_open(msg) {
	document.getElementById('dw3_msg').style.display = 'inline-block';
	document.getElementById('dw3_msg').innerHTML = msg;
	document.getElementById('dw3_body_fade').style.display = 'inline-block';
    document.getElementById("dw3_body_fade").style.opacity = "0.6";
}
function dw3_msg_close() {
    document.getElementById('dw3_msg').style.display = 'none';
    //document.getElementById("dw3_body_fade").style.opacity = "0";
    if (document.getElementById('dw3_editor') != undefined && document.getElementById('dw3_cart') != undefined){
        if (document.getElementById('dw3_editor').style.display != "inline-block" && document.getElementById('dw3_cart').style.display != "inline-block"){
            document.getElementById("dw3_body_fade").style.opacity = "0";
        }
    } else {
        document.getElementById("dw3_body_fade").style.opacity = "0";
    }
    setTimeout(() => {
        //document.getElementById('dw3_body_fade').style.display = 'none';
        if (document.getElementById('dw3_editor') != undefined && document.getElementById('dw3_cart') != undefined){
            if (document.getElementById('dw3_editor').style.display != "inline-block" && document.getElementById('dw3_cart').style.display != "inline-block"){
                    document.getElementById("dw3_body_fade").style.display = 'none';
            }
        } else {
            document.getElementById("dw3_body_fade").style.display = 'none';
        }
    }, "500");
}
function dw3_msgc_close() {
	document.getElementById('dw3_cookie_msg').style.height = '0px';
}


function dw3_go_home(url,target){
  window.open('https://<?php echo $_SERVER["SERVER_NAME"];?>','_self');
}
function dw3_page_open(url,target){
/*     if (url.substring(1,4)!="http"){

    } */
  window.open(url,target);
}

function dw3_lang_open() {
    dw3_msg_open("Choisissez une langue<br style='margin:0px;'>Choose a language<br><button onclick='dw3_lang_set(\"FR\");'><img src=\"https://dataia.ca/img/flags/84.png\"' style='height:32px;width:auto;'> Français</button> <button onclick='dw3_lang_set(\"EN\");'><img src=\"https://dataia.ca/img/flags/86.png\"' style='height:32px;width:auto;'> English</button>");
}
function dw3_lang_set(language) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText)
        }
    }
    xmlhttp.open('GET', '/pub/page/set_lang.php?LANG=' + language , true);
	xmlhttp.send();
    var myDate = new Date();
    myDate.setMonth(myDate.getMonth() + 12);
    document.cookie = "LANG="+language+";expires=" + myDate +";path=/;domain=.<?php echo $_SERVER['SERVER_NAME']; ?>;";
    dw3_msg_close();
    if (document.getElementById('dw3_lang_span')) {
        document.getElementById('dw3_lang_span').innerHTML = "<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>' style='border-radius:10px;max-width:30px;height:auto;margin:5px;'>";
    }
    setTimeout(() => {
        location.reload();
        return false;
    }, "1500");

}


//drag obj using first child 
function dw3_drag_init(elmnt) {
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    //document.getElementById(elmnt.id).firstChild.onmousedown = dragMouseDown;
    //const elemntChild = elmnt.firstChild;
    const elemntChild = document.getElementById(elmnt.id+"_HEAD");
    //elmnt.firstChild.onmousedown = dragMouseDown;
    elemntChild.onmousedown = dragMouseDown;
    function dragMouseDown(e) {
      e = e || window.event;
      e.preventDefault();
      pos3 = e.clientX;
      pos4 = e.clientY;
      document.onmouseup = closeDragElement;
      document.onmousemove = elementDrag;
    }
    function elementDrag(e) {
      e = e || window.event;
      e.preventDefault();
      pos1 = pos3 - e.clientX;
      pos2 = pos4 - e.clientY;
      pos3 = e.clientX;
      pos4 = e.clientY;
      elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
      elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }
    function closeDragElement() {
      document.onmouseup = null;
      document.onmousemove = null;
    }
}

//avatars
function dw3_avatar_change(avatarId,target){
    var svgCode = multiavatar(avatarId);
    if (document.getElementById(target)){
        document.getElementById(target).innerHTML=svgCode;
    }
}

//wish
function dw3_wish_count(){
    var cookies = dw3_cookies_get_all();
    var counter = 0;
    for(var name in cookies) {
        if(name.slice(0, 4) == "WISH" && cookies[name] != "0" || name.slice(0, 5) == "WISH2" && cookies[name] != "0"){counter++;}
    }
    if (document.getElementById("dw3_wish_qty")){
        document.getElementById("dw3_wish_qty").innerHTML= counter;
    }
    if (document.getElementById("dw3_wish2_qty")){
        document.getElementById("dw3_wish2_qty").innerHTML= counter;
    }
}
function dw3_wish_open() {
    document.getElementById("dw3_body_fade").style.opacity = "0.6";
    document.getElementById("dw3_body_fade").style.display = "inline-block";	 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("dw3_cart").innerHTML = this.responseText;
        document.getElementById('dw3_cart').style.display = 'inline-block';
        document.getElementById('dw3_cart').style.opacity = '1';
        document.getElementById('dw3_body_fade').style.display = 'inline-block';
        document.getElementById("dw3_body_fade").style.opacity = "0.6";
        dw3_drag_init(document.getElementById('dw3_cart'));
        }
    };
        xmlhttp.open('GET', '/pub/section/products/getFAV.php?KEY=' + KEY , true);
        xmlhttp.send();
}

//product wish
function dw3_wish_toogle(id){
    if (document.getElementById("dw3_wish_"+id)){
        if (document.getElementById("dw3_wish_"+id).innerText=="Q"){
            dw3_wish_del(id);
        } else {
            dw3_wish_add(id);
        }
    } else if (document.getElementById("dw3_wish3_"+id)){
        //if (document.getElementById("dw3_wish3_"+id).src=="/pub/img/dw3/fav_full.png"){
        if (document.getElementById("dw3_wish3_"+id).innerText=="Q"){
            dw3_wish_del(id);
        } else {
            dw3_wish_add(id);
        }
    }
    dw3_wish_count();
}
function dw3_wish_add(id){
    document.cookie = "WISH_" + id + "=1;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    if(USER_LANG == "FR"){
        dw3_notif_add("Un item a été ajouté à votre liste de souhaits.");
    } else {
        dw3_notif_add("An item has been added to your wishlist.");
    }
    if (document.getElementById("dw3_wish_"+id)){
        document.getElementById("dw3_wish_"+id).innerText="Q";  
    }
    if (document.getElementById("dw3_wish3_"+id)){
        document.getElementById("dw3_wish3_"+id).innerText="Q";  
    }
    dw3_wish_count();
}
function dw3_wish_del(prID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(5, (eqPos-5));
        const cookieVal = getCookie("WISH_"+prID);
        const newVal = "0";
        if (cprid==prID){
            document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            if (document.getElementById("dw3_wish_"+prID)){
                document.getElementById("dw3_wish_"+prID).innerText="R";
            }
            if (document.getElementById("dw3_wish3_"+prID)){
                document.getElementById("dw3_wish3_"+prID).innerText="R";
            }
            if(USER_LANG == "FR"){
                dw3_notif_add("Un item a été retiré à votre liste de souhaits.");
            } else {
                dw3_notif_add("An item has been removed from your wishlist.");
            }
        }
    }
    dw3_wish_count();
}
function deleteOneWish(id){
    document.cookie = "WISH_" + id + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_wish_count();
    if(USER_LANG == "FR"){
        dw3_notif_add("Un item a été retiré de votre liste de favoris.");
    } else {
        dw3_notif_add("An item has been removed from your favorites list.");
    }
    dw3_wish_open();
    if (document.getElementById("dw3_wish_"+id)){
        document.getElementById("dw3_wish_"+id).innerText="R";
    }
    if (document.getElementById("dw3_wish3_"+id)){
        document.getElementById("dw3_wish3_"+id).innerText="R";
    }
}


//market wish
function dw3_wish2_toogle(id){
 if (document.getElementById("dw3_wish2_"+id).innerHTML=="♥"){
    dw3_wish2_del(id);
 } else {
    dw3_wish2_add(id);
 }
 dw3_wish_count();
}
function dw3_wish2_add(id){
    document.cookie = "WISH2_" + id + "=1;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    if(USER_LANG == "FR"){
        dw3_notif_add("Un item a été ajouté à votre liste de souhaits.");
    } else {
        dw3_notif_add("An item has been added to your wishlist.");
    }
    document.getElementById("dw3_wish2_"+id).innerText=="Q";
    dw3_wish_count();
}
function dw3_wish2_del(prID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(6, (eqPos-6));
        const cookieVal = getCookie("WISH2_"+prID);
        const newVal = "0";
        if (cprid==prID){
            document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            document.getElementById("dw3_wish2_"+prID).innerHTML= "&#9825;";
            if(USER_LANG == "FR"){
                dw3_notif_add("Un item a été retiré à votre liste de souhaits.");
            } else {
                dw3_notif_add("An item has been removed from your wishlist.");
            }
        }
    }
    dw3_wish_count();
}



//search
function dw3_search_prod() {
    var GRPBOX  = document.getElementById("header_cat_bar");
	var selected_cat = GRPBOX.options[GRPBOX.selectedIndex].value;
    sS_val = document.getElementById("header_search_bar").value;
/*     if ( sS_val == ""){
        document.getElementById("header_search_bar").style.boxShadow = "0px 0px 4px 2px orange";
        document.getElementById("header_search_bar").focus();
        return;
    } */
    
    window.open("/pub/page/products/index.php?P1="+selected_cat+"&P2="+encodeURIComponent(sS_val),"_self")
}
function dw3_search_open() {
    if (USER_LANG == "FR"){
        dw3_msg_open("<button class='dw3_form_close no-effect' onclick='dw3_msg_close();'>&#10062;</button><b>Recherche de produits et services</b></br><div style='max-width:400px;display:inline-block;margin:15px 0px 10px 0px;display:flex'><input style='background:#fff;color:#333;' type='search' class='inputRECH' placeholder='Rechercher' id='header_search_bar' onkeyup='if (event.keyCode == 13){dw3_search_prod();}'><button onclick='dw3_search_prod()' class='no-effect'>&#128269;</button></div>"
        +"<select id='header_cat_bar' class='like_search'><option value='all'>Toutes les catégories</option>"
        <?php
        $sql = "SELECT A.*, IFNULL(B.product_found,'0') AS found_b, IFNULL(C.product_found,'0') AS found_c, IFNULL(D.product_found,'0') AS found_d
FROM product_category A
LEFT JOIN (SELECT count(id) AS product_found, category_id FROM product WHERE web_dsp=1 AND stat=0 GROUP BY category_id) B ON A.id = B.category_id
LEFT JOIN (SELECT count(id) AS product_found, category2_id FROM product WHERE web_dsp=1 AND stat=0 GROUP BY category2_id) C ON A.id = C.category2_id
LEFT JOIN (SELECT count(id) AS product_found, category3_id FROM product WHERE web_dsp=1 AND stat=0 GROUP BY category3_id) D ON A.id = D.category3_id
WHERE B.product_found <> 0 OR C.product_found <> 0 OR D.product_found <> 0
ORDER BY A.name_fr ASC;";
        $result = $dw3_conn->query($sql);
        $cat_count = $result->num_rows;
        if ($cat_count > 0) {
            while($row = $result->fetch_assoc()) {
                    $found_by_cat = $row["found_b"] + $row["found_c"] + $row["found_d"] ;
                    echo '+"<option value=\''.$row["id"].'\'>'.str_replace("'","’",$row["name_fr"]).' ('.$found_by_cat.')</option>"';
            }
        }
        ?>
    +"</select>");
    } else {
        dw3_msg_open("<button class='dw3_form_close no-effect' onclick='dw3_msg_close();'>&#10062;</button><b>Search in products and services</b><br><div style='max-width:400px;display:inline-block;margin:15px 0px 10px 0px;display:flex'><input style='background:#fff;color:#333;' type='search' class='inputRECH' placeholder='Search' id='header_search_bar' onkeyup='if (event.keyCode == 13){dw3_search_prod();}'><button onclick='dw3_search_prod()' class='no-effect'>&#128269;</button></div>"
        +"<select id='header_cat_bar' class='like_search'><option value='all'>All categories</option>"
        <?php
                $sql = "SELECT A.*, IFNULL(B.product_found,'0') AS found_b, IFNULL(C.product_found,'0') AS found_c, IFNULL(D.product_found,'0') AS found_d
FROM product_category A
LEFT JOIN (SELECT count(id) AS product_found, category_id FROM product WHERE web_dsp=1 AND stat=0 GROUP BY category_id) B ON A.id = B.category_id
LEFT JOIN (SELECT count(id) AS product_found, category2_id FROM product WHERE web_dsp=1 AND stat=0 GROUP BY category2_id) C ON A.id = C.category2_id
LEFT JOIN (SELECT count(id) AS product_found, category3_id FROM product WHERE web_dsp=1 AND stat=0 GROUP BY category3_id) D ON A.id = D.category3_id
WHERE B.product_found <> 0 OR C.product_found <> 0 OR D.product_found <> 0
ORDER BY A.name_en ASC;";
        $result = $dw3_conn->query($sql);
        $cat_count = $result->num_rows;
        if ($cat_count > 0) {
            while($row = $result->fetch_assoc()) {
                $found_by_cat = $row["found_b"] + $row["found_c"] + $row["found_d"] ;
                echo '+"<option value=\''.$row["id"].'\'>'.str_replace("'","’",$row["name_en"]).' ('.$found_by_cat.')</option>"';
            }
        }
        ?>
    +"</select>");
    }
}

//market
function plusAdCookie(adID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(3, (eqPos-3));
        const cookieVal = getCookie("AD_"+adID);
        const newVal = Number(cookieVal) + 1;
        if (cprid==adID && name.substr(0,3) == "AD_"){
            document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            //browser.cookies.remove({name:name});
            //location.reload();
            dw3_cart_open();
        }
    }
}
function minusAdCookie(adID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(3, (eqPos-3));
        const cookieVal = getCookie("AD_"+adID);
        const newVal = Number(cookieVal) - 1;
        if (cprid==adID && name.substr(0,3) == "AD_"){
            document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            //browser.cookies.remove({name:name});
            //location.reload();
            dw3_cart_open();
        }
    }
}
function deleteOneAd(id){
    document.cookie = "AD_" + id + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_cart_count();
    if (USER_LANG == "FR"){
        dw3_notif_add("Un item a été retiré de votre panier.");
    } else {
        dw3_notif_add("An item has been removed from your cart.");
    }
    dw3_cart_open();
}
function deleteOneWish2(id){
    document.cookie = "WISH2_" + id + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_wish_count();
    if (USER_LANG == "FR"){
        dw3_notif_add("Un item a été retiré de votre liste de favoris.");
    } else {
        dw3_notif_add("An item has been removed from your favorites list.");
    }
    dw3_wish_open();
}

//subscription
function dw3_subscribe(product_id){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (KEY !="") {
                window.open('/client/dashboard.php?K=' + KEY,'_self');
            } else {
                if (USER_LANG == "FR"){
                    dw3_msg_open("Pour vous abonner, veuillez vous connecter ou vous créer un compte.<br><br><button class='grey no-effect' onclick='dw3_msg_close();' ><span class='dw3_font'>ď</span> Annuler</button><button class='no-effect' onclick=\"dw3_msg_close();window.open('/client','_self');\" ><span class='dw3_font'>Ɔ</span> Espace client</button>");
                } else {
                    dw3_msg_open("To subscribe, please log in or create an account.<br><br><button class='grey no-effect' onclick='dw3_msg_close();' ><span class='dw3_font'>ď</span> Cancel</button><button class='no-effect' onclick=\"dw3_msg_close();window.open('/client','_self');\" ><span class='dw3_font'>Ɔ</span> Client area</button>");
                }
            }
        }
    }
    xmlhttp.open('GET', '/pub/section/products/dw3_subscribe.php?ID=' + product_id, true);
    xmlhttp.send();        
}

//cart
function dw3_cart_count(){
    var counter = dw3_get_cookie("CART_COUNT");
    if (counter == "" || counter == undefined){ counter = 0;}
    var cookies = dw3_cookies_get_all();
    for(var name in cookies) {
        if(name.slice(0, 3) == "AD_" && cookies[name] != "0"){counter = counter + Number(cookies[name]);}
    }
    if (document.getElementById("dw3_cart_qty")){
        document.getElementById("dw3_cart_qty").innerHTML= counter;
    }
    if (document.getElementById("dw3_cart2_qty")){
        document.getElementById("dw3_cart2_qty").innerHTML= counter;
    }
}

function dw3_cart_add(product_id){
    var counter = dw3_get_cookie("CART_COUNT");
    //console.log(counter);
    if (counter == "" || counter == undefined){ counter = 0;}
    //console.log(counter);
    counter++;
    //console.log(counter);
    document.cookie = "CART_COUNT="+counter+";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            dw3_cart_count();
            if (document.getElementById('dw3_cart') != undefined){
                if (document.getElementById('dw3_cart').style.display == "inline-block"){
                    dw3_cart_open();
                }
            }
        }
    }
    xmlhttp.open('GET', '/pub/section/products/dw3_cart_add.php?ID=' + product_id , true);
    xmlhttp.send();
    if (USER_LANG == "FR"){
        dw3_notif_add("Un item a été ajouté à votre panier.");
    } else {
        dw3_notif_add("An item has been added to your cart.");
    }    
}

function dw3_cart_plus(line_id,qtyMAX = ""){
    //if(Number(counter) < qtyMAX || qtyMAX == ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                dw3_cart_open();
            }
        }
        xmlhttp.open('GET', '/pub/section/products/dw3_cart_plus.php?ID=' + line_id + '&MAX=' + qtyMAX, true);
        xmlhttp.send();        
    //}
}
function dw3_cart_minus(line_id,qtyMIN = ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.cookie = "CART_COUNT="+this.responseText+";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
                dw3_cart_count();
                dw3_cart_open();
            }
        }
        xmlhttp.open('GET', '/pub/section/products/dw3_cart_minus.php?ID=' + line_id + '&MIN=' + qtyMIN, true);
        xmlhttp.send(); 
}
function dw3_cart_plusX(line_id,qtyMAX = ""){
    //if(Number(counter) < qtyMAX || qtyMAX == ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                dw3_cart_open();
            }
        }
        xmlhttp.open('GET', '/pub/section/products/dw3_cart_plusX.php?ID=' + line_id + '&MAX=' + qtyMAX, true);
        xmlhttp.send();        
    //}
}
function dw3_cart_minusX(line_id,qtyMIN = ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.cookie = "CART_COUNT="+this.responseText+";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
                dw3_cart_count();
                dw3_cart_open();
            }
        }
        xmlhttp.open('GET', '/pub/section/products/dw3_cart_minusX.php?ID=' + line_id + '&MIN=' + qtyMIN, true);
        xmlhttp.send(); 
}

function dw3_cart_change(line_id, qtyMAX = "", qtyMIN = ""){
    var cart_qty = document.getElementById('dw3_cart_item_qty_'+line_id).value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            document.getElementById('dw3_cart_item_qty_'+line_id).value = response.line_qty;
            document.cookie = "CART_COUNT="+response.cart_count+";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
            dw3_notif_add(response.response_text);
            dw3_cart_open();
        }
    }
    xmlhttp.open('GET', '/pub/section/products/dw3_cart_change.php?ID=' + line_id + '&MIN=' + qtyMIN + '&MAX=' + qtyMAX + '&QTY=' + cart_qty, true);
    xmlhttp.send(); 
}

function updCART_OPTION(lnID,optID,optlID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (USER_LANG == "FR"){
            dw3_notif_add("Option mise à jour.");
        } else {
            dw3_notif_add("Option updated.");
        }
        dw3_cart_open();
	  }
	};
		xmlhttp.open('GET', '/pub/section/products/updCART_OPTION.php?KEY=' + KEY + '&lnID=' + lnID + '&optID=' + optID + '&optlID=' + optlID , true);
		xmlhttp.send();
}

function dw3_cart_del(line_id){
/*     document.cookie = "CART_" + id + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_cart_count();
    dw3_notif_add("Un item a été retiré de votre panier.");
    dw3_cart_open(); */
    var counter = dw3_get_cookie("CART_COUNT");
    if (counter == "" || counter == undefined || counter <= 0|| counter == "0"){ counter = 0;} else {counter = counter -1;}
    document.cookie = "CART_COUNT="+counter+";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText);
            dw3_cart_open();
        }
    }
    xmlhttp.open('GET', '/pub/section/products/dw3_cart_del.php?ID=' + line_id , true);
	xmlhttp.send();
    if (USER_LANG == "FR"){
        dw3_notif_add("Un item a été retiré de votre panier.");
    } else {
        dw3_notif_add("An item has been removed from your cart.");
    }
    dw3_cart_count();
}


function getPRICE_LIST(product_id,customer_id,line_id){
    //if(Number(counter) < qtyMAX || qtyMAX == ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (USER_LANG == "FR"){
                    dw3_msg_open(this.responseText + "<br><button class='no-effect' onclick='dw3_msg_close();' ><span class='dw3_font'>ď</span> Fermer</button>");
                } else {
                    dw3_msg_open(this.responseText + "<br><button class='no-effect' onclick='dw3_msg_close();' ><span class='dw3_font'>ď</span> Close</button>");
                }
            }
        }
        xmlhttp.open('GET', '/pub/section/products/getPRICE_LIST.php?prID=' + product_id + '&clID=' + customer_id+ '&lnID=' + line_id, true);
        xmlhttp.send();        
    //}
}
function dw3_set_item_qty(line_id,newQTY){
    document.getElementById('dw3_cart_item_qty_'+line_id).value = newQTY;
    var new_event = new Event('change');
    document.getElementById('dw3_cart_item_qty_'+line_id).dispatchEvent(new_event);
    dw3_msg_close();
}

function dw3_cart_close() {
    document.getElementById('dw3_cart').style.opacity = '0';
    //document.getElementById("dw3_body_fade").style.opacity = "0";
    if (document.getElementById('dw3_editor') != undefined){
        if (document.getElementById('dw3_editor').style.display != "inline-block"){
            document.getElementById("dw3_body_fade").style.opacity = "0";
        }
    } else {
        document.getElementById("dw3_body_fade").style.opacity = "0";
    }
    setTimeout(() => {
        document.getElementById('dw3_cart').style.display = 'none';
        //document.getElementById('dw3_body_fade').style.display = 'none';
        if (document.getElementById('dw3_editor') != undefined){
            if (document.getElementById('dw3_editor').style.display != "inline-block"){
                    document.getElementById("dw3_body_fade").style.display = 'none';
            }
        } else {
            document.getElementById("dw3_body_fade").style.display = 'none';
        }
    }, "500");
}

function dw3_cart_open() {
        //save cart scrollTop
        const myElement = document.getElementById("dw3_cart_DATA");
        if (myElement !== null) {
            localStorage.setItem("myElementScrollTop", myElement.scrollTop);
        }

        document.getElementById("dw3_body_fade").style.opacity = "0.6";
        document.getElementById("dw3_body_fade").style.display = "inline-block";	 
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("dw3_cart").innerHTML = this.responseText;
            document.getElementById('dw3_cart').style.opacity = '1';
            document.getElementById('dw3_cart').style.display = 'inline-block';
            document.getElementById("dw3_body_fade").style.opacity = "0.6";
            document.getElementById('dw3_body_fade').style.display = 'inline-block';
            dw3_drag_init(document.getElementById('dw3_cart'));

                //load cart scrollTop
                const myElement = document.getElementById("dw3_cart_DATA");
                const savedScrollTop = localStorage.getItem("myElementScrollTop");
                if (myElement && savedScrollTop !== null) {
                    myElement.scrollTop = parseInt(savedScrollTop);
                }
          }
        };
        xmlhttp.open('GET', '/pub/section/products/getCART.php?KEY=' + KEY , true);
        xmlhttp.send();
}

function dw3_cookies_get_all() {
    var cookies = { };
    if (document.cookie && document.cookie != '') {
        var split = document.cookie.split(';');
        for (var i = 0; i < split.length; i++) {
            var name_value = split[i].split("=");
            name_value[0] = name_value[0].replace(/^ /, '');
            cookies[decodeURIComponent(name_value[0])] = decodeURIComponent(name_value[1]);
        }
    }
    return cookies;
}

function dw3_get_cookie(name) {
    const regex = new RegExp(`(^| )${name}=([^;]+)`)
    const match = document.cookie.match(regex)
    if (match) {
        return match[2];
    }
}

function plusCookie(prID,qtyMAX) {
/*     const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(5, (eqPos-5));
        const cookieVal = getCookie("CART_"+prID);
        const newVal = Number(cookieVal) + 1;
        if (cprid==prID){
            if(Number(cookieVal) < qtyMAX || qtyMAX == ""){
                document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
                dw3_cart_open();
            }
            //browser.cookies.remove({name:name});
            //dw3_cart_count();
        }
    } */
}

function minusCookie(prID) {
/*     const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(5, (eqPos-5));
        const cookieVal = getCookie("CART_"+prID);
        const newVal = Number(cookieVal) - 1;
        if (cprid==prID){
            document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            //browser.cookies.remove({name:name});
            dw3_cart_open();
            dw3_cart_count();
        }
    } */
}



function buyAD(id){
    document.cookie = "AD_" + id + "=1;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_cart_count();
    if (USER_LANG == "FR"){
        dw3_notif_add("Un item a été ajouté à votre panier.");
    } else {
        dw3_notif_add("An item has been added to your cart.");
    }
    //dw3_msg_open("<div style='margin:10px 0px 10px 0px;'>Pour completer l'achat, vous serez redirigé vers la page de connexion</div><br> <button class='no-effect' onclick='dw3_msg_close();' style='padding:2px;position:absolute;top:0px;right:0px;'>&#10060; </button> <button onclick=\"window.open('/client','_self');\">Continuer <span class='material-icons' style='vertical-align:middle;'>login</span></button>");
}

//downloads
var dw3_cancel_download = false;
function dw3_download(product_id,file_url,that_button) {
    var button_before_html = that_button.innerHTML;
    that_button.disabled = true;
    document.getElementById("dw3_body_fade").style.opacity = "0.6";
    document.getElementById("dw3_body_fade").style.display = "inline-block";        
    document.getElementById("dw3_msg").style.display = "inline-block";
    document.getElementById("dw3_msg").innerHTML = "<span class='dw3_font'>ņ</span><br><div id='dw3_download_msg' style='width:300px;'></div><br><br><button class='no-effect red' style='background:#444;color:#EEE;' onclick='dw3_msg_close();dw3_cancel_download=true;'>&#10060; Cancel</button>";

    const startTime = new Date().getTime();
    request = new XMLHttpRequest();
    request.responseType = "blob";
    request.open("get", file_url, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        const imageURL = window.URL.createObjectURL(this.response);
        const anchor = document.createElement("a");
        anchor.href = imageURL;
        anchor.download = file_url.substring(file_url.lastIndexOf('/')+1);
        document.body.appendChild(anchor);
        anchor.click();
        that_button.innerHTML ='&#9989; Terminé';
        dw3_msg_close();
        dw3_updatedl_count(product_id);
        }
    };

    request.onprogress = function (e) {
        const percent_complete = Math.floor((e.loaded / e.total) * 100); 
        const duration = (new Date().getTime() - startTime) / 1000;
        const bps = e.loaded / duration;
        const kbps = Math.floor(bps / 1024);
        const time = (e.total - e.loaded) / bps;
        const seconds = Math.floor(time % 60);
        const minutes = Math.floor(time / 60);
        document.getElementById('dw3_download_msg').innerHTML = `<b>${percent_complete}%</b> - ${kbps} Kbps <br> <b>${minutes}</b> min <b>${seconds}</b> sec remaining`;
        //that.innerText = `${percent_complete}%`;
        //that.innerText = `${percent_complete}% - ${kbps} Kbps - ${minutes} min ${seconds} sec remaining`;
        if (dw3_cancel_download == true){
            dw3_cancel_download = false;
            request.abort();
            that_button.innerHTML ='&#10071; Annulé';
            setTimeout(() => {
                dw3_cancel_download = false;
                that_button.innerHTML = button_before_html;
                that_button.disabled = false;
            }, 3000);
        }
    };
}

function dw3_updatedl_count(product_id){
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText)
        }
    }
    xmlhttp.open('GET', '/pub/section/products/dw3_updatedl_count.php?ID=' + product_id , true);
	xmlhttp.send();
}

function dw3_handle_orientation(event) {
  const absolute = event.absolute;
  const alpha = event.alpha;
  const beta = event.beta; 
  const gamma = event.gamma;

  //document.getElementById('bg').style.top = "-" + Math.abs(beta) + "px";
  //document.getElementById('bg').style.left = "-" + Math.abs(gamma-20) + "px";
  
}
function verify_code_coupon() {
    document.getElementById("dw3_body_fade").style.opacity = "0.6";
    document.getElementById("dw3_body_fade").style.display = "inline-block";
    sCODE = document.getElementById("dw3_input_coupon").value;
    if (sCODE==""){

    }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == ""){
            if (USER_LANG == "FR"){
                dw3_notif_add("Le coupon a été validé et sera appliqué sur votre commande.<br><br><button onclick=\"dw3_msg_close();dw3_cart_open();\">&#9989; Ok Merci!</button>");
            } else {
                dw3_notif_add("The coupon has been validated and will be applied to your order.<br><br><button onclick=\"dw3_msg_close();dw3_cart_open();\">&#9989; Ok Thank You!</button>");
            }
            //dw3_cart_open();
        } else {
            dw3_msg_open(this.responseText + "<br><br><button onclick=\"dw3_msg_close();\">&#9989; Ok</button>");
            document.getElementById("dw3_input_coupon").value = "";
        }
	  }
	};
		xmlhttp.open('GET', '/pub/section/products/validateCOUPON.php?KEY=' + KEY + '&C=' + sCODE , true);
		xmlhttp.send();
}
function getPRD(prID) {
    document.getElementById("dw3_body_fade").style.opacity = "0.6";
    document.getElementById("dw3_body_fade").style.display = "inline-block";	 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("dw3_editor").innerHTML = this.responseText;
        document.getElementById("dw3_editor").style.display = "inline-block";
        document.getElementById("dw3_editor").style.opacity = "1";
        dw3_drag_init(document.getElementById('dw3_editor'));
	  }
	};
		xmlhttp.open('GET', '/pub/section/products/getPRD.php?KEY=' + KEY + '&P=' + prID , true);
		xmlhttp.send();
}


function getPRDS(catID,pageID="") {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        window.open('/pub/page/products/index.php?KEY=' + KEY + '&P1=' + catID + '&PID='+pageID,'_self');
      }
    };
    xmlhttp.open('GET', '/pub/page/products/addCatVisit.php?KEY=' + KEY + '&C=' + catID , true);
    xmlhttp.send();
}

function getAD(ID) {
    document.getElementById("dw3_body_fade").style.opacity = "0.6";
    document.getElementById("dw3_body_fade").style.display = "inline-block";	 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("dw3_editor").innerHTML = this.responseText;
        document.getElementById("dw3_editor").style.display = "inline-block";
        document.getElementById("dw3_editor").style.opacity = "1";
        dw3_drag_init(document.getElementById('dw3_editor'));
	  }
	};
		xmlhttp.open('GET', '/pub/section/classifieds/getAD.php?KEY=' + KEY + '&A=' + ID , true);
		xmlhttp.send();
}
function getRET_DET(ID) {
    document.getElementById("dw3_body_fade").style.opacity = "0.6";
    document.getElementById("dw3_body_fade").style.display = "inline-block";	 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("dw3_editor").innerHTML = this.responseText;
        document.getElementById("dw3_editor").style.display = "inline-block";
        document.getElementById("dw3_editor").style.opacity = "1";
        dw3_drag_init(document.getElementById('dw3_editor'));
	  }
	};
		xmlhttp.open('GET', '/pub/section/classifieds/getRET_DET.php?KEY=' + KEY + '&C=' + ID , true);
		xmlhttp.send();
}
function getRET_ADS(retID) {
    window.open('/pub/page/retailer/classifieds.php?KEY=' + KEY + '&P1=' + retID,'_self');
}
function getADS(catID,pID) {
    window.open('/pub/page/classifieds2/index.php?KEY=' + KEY + '&P1=' + catID+ '&PID=' + pID,'_self');
}

function findADS(sOFFSET,sLIMIT) {
    ssF = document.getElementById("rechAD").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divCLASSIFIEDS").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', '/pub/page/classifieds2/getADS.php?KEY=' + KEY 
    + '&P1='												
    + '&SS='+encodeURIComponent(ssF)												
    + '&OFFSET=' + sOFFSET 
    + '&LIMIT=' + sLIMIT, true);
    xmlhttp.send();
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
function dw3_gal3_show(images_array,img_tag_id,title){
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
          }, 490);
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
          }, 490);
      }
  }
  function dw3_gal3_close(){
    var scroll_top = document.getElementById("dw3_scroll_top");
    scroll_top.style.display = "inline-block";
    document.body.style.overflowY = 'auto';
    var modal = document.getElementById("gal3_modal");
    modal.style.display = "none";
    dw3_gal3_rotation = 0;
    dw3_gal3_current_index = 0;
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


var currentSORTway="ASC";
function dw3_table_sort(COL=0,table) {
  var rows, switching, i, x, y, shouldSwitch;
  //table = document.getElementById(tableNAME);
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
      if (currentSORTway == "ASC"){
            if (!isNaN(x.innerHTML) && !isNaN(y.innerHTML)){
                if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
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
            if (!isNaN(x.innerHTML) && !isNaN(y.innerHTML)){
                if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
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

//used with search bar
function dw3_table_filter(input, tableName) {
    var input, filter, table, tr, td, i, txtValue;
    filter = input.value.toUpperCase();
    table = document.getElementById(tableName);
    tr = table.getElementsByTagName("tr");
    for (var i = 0; i < tr.length; i++) {
        if (tr[i].textContent.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }      
    }
}

function iOS() {
  return [
    'iPad Simulator',
    'iPhone Simulator',
    'iPod Simulator',
    'iPad',
    'iPhone',
    'iPod'
  ].includes(navigator.platform)
  // iPad on iOS 13 detection
  || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
} 

function mapResizer(maps) {
    if (!maps) {maps = document.getElementsByTagName('map');}
    for (const map of maps) {
        map.img = document.querySelectorAll(`[usemap="#${map.name}"]`)[0];
        map.areas = map.getElementsByTagName('area');
        for (const area of map.areas) {
            area.coordArr = area.coords.split(',');
        }
    }
    function resizeMaps() {
        for (const map of maps) {
            const scale = map.img.offsetWidth / (map.img.naturalWidth || map.img.width);
            for (const area of map.areas) {
                area.coords = area.coordArr.map(coord => Math.round(coord * scale)).join(',');
            }
        }
    }
    window.addEventListener('resize', () => resizeMaps());
    resizeMaps();
}
if (document.readyState == 'complete') {
    mapResizer();
} else {
    window.addEventListener('load', () => mapResizer());
}

bREADY = true;
</script>