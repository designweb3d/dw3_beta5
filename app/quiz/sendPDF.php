<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php';

$report_id = $_GET['ID'];
$EML_TO = $_GET['EML'];

$sql = "SELECT B.*, A.id as report_id, A.parent_id as parent_id, A.date_completed as date_completed, A.head_id as head_id, A.report_eml as report_eml, A.user_created AS user_created, A.lang AS report_lang,
IFNULL(C.company,'') AS customer_company, IFNULL(C.first_name,'') AS customer_fname, IFNULL(C.last_name,'') AS customer_name, IFNULL(C.tel1,'') AS customer_tel,IFNULL(C.adr1,'') AS customer_adr1,IFNULL(C.adr2,'') AS customer_adr2,IFNULL(C.city,'') AS customer_city,IFNULL(C.province,'') AS customer_prov,IFNULL(C.postal_code,'') AS customer_cp,IFNULL(C.eml1,'') AS customer_eml, 
IFNULL(D.eml1,'') AS user_eml, IFNULL(D.tel1,'') AS user_tel, IFNULL(D.last_name,'') AS user_name
FROM prototype_report A
LEFT JOIN prototype_head B ON A.head_id = B.id
LEFT JOIN customer C ON A.parent_id = C.id
LEFT JOIN user D ON A.parent_id = D.id
WHERE A.id = '" .$report_id  . "'";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_id = $data['id']??0;
$head_lang = $data['report_lang']??"FR";
if($head_lang == "FR" || $head_lang == "fr"){
    $head_name = $data['name_fr'];
    $head_desc = $data['description_fr'];
} else {
    $head_name = $data['name_en'];
    $head_desc = $data['description_en'];
}
$head_total_type = $data['total_type']??0;
$head_total_max = $data['total_max']??0;
$head_parent_table = $data['parent_table']??0;
$head_parent_id = $data['parent_id']??0;
$head_user_name = $data['user_name']??'';
$head_user_tel = $data['user_tel']??'';
$head_user_eml = $data['user_eml']??'';
$head_report_eml = $data['report_eml']??'';
$head_customer_tel = dw3_decrypt($data['customer_tel'])??'';
$head_customer_eml = dw3_decrypt($data['customer_eml'])??'';
$head_customer_fname = dw3_decrypt($data['customer_fname'])??'';
$head_customer_name = dw3_decrypt($data['customer_name'])??'';
$head_customer_cie = $data['customer_cie']??'';
$head_customer_adr1 = dw3_decrypt($data['customer_adr1'])??'';
$head_customer_adr2 = dw3_decrypt($data['customer_adr2'])??'';
$head_customer_city = $data['customer_city']??'';
$head_customer_prov = $data['customer_prov']??'';
$head_customer_cp = $data['customer_cp']??'';
$date_completed = $data['date_completed']??0;
$head_user_created = $data['user_created']??0;

$title_len = strlen($head_name);
if ($title_len <= 30){
    $title_size = "26px";
} else if ($title_len > 30 && $title_len <= 50){
    $title_size = "22px";
} else if ($title_len > 50 && $title_len <= 70){
    $title_size = "18px";
} else {
    $title_size = "14px";
}

$html = "<html><head><title>".$head_name."</title><style>
@page {
    margin: 5px 20px;
}
main {
    position: fixed;
    top: 180px;
    bottom: 50px;
    left: 0px;
    right: 0px;
    height: 50px; 
    break-inside: auto;
}

header {
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    height: 180px;
}

footer {
    position: fixed; 
    bottom: 0px; 
    left: 0px; 
    right: 0px;
    height: 20px; 
}
body{font-size:14px;font-family:arial;}
h3 {padding: 2px;text-align:center;}
input {
    border:0px;
}
.tblDATA {word-wrap:wrap; width:100%;}
.tblDATA tr:nth-child(even){background-color: #FAFAFA;}
.tblDATA tr:nth-child(odd){background-color: #CCCCCC;}
.divBOX{
    display:inline-block;
    padding:5px;
    border-bottom:1px solid #ddd;
}
br { content: ' '; display: block; margin:0px; font-size:0px;}
</style></head><body><header>
    <table style='width:100%;font-size:10px;border-top:2px solid #555;border-bottom:2px solid #555;'><tr>
        <td style='text-align:left; width:260px;'><img src='https://" . $_SERVER["SERVER_NAME"] . "/pub/img/".$CIE_LOGO1."' style='height:100px;width:auto;max-width:260px;'></td>
        <td style='text-align:center;'> <div style='border-right:3px solid #333;border-left:3px solid #555;padding:10px 5px;font-weight:bold;'><span style='font-size: ".$title_size.";'>".$head_name."</span><br>".$head_desc."</div></td>
        <td style='text-align:right;width:260px;'>";
        if ($CIE_RBQ != ""){$html .= "#RBQ ".$CIE_RBQ."<br>";}$html .= "<b style='font-size:14px;'>".$CIE_TEL1."</b><br>".$CIE_EML1."<br>".$CIE_ADR."<br><a href='https://".$_SERVER["SERVER_NAME"]."'>www.".$_SERVER["SERVER_NAME"]."</a>
        <br>Document N°<b style='font-size:22px;padding-left:10px;'> ". str_pad($report_id,5,"0",STR_PAD_LEFT)  . "</b></td>
    </tr></table>";
	if ($head_parent_table == "customer"){
        $html .= "<table style='width:100%;border-bottom:2px solid #555;'><tr>
        <td rowspan='3' style='vertical-align:top;'>Client:<br>Adresse:</td><td width='50%' rowspan='3'>". $head_customer_fname ." ". $head_customer_name ." <b>". $head_customer_cie . "</b><br>".$head_customer_adr1 ." ". $head_customer_adr2."<br>".$head_customer_city .", ". $head_customer_prov."<br>Canada ". $head_customer_cp."</td>
        <td style='width:100px;'>Date:</td><td>". $today . "</td></tr>
        <tr><td style='width:100px;'>Téléphone:</td><td>". $head_customer_tel . "</td></tr>
        <tr><td style='width:100px;'>Courriel:</td><td>". $head_customer_eml . "</td></tr>
        ";
    } else if ($head_parent_table == "user"){
        $html .= "<table style='width:100%;'><tr>
        <td rowspan='3'>Nom:</td><td width='50%' rowspan='3'>". $head_user_name ."</td>
        <td style='width:100px;'>Date:</td><td>". $today . "</td></tr>
        <tr><td style='width:100px;'>Téléphone:</td><td>". $head_user_tel . "</td></tr>
        <tr><td style='width:100px;'>Courriel:</td><td>". $head_user_eml . "</td></tr>
        ";
    }
    $html .= "</table></header>    
    <footer> &copy; ".$CIE_NOM." " .date('Y'). "</footer><main>";

/*     $sql = "SELECT A.*,B.id AS id,B.name_fr AS name_fr,B.description_fr AS description_fr, B.response_type AS response_type, B.box_size AS box_size,
    B.multiplier as multiplier,B.multiplied as multiplied,B.mandatory AS mandatory,
     B.choice_name1 AS choice_name1, B.choice_name2 AS choice_name2, B.choice_name3 AS choice_name3,
     B.choice_name4 AS choice_name4, B.choice_name5 AS choice_name5,B.choice_name6 AS choice_name6,
     B.choice_name7 AS choice_name7,B.choice_name8 AS choice_name8,B.choice_name9 AS choice_name9,B.choice_name0 AS choice_name0,
     B.choice_value1 AS choice_value1, B.choice_value2 AS choice_value2, B.choice_value3 AS choice_value3,
     B.choice_value4 AS choice_value4, B.choice_value5 AS choice_value5,B.choice_value6 AS choice_value6,
     B.choice_value7 AS choice_value7,B.choice_value8 AS choice_value8,B.choice_value9 AS choice_value9,B.choice_value0 AS choice_value0,
     B.record_name AS record_name
        FROM prototype_data A
        LEFT JOIN prototype_line B ON A.line_id = B.id
        WHERE A.report_id = '" . $head_id . "' ;"; */
$total_value = 0;
$sql = "SELECT A.*,B.*
        FROM prototype_line A
        LEFT JOIN (SELECT * FROM prototype_data WHERE report_id = '" . $report_id . "') B ON A.id = B.line_id
        WHERE A.head_id = '".$head_id."'
        ORDER BY position ASC;";
	$result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
            //if($head_lang == "FR" || $USER_LANG == "FR" || $USER_LANG == "fr" || $USER_LANG == ""){
            if($head_lang == "FR" || $head_lang == "fr"){
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
            if ($row["response_align"] == ""){
                $line_position = "";
            } else if (strtolower($row["response_align"]) == "center"){
                $line_position = "width:100%;text-align:center;";
            } else if (strtolower($row["response_align"]) == "left"){
                $line_position = "width:100%;text-align:left;";
            } else if (strtolower($row["response_align"]) == "right"){
                $line_position = "width:100%;text-align:right;";
            }

/*             if($row["mandatory"]=="1"){
                $req=" title='Requis' ";
                $required_field = "<span style='color:red;font-weight:bold;'>*</span>";
            }else{
                $req='';
                $required_field = "";
            } */

            if($row["box_size"]=="SMALL"){
                $box_size = "32%";
            } else if($row["box_size"]=="MEDIUM"){
                $box_size = "48%";
            } else if($row["box_size"]=="LARGE"){
                $box_size = "96%";
            } else {
                $box_size = "335px";
            }
        //NONE
            if($row["response_type"] == "NONE"){
                if(trim($line_name) != ""){
                    $html .= "<h3 style='background:#".$CIE_COLOR6.";color:#".$CIE_COLOR7.";'>".$line_name."</h3>";
                }
                if(trim($line_desc) != ""){
                    $html .= "<br><div style='font-size:0.8em;'font-weight:normal;'> ".$line_desc."</div>";
                }
        //TEXT
            } else if($row["response_type"] == "TEXT"){
                $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."";
                if (trim($row["value1"])!=""){
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value1"]."</b></u></div>";
                }
                if($line_desc != ""){
                    $html .= "<div style='font-size:0.7em;'> ".$line_desc."</div>";
                }
                $html .= "</div>";
                if($row["multiplier"] =="1"){
                    if ($row["multiplied"] =="0"){
                        $total_multiplier += (float)$row["value1"];
                    } else {
                        //to do
                    }
                }
        //MULTI-TEXT
            } else if($row["response_type"] == "MULTI-TEXT"){
                $html .= "<div class='divBOX' style='padding-top:5px;min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."";
                if($line_desc != ""){
                    $html .= "<br><div style='font-size:0.7em;'> ".$line_desc."</div>";
                }
                //valeur1
                if(trim($line_c1) != ""){
                    $html .= "<br>".$line_c1;
                }
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value1"]."</b></u></div>";
                //valeur2
                if(trim($line_c2) != ""){
                    $html .= "<br>".$line_c2;
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value2"]."</b></u></div>";
                }
                //valeur3
                if(trim($line_c3) != ""){
                    $html .= "<br>".$line_c3;
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value3"]."</b></u></div>";
                }
                //valeur4
                if(trim($line_c4) != ""){
                    $html .= "<br>".$line_c4;
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value4"]."</b></u></div>";
                }
                //valeur5
                if(trim($line_c5) != ""){
                    $html .= "<br>".$line_c5;
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value5"]."</b></u></div>";
                }
                //valeur6
                if(trim($line_c6) != ""){
                    $html .= "<br>".$line_c6;
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value6"]."</b></u></div>";
                }
                //valeur7
                if(trim($line_c7) != ""){
                    $html .= "<br>".$line_c7;
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value7"]."</b></u></div>";
                }
                //valeur8
                if(trim($line_c8) != ""){
                    $html .= "<br>".$line_c8;
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value8"]."</b></u></div>";
                }
                //valeur9
                if(trim($line_c9) != ""){
                    $html .= "<br>".$line_c9;
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value9"]."</b></u></div>";
                }
                //valeur0
                if(trim($line_c0) != ""){
                    $html .= "<br>".$line_c0;
                    $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><u><b>".$row["value0"]."</b></u></div>";
                }
                $html .= "</div>";
        //CHECKBOX        
            } else if($row["response_type"] == "CHECKBOX"){
                if ($row["value1"]=="1"){
                    $is_checked = "checked";$total_value+=(float)$row["choice_value1"];} else {$is_checked = "";}
                $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'><input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'>".$line_name."</div> <small style='display:inline-block;vertical-align:middle;'> ".$line_desc."</small></div>";
        //YES/NO      
            } else if($row["response_type"] == "YES/NO"){
                $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."";
                if($line_desc != ""){
                    $html .= "<br><div style='font-size:0.7em;'> ".$line_desc."</div>";
                }
                $html .= "<div style='".$line_position."'><b>".$row["value1"]."</b></div></div>";
                //$html .= $row["value1"]."</div>";
        //CHOICE        
            } else if($row["response_type"] == "CHOICE"){
                $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."";
                if($line_desc != ""){
                    $html .= "<br><div style='font-size:0.7em;display:inline-block;'> ".$line_desc."</div>";
                }
                //$html .= " <u>".$row["value1"]."</u></div>";
                $html .= "<div style='margin-left:7px;display:inline-block;vertical-align:middle;".$line_position."'><b>".$row["value1"]."</b></div></div>";
                if ($line_c1 == $row["value1"]){
                    $total_value+=(float)$row["choice_value1"];
                } else if ($line_c2 == $row["value1"]){
                    $total_value+=(float)$row["choice_value2"];
                } else if ($line_c3 == $row["value1"]){
                    $total_value+=(float)$row["choice_value3"];
                } else if ($line_c4 == $row["value1"]){
                    $total_value+=(float)$row["choice_value4"];
                } else if ($line_c5 == $row["value1"]){
                    $total_value+=(float)$row["choice_value5"];
                } else if ($line_c6 == $row["value1"]){
                    $total_value+=(float)$row["choice_value6"];
                } else if ($line_c7 == $row["value1"]){
                    $total_value+=(float)$row["choice_value7"];
                } else if ($line_c8 == $row["value1"]){
                    $total_value+=(float)$row["choice_value8"];
                } else if ($line_c9 == $row["value1"]){
                    $total_value+=(float)$row["choice_value9"];
                } else if ($line_c0 == $row["value1"]){
                    $total_value+=(float)$row["choice_value0"];
                }
        //MULTI-CHOICE
            } else if($row["response_type"] == "MULTI-CHOICE"){
                $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."<br>";
                if($line_desc != ""){
                    $html .= "<div style='font-size:0.7em;display:inline-block;'> ".$line_desc."</div><br>";
                }
                //valeur1
                    if ($row["value1"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value1"];} else {$is_checked = "";}
                    $html .= "<input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'> <b>".$line_c1."</b></div><br>";
                //valeur2
                    if ($row["value2"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value2"];} else {$is_checked = "";}
                    $html .= "<input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'> <b>".$line_c2."</b></div><br>";
                //valeur3
                if($line_c3 != ""){
                    if ($row["value3"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value3"];} else {$is_checked = "";}
                    $html .= "<input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'> <b>".$line_c3."</b></div><br>";
                }
                //valeur4
                if($line_c4 != ""){
                    if ($row["value4"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value4"];} else {$is_checked = "";}
                    $html .= "<input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'> <b>".$line_c4."</b></div><br>";
                }
                //valeur5
                if($line_c5 != ""){
                    if ($row["value5"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value5"];} else {$is_checked = "";}
                    $html .= "<input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'> <b>".$line_c5."</b></div><br>";
                }
                //valeur6
                if($line_c6 != ""){
                    if ($row["value6"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value6"];} else {$is_checked = "";}
                    $html .= "<input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'> <b>".$line_c6."</b></div><br>";
                }
                //valeur7
                if($line_c7 != ""){
                    if ($row["value7"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value7"];} else {$is_checked = "";}
                    $html .= "<input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'> <b>".$line_c7."</b></div><br>";
                }
                //valeur8
                if($line_c8 != ""){
                    if ($row["value8"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value8"];} else {$is_checked = "";}
                    $html .= " <input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'> <b>".$line_c8."</b></div><br>";
                }
                //valeur9
                if($line_c9 != ""){
                    if ($row["value9"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value9"];} else {$is_checked = "";}
                    $html .= "<input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'> <b>".$line_c9."</b></div><br>";
                }
                //valeur0
                if($line_c0 != ""){
                    if ($row["value0"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value0"];} else {$is_checked = "";}
                    $html .= "<input ".$is_checked." type='checkbox' style='margin:0px 5px;vertical-align:middle;'><div style='display:inline-block;vertical-align:middle;'> <b>".$line_c0."</b> ";
                }
                $html .= "</div>";
        //FILE
            } else if($row["response_type"] == "FILE"){
                $extension = pathinfo($row["value1"], PATHINFO_EXTENSION);
                if ($extension=="png"||$extension=="jpg"||$extension=="jpeg"){
                    $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."<br><small> ".$line_desc."</small><br><img style='width:300px;' src='/fs/".$head_parent_table."/upload/".$row["value1"]."'></div>";
                } else if ($row["value1"] != 'undefined') {
                    $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."<br><small> ".$line_desc."</small><br><a href='/fs/".$head_parent_table."/".$head_parent_id."/".$row["value1"]."' target='_blank'>".$row["value1"]."</a></div>";
                } else {
                    $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."<br><small> ".$line_desc."</small><br>".$row["value1"]."</div>";
                }
                //$html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."<small>".$line_desc."</small><b>".$row["value1"]."' type='file'></div>";
        //COLOR
            } else if($row["response_type"] == "COLOR"){
                $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."<small> ".$line_desc."</small><div style='display:inline-block;width:18px;height:18px;background-color:".$row["value1"].";vertical-align:middle;'> </div><b>".$row["value1"]."</b></div>";
        //PASSWORD
            } else if($row["response_type"] == "PASSWORD"){
                $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."<br><small> ".$line_desc."</small><b>".$row["value1"]."</b></div>";
        //DATE
            } else if($row["response_type"] == "DATE"){
                $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."<br><small> ".$line_desc."</small><b>".$row["value1"]."</b></div>";
        //TIME
            } else if($row["response_type"] == "TIME"){
                $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."<br><small> ".$line_desc."</small><b>".$row["value1"]."</b></div>";
        //SIGNATURE
            } else if($row["response_type"] == "SIGNATURE"){
                $sig_path = $_SERVER['DOCUMENT_ROOT'] . "/fs/customer/upload/doc-sig-". $report_id . ".png";
                $sig_path_pub = "https://" . $_SERVER["SERVER_NAME"] ."/fs/customer/upload/doc-sig-". $report_id . ".png";

                if (file_exists($sig_path)){
                    $html .= "<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>".$line_name."<br> ".$line_desc;
                    $html .= "<img src='" . $sig_path_pub . "' style='width:335px;height:auto;'>"; 
                } else {
                    $html .= "<div class='divBOX' style='margin-top:25px;min-height:15px;max-width:".$box_size.";width:".$box_size.";'><div style='border-top:1px solid #444;width:100%;'> </div>".$line_name."<br> ".$line_desc;
                }
                $html .= "</div>";
            } else if($row["response_type"] == "SIG-USER"){
                $html .="<div class='divBOX' style='min-height:15px;max-width:".$box_size.";width:".$box_size.";'>";
                $sig_path = $_SERVER['DOCUMENT_ROOT'] . "/fs/user/".$head_user_created."/signature.png";
                $sig_path_pub =  "https://" . $_SERVER["SERVER_NAME"] ."/fs/user/".$head_user_created."/signature.png";
                if (file_exists($sig_path)){
                    $html .= "<div style='width:100%;text-align:center;'><img src='" . $sig_path_pub . "' style='width:auto;height:90px;max-width:335px;margin-bottom:-30px;'></div>"; 
                    //$html .= $sig_path_pub;
                } 
                $html .= "<div style='border-top:1px solid #444;width:100%;'> </div>".$line_name."<br>".$line_desc."</div>";
            }
		}
	}


$html .= "</main></body></html>";
//$html .= "<br>Signature de l'assuré:<br><img src='https://infotronix.ca/technicien/dossier/signature-" . $dossier . ".png' style='width:400px;width:150px;'><br>https://infotronix.ca/technicien/dossier/signature-" . $dossier . ".png" ;
//$html = "<img src='https://infotronix.ca/img/Infotronix_fr.png'>";

use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isJavascriptEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('defaultMediaType', 'all');
$dompdf->set_option('isFontSubsettingEnabled', true);
$dompdf->loadHtml($html);
$dompdf->setPaper('letter', 'portrait');
// Render the HTML as PDF
$dompdf->render();
//page#
$font = $dompdf->getFontMetrics()->get_font("Verdana", "");
$dompdf->get_canvas()->page_text(577, 770, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));
// Output the generated PDF 
//$dompdf->stream(trim($dossier) . "-CopieClient.pdf");
$output_pdf = $dompdf->output();
$output_fn = $_SERVER['DOCUMENT_ROOT'] . "/fs/".$head_parent_table."/" . $head_parent_id . "/Document_".$report_id.".pdf";
file_put_contents($output_fn, $output_pdf);
sleep(2);

if (trim($EML_TO) == ""){
    //$file_to_save = $_SERVER['DOCUMENT_ROOT'] . '/fs/tmp_file_'.time().'.pdf';
    //save the pdf file on the server
    //file_put_contents($file_to_save, $dompdf->output()); 
    //print the pdf file to the screen for saving
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="'.str_replace(" ","_",$head_name) ."_".$report_id. ".pdf".'"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($output_fn));
    header('Accept-Ranges: bytes');
    readfile($output_fn);
    $dw3_conn->close();
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$email = new PHPMailer(true);
$email->CharSet = "UTF-8";
$subject = $head_name;
$htmlContent = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
<body>
    <h3>Bonjour,</h3>
    Vous trouverez ci-joint un document PDF.<div style="height:30px;"> </div>' . 
    '<br><div style="border-bottom: 1px dashed #999; width: 100%;padding:2px;">Veuillez noter que cette boîte courriel ne peut recevoir de réponse.</div>
    <b>Pour communiquer avec nous</b>:<br>
    <table style="border: 0px dashed #FB4314;font-size:17px;"> 
        <tr> 
        <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO1.'" style="height:48px;width:auto;"></td>
        <td><b>'.$CIE_NOM.'</b>
        <br>'.$CIE_EML1.'
        <br>'.$CIE_TEL1.'</td> 
        </tr> 
    </table> 
    <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a>
</html>';
$email->SetFrom("no-reply@".$_SERVER["SERVER_NAME"],$CIE_NOM); //Name is optional
$email->Subject = $subject;
$email->Body = $htmlContent;
$email->IsHTML(true); 
$email->AddAddress( trim($EML_TO) );
$email->AddAttachment( $output_fn , str_replace(" ","_",$head_name) . '.pdf' );
try {
    $mail_ret = $email->Send();
    echo "Courriel envoyé.";
    if ($head_parent_table == "customer"){
        //ajout évènement
        $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
            VALUES('EMAIL','Document complété en PDF','".$subject."\nEnvoyé par: ".$USER_FULLNAME ."','". $datetime ."','".$head_parent_id."','".$USER."')";
        $result_task = $dw3_conn->query($sql_task);
    }
} catch (phpmailerException $e) {
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    echo $e->getMessage(); //Boring error messages from anything else!
}

$dw3_conn->close();
?>