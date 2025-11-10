<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'fr_CA');
$ID = $_GET['RID'];
sleep(3); //to let the time for signatures to be uploaded
	$sql = "SELECT B.*, A.id as report_id, A.parent_id as parent_id, A.date_completed as date_completed, A.head_id as head_id, A.report_eml as report_eml, 
            IFNULL(C.company,'') AS customer_company, IFNULL(C.first_name,'') AS customer_fname, IFNULL(C.last_name,'') AS customer_name, IFNULL(C.tel1,'') AS customer_tel,IFNULL(C.adr1,'') AS customer_adr1,IFNULL(C.adr2,'') AS customer_adr2,IFNULL(C.city,'') AS customer_city,IFNULL(C.province,'') AS customer_prov,IFNULL(C.postal_code,'') AS customer_cp,IFNULL(C.eml1,'') AS customer_eml, 
            IFNULL(D.eml1,'') AS user_eml, IFNULL(D.last_name,'') AS user_name
    FROM prototype_report A
    LEFT JOIN prototype_head B ON A.head_id = B.id
    LEFT JOIN customer C ON A.parent_id = C.id
    LEFT JOIN user D ON A.parent_id = D.id
    WHERE A.id = '" . $ID . "';";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $head_id = $data['id']??0; 
    $head_name = $data['name_fr']??0;
    $head_desc = $data['description_fr']??0;
    $head_total_type = $data['total_type']??0;
    $head_total_max = $data['total_max']??0;
    $head_parent_table = $data['parent_table']??0;
    $head_parent_id = $data['parent_id']??0;
    $head_user_eml = $data['user_eml']??0;
    $head_user_name = $data['user_name']??0;
    $head_report_eml = $data['report_eml']??0;
    $head_customer_eml = dw3_decrypt($data['customer_eml'])??'';
    $head_customer_tel = dw3_decrypt($data['customer_tel'])??'';
    $head_customer_fname = dw3_decrypt($data['customer_fname'])??'';
    $head_customer_name = dw3_decrypt($data['customer_name'])??'';
    $head_customer_cie = $data['customer_cie']??'';
    $head_customer_adr1 = dw3_decrypt($data['customer_adr1'])??'';
    $head_customer_adr2 = dw3_decrypt($data['customer_adr2'])??'';
    $head_customer_city = $data['customer_city']??'';
    $head_customer_prov = $data['customer_prov']??'';
    $head_customer_cp = $data['customer_cp']??'';
    $date_completed = $data['date_completed']??0;
    $htmlContent2 = "<html>
    <style>
        .divBOX{
            padding:3px;
            display:block;
        }
        .tblDATA {
            width:100%;
            margin:0px;
            background: rgba(255, 255, 255, 0.1);
            white-space:nowrap;
            border-collapse: collapse;
            font-family: ". $CIE_FONT3.";
        }
        .tblDATA td{
            text-align:left;
            border: 1px solid #ddd;
            padding: 4px;
            color: #". $CIE_COLOR7_4.";
            overflow:hidden;
            vertical-align:top;
        }
        .tblDATA th{
            text-align:left;
            padding: 6px;
            user-select:none;	
            vertical-align:top;
            background: linear-gradient(180deg,#". $CIE_COLOR6.",#". $CIE_COLOR6_2.");
            color:#". $CIE_COLOR7.";
            position: sticky;
            top: 0;
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        }
        .tblDATA tr:nth-child(even){background-color: #". $CIE_COLOR7_2.";}
        .tblDATA tr:nth-child(odd){background-color: #". $CIE_COLOR7_3.";}
        .tblDATA tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;border-left:1px solid ". $CIE_COLOR6.";}
        .odd{background-color: #". $CIE_COLOR7_3.";} 
        .even{background-color: #". $CIE_COLOR7_2.";} 
        .selected{ border: 1pt solid #". $CIE_COLOR0_1.";box-shadow: inset 0px 0px 4px 2px #". $CIE_COLOR0_1.";}
        .short{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
    <body style='padding:10px;'>";
    $htmlContent2 .= "Questionnaire: #".$head_id." <b>".$head_name."</b><br>";
    $htmlContent2 .= "Date et heure complété: <b>".$date_completed."</b><br><br>";
    if ($head_parent_table == "customer"){
        $htmlContent2 .= "Questionnaire conçu pour les clients ou clients potentiels<br>";
        $htmlContent2 .= "Email entré sur le formulaire: <b>".dw3_decrypt($head_report_eml) ."</b><br>";
        if ($head_customer_name != "" || $head_customer_cie != "" || $head_customer_adr1 != "" || $head_customer_tel != ""){
            $htmlContent2 .= "Client trouvé avec ce courriel: <table style='width:100%;'><tr>
        <td rowspan='3' style='vertical-align:top;'>Client:</td><td width='50%' rowspan='3'>". $head_customer_fname ." ". $head_customer_name ." <b>". $head_customer_cie . "</b><br>".$head_customer_adr1 ." ". $head_customer_adr2."<br>".$head_customer_city .", ". $head_customer_prov."<br>Canada ". $head_customer_cp."</td>
        <td style='width:100px;'>Date:</td><td>". $today . "</td></tr>
        <tr><td style='width:100px;'>Téléphone:</td><td>". $head_customer_tel . "</td></tr>
        <tr><td style='width:100px;'>Courriel:</td><td>". $head_customer_eml . "</td></tr></table>
        <br>";
        } else {
            $htmlContent2 .= "Aucun client trouvé avec ce courriel<br>";
        }
    } else if ($head_parent_table == "user"){
        $htmlContent2 .= "Questionnaire conçu pour les employés ou employés potentiels<br>";
        $htmlContent2 .= "Email entré sur le formulaire: <b>".$head_report_eml ."</b><br>";
        if (trim($head_user_name) != ""){
            $htmlContent2 .= "Employé trouvé avec ce courriel: <b>".$head_user_name."</b><br>";
        } else {
            $htmlContent2 .= "Aucun employé trouvé avec ce courriel<br>";
        }
    }
    $htmlContent2 .= "<hr>";
	$sql = "SELECT A.*,B.id AS id,B.name_fr AS name_fr,B.description_fr AS description_fr, B.response_type AS response_type, B.box_size AS box_size,
     B.choice_name1 AS choice_name1, B.choice_name2 AS choice_name2, B.choice_name3 AS choice_name3,
     B.choice_name4 AS choice_name4, B.choice_name5 AS choice_name5,B.choice_name6 AS choice_name6,
     B.choice_name7 AS choice_name7,B.choice_name8 AS choice_name8,B.choice_name9 AS choice_name9,B.choice_name0 AS choice_name0,
     B.choice_value1 AS choice_value1, B.choice_value2 AS choice_value2, B.choice_value3 AS choice_value3,
     B.choice_value4 AS choice_value4, B.choice_value5 AS choice_value5,B.choice_value6 AS choice_value6,
     B.choice_value7 AS choice_value7,B.choice_value8 AS choice_value8,B.choice_value9 AS choice_value9,B.choice_value0 AS choice_value0,
     B.record_name AS record_name, B.position AS position
        FROM prototype_data A
        LEFT JOIN prototype_line B ON A.line_id = B.id
        WHERE A.report_id = '" . $ID . "'  ORDER BY B.position ASC;";

	$result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        $htmlContent2 .= "<table class='tblDATA'><tr><th colspan='2'>Donnés entrées sur le formulaire:</th></tr>";
		while($row = $result->fetch_assoc()) {
    //TEXT
            if($row["response_type"] == "TEXT"){
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td>";
                $htmlContent2 .= "<b> ".$row["value1"]."</b></td></tr>";
    //MULTI-TEXT
            } else if($row["response_type"] == "MULTI-TEXT"){
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td>";
                //valeur1
                if($row["choice_name1"] != ""){
                    $htmlContent2 .= $row["choice_name1"];
                }
                    $htmlContent2 .= "<b> ".$row["value1"]."</b>";
                //valeur2
                if($row["choice_name2"] != ""){
                    $htmlContent2 .= "<br class='br_small'>".$row["choice_name2"];
                    $htmlContent2 .= "<b> ".$row["value2"]."</b>";
                }
                //valeur3
                if($row["choice_name3"] != ""){
                    $htmlContent2 .= "<br class='br_small'>".$row["choice_name3"];
                    $htmlContent2 .= "<b> ".$row["value3"]."</b>";
                }
                //valeur4
                if($row["choice_name4"] != ""){
                    $htmlContent2 .= "<br class='br_small'>".$row["choice_name4"];
                    $htmlContent2 .= "<b> ".$row["value4"]."</b>";
                }
                //valeur5
                if($row["choice_name5"] != ""){
                    $htmlContent2 .= "<br class='br_small'>".$row["choice_name5"];
                    $htmlContent2 .= "<b> ".$row["value5"]."</b>";
                }
                //valeur6
                if($row["choice_name6"] != ""){
                    $htmlContent2 .= "<br class='br_small'>".$row["choice_name6"];
                    $htmlContent2 .= "<b> ".$row["value6"]."</b>";
                }
                //valeur7
                if($row["choice_name7"] != ""){
                    $htmlContent2 .= "<br class='br_small'>".$row["choice_name7"];
                    $htmlContent2 .= "<b> ".$row["value7"]."</b>";
                }
                //valeur8
                if($row["choice_name8"] != ""){
                    $htmlContent2 .= "<br class='br_small'>".$row["choice_name8"];
                    $htmlContent2 .= "<b> ".$row["value8"]."</b>";
                }
                //valeur9
                if($row["choice_name9"] != ""){
                    $htmlContent2 .= "<br class='br_small'>".$row["choice_name9"];
                    $htmlContent2 .= "<b> ".$row["value9"]."</b>";
                }
                //valeur0
                if($row["choice_name0"] != ""){
                    $htmlContent2 .= "<br class='br_small'>".$row["choice_name0"];
                    $htmlContent2 .= "<b> ".$row["value0"]."</b>";
                }
                $htmlContent2 .= "</td></tr>";
    //CHECKBOX        
            } else if($row["response_type"] == "CHECKBOX"){
                if ($row["value1"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td>".$is_checked."</td></tr>";
    //YES/NO      
            } else if($row["response_type"] == "YES/NO"){
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td>";
                $htmlContent2 .= " <b> <u>".$row["value1"]."</u></b></td></tr>";
    //CHOICE        
            } else if($row["response_type"] == "CHOICE"){
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td>";
                $htmlContent2 .= " <b><u> ".$row["value1"]."</u></b></td></tr>";
    //MULTI-CHOICE
            } else if($row["response_type"] == "MULTI-CHOICE"){
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td>";
                //valeur1
                    if ($row["value1"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                    $htmlContent2 .= "<b> ".$is_checked."</b> ".$row["choice_name1"];
                //valeur2
                    if ($row["value2"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                    $htmlContent2 .= "<br><b> ".$is_checked."</b> ".$row["choice_name2"];
                //valeur3
                if($row["choice_name3"] != ""){
                    if ($row["value3"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                    $htmlContent2 .= "<br><b>".$is_checked."</b> ".$row["choice_name3"];
                }
                //valeur4
                if($row["choice_name4"] != ""){
                    if ($row["value4"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                    $htmlContent2 .= "<br><b>".$is_checked."</b> ".$row["choice_name4"];
                }
                //valeur5
                if($row["choice_name5"] != ""){
                    if ($row["value5"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                    $htmlContent2 .= "<br><b>".$is_checked."</b> ".$row["choice_name5"];
                }
                //valeur6
                if($row["choice_name6"] != ""){
                    if ($row["value6"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                    $htmlContent2 .= "<br><b>".$is_checked."</b> ".$row["choice_name6"];
                }
                //valeur7
                if($row["choice_name7"] != ""){
                    if ($row["value7"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                    $htmlContent2 .= "<br><b>".$is_checked."</b> ".$row["choice_name7"];
                }
                //valeur8
                if($row["choice_name8"] != ""){
                    if ($row["value8"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                    $htmlContent2 .= "<br><b>".$is_checked."</b> ".$row["choice_name8"];
                }
                //valeur9
                if($row["choice_name9"] != ""){
                    if ($row["value9"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                    $htmlContent2 .= "<br><b>".$is_checked."</b> ".$row["choice_name9"];
                }
                //valeur0
                if($row["choice_name0"] != ""){
                    if ($row["value0"]=="1"){$is_checked = "&#9989;";} else {$is_checked = "&#10065;";}
                    $htmlContent2 .= "<br><b>".$is_checked."</b> ".$row["choice_name0"];
                }
                $htmlContent2 .= "</td></tr>";
    //FILE
            } else if($row["response_type"] == "FILE"){
                $extension = strtolower(pathinfo($row["value1"], PATHINFO_EXTENSION));
                if ($extension=="png"||$extension=="jpg"||$extension=="jpeg"||$extension=="webp"){
                    if ($head_parent_id != 0){
                        $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td><img style='width:300px;' src='https://" . $_SERVER["SERVER_NAME"] . "/fs/".$head_parent_table."/".$head_parent_id."/".$row["value1"]."'></td></tr>";
                    } else {
                        $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td><img style='width:300px;' src='https://" . $_SERVER["SERVER_NAME"] . "/fs/".$head_parent_table."/upload/".$row["value1"]."'></td></tr>";
                    }
                } else if ($row["value1"] != 'undefined') {
                    if ($head_parent_id != 0){
                        $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td><a href='https://" . $_SERVER["SERVER_NAME"] . "/fs/".$head_parent_table."/".$head_parent_id."/".$row["value1"]."' target='_blank'>".$row["value1"]."</a></td></tr>";
                    } else {
                        $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td><a href='https://" . $_SERVER["SERVER_NAME"] . "/fs/".$head_parent_table."/upload/".$row["value1"]."' target='_blank'>".$row["value1"]."</a></td></tr>";
                    }
                } else {
                    $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td>".$row["value1"]."</td></tr>";
                }
    //COLOR
            } else if($row["response_type"] == "COLOR"){
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td><div style='display:inline-block;width:15px;height:15px;background:".$row["value1"].";'> </div> ".$row["value1"]."</b></td></tr>";
    //PASSWORD
            } else if($row["response_type"] == "PASSWORD"){
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td><b> ".$row["value1"]."</b></td></tr>";
    //DATE
            } else if($row["response_type"] == "DATE"){
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td><b> ".$row["value1"]."</b></td></tr>";
    //TIME
            } else if($row["response_type"] == "TIME"){
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td><b>".$row["value1"]."</b></td></tr>";
    //SIGNATURE
            } else if($row["response_type"] == "SIGNATURE"){
                $htmlContent2 .= "<tr><td>".$row["name_fr"]."</td><td>";
                $sig_path = $_SERVER['DOCUMENT_ROOT'] . "/fs/customer/upload/doc-sig-". $ID ."-".$row["id"]. ".png";
                $sig_path_pub = "https://" . $_SERVER["SERVER_NAME"] . "/fs/customer/upload/doc-sig-". $ID ."-".$row["id"]. ".png";
                if (file_exists($sig_path)){
                    $htmlContent2 .= "<img src='" . $sig_path_pub . "' style='width:auto;height:90px;max-width:335px;'>"; 
                }
                $htmlContent2 .= "</td></tr>";
            }
		}
        $htmlContent2 .= "</table>";
	}

if ($head_parent_table == "customer"){
    $subject2 = "Questionnaire #".$head_id." " .$head_name. " remplis par " . dw3_decrypt($head_report_eml);
} else if ($head_parent_table == "user") {
    $subject2 = "Questionnaire #".$head_id." " .$head_name. " remplis par " . $head_report_eml;
}
  $htmlContent2 .= "<br><table style='width:100%;font-size:10px;'><tr>
        <td width='45%' style='text-align:center;'>https://" . $_SERVER["SERVER_NAME"] . "</td>
        <td width='2%' style='text-align:center;'>|</td><td width='45%' style='text-align:center;'>".$CIE_TEL1."</td>
        </tr><tr><td colspan=3 style='text-align:center;'>".$CIE_NOM."</td></tr>
        </table>
    </body>
  </html>";
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  $email2 = new PHPMailer();
  $email2->CharSet = "UTF-8";
  $email2->SetFrom('no-reply@'.$_SERVER["SERVER_NAME"],$CIE_NOM); 
  $email2->Subject   = $subject2;
  $email2->Body      = $htmlContent2;
  $email2->IsHTML(true); 
    if (trim($CIE_EML4) == ""){
        $email2->AddAddress($CIE_EML1);
    } else {
        $email2->AddAddress($CIE_EML4);
    }
 // $file_to_attach = $_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $enID . ".pdf";
 // $email->AddAttachment( $file_to_attach , $enID . '.pdf' );
  $mail_ret2 = $email2->Send();
  if (!$mail_ret2){
    error_log("Mailer Error: sendQuiz:" .$email2->ErrorInfo . " From:" . 'no-reply@'.$_SERVER["SERVER_NAME"] . " To: " . $CIE_EML1);
  }
  $dw3_conn->close();
?>
