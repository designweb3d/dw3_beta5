<div style="margin:<?php echo $SECTION_MARGIN; ?>;padding:0px;display:inline-block;text-align:left;height:450px;line-height:1.5em;background-color:<?php echo $SECTION_BG; ?>;border-radius:<?php echo $SECTION_RADIUS; ?>;max-width:<?php echo $SECTION_MAXW; ?>;overflow:hidden;box-shadow: <?php echo $SECTION_SHADOW; ?>;">
    <?php 
        if ($SECTION_TITLE_DSP!="none" && $SECTION_TITLE_DSP!=""){
            echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;margin-top:-15px;'>".$SECTION_TITLE."</h2>";
            
        }
    echo $SECTION_HTML_FR . "<div style='width:100%;overflow-x:auto;text-align:center;'>";
    $dw3_sql = "SELECT * FROM slideshow WHERE index_id='".$SECTION_ID."' ORDER BY id ASC";
    $dw3_result = $dw3_conn->query($dw3_sql);
        if ($dw3_result->num_rows > 0) {
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
            echo "<img id='imgSLIDE_".$SECTION_ID."' style='margin:5px;box-shadow: 2px 2px 5px 2px black;width:auto;height:300px;max-height:300px;max-width:415px;border-radius:5px;' src='" . $filename . "' onerror='this.onerror=null; this.src=\"/img/dw3/nd.png\";'>";                
            if(count($filenames)>1){
                echo "<div class='dw3_section'>";
                foreach($filenames as $file) {
                       echo "<button onclick=\"dw3_change_image('" . $file . "','imgSLIDE_".$SECTION_ID."')\" style='box-shadow: 1px 1px 4px 2px #555;border:0px;margin:0px 3px 5px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:40px;min-width:40px;max-width:40px;background-size:100% 100%;background-color:#FFF;background-image: url(\"" . $file . "\");'></button>";
                }
                echo "</div>";
            }
        }
    echo "</div>";
echo"</div>";
?>