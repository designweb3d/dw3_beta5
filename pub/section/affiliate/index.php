<?php 
/* $SID = $_GET['SID']??'';
if (isset($_SERVER['HTTP_SECTION_ID'])) {header("SECTION_ID:".$_SERVER['HTTP_SECTION_ID']);}
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.min.php'; */
echo $SECTION_HTML_FR . "";
if 	($SECTION_IMG_DSP=="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}
echo "<div id='slide_show_container' style='background-color:".$SECTION_BG.";color:". $SECTION_FG.";margin:". $SECTION_MARGIN.";width:100%;max-height:300px;text-align:left;padding:0;overflow:hidden;".$bg_gradiant.$font_family."'>";
?>
    <section class="slider-wrapper">
        <button class="slide-arrow no-effect" id="slide-arrow-prevA">
            &#8249; 
        </button>
        <button class="slide-arrow no-effect" id="slide-arrow-nextA">
            &#8250;
        </button>
        <ul class="slides-container" id="slides-container-affiliate">
        <?php 
        $dw3_sql = "SELECT * FROM affiliate ORDER BY id ASC";
        $dw3_result = $dw3_conn->query($dw3_sql);
            if ($dw3_result->num_rows > 0) {
                $slide_num = 0;
                while($row = $dw3_result->fetch_assoc()) {
                    $slide_num++;
                        echo "<li class='slideA'>
                            <div style='text-align:center;width:auto;height:240px;'>";
                            if ($row["href"] != ""){
                                echo "<img onclick=\"window.open('".$row["href"]."','_blank');\" alt='"; if($USER_LANG == "FR"){echo $row["name_fr"];}else{echo $row["name_en"];} echo "' style='cursor:pointer;width:auto;height:200px;max-width:100%;' src='". $row["img_link"]."'>";
                            } else {
                                echo "<img alt='"; if($USER_LANG == "FR"){echo $row["name_fr"];}else{echo $row["name_en"];} echo "' style='width:auto;height:200px;max-width:100%;' src='". $row["img_link"]."'>";
                            }
                            echo "<span id='slideAnum". $slide_num."' style='display:none;'>"; if($USER_LANG == "FR"){echo $row["description_fr"];}else{echo $row["description_en"];} echo "</span>
                            </div>
                        </li>";                     
                }
            }
        ?>
        </ul><div style='position:absolute;top:180px;width:100%;height:60px;text-align:center;line-height:60px;display:inline-block;'><span style='vertical-align:middle;display: inline-block;line-height: 1em;' id='slide_textA'></span></div>
    </section>
</div><input id='slideA_num' type='text' style='display:none;' value='<?php echo $slide_num; ?>'>