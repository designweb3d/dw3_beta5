<div id="slide_show_container" style='width:100%;height:auto;text-align:left;padding:0;background-color:<?php echo $SECTION_BG; ?>;width:100%;text-align:center;margin:<?php echo $SECTION_MARGIN; ?>;display:inline-block;text-align:center;height:auto;border-radius:<?php echo $SECTION_RADIUS; ?>;max-width:<?php echo $SECTION_MAXW; ?>;box-shadow: <?php echo $SECTION_SHADOW; ?>;'>
    <section class="slider-wrapper">
        <button class="slide-arrow no-effect" id="slide-arrow-prev">&#8249;</button>
        <button class="slide-arrow no-effect" id="slide-arrow-next">&#8250;</button>
        <ul class="slides-container" id="slides-container">
        <?php 
        $dots = "<div style='position:absolute;left:0px;bottom:5px;width:100%;text-align:center;display:inline-block;'><div style='background:rgba(0,0,0,0.6);border-radius:10px;display:inline-block;padding:5px 15px 3px 15px;'>";
        $dw3_sql = "SELECT * FROM slideshow WHERE index_id='".$SECTION_ID."' ORDER BY id DESC;"; 
        $dw3_result_sl = $dw3_conn->query($dw3_sql);

        $slides_count = $dw3_result_sl->num_rows;
        
        $slide_num = 0;
            if ($slides_count > 0) {
                while($row_sl = $dw3_result_sl->fetch_assoc()) {
                    $slide_num++;
                    if ($row_sl["media_type"]=="video"){
                        ?>
                        <li class='slide'>
                            <div style='text-align:center;width:100%;height:auto;background:rgba(255,255,255,0.7);border-radius:7px;'>
                            <?php if ($row_sl["media_url"]!=""){ echo "<a href='" . $row_sl["media_url"] . "' target='_blank'>";} ?><video style='width:100%;height:auto;max-width:100%;'><source src='<?php echo $row_sl["media_link"]; ?>'></video><?php if ($row_sl["media_url"]!=""){ echo "</a>";} ?>
                            </div>
                        </li>
                        <?php                        
                    } else if ($row_sl["media_type"]=="image"){
                        ?>
                        <li class='slide'>
                            <div style='text-align:center;width:100%;height:auto;background:rgba(255,255,255,0.7);border-radius:7px;'>
                            <?php if ($row_sl["media_url"]!=""){ echo "<a href='" . $row_sl["media_url"] . "' target='_blank'>";} ?><img style='width:100%;height:auto;max-width:100%;' src='<?php echo $row_sl["media_link"]; ?>'><?php if ($row_sl["media_url"]!=""){ echo "</a>";} ?>
                            <span id='slide-text<?php echo $slide_num; ?>' style='display:none;'><?php if($USER_LANG == "FR"){echo $row_sl["description_fr"];}else{echo $row_sl["description_en"];} ?></span>
                            </div>
                        </li>
                        <?php                        
                    }
                    if ($slide_num == 1){
                        $dots .= "<div onclick='changeSlideTo(".$slide_num.");' id='slide_dot".$slide_num."' style='transition: all 0.5s linear;display:inline-block;width:10px;height:10px;border-radius:5px;margin:10px 5px;background:rgba(255,255,255,1);cursor:pointer;'> </div>";
                    } else {
                        $dots .= "<div onclick='changeSlideTo(".$slide_num.");' id='slide_dot".$slide_num."' style='transition: all 0.5s linear;display:inline-block;width:10px;height:10px;border-radius:5px;margin:10px 5px;background:rgba(155,155,155,0.5);cursor:pointer;'> </div>";
                    }
                }
            }
            $dots .= "</div></div>";
        ?>
        </ul><div style='position:absolute;bottom:50px;left:0px;width:100%;height:60px;text-align:center;line-height:60px;display:inline-block;'><span style='vertical-align:middle;display: inline-block;line-height: 1em;' id='slide_text'></span></div>
        <?php if ($slide_num > 1) {echo $dots;} ?>
    </section>
</div><input id='slide1_num' type='text' style='display:none;' value='<?php echo $slides_count; ?>'>