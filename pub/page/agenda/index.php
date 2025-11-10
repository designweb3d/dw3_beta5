<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/js/Multiavatar.php';
 $multiavatar = new Multiavatar();
 $product_id = $_GET['PRID']??"";
 $user_service_id = $_GET['USID']??"";
 $service_location  = $_GET['L']??"";
 if ($PAGE_HEADER== '/pub/section/header0.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header1.php'){$INDEX_HEADER_HEIGHT = '120';}
 else if ($PAGE_HEADER== '/pub/section/header2.php'){$INDEX_HEADER_HEIGHT = '105';}
 else if ($PAGE_HEADER== '/pub/section/header3.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header4.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header5.php'){$INDEX_HEADER_HEIGHT = '102';}
 else if ($PAGE_HEADER== '/pub/section/header6.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header7.php'){$INDEX_HEADER_HEIGHT = '105';}
 else if ($PAGE_HEADER== '/pub/section/header8.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header9.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header10.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header11.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header12.php'){$INDEX_HEADER_HEIGHT = '82';}
 else if ($PAGE_HEADER== '/pub/section/header13.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header14.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header15.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header16.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header17.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header18.php'){$INDEX_HEADER_HEIGHT = '90';}
 else if ($PAGE_HEADER== '/pub/section/header19.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header20.php'){$INDEX_HEADER_HEIGHT = '90';}
 else if ($PAGE_HEADER== '/pub/section/header21.php'){$INDEX_HEADER_HEIGHT = '90';}
 else if ($PAGE_HEADER== '/pub/section/header22.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header23.php'){$INDEX_HEADER_HEIGHT = '70';}
 else {$INDEX_HEADER_HEIGHT='70';}
?>
	<div class='dw3_quiz_data' style='top:<?php echo $INDEX_HEADER_HEIGHT; ?>px;bottom:0px; background-color:<?php echo $PAGE_BG; ?>;'>
        <div id='cal_page0' style='position:absolute;top:0px;left:0px;bottom:0px;width:100%;transition: left 1.2s ease-in-out;overflow-x:hidden;'>
            <div class='dw3_quiz_foot'>
                <button class="no-effect" onclick="dw3_go_home();" style='float:left;padding:8px 12px 6px 12px;height:38px;'>
                    <span class='dw3_font'>ď</span> <?php if ($USER_LANG == "FR"){ echo "Annuler"; }else{echo "Cancel";}?>
                </button>	
                <button class="no-effect" onmouseup="openRDV('1','0');" style='float:right;padding:8px 12px 6px 12px;height:38px;'>
                    <span class='dw3_font'>Ĺ</span> <?php if ($USER_LANG == "FR"){ echo "Continuer"; }else{echo "Continue";}?>
                </button>
            </div>	
            <div id='dw3_schedule_local' class='dw3_page'>
                <?php
                    if ($USER_LANG == "FR"){
                        echo "<h2 style='text-align:left;padding-top:10px;'>Choisir le lieu:</h2>";	
                    } else {
                        echo "<h2 style='text-align:left;padding-top:10px;'>Choose the location:</h2>";	
                    }
                    $year = date("Y");
                    $month = date("m");
                    $day = date("d");
                    //virtual
                    $is_virtual = false;
                    $sql2 = "SELECT COUNT(*) as is_virtual
                    FROM schedule_head
                    WHERE  YEAR(start_date) >= '" . $year . "' AND MONTH(end_date) >= '" . $month . "'  AND DAY(end_date) >= '" . $day . "' AND is_public = 1 AND virtual_enable = 1
                    OR YEAR(end_date) = '" . $year . "' AND MONTH(end_date) > '" . $month . "' AND is_public = 1 AND virtual_enable = 1
                    OR YEAR(end_date) > '" . $year . "' AND is_public = 1 AND virtual_enable = 1
                    ";
                        $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {	
                            while($row2 = $result2->fetch_assoc()) {
                                if ($row2["is_virtual"] > 0){
                                    $is_virtual = true;
                                }
                            }
                        }
                    //road a domicil
                    $is_road = false;
                    $sql2 = "SELECT COUNT(*) as is_road
                    FROM schedule_head
                    WHERE  YEAR(start_date) >= '" . $year . "' AND MONTH(end_date) >= '" . $month . "'  AND DAY(end_date) >= '" . $day . "' AND is_public = 1 AND road_enable = 1
                    OR YEAR(end_date) = '" . $year . "' AND MONTH(end_date) > '" . $month . "' AND is_public = 1 AND road_enable = 1
                    OR YEAR(end_date) > '" . $year . "' AND is_public = 1 AND road_enable = 1
                    ";
                        $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {	
                            while($row2 = $result2->fetch_assoc()) {
                                if ($row2["is_road"] > 0){
                                    $is_road = true;
                                }
                            }
                        }
                    //local dans nos locaux
                    $is_local = false;
                    $sql2 = "SELECT COUNT(*) as is_local
                    FROM schedule_head
                    WHERE  YEAR(start_date) >= '" . $year . "' AND MONTH(end_date) >= '" . $month . "'  AND DAY(end_date) >= '" . $day . "' AND is_public = 1 AND local_enable = 1
                    OR YEAR(end_date) = '" . $year . "' AND MONTH(end_date) > '" . $month . "' AND is_public = 1 AND local_enable = 1
                    OR YEAR(end_date) > '" . $year . "' AND is_public = 1 AND local_enable = 1
                    ";
                        $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {	
                            while($row2 = $result2->fetch_assoc()) {
                                if ($row2["is_local"] > 0){
                                    $is_local = true;
                                }
                            }
                        }
                    //par téléphone
                    $is_phone = false;
                    $sql2 = "SELECT COUNT(*) as is_phone
                    FROM schedule_head
                    WHERE  YEAR(start_date) >= '" . $year . "' AND MONTH(end_date) >= '" . $month . "'  AND DAY(end_date) >= '" . $day . "' AND is_public = 1 AND phone_enable = 1
                    OR YEAR(end_date) = '" . $year . "' AND MONTH(end_date) > '" . $month . "' AND is_public = 1 AND phone_enable = 1
                    OR YEAR(end_date) > '" . $year . "' AND is_public = 1 AND phone_enable = 1
                    ";
                        $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {	
                            while($row2 = $result2->fetch_assoc()) {
                                if ($row2["is_phone"] > 0){
                                    $is_phone = true;
                                }
                            }
                        }


                    //auto-check if not only one choice
                    if ($USER_LANG == "FR"){ 
                        if ($is_virtual == true){
                            if($is_road == false && $is_local == false && $is_phone == false){
                                echo "<div onclick=\"getServiceUser('V');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/virtual_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_V' type='radio' checked value='V'>
                                        <label for='service_type_V' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> En ligne</label>
                                    </div>";
                            } else {
                                echo "<div onclick=\"getServiceUser('V');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/virtual_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_V' type='radio' value='V'>
                                        <label for='service_type_V' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> En ligne</label>
                                    </div>";
                            }
                        }
                        if ($is_road == true){
                            if($is_local == false && $is_virtual == false && $is_phone == false){
                                echo "<div onclick=\"getServiceUser('R');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/home_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_R' type='radio' checked value='R'>
                                        <label for='service_type_R' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> À votre adresse</label>
                                   </div>";
                            } else {
                                echo "<div onclick=\"getServiceUser('R');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/home_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_R' type='radio' value='R'>
                                        <label for='service_type_R' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> À votre adresse</label>
                                    </div>";
                            }
                        }
                        if ($is_local == true){
                            if($is_road == false && $is_virtual == false && $is_phone == false){
                                echo "<div onclick=\"getServiceUser('L');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/office_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_L' type='radio' checked value='L'>
                                        <label for='service_type_L' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> Dans nos locaux</label>
                                 </div>";                            
                            } else {
                                echo "<div onclick=\"getServiceUser('L');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                     <img src='/pub/img/dw3/office_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_L' type='radio' value='L'>
                                       <label for='service_type_L' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> Dans nos locaux</label>
                                   </div>";                            
                            }
                        }
                        if ($is_phone == true){
                            if($is_road == false && $is_local == false && $is_virtual == false){
                                echo "<div onclick=\"getServiceUser('P');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/phone_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_P' type='radio' checked value='P'>
                                        <label for='service_type_P' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> Au téléphone</label>
                                    </div>";                            
                            } else {
                                echo "<div onclick=\"getServiceUser('P');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/phone_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_P' type='radio' value='P'>
                                    <label for='service_type_P' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> Au téléphone</label>
                                    </div>";                            
                            }
                        }
                    }else{
                        if ($is_virtual == true){
                            if($is_road == false && $is_local == false && $is_phone == false){
                                echo "<div onclick=\"getServiceUser('V');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/virtual_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_V' type='radio' checked value='V'>
                                        <label for='service_type_V' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> Online</label>
                                    </div>";
                            } else {
                                echo "<div onclick=\"getServiceUser('V');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/virtual_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_V' type='radio' value='V'>
                                        <label for='service_type_V' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> Online</label>
                                    </div>";
                            }
                        }
                        if ($is_road == true){
                            if($is_local == false && $is_virtual == false && $is_phone == false){
                                echo "<div onclick=\"getServiceUser('R');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/home_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_R' type='radio' checked value='R'>
                                        <label for='service_type_R' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> To your address</label>
                                    </div>";
                            } else {
                                echo "<div onclick=\"getServiceUser('R');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/home_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_R' type='radio' value='R'>
                                        <label for='service_type_R' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> To your address</label>
                                    </div>";
                            }
                        }
                        if ($is_local == true){
                            if($is_road == false && $is_virtual == false && $is_phone == false){
                                echo "<div onclick=\"getServiceUser('L');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/office_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_L' type='radio' checked value='L'>
                                        <label for='service_type_L' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> In our offices</label>
                                    </div>";                            
                            } else {
                                echo "<div onclick=\"getServiceUser('L');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/office_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_L' type='radio' value='L'>
                                        <label for='service_type_L' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> In our offices</label>
                                    </div>";                            
                            }
                        }
                        if ($is_phone == true){
                            if($is_road == false && $is_local == false && $is_virtual == false){
                                echo "<div onclick=\"getServiceUser('P');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/phone_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_P' type='radio' checked value='P'>
                                        <label for='service_type_P' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> On the phone</label>
                                    </div>";                            
                            } else {
                                echo "<div onclick=\"getServiceUser('P');\" class='dw3_box' style='cursor:pointer;width:150px;background:#fff;color:#333;vertical-align:middle;min-height:30px;margin:5px;text-align:center;'>
                                        <img src='/pub/img/dw3/phone_meeting.jpg' style='width:100%;height:auto;margin-bottom:7px;'>
                                        <input style='vertical-align:middle;cursor:pointer;' name='service_type' id='service_type_P' type='radio' value='P'>
                                        <label for='service_type_P' style='cursor:pointer;width:175px;overflow:hidden;vertical-align:middle;'> On the phone</label>
                                    </div>";                            
                            }
                        }    
                    }
                ?>
            </div><hr>
            <div id='dw3_service_user' class='dw3_page' style='scroll-margin-top: -100px;margin-bottom:100px;'></div>
        </div>
        <div id='cal_page1' style='position:absolute;top:0px;left:100%;bottom:0px;width:100%;transition: left 1.2s ease-in-out;overflow-x:hidden;'>
            <div class='dw3_quiz_foot'>
                <button class="no-effect" onmouseup="openRDV('0','1');" style='float:left;padding:8px 12px 6px 12px;height:38px;'>
                    <span class='dw3_font'>ĸ</span> <?php if ($USER_LANG == "FR"){ echo "Personel";}else{echo "Employee";} ?>
                </button>
                <button class="no-effect" onmouseup="openRDV('2','1');" style='float:right;padding:8px 12px 6px 12px;height:38px;'>
                    <span class='dw3_font'>Ĺ</span> <?php if ($USER_LANG == "FR"){ echo "Continuer";}else{echo "Continue";} ?>
                </button>
            </div>	
            <div id='divMAIN_OUTPUT' class='dw3_page'>
            </div>
        </div>
        <div id='cal_page2' style='position:absolute;top:0px;left:100%;bottom:0px;width:100%;transition: left 1.2s ease-in-out;overflow-x:hidden;'>
            <div class='dw3_quiz_foot'>
                <button class="no-effect" onmouseup="openRDV('1','2');" style='float:left;padding:8px 12px 6px 12px;height:38px;'>
                    <span class='dw3_font'>ĸ</span> Service
                </button>	
                <button class="no-effect" onmouseup="openRDV('3','2');" style='float:right;padding:8px 12px 6px 12px;height:38px;'>
                    <span class='dw3_font'>Ĺ</span> <?php if ($USER_LANG == "FR"){ echo "Continuer";}else{echo "Continue";} ?>
                </button>
            </div>	
            <div class='dw3_page'>
                <?php if ($USER_LANG == "FR"){ echo "<h2 style='text-align:left;max-width:1080px;padding-top:10px;'>Choisir la date et l'heure:</h2>";}else{echo "<h2 style='text-align:left;max-width:1080px;padding-top:10px; '>Choose the date and time:</h2>";} ?>
            </div>
            <h2><button class="no-effect" onclick='previous();'><span class='dw3_font'>ĸ</span></button> <span id='monthAndYear' style='min-width:175px;color:#EEE;text-shadow:1px 1px 4px #222;'></span><button class="no-effect" onclick='next();'><span class='dw3_font'>Ĺ</span></button></h2>
                <table id='calendar' class='tblCAL'></table>
            <div class='dw3_page' style='background-color:rgba(255,255,255,0.7);'>
                <div id='divDISPO' style='width:100%;margin:3px;'><div style='width:95%;text-align:left;'><?php if ($USER_LANG == "FR"){ echo "Non disponible";}else{echo "Not available";}?>.</div></div></div>
        </div>
        <div id='cal_page3' style='text-align:center;position:absolute;top:0px;left:100%;width:100%;bottom:0px;transition: left 1.2s ease-in-out;overflow-x:hidden;'>
            <div class='dw3_quiz_foot'>
                <button class="no-effect" onmouseup="openRDV('2','3');" style='float:left;padding:8px 12px 6px 12px;height:38px;'>
                    <span class='dw3_font'>ĸ</span> <?php if ($USER_LANG == "FR"){ echo "Date & Heure";}else{echo "Date & Time";} ?>
                </button>
                <button class="no-effect green" id='btnaddRDV' onclick='addRDV();' style='float:right;padding:8px 12px 6px 12px;height:38px;'>
                    <span class='dw3_font'>Ē</span> <?php if ($USER_LANG == "FR"){ echo "Valider";}else{echo "Validate";} ?>
                </button>
            </div>	
            <div class='dw3_page' style='text-align:middle;background-color:rgba(255,255,255,0.7);'>
                <?php if ($USER_LANG == "FR"){ echo "<h2 style='text-align:left;padding-top:10px;'>Valider le rendez-vous:</h2>";}else{echo "<h2 style='text-align:left;padding-top:10px;'>Validate the appointment:</h2>";} ?>
                <div class='dw3_paragraf' style='margin-top:20px;max-width:700px;'>
                    <table style='width:100%;border-spacing: 0px;'>
                        <tr><td width='35' style='border-bottom:1px solid #ddd;'><span style='font-size:25px;' class='dw3_font'>Ɔ</span></td>
                                <td width='*' style='border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:5px;' type='text' id='txtSUBMIT_NOM' placeHolder='Nom*' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                        <tr><td width='35' style='border-bottom:1px solid #ddd;'><span style='font-size:25px;' class='dw3_font'>q</span></td>
                                <td width='*' style='border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:5px;' type='text' id='txtSUBMIT_EMAIL' placeHolder='Courriel*' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                        <tr><td width='35' style='border-bottom:1px solid #ddd;'><span style='font-size:25px;' class='dw3_font'>N</span></td>
                                <td width='*' style='border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:5px;' type='text' id='txtSUBMIT_TEL' placeHolder='Téléphone*' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                        <tr><td colspan=2><textarea placeHolder='Note' id='txtSUBMIT_CMNT' style='padding:7px;width:100%;height:120px;border:1px solid #dfdfdf;'  onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></textarea></td></tr>
                    </table><div style='margin:0px 10px'><?php if ($USER_LANG == "FR"){ echo "En appuyant sur 'Valider', j'accepte la";}else{echo "By pressing on 'Validate', I accept the";} ?> <u><a href='/legal/PRIVACY.html' target='_blank' arial-label="Politique de confidentialité"><?php if ($USER_LANG == "FR"){ echo "politique de confidentialité</a></u> et les ";}else{echo "privacy policy</a></u>and the";} ?><u><a href='/legal/CONDITIONS.html' arial-label="Conditions d'utilisations" target='_blank'><?php if ($USER_LANG == "FR"){ echo " conditions d'utilisations";}else{echo " conditions of use";} ?></a></u>.</div><br>
                </div><br>
                <button class="no-effect green" id='btnaddRDV' onclick='addRDV();' style='padding:15px;'>
                📆 <?php if ($USER_LANG == "FR"){ echo "Valider";}else{echo "Validate";} ?>
                </button><br>
                <div class='dw3_paragraf' style='font-family:Roboto;text-align:left;padding:20px;max-width:700px;'>
                    <strong style='color:#888;font-size:14px;'><?php if ($USER_LANG == "FR"){ echo "Rendez-vous ";}else{echo "Appointment ";} ?>:</strong><br>
                    <div id='divDATE_OUTPUT'></div><br><br>
                    <div id='divHEURE_OUTPUT' style='margin:25px;'><h4><span style='color:darkred;'><?php if ($USER_LANG == "FR"){ echo "Heure non-définie";}else{echo "Undefined time";} ?></span></h4></div><br><br>
                    <h3 id='location_output'><?php echo $CIE_ADR; ?></h3>
                </div>
                <hr><button onclick='dw3_cookie_pref();'><?php if($USER_LANG == "FR"){ echo "Préférences en matière de conservation des données"; }else{echo "Data retention preferences";}?></button>
                <div style="font-size:0.7em;padding:5px;width:100%;max-width:100%;overflow:hidden;display:inline-block;text-align:center;">
                    <a href="/legal/PRIVACY.html" target="_blank" style='color:unset;'><u><?php if($USER_LANG == "FR"){ echo "Politique de confidentialité"; }else{echo "Privacy Policy";} ?></u></a>
                    | <a href="/legal/LICENSE.html" target="_blank" style='color:unset;'><u><?php if($USER_LANG == "FR"){ echo "Conditions d'utilisation"; }else{echo "Terms of use";}?></u></a>
                </div>
                <div style='font-size:0.65em;padding:3px;'>
                    <?php if($USER_LANG == "FR"){ echo "Créé avec"; }else{echo "Created with";} ?> Design Web 3D | <a style='color:#444;' href='https://dw3.ca'>https://dw3.ca</a>
                </div>
                <div style='margin-bottom:-3px;overflow:hidden;font-size:20px;width:100%;height:25px;max-height:25px;padding-top:5px;background-color:#<?php echo $CIE_COLOR6; ?>;color:#<?php echo $CIE_COLOR7; ?>;'>
                © <?php echo $CIE_NOM . " " .  date("Y"); ?>
                </div>
        </div>
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
let product_id = "<?php echo $product_id; ?>";
let user_loc_adr = "<?php echo $CIE_ADR; ?>";
let current_schedule = [];
let selectedDate = new Date();
let selectedDispo = "90";
let selectedPrd = "";
let selectedDesc = "";
let today = new Date();
let currentDay = today.getDate();
let currentMonth = today.getMonth()+1;
let currentYear = today.getFullYear();
let selectYear = document.getElementById("year");
let selectMonth = document.getElementById("month");
<?php if($USER_LANG == "FR"){ ?>
    let months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aôut", "Septembre", "Octobre", "Novembre", "Décembre"];
<?php }else{ ?>
    let months = ["January", "February", "March", "April", "May", "June", "Jully", "August", "September", "October", "November", "December"];
<?php } ?>
//let monthAndYear = document.getElementById("monthAndYear");


/* window.onresize = function() {
    let xw = document.getElementById("cal_page0").offsetWidth;
	document.getElementById("cal_page0").style.left = "0px";
	document.getElementById("cal_page1").style.left = xw + "px";
	document.getElementById("cal_page2").style.left = xw + "px";
	document.getElementById("cal_page3").style.left = xw + "px";
} */
let windowWidth = window.innerWidth;
window.addEventListener('resize', function(event) {
    if (window.innerWidth != windowWidth) {
        windowWidth = window.innerWidth;
        let xw = document.getElementById("cal_page0").offsetWidth;
        document.getElementById("cal_page0").style.left = "0px";
        document.getElementById("cal_page1").style.left = xw + "px";
        document.getElementById("cal_page2").style.left = xw + "px";
        document.getElementById("cal_page3").style.left = xw + "px";
    }
});


/*  var dw3_sticky = document.getElementById("dw3_head").offsetTop;
document.onscroll = function(){
    if (window.pageYOffset > dw3_sticky || window.scrollTop > dw3_sticky) {
        document.getElementById("dw3_head").classList.add("sticky");
        //document.getElementById("dw3_scroll_top").style.right = "5px";
    } else {
        document.getElementById("dw3_head").classList.remove("sticky");
        //document.getElementById("dw3_scroll_top").style.right = "-45px";
    }
};
 */

function dw3_set_dispo(dispo=selectedDispo) { 
    selectedDispo=dispo;    
    //selectedDesc=descr;
    if (document.querySelector('input[name="prd"]:checked')!=undefined){
        openRDV('2','1');    
    }
}

function getD(day=currentDay) { 
	currentDay=day;
	var xday = new Date(currentYear + "/" + (currentMonth) + "/" + day);
	switch(xday.getDay()) {
	case 0:
		// dimanche
		var dayname_of_week = "<?php if($USER_LANG == "FR"){ echo "Dimanche"; }else{echo "Sunday";} ?>";
		break;
	case 1:
		// lundi
		var dayname_of_week = "<?php if($USER_LANG == "FR"){ echo "Lundi"; }else{echo "Monday";} ?>";
		break;
	case 2:
		// lundi
		var dayname_of_week = "<?php if($USER_LANG == "FR"){ echo "Mardi"; }else{echo "Tuesday";} ?>";
		break;
	case 3:
		// lundi
		var dayname_of_week = "<?php if($USER_LANG == "FR"){ echo "Mercredi"; }else{echo "Wednesday";} ?>";
		break;
	case 4:
		// lundi
		var dayname_of_week = "<?php if($USER_LANG == "FR"){ echo "Jeudi"; }else{echo "Thursday";} ?>";
		break;
	case 5:
		// lundi
		var dayname_of_week = "<?php if($USER_LANG == "FR"){ echo "Vendredi"; }else{echo "Friday";} ?>";
		break;
	case 6:
		// lundi
		var dayname_of_week = "<?php if($USER_LANG == "FR"){ echo "Samedi"; }else{echo "Saturday";} ?>";
		break;
	default:
		// code block
        return;
	}
 	document.getElementById("divDATE_OUTPUT").innerHTML = "<h2>" + dayname_of_week + " <strong>" + day + "</strong> " +  months[currentMonth-1] + " " + currentYear + "</h2>" ;
	document.getElementById("divHEURE_OUTPUT").innerHTML = "<h3><span style='color:darkred;'><?php if($USER_LANG == "FR"){ echo "Heure non-définie"; }else{echo "Undefined time";} ?></span></h3>" ;  
    getDISPO();
}


function openRDV(page,from){
    //let xw = document.getElementById("divSUBMIT").offsetWidth;parent.innerWidth
    //let xw= window.innerWidth;
    let xw = document.getElementById("cal_page1").offsetWidth;
	if (page=="0"){
		document.getElementById("cal_page0").style.left = "0px";
		document.getElementById("cal_page1").style.left = xw + "px";
		document.getElementById("cal_page2").style.left = xw + "px";
		document.getElementById("cal_page3").style.left = xw + "px";
/* 		document.getElementById("cal_page1").style.display = "inline-block";
		document.getElementById("cal_page2").style.display = "none";
		document.getElementById("cal_page3").style.display = "none"; */
    }else if(page=="1") {
        if (document.querySelector('input[name="service_type"]:checked')==undefined || document.querySelector('input[name="service_user"]:checked')==undefined){
            document.getElementById("dw3_body_fade").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.opacity = "0.5";
            document.getElementById("dw3_msg").style.display = "inline-block";
            document.getElementById("dw3_msg").innerHTML = "<?php if($USER_LANG == "FR"){ echo "Veuillez choisir le lieux et le personel pour continuer."; }else{echo "Please choose location and staff to continue.";} ?><br><button onclick='dw3_msg_close();' style='margin-top:20px;'><span class='dw3_font'>Ē</span> Ok</button>";
            return;
	    }
        //document.getElementById("location_output").innerHTML = $('label[for="'+document.querySelector('input[name="service_type"]:checked').id+'"]').innerHTML;
        if (document.querySelector('input[name="service_type"]:checked').value == "V"){
            document.getElementById("location_output").innerHTML = "<?php if($USER_LANG == "FR"){ echo "Un lien pour la visioconférence vous sera envoyé par courriel."; }else{echo "A link for the videoconference will be sent to you by email.";} ?>";
        } else if (document.querySelector('input[name="service_type"]:checked').value == "R"){
            document.getElementById("location_output").innerHTML = "<?php if($USER_LANG == "FR"){ echo "Un lien vous sera envoyé par courriel afin de compléter vos informations pour le rendez-vous."; }else{echo "A link will be sent to you by email to complete your information for the appointment.";} ?>";
        } else if (document.querySelector('input[name="service_type"]:checked').value == "L"){
            document.getElementById("location_output").innerHTML = "<?php if($USER_LANG == "FR"){ echo "Rendez-vous au: "; }else{echo "Meet at:";} ?>" + user_loc_adr;
        } else if (document.querySelector('input[name="service_type"]:checked').value == "P"){
            document.getElementById("location_output").innerHTML = "<?php if($USER_LANG == "FR"){ echo "Nous vous contacterons par téléphone à l'heure prévue."; }else{echo "We will contact you by telephone at the scheduled time.";} ?>";
        }

		document.getElementById("cal_page0").style.left = "-" + xw + "px";
		document.getElementById("cal_page1").style.left = "0px";
		document.getElementById("cal_page2").style.left = xw + "px";  
		document.getElementById("cal_page3").style.left = xw + "px";  
/* 		document.getElementById("cal_page1").style.display = "none";
		document.getElementById("cal_page2").style.display = "inline-block";
		document.getElementById("cal_page3").style.display = "none";   */
    }else if(page=="2") {
        if (document.querySelector('input[name="prd"]:checked')==undefined){
            document.getElementById("dw3_body_fade").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.opacity = "0.5";
            document.getElementById("dw3_msg").style.display = "inline-block";
            document.getElementById("dw3_msg").innerHTML = "<?php if($USER_LANG == "FR"){ echo "Veuillez choisir un service pour continuer."; }else{echo "Please choose a service to continue.";} ?><br><button onclick='dw3_msg_close();' style='margin-top:20px;'><span class='dw3_font'>Ē</span> Ok</button>";
            return;
	    }
        if (from=="1") {
            //getD();
            getNextDISPO2();
        }
		document.getElementById("cal_page0").style.left = "-" + xw + "px";
		document.getElementById("cal_page1").style.left = "-" + xw + "px";
		document.getElementById("cal_page2").style.left = "0px";
		document.getElementById("cal_page3").style.left = xw + "px";  
/* 		document.getElementById("cal_page1").style.display = "none";
		document.getElementById("cal_page2").style.display = "inline-block";
		document.getElementById("cal_page3").style.display = "none";   */
    }else if(page=="3") {
		document.getElementById("cal_page0").style.left = "-" + xw + "px";
        document.getElementById("cal_page1").style.left = "-"+xw + "px";
		document.getElementById("cal_page2").style.left = "-"+xw + "px";
		document.getElementById("cal_page3").style.left = "0px";
/* 		document.getElementById("cal_page1").style.display = "none";
		document.getElementById("cal_page2").style.display = "none";
		document.getElementById("cal_page3").style.display = "inline-block"; */
    }
}

function addRDV(){
    document.getElementById("btnaddRDV").disabled = true;
	if (document.querySelector('input[name="service_type"]:checked')==undefined){
		document.getElementById("dw3_body_fade").style.display = "inline-block";
		document.getElementById("dw3_body_fade").style.opacity = "0.5";
		document.getElementById("dw3_msg").style.display = "inline-block";
		document.getElementById("dw3_msg").innerHTML = "<?php if($USER_LANG == "FR"){ echo "Veuillez choisir un lieu pour continuer."; }else{echo "Please choose a location to continue.";} ?><br><button onclick='dw3_msg_close();' style='margin-top:20px;'><span class='dw3_font'>Ē</span> Ok</button>";
        openRDV("0","3");
        document.getElementById("btnaddRDV").disabled = false;
		return;
	}
	if (document.querySelector('input[name="service_user"]:checked')==undefined){
		document.getElementById("dw3_body_fade").style.display = "inline-block";
		document.getElementById("dw3_body_fade").style.opacity = "0.5";
		document.getElementById("dw3_msg").style.display = "inline-block";
		document.getElementById("dw3_msg").innerHTML = "Veuillez choisir le personel pour continuer.<?php if($USER_LANG == "FR"){ echo "Please choose staff to continue."; }else{echo "Please choose a location to continue.";} ?><br><button onclick='dw3_msg_close();' style='margin-top:20px;'><span class='dw3_font'>Ē</span> Ok</button>";
        openRDV("0","3");
        document.getElementById("btnaddRDV").disabled = false;
		return;
	}
	if (document.querySelector('input[name="prd"]:checked')==undefined){
		document.getElementById("dw3_body_fade").style.display = "inline-block";
		document.getElementById("dw3_body_fade").style.opacity = "0.5";
		document.getElementById("dw3_msg").style.display = "inline-block";
		document.getElementById("dw3_msg").innerHTML = "<?php if($USER_LANG == "FR"){ echo "Veuillez choisir un lieu pour continuer."; }else{echo "Please choose a service to continue.";} ?><br><button onclick='dw3_msg_close();' style='margin-top:20px;'><span class='dw3_font'>Ē</span> Ok</button>";
        openRDV("1","3");
        document.getElementById("btnaddRDV").disabled = false;
		return;
	}
	if (document.querySelector('input[name="selBLOCK"]:checked')==undefined){
		document.getElementById("dw3_body_fade").style.display = "inline-block";
		document.getElementById("dw3_body_fade").style.opacity = "0.5";
		document.getElementById("dw3_msg").style.display = "inline-block";
		document.getElementById("dw3_msg").innerHTML = "<?php if($USER_LANG == "FR"){ echo "Veuillez choisir un jour et une heure de disponible."; }else{echo "Please choose an available day and time.";} ?><br><button onclick='dw3_msg_close();' style='margin-top:20px;'><span class='dw3_font'>Ē</span> Ok</button>";
        openRDV("2","3");
        document.getElementById("btnaddRDV").disabled = false;
		return;
	}

	var xuser = document.querySelector('input[name="service_user"]:checked').value;
	var xtype= document.querySelector('input[name="service_type"]:checked').value;
	var xprd = document.querySelector('input[name="prd"]:checked').value;
    var selectedDesc = findLableForControl("product_"+xprd);
	var xblock_from = document.querySelector('input[name="selBLOCK"]:checked').value;
	//var date_rdv_from = new Date(currentYear + "-" + (currentMonth) + "-" + currentDay + " " + xblock_from + ":00");
    var date_rdv_from = new Date(currentYear + "/" + ("0"+currentMonth).slice(-2) + "/" + ("0" +currentDay).slice(-2) + " " + xblock_from + ":00");
	//var d1 = currentYear + "-" + (currentMonth) + "-" + currentDay + " " + xblock_from + ":00";
    var d1 = currentYear + "/" + ("0"+currentMonth).slice(-2) + "/" + ("0" +currentDay).slice(-2) + " " + xblock_from + ":00";
    var date_rdv_to = new Date(date_rdv_from.getTime() + selectedDispo*60000);
	
	//var d2 = date_rdv_to.getFullYear() + "-" + (date_rdv_to.getMonth()+1) + "-" + date_rdv_to.getDate() + " " +  date_rdv_to.getHours()+ ":" +  date_rdv_to.getMinutes()+ ":00";
    var d2 = date_rdv_to.getFullYear() + "/" + ("0" +(date_rdv_to.getMonth()+1)).slice(-2) + "/" + ("0" +date_rdv_to.getDate()).slice(-2) + " " +  ("0" +date_rdv_to.getHours()).slice(-2)+ ":" +  ("0" +date_rdv_to.getMinutes()).slice(-2)+ ":" +  ("0" +date_rdv_to.getSeconds()).slice(-2);

	var xxcmnt = document.getElementById("txtSUBMIT_CMNT").value;
	var xxtel = document.getElementById("txtSUBMIT_TEL").value;
	var xxcl = document.getElementById("txtSUBMIT_EMAIL").value;
	var xxcln = document.getElementById("txtSUBMIT_NOM").value;
	if (xxcln == "" || xxcln == undefined){
		document.getElementById("txtSUBMIT_NOM").style.borderColor = "red";
		document.getElementById("dw3_body_fade").style.display = "inline-block";
		document.getElementById("dw3_body_fade").style.opacity = "0.5";
		document.getElementById("dw3_msg").style.display = "inline-block";
		document.getElementById("dw3_msg").innerHTML = "Veuillez entrer votre nom ou prénom pour continuer.<br><br><button onclick='dw3_msg_close();document.getElementById(\"txtSUBMIT_NOM\").focus();'><span class='dw3_font'>Ē</span> Ok</button>";
        document.getElementById("btnaddRDV").disabled = false;
		return;
	} else {
		document.getElementById("txtSUBMIT_NOM").style.borderColor = "lightgrey";
	}
	if (xxcl == "" || xxcl == undefined){
		document.getElementById("txtSUBMIT_EMAIL").style.borderColor = "red";
		document.getElementById("dw3_body_fade").style.display = "inline-block";
		document.getElementById("dw3_body_fade").style.opacity = "0.5";
		document.getElementById("dw3_msg").style.display = "inline-block";
		document.getElementById("dw3_msg").innerHTML = "Veuillez entrer votre adresse courriel pour continuer.<br><br><button onclick='dw3_msg_close();document.getElementById(\"txtSUBMIT_EMAIL\").focus();'><span class='dw3_font'>Ē</span> Ok</button>";
        document.getElementById("btnaddRDV").disabled = false;
		return;
	} else {
		document.getElementById("txtSUBMIT_EMAIL").style.borderColor = "lightgrey";
	}
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (!xxcl.match(validRegex)) {
        document.getElementById("dw3_body_fade").style.display = "inline-block";
		document.getElementById("dw3_body_fade").style.opacity = "0.5";
		document.getElementById("dw3_msg").style.display = "inline-block";
		document.getElementById("dw3_msg").innerHTML = "Courriel invalide.<br><br><button onclick='dw3_msg_close();document.getElementById(\"txtSUBMIT_EMAIL\").focus();'><span class='dw3_font'>Ē</span> Ok</button>";
        document.getElementById("btnaddRDV").disabled = false;
		return;
	} else {
		document.getElementById("txtSUBMIT_EMAIL").style.borderColor = "lightgrey";
	}
    if (xxtel == "" || xxtel == undefined){
		document.getElementById("txtSUBMIT_NOM").style.borderColor = "red";
		document.getElementById("dw3_body_fade").style.display = "inline-block";
		document.getElementById("dw3_body_fade").style.opacity = "0.5";
		document.getElementById("dw3_msg").style.display = "inline-block";
		document.getElementById("dw3_msg").innerHTML = "Veuillez entrer votre # de téléphone pour continuer.<br><br><button onclick='dw3_msg_close();document.getElementById(\"txtSUBMIT_TEL\").focus();'><span class='dw3_font'>Ē</span> Ok</button>";
        document.getElementById("btnaddRDV").disabled = false;
		return;
	} else {
		document.getElementById("txtSUBMIT_NOM").style.borderColor = "lightgrey";
	}
    document.getElementById("dw3_body_fade").style.display = "inline-block";
	document.getElementById("dw3_body_fade").style.opacity = "0.5";
    document.getElementById("dw3_msg").style.display = "inline-block";
	document.getElementById("dw3_msg").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
	//addNotif("Création du rendez-vous..<img style='height:30px;width:auto;' src='/img/load.gif'>");
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  //if (this.readyState == 4 && this.status == 200) {
	  if (this.readyState ==3  && this.status == 200) {
        document.getElementById("dw3_msg").style.display = "inline-block";
        document.getElementById("dw3_body_fade").style.display = "inline-block";
	    document.getElementById("dw3_body_fade").style.opacity = "0.6";
		document.getElementById("dw3_msg").innerHTML = "<strong>Le rendez-vous a été créé!</strong><br> Ouvrez votre boite de courriels pour voir les détails.<br>Ajouter à votre agenda:<br><a href='" + this.responseText + "'><button><img src='/pub/img/dw3/ics_file.png' style='vertical-align:middle;height:40px;width:auto;'></button></a><br><br><button onclick=\"dw3_msg_close();window.open('/client','_self');\"><span class='dw3_font'>)</span> Accèder à mon compte</button><button onclick=\"dw3_msg_close();window.open('/','_self');\"><span class='dw3_font'>!</span> Retourner à l'accueil</button>";
				//getM();
				//getD(currentDay);
                //closeSUBMIT();
                
	  }
	};
    var id1 = new Date(d1);
	//id1.setMinutes(id1.getMinutes() - id1.getTimezoneOffset());
	var id2 = new Date(d2);
    //alert(id2.getTimezoneOffset());
	//id2.setMinutes(id2.getMinutes() - id2.getTimezoneOffset());
    
		xmlhttp.open('GET', 'newScheduleLine.php?'
                                        + 'START=' + encodeURIComponent(d1)  
										+ '&ISTART=' + encodeURIComponent(id1.toISOString().replace(/-/g,'').replace(/:/g,''))
										+ '&END=' + encodeURIComponent(d2)    
										+ '&IEND=' + encodeURIComponent(id2.toISOString().replace(/-/g,'').replace(/:/g,''))  
										+ '&P=' + xprd    
										+ '&D=' + selectedDesc    
										+ '&T=' + encodeURIComponent(xxtel)    
										+ '&M=' + encodeURIComponent(xxcmnt)    
										+ '&Y=' + encodeURIComponent(xtype)    
										+ '&U=' + encodeURIComponent(xuser)    
										+ '&N=' + encodeURIComponent(xxcln)    
										+ '&C=' + encodeURIComponent(xxcl),    
										true);
		xmlhttp.send();
		document.getElementById("dw3_body_fade").style.display = "inline-block";
		document.getElementById("dw3_body_fade").style.opacity = "0.5";
		
        var formattedD1 = id1.getFullYear() + "-" + ('0' + parseInt(id1.getMonth() + 1)).slice(-2) + "-" + ('0' + id1.getDate()).slice(-2)+"T"+ ('0' + id1.getHours()).slice(-2)+ ":" + ('0' + id1.getMinutes()).slice(-2)+ ":" + ('0' + id1.getSeconds()).slice(-2);
        var formattedD2 = id2.getFullYear() + "-" + ('0' + parseInt(id2.getMonth() + 1)).slice(-2) + "-" + ('0' + id2.getDate()).slice(-2)+"T"+ ('0' + id2.getHours()).slice(-2)+ ":" + ('0' + id2.getMinutes()).slice(-2)+ ":" + ('0' + id2.getSeconds()).slice(-2);
        addEVENT(selectedDesc,xtype,xxcln + " " + xxcmnt,formattedD1,formattedD2,xuser);
}
function findLableForControl(idVal) {
   labels = document.getElementsByTagName('label');
   for( var i = 0; i < labels.length; i++ ) {
      if (labels[i].htmlFor == idVal)
           return labels[i].innerText.trim();
   }
   return "";
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
										+ '&L=' + encodeURIComponent(location)    
										+ '&T=' + encodeURIComponent(date_to),    
										true);
		xmlhttp.send();  
}

function getUserLocAdr(user_id,location_id){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        user_loc_adr = this.responseText;
	  };
    }   
		xmlhttp.open('GET', 'getUserLocAdr.php?UID=' + user_id + '&LID=' + location_id,true);
		xmlhttp.send();
  
}

function next() {
    //currentYear = (parseInt(currentMonth-1) === 11) ? currentYear + 1 : currentYear;
    //currentMonth = (parseInt(currentMonth-1) + 1) % 12;
    if (currentMonth==12){currentMonth=1;currentYear++}else{currentMonth++;}
    getM();
    document.getElementById("divDISPO").innerHTML = "";
    //showCalendar(currentMonth, currentYear);
}

function previous() {
    //currentYear = (parseInt(currentMonth-1) === 0) ? currentYear - 1 : currentYear;
    //currentMonth = (parseInt(currentMonth-1) === 0) ? 11 : parseInt(currentMonth-1) - 1;
    if (currentMonth==1){currentMonth=12;currentYear--}else{currentMonth--;}
    getM();
    document.getElementById("divDISPO").innerHTML = "";
    //showCalendar(currentMonth, currentYear);
}

function jump() {
    currentYear = parseInt(selectYear.value);
    currentMonth = parseInt(selectMonth.value);
    getM();
    //showCalendar(currentMonth, currentYear);
}
function showCalendar(month, year) {
let firstDate = new Date(parseInt(year), parseInt(month)-1,01)
let firstDay = (firstDate).getDay();
let daysInMonth = 32 - new Date(year, parseInt(month)-1, 32).getDate();
let tbl = document.getElementById("calendar"); // body of the calendar
let monthAndYear = document.getElementById("monthAndYear");
// clearing all previous cells
<?php if ($USER_LANG == "FR"){ ?>
    tbl.innerHTML = "<thead><tr><th width='14%'>Dim</th><th width='15%'>Lun</th><th width='15%'>Mar</th><th width='14%'>Mer</th><th width='14%'>Jeu</th><th width='14%'>Ven</th><th width='14%'>Sam</th></tr></thead>";
<?php } else{ ?>
    tbl.innerHTML = "<thead><tr><th width='14%'>Sun</th><th width='15%'>Mon</th><th width='15%'>Tue</th><th width='14%'>Wed</th><th width='14%'>Thu</th><th width='14%'>Fri</th><th width='14%'>Sat</th></tr></thead>";
<?php } ?>
// filing data about month and in the page via DOM.
monthAndYear.innerHTML = months[month-1] + " " + year;
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
            cell.appendChild(cellText);
            row.appendChild(cell);
        }
        else if (date > daysInMonth) {
            for (let jj = j; jj < 7; jj++) {
                var cell = document.createElement("td");
                let cellText = document.createTextNode("");
                cell.style.backgroundColor = "rgba(255,255,255,0)";
                cell.style.height = "40px";
                cell.appendChild(cellText);
                row.appendChild(cell);
            }
            break;
        }
        else {
            var cell = document.createElement("td");
            cell.style.textAlign = "center";
            cell.style.padding = "2px";
            cell.style.height = "40px";
            cell.style.whiteSpace = "pre-wrap";

            if (parseInt(date) === today.getDate() && parseInt(year) === today.getFullYear() && parseInt(month) === (today.getMonth()+1)) {
                //cell
                cell.style.backgroundColor = "rgba(255,200,100,0.5)";
            } // color today's date
            if (parseInt(date) === parseInt(currentDay) && parseInt(year) === parseInt(currentYear) && parseInt(month) === parseInt(currentMonth)) {
                //cell
                cell.style.backgroundColor = "rgba(50,200,255,0.5)";
            } // color selected date
            if (parseInt(date) < today.getDate() && parseInt(year) <= today.getFullYear() && parseInt(month) <= (today.getMonth()+1)){
                cell.innerHTML = "<div style='color:#999;padding-left:3px;width:100%;text-align:left;margin-bottom:-3px;'>" + date + "</div>";
            }else{
                cell.innerHTML = "<div style='padding-left:3px;width:100%;text-align:left;margin-bottom:3px;'>" + date + "</div>";
            }
            //var tmpdate = new Date(date, year, month);
            //if (today >= tmpdate){
                cell.style.cursor = "pointer";
                let tmpday = date;
                cell.onclick = function () {
                    //this.parentElement.removeChild(this);
                    getD(tmpday);
                    //getDISPO(selectedDispo);
                    showCalendar(month, year);
                };
            //}
            var iloop = 0;var isOff = true;
            for (var iloop=0; iloop<current_schedule.length; iloop++) {
                //for (var head_id in current_schedule[iloop]) {
                        //console.log(current_schedule[iloop][schedule_id]);
                        let tmpDateStart = new Date(current_schedule[iloop].start_date.replace(/-/g, "/"));
                        let tmpDateEnd = new Date(current_schedule[iloop].end_date.replace(/-/g, "/"));
                        //alert (current_schedule[iloop].end_date);
                        if (parseInt(date) === tmpDateStart.getDate() && parseInt(year) === tmpDateStart.getFullYear() && parseInt(month) === tmpDateStart.getMonth()+1) {
                            isOff = false;
                            if ((parseInt(date) < today.getDate() && parseInt(year) <= today.getFullYear() && parseInt(month) <= (today.getMonth()+1)) || (parseInt(year) <= today.getFullYear() && parseInt(month) < (today.getMonth()+1)) || (parseInt(year) < today.getFullYear() )) {
                                cell.innerHTML += "<div style='font-size:0.7em;color:#555;margin-top:-4px;'><?php if ($USER_LANG == "FR"){ echo "Terminé";}else{echo "Finished";} ?></div>";
                                break;
                            } else {
                                var hour_from = current_schedule[iloop].start_date.substr(11, 5);
                                if (hour_from.substr(0, 1)=="0"){
                                    hour_from = hour_from.substr(1, 4);
                                }
                                var hour_to = current_schedule[iloop].end_date.substr(11, 5);
                                if (hour_to.substr(0, 1)=="0"){
                                    hour_to = hour_to.substr(1, 4);
                                }
                                if (current_schedule[iloop].reserved > 0){
                                    cell.innerHTML += "<div style='font-size:0.5em;color:goldenrod;'>" + hour_from + "-;" + hour_to + "</div>";
                                } else{
                                    cell.innerHTML += "<div style='font-size:0.5em;color:darkgreen;'>" + hour_from + "-" + hour_to + "</div>";
                                }
                            }
                            //cell.style.backgroundColor = "rgba(50,250,20,0.5)";
                        }
                //}
            }
            if ( isOff == true && !((parseInt(date) < today.getDate() && parseInt(year) <= today.getFullYear() && parseInt(month) <= (today.getMonth()+1)) || (parseInt(year) <= today.getFullYear() && parseInt(month) < (today.getMonth()+1)) || (parseInt(year) < today.getFullYear() ))) { 
/*                 if (iOS()) { 
                    cell.innerHTML += "<div style='font-size:0.65em;color:#333;text-align:center;margin-top:-7px;'>Vérifier</div>";
                } else { */
                    cell.innerHTML += "<div style='font-size:0.65em;color:goldenrod;text-align:center;margin-top:-7px;'><?php if ($USER_LANG == "FR"){ echo "Non<br style='line-height:0.1em;margin:-3px;'>disponible";}else{echo "Not<br style='line-height:0.1em;margin:-3px;'>available";} ?></div>";
                //}
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


function getServiceUser(service_type){
    if (service_type == "L"){
        document.getElementById("service_type_L").checked = true;
    }
    if (service_type == "R"){
        document.getElementById("service_type_R").checked = true;
    }
    if (service_type == "V"){
        document.getElementById("service_type_V").checked = true;
    }
    if (service_type == "P"){
        document.getElementById("service_type_P").checked = true;
    }
    
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        <?php 
            $result = $dw3_conn->query("SELECT DISTINCT user_id as user_id, location_id FROM schedule_head WHERE is_public = 1");
            $row_count = $result->num_rows;
            $row = $result->fetch_row();
            if ($row_count == 1){
                echo 'document.getElementById("dw3_service_user").innerHTML = this.responseText;';
                echo 'getServiceType("'.$row[0].'","'.$row[1].'");';
            } else {
                echo 'document.getElementById("dw3_service_user").innerHTML = this.responseText;';
                echo 'document.getElementById("dw3_service_user").scrollIntoView({ behavior: "smooth", block: "center", inline: "center" });';
                //echo 'document.getElementById("dw3_service_user_after").scrollIntoView({ behavior: "smooth", block: "center", inline: "center" });';
                //echo 'document.getElementById("cal_page0").scrollTop = document.getElementById("cal_page0").scrollHeight;';
                //echo "window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });";

            } 
        ?>
		
	  }
	};
		xmlhttp.open('GET', 'getServiceUser.php?T=' + service_type,true);
		xmlhttp.send();
}
function getServiceType(user_id,location_id){
    getUserLocAdr(user_id,location_id);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divMAIN_OUTPUT").innerHTML = this.responseText;
            openRDV('1','0');
            getM();
	  }
	};
		xmlhttp.open('GET', 'getServiceType.php?U=' + user_id+'&P='+ product_id,true);
		xmlhttp.send();
}
function getDISPO(){
    var xloc = document.querySelector('input[name="service_type"]:checked').value;
    if (document.querySelector('input[name="prd"]:checked')){
        var xprd = document.querySelector('input[name="prd"]:checked').value;
    } else { return;}
    var xusr = document.querySelector('input[name="service_user"]:checked').value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divDISPO").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getScheduleDispo.php?M=' + currentMonth + '&Y=' + currentYear + '&D=' + currentDay + '&P=' + xprd + '&U=' + xusr + '&L=' + xloc
										,true);
		xmlhttp.send();
}
function getNextDISPO(minut){
    selectedDispo = minut;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.trim() != ""){
                currentYear = this.responseText.trim().substr(0, 4);
                currentMonth = this.responseText.trim().substr(5, 2);
                currentDay = this.responseText.trim().substr(8, 2);
                getM();
                getD(currentDay);
            }else{

            }
	  }
	};
		xmlhttp.open('GET', 'getNextDISPO.php?T=' + minut
										,true);
		xmlhttp.send();
}
function getNextDISPO2(){
    var xloc = document.querySelector('input[name="service_type"]:checked').value;
    var xusr = document.querySelector('input[name="service_user"]:checked').value;
    var xprd = document.querySelector('input[name="prd"]:checked').value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.trim() != ""){
                currentYear = this.responseText.trim().substr(0, 4);
                currentMonth = this.responseText.trim().substr(5, 2);
                currentDay = this.responseText.trim().substr(8, 2);
                //getD(currentDay);
                getM();
                getD(currentDay);
                //document.getElementById("divDATE_OUTPUT").innerHTML = "<h2>" + dayname_of_week + " <strong>" + day + "</strong> " + monthAndYear.innerHTML + "</h2>" ;
                //document.getElementById("divDATE_OUTPUT").innerHTML = "<h3><span style='color:darkred;'>Date non-défini</span></h3>";
            }else{

            }
	  }
	};
		xmlhttp.open('GET', 'getNextDISPO.php?P=' + xprd + '&U=' + xusr + '&L=' + xloc
										,true);
		xmlhttp.send();
}

function getM() {
    var xusr = document.querySelector('input[name="service_user"]:checked').value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		current_schedule = JSON.parse(this.responseText);
        //document.getElementById("divDATE_OUTPUT").innerHTML = "<h3><span style='color:darkred;'>Date non-défini</span></h3>";
        //document.getElementById("divDISPO").innerHTML = "<div style='display:inline-block;width:auto;text-align:center;font-weight:bold;background-image: linear-gradient(180deg, rgba(255,255,255,0), rgba(155,200,255,0.3),rgba(255,255,255,0));padding:10px;font-size:23px;'>Veuillez choisir un jour de disponible.</div>";
        //currentDay=0;
		showCalendar(currentMonth, currentYear);
        getDISPO();
	  }
	};
		xmlhttp.open('GET', 'getScheduleMonth.php?M=' + currentMonth + '&Y=' + currentYear + '&U=' + xusr  , true);
		xmlhttp.send();	
}

function setPAGE_POS() {
    //var TotalHeight = document.documentElement.scrollHeight;
    //var scrollPercent = (100 / TotalHeight) * (document.documentElement.scrollTop+(TotalHeight/100 *((100 / (TotalHeight+(document.documentElement.clientHeight/2))) * (document.documentElement.scrollTop))));
    //var scrollPercent = (100 / TotalHeight) * (document.documentElement.scrollTop+(TotalHeight/100 *((100 / TotalHeight) * (document.documentElement.scrollTop*0.6))));
    //var scrollPercent = (100 / TotalHeight) * document.documentElement.scrollTop;
    //var posLeft = Math.round((document.documentElement.clientWidth / 100) * scrollPercent);
    //document.getElementById("divPAGE_POS").style.left = posLeft + "px";
    //document.getElementById("divPAGE_POS").style.width = (TotalHeight - document.documentElement.client) +"px";
            // if (document.documentElement.scrollTop > 50) {
            //    document.getElementById("divPAGE_POS").className = "test";
            //  } else {
            //      document.getElementById("divPAGE_POS").className = "";
            // }
            // var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
                //scrollTop = window.pageYOffset || document.documentElement.scrollTop;
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("dw3_body").innerHTML = "";
    <?php 
        $result = $dw3_conn->query("SELECT count(*) FROM schedule_head WHERE is_public = 1 AND virtual_enable = 1");
        $row = $result->fetch_row();
        $tot_v = $row[0];
        $result = $dw3_conn->query("SELECT count(*) FROM schedule_head WHERE is_public = 1 AND road_enable = 1");
        $row = $result->fetch_row();
        $tot_r = $row[0];
        $result = $dw3_conn->query("SELECT count(*) FROM schedule_head WHERE is_public = 1 AND local_enable = 1");
        $row = $result->fetch_row();
        $tot_l = $row[0];
        $result = $dw3_conn->query("SELECT count(*) FROM schedule_head WHERE is_public = 1 AND phone_enable = 1");
        $row = $result->fetch_row();
        $tot_p = $row[0];
       
        if ($tot_v == 0 && $tot_r == 0 && $tot_l > 0 && $tot_p == 0){
            echo "getServiceUser('L');" . "\n";
        } else if ($tot_v > 0 && $tot_r == 0 && $tot_l == 0 && $tot_p == 0){
            echo "getServiceUser('V');" . "\n";
        } else if ($tot_v == 0 && $tot_r > 0 && $tot_l == 0 && $tot_p == 0){
            echo "getServiceUser('R');" . "\n";
        } else if ($tot_v == 0 && $tot_p > 0 && $tot_l == 0 && $tot_r == 0){
            echo "getServiceUser('P');" . "\n";
        }

        ?>

}, false);

</script>
</body>
</html>
<?php 
    $dw3_conn->close();
    exit; 
?>