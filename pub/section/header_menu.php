    <div id='dw3_menu'>
        <?php
            if ($PAGE_ID != "0" && $PAGE_URL != "/"){
                $sql = "SELECT * FROM index_head WHERE parent_id='".$PAGE_ID."' AND target='page' AND is_in_menu='true' OR parent_id='".$PAGE_ID."' AND target='sub' AND is_in_menu='true' OR parent_id='".$PAGE_ID."' AND target='button'  AND is_in_menu='true' OR parent_id = '".$PAGE_ID."' AND target='section' AND is_in_menu='true' ORDER BY menu_order ASC";
                $result = $dw3_conn->query($sql);
                if ($result->num_rows == 0) {
                    $sql = "SELECT * FROM index_head WHERE parent_id=0 AND target='page' AND is_in_menu='true' OR parent_id=0 AND target='sub'  AND is_in_menu='true' OR parent_id=0 AND target='button'  AND is_in_menu='true' OR parent_id = 0 AND target='section'  AND is_in_menu='true' ORDER BY menu_order ASC";
                    $result = $dw3_conn->query($sql);
                } 
            } else {
                $sql = "SELECT * FROM index_head WHERE parent_id=0 AND target='page' AND is_in_menu='true' OR parent_id=0 AND target='sub' AND is_in_menu='true' OR parent_id=0 AND target='button' AND is_in_menu='true' OR parent_id = 0 AND target='section' AND is_in_menu='true' ORDER BY menu_order ASC";
                $result = $dw3_conn->query($sql);
            }
            $x_s = 0;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $TABINDEX++;
                    if ($USER_LANG == "FR"){$title_trad = $row["title"];}else{$title_trad = $row["title_en"];}
                    if ($row["target"] == "page" &&  $row["is_in_menu"] == "true"){
                        if (substr($row["url"],0,7)=="/client"){
                            echo "<button tabindex='-1' onclick=\"dw3_menu_toggle();window.open('".$row["url"]."','_self');\" style='white-space: normal;text-align:left;'> <div style='display:inline-block;vertical-align:middle;font-family:var(--dw3_menu_font);'>".$title_trad."</div> <span id='dw3_menu_avatar' style='float:right;margin-left:5px;width:30px;display:inline-block;vertical-align:middle;'><span class=\"dw3_font\" style=\"width:30px;text-align:center;float:right;font-size:1.5em;color:".$row["icon_color"].";text-shadow:".$row["icon_textShadow"].";\">".$row["icon"]."</span> </span></button>";
                        }else if (substr($row["url"],0,10)=="/pub/page/"){
                            echo "<button tabindex='-1' onclick=\"dw3_menu_toggle();window.open('".$row["url"]."?PID=".$row["id"]."&P1=".$row["cat_list"]."','_self');\" style='white-space: normal;text-align:left;'> <div style='display:inline-block;vertical-align:middle;font-family:var(--dw3_menu_font);'>".$title_trad."</div> <span class=\"dw3_font\" style=\"width:30px;text-align:center;float:right;margin-left:5px;vertical-align:middle;font-size:1.5em;color:".$row["icon_color"].";text-shadow:".$row["icon_textShadow"].";\">".$row["icon"]."</span></button>";
                        }else{
                            echo "<button tabindex='-1' onclick=\"dw3_menu_toggle();window.open('".$row["url"]."','_self');\" style='white-space: normal;text-align:left;'> <div style='display:inline-block;vertical-align:middle;font-family:var(--dw3_menu_font);'>".$title_trad."</div> <span class=\"dw3_font\" style=\"width:30px;text-align:center;float:right;margin-left:5px;vertical-align:middle;font-size:1.5em;color:".$row["icon_color"].";text-shadow:".$row["icon_textShadow"].";\">".$row["icon"]."</span></button>";
                        }
                    } else if ($row["target"] == "section" &&  $row["is_in_menu"] == "true"){	
                        echo "      <button tabindex='-1' onclick=\"dw3_menu_toggle();window.scroll({top: document.getElementById('dw3_section_".$x_s."').getBoundingClientRect().top + window.scrollY,behavior: 'smooth'});\" style='white-space: normal;text-align:left;'>  <div style='display:inline-block;vertical-align:middle;font-family:var(--dw3_menu_font);'>".$title_trad."</div> <span class=\"dw3_font\" style=\"width:30px;text-align:center;float:right;vertical-align:middle;font-size:1.5em;color:".$row["icon_color"].";text-shadow:".$row["icon_textShadow"].";\">".$row["icon"]."</span></button>";
                    } else if ($row["target"] == "button" &&  $row["is_in_menu"] == "true"){	
                        echo "      <button tabindex='-1' onclick=\"dw3_menu_toggle(); ".$row["url"]." \" style='white-space: normal;text-align:left;'>  <div style='display:inline-block;vertical-align:middle;font-family:var(--dw3_menu_font);'>".$title_trad."</div> <span class=\"dw3_font\" style=\"width:30px;text-align:center;float:right;margin-left:5px;vertical-align:middle;font-size:1.5em;color:".$row["icon_color"].";text-shadow:".$row["icon_textShadow"].";\">".$row["icon"]."</span></button>";
                    } else if ($row["target"] == "sub"){
                        echo "      <button tabindex='-1' onclick=\"dw3_sub_toggle('dw3_sub2".$row["id"]."','1000','dw3_sub_menu_tick".$row["id"]."')\" class='no-effect' style='white-space: normal;text-align:left;'> <div style='vertical-align:middle!important;text-align:left;font-family:var(--dw3_menu_font);'>".$title_trad."</div> <span id='dw3_sub_menu_tick".$row["id"]."' style='width:30px;float:right;padding:0px;font-family:Verdana;text-align:center;'>▼</span></button>";	
                        $sql2 = "SELECT * FROM index_head WHERE target='page' AND parent_id='".$row["id"] ."' ORDER BY menu_order ASC";
                        $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            echo "<div id='dw3_sub2".$row["id"] ."' class='dw3_sub_menu2'>";
                            while($row2 = $result2->fetch_assoc()) {
                                if ($USER_LANG == "FR"){$title_trad = $row2["title"];}else{$title_trad = $row2["title_en"];}
                                if (substr($row2["url"],0,10)=="/pub/page/"){
                                    echo "<button tabindex='-1' onclick=\"dw3_menu_toggle();window.open('".$row2["url"]."?PID=".$row2["id"]."&P1=".$row2["cat_list"]."','_self');\" style='background:var(--dw3_menu_background2);white-space: normal;text-align:left;'> <div style='overlow:hidden;display:inline-block;vertical-align:middle;text-align:left;font-family:var(--dw3_menu_font);'> ".$title_trad."</div> <span class=\"dw3_font\" style=\"width:30px;text-align:center;float:right;vertical-align:middle;margin-left:5px;font-size:1.5em;color:".$row2["icon_color"].";text-shadow:".$row2["icon_textShadow"].";\">".$row2["icon"]."</span></button>";
                                } else if (strtolower(substr($row2["url"],0,4))=="http"){
                                    echo "<button tabindex='-1' onclick=\"dw3_menu_toggle();window.open('".$row2["url"]."','_self');\" style='background:var(--dw3_menu_background2);white-space: normal;text-align:left;'> <div style='overlow:hidden;display:inline-block;vertical-align:middle;text-align:left;font-family:var(--dw3_menu_font);'> ".$title_trad."</div> <img alt='Icone de ".$row2["url"]."' style='width:30px;text-align:center;float:right;vertical-align:middle;height:2vw;width:2vw;margin-left:5px;' src='".$row2["url"]."/favicon.ico' onerror=\"this.src='https://s2.googleusercontent.com/s2/favicons?domain=". trim($row2["url"]). "'\"></button>";
                                } else {
                                    echo "<button tabindex='-1' onclick=\"dw3_menu_toggle();window.open('".$row2["url"]."','_self');\" style='background:var(--dw3_menu_background2);white-space: normal;text-align:left;'> <div style='overlow:hidden;display:inline-block;vertical-align:middle;text-align:left;font-family:var(--dw3_menu_font);'> ".$title_trad."</div> <span class=\"dw3_font\" style=\"width:30px;text-align:center;float:right;vertical-align:middle;margin-left:5px;font-size:1.5em;color:".$row2["icon_color"].";text-shadow:".$row2["icon_textShadow"].";\">".$row2["icon"]."</span></button>";
                                }
                            }
                            echo "</div>";
                        }}
                    $x_s++;
                }
            }
            if ($INDEX_HEADER == "/pub/section/header6.php"){
                if ($INDEX_DSP_LANG=="true"){
                    $TABINDEX++;
                    if ($USER_LANG == "FR"||$USER_LANG == ""){
                        echo "<button id='dw3_lang_span' onclick=\"dw3_lang_set('EN');\" tabindex='".$TABINDEX."' style='width:50px;height:50px;' class='no-effect'> EN </button>";
                    } else {
                        echo "<button id='dw3_lang_span' onclick=\"dw3_lang_set('FR');\" tabindex='".$TABINDEX."' style='width:50px;height:50px;' class='no-effect'> FR </button>";
                    }
                }
                if ($INDEX_WISH=="true"){
                    $TABINDEX++;
                    echo "<button onclick='dw3_wish_open();' tabindex='".$TABINDEX."' style='width:auto;' class='no-effect'>";
                    echo "<div id='dw3_wish2_qty' style='position:absolute;display:inline-block;font-family:Arial;font-size:14px;color:#". $CIE_COLOR8.";width:35px;font-weight:bold;text-shadow: -1px 1px 3px #fff;padding:5px 0px 0px 0px;text-align:center;z-index:+1;'>". $dw3_wish_count."</div>
                                <span class='dw3_font' style='display:inline-block;text-shadow: 1px 1px #222;cursor:pointer;font-size:40px;color:#". $CIE_COLOR9.";margin:0px 0px 0px 0px;'>Q</span>";
                    echo "</button>";
                }
                if ($INDEX_CART=="true"){
                    $TABINDEX++;
                    echo "<button onclick='dw3_cart_open();' tabindex='".$TABINDEX."' style='width:auto;' class='no-effect'>";
                    echo "<div id='dw3_cart2_qty' style='position:absolute;display:inline-block;font-family:Arial;font-size:14px;color:#". $CIE_COLOR8.";width:35px;font-weight:bold;text-shadow: -1px 1px 3px #fff;padding:0px 0px 0px 0px;text-align:center;z-index:+1;'>". $dw3_cart_count."</div>
                                <span class='dw3_font' style='display:inline-block;text-shadow: 1px 1px #222;cursor:pointer;font-size:40px;color:#". $CIE_COLOR9.";margin:0px 0px 0px 0px;'>x</span>";
                    echo "</button>";
                }
            }
            //$TABINDEX++;
            //echo "<button class='no-effect' tabindex='-1' onclick='dw3_menu_toggle();' style='padding:3px;'><span class='dw3_font' style='font-size:20px;float:inherit;color:".$CIE_COLOR5.";text-shadow:".$CIE_COLOR6.";'>close</span></button>";
        ?>  
    </div>
</header>
<main>