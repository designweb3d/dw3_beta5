<?php 
if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}
if 	($SECTION_IMG_DSP=="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
echo "<div style='width:100%;text-align:center;margin:". $SECTION_MARGIN.";'>
<div style='display:inline-block;width:100%;max-width:". $SECTION_MAXW.";background-color:".$SECTION_BG.";color:". $SECTION_FG.";".$font_family."border-radius:". $SECTION_RADIUS.";box-shadow:". $SECTION_SHADOW.";'>
<div class='dw3_tabs'>";
$sql = "SELECT * FROM index_line WHERE head_id = '".$SID."' ORDER BY sort_order ASC;";
$result = $dw3_conn->query($sql);
$html = "";
$row_num = 0;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row_num++;
        if ($row_num == 1){
            $display_first_tab = "block";
            $bg_first_link = "#ccc";
        } else {
            $display_first_tab = "none";
            $bg_first_link = "inherit";
        }
        if ($USER_LANG == "FR"){
            echo "<div class='dw3_tabs_links_".$SECTION_ID."' onclick=\"dw3_change_tab(event, 'dw3_tabs_".$SECTION_ID."_".$row["id"]."','dw3_tabs_content_".$SECTION_ID."','dw3_tabs_links_".$SECTION_ID."')\" style='background-color:".$bg_first_link.";'>".$row["title_fr"]."</div>";
            $html .= "<div id='dw3_tabs_".$SECTION_ID."_".$row["id"]."' class='dw3_tabs_content dw3_tabs_content_".$SECTION_ID."' style='display:".$display_first_tab.";'><p>".$row["html_fr"]."</p></div>\n";
        } else {
            echo "<div class='dw3_tabs_links_".$SECTION_ID."' onclick=\"dw3_change_tab(event, 'dw3_tabs_".$SECTION_ID."_".$row["id"]."','dw3_tabs_content_".$SECTION_ID."','dw3_tabs_links_".$SECTION_ID."')\" style='background-color:".$bg_first_link.";'>".$row["title_en"]."</div>";
            $html .= "<div id='dw3_tabs_".$SECTION_ID."_".$row["id"]."' class='dw3_tabs_content dw3_tabs_content_".$SECTION_ID."' style='display:".$display_first_tab.";'><p>".$row["html_en"]."</p></div>\n";
        }
    }
}
echo "</div>";
echo $html."</div></div>";
?>