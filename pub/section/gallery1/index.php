<div style="margin:<?php echo $SECTION_MARGIN; ?>;padding:0px;display:inline-block;text-align:left;height:auto;line-height:1.5em;background-color:<?php echo $SECTION_BG; ?>;border-radius:<?php echo $SECTION_RADIUS; ?>;max-width:<?php echo $SECTION_MAXW; ?>;overflow:hidden;box-shadow: <?php echo $SECTION_SHADOW; ?>;">
    <?php 
        if ($SECTION_TITLE_DSP!="none" && $SECTION_TITLE_DSP!=""){
            echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;margin-top:-15px;'>".$SECTION_TITLE."</h2>";
            
        }
        echo $SECTION_HTML_FR . "<div style='width:100%;overflow-x:auto;'><table style='margin:0px;padding:0px;white-space:nowrap;border-collapse: collapse;'><tr>";
        $dw3_sql = "SELECT * FROM slideshow WHERE index_id='".$SECTION_ID."' ORDER BY id ASC";
        $dw3_result = $dw3_conn->query($dw3_sql);
            if ($dw3_result->num_rows > 0) {
                while($row = $dw3_result->fetch_assoc()) {
                    if ($row["media_type"]=="video"){
                        ?><td><video style='width:320px;height:240px;'><source src='<?php echo $row["media_link"]; ?>'></video></td><?php                                              
                    } else if ($row["media_type"]=="image"){
                        ?><td><img style='width:auto;height:150px;' src='<?php echo $row["media_link"]; ?>'></td><?php                        
                    }
                }
            }
        echo "</tr></table></div>";
    ?>
</div>