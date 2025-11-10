<section class="cd-horizontal-timeline">
        <div style="width:100%;font-size:2em;"><div style="display:inline-block;text-align:center;width:100%;margin-top:20px;">
            <?php if ($USER_LANG == "FR"){echo $SECTION_TITLE;}else{echo $SECTION_TITLE_EN;} ?>
        <br style="content: '';display: block;margin-top:-20px;"><div style="display:inline-block;width:40px;height:5px;border-radius:2px;background:#f17144;"> </div></div></div>
        <div class="paragraf2" style="margin:15px;display:inline-block;max-width:1020px;text-align:left;line-height:30px;color:#fff;vertical-align:top;">
            <?php if ($USER_LANG == "FR"){echo $SECTION_HTML_FR;}else{echo $SECTION_HTML_EN;} ?>
            <br><br>
        </div>
        <div class="timeline">
            <div class="events-wrapper">
                <div class="events" style="width:auto;">
                    <ol>
                    <?php
                        $sql = "SELECT * FROM realisation ORDER BY sort_number DESC";
                        $result = $dw3_conn->query($sql);
                        $row_number = 0;
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $row_number = $row_number + 1; 
                                $row_px = $row_number*120;
                                $data_date = "01/01/2" . str_pad($row_number, 3, "0", STR_PAD_LEFT);
                                if ($USER_LANG == "FR"){$name_trad = $row["name_fr"];}else{$name_trad = $row["name_en"];}    
                                echo "<a href='#0' data-date='".$data_date."'"; if($row_number == 1){ echo " class='selected' ";} echo "style='left: ".$row_px."px;'>".$name_trad."</a>";
                            }
                        }
                    ?>
                    </ol>
                    <span class="filling-line" aria-hidden="true" style="transform: scaleX(0.0675163);"></span>
                </div> <!-- .events -->
            </div> <!-- .events-wrapper -->
                
            <div class="cd-timeline-navigation">
                <a href="#0" class="prev inactive">Prev</a><div style="line-height:1;font-family:Roboto;position:absolute;top:39px;left:15px;font-size:22px;color:#f17144;">&lt;</div>
                <a href="#0" class="next">Next</a><div style="line-height:1;font-family:Roboto;position:absolute;top:39px;right:14px;font-size:22px;color:#f17144;">&gt;</div>
            </div> <!-- .cd-timeline-navigation -->
        </div> <!-- .timeline -->

        <div class="events-content">
            <ol>
            <?php
                $sql = "SELECT * FROM realisation ORDER BY sort_number DESC";
                $result = $dw3_conn->query($sql);
                $row_number = 0;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $row_number = $row_number + 1;
                        $data_date = "01/01/2" . str_pad($row_number, 3, "0", STR_PAD_LEFT);
                        if ($USER_LANG == "FR"){$description_trad = $row["description_fr"];}else{$description_trad = $row["description_en"];}
                        echo "<li "; if($row_number == 1){ echo " class='selected' ";} echo " data-date='".$data_date."'><p>".$description_trad."<br><img src='".$row["img_link"]."' style='height:200px;width:auto;max-width:100%;'>"; if ($row["href"]!=""){ echo "<br><a style='color:#bbb;font-size:20px;' href='".$row["href"]."' target='_blank'>".$row["href"]." <span style='font-size:15px;'>⏵</span></a>";} echo "</p></li>";
                    }
                }
            ?>
            </ol>
        </div> <!-- .events-content -->
    </section>