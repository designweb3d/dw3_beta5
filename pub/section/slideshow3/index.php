<div style="margin:<?php echo $SECTION_MARGIN; ?>;padding:25px 0px;display:inline-block;text-align:center;height:auto;font-size:0.85em;line-height:0.9;background-color:<?php echo $SECTION_BG; ?>;border-radius:<?php echo $SECTION_RADIUS; ?>;max-width:<?php echo $SECTION_MAXW; ?>;overflow:hidden;box-shadow: <?php echo $SECTION_SHADOW; ?>;">
    <?php 

      $dw3_sql = "SELECT * FROM slideshow WHERE index_id='".$SECTION_ID."' ORDER BY sort_by ASC, id ASC";
      $dw3_result = $dw3_conn->query($dw3_sql);
          if ($dw3_result->num_rows > 0) {
            echo "<div class='dw3_flip_card' id='dw3_flip_card_".$SECTION_ID."'>
                    <div class='dw3_flip_card_front'>";
            if ($SECTION_TITLE_DSP!="none" && $SECTION_TITLE_DSP!=""){
                echo "<div style='position:absolute;top:0px;left:0px;text-align:".$SECTION_TITLE_DSP.";color:#000;text-shadow:0px 0px 3px white;border-top-right-radius:10px;border-top-left-radius:10px;width:100%;padding:10px 0px 5px 0px;background-color:rgba(255,255,255,0.5)'>".$SECTION_TITLE."</div>"; 
                if ($USER_LANG == "FR"){
                    $gal3_title = $SECTION_TITLE ;
                } else {
                    $gal3_title = $SECTION_TITLE_EN ;
                }
            } else {
                $gal3_title = "";
            }
            $filenames = [];
            while($row = $dw3_result->fetch_assoc()) {
                $filenames[] = $row["media_link"];
            }

            $filename=$filenames[0] ;
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $filename)){
                $filename = "/pub/img/dw3/nd.png";
            } else {
                if (!is_file($_SERVER['DOCUMENT_ROOT'] . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                }
            }
            echo "<div style='display: flex;align-items: center;width:300px;height:300px;overflow:hidden;margin:0px 0px 5px 0px;border-radius:10px 10px 0px 0px;'><img onclick=\"var gal3_images_array_".$SECTION_ID." = ".str_replace("\"","'",json_encode($filenames)).";dw3_gal3_show(gal3_images_array_".$SECTION_ID.",'imgSLIDE_".$SECTION_ID."','".$gal3_title."')\" id='imgSLIDE_".$SECTION_ID."' style='cursor:pointer;margin:0px;width:300px;height:auto;' src='" . $filename . "' alt='".$filetitle."' onerror='this.onerror=null; this.src=\"/img/dw3/nd.png\";'></div>";                
            if(count($filenames)>1){
                $x_index = 0;
                foreach($filenames as $file) {
                       echo "<button class='no-effect' onclick=\"dw3_change_image3('" . $file . "','imgSLIDE_".$SECTION_ID."',".$x_index.")\" style='box-shadow: 1px 1px 4px 2px #555;border:0px;margin:0px 3px 5px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:40px;min-width:40px;max-width:40px;background-size:100% 100%;background-color:#FFF;background-image: url(\"" . $file . "\");'></button>";
                       $x_index++;
                }
            }
            echo "<button class='no-effect' onclick=\"dw3_card_to_back('dw3_flip_card_".$SECTION_ID."')\" style='position:absolute;bottom:0px;right:0px;'><span class='dw3_font' style='font-size:24px;'>ń</span></button>";
            echo "</div><div class='dw3_flip_card_back'>";
                if ($USER_LANG == "FR"){
                    echo $SECTION_HTML_FR ;
                } else {
                    echo $SECTION_HTML_EN ;
                }
                echo "<button class='no-effect' onclick=\"dw3_card_to_front('dw3_flip_card_".$SECTION_ID."')\" style='position:absolute;bottom:0px;right:0px;'><span class='dw3_font' style='font-size:24px;'>Ń</span></button>";
            echo "</div></div>";

          }
      ?>
</div>