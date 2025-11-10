<?php 
//header('Content-Type: application/javascript');
?><script>
var bREADY = false;
var arin_country = '<?php echo $arin_country; ?>';
const dw3_section = JSON.parse('[<?php echo $dw3_section; ?>]');
var dw3_section_displayed = 0;
var dw3_section_loaded = 0;
var dw3_body = document.getElementById("dw3_body");
var KEY = '<?php echo $KEY; ?>';
var COOKIE_OK = '<?php if(isset($_COOKIE["COOKIES"])) { echo $_COOKIE["COOKIES"]; }  else {echo "no";} ?>';
var USER_LANG = '<?php if(isset($_COOKIE["LANG"])) { echo $_COOKIE["LANG"]; } else if ($USER_LANG != "") { echo $USER_LANG; } else { echo $INDEX_LANG; } ?>';
var USER_NAME = '<?php echo $USER_NAME; ?>';
var cookie_msg = "<?php if($USER_LANG == "FR"){echo $CIE_COOKIE_MSG;}else{echo $CIE_COOKIE_MSG_EN;} ?>";
var CART = <?php if(isset($_COOKIE["CART"])) { echo $_COOKIE["CART"]; }  else {echo "[]";} ?>;
var INDEX_HEADER = "<?php echo $SECTION_HEADER; ?>";
var INDEX_BLOCK_DEBUG = "<?php echo $INDEX_BLOCK_DEBUG; ?>";
var is_section_historic = false;
var is_section_realisation = false;
var timelines ;
var CounterVal1 = "<?php echo $COUNTER1_VAL??0; ?>";
var CounterVal2 = "<?php echo $COUNTER2_VAL??0; ?>";
var CounterVal3 = "<?php echo $COUNTER3_VAL??0; ?>";
var CounterVisitors = "<?php echo $INDEX_VISITED??0; ?>";
var CounterReady = true;

if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
    window.scrollTo({top: 0, behavior: 'smooth'});
    checkSectionsView();
}

//addLoadEvent(dw3_html_load());
/* $(window).resize(function(){
    setTimeout(setSubMenusPos, 2000);
    init_realisation();
}); */

var dw3_sticky = document.getElementById("dw3_head").offsetTop;
/* window.onhashchange = function() {
    if (bREADY == true) {
        window.scrollTo({top: 0, behavior: 'smooth'});
        checkSectionsView();
    }
} */
reset_menu_top();
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
if (INDEX_HEADER == "/pub/section/header6.php"){
    document.getElementById("dw3_head").style.position = "relative";
} else {
    document.getElementById("dw3_head").classList.add("sticky");
}
var dw3_scrolled_down = false;
document.onscroll = function(){
    if (bREADY == true) {
        checkSectionsView();
    } else {
        return false;
    }
    if (window.scrollY > dw3_sticky && dw3_scrolled_down == false) {
        dw3_scrolled_down = true;
        document.getElementById("dw3_scroll_top").style.right = "5px";
        if (INDEX_HEADER == "/pub/section/header10.php"){
            document.getElementById("dw3_head").style.background = "#<?php echo $CIE_COLOR8??'FFF'; ?>";
            document.getElementById("dw3_head").style.backgroundImage = "linear-gradient(#<?php echo $CIE_COLOR8??'FFF'; ?> 0%, #<?php echo $CIE_COLOR8_2??'FFF'; ?> 40%)";
            document.getElementById("dw3_menu").style.top = "70px";
           // document.getElementById("dw3_menu_fade").style.top = "70px";
        }
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
        document.getElementById("dw3_scroll_top").style.right = "-145px";
        if (INDEX_HEADER == "/pub/section/header10.php"){
                document.getElementById("dw3_head").style.background = "transparent";
                document.getElementById("dw3_head").style.backgroundImage = "linear-gradient(to right, #<?php echo $CIE_COLOR8; ?> , transparent,transparent,transparent,transparent, transparent , #<?php echo $CIE_COLOR8; ?>)";
            }
        if (INDEX_HEADER == "/pub/section/header1.php" || INDEX_HEADER == "/pub/section/header5.php" || INDEX_HEADER == "/pub/section/header17.php" ){
            //document.getElementById("dw3_head").style.position = "relative";
            document.getElementById("dw3_menu").style.top = "98px";
        }
        if (INDEX_HEADER == "/pub/section/header3.php" || INDEX_HEADER == "/pub/section/header16.php" || INDEX_HEADER == "/pub/section/header20.php"){
            document.getElementById("dw3_h3_eml1").style.opacity = "1";
            document.getElementById("dw3_h3_tel1").style.opacity = "1";
            document.getElementById("dw3_head_row").style.height = "100px";
            document.getElementById("imgLOGO").style.height = "100px";
            document.getElementById("dw3_head").style.height = "100px";
            document.getElementById("dw3_head").style.maxHeight = "100px";
            //document.getElementById("dw3_menu_fade").style.top = "100px";
        } else if (INDEX_HEADER == "/pub/section/header14.php" || INDEX_HEADER == "/pub/section/header12.php" || INDEX_HEADER == "/pub/section/header19.php"){
            document.getElementById("dw3_head_row").style.height = "100px";
            document.getElementById("imgLOGO").style.height = "100px";
            document.getElementById("dw3_head").style.height = "100px";
            document.getElementById("dw3_head").style.maxHeight = "100px";
           // document.getElementById("dw3_menu_fade").style.top = "100px";
        } else if (INDEX_HEADER == "/pub/section/header18.php"){
            document.getElementById("dw3_head_row").style.height = "90px";
            document.getElementById("imgLOGO").style.height = "90px";
            document.getElementById("dw3_head").style.height = "90px";
            document.getElementById("dw3_head").style.maxHeight = "90px";
            //document.getElementById("dw3_menu_fade").style.top = "90px";
        }
        reset_menu_top();
    }
};
//
function reset_menu_top(){
    if (INDEX_HEADER == "/pub/section/header0.php" || INDEX_HEADER == "/pub/section/header6.php" || INDEX_HEADER == "/pub/section/header7.php" || INDEX_HEADER == "/pub/section/header9.php" || INDEX_HEADER == "/pub/section/header10.php" || INDEX_HEADER == "/pub/section/header11.php" || INDEX_HEADER == "/pub/section/header13.php"){
        document.getElementById("dw3_menu").style.top = "69px";
    }
    if (INDEX_HEADER == "/pub/section/header18.php"){
                    document.getElementById("dw3_menu").style.top = "89px";
    }
    if (INDEX_HEADER == "/pub/section/header3.php" || INDEX_HEADER == "/pub/section/header4.php" || INDEX_HEADER == "/pub/section/header8.php" || INDEX_HEADER == "/pub/section/header12.php" || INDEX_HEADER == "/pub/section/header14.php" || INDEX_HEADER == "/pub/section/header15.php" || INDEX_HEADER == "/pub/section/header6.php" || INDEX_HEADER == "/pub/section/header17.php" || INDEX_HEADER == "/pub/section/header19.php" || INDEX_HEADER == "/pub/section/header20.php"){
        document.getElementById("dw3_menu").style.top = "99px";
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
    
    if (COOKIE_OK != "OK" && cookie_msg !=""){  
        if(USER_LANG == "FR"){
            document.getElementById("dw3_cookie_msg").innerHTML = "<div style='padding:15px 10px 0px 10px;display:inline-block;'>" + cookie_msg + "</div>"
            + "<div style='margin:3px 0px -3px 0px;text-align:center;display:inline-block;vertical-align:middle;padding:10px;'><button style='font-family:Arial;padding:10px;' class='<?php echo $LOGIN_BTN_CLASS; ?> no-effect' onclick=\"dw3_msgc_close();dw3_cookie_ok();\">Tout Accepter</button> <button style='font-family:Arial;padding:10px;' onclick='dw3_msgc_close();dw3_cookie_pref();'>Personnaliser</button>";
        } else { 
            document.getElementById("dw3_cookie_msg").innerHTML = "<div style='padding:15px 10px 0px 10px;display:inline-block;'>" + cookie_msg + "</div>"
            + "<div style='margin:3px 0px -3px 0px;text-align:center;display:inline-block;vertical-align:middle;padding:10px;'><button style='font-family:Arial;padding:10px;' class='<?php echo $LOGIN_BTN_CLASS; ?> no-effect' onclick=\"dw3_msgc_close();dw3_cookie_ok();\">Accept all</button> <button style='font-family:Arial;padding:10px;' onclick='dw3_msgc_close();dw3_cookie_pref();'>Personnalize</button>";
        } 
        document.getElementById('dw3_cookie_msg').style.height = 'auto';
        document.getElementById('dw3_cookie_msg').style.maxHeight = 'none';
    } else {
        document.getElementById('dw3_cookie_msg').style.height = '0px';
        document.getElementById('dw3_cookie_msg').style.maxHeight = '0px';
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
        setTimeout(startCounterAnim, 1000);
        setTimeout(init_historic, 2000);
        setTimeout(init_realisation, 500);
        setTimeout(setSubMenusPos, 1500);
        setTimeout(function () {
            //document.getElementById("dw3_body_load_img").style.display = "none";
            checkSectionsView();
        }, 1000);
//}
document.addEventListener('touchmove', function (event) {
  if (event.scale !== 1) { event.preventDefault(); }
}, { passive: false });


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
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
function plusCookie(prID,qtyMAX) {
    const cookies = document.cookie.split(";");
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
    }
}
function minusCookie(prID) {
    const cookies = document.cookie.split(";");
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
    }
}

function taxeVERTE_INFO() {
    if (USER_LANG == "FR"){
        dw3_msg_open("<h2>Que sont les frais environnementaux?</h2><p style='text-align:justify;font-weight:normal;'>Les frais environnementaux sont des montants recueillis pour financer l'élimination et le recyclage des produits ménagers faisant partie de la réglementation provinciale visant la gestion des déchets. <br>En payant ces frais, vous contribuez à la collecte d'articles, à leur recyclage, à leur réutilisation ou dans les cas où cela n'est pas possible, leur élimination de la façon qui respecte le plus l'environnement. Au Québec, la loi 60 indique que le prix affiché d'un article doit comprendre les frais environnementaux et les frais de reprise. <br>Sur le site "+window.location.host +", les clients du Québec pourront voir les frais environnementaux et les frais de reprise clairement indiqués dans le prix total d'un article.</p><br><br><button onclick='dw3_msg_close();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
    }else{
        dw3_msg_open("<h2>What is an environmental Fee?</h2><p style='text-align:justify;font-weight:normal;'>Sometimes called an Eco Fee, is a fee collected by manufacturers and retails to help fund recycling programs that divert potentially hazardous items, such as fire exinguishers, household cleaners, and paint, from landfills.</p><br><br><button onclick='dw3_msg_close();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
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

    if(document.getElementById(tick_id) && tick_id != ""){
        if(document.getElementById(tick_id).innerHTML == "+"){
            document.getElementById(tick_id).innerHTML = "-"
        }  else if (document.getElementById(tick_id).innerHTML == "-"){
            document.getElementById(tick_id).innerHTML = "+"
        } else if (document.getElementById(tick_id).innerHTML == "▲"){
            document.getElementById(tick_id).innerHTML = "▼"
        } else if (document.getElementById(tick_id).innerHTML == "▼"){
            document.getElementById(tick_id).innerHTML = "▲"
        } else if (document.getElementById(tick_id).innerHTML == '<span class="material-icons">arrow_right</span>'){
            document.getElementById(tick_id).innerHTML = '<span class="material-icons">arrow_drop_down</span>';
        } else if (document.getElementById(tick_id).innerHTML == '<span class="material-icons">arrow_drop_down</span>'){
            document.getElementById(tick_id).innerHTML = '<span class="material-icons">arrow_right</span>';
        }
    }
    checkSectionsView();
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


function dw3_section_insert(section_id,section_html){
    document.getElementById("dw3_section_"+section_id).innerHTML = section_html;
    var path = dw3_section[section_id]["url"].substring(0,dw3_section[section_id]["url"].lastIndexOf("/")+1);;
    var my_script = document.createElement('script');
    //my_script.setAttribute('id','section-js-'+section_id);
    my_script.setAttribute('src',path+'section.js?PID='+section_id+'&t='+Math.floor(Math.random() * 9999999));
    //my_script.setAttribute('data-section-id',section_id);
    dw3_body.appendChild(my_script);
}

function dw3_body_load(){
    return false;

    var xmlhttp = [];
    dw3_body.innerHTML = "";
    for (var section_id = 0; section_id < dw3_section.length; section_id++) {
        if (dw3_section[section_id]["target"]=="section"){
            const div_url = dw3_section[section_id]["url"];
            const div_target = dw3_section[section_id]["target"];
            const cat_list = dw3_section[section_id]["cat_list"];
            const newDiv = document.createElement("div");
            newDiv.id = "dw3_section_"+section_id;
            newDiv.classList.add('dw3_section');
            newDiv.classList.add("dw3_section_"+dw3_section[section_id]["anim"]);
            if (dw3_section[section_id]["img_display"]=='background'){
                var tmp_img_url = "/pub/upload/" + dw3_section[section_id]["img_url"] ;
                newDiv.style.backgroundImage="url('" + tmp_img_url + "')"; 
                newDiv.style.backgroundPosition = "center";
                newDiv.style.backgroundSize = "cover"; 
                newDiv.style.backgroundRepeat = "no-repeat"; 
                newDiv.style.backgroundAttachment = "fixed"; 
            } else if (dw3_section[section_id]["img_display"]=='background2'){
                var tmp_img_url = "/pub/upload/" + dw3_section[section_id]["img_url"] ;
                newDiv.style.backgroundImage="url('" + tmp_img_url + "')"; 
                newDiv.style.backgroundPosition = "center";
                newDiv.style.backgroundSize = "cover"; 
                newDiv.style.backgroundRepeat = "no-repeat"; 
                newDiv.style.backgroundAttachment = "scroll"; 
            }
            //newDiv.style.opacity = dw3_section[section_id]["opacity"]; 
            //newDiv.style.maxWidth = dw3_section[section_id]["max_width"]; 
            //newDiv.style.borderRadius = dw3_section[section_id]["border_radius"]; 
            //newDiv.style.margin = dw3_section[section_id]["margin"]; 
            if (dw3_section[section_id]["url"] == "/pub/section/slideshow2/index.php" || dw3_section[section_id]["url"] == "/pub/section/slideshow3/index.php"){
                newDiv.style.width = "auto"; 
            }
            dw3_body.appendChild(newDiv);
            if (dw3_section[section_id]["url"] != "/pub/section/slideshow2/index.php" && dw3_section[section_id]["url"] != "/pub/section/slideshow3/index.php"){
                const newDiv2 = document.createElement("div");
                newDiv2.style.maxHeight="0px";
                newDiv2.style.height="0px";
                newDiv2.style.display="block";
                dw3_body.appendChild(newDiv2);
            }
            if (div_url.substr(0,21)=="/pub/section/historic"){
                is_section_historic = true;
            }
            if (div_url.substr(0,24)=="/pub/section/realisation"){
                is_section_realisation = true;
            }
            //newDiv.style.marginBottom = "-6px"; 
            if (div_url.substr(0,1)!="/"){
                newDiv.innerHTML = "<iframe style='text-align:center;width:100%;height:90vh;border:0px;margin:0px;padding:0px;' src='"+div_url+"'></iframe>";
            } else if(div_url.slice(-5).toLowerCase()==".html") {
                newDiv.innerHTML = "<iframe style='text-align:center;width:100%;height:90vh;border:0px;margin:0px;padding:0px;' src='"+div_url+"'></iframe>";
            } else {
                //xmlhttp[section_id].open('GET', div_url+"?DS="+div_target+"&P1="+cat_list, true);
                xmlhttp[section_id] = new XMLHttpRequest();
/*             xmlhttp[section_id].onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var returned_id = this.getResponseHeader('SECTION_ID');
                if (returned_id != undefined){
                    dw3_section_insert(returned_id,this.response);
                }
            }
            }; */

                xmlhttp[section_id].open('GET', div_url+"?DS="+div_target+"&P1="+cat_list+"&SID="+dw3_section[section_id]["id"]+"&IID="+section_id, true);
                xmlhttp[section_id].onloadend = function() {
                    dw3_section_loaded++;
                    if (dw3_section_loaded >= dw3_section_displayed){
                        //document.getElementById("dw3_body_load_img").style.height = "0vh";
                        setTimeout(function () {
                            //document.getElementById("dw3_body_load_img").style.display = "none";
                            checkSectionsView();
                        }, 1000);
                    }
                    if(this.status == 404) {
                        //throw new Error(url + ' replied 404');
                        console.log ("Error 404 - " + div_url);
                    } else if (this.status == 200) {
                        var returned_id = this.getResponseHeader('SECTION_ID');
                        //var returned_in = this.getResponseHeader('SECTION_IN');
                        //if (returned_id != undefined && returned_id != ""){
                            //dw3_section_insert(returned_id,this.response);
                        //} else {
                            const urlParams = new URLSearchParams(this.responseURL);
                            const iid = urlParams.get('IID'); 
                            dw3_section_insert(iid,this.response);
                        //} 
                        /* else {
                            for (var section_id = 0; section_id < dw3_section.length; section_id++) {
                                if (dw3_section[section_id]["url"]==this.responseURL){
                                    dw3_section_insert(section_id,"<iframe>"+this.response);
                                    break;
                                }
                            }
                        } */
                    }
                }
                xmlhttp[section_id].setRequestHeader('SECTION_ID', section_id);
                xmlhttp[section_id].setRequestHeader('SECTION_IN', dw3_section[section_id]["id"]);
                xmlhttp[section_id].send();
                dw3_section_displayed++;
            } 
        }
    }
    bREADY = true;
    checkSectionsView();
    setTimeout(startCounterAnim, 1000);
    setTimeout(init_historic, 2000);
    setTimeout(init_realisation, 500);
    setTimeout(setSubMenusPos, 1500);
    //init_realisation();
    //startCounterAnim();

    if('<?php echo $INDEX_FOOTER; ?>' == '/pub/section/footer4.php' && document.getElementById("dw3_foot4_pos")!=null){
        var body = document.body,html = document.documentElement;
        var height = Math.max( body.scrollHeight, body.offsetHeight, 
                        html.clientHeight, html.scrollHeight, html.offsetHeight );
        //alert (height);
        document.getElementById("dw3_foot4_pos").style.bottom= "-" +height + "px";
        document.getElementById("dw3_foot4_pos").style.display="inline-block";
    }
    //dw3_body.classList.add("show_body");
}

function init_historic() {
    if (is_section_historic==true){
        timelines = document.getElementsByClassName('cd-horizontal-timeline'),
            eventsMinDistance = 100;
        (timelines.length > 0) && initTimeline(timelines);
        //alert(timelines.length);
    }
}
function init_realisation() {
    if (is_section_realisation==true){
        if ( window.innerWidth > 600){
            timeline(document.querySelectorAll('.timeline2'), {
            mode: 'horizontal',
            visibleItems: 4
            });
        }else{
            timeline(document.querySelectorAll('.timeline2'), {
            mode: 'horizontal',
            visibleItems: 2
            });
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
	//sNotifCount++;
    const newDiv = document.createElement("div");
    //const newContent = document.createTextNode(String());
    //const newContent2 = document.createTextNode(" X ");
    //newDiv.style.position = "fixed";
    //newDiv.style.right = "2px";
    //newDiv.style.top = (35*sNotifCount) + "px";
    newDiv.style.background = "#EEE";
    newDiv.style.borderRadius = "5px";
    newDiv.style.color = "darkgreen";
    newDiv.style.border = "1px dotted darkgreen";
    //newDiv.style.zIndex = "3000";
    newDiv.style.transition ="all 1s";
    newDiv.style.fontWeight ="bold";
    newDiv.style.width ="auto";
    newDiv.style.textShadow ="2px 2px #DDDDDD";
    newDiv.style.padding ="0px 5px 5px 5px";
    newDiv.style.margin ="5px";
    newDiv.style.cursor ="pointer";
    newDiv.style.display ="table";
    newDiv.style.float ="right";
    newDiv.style.whiteSpace ="nowrap";
    //newContent2.style.background = "white";
    //newContent2.style.color = "darkgreen";
    //newDiv.appendChild(newContent2);
    newDiv.innerHTML = "<span style='font-size:1.1em;margin-top:-3px;font-weight:normal;color:goldenrod;vertical-align:middle;'>&#x26A0;</span> <span style='vertical-align:middle;'>&nbsp; " + text + "&nbsp; </span> <sup><span class='material-icons' style='font-size:0.8em;font-weight:normal;color:#990000'>close</span></sup>";
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
    addNotif("Le texte a été copié dans le presse-papier.");
}
function dw3_text_to_clipboard(source_text) {
    navigator.clipboard.writeText(source_text);
    addNotif("Le texte a été copié dans le presse-papier.");
}

//menu
function dw3_menu_toggle() {
  document.getElementById('dw3_menu_bars').classList.toggle("dw3_menu_bars_change");
  document.getElementById('dw3_menu').classList.toggle("dw3_menu_change");
  document.getElementById('dw3_menu_fade').classList.toggle("dw3_menu_fade_open");
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
    document.getElementById("dw3_body_fade").style.opacity = "0";
    setTimeout(() => {
        document.getElementById('dw3_editor').style.display = 'none';
        document.getElementById('dw3_body_fade').style.display = 'none';
    }, 500);
}
function dw3_editor_open() {
	document.getElementById('dw3_editor').style.display = 'inline-block';
	document.getElementById('dw3_editor').style.opacity = '1';
	document.getElementById('dw3_body_fade').style.display = 'inline-block';
    document.getElementById("dw3_body_fade").style.opacity = "0.6";
}
function dw3_cart_close() {
    document.getElementById('dw3_cart').style.opacity = '0';
    document.getElementById("dw3_body_fade").style.opacity = "0";
    setTimeout(() => {
        document.getElementById('dw3_body_fade').style.display = 'none';
        document.getElementById('dw3_cart').style.display = 'none';
    }, "500");
}
function dw3_cart_open() {
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
            xmlhttp.open('GET', '/pub/section/products/getCART.php?KEY=' + KEY , true);
            xmlhttp.send();
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
    document.getElementById("dw3_body_fade").style.opacity = "0";
    setTimeout(() => {
        document.getElementById('dw3_body_fade').style.display = 'none';
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
    document.getElementById(elmnt.id).firstChild.onmousedown = dragMouseDown;
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
//cookies
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

//product wish
function dw3_wish_toogle(id){
if (document.getElementById("dw3_wish_"+id)){
    if (document.getElementById("dw3_wish_"+id).innerHTML=="favorite"){
        dw3_wish_del(id);
    } else {
        dw3_wish_add(id);
    }
} else if (document.getElementById("dw3_wish3_"+id)){
    if (document.getElementById("dw3_wish3_"+id).innerHTML=="favorite"){
        dw3_wish_del(id);
    } else {
        dw3_wish_add(id);
    }
}
dw3_wish_count();
}
function dw3_wish_add(id){
    document.cookie = "WISH_" + id + "=1;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_notif_add("Un item a été ajouté à votre liste de souhaits.");
    if (document.getElementById("dw3_wish_"+id)){
        document.getElementById("dw3_wish_"+id).innerHTML= "favorite";   
    }
    if (document.getElementById("dw3_wish3_"+id)){
        document.getElementById("dw3_wish3_"+id).innerHTML= "favorite";   
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
                document.getElementById("dw3_wish_"+prID).innerHTML= "favorite_border";
            }
            if (document.getElementById("dw3_wish3_"+prID)){
                document.getElementById("dw3_wish3_"+prID).innerHTML= "favorite_border";
            }
            dw3_notif_add("Un item a été retiré à votre liste de souhaits.");
        }
    }
    dw3_wish_count();
}
function deleteOneWish(id){
    document.cookie = "WISH_" + id + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_wish_count();
    dw3_notif_add("Un item a été retiré de votre liste de favoris.");
    dw3_wish_open();
    if (document.getElementById("dw3_wish_"+id)){
        document.getElementById("dw3_wish_"+id).innerHTML= "favorite_border";
    }
    if (document.getElementById("dw3_wish3_"+id)){
        document.getElementById("dw3_wish3_"+id).innerHTML= "favorite_border";
    }
}


//market wish
function dw3_wish2_toogle(id){
 if (document.getElementById("dw3_wish2_"+id).innerHTML=="favorite"){
    dw3_wish2_del(id);
 } else {
    dw3_wish2_add(id);
 }
 dw3_wish_count();
}
function dw3_wish2_add(id){
    document.cookie = "WISH2_" + id + "=1;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_notif_add("Un item a été ajouté à votre liste de souhaits.");
    document.getElementById("dw3_wish2_"+id).innerHTML= "favorite";
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
            document.getElementById("dw3_wish2_"+prID).innerHTML= "favorite_border";
            dw3_notif_add("Un item a été retiré à votre liste de souhaits.");
        }
    }
    dw3_wish_count();
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
        dw3_msg_open("<button class='dw3_form_close no-effect' onclick='dw3_msg_close();'><span class='material-icons'>cancel</span></button><b>Rechercher dans les produits et services</b></br><div style='max-width:400px;display:inline-block;margin:15px 0px 10px 0px;display:flex'><input style='background:#fff;color:#333;' type='search' class='inputRECH' placeholder='Rechercher' id='header_search_bar' onkeyup='if (event.keyCode == 13){dw3_search_prod();}'><button onclick='dw3_search_prod()' class='no-effect'><span class='material-icons' style='vertical-align:middle;font-size:1.7em;'>search</span></button></div>"
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
        dw3_msg_open("<button class='dw3_form_close no-effect' onclick='dw3_msg_close();'><span class='material-icons'>cancel</span></button><b>Search in products and services</b><br><div style='max-width:400px;display:inline-block;margin:15px 0px 10px 0px;display:flex'><input style='background:#fff;color:#333;' type='search' class='inputRECH' placeholder='Search' id='header_search_bar' onkeyup='if (event.keyCode == 13){dw3_search_prod();}'><button onclick='dw3_search_prod()' class='no-effect'><span class='material-icons' style='vertical-align:middle;font-size:1.7em;'>search</span></button></div>"
        +"<select id='header_cat_bar' class='like_search'><option value='all'>All categories</option>"
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
    dw3_notif_add("Un item a été retiré de votre panier.");
    dw3_cart_open();
}
function deleteOneWish2(id){
    document.cookie = "WISH2_" + id + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_wish_count();
    dw3_notif_add("Un item a été retiré de votre liste de favoris.");
    dw3_wish_open();
}

//cart
function dw3_cart_count(){
    var cookies = dw3_cookies_get_all();
    var counter = 0;
    for(var name in cookies) {
        if(name.slice(0, 5) == "CART_" && cookies[name] != "0" || name.slice(0, 3) == "AD_" && cookies[name] != "0"){counter++;}
    }
    if (document.getElementById("dw3_cart_qty")){
        document.getElementById("dw3_cart_qty").innerHTML= counter;
    }
    if (document.getElementById("dw3_cart2_qty")){
        document.getElementById("dw3_cart2_qty").innerHTML= counter;
    }
}
function dw3_cart_add(id){
    document.cookie = "CART_" + id + "=1;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_cart_count();
    dw3_notif_add("Un item a été ajouté à votre panier.");
}

function buyAD(id){
    document.cookie = "AD_" + id + "=1;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_cart_count();
    dw3_notif_add("Un item a été ajouté à votre panier.");
    //dw3_msg_open("<div style='margin:10px 0px 10px 0px;'>Pour completer l'achat, vous serez redirigé vers la page de connexion</div><br> <button class='no-effect' onclick='dw3_msg_close();' style='padding:2px;position:absolute;top:0px;right:0px;'><span class='material-icons' style='vertical-align:middle;'>cancel</span></button> <button onclick=\"window.open('/client','_self');\">Continuer <span class='material-icons' style='vertical-align:middle;'>login</span></button>");
}

function deleteOneCookie(id){
    document.cookie = "CART_" + id + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_cart_count();
    dw3_notif_add("Un item a été retiré de votre panier.");
    dw3_cart_open();
}



//downloads
var dw3_cancel_download = false;
function dw3_download(product_id,file_url,that_button) {
    var button_before_html = that_button.innerHTML;
    that_button.disabled = true;
    document.getElementById("dw3_body_fade").style.opacity = "0.6";
    document.getElementById("dw3_body_fade").style.display = "inline-block";        
    document.getElementById("dw3_msg").style.display = "inline-block";
    document.getElementById("dw3_msg").innerHTML = "<span class='material-icons'>system_update_alt</span><br><div id='dw3_download_msg' style='width:300px;'></div><br><br><button style='background:#444;color:#EEE;' onclick='dw3_msg_close();dw3_cancel_download=true;'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Cancel</button>";

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
        that_button.innerHTML ='<span class="material-icons">download_done</span> Done';
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
            that_button.innerHTML ='<span class="material-icons">file_download_off</span> Canceled';
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
            dw3_msg_open("Le coupon a été validé et sera appliqué sur votre commande.<br><br><button onclick=\"dw3_msg_close();dw3_cart_open();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok merci!</button>");
            //dw3_cart_open();
        } else {
            dw3_msg_open(this.responseText + "<br><br><button onclick=\"dw3_msg_close();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
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
/* $(document).ready(function (){
    startCounterAnim();
}); */

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

//HISTORIC
function initTimeline() {
    var timelinez = jQuery('.cd-horizontal-timeline');
    //var timelinez = document.getElementsByClassName("cd-horizontal-timeline");
		timelinez.each(function(){
			var timeline = jQuery(this),
				timelineComponents = {};
			//cache timeline components 
			timelineComponents['timelineWrapper'] = timeline.find('.events-wrapper');
			timelineComponents['eventsWrapper'] = timelineComponents['timelineWrapper'].children('.events');
			timelineComponents['fillingLine'] = timelineComponents['eventsWrapper'].children('.filling-line');
			timelineComponents['timelineEvents'] = timelineComponents['eventsWrapper'].find('a');
			timelineComponents['timelineDates'] = parseDate(timelineComponents['timelineEvents']);
			timelineComponents['eventsMinLapse'] = minLapse(timelineComponents['timelineDates']);
			timelineComponents['timelineNavigation'] = timeline.find('.cd-timeline-navigation');
			timelineComponents['eventsContent'] = timeline.children('.events-content');

			//assign a left postion to the single events along the timeline
			setDatePosition(timelineComponents, eventsMinDistance);
			//assign a width to the timeline
			var timelineTotWidth = setTimelineWidth(timelineComponents, eventsMinDistance);
			//the timeline has been initialize - show it
			timeline.addClass('loaded');

			//detect click on the next arrow
			timelineComponents['timelineNavigation'].on('click', '.next', function(event){
				event.preventDefault();
				updateSlide(timelineComponents, timelineTotWidth, 'next');
			});
			//detect click on the prev arrow
			timelineComponents['timelineNavigation'].on('click', '.prev', function(event){
				event.preventDefault();
				updateSlide(timelineComponents, timelineTotWidth, 'prev');
			});
			//detect click on the a single event - show new event content
			timelineComponents['eventsWrapper'].on('click', 'a', function(event){
				event.preventDefault();
				timelineComponents['timelineEvents'].removeClass('selected');
				jQuery(this).addClass('selected');
				updateOlderEvents(jQuery(this));
				updateFilling(jQuery(this), timelineComponents['fillingLine'], timelineTotWidth);
				updateVisibleContent(jQuery(this), timelineComponents['eventsContent']);
			});

			//on swipe, show next/prev event content
			timelineComponents['eventsContent'].on('swipeleft', function(){
				var mq = checkMQ();
				( mq == 'mobile' ) && showNewContent(timelineComponents, timelineTotWidth, 'next');
			});
			timelineComponents['eventsContent'].on('swiperight', function(){
				var mq = checkMQ();
				( mq == 'mobile' ) && showNewContent(timelineComponents, timelineTotWidth, 'prev');
			});

			//keyboard navigation
			jQuery(document).keyup(function(event){
				if(event.which=='37' && elementInViewport(timeline.get(0)) ) {
					showNewContent(timelineComponents, timelineTotWidth, 'prev');
				} else if( event.which=='39' && elementInViewport(timeline.get(0))) {
					showNewContent(timelineComponents, timelineTotWidth, 'next');
				}
			});
		});
}

function updateSlide(timelineComponents, timelineTotWidth, string) {
    //retrieve translateX value of timelineComponents['eventsWrapper']
    var translateValue = getTranslateValue(timelineComponents['eventsWrapper']),
        wrapperWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', ''));
    //translate the timeline to the left('next')/right('prev') 
    (string == 'next') 
        ? translateTimeline(timelineComponents, translateValue - wrapperWidth + eventsMinDistance, wrapperWidth - timelineTotWidth)
        : translateTimeline(timelineComponents, translateValue + wrapperWidth - eventsMinDistance);
}

function showNewContent(timelineComponents, timelineTotWidth, string) {
    //go from one event to the next/previous one
    var visibleContent =  timelineComponents['eventsContent'].find('.selected'),
        newContent = ( string == 'next' ) ? visibleContent.next() : visibleContent.prev();

    if ( newContent.length > 0 ) { //if there's a next/prev event - show it
        var selectedDate = timelineComponents['eventsWrapper'].find('.selected'),
            newEvent = ( string == 'next' ) ? selectedDate.parent('li').next('li').children('a') : selectedDate.parent('li').prev('li').children('a');
        
        updateFilling(newEvent, timelineComponents['fillingLine'], timelineTotWidth);
        updateVisibleContent(newEvent, timelineComponents['eventsContent']);
        newEvent.addClass('selected');
        selectedDate.removeClass('selected');
        updateOlderEvents(newEvent);
        updateTimelinePosition(string, newEvent, timelineComponents, timelineTotWidth);
    }
}

function updateTimelinePosition(string, event, timelineComponents, timelineTotWidth) {
    //translate timeline to the left/right according to the position of the selected event
    var eventStyle = window.getComputedStyle(event.get(0), null),
        eventLeft = Number(eventStyle.getPropertyValue("left").replace('px', '')),
        timelineWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', '')),
        timelineTotWidth = Number(timelineComponents['eventsWrapper'].css('width').replace('px', ''));
    var timelineTranslate = getTranslateValue(timelineComponents['eventsWrapper']);

    if( (string == 'next' && eventLeft > timelineWidth - timelineTranslate) || (string == 'prev' && eventLeft < - timelineTranslate) ) {
        translateTimeline(timelineComponents, - eventLeft + timelineWidth/2, timelineWidth - timelineTotWidth);
    }
}

function translateTimeline(timelineComponents, value, totWidth) {
    var eventsWrapper = timelineComponents['eventsWrapper'].get(0);
    value = (value > 0) ? 0 : value; //only negative translate value
    value = ( !(typeof totWidth === 'undefined') &&  value < totWidth ) ? totWidth : value; //do not translate more than timeline width
    setTransformValue(eventsWrapper, 'translateX', value+'px');
    //update navigation arrows visibility
    (value == 0 ) ? timelineComponents['timelineNavigation'].find('.prev').addClass('inactive') : timelineComponents['timelineNavigation'].find('.prev').removeClass('inactive');
    (value == totWidth ) ? timelineComponents['timelineNavigation'].find('.next').addClass('inactive') : timelineComponents['timelineNavigation'].find('.next').removeClass('inactive');
}

function updateFilling(selectedEvent, filling, totWidth) {
    //change .filling-line length according to the selected event
    var eventStyle = window.getComputedStyle(selectedEvent.get(0), null),
        eventLeft = eventStyle.getPropertyValue("left"),
        eventWidth = eventStyle.getPropertyValue("width");
    eventLeft = (Number(eventLeft.replace('px', '')) + Number(eventWidth.replace('px', ''))/2);
    var scaleValue = eventLeft/totWidth;
    setTransformValue(filling.get(0), 'scaleX', scaleValue);
}

function setDatePosition(timelineComponents, min) {
    for (i = 0; i < timelineComponents['timelineDates'].length; i++) { 
        var distance = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][i]),
            distanceNorm = Math.round(distance/timelineComponents['eventsMinLapse']) + 2;
        timelineComponents['timelineEvents'].eq(i).css('left', (distanceNorm*min)-100+'px');
    }
}

function setTimelineWidth(timelineComponents, width) {
    var timeSpan = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][timelineComponents['timelineDates'].length-1]),
        timeSpanNorm = timeSpan/timelineComponents['eventsMinLapse'],
        timeSpanNorm = Math.round(timeSpanNorm) + 4,
        totalWidth = timeSpanNorm*width;
    timelineComponents['eventsWrapper'].css('width', totalWidth+'px');
    updateFilling(timelineComponents['timelineEvents'].eq(0), timelineComponents['fillingLine'], totalWidth);

    return totalWidth;
}

function updateVisibleContent(event, eventsContent) {
    var eventDate = event.data('date'),
        visibleContent = eventsContent.find('.selected'),
        selectedContent = eventsContent.find('[data-date="'+ eventDate +'"]'),
        selectedContentHeight = selectedContent.height();

    if (selectedContent.index() > visibleContent.index()) {
        var classEnetering = 'selected enter-right',
            classLeaving = 'leave-left';
    } else {
        var classEnetering = 'selected enter-left',
            classLeaving = 'leave-right';
    }

    selectedContent.attr('class', classEnetering);
    visibleContent.attr('class', classLeaving).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
        visibleContent.removeClass('leave-right leave-left');
        selectedContent.removeClass('enter-left enter-right');
    });
    eventsContent.css('height', selectedContentHeight+'px');
}

function updateOlderEvents(event) {
    event.parent('li').prevAll('li').children('a').addClass('older-event').end().end().nextAll('li').children('a').removeClass('older-event');
}

function getTranslateValue(timeline) {
    var timelineStyle = window.getComputedStyle(timeline.get(0), null),
        timelineTranslate = timelineStyle.getPropertyValue("-webkit-transform") ||
            timelineStyle.getPropertyValue("-moz-transform") ||
            timelineStyle.getPropertyValue("-ms-transform") ||
            timelineStyle.getPropertyValue("-o-transform") ||
            timelineStyle.getPropertyValue("transform");

    if( timelineTranslate.indexOf('(') >=0 ) {
        var timelineTranslate = timelineTranslate.split('(')[1];
        timelineTranslate = timelineTranslate.split(')')[0];
        timelineTranslate = timelineTranslate.split(',');
        var translateValue = timelineTranslate[4];
    } else {
        var translateValue = 0;
    }

    return Number(translateValue);
}

function setTransformValue(element, property, value) {
    element.style["-webkit-transform"] = property+"("+value+")";
    element.style["-moz-transform"] = property+"("+value+")";
    element.style["-ms-transform"] = property+"("+value+")";
    element.style["-o-transform"] = property+"("+value+")";
    element.style["transform"] = property+"("+value+")";
}

//based on http://stackoverflow.com/questions/542938/how-do-i-get-the-number-of-days-between-two-dates-in-javascript
function parseDate(events) {
    var dateArrays = [];
    events.each(function(){
        var dateComp = jQuery(this).data('date').split('/'),
            newDate = new Date(dateComp[2], dateComp[1]-1, dateComp[0]);
        dateArrays.push(newDate);
    });
    return dateArrays;
}

function parseDate2(events) {
    var dateArrays = [];
    events.each(function(){
        var singleDate = jQuery(this),
            dateComp = singleDate.data('date').split('T');
        if( dateComp.length > 1 ) { //both DD/MM/YEAR and time are provided
            var dayComp = dateComp[0].split('/'),
                timeComp = dateComp[1].split(':');
        } else if( dateComp[0].indexOf(':') >=0 ) { //only time is provide
            var dayComp = ["2000", "0", "0"],
                timeComp = dateComp[0].split(':');
        } else { //only DD/MM/YEAR
            var dayComp = dateComp[0].split('/'),
                timeComp = ["0", "0"];
        }
        var	newDate = new Date(dayComp[2], dayComp[1]-1, dayComp[0], timeComp[0], timeComp[1]);
        dateArrays.push(newDate);
    });
    return dateArrays;
}

function daydiff(first, second) {
    return Math.round((second-first));
}

function minLapse(dates) {
    //determine the minimum distance among events
    var dateDistances = [];
    for (i = 1; i < dates.length; i++) { 
        var distance = daydiff(dates[i-1], dates[i]);
        dateDistances.push(distance);
    }
    return Math.min.apply(null, dateDistances);
}

/*
    How to tell if a DOM element is visible in the current viewport?
    http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
*/
function elementInViewport(el) {
    var top = el.offsetTop;
    var left = el.offsetLeft;
    var width = el.offsetWidth;
    var height = el.offsetHeight;

    while(el.offsetParent) {
        el = el.offsetParent;
        top += el.offsetTop;
        left += el.offsetLeft;
    }

    return (
        top < (window.pageYOffset + window.innerHeight) &&
        left < (window.pageXOffset + window.innerWidth) &&
        (top + height) > window.pageYOffset &&
        (left + width) > window.pageXOffset
    );
}

function checkMQ() {
    //check if mobile or desktop device
    return window.getComputedStyle(document.querySelector('.cd-horizontal-timeline'), '::before').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
}

//timeline2 //Realisation
function timeline(collection, options) {
    const timelines = [];
    const warningLabel = 'Timeline:';
    let winWidth = window.innerWidth;
    let resizeTimer;
    let currentIndex = 0;
    // Set default settings
    const defaultSettings = {
      forceVerticalMode: {
        type: 'integer',
        defaultValue: 600
      },
      horizontalStartPosition: {
        type: 'string',
        acceptedValues: ['bottom', 'top'],
        defaultValue: 'top'
      },
      mode: {
        type: 'string',
        acceptedValues: ['horizontal', 'vertical'],
        defaultValue: 'vertical'
      },
      moveItems: {
        type: 'integer',
        defaultValue: 1
      },
      rtlMode: {
        type: 'boolean',
        acceptedValues: [true, false],
        defaultValue: false
      },
      startIndex: {
        type: 'integer',
        defaultValue: 0
      },
      verticalStartPosition: {
        type: 'string',
        acceptedValues: ['left', 'right'],
        defaultValue: 'left'
      },
      verticalTrigger: {
        type: 'string',
        defaultValue: '15%'
      },
      visibleItems: {
        type: 'integer',
        defaultValue: 3
      }
    };
  
    // Helper function to test whether values are an integer
    function testValues(value, settingName) {
      if (typeof value !== 'number' && value % 1 !== 0) {
        console.warn(`${warningLabel} The value "${value}" entered for the setting "${settingName}" is not an integer.`);
        return false;
      }
      return true;
    }
  
    // Helper function to wrap an element in another HTML element
    function itemWrap(el, wrapper, classes) {
      wrapper.classList.add(classes);
      el.parentNode.insertBefore(wrapper, el);
      wrapper.appendChild(el);
    }
  
    // Helper function to wrap each element in a group with other HTML elements
    function wrapElements(items) {
      items.forEach((item) => {
        itemWrap(item.querySelector('.timeline__content'), document.createElement('div'), 'timeline__content__wrap');
        itemWrap(item.querySelector('.timeline__content__wrap'), document.createElement('div'), 'timeline__item__inner');
      });
    }
  
    // Helper function to check if an element is partially in the viewport
    function isElementInViewport(el, triggerPosition) {
      const rect = el.getBoundingClientRect();
      const windowHeight = window.innerHeight || document.documentElement.clientHeight;
      const defaultTrigger = defaultSettings.verticalTrigger.defaultValue.match(/(\d*\.?\d*)(.*)/);
      let triggerUnit = triggerPosition.unit;
      let triggerValue = triggerPosition.value;
      let trigger = windowHeight;
      if (triggerUnit === 'px' && triggerValue >= windowHeight) {
        console.warn('The value entered for the setting "verticalTrigger" is larger than the window height. The default value will be used instead.');
        [, triggerValue, triggerUnit] = defaultTrigger;
      }
      if (triggerUnit === 'px') {
        trigger = parseInt(trigger - triggerValue, 10);
      } else if (triggerUnit === '%') {
        trigger = parseInt(trigger * ((100 - triggerValue) / 100), 10);
      }
      return (
        rect.top <= trigger
        && rect.left <= (window.innerWidth || document.documentElement.clientWidth)
        && (rect.top + rect.height) >= 0
        && (rect.left + rect.width) >= 0
      );
    }
  
    // Helper function to add transform styles
    function addTransforms(el, transform) {
      el.style.webkitTransform = transform;
      el.style.msTransform = transform;
      el.style.transform = transform;
    }
  
    // Create timelines
    function createTimelines(timelineEl) {
      const timelineName = timelineEl.id ? `#${timelineEl.id}` : `.${timelineEl.className}`;
      const errorPart = 'could not be found as a direct descendant of';
      const data = timelineEl.dataset;
      let wrap;
      let scroller;
      let items;
      const settings = {};
  
      // Test for correct HTML structure
      try {
        wrap = timelineEl.querySelector('.timeline__wrap');
        if (!wrap) {
          throw new Error(`${warningLabel} .timeline__wrap ${errorPart} ${timelineName}`);
        } else {
          scroller = wrap.querySelector('.timeline__items');
          if (!scroller) {
            throw new Error(`${warningLabel} .timeline__items ${errorPart} .timeline__wrap`);
          } else {
            items = [].slice.call(scroller.children, 0);
          }
        }
      } catch (e) {
        console.warn(e.message);
        return false;
      }
  
      // Test setting input values
      Object.keys(defaultSettings).forEach((key) => {
        settings[key] = defaultSettings[key].defaultValue;
  
        if (data[key]) {
          settings[key] = data[key];
        } else if (options && options[key]) {
          settings[key] = options[key];
        }
  
        if (defaultSettings[key].type === 'integer') {
          if (!settings[key] || !testValues(settings[key], key)) {
            settings[key] = defaultSettings[key].defaultValue;
          }
        } else if (defaultSettings[key].type === 'string') {
          if (defaultSettings[key].acceptedValues && defaultSettings[key].acceptedValues.indexOf(settings[key]) === -1) {
            console.warn(`${warningLabel} The value "${settings[key]}" entered for the setting "${key}" was not recognised.`);
            settings[key] = defaultSettings[key].defaultValue;
          }
        }
      });
  
      // Further specific testing of input values
      const defaultTrigger = defaultSettings.verticalTrigger.defaultValue.match(/(\d*\.?\d*)(.*)/);
      const triggerArray = settings.verticalTrigger.match(/(\d*\.?\d*)(.*)/);
      let [, triggerValue, triggerUnit] = triggerArray;
      let triggerValid = true;
      if (!triggerValue) {
        console.warn(`${warningLabel} No numercial value entered for the 'verticalTrigger' setting.`);
        triggerValid = false;
      }
      if (triggerUnit !== 'px' && triggerUnit !== '%') {
        console.warn(`${warningLabel} The setting 'verticalTrigger' must be a percentage or pixel value.`);
        triggerValid = false;
      }
      if (triggerUnit === '%' && (triggerValue > 100 || triggerValue < 0)) {
        console.warn(`${warningLabel} The 'verticalTrigger' setting value must be between 0 and 100 if using a percentage value.`);
        triggerValid = false;
      } else if (triggerUnit === 'px' && triggerValue < 0) {
        console.warn(`${warningLabel} The 'verticalTrigger' setting value must be above 0 if using a pixel value.`);
        triggerValid = false;
      }
  
      if (triggerValid === false) {
        [, triggerValue, triggerUnit] = defaultTrigger;
      }
  
      settings.verticalTrigger = {
        unit: triggerUnit,
        value: triggerValue
      };
  
      if (settings.moveItems > settings.visibleItems) {
        console.warn(`${warningLabel} The value of "moveItems" (${settings.moveItems}) is larger than the number of "visibleItems" (${settings.visibleItems}). The value of "visibleItems" has been used instead.`);
        settings.moveItems = settings.visibleItems;
      }
  
      if (settings.startIndex > (items.length - settings.visibleItems) && items.length > settings.visibleItems) {
        console.warn(`${warningLabel} The 'startIndex' setting must be between 0 and ${items.length - settings.visibleItems} for this timeline. The value of ${items.length - settings.visibleItems} has been used instead.`);
        settings.startIndex = items.length - settings.visibleItems;
      } else if (items.length <= settings.visibleItems) {
        console.warn(`${warningLabel} The number of items in the timeline must exceed the number of visible items to use the 'startIndex' option.`);
        settings.startIndex = 0;
      } else if (settings.startIndex < 0) {
        console.warn(`${warningLabel} The 'startIndex' setting must be between 0 and ${items.length - settings.visibleItems} for this timeline. The value of 0 has been used instead.`);
        settings.startIndex = 0;
      }
  
      timelines.push({
        timelineEl,
        wrap,
        scroller,
        items,
        settings
      });
    }
  
    if (collection.length) {
      [].forEach.call(collection, createTimelines);
    }
  
    // Set height and widths of timeline elements and viewport
    function setHeightandWidths(tl) {
      // Set widths of items and viewport
      function setWidths() {
        tl.itemWidth = tl.wrap.offsetWidth / tl.settings.visibleItems;
        tl.items.forEach((item) => {
          item.style.width = `${tl.itemWidth}px`;
        });
        tl.scrollerWidth = tl.itemWidth * tl.items.length;
        tl.scroller.style.width = `${tl.scrollerWidth}px`;
      }
  
      // Set height of items and viewport
      function setHeights() {
        let oddIndexTallest = 0;
        let evenIndexTallest = 0;
        tl.items.forEach((item, i) => {
          item.style.height = 'auto';
          const height = item.offsetHeight;
          if (i % 2 === 0) {
            evenIndexTallest = height > evenIndexTallest ? height : evenIndexTallest;
          } else {
            oddIndexTallest = height > oddIndexTallest ? height : oddIndexTallest;
          }
        });
  
        const transformString = `translateY(${evenIndexTallest}px)`;
        tl.items.forEach((item, i) => {
          if (i % 2 === 0) {
            item.style.height = `${evenIndexTallest}px`;
            if (tl.settings.horizontalStartPosition === 'bottom') {
              item.classList.add('timeline__item--bottom');
              addTransforms(item, transformString);
            } else {
              item.classList.add('timeline__item--top');
            }
          } else {
            item.style.height = `${oddIndexTallest}px`;
            if (tl.settings.horizontalStartPosition !== 'bottom') {
              item.classList.add('timeline__item--bottom');
              addTransforms(item, transformString);
            } else {
              item.classList.add('timeline__item--top');
            }
          }
        });
        tl.scroller.style.height = `${evenIndexTallest + oddIndexTallest}px`;
      }
  
      //if (window.innerWidth > tl.settings.forceVerticalMode) {
        setWidths();
        //setHeights();
      //}
    }
  
    // Create and add arrow controls to horizontal timeline
    function addNavigation(tl) {
      if (tl.items.length > tl.settings.visibleItems) {
        const prevArrow = document.createElement('button');
        const nextArrow = document.createElement('button');
        const topPosition = tl.items[0].offsetHeight -20;
        prevArrow.className = 'timeline-nav-button timeline-nav-button--prev';
        nextArrow.className = 'timeline-nav-button timeline-nav-button--next';
        prevArrow.textContent = 'Previous';
        nextArrow.textContent = 'Next';
        prevArrow.style.top = `${topPosition}px`;
        nextArrow.style.top = `${topPosition}px`;
        if (currentIndex === 0) {
          prevArrow.disabled = true;
        } else if (currentIndex === (tl.items.length - tl.settings.visibleItems)) {
          nextArrow.disabled = true;
        }
        tl.timelineEl.appendChild(prevArrow);
        tl.timelineEl.appendChild(nextArrow);
      }
    }
  
    // Add the centre line to the horizontal timeline
    function addHorizontalDivider(tl) {
      const divider = tl.timelineEl.querySelector('.timeline-divider');
      if (divider) {
        tl.timelineEl.removeChild(divider);
      }
      const topPosition = tl.items[0].offsetHeight;
      const horizontalDivider = document.createElement('span');
      horizontalDivider.className = 'timeline-divider';
      horizontalDivider.style.top = `${topPosition}px`;
      tl.timelineEl.appendChild(horizontalDivider);
    }
  
    // Calculate the new position of the horizontal timeline
    function timelinePosition(tl) {
      const position = tl.items[currentIndex].offsetLeft;
      const str = `translate3d(-${position}px, 0, 0)`;
      addTransforms(tl.scroller, str);
    }
  
    // Make the horizontal timeline slide
    function slideTimeline(tl) {
      const navArrows = tl.timelineEl.querySelectorAll('.timeline-nav-button');
      const arrowPrev = tl.timelineEl.querySelector('.timeline-nav-button--prev');
      const arrowNext = tl.timelineEl.querySelector('.timeline-nav-button--next');
      const maxIndex = tl.items.length - tl.settings.visibleItems;
      const moveItems = parseInt(tl.settings.moveItems, 10);
      [].forEach.call(navArrows, (arrow) => {
        arrow.addEventListener('click', function(e) {
          e.preventDefault();
          currentIndex = this.classList.contains('timeline-nav-button--next') ? (currentIndex += moveItems) : (currentIndex -= moveItems);
          if (currentIndex === 0 || currentIndex < 0) {
            currentIndex = 0;
            arrowPrev.disabled = true;
            arrowNext.disabled = false;
          } else if (currentIndex === maxIndex || currentIndex > maxIndex) {
            currentIndex = maxIndex;
            arrowPrev.disabled = false;
            arrowNext.disabled = true;
          } else {
            arrowPrev.disabled = false;
            arrowNext.disabled = false;
          }
          timelinePosition(tl);
        });
      });
    }
  
    // Set up horizontal timeline
    function setUpHorinzontalTimeline(tl) {
      if (tl.settings.rtlMode) {
        currentIndex = tl.items.length > tl.settings.visibleItems ? tl.items.length - tl.settings.visibleItems : 0;
      } else {
        currentIndex = tl.settings.startIndex;
      }
      tl.timelineEl.classList.add('timeline--horizontal');
      setHeightandWidths(tl);
      timelinePosition(tl);
      addNavigation(tl);
      addHorizontalDivider(tl);
      slideTimeline(tl);
    }
  
    // Set up vertical timeline
    function setUpVerticalTimeline(tl) {
      let lastVisibleIndex = 0;
      tl.items.forEach((item, i) => {
        item.classList.remove('animated', 'fadeIn');
        if (!isElementInViewport(item, tl.settings.verticalTrigger) && i > 0) {
          item.classList.add('animated');
        } else {
          lastVisibleIndex = i;
        }
        const divider = tl.settings.verticalStartPosition === 'left' ? 1 : 0;
        if (i % 2 === divider && window.innerWidth > tl.settings.forceVerticalMode) {
          item.classList.add('timeline__item--right');
        } else {
          item.classList.add('timeline__item--left');
        }
      });
      for (let i = 0; i < lastVisibleIndex; i += 1) {
        tl.items[i].classList.remove('animated', 'fadeIn');
      }
      // Bring elements into view as the page is scrolled
      window.addEventListener('scroll', () => {
        tl.items.forEach((item) => {
          if (isElementInViewport(item, tl.settings.verticalTrigger)) {
            item.classList.add('fadeIn');
          }
        });
      });
    }
  
    // Reset timelines
    function resetTimelines(tl) {
      tl.timelineEl.classList.remove('timeline--horizontal', 'timeline--mobile');
      tl.scroller.removeAttribute('style');
      tl.items.forEach((item) => {
        item.removeAttribute('style');
        item.classList.remove('animated', 'fadeIn', 'timeline__item--left', 'timeline__item--right');
      });
      const navArrows = tl.timelineEl.querySelectorAll('.timeline-nav-button');
      [].forEach.call(navArrows, (arrow) => {
        arrow.parentNode.removeChild(arrow);
      });
    }
  
    // Set up the timelines
    function setUpTimelines() {
      timelines.forEach((tl) => {
        tl.timelineEl.style.opacity = 0;
        if (!tl.timelineEl.classList.contains('timeline--loaded')) {
          wrapElements(tl.items);
        }
        resetTimelines(tl);
        //if (window.innerWidth <= tl.settings.forceVerticalMode) {
          //tl.timelineEl.classList.add('timeline--mobile');
        //}
        //if (tl.settings.mode === 'horizontal' && window.innerWidth > tl.settings.forceVerticalMode) {
          setUpHorinzontalTimeline(tl);
        //} else {
        //  setUpVerticalTimeline(tl);
        //}
        tl.timelineEl.classList.add('timeline--loaded');
        setTimeout(() => {
          tl.timelineEl.style.opacity = 1;
        }, 500);
      });
    }
  
    // Initialise the timelines on the page
    setUpTimelines();
    window.addEventListener('resize', () => {
        var newWidth = window.innerWidth;
        if (newWidth !== prevWidth) {
            prevWidth = newWidth;
            setTimeout(setSubMenusPos, 1000);
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
            const newWinWidth = window.innerWidth;
            if (newWinWidth !== winWidth) {
                setUpTimelines();
                winWidth = newWinWidth;
            }
            }, 250);
            init_realisation();
        }
    });
}
var prevWidth = window.innerWidth;


window.addEventListener('resize', () => {
    setTimeout(setSubMenusPos, 1000);
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

  // Register as a jQuery plugin if the jQuery library is present
  if (window.jQuery) {
    (($) => {
      $.fn.timeline = function(opts) {
        timeline(this, opts);
        return this;
      };
    })(window.jQuery);
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
    document.getElementById(cardID).addClass("dw3_card_flip");
}
function dw3_card_to_front(cardID){
    document.getElementById(cardID).removeClass("dw3_card_flip");
}

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
bREADY = true;
</script>