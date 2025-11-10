<div style='line-height:1;background-color:<?php echo $SECTION_BG; ?>;color:<?php echo $SECTION_FG; ?>;width:100%;text-align:center;margin:<?php echo $SECTION_MARGIN; ?>;display:inline-block;text-align:center;height:auto;border-radius:<?php echo $SECTION_RADIUS; ?>;max-width:<?php echo $SECTION_MAXW; ?>;box-shadow: <?php echo $SECTION_SHADOW; ?>;'>
    <br>
    <?php if ($SECTION_TITLE_DSP!="none" && $SECTION_TITLE_DSP!=""){
            if($USER_LANG == "FR"){
                echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;'>".$SECTION_TITLE."</h2>";
            } else {
                echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;'>".$SECTION_TITLE_EN."</h2>";
            }
        }
    ?>
    <!-- <h2 style="width:100%;text-align:center;letter-spacing:.2rem;color:#333;">Réalisations</h2> -->
            <div style="width:100%;text-align:center;margin-bottom:20px;">
                <div style="display:inline-block;width:50px;height:5px;border-radius:2px;background:#f17144;"> </div>
            </div>
            <div style="display:inline-block;max-width:1020px;margin:0px 60px 30px 60px;">
            <?php 
            if($USER_LANG == "FR"){
                echo $SECTION_HTML_FR . "</div><br>";
            }else{
                echo $SECTION_HTML_EN . "</div><br>";
            }
            ?>
        <div class="timeline2 timeline--loaded timeline--horizontal" style="display: inline-block; max-width: 1080px; width: 100%; opacity: 1;">
        <div class="timeline__wrap">
            <div class="timeline__items" style="width: 3885.5px; transform: translate3d(0px, 0px, 0px);">
                <?php
                    $sql = "SELECT * FROM historic ORDER BY sort_number DESC";
                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            if ($USER_LANG == "FR"){
                                $name_trad = $row["name_fr"];
                                $description_trad = $row["description_fr"];
                                if (trim($row["href"]) != "" && $row["href"] != "Lien / Link"){ $link_trad = "<br><a href='".$row["href"]."' style='font-size:13px;'><u><b>Plus de détails..</b></u></a>";}else{ $link_trad = "";}
                            }else{
                                $name_trad = $row["name_en"];
                                $description_trad = $row["description_en"];
                                if (trim($row["href"]) != "" && $row["href"] != "Lien / Link"){ $link_trad = "<br><a href='".$row["href"]."' style='font-size:13px;'><u><b>More details..</b></u></a>";}else{ $link_trad = "";}
                            }    
                            if (trim($row["img_link"]) != "" && $row["img_link"] != "Lien / Link Image"){ $img_link = "<br><img src='".$row["img_link"]."' style='width:100%;height:auto;'>";}else{ $img_link = "";}
                            
                            echo "<div class='timeline__item' style='width: 204.5px;'><div class='timeline__item__inner'><div class='timeline__content__wrap'><div class='timeline__content'>";
                            echo $name_trad ."</div></div></div><div style='position:absolute;top:120px;left:10px;right:10px;'>";
                            echo $description_trad.$img_link.$link_trad."</div></div>";
                        }
                    }
                ?>
            </div>
        </div>
        <button class="timeline-nav-button timeline-nav-button--prev" disabled="" style="top: 80px;">Previous</button><button class="timeline-nav-button timeline-nav-button--next" style="top: 80px;">Next</button><span class="timeline-divider" style="top: 80px;"></span></div>
    </div>