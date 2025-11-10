<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
$quiz_id = $_GET['ID']??0;
$report_id = $_GET['RID']??0;
if($quiz_id==0){
    if ($PAGE_P1!=""){
        $quiz_id = $PAGE_P1;
    } else {
        $dw3_conn->close();
        die("Error: No data found.");
    }
}
$report_lang = $USER_LANG;
$head_parent_id = 0;
//get report header
if ($report_id != '0'){
    $sql = "SELECT * FROM prototype_report WHERE id = '" . $report_id . "';";
    $result = mysqli_query($dw3_conn, $sql);
    if ($result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result);
        $report_completed = $data['date_completed'];
        $report_lang = $data["lang"];
        $report_user_created = $data['user_created'];
        $head_parent_id = $data['parent_id'];
    } else {
        $report_id = '0';
        $report_completed = "0000-00-00 00:00:00";
        $report_lang = $USER_LANG;
    }
}else if ($USER_ID != ""){
    $sql = "SELECT * FROM prototype_report WHERE head_id = '" . $quiz_id . "' AND parent_id = '" . $USER_ID . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    if ($result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result);
        $report_id = $data['id'];
        $report_completed = $data['date_completed'];
        $report_lang = $data["lang"];
        $report_user_created = $data['user_created'];
        $head_parent_id = $data['parent_id'];
    } else {
        $report_id = '0';
        $report_completed = "0000-00-00 00:00:00";
        $report_lang = $USER_LANG;
    }
}


//get quiz header
$sql = "SELECT * FROM prototype_head WHERE id = '" . str_replace("'", "", $quiz_id) . "';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if($report_lang == "FR"){
    $head_name = $data['name_fr']??"";
    $head_desc = $data['description_fr']??"";
} else {
    $head_name = $data['name_en']??"";
    $head_desc = $data['description_en']??"";
}
$head_total_type = $data['total_type']??0;
$head_total_max = $data['total_max']??0;
$head_parent_table = $data['parent_table']??0;
$head_next = $data['next_id']??0;
$allow_user_reedit = $data['allow_user_reedit']??'0';
$captcha_required = $data['captcha_required']??'0';
$link_to_user = $data['link_to_user']??'0';

$PAGE_TITLE = $data['name_fr']??"";
$PAGE_TITLE_EN = $data['name_en']??"";
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
if ($PAGE_HEADER == "/pub/section/header6.php" || $PAGE_HEADER == "/pub/section/header21.php" || $PAGE_HEADER == "/pub/section/header22.php"){
    $PAGE_HEADER = "/pub/section/header0.php";
}
require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';

if ($allow_user_reedit=="1" || $report_id == "0"){
    $form_disabled = "";
} else {
    $form_disabled = " disabled ";
    echo "<style>
    label{display:inline-block;max-width:290px;}
    input[type=date]:disabled {
        border: 0px solid #999999;
        background: transparent;
        color: #000;
        box-shadow: none;
        font-weight:bold;
    }
    input[type=datetime-local]:disabled {
        border: 0px solid #999999;
        background: transparent;
        color: #000;
        box-shadow: none;
        font-weight:bold;
    }
    input[type=text]:disabled {
        border: 0px solid #999999;
        background: transparent;
        color: #000;
        box-shadow: none;
        font-weight:bold;
    }
    input[type=number]:disabled {
        border: 0px solid #999999;
        background: transparent;
        color: #000;
        box-shadow: none;
        font-weight:bold;
    }
    input[type=checkbox] {
        border-radius: initial;
        border: initial;
        color: #000;
        background: transparent;
        box-shadow: none;
        transform: scale(1.2);
    }
    input[type=checkbox]:checked{
        color: #000;
        accent-color: #000;
    }
    .dw3_box{
        border-top: 1px solid #999;
        width:97%;max-width:49%;
        display:inline-block;
        text-align:left;
        vertical-align:top;
        box-shadow: none;
        padding:10px 3px 10px 3px;
        border-radius:0px;
        margin:5px 0px 5px 0px;
        background: transparent;
        color: #333;
        font-family:  var(--dw3_form_font);
        line-height: 1;
    }

    </style>";
}

echo "<style>
/* date-time pick */
        .calendar {
        /* width: 350px; */
            margin-top:40px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }
        .calendar-header button {
            background-color: transparent;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
        }
        #month-year {
            font-size: 1.2em;
            font-weight: bold;
        }
        .calendar-weekdays, .calendar-dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }
        .calendar-weekdays div, .calendar-dates div {
            text-align: center;
            padding: 10px;
        }
        .calendar-weekdays {
            background-color: #eaeef3;
        }
        .calendar-weekdays div {
            font-weight: bold;
        }
        .calendar-dates div {
            border-bottom: 1px solid #eaeef3;
        }
        .valid-day {
            cursor: pointer;
            color:#000;
        }
        .valid-day:hover {
            background-color: #f1f1f1;
        }
        .current-date {
            background-color: var(--dw3_selected_border);
            color: #fff;
            border-radius: 50%;
        }
        .current-date:hover {
            background-color: #fff;
            color: var(--dw3_selected_border);
        }
        .past-date {
            color: #bbb;
            cursor: default;
        }
</style>";


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
 else {$INDEX_HEADER_HEIGHT='70';}

//picktime calendar
?>

    <div id='dw3_datetime_pick' class='dw3_editor'>
        <div id='dw3_datetime_pick_HEAD' class='dw3_form_head'>
            <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>Date et heure de ramassage</div></h3>
            <button class='grey no-effect' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeCALENDAR();'><span class='dw3_font'>ď</span></button>
        </div><input id='picktime_input_name' style='display:none;'>
        <div class="calendar">
            <div class="calendar-header">
            <button id="prev-month" class='no-effect'><span class='dw3_font'>ĸ</span></button>
            <div id="month-year"></div>
            <button id="next-month" class='no-effect'><span class='dw3_font'>Ĺ</span></button>
            </div>
            <div class="calendar-body">
            <div class="calendar-weekdays">
                <?php 
                    if ($USER_LANG == "FR"){
                        echo "<div>Dim</div>
                        <div>Lun</div>
                        <div>Mar</div>
                        <div>Mer</div>
                        <div>Jeu</div>
                        <div>Ven</div>
                        <div>Sam</div>";
                    } else {
                        echo "<div>Sun</div>
                        <div>Mon</div>
                        <div>Tue</div>
                        <div>Wed</div>
                        <div>Thu</div>
                        <div>Fri</div>
                        <div>Sat</div>";
                    }
                ?>
            </div>
            <div class="calendar-dates">
                <!-- Dates will be populated here -->
            </div>
            </div>
        </div>
        <div id='hours-selection'></div>
    </div>

<?php


//}

//get number of pages to build form
	$sql = "SELECT COUNT(*) as page_count FROM prototype_line WHERE head_id = '" . $quiz_id . "' AND last_on_page = 1;";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $page_count = $data["page_count"];
    $page_count = $page_count + 1;
    $page_number = 1;

        echo "<div class='dw3_quiz_data' style='top:". $INDEX_HEADER_HEIGHT."px;bottom:0px; background-color:".$PAGE_BG.";'><form onsubmit='return false;' id='dw3_quiz_form'>";
        echo "<div id='quiz_page1' style='position:absolute;top:0px;left:0px;bottom:30px;width:100%;transition: left 1.2s ease-in-out;overflow-x:hidden;'>
                
                <div class='dw3_quiz_foot'>
                    <button class='no-effect' onclick='dw3_go_home();' style='float:left;padding:8px 12px 6px 12px;height:38px;'>
                        <span class='dw3_font'>ď</span> "; if ($USER_LANG == "FR"){ echo "Annuler"; }else{echo "Cancel";}
                    echo "</button>";
                    if ($page_number < $page_count){
                        echo "<button class='no-effect' onmouseup=\"openPAGE('2');\" style='float:right;padding:8px 12px 6px 12px;height:38px;'>
                            <span class='dw3_font'>Ĺ</span> "; if ($USER_LANG == "FR"){ echo "Continuer"; }else{echo "Continue";}
                        echo "</button>";
                    }
                echo "</div>";

            if ($allow_user_reedit=="1"){
                if ($report_id != "0" && $report_id != ""){
                    echo "<div class='dw3_page' style='background:#fff;color:#222;text-align:left;font-size:0.8em;margin:0px;'><div style='margin:10px;'>";
                    if($report_lang == "FR"){
                        echo "Dernière modification : <strong>".substr($report_completed,0,10)."</strong> " . substr($report_completed,11,8) . ".</div></div><br>";
                    } else {
                        echo "Last modification : <strong>".substr($report_completed,0,10)."</strong> " . substr($report_completed,11,8) . ".</div></div><br>";
                    }
                } else {
                    echo "<div class='dw3_page' style='line-height:1;background:#".$CIE_COLOR7.";color:#".$CIE_COLOR6.";text-align:left;font-size:0.8em;margin:0px;text-align:center;'><div style='margin:10px;'>";
                    if($report_lang == "FR"){
                        echo "Si vous avez déjà remplis le document et que vous voulez le mettre à jour, utilisez le document dans votre <a href='/client'><u>Espace-Client</u></a>.</div></div><br>";
                    } else{
                        echo "If you have already completed the document and want to update it, use the document in your <a href='/client'><u>Customer Zone</u></a>.</div></div><br>";
                    }
                }
            }

            echo "<div class='dw3_page' style='line-height:1;background:#".$CIE_COLOR5.";color:#".$CIE_COLOR0.";'>";
            if($report_lang == "FR"){
                echo "<div style='width:98%;text-align:right;margin:3px;font-size:0.7em;'><span style='color:red;font-weight:bold;'>*</span> Seuls les champs marqués d'un astérisque rouge sont requis</div>";
            } else {
                echo "<div style='width:98%;text-align:right;margin:3px;font-size:0.7em;'><span style='color:red;font-weight:bold;'>*</span> Only fields marked with a red asterisk are required</div>";
            }
            echo "<h2 style='margin-top:15px;'>".$head_name."</h2>".$head_desc."<hr class='colored'>";


$all_sig_done=true;
$sql = "SELECT A.*, IFNULL(B.value1,'') AS value1, IFNULL(B.value2,'') AS value2, IFNULL(B.value3,'') AS value3, IFNULL(B.value4,'') AS value4, IFNULL(B.value5,'') AS value5, IFNULL(B.value6,'') AS value6, IFNULL(B.value7,'') AS value7, IFNULL(B.value8,'') AS value8, IFNULL(B.value9,'') AS value9, IFNULL(B.value0,'') AS value0
        FROM prototype_line A
        LEFT JOIN prototype_data B ON B.line_id = A.id AND B.report_id = '".$report_id."' 
        WHERE A.head_id = '" . $quiz_id . "' ORDER BY A.position ASC;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
     while($row = $result->fetch_assoc()) {
        if($report_lang == "FR"){
            $line_name = $row["name_fr"];
            $line_desc = $row["description_fr"];
            $line_c1 = $row["choice_name1"];
            $line_c2 = $row["choice_name2"];
            $line_c3 = $row["choice_name3"];
            $line_c4 = $row["choice_name4"];
            $line_c5 = $row["choice_name5"];
            $line_c6 = $row["choice_name6"];
            $line_c7 = $row["choice_name7"];
            $line_c8 = $row["choice_name8"];
            $line_c9 = $row["choice_name9"];
            $line_c0 = $row["choice_name0"];
        } else {
            $line_name = $row["name_en"];
            $line_desc = $row["description_en"];
            $line_c1 = $row["choice_name1_en"];
            $line_c2 = $row["choice_name2_en"];
            $line_c3 = $row["choice_name3_en"];
            $line_c4 = $row["choice_name4_en"];
            $line_c5 = $row["choice_name5_en"];
            $line_c6 = $row["choice_name6_en"];
            $line_c7 = $row["choice_name7_en"];
            $line_c8 = $row["choice_name8_en"];
            $line_c9 = $row["choice_name9_en"];
            $line_c0 = $row["choice_name0_en"];
        }
        if($row["mandatory"]=="1"){
            $req=" title='Requis' ";
            $required_field = " <span style='color:red;font-weight:bold;'>*</span>";
        }else{
            $req='';
            $required_field = "";
        }
        if($row["box_size"]=="SMALL"){
            $box_size = "200px";
        } else if($row["box_size"]=="MEDIUM"){
            $box_size = "335px";
        } else if($row["box_size"]=="LARGE"){
            $box_size = "97%";
        } else {
            $box_size = "335px";
        }
        if ($row["response_align"] == ""){
            $line_position = "";
        } else if (strtolower($row["response_align"]) == "center"){
            $line_position = "width:100%;text-align:center;";
        } else if (strtolower($row["response_align"]) == "left"){
            $line_position = "width:100%;text-align:left;";
        } else if (strtolower($row["response_align"]) == "right"){
            $line_position = "width:100%;text-align:right;";
        }
//NONE
        if($row["response_type"] == "NONE"){
            if(trim($line_name) != ""){
                echo "<h4 style='padding:10px 0px 5px 0px;background:#".$CIE_COLOR6.";color:#".$CIE_COLOR7.";'>".$line_name."</h4>";
            } else {
                echo "<br class='br_small'>";
            }
            if($line_desc != ""){
                echo "<br class='br_small'><div style='font-size:0.8em;font-weight:normal;width:100%;text-align:center;'><div style='text-align:left;padding:5px 20px;'>".$line_desc."</div></div>";
            }
//TEXT
        } else if($row["response_type"] == "TEXT"){
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."";
            if($line_desc != ""){
                echo "<div style='font-size:0.7em;'font-weight:normal;'>".$line_desc."</div><br class='br_small'>";
            }
            if ($form_disabled == ""){
                echo "<input data-page='".$page_number."' value=\"".$row["value1"]."\" ".$req." id='lnVAL1_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
            } else {
                echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value1"]."</b></u></div>";
            }
            echo "</div>";
//MULTI-TEXT
        } else if($row["response_type"] == "MULTI-TEXT"){
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field." ";
            if($line_desc != ""){
                echo "<div style='font-size:0.7em;'font-weight:normal;'>".$line_desc."</div>";
            }
            //valeur1
            if($line_c1 != ""){
                echo "<br class='br_small'>".$line_c1;
            }
            if ($form_disabled == ""){
                echo "<input data-page='".$page_number."' value=\"".$row["value1"]."\" ".$req." id='lnVAL1_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
            } else {
                echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;padding:3px;".$line_position."'><u><b>".$row["value1"]."</b></u></div>";
            }
            //valeur2
            if($line_c2 != ""){
                echo "<br class='br_small'>".$line_c2;
                if ($form_disabled == ""){
                    echo "<input data-page='".$page_number."' value=\"".$row["value2"]."\" ".$req." id='lnVAL2_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
                } else {
                    echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;padding:3px;".$line_position."'><u><b>".$row["value2"]."</b></u></div>";
                }            }
            //valeur3
            if($row["choice_name3"] != ""){
                echo "<br class='br_small'>".$row["choice_name3"];
                if ($form_disabled == ""){
                    echo "<input data-page='".$page_number."' value=\"".$row["value3"]."\" ".$req." id='lnVAL3_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
                } else {
                    echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;padding:3px;".$line_position."'><u><b>".$row["value3"]."</b></u></div>";
                }            }
            //valeur4
            if($line_c4 != ""){
                echo "<br class='br_small'>".$line_c4;
                if ($form_disabled == ""){
                    echo "<input data-page='".$page_number."' value=\"".$row["value4"]."\" ".$req." id='lnVAL4_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
                } else {
                    echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;padding:3px;".$line_position."'><u><b>".$row["value4"]."</b></u></div>";
                }            }
            //valeur5
            if($line_c5 != ""){
                echo "<br class='br_small'>".$line_c5;
                if ($form_disabled == ""){
                    echo "<input data-page='".$page_number."' value=\"".$row["value5"]."\" ".$req." id='lnVAL5_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
                } else {
                    echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;padding:3px;".$line_position."'><u><b>".$row["value5"]."</b></u></div>";
                }            }
            //valeur6
            if($line_c6 != ""){
                echo "<br class='br_small'>".$line_c6;
                if ($form_disabled == ""){
                    echo "<input data-page='".$page_number."' value=\"".$row["value6"]."\" ".$req." id='lnVAL6_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
                } else {
                    echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;padding:3px;".$line_position."'><u><b>".$row["value6"]."</b></u></div>";
                }            }
            //valeur7
            if($line_c7 != ""){
                echo "<br class='br_small'>".$line_c7;
                if ($form_disabled == ""){
                    echo "<input data-page='".$page_number."' value=\"".$row["value7"]."\" ".$req." id='lnVAL7_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
                } else {
                    echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;padding:3px;".$line_position."'><u><b>".$row["value7"]."</b></u></div>";
                }            }
            //valeur8
            if($line_c8 != ""){
                echo "<br class='br_small'>".$line_c8;
                if ($form_disabled == ""){
                    echo "<input data-page='".$page_number."' value=\"".$row["value8"]."\" ".$req." id='lnVAL8_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
                } else {
                    echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;padding:3px;".$line_position."'><u><b>".$row["value8"]."</b></u></div>";
                }            }
            //valeur9
            if($line_c9 != ""){
                echo "<br class='br_small'>".$line_c9;
                if ($form_disabled == ""){
                    echo "<input data-page='".$page_number."' value=\"".$row["value9"]."\" ".$req." id='lnVAL9_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
                } else {
                    echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;padding:3px;".$line_position."'><u><b>".$row["value9"]."</b></u></div>";
                }            }
            //valeur0
            if($line_c0 != ""){
                echo "<br class='br_small'>".$line_c0;
                if ($form_disabled == ""){
                    echo "<input data-page='".$page_number."' value=\"".$row["value0"]."\" ".$req." id='lnVAL0_".$row["id"]."' type='text' style='vertical-align:middle;margin: 3px 0px;".$line_position."'>";
                } else {
                    echo "<div style='margin-left:7px;display:inline-block;vertical-align:middle;padding:3px;".$line_position."'><u><b>".$row["value0"]."</b></u></div>";
                }            }
            echo "</div>";
//CHECKBOX        
        } else if($row["response_type"] == "CHECKBOX"){
            if ($row["value1"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
            if ($row["product_id"]!="0"){$product_id = " name='".$row["product_id"]."' ";}else{ $product_id = " ";}
            if ($form_disabled == ""){
                echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";font-weight:normal;'><label for='lnVAL1_".$row["id"]."'>".$line_name.$required_field."</label><input data-page='".$page_number."' ".$product_id." ".$checked_value." ".$req." id='lnVAL1_".$row["id"]."' type='checkbox' style='float:right;margin:5px 20px 5px 5px;'><div style='font-size:0.7em;font-weight:normal;'>".$line_desc."</div></div>";
            } else {
                echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";font-weight:normal;'><label>".$line_name.$required_field."</label><input data-page='".$page_number."' ".$product_id." ".$checked_value." ".$req." id='lnVAL1_".$row["id"]."' type='checkbox' style='float:right;margin:5px 20px 5px 5px;pointer-events: none;'><div style='font-size:0.7em;font-weight:normal;'>".$line_desc."</div></div>";
            }
//YES/NO      
        } else if($row["response_type"] == "YES/NO"){
            if ($row["value1"]=="YES"||$row["value1"]=="OUI"){$selected_value = " selected ";}else{ $checked_value = " ";}
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."";
            if($line_desc != ""){
                echo "<br class='br_small'><div style='font-size:0.7em;font-weight:normal;'>".$line_desc."</div>";
            }
            echo "<select data-page='".$page_number."' id='lnVAL1_".$row["id"]."' style='width:120px;float:right;text-align:center;margin: 3px 0px;' ".$req." ".$form_disabled.">";
            //ND
                echo "<option value=''>Non défini</option>";
            //OUI
                echo "<option ";if ($row["value1"]=="YES"||$row["value1"]=="OUI"){echo " selected ";} echo ">OUI</option>";
            //NON
                echo "<option ";if ($row["value1"]=="NO"||$row["value1"]=="NON"){echo " selected ";} echo ">NON</option>";
            echo "</select></div>";
//CHOICE        
        } else if($row["response_type"] == "CHOICE"){
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."";
            echo "<div style='float:right;'>";
            if($row["choice_img1"]!="" && $row["choice_img2"]!=""){
                echo "<button class='no-effect' style='padding:8px;' onclick='chooseFromImage(".$row["id"].");'>✨ Choisir</button>";
            }
            echo "<select data-page='".$page_number."' id='lnVAL1_".$row["id"]."' style='max-width:100%;width:auto;margin: 3px 0px;' ".$req." ".$form_disabled.">";
            //valeur1
                echo "<option";if ($row["value1"]==$line_c1){echo " selected ";} echo ">".$line_c1."</option>";
            //valeur2
                echo "<option";if ($row["value1"]==$line_c2){echo " selected ";} echo ">".$line_c2."</option>";
            //valeur3
            if($line_c3 != ""){
                echo "<option";if ($row["value1"]==$line_c3){echo " selected ";} echo ">".$line_c3."</option>";
            }
            //valeur4
            if($line_c4 != ""){
                echo "<option";if ($row["value1"]==$line_c4){echo " selected ";} echo ">".$line_c4."</option>";
            }
            //valeur5
            if($line_c5 != ""){
                echo "<option";if ($row["value1"]==$line_c5){echo " selected ";} echo ">".$line_c5."</option>";
            }
            //valeur6
            if($line_c6 != ""){
                echo "<option";if ($row["value1"]==$line_c6){echo " selected ";} echo ">".$line_c6."</option>";
            }
            //valeur7
            if($line_c7 != ""){
                echo "<option";if ($row["value1"]==$line_c7){echo " selected ";} echo ">".$line_c7."</option>";
            }
            //valeur6
            if($line_c8 != ""){
                echo "<option";if ($row["value1"]==$line_c8){echo " selected ";} echo ">".$line_c8."</option>";
            }
            //valeur6
            if($line_c9 != ""){
                echo "<option";if ($row["value1"]==$line_c9){echo " selected ";} echo ">".$line_c9."</option>";
            }
            //valeur6
            if($line_c0 != ""){
                echo "<option";if ($row["value1"]==$line_c0){echo " selected ";} echo ">".$line_c0."</option>";
            }
            echo "</select></div>";
            if($line_desc != ""){
                echo "<br class='br_small'><div style='font-size:0.7em;display:inline-block;font-weight:normal;'>".$line_desc."</div>";
            }
            echo "</div>";
//MULTI-CHOICE
        } else if($row["response_type"] == "MULTI-CHOICE"){
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."";
            if($line_desc != ""){
                echo "<br class='br_small'><div style='font-size:0.7em;display:inline-block;font-weight:normal;'>".$line_desc."</div>";
            }
            echo "<div style='float:right;margin-right:5px;text-align:right;'>";
            //valeur1
            if ($row["value1"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
                echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL1_".$row["id"]."'>".$line_c1."</label> <input data-page='".$page_number."' ".$checked_value ." id='lnVAL1_".$row["id"]."' type='checkbox' style='margin:2px;' ".$form_disabled."></div>";
            //valeur2
            if ($row["value2"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
                echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL2_".$row["id"]."'>".$line_c2."</label> <input data-page='".$page_number."' ".$checked_value ." id='lnVAL2_".$row["id"]."' type='checkbox' style='margin:2px;' ".$form_disabled."></div>";
            //valeur3
            if ($row["value3"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
            if($line_c3 != ""){
                echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL3_".$row["id"]."'>".$line_c3."</label> <input data-page='".$page_number."' ".$checked_value ." id='lnVAL3_".$row["id"]."' type='checkbox' style='margin:2px;' ".$form_disabled."> </div>";
            }
            //valeur4
            if ($row["value4"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
            if($line_c4 != ""){
                echo " <div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL4_".$row["id"]."'>".$line_c4."</label> <input data-page='".$page_number."' ".$checked_value ." id='lnVAL4_".$row["id"]."' type='checkbox' style='margin:2px;' ".$form_disabled."> </div>";
            }
            //valeur5
            if ($row["value5"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
            if($line_c5 != ""){
                echo " <div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL5_".$row["id"]."'>".$line_c5."</label> <input data-page='".$page_number."' ".$checked_value ." id='lnVAL5_".$row["id"]."' type='checkbox' style='margin:2px;' ".$form_disabled."> </div>";
            }
            //valeur6
            if ($row["value6"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
            if($line_c6 != ""){
                echo "<div style='border-bottom:1px dotted lightgrey;'> <label for='lnVAL6_".$row["id"]."'>".$line_c6."</label> <input data-page='".$page_number."' ".$checked_value ." id='lnVAL6_".$row["id"]."' type='checkbox' style='margin:2px;' ".$form_disabled."> </div>";
            }
            //valeur7
            if ($row["value7"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
            if($line_c7 != ""){
                echo " <div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL7_".$row["id"]."'>".$line_c7."</label> <input data-page='".$page_number."' ".$checked_value ." id='lnVAL7_".$row["id"]."' type='checkbox' style='margin:2px;' ".$form_disabled."> </div>";
            }
            //valeur8
            if ($row["value8"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
            if($line_c8 != ""){
                echo "<div style='border-bottom:1px dotted lightgrey;'> <label for='lnVAL8_".$row["id"]."'>".$line_c8."</label> <input data-page='".$page_number."' ".$checked_value ." id='lnVAL8_".$row["id"]."' type='checkbox' style='margin:2px;' ".$form_disabled."> </div>";
            }
            //valeur9
            if ($row["value9"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
            if($line_c9 != ""){
                echo "<div style='border-bottom:1px dotted lightgrey;'> <label for='lnVAL9_".$row["id"]."'>".$line_c9."</label> <input data-page='".$page_number."' ".$checked_value ." id='lnVAL9_".$row["id"]."' type='checkbox' style='margin:2px;' ".$form_disabled."> </div>";
            }
            //valeur6
            if ($row["value0"]=="1"){$checked_value = " checked ";}else{ $checked_value = " ";}
            if($line_c0 != ""){
                echo "<div style='border-bottom:1px dotted lightgrey;'> <label for='lnVAL0_".$row["id"]."'>".$line_c0."</label> <input data-page='".$page_number."' ".$checked_value ." id='lnVAL0_".$row["id"]."' type='checkbox' style='margin:2px;' ".$form_disabled."></div>";
            }
            echo "</div></div>";
//FILE
        } else if($row["response_type"] == "FILE"){
            if ($row["value1"]!='' && $row["value1"] != "undefined"){
                if ($head_parent_table == "customer"){
                    if ($head_parent_id != 0){
                        echo "<div class='dw3_box' style='min-height:20px;:'>".$line_name.$required_field."<br class='br_small'><span style='font-size:0.7em;font-weight:normal;'>".$line_desc."</span><input data-page='".$page_number."' ".$req." id='lnVAL1_".$row["id"]."' style='display:none;' type='file' value='".$row["value1"]."' ".$form_disabled."><div style='width:100%;text-align:center;'><img id='lnFILE_".$row["id"]."' src='/fs/customer/".$head_parent_id."/".$row["value1"]."' style='width:300px;'><button type='button' onclick=\"eraseFile('".$row["id"]."',this);\"> Modifier </button></div></div>";
                    } else {
                        echo "<div class='dw3_box' style='min-height:20px;:'>".$line_name.$required_field."<br class='br_small'><span style='font-size:0.7em;font-weight:normal;'>".$line_desc."</span><input data-page='".$page_number."' ".$req." id='lnVAL1_".$row["id"]."' style='display:none;' type='file' value='".$row["value1"]."' ".$form_disabled."><div style='width:100%;text-align:center;'><img id='lnFILE_".$row["id"]."' src='/fs/customer/upload/".$row["value1"]."' style='width:300px;'><button type='button' onclick=\"eraseFile('".$row["id"]."',this);\"> Modifier </button></div></div>";
                    }
                } else if ($head_parent_table == "user"){
                    if ($head_parent_id != 0){
                        echo "<div class='dw3_box' style='min-height:20px;:'>".$line_name.$required_field."<br class='br_small'><span style='font-size:0.7em;font-weight:normal;'>".$line_desc."</span><input data-page='".$page_number."' ".$req." id='lnVAL1_".$row["id"]."' style='display:none;' type='file' value='".$row["value1"]."' ".$form_disabled."><div style='width:100%;text-align:center;'><img id='lnFILE_".$row["id"]."' src='/fs/user/".$head_parent_id."/".$row["value1"]."' style='width:300px;'><button type='button' onclick=\"eraseFile('".$row["id"]."',this);\"> Modifier </button></div></div>";
                    } else {
                        echo "<div class='dw3_box' style='min-height:20px;:'>".$line_name.$required_field."<br class='br_small'><span style='font-size:0.7em;font-weight:normal;'>".$line_desc."</span><input data-page='".$page_number."' ".$req." id='lnVAL1_".$row["id"]."' style='display:none;' type='file' value='".$row["value1"]."' ".$form_disabled."><div style='width:100%;text-align:center;'><img id='lnFILE_".$row["id"]."' src='/fs/user/upload/".$row["value1"]."' style='width:300px;'><button type='button' onclick=\"eraseFile('".$row["id"]."',this);\"> Modifier </button></div></div>";
                    }
                }
            } else {
                echo "<div class='dw3_box' style='min-height:20px;:'>".$line_name.$required_field."<br class='br_small'><span style='font-size:0.7em;font-weight:normal;'>".$line_desc."</span><input data-page='".$page_number."' ".$req." id='lnVAL1_".$row["id"]."' type='file'></div>";
            }
//COLOR
        } else if($row["response_type"] == "COLOR"){
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."<br class='br_small'><span style='font-size:0.7em;font-weight:normal;'>".$line_desc."</span><input data-page='".$page_number."' value=\"".$row["value1"]."\" ".$req." id='lnVAL1_".$row["id"]."' type='color' ".$form_disabled."></div>";
//PASSWORD
        } else if($row["response_type"] == "PASSWORD"){
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."<br class='br_small'><span style='font-size:0.7em;font-weight:normal;'>".$line_desc."</span><input data-page='".$page_number."' value=\"".$row["value1"]."\" ".$req." id='lnVAL1_".$row["id"]."' type='password' ".$form_disabled."></div>";
//DATE
        } else if($row["response_type"] == "DATE"){
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."<br class='br_small'><span style='font-size:0.7em;font-weight:normal;'>".$line_desc."</span><input data-page='".$page_number."' value=\"".$row["value1"]."\" ".$req." id='lnVAL1_".$row["id"]."' type='date' style='width:auto;float:right;' ".$form_disabled."></div>";
//TIME
        } else if($row["response_type"] == "TIME"){
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."<br class='br_small'><span style='font-size:0.7em;font-weight:normal;'>".$line_desc."</span><input data-page='".$page_number."' value=\"".$row["value1"]."\" ".$req." id='lnVAL1_".$row["id"]."' type='time' style='width:auto;float:right;' ".$form_disabled."></div>";
//DATE ET HEURE DE RAMASSAGE
        } else if($row["response_type"] == "PICKTIME"){
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."<br class='br_small'><span style='font-size:0.7em;font-weight:normal;'>".$line_desc."</span><input data-page='".$page_number."' value=\"".$row["value1"]."\" ".$req." id='lnVAL1_".$row["id"]."' type='text' style='width:auto;float:right;' disabled><button onclick=\"openCALENDAR('lnVAL1_".$row["id"]."')\">✨ Choisir</button></div>";
//SIGNATURE
        } else if($row["response_type"] == "SIGNATURE"){
            $RNDSEQ = rand(10,100000);
            $sig_path = $_SERVER['DOCUMENT_ROOT'] . "/fs/customer/upload/doc-sig-". $report_id . "-".$row["id"].".png";
            $sig_path_pub = "/fs/customer/upload/doc-sig-". $report_id . "-".$row["id"].".png";
            if (file_exists($sig_path)){
                echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."<br class='br_small'><span style='font-weight:normal;font-size:0.7em;'>".$line_desc."</span>
                <input data-page='".$page_number."' value=\"".$row["value1"]."\" id='lnVAL1_".$row["id"]."' style='display:none;' type='text'>
                <img src='" . $sig_path_pub . "?t=". $RNDSEQ. "' style='width:auto;max-width:335px;height:90px;'>
                </div>";                
            } else {
                $all_sig_done=false;
                echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'>".$line_name.$required_field."<br class='br_small'><span style='font-weight:normal;font-size:0.7em;'>".$line_desc."</span>
                <input data-page='".$page_number."' value=\"".$row["value1"]."\" id='lnVAL1_".$row["id"]."' style='display:none;' type='text'>
                <img id='signature-img_".$row["id"]."' src='' style='width:auto;max-width:335px;height:90px;position:relative;display:none;'>
                <canvas class='signature_pads' id='signature-pad_".$row["id"]."' width='335' height='90' style=\"  font-family: 'Imperial';font-style:normal;font-weight: 400;font-size: 40px;\"></canvas>
                <br><button type='button' id='signature-clear_".$row["id"]."' class='grey no-effect' style='border-radius:5px;float:left;'>♻ <span> Effacer </span></button>
                <button type='button' onclick=\"getSIGNATURE('".$row["id"]."')\" class='blue no-effect' style='border-radius:5px;float:right;'>🖉 <span> Auto </span></button>
                </div>";
            }
        } else if($row["response_type"] == "SIG-USER"){
            $RNDSEQ = rand(10,100000);
            echo "<div class='dw3_box' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'>".$line_desc;
            $sig_path = $_SERVER['DOCUMENT_ROOT'] . "/fs/user/".$report_user_created."/signature.png";
            $sig_path_pub = "/fs/user/".$report_user_created."/signature.png";
            if (file_exists($sig_path)){
                echo "<div style='width:100%;text-align:center;'><img src='" . $sig_path_pub . "?t=". $RNDSEQ."' style='width:auto;height:90px;max-width:335px;'></div>"; 

            }
            echo "</div>";
        }
        if($row["last_on_page"] == "1"){
            //end of quiz_pageX & dw3_page
            echo "</div></div>";
            $page_number++;
            echo "<div id='quiz_page".$page_number."' style='position:absolute;top:0px;left:100%;bottom:30px;width:100%;transition: left 1.2s ease-in-out;overflow-x:hidden;'>
                    <div class='dw3_quiz_foot'>
                        <button class='no-effect' onmouseup=\"openPAGE('".($page_number-1)."');\" style='float:left;padding:8px 12px 6px 12px;height:38px;'>
                            <span class='dw3_font'>ĸ</span> "; if ($USER_LANG == "FR"){ echo "Retour"; }else{echo "Go Back";}
                        echo "</button>";
                        if ($page_number < $page_count){
                            echo "<button class='no-effect' onmouseup=\"openPAGE('".($page_number+1)."');\" style='float:right;padding:8px 12px 6px 12px;height:38px;'>
                                <span class='dw3_font'>Ĺ</span> "; if ($USER_LANG == "FR"){ echo "Continuer"; }else{echo "Continue";}
                            echo "</button>";
                        } else {
                            /* echo "<button class='no-effect' onmouseup=\"openPAGE('1');\" style='float:right;padding:8px 12px 6px 12px;height:38px;'>
                                &#11208; "; if ($USER_LANG == "FR"){ echo "Continuer"; }else{echo "Continue";}
                            echo "</button>"; */                      
                        }
                //end of dw3_quiz_foot
                echo "</div>";
                echo "<div class='dw3_page' style='line-height:1;background:#".$CIE_COLOR5.";color:#".$CIE_COLOR0.";'>";
        }
    }
}

//end of dw3_page
echo "</div>";

    //last page
    //$page_number++;
    /* echo "<div id='quiz_page".$page_number."' style='position:absolute;top:0px;left:100%;bottom:30px;width:100%;transition: left 1.2s ease-in-out;overflow-x:hidden;'>
            <div class='dw3_quiz_foot'>
                <button class='no-effect' onmouseup=\"openPAGE('".($page_number-1)."');\" style='float:left;padding:8px 12px 6px 12px;height:38px;'>
                    <span class='dw3_font'>ĸ</span> "; if ($USER_LANG == "FR"){ echo "Retour"; }else{echo "Go Back";}
                echo "</button>";
                if ($page_number < $page_count){
                    echo "<button class='no-effect' onmouseup=\"openPAGE('".($page_number+1)."');\" style='float:right;padding:8px 12px 6px 12px;height:38px;'>
                        <span class='dw3_font'>Ĺ</span> "; if ($USER_LANG == "FR"){ echo "Continuer"; }else{echo "Continue";}
                    echo "</button>";
                } else { */
                    /* echo "<button class='no-effect' onmouseup=\"openPAGE('1');\" style='float:right;padding:8px 12px 6px 12px;height:38px;'>
                        &#11208; "; if ($USER_LANG == "FR"){ echo "Continuer"; }else{echo "Continue";}
                    echo "</button>"; */                      
                //}
            //end of dw3_quiz_foot
            //echo "</div>";
            echo "<div class='dw3_page' style='line-height:1;background:#".$CIE_COLOR5.";color:#".$CIE_COLOR0.";min-height:63vh;'>";
            echo "<br><div class='dw3_box'";
                if ($USER_EML != ""){
                    //echo " style='display:none;'";
                }
                if ($form_disabled == "" && $link_to_user == "1"){
                    echo "><small>Veuillez confirmer le courriel associé à votre <strong>compte-<u>client</u></strong>, s'il y a lieu.</small><input type='text' value='".$USER_EML."' id='report_user_eml' style='text-align:center;'></div>";
                } else {
                    echo " style='display:none;'><small>Veuillez confirmer le courriel associé à votre <strong>compte-<u>client</u></strong>, s'il y a lieu.</small><input type='text' value='".$USER_EML."' id='report_user_eml' style='text-align:center;display:none;'></div>";
                }

$show_captcha = false;
if ($captcha_required != "0"){
    if ($report_id != "0" && $report_id != ""){
        if ($allow_user_reedit=="1" || !$all_sig_done){
                $show_captcha = true;
        }
    } else {
        $show_captcha = true;
    }
}
echo "<br><div class='dw3_box'>";
    if ($show_captcha){
        if($report_lang == "FR"){
            echo "Veuillez entrer le Captcha: <span style='color:red;font-weight:bold;'>*</span>";
        } else {
            echo "Please Enter the Captcha: <span style='color:red;font-weight:bold;'>*</span>";
        }
            echo "<div style='text-align:center;margin-top:5px;'><img src='/sbin/captcha.php' alt='CAPTCHA' id='captcha_image'>
                <button id='captcha_refresh' style='cursor:pointer;font-size:20px;margin-left:5px;' class='no-effect'>♻</button><br>
            <input type='text' id='captcha_text' pattern='[A-Z]{6}' oninput='this.value=this.value.toUpperCase();' style='width:75%'></div>
        
        ";
    }

    if ($report_id != "0" && $report_id != ""){
        if ($allow_user_reedit=="1" || !$all_sig_done){
            if($report_lang == "FR"){
                echo "<div style='text-align:center;width:100%;'><button style='padding:15px;margin:20px 0px 10px 0px;' onclick=\"sendQUIZ('" . $quiz_id . "','".$report_id."');\"><span class='dw3_font'>å</span> Mettre à jour</button></div>";
            } else {
                echo "<div style='text-align:center;width:100%;'><button style='padding:15px;margin:20px 0px 10px 0px;' onclick=\"sendQUIZ('" . $quiz_id . "','".$report_id."');\"><span class='dw3_font'>å</span> Update</button></div>";
            }
        }
    } else {
        if($report_lang == "FR"){
            echo "<div style='text-align:center;width:100%;'><button style='padding:15px;margin:20px 0px 10px 0px;' onclick=\"sendQUIZ('" . $quiz_id . "','".$report_id."');\"><span class='dw3_font'>å</span> Transmettre</button></div>";
        } else {
            echo "<div style='text-align:center;width:100%;'><button style='padding:15px;margin:20px 0px 10px 0px;' onclick=\"sendQUIZ('" . $quiz_id . "','".$report_id."');\"><span class='dw3_font'>å</span> Send</button></div>";
        }
    }
//end of captcha and send & dw3_page
echo "</div></div>";




    //the real footer
    echo "<div style='position:fixed;text-align:left;bottom:0px;left:0px;right:0px;height:30px;background:#".$CIE_COLOR6.";color:#".$CIE_COLOR7.";'>
    <div style='padding:8px 20px;display:inline-block;'>Page: <div id='quiz_page_number' style='font-weight:bold;display:inline-block;'>1 / ".$page_count."</div></div>
    ";
    if ($head_total_type == "CASH"){
        echo "<div style='padding:5px;display:inline-block;float:right;'><span>Sous-total:</span> <div id='report_total' style='vertical-align:bottom;display:inline-block;font-weight:bold;font-size:20px;'></div></div>";
    }
    //end of the real footer
    echo "</div>";

?>
<div style='display:inline-block;max-width:1080px;width:100%;background-color:#<?php echo $CIE_COLOR5; ?>;color:#<?php echo $CIE_COLOR0; ?>;padding:20px 0px;'>
<?php
        if ($CIE_COOKIES_IMG == ""){ 
            echo "<button onclick='dw3_cookie_pref();'>";
                if($USER_LANG == "FR"){ 
                    echo "Préférences en matière de conservation des données"; 
                }else{
                    echo "Data retention preferences";
                }
            echo "</button>";
        } else {
            echo "<img alt='Image pour les cookies' title='"; 
            if($USER_LANG == "FR"){ 
                echo "Préférences en matière de conservation des données"; 
            }else{
                echo "Data retention preferences";
            }
            echo "' style='cursor:pointer;margin:10px;width:auto;height:2vw;min-height:40px;z-index:+1;' src='/pub/img/cookies/". $CIE_COOKIES_IMG."' onclick='dw3_cookie_pref();'>";
        }
?>
    <div style="font-size:0.7em;padding:5px;width:100%;max-width:100%;overflow:hidden;display:inline-block;text-align:center;">
        <a href="/legal/PRIVACY.html" target="_blank" style='color:unset;'><u><?php if($USER_LANG == "FR"){ echo "Politique de confidentialité"; }else{echo "Privacy Policy";} ?></u></a>
        | <a href="/legal/LICENSE.html" target="_blank" style='color:unset;'><u><?php if($USER_LANG == "FR"){ echo "Conditions d'utilisation"; }else{echo "Terms of use";}?></u></a>
    </div>
    <div style='font-size:0.65em;padding:3px;'>
        <?php if($USER_LANG == "FR"){ echo "Créé avec"; }else{echo "Created with";} ?> Design Web 3D | <a href='https://dw3.ca'>https://dw3.ca</a>
    </div>
    <div style='margin-bottom:-3px;overflow:hidden;font-size:20px;width:100%;height:25px;max-height:25px;padding-top:5px;'>
    © <?php echo $CIE_NOM . " " .  date("Y"); ?>
    </div>
</div>
<?php
//end of last page
echo "</div>";
//end of quiz_pageX
echo "</div>";
//end of form 
echo "</form>";
//end of dw3_quiz_data
echo "</div>";


?>

<script src="/pub/js/signature_pad.min.js" referrerpolicy="no-referrer"></script> 
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/pub/js/page.js.php"; ?>
<script>
var quiz_id = "<?php echo $quiz_id; ?>";
var report_id = "<?php echo $report_id; ?>";
var USER_EML = "<?php echo $USER_EML; ?>";
var PAGE_ID = "<?php echo $PAGE_ID; ?>";
var USER_LANG = "<?php echo $report_lang; ?>";
var TOTAL_TYPE = "<?php echo $head_total_type; ?>";
var PAGE_COUNT = "<?php echo $page_count; ?>";
var CIE_PK_F1 = '<?php echo $CIE_PK_F1; ?>'; //delais de ramassage chiffre
var CIE_PK_F2 = '<?php echo $CIE_PK_F2; ?>'; //delais de ramassage hour/day/week/month
var signaturePads = [];

if (document.getElementById("captcha_refresh")){
    var refreshButton = document.getElementById("captcha_refresh");
    refreshButton.onclick = function() {
    document.getElementById("captcha_image").src = '/sbin/captcha.php?' + Date.now();
    }
}

//$(document).ready(function (){
    //The simplest thing to do in the absence of a framework that does all the cross-browser compatibility for you is to just put a call to your code at the end of the body. This is faster to execute than an onload handler because this waits only for the DOM to be ready, not for all images to load. And, this works in every browser.
    document.getElementById("dw3_body").innerHTML = "";
    bREADY = true;
    //var canvas = document.getElementById("signature-pad");
    var canvas_tags = document.getElementsByClassName("signature_pads");
    for (var i=0, max=canvas_tags.length; i < max; i++) {
        signaturePads[i] = new SignaturePad(canvas_tags[i], {
        backgroundColor: 'rgb(200,200,200)'
        });
        //let sValId = canvas_tags[i].id;
        //let sValLenght = sValId.length;
        let sLineId = canvas_tags[i].id.substring(14);
        //let sLineId = sValId.substring(14);
/*         document.getElementById("signature-clear_"+sLineId).addEventListener('click', function(){
            const pad_i = i;
            signaturePads[pad_i].clear();
        }); */
        someInput = document.getElementById("signature-clear_"+sLineId);
        someInput.addEventListener('click', clear_sig, false);
        someInput.myParam = i;
        someInput.myParam2 = sLineId;
        function clear_sig(evt) {
            signaturePads[evt.currentTarget.myParam].clear();
            document.getElementById("signature-pad_"+evt.currentTarget.myParam2).width="335";
            document.getElementById("signature-pad_"+evt.currentTarget.myParam2).height="90";
            //document.getElementById("signature-pad_"+myParam2).style.width="335px";
            //document.getElementById("signature-pad_"+myParam2).style.height="90px";
            document.getElementById("signature-pad_"+evt.currentTarget.myParam2).style.backgroundColor = "rgb(200,200,200)";
            document.getElementById("signature-pad_"+evt.currentTarget.myParam2).style.display = "inline-block";
            document.getElementById("signature-img_"+evt.currentTarget.myParam2).style.display = "none";
        }

    }
//});

function getSIGNATURE(sRowId){
    dw3_msg_open("<div style='width:100%;text-align:left;'>Entrez votre nom:</div><input style='max-width:335px;margin:10px 0px 20px 0px;' type='text' id='user_signature_name' onkeydown=\"if (event.keyCode == 13) document.getElementById('make_sig_btn').click()\"><button class='grey no-effect' onclick='dw3_msg_close();'>❎ Annuler</button><button class='blue no-effect' id='make_sig_btn' onclick='makeSIGNATURE("+sRowId+");'>✍ Signer</button>");
}
function makeSIGNATURE(sRowId){
    var tCtx = document.getElementById('signature-pad_'+sRowId).getContext('2d');
    var imageElem = document.getElementById('signature-img_'+sRowId);
    var sing_text = document.getElementById('user_signature_name').value;
    if (sing_text == ""){
        document.getElementById('user_signature_name').style.boxShadow = "0px 0px 3px 5px orange";
        document.getElementById('user_signature_name').focus();
        return false;
    }
    var font = '400 40px "Imperial", "Imperial"';
    //const myFont = new FontFace('Sacramento', 'url(/pub/font/Sacramento)');
    document.fonts.load(font)
      .then(function() {
          // Set it before getting the size
          tCtx.font = font
          // this will reset all our context's properties
          tCtx.canvas.width = tCtx.measureText(sing_text).width+10;
          // so we need to set it again
          tCtx.font = font;
          // set the color only now
          tCtx.fillStyle = '#000c23';
          tCtx.fillText(sing_text, 0, 50);
          imageElem.src = tCtx.canvas.toDataURL();
          document.getElementById('signature-pad_'+sRowId).style.display = "none";
          imageElem.style.display = "inline-block";
    });
    dw3_msg_close();
}

function eraseFile(rowID,that){
    document.getElementById("lnVAL1_"+rowID).style.display = "inline-block";
    document.getElementById("lnFILE_"+rowID).style.display = "none";
    that.style.display = "none";
    document.getElementById("lnVAL1_"+rowID).value = "";
    document.getElementById("lnVAL1_"+rowID).defaultValue = "";
    document.getElementById("lnVAL1_"+rowID).click();
}

function sendSIGNATURE(){

  /*   if (signaturePad.isEmpty()) {
    console.log("Empty!");
  }
 */
    var canvas_tags = document.getElementsByClassName("signature_pads");
    for (var i=0, max=canvas_tags.length; i < max; i++) {
        //let sValId = canvas_tags[i].id;
        //let sValLenght = sValId.length;
        //let sLineId = sValId.substring(14);
        let sLineId = canvas_tags[i].id.substring(14);
        var data = signaturePads[i].toDataURL();
        fetch('uploadSIGNATURE.php?KEY=' + KEY + '&QID=' + quiz_id + '&RID=' + report_id + '&LID=' + sLineId, { method: "post", body: data })
        .then(function() {
            //window.open("https://infotronix.ca/technicien/dossier/-CopieClient.pdf","_self");
        })
    .catch(err => console.log(err));
    }
}

function nextQUIZ(QID) {
    window.open('/pub/page/quiz/index.php?KEY='+KEY+'&ID='+QID+"&EML="+encodeURIComponent(USER_EML)+'&PID='+PAGE_ID,'_self');
}

//calculate total
function calc_total(ID) { 
    var BreakException = {};
    var urlDATA = "calcQUIZ.php?ID="+ID;
    var cLN = 0;
    var qID = "";
    var qVAL = "";
    const forms = document.querySelectorAll('form');
    const form = forms[0];
    var total_value = 0;
        try {
        Array.from(form.elements).forEach((input) => {
            cLN++;
            qID = input.id.substr(5);
            qVAL = "";
            if (input.type == "text" && input.id != "captcha_text" && input.id != "report_user_eml"){
                qVAL = input.value;
            }  else if (input.type == "checkbox" && input.id != "captcha_text" && input.id != "report_user_eml"){
                if (input.checked == false){ 
                    qVAL = "0"; 
                } else { 
                    qVAL = "1"; 
                }
            } else if ((input.nodeName == "SELECT" || input.type == "select-one")  && input.id != "captcha_text" && input.id != "report_user_eml"){
                var GRPBOX = document.getElementById(input.id);
                qVAL = GRPBOX.options[GRPBOX.selectedIndex].value;
            }
            if (input.id != "captcha_text" && input.id != "report_user_eml"){
                urlDATA += "&"+qID+"="+encodeURIComponent(qVAL);
            }
        });
    }  catch (e) {
        if (e !== BreakException) throw e;
        return;
    } 

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            document.getElementById("report_total").innerHTML = this.responseText;
      }
    };
    xmlhttp.open('GET', urlDATA,true);
	xmlhttp.send();
}
function sendQUIZ(ID,RID) { 
    //if (USER_EML == ""){
        REPORT_USER_EML = document.getElementById("report_user_eml").value;
        if (document.getElementById("captcha_text")){
           CAPTCHA_TEXT = document.getElementById("captcha_text").value; 
        } else {
            CAPTCHA_TEXT = "";
        }
    //}
    if (REPORT_USER_EML == "" && document.getElementById("report_user_eml").style.display == "inline-block"){
        document.getElementById("report_user_eml").focus();
        document.getElementById("report_user_eml").style.boxShadow = "0px 0px 4px 2px red";
        if (USER_LANG == "FR"){
            dw3_notif_add("Courriel requis pour la transmission du document.");
        } else {
            dw3_notif_add("Email required for document transmission.");
        }
        return false;
    } else {
        document.getElementById("report_user_eml").style.boxShadow = "initial";
    }
    const forms = document.querySelectorAll('form');
    const form = forms[0];
    var urlDATA = "sendQUIZ.php?ID="+ID+"&EML="+encodeURIComponent(REPORT_USER_EML)+"&RID="+RID+"&CPTCH="+CAPTCHA_TEXT;
    var cLN = 0;
    var BreakException = {};
    var qID = "";
    var qVAL = "";
    try {
        Array.from(form.elements).forEach((input) => {
            cLN++;
            qID = input.id.substr(5);
            qVAL = "";
            if ((input.type == "text" || input.type == "color" || input.type == "password" || input.type == "date" || input.type == "time")  && input.id != "captcha_text" && input.id != "report_user_eml"){
                if (input.title == "Requis" && input.value ==""){
                    openPAGE(input.dataset.page);
                    input.focus();
                    input.style.boxShadow = "0px 0px 4px 2px red";
                    if (USER_LANG == "FR"){
                        dw3_notif_add("Valeur requise pour la transmission du document.");
                    } else {
                        dw3_notif_add("Value required for document transmission.");
                    }
                    //return false;
                    throw BreakException;
                }else {
                    input.style.boxShadow = "initial";
                }
                qVAL = input.value;
            } else if (input.type == "checkbox" && input.id != "captcha_text" && input.id != "report_user_eml"){
                if (input.name != "" && input.checked == true){
                    //document.cookie = "CART_" + input.name + "=1;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
                    //dw3_cart_count();
                    /* if (USER_LANG == "FR"){
                        dw3_notif_add("Un item a été ajouté à votre panier.");
                    } else {
                        dw3_notif_add("An item has been added to your basket.");
                    } */
                }
                if (input.title == "Requis" && input.checked == false){
                    openPAGE(input.dataset.page);
                    input.focus();
                    input.style.boxShadow = "0px 0px 4px 2px red";
                    if (USER_LANG == "FR"){
                        dw3_notif_add("Case requise pour la transmission du document.");
                    } else {
                        dw3_notif_add("Box required for document transmission.");
                    }
                    //return false;
                    throw BreakException;
                } else {
                    input.style.boxShadow = "initial";
                }
                if (input.checked == false){ 
                    qVAL = "0"; 
                } else { 
                    qVAL = "1"; 
                }
            } else if ((input.nodeName == "SELECT" || input.type == "select-one") && input.id != "captcha_text" && input.id != "report_user_eml"){
                var GRPBOX = document.getElementById(input.id);
                qVAL = GRPBOX.options[GRPBOX.selectedIndex].value;	
                if (qVAL == "" && input.title == "Requis"){
                    openPAGE(input.dataset.page);
                    input.focus();
                    input.style.boxShadow = "0px 0px 4px 2px red";
                    if (USER_LANG == "FR"){
                        dw3_notif_add("Case requise pour la transmission du document.");
                    } else {
                        dw3_notif_add("Box required for document transmission.");
                    }
                    //return false;
                    throw BreakException;
                }else {
                    input.style.boxShadow = "initial";
                }
            } else if ((input.type == "file" || input.type == "FILE") && input.id != "captcha_text" && input.id != "report_user_eml"){
                if (input.files[0]){
                    /* if(!['image/jpeg', 'image/png'].includes(input.files[0].type)){
                        document.getElementById("dw3_msg").style.display = "inline-block";
                        document.getElementById("dw3_body_fade").style.display = "inline-block";
                        document.getElementById("dw3_body_fade").style.opacity = "0.6";
                        if (LANG == "FR"){
                            document.getElementById("dw3_msg").innerHTML = "Seulement les images JPG/PNG sont acceptés. <div style='height:20px;'> </div><button onclick=\"dw3_msg_close();\">✔ Ok</button>";
                        } else {
                            document.getElementById("dw3_msg").innerHTML = "Only JPG/PNG images are accepted. <div style='height:20px;'> </div><button onclick=\"dw3_msg_close();\">✔ Ok</button>";
                        }
                        input.files[0].value = '';
                        return;
                    } */
                    if(input.files[0].size > 10 * 1024 * 1024) {
                        document.getElementById("dw3_msg").style.display = "inline-block";
                        document.getElementById("dw3_body_fade").style.display = "inline-block";
                        document.getElementById("dw3_body_fade").style.opacity = "0.6";
                        if (LANG == "FR"){
                            document.getElementById("dw3_msg").innerHTML = "Seulement les images de moins de 10MB sont acceptés. <div style='height:20px;'> </div><button onclick=\"dw3_msg_close();\">✔ Ok</button>";
                        } else {
                            document.getElementById("dw3_msg").innerHTML = "Only images less than 10MB are accepted.<div style='height:20px;'> </div><button onclick=\"dw3_msg_close();\">✔ Ok</button>";
                        }
                        input.files[0].value = '';
                        return;
                    }
                    var timeNow = Date.now();
                    var re = /(?:\.([^.]+))?$/;
                    var ext = re.exec(input.files[0].name)[1];
                    qVAL = timeNow+"."+ext.toLowerCase();
                    upload_file(input.files[0],REPORT_USER_EML,qVAL);
                } else if (input.defaultValue != ""){
                    qVAL = input.defaultValue;
                }
            }
            //urlDATA += "&i"+cLN+"="+qID;
            //urlDATA += "&d"+cLN+"="+encodeURIComponent(qVAL);
            if (input.id != "captcha_text" && input.id != "report_user_eml"){
                urlDATA += "&"+qID+"="+encodeURIComponent(qVAL);
            }
        });
    } catch (e) {
        if (e !== BreakException) throw e;
        return;
    }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        const result = JSON.parse(this.responseText);
        var canvas_tags = document.getElementsByClassName("signature_pads");
        if (canvas_tags.length > 0){
            sendSIGNATURE();
        }
        if (result.next_id != ""){
            document.getElementById("dw3_msg").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.opacity = "0.6";
            if (USER_LANG == "FR"){
                document.getElementById("dw3_msg").innerHTML = "<strong>Les données ont étés envoyés avec succès!</strong><div style='height:20px;'> </div><button style='background-color:green;color:white;' onclick=\"dw3_msg_close();nextQUIZ('"+this.responseText.substr(8)+"');\">↷ Document suivant</button><hr class='colored'><button onclick=\"dw3_msg_close();window.open('/client','_self');\"><span class='dw3_font'>)</span> Accèder à mon compte</button><button onclick=\"dw3_msg_close();window.open('/','_self');\"><span class='dw3_font'>!</span> Retourner à l'accueil</button>";
            } else {
                document.getElementById("dw3_msg").innerHTML = "<strong>The data has been sent successfully!</strong><div style='height:20px;'> </div><button style='background-color:green;color:white;' onclick=\"dw3_msg_close();nextQUIZ('"+this.responseText.substr(8)+"');\">↷ Next document</button><hr class='colored'><button onclick=\"dw3_msg_close();window.open('/client','_self');\"><span class='dw3_font'>)</span> Access my account</button><button onclick=\"dw3_msg_close();window.open('/','_self');\"><span class='dw3_font'>!</span> Return to home</button>";
            }
            sendQuizEmail(result.report_id);
        } else if (result.error != ""){
            document.getElementById("dw3_msg").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.opacity = "0.6";
            document.getElementById("dw3_msg").innerHTML = result.error + "<br><button onclick=\"dw3_msg_close();\" style='margin-top:20px;'>✔ Ok</button>";
        } else {
            document.getElementById("dw3_msg").innerHTML = "";
            document.getElementById("dw3_msg").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.opacity = "0.6";
            document.getElementById("dw3_quiz_form").style.visibility = "invisible";
            //var cookies = dw3_cookies_get_all();
            //var counter = 0;
            /* for(var name in cookies) {
                if(name.slice(0, 10) == "CART_COUNT" && cookies[name] != "0"){counter++;}
            }
            if (counter == 1){
                if (USER_LANG == "FR"){
                    document.getElementById("dw3_msg").innerHTML = "<strong>Les données ont étés envoyés avec succès!<br>Un item se trouve dans votre panier</strong><div style='height:20px;'> </div><button style='color:white;background:green;' onclick=\"dw3_msg_close();dw3_cart_open();\">🛒 Voir le panier</button><hr class='colored'><button onclick=\"dw3_msg_close();window.open('/','_self');\">🏠 Retourner à l'accueil</button>";
                } else {
                    document.getElementById("dw3_msg").innerHTML = "<strong>The data has been sent successfully!<br>An item is in your basket</strong><div style='height:20px;'> </div><button style='color:white;background:green;' onclick=\"dw3_msg_close();dw3_cart_open();\">🛒 View cart</button><hr class='colored'><button onclick=\"dw3_msg_close();window.open('/','_self');\">🏠 Return to home</button>";
                }
            } else if (counter > 1){
                if (USER_LANG == "FR"){
                    document.getElementById("dw3_msg").innerHTML = "<strong>Les données ont étés envoyés avec succès!<br>"+counter+" items se trouvent dans votre panier</strong><div style='height:20px;'> </div><button style='color:white;background:green;' onclick=\"dw3_msg_close();dw3_cart_open();\">🛒 Voir le panier</button><hr class='colored'><button onclick=\"dw3_msg_close();window.open('/','_self');\">🏠 Retourner à l'accueil</button>";
                } else {
                    document.getElementById("dw3_msg").innerHTML = "<strong>The data has been sent successfully!<br>"+counter+" items are in your basket</strong><div style='height:20px;'> </div><button style='color:white;background:green;' onclick=\"dw3_msg_close();dw3_cart_open();\">🛒 View cart</button><hr class='colored'><button onclick=\"dw3_msg_close();window.open('/','_self');\">🏠 Return to home</button>";
                }
            } else { */
                if (USER_LANG == "FR"){
                    document.getElementById("dw3_msg").innerHTML = "<strong>Les données ont étés envoyés avec succès!</strong><div style='height:20px;'> </div><button onclick=\"dw3_msg_close();window.open('/client','_self');\"><span class='dw3_font'>)</span> Accèder à mon compte</button><button onclick=\"dw3_msg_close();window.open('/','_self');\"><span class='dw3_font'>!</span> Retourner à l'accueil</button>";
                } else {
                    document.getElementById("dw3_msg").innerHTML = "<strong>The data has been sent successfully!</strong><div style='height:20px;'> </div><button onclick=\"dw3_msg_close();window.open('/client','_self');\"><span class='dw3_font'>)</span> Access my account</button><button onclick=\"dw3_msg_close();window.open('/','_self');\"><span class='dw3_font'>!</span> Return to home</button>";
                }
            //}
            sendQuizEmail(result.report_id);
        }
	  }
	};
    xmlhttp.open('GET', urlDATA,true);
	xmlhttp.send();
}
function choosedImage(sLineId,sSelectedText){
    document.getElementById("lnVAL1_"+sLineId).value = sSelectedText;
    dw3_editor_close();
    calc_total(quiz_id);
}
function chooseFromImage(sLineId){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("dw3_body_fade").style.display = "inline-block";
        document.getElementById("dw3_body_fade").style.opacity = "0.6";
        document.getElementById("dw3_editor").style.display = "inline-block";
        document.getElementById("dw3_editor").style.opacity = "1";
        document.getElementById("dw3_editor").style.padding = "20px";
        document.getElementById("dw3_editor").style.minWidth = "0px";
        document.getElementById("dw3_editor").style.minHeight = "0px";
        document.getElementById("dw3_editor").style.width = "auto";
        document.getElementById("dw3_editor").style.height = "auto";
        document.getElementById("dw3_editor").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'chooseFromImage.php?LID=' + sLineId, true);
    xmlhttp.send();
}

function sendQuizEmail(sRID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        //na
	  }
	};
    xmlhttp.open('GET', 'sendQuizEmail.php?KEY=' + KEY + '&RID=' + sRID, true);
    xmlhttp.send();
}
const upload_file = (file,eml,newName) => {
    const form_data = new FormData();
    form_data.append('sample_image', file);
    fetch("uploadFILE.php?eml="+encodeURIComponent(eml)+"&t="+encodeURIComponent(newName)+"&q="+quiz_id, {
        method:"POST",
        body : form_data
    }).then(function(response){
        //return response.json();
    }).then(function(responseData){
        //dw3_notif_add("Case requise pour la transmission du document.");
    });
}

if(TOTAL_TYPE == "CASH"){
    calc_total(quiz_id);
    const form = document.querySelector('form');
    form.addEventListener('input', function() {
        calc_total(quiz_id);
    });
}


function openPAGE(page){
    let xw = document.getElementById("quiz_page1").offsetWidth;
    document.getElementById("quiz_page_number").innerText = page + " / " + PAGE_COUNT;

    for (let i = 1; i <= PAGE_COUNT; i++) {
        if (i<page){
            document.getElementById("quiz_page"+i).style.left = "-" + xw + "px";
        } else if(i==page){
            document.getElementById("quiz_page"+i).style.left = "0px";
        } else {
            document.getElementById("quiz_page"+i).style.left = xw + "px";
        }
    }

}

//dw3_datetime_pick
const calendarDates = document.querySelector('.calendar-dates');
const monthYear = document.getElementById('month-year');
const prevMonthBtn = document.getElementById('prev-month');
const nextMonthBtn = document.getElementById('next-month');

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

const is_j0_open = <?php if (intval(substr($CIE_OPEN_J0_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J0_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J0_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J0_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j1_open = <?php if (intval(substr($CIE_OPEN_J1_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J1_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J1_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J1_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j2_open = <?php if (intval(substr($CIE_OPEN_J2_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J2_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J2_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J2_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j3_open = <?php if (intval(substr($CIE_OPEN_J3_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J3_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J3_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J3_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j4_open = <?php if (intval(substr($CIE_OPEN_J4_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J4_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J4_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J4_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j5_open = <?php if (intval(substr($CIE_OPEN_J5_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J5_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J5_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J5_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j6_open = <?php if (intval(substr($CIE_OPEN_J6_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J6_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J6_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J6_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;

        <?php 
            if ($USER_LANG == "FR"){
                echo "const months = [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ];";
            } else {
                echo "const months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
                ];";
            }
        ?>

function renderCalendar(month, year) {
  calendarDates.innerHTML = '';
  monthYear.textContent = `${months[month]} ${year}`;

  // Get the first day of the month
  const firstDay = new Date(year, month, 1).getDay();

  // Get the number of days in the month
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  // Create blanks for days of the week before the first day
  for (let i = 0; i < firstDay; i++) {
    const blank = document.createElement('div');
    calendarDates.appendChild(blank);
  }


  //calculate pickup delay date
  var pk_date = new Date();
  if (CIE_PK_F1 != "0" && CIE_PK_F1 != ""){
    if (CIE_PK_F2 == "hour"){
         pk_date.setHour(pk_date.getHours() + parseInt(CIE_PK_F1));
    } else if (CIE_PK_F2 == "day"){
        pk_date.setDate(pk_date.getDate() + parseInt(CIE_PK_F1));
    } else if (CIE_PK_F2 == "week"){
        pk_date.setDate(pk_date.getDate() + (parseInt(CIE_PK_F1)*7));
    } else if (CIE_PK_F2 == "month"){
        pk_date.setMonth(pk_date.getMonth() + parseInt(CIE_PK_F1));
    }
  }

  // Get today's date
  const today = new Date();

  // Populate the days
  for (let i = 1; i <= daysInMonth; i++) {
    const day = document.createElement('div');
    day.textContent = i;
    var valid_day = true;

    // Disable past dates
    if (i < today.getDate() && year <= today.getFullYear() && month <= today.getMonth() ) {
      day.classList.add('past-date');
      valid_day = false;
    }

    // Disable dates before pickup delay
    if (i < pk_date.getDate() && year <= pk_date.getFullYear() && month <= pk_date.getMonth() ) {
      day.classList.add('past-date');
      valid_day = false;
    }

    if (new Date(year, month, i).getDay() == "0" && is_j0_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "1" && is_j1_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "2" && is_j2_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "3" && is_j3_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "4" && is_j4_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "5" && is_j5_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "6" && is_j6_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    }

    // Highlight today's date
    if (i === today.getDate() && year === today.getFullYear() && month === today.getMonth() ) {
      day.classList.add('current-date');
      if (valid_day == true){
        getCAL_HOURS(currentDate.getDate(),currentMonth,currentYear);
      } else {
        document.getElementById('hours-selection').innerHTML = "<br><div class='divBOX' style='max-width:none;'>Aucunes disponibilités cette journée. Veuillez en choisir une autre.</div>";
      }
    }

    if (valid_day == true){
        day.classList.add('valid-day');
    }

    calendarDates.appendChild(day);
  }

}

renderCalendar(currentMonth, currentYear);

prevMonthBtn.addEventListener('click', () => {
  currentMonth--;
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  }
  renderCalendar(currentMonth, currentYear);
});

nextMonthBtn.addEventListener('click', () => {
  currentMonth++;
  if (currentMonth > 11) {
    currentMonth = 0;
    currentYear++;
  }
  renderCalendar(currentMonth, currentYear);
});


calendarDates.addEventListener('click', (e) => {
  if (e.target.textContent !== '' && e.target.classList.contains("valid-day")) {
    //alert(`You clicked on ${e.target.textContent} ${months[currentMonth]} ${currentYear}`);
    getCAL_HOURS(e.target.textContent,currentMonth,currentYear);
  }
});

function updCAL_HOUR(year,month,day,hour,minute,input_name){
    pickup_date = year + "/" + month + "/" + day + " " + hour + ":" + minute;
    closeCALENDAR();
    dw3_notif_add("La date et l'heure de ramassage a été mise à jour.");
    document.getElementById(input_name).value = pickup_date;
}
function getCAL_HOURS(day,month,year){
    input_name = document.getElementById("picktime_input_name").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById('hours-selection').innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getCAL_HOURS.php?KEY=' + KEY 
                                    + '&I=' + input_name
                                    + '&D=' + day
                                    + '&M=' + month
                                    + '&Y=' + year,
                                    true);
    xmlhttp.send();
}


function openCALENDAR(input_name) {
		document.getElementById("dw3_body_fade").style.display = "inline-block";
		document.getElementById("dw3_body_fade").style.opacity = "0.6";
		document.getElementById("dw3_datetime_pick").style.display = "inline-block";
		document.getElementById("dw3_datetime_pick").style.opacity = "1";
		document.getElementById("picktime_input_name").value = input_name;
}
function closeCALENDAR() {
		document.getElementById("dw3_body_fade").style.display = "none";
		document.getElementById("dw3_body_fade").style.opacity = "0";
		document.getElementById("dw3_datetime_pick").style.display = "none";
        document.getElementById("dw3_datetime_pick").style.opacity = "0";
}

 dw3_drag_init(document.getElementById('dw3_datetime_pick'));
var CART = <?php if(isset($_COOKIE["CART"])) { echo $_COOKIE["CART"]; }  else {echo "[]";} ?>;
</script>
<?php  
//require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER; 
?>