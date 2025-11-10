<?php
$SID = $_GET['SID']??'';
header("SECTION_ID:".$_SERVER['HTTP_SECTION_ID']);
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.min.php';

?>
                    <?php //JANVIER class='dw3_third_view_div'
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 1 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 1  AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) { ?>
    <div id='divCAL2' style='margin-bottom:-7px;box-shadow: <?php echo $SECTION_SHADOW; ?>;'>           
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Janvier"; }else { echo "January";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style='height:100px;text-align:center;'><?php
                            while($row = $result->fetch_assoc()) {
                                //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                                echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                                    if($USER_LANG == "FR"){
                                    echo  "<h3>".$row['name']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Janvier";
                                    }else{
                                        echo "Le <b>". substr($row['date_start'],8,2) . "</b> Janvier";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                    }                                    
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }else{
                                    echo  "<h3>".$row['name_en']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> January";
                                    }else{
                                        echo "The <b>". substr($row['date_start'],8,2) . "</b> January";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                    }
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }
                                echo "</div>";
                                //if (trim($row['href'])!="") {echo "</a>";}
                            }
                            echo "                </td></tr></tbody></table>";
                        } 
 //Février - February
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 2 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 2  AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) { ?>
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Février"; }else { echo "February";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>   
                <td style='height:100px;text-align:center;'> <?php
                            while($row = $result->fetch_assoc()) {
                                //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                                echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                                    if($USER_LANG == "FR"){
                                    echo  "<h3>".$row['name']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Février";
                                    }else{
                                        echo "Le <b>". substr($row['date_start'],8,2) . "</b> Février";
                                    }
                                        if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                            echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                        }                                    
                                        $cur_cd = $row['id'];
                                        $cur_time = $row['date_start'];
                                        echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                        echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }else{
                                    echo  "<h3>".$row['name_en']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> February";
                                    }else{
                                        echo "The <b>". substr($row['date_start'],8,2) . "</b> February";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                    }
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Details..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }
                                echo "</div>";
                                //if (trim($row['href'])!="") {echo "</a>";}
                            }
                            echo "                </td></tr></tbody></table>";
                        }
//Mars - March
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 3 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 3  AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                       $result = $dw3_conn->query($sql);
                       if ($result->num_rows > 0) { ?>
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Mars"; }else { echo "March";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>    
                <td style='height:100px;text-align:center;'> <?php
                           while($row = $result->fetch_assoc()) {
                            //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                            echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                            if($USER_LANG == "FR"){
                                echo  "<h3>".$row['name']. "</h3>";
                                if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                    echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Mars";
                                }else{
                                    echo "Le <b>". substr($row['date_start'],8,2) . "</b> Mars";
                                }
                                if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                    echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                }                                
                                $cur_cd = $row['id'];
                                $cur_time = $row['date_start'];
                                echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                            echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                            }else{
                                echo  "<h3>".$row['name_en']. "</h3>";
                                if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                    echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> March";
                                }else{
                                    echo "The <b>". substr($row['date_start'],8,2) . "</b> March";
                                }
                                if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                    echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                }
                                $cur_cd = $row['id'];
                                $cur_time = $row['date_start'];
                                echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                            echo "<br style='margin:0px;'>Details..<span style='font-size:1em;' class='dw3_font'>³</span>";
                            }
                            echo "</div>";
                            //if (trim($row['href'])!="") {echo "</a>";}
                           }
                           echo "                </td></tr></tbody></table>";
                        }
//Avril - April
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 4 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 4 AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) { ?>
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Avril"; }else { echo "April";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style='height:100px;text-align:center;'> <?php
                            while($row = $result->fetch_assoc()) {
                                //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                                echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                                    if($USER_LANG == "FR"){
                                    echo  "<h3>".$row['name']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Avril";
                                    }else{
                                        echo "Le <b>". substr($row['date_start'],8,2) . "</b> Avril";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                    }                                    
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }else{
                                    echo  "<h3>".$row['name_en']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> April";
                                    }else{
                                        echo "The <b>". substr($row['date_start'],8,2) . "</b> April";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                    }
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Details..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }
                                echo "</div>";
                                //if (trim($row['href'])!="") {echo "</a>";}
                            }
                            echo "                </td></tr></tbody></table>";
                        }
//Mai - May
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 5 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 5 AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) { ?>

<table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Mai"; }else { echo "May";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>  
                <td style='height:100px;text-align:center;'> <?php
                            while($row = $result->fetch_assoc()) {
                                //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                                echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                                    if($USER_LANG == "FR"){
                                    echo  "<h3>".$row['name']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Mai";
                                    }else{
                                        echo "Le <b>". substr($row['date_start'],8,2) . "</b> Mai";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                    }                                    
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }else{
                                    echo  "<h3>".$row['name_en']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> May";
                                    }else{
                                        echo "The <b>". substr($row['date_start'],8,2) . "</b> May";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                    }
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Details..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }
                                echo "</div>";
                                //if (trim($row['href'])!="") {echo "</a>";}
                            }
                            echo "                </td></tr></tbody></table>";
                        }
//Juin - June
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 6 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 6 AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                       $result = $dw3_conn->query($sql);
                       if ($result->num_rows > 0) { ?>
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Juin"; }else { echo "June";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr> 
                <td style='height:100px;text-align:center;'> <?php
                           while($row = $result->fetch_assoc()) {
                            //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                            echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                            if($USER_LANG == "FR"){
                                echo  "<h3>".$row['name']. "</h3>";
                                if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                    echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Juin";
                                }else{
                                    echo "Le <b>". substr($row['date_start'],8,2) . "</b> Juin";
                                }
                                if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                    echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                }                                
                                $cur_cd = $row['id'];
                                $cur_time = $row['date_start'];
                                echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                            echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                            }else{
                                echo  "<h3>".$row['name_en']. "</h3>";
                                if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                    echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> June";
                                }else{
                                    echo "The <b>". substr($row['date_start'],8,2) . "</b> June";
                                }
                                if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                    echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                }
                                $cur_cd = $row['id'];
                                $cur_time = $row['date_start'];
                                echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                            echo "<br style='margin:0px;'>Details..<span style='font-size:1em;' class='dw3_font'>³</span>";
                            }
                            echo "</div>";
                            //if (trim($row['href'])!="") {echo "</a>";}
                           }
                           echo "                </td></tr></tbody></table>";
                        }
//Juillet - July
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 7 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 7 AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) { ?>
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Juillet"; }else { echo "July";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style='height:100px;text-align:center;'> <?php
                            while($row = $result->fetch_assoc()) {
                                //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                                echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                                    if($USER_LANG == "FR"){
                                    echo  "<h3>".$row['name']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Juillet";
                                    }else{
                                        echo "Le <b>". substr($row['date_start'],8,2) . "</b> Juillet";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                    }                                    
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }else{
                                    echo  "<h3>".$row['name_en']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> July";
                                    }else{
                                        echo "The <b>". substr($row['date_start'],8,2) . "</b> July";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                    }
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Details..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }
                                echo "</div>";
                                //if (trim($row['href'])!="") {echo "</a>";}
                            }
                            echo "                </td></tr></tbody></table>";
                        }
//Aôut - August
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 8 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 8 AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) { ?>
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Aôut"; }else { echo "August";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>     
                <td style='height:100px;text-align:center;'> <?php
                            while($row = $result->fetch_assoc()) {
                                //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                                echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                                    if($USER_LANG == "FR"){
                                    echo  "<h3>".$row['name']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Aôut";
                                    }else{
                                        echo "Le <b>". substr($row['date_start'],8,2) . "</b> Aôut";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                    }                                    
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }else{
                                    echo  "<h3>".$row['name_en']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> August";
                                    }else{
                                        echo "The <b>". substr($row['date_start'],8,2) . "</b> August";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                    }
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }
                                echo "</div>";
                                //if (trim($row['href'])!="") {echo "</a>";}
                            }
                            echo "                </td></tr></tbody></table>";
                        }
//Septembre - September
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 9 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 9 AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                       $result = $dw3_conn->query($sql);
                       if ($result->num_rows > 0) { ?>
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Septembre"; }else { echo "September";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>  
                <td style='height:100px;text-align:center;'> <?php
                           while($row = $result->fetch_assoc()) {
                            //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                            echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                            if($USER_LANG == "FR"){
                                echo  "<h3>".$row['name']. "</h3>";
                                if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                    echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Septembre";
                                }else{
                                    echo "Le <b>". substr($row['date_start'],8,2) . "</b> Septembre";
                                }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                    }                                
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                            }else{
                                echo  "<h3>".$row['name_en']. "</h3>";
                                if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                    echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> September";
                                }else{
                                    echo "The <b>". substr($row['date_start'],8,2) . "</b> September";
                                }
                                if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                    echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                }
                                $cur_cd = $row['id'];
                                $cur_time = $row['date_start'];
                                echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                            echo "<br style='margin:0px;'>Details..<span style='font-size:1em;' class='dw3_font'>³</span>";
                            }
                            echo "</div>";
                            //if (trim($row['href'])!="") {echo "</a>";}
                           }
                           echo "                </td></tr></tbody></table>";
                        }
//Octobre - October
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 10 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 10 AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) { ?>
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Octobre"; }else { echo "October";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style='height:100px;text-align:center;'> <?php
                            while($row = $result->fetch_assoc()) {
                                //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                                echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                                    if($USER_LANG == "FR"){
                                    echo  "<h3>".$row['name']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Octobre";
                                    }else{
                                        echo "Le <b>". substr($row['date_start'],8,2) . "</b> Octobre";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                    }                                    
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }else{
                                    echo  "<h3>".$row['name_en']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> October";
                                    }else{
                                        echo "The <b>". substr($row['date_start'],8,2) . "</b> October";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                    }
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }
                                echo "</div>";
                                //if (trim($row['href'])!="") {echo "</a>";}
                            }
                            echo "                </td></tr></tbody></table>";
                        }
//Novembre - November
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 11 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 11 AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) { ?>
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Novembre"; }else { echo "November";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>    
                <td style='height:100px;text-align:center;'> <?php
                            while($row = $result->fetch_assoc()) {
                                //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                                echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                                    if($USER_LANG == "FR"){
                                    echo  "<h3>".$row['name']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Novembre";
                                    }else{
                                        echo "Le <b>". substr($row['date_start'],8,2) . "</b> Novembre";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                    }                                      
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }else{
                                    echo  "<h3>".$row['name_en']. "</h3>";
                                    if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                        echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> November";
                                    }else{
                                        echo "The <b>". substr($row['date_start'],8,2) . "</b> November";
                                    }
                                    if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                        echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                    }
                                    $cur_cd = $row['id'];
                                    $cur_time = $row['date_start'];
                                    echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                                    echo "<br style='margin:0px;'>Details..<span style='font-size:1em;' class='dw3_font'>³</span>";
                                }
                                echo "</div>";
                                //if (trim($row['href'])!="") {echo "</a>";}
                            }
                            echo "                </td></tr></tbody></table>";
                        }
//Décembre - December
                        $sql = "SELECT * FROM event
                                WHERE YEAR(date_start) = YEAR(curdate()) AND MONTH(date_start) = 12 AND event_type = 'PUBLIC'
                                    OR  YEAR(end_date) = YEAR(curdate()) AND MONTH(end_date) = 12 AND event_type = 'PUBLIC'
                                ORDER BY date_start";
                       $result = $dw3_conn->query($sql);
                       if ($result->num_rows > 0) { ?>
        <table class='tblCAL2'>
            <thead>
            <tr>
                <th width='33%'><?php if($USER_LANG == "FR"){ echo "Décembre"; }else { echo "December";} ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>   
                <td style='height:100px;text-align:center;'> <?php
                           while($row = $result->fetch_assoc()) {
                            //if (trim($row['href'])!="") {echo "<a href='".$row['href']."' target='_blank'>";}
                            echo "<div class='dw3_box' onclick=\"getEVENT('".$row['id']."');\" style='cursor:pointer;font-weight:normal;background-color:#e0e0e0;color:#222;margin:5px 2px 5px 2px;width:94%;'>";
                            if($USER_LANG == "FR"){
                                echo  "<h3>".$row['name']. "</h3>";
                                if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                    echo "Du <b>". substr($row['date_start'],8,2). "</b> au <b>".substr($row['end_date'],8,2) . "</b> Décembre";
                                }else{
                                    echo "Le <b>". substr($row['date_start'],8,2) . "</b> Décembre";
                                }
                                if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                    echo "<br style='margin:0px;'>De <b>". substr($row['date_start'],11,5). "</b> à <b>".substr($row['end_date'],11,5) . "</b>";
                                }
                                $cur_cd = $row['id'];
                                $cur_time = $row['date_start'];
                                echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                            echo "<br style='margin:0px;'>Détails..<span style='font-size:1em;' class='dw3_font'>³</span>";
                            }else{
                                echo  "<h3>".$row['name_en']. "</h3>";
                                if (substr($row['date_start'],0,10) != substr($row['end_date'],0,10)){
                                    echo "From <b>". substr($row['date_start'],8,2). "</b> to <b>".substr($row['end_date'],8,2) . "</b> December";                                
                                }else{
                                    echo "The <b>". substr($row['date_start'],8,2) . "</b> December";
                                }
                                if (substr($row['date_start'],11,5) != "00:00" && substr($row['end_date'],11,5) != "00:00"){
                                    echo "<br style='margin:0px;'>Starting at <b>". substr($row['date_start'],11,5). "</b> to <b>".substr($row['end_date'],11,5) . "</b>";
                                }
                                $cur_cd = $row['id'];
                                $cur_time = $row['date_start'];
                                echo "<p style='width:100%;text-align:center;' class='count_down' id='cd".$row['id']."'>".$cur_time."</p>";
                            echo "<br style='margin:0px;'>Details..<span style='font-size:1em;' class='dw3_font'>³</span>";
                            }
                            echo "</div>";
                            //if (trim($row['href'])!="") {echo "</a>";}
                           }
                           echo "                </td></tr></tbody></table>";
                        }
                    ?>
    </div>