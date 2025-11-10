<?php 
    if 	($SECTION_IMG_DSP=="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
    if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}

    echo "<canvas id='dw3_catbot_canvas' style='text-align:center;margin:". $SECTION_MARGIN.";display:inline-block;text-align:center;height:auto;border-radius:". $SECTION_RADIUS.";box-shadow:". $SECTION_SHADOW.";".$bg_gradiant.$font_family."'></canvas>";

    echo "<div style=position:absolute;top:125px;left:5px;z-index:+1;'><input id='dw3_chatbot_auto' type='checkbox' onclick='dw3_chatbot_speech()'> <label for='dw3_chatbot_auto' style='color:". $SECTION_FG.";'><span class='dw3_font' style='margin-top:-8px;'>ĕ</span></label></div>
        <div style='position:absolute;top:155px;color:". $SECTION_FG.";width:100%;line-height:1.2;'><div id='dw3_chatbot_response' style='text-align:left;background:rgba(0,0,0,0.9);font-size:20px;box-shadow:0px 0px 3px 1px grey;width:320px;padding:5px;height:120px;max-height:100px;'>";
        if($USER_LANG == "FR"){ 
            echo $SECTION_HTML_FR;
        }else{
            echo $SECTION_HTML_EN;
        }
    echo "</div><button class='no-effect' onclick='dw3_chatbot_ask()'><span class='dw3_font'>Ė</span></button><textarea id='dw3_chatbot_q' style='width:320px;margin:5px;height:50px;width:60%;vertical-align:middle;'></textarea><button class='no-effect' onclick='dw3_chatbot_ask()'><span class='dw3_font'>ł</span></button></div>";

?>

<script type="module" src="/pub/section/chatbot/section.js?t=<?php echo(rand(100,100000)); ?>" data-bg3="/pub/img/<?php echo $CIE_BG3; ?>"></script>