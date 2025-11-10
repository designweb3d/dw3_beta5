<?php 
    if 	($SECTION_IMG_DSP=="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
    if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}
?>
<div style='width:100%;text-align:center;margin:<?php echo $SECTION_MARGIN . ";" . $bg_gradiant; ?>'>
    <div class='hoverShadow' onclick="dw3_sub_toggle('dw3_subR<?php echo $SECTION_ID; ?>','1000','spanPlus<?php echo $SECTION_ID; ?>')" style='max-width:<?php echo $SECTION_MAXW; ?>;width:100%;border-radius:5px;display:inline-block;min-height:40px;box-shadow:0px 0px 6px 3px <?php echo $SECTION_BG; ?>;background-color:<?php echo $SECTION_BG; ?>;color:<?php echo $SECTION_FG; ?>;<?php echo $font_family ?>'>
        <div style='text-shadow:0px 0px 3px #3AA9A7;cursor:pointer;text-align:left;user-select: none;'>
            <div style='display:flex;text-align:left;vertical-align:top;padding:10px 0px 5px 10px;'>
                <div id='spanPlus<?php echo $SECTION_ID; ?>' style='vertical-align:top;display:inline-block;text-align:center;width:20px;font-weight:bold;min-height:20px;padding-top:3px;'>+</div> 
                <?php if ($SECTION_ICON != ""){ ?>
                    <div class="dw3_font" style="width:30px;text-align:center;margin:0px 5px 0px 0px;vertical-align:top;font-size:1.5em;color:<?php echo $SECTION_ICON_COLOR; ?>;text-shadow:<?php echo $SECTION_ICON_TEXT_SHADOW; ?>;"><?php echo $SECTION_ICON; ?></div>
                <?php }
                if($USER_LANG == "FR"){
                    echo "<div style='line-height:1em;vertical-align:top;'><b>".$SECTION_TITLE."</b></div>";
                } else {
                    echo "<div style='line-height:1em;vertical-align:top;'><b>".$SECTION_TITLE_EN."</b></div>";
                }
                ?>
            </div>
        </div>
    </div><div></div>
    <div id='dw3_subR<?php echo $SECTION_ID; ?>' class='dw3_sub' style='display:inline-block;width:100%;max-width:<?php echo $SECTION_MAXW; ?>;margin-bottom:3px;'>
        <div style='<?php echo $font_family ?>border-radius:0px 0px 25px 25px;background-color:<?php echo $SECTION_BG; ?>;color:<?php echo $SECTION_FG; ?>;text-align:left;width:100%;display:inline-block;<?php echo $bg_gradiant.$font_family;?>'> 
            <div style='padding:15px 25px 15px 25px;line-height:1.5;text-align:justify;'>
                <?php 
                if ($USER_LANG == "FR"){
                    echo $SECTION_HTML_FR;
                } else {
                    echo $SECTION_HTML_EN;
                }          
                ?>  
            </div>
        </div>
    </div>
</div> 
