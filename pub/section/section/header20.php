<!-- Avec redimension et contacts 100px -> 70px  Sticky Flex -->
<?php if (!isset($TABINDEX)){$TABINDEX=0;} ?>
<div style='height:100px;'>
    <div id="dw3_head" style="position:fixed;top:0;left:0;border-top:<?php echo $CIE_COLOR8_3S; ?>px solid #<?php echo $CIE_COLOR8_3; ?>;border-bottom:<?php echo $CIE_COLOR8_4S; ?>px solid #<?php echo $CIE_COLOR8_4; ?>;max-height:100px;height:100px;">
        <div style='position:absolute;top:4px;left:0px;right:0px;display: flex;justify-content: center;'><div id='dw3_h3_tel1' style='<?php if ($CIE_TEL1 == "") { echo "display:none;"; } ?>transition: all 1s;' class='dw3_wide_view_menu'><span class='dw3_font' style='font-size:26px;color:#<?php echo $CIE_COLOR9; ?>;'>N</span> <a class='hovera' <?php if ($CIE_TEL1 != "") { $TABINDEX++; echo "tabindex='".$TABINDEX."'"; } ?> href='tel://<?php echo $CIE_TEL1; ?>' style='font-size:20px;color:#<?php echo $CIE_COLOR9; ?>;filter: invert(100%);font-family:Roboto;'><?php echo $CIE_TEL1; ?></a> </div> <div id='dw3_h3_eml1' style='<?php if ($CIE_EML1 == "") { echo "display:none;"; } ?>transition: all 1s;' class='dw3_wide_view_menu'><span class='dw3_font' style='font-size:26px;color:#<?php echo $CIE_COLOR9; ?>;'>q</span> <a class='hovera' <?php if ($CIE_EML1 != "") { $TABINDEX++; echo "tabindex='".$TABINDEX."'"; } ?> href='mailto://<?php echo $CIE_EML1; ?>' style='font-size:20x;color:#<?php echo $CIE_COLOR9; ?>;filter: invert(100%);font-family:Roboto;'><?php echo $CIE_EML1; ?></a> </div></div>
        <table style='font-family:var(--dw3_menu_font);border-spacing:0px;border-collapse: collapse;border:0;padding:0;'>
          <tr id='dw3_head_row' style='transition: all 1s;height:100px;max-height:100px;'>
            <td id='header3_img' onclick='dw3_menu_toggle();' style="vertical-align:top;text-align:left;cursor:pointer;color:#66c6dd;max-width:340px;font-weight:bold;transition: all 1s ease-in-out;">
                <img id="imgLOGO" src="/pub/img/<?php echo $CIE_LOGO3; ?>" style="padding:0px;vertical-align:top;height:100px;width:auto;transition: all 1s;" alt="Logo de l'entreprise pour le site web">
            </td>
                <?php
                $aftermath='';
                echo "<td width='*' style='padding-top:10px;'><div style='display: flex;justify-content: center;' class='dw3_wide_view_menu'>";
                //si sous-page voir si il y a dautres sous-pages sinon afficher les pages de la racine PAGE_ID=0
                if ($PAGE_ID != "0" && $PAGE_URL != "/"){
                    $sql = "SELECT * FROM index_head WHERE parent_id='".$PAGE_ID."' AND target='page' OR parent_id='".$PAGE_ID."' AND target='sub' OR parent_id='".$PAGE_ID."' AND target='button' OR parent_id = '".$PAGE_ID."' AND target='section' AND is_in_menu='true' ORDER BY menu_order ASC";
                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows == 0) {
                        $sql = "SELECT * FROM index_head WHERE parent_id=0 AND target='page' OR parent_id=0 AND target='sub' OR parent_id=0 AND target='button' OR parent_id = 0 AND target='section' ORDER BY menu_order ASC";
                        $result = $dw3_conn->query($sql);
                    } 
                } else {
                    $sql = "SELECT * FROM index_head WHERE parent_id=0 AND target='page' OR parent_id=0 AND target='sub' OR parent_id=0 AND target='button' OR parent_id = 0 AND target='section' ORDER BY menu_order ASC";
                    $result = $dw3_conn->query($sql);
                }
                $x_s = 0;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $TABINDEX++;
                        if ($USER_LANG == "FR"){$title_trad = $row["title"];}else{$title_trad = $row["title_en"];}
                        if ($row["target"] == "page" &&  $row["is_in_menu"] == "true"){
                            if (substr($row["url"],0,10)=="/pub/page/" || $row["url"] == "/" || $row["url"] == "/client/" || $row["url"] == ""){
                                if ($PAGE_ID == $row["id"] || $PAGE_ID == "0" && $row["url"] == "/" || $PAGE_ID == "" && $row["url"] == "/"){
                                    echo "<div style='padding:10px 20px;flex-direction:row;vertical-align:middle!important;text-align:center;'><a href='".$row["url"]."?PID=".$row["id"]."&P1=".$row["cat_list"]."' target='_self' style='color:#".$CIE_COLOR9.";text-decoration: underline;' arial-label='".$title_trad."' tabindex='".$TABINDEX."'>".$title_trad."</a></div>";
                                } else {
                                    echo "<div style='padding:10px 20px;flex-direction:row;vertical-align:middle!important;text-align:center;'><a href='".$row["url"]."?PID=".$row["id"]."&P1=".$row["cat_list"]."' target='_self' style='color:#".$CIE_COLOR9.";' arial-label='".$title_trad."' tabindex='".$TABINDEX."'>".$title_trad."</a></div>";
                                }
                            }else{
                                echo "<div style='padding:10px 20px;flex-direction:row;vertical-align:middle!important;text-align:center;'><a href='".$row["url"]."' target='_self' style='color:#".$CIE_COLOR9.";' arial-label='".$title_trad."' tabindex='".$TABINDEX."'>".$title_trad."</a></div>";
                            }
                        } else if ($row["target"] == "sub" &&  $row["is_in_menu"] == "true"){
                            echo "<div style='padding:10px 20px;flex-direction:row;vertical-align:middle!important;text-align:center;' onmouseover=\"dw3_sub_menu_open('dw3_sub".$row["id"]."',1000)\" onmouseout=\"dw3_sub_menu_close('dw3_sub".$row["id"]."',1000)\" onclick=\"dw3_sub_menu_toggle('dw3_sub".$row["id"]."',1000)\"><a onfocus=\"dw3_sub_menu_open('dw3_sub".$row["id"]."',1000)\" onblur=\"dw3_sub_menu_close('dw3_sub".$row["id"]."',1000)\" style='color:#".$CIE_COLOR9.";' class='no_underline' arial-label='".$title_trad."' tabindex='".$TABINDEX."'>".$title_trad." <span style='font-size:14px;'>&#11206;</span></a><br class='br_tiny'>";
                            //sub-menu
                            $sql2 = "SELECT * FROM index_head WHERE target='page' AND parent_id='".$row["id"] ."' ORDER BY menu_order ASC";
                            $result2 = $dw3_conn->query($sql2);
                            if ($result2->num_rows > 0) {
                                echo "<div id='dw3_sub".$row["id"] ."' class='dw3_sub_menu'>";
                                while($row2 = $result2->fetch_assoc()) {
                                    $TABINDEX++;
                                    if ($USER_LANG == "FR"){$title_trad = $row2["title"];}else{$title_trad = $row2["title_en"];}
                                    if (substr($row2["url"],0,10)=="/pub/page/"){
                                        echo "<button tabindex='".$TABINDEX."' onclick=\"window.open('".$row2["url"]."?PID=".$row2["id"]."&P1=".$row2["cat_list"]."','_self');\" style='white-space:normal;padding:10px;margin:1px 0px;width:97%;max-width:350px;display:inline-block;' onfocus=\"dw3_sub_menu_open('dw3_sub".$row["id"]."',1000)\" onblur=\"dw3_sub_menu_close('dw3_sub".$row["id"]."',1000)\">".$title_trad."</button><br class='br_tiny'>";
                                    }else{
                                        echo "<button tabindex='".$TABINDEX."' onclick=\"window.open('".$row2["url"]."','_self');\" style='white-space:normal;padding:10px;margin:1px 0px;width:97%;max-width:350px;display:inline-block;' onfocus=\"dw3_sub_menu_open('dw3_sub".$row["id"]."',1000)\" onblur=\"dw3_sub_menu_close('dw3_sub".$row["id"]."',1000)\">".$title_trad."</button><br class='br_tiny'>";
                                    }
                                }
                                echo "</div>";
                                $aftermath .= "\n if (document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth>152){document.getElementById('dw3_sub".$row["id"] ."').style.width = document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth+'px'; document.getElementById('dw3_sub".$row["id"] ."').style.marginLeft='-20px'; }else{ document.getElementById('dw3_sub".$row["id"] ."').style.width='152px'; document.getElementById('dw3_sub".$row["id"] ."').style.marginLeft='-'+((152-(document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth-40))/2).toString()+'px'; } ";                            }
                            echo "</div>";
                        } else if ($row["target"] == "section" &&  $row["is_in_menu"] == "true"){
                            //echo "<td class='dw3_wide_view_menu' style='min-width:100px;padding-top:5px;vertical-align:middle!important;text-align:center;' onclick=\"window.scroll({top: document.getElementById('dw3_section_".$x_s."').getBoundingClientRect().top + window.scrollY,behavior: 'smooth'});\">".$title_trad."</td>";
                            echo "<div style='padding:10px 20px;flex-direction:row;vertical-align:middle!important;text-align:center;'><a href='#dw3_section_".$x_s."' style='color:#".$CIE_COLOR9.";' arial-label='".$title_trad."' tabindex='".$TABINDEX."'>".$title_trad."</a></div>";
                        } else if ($row["target"] == "button" &&  $row["is_in_menu"] == "true"){	
                           // echo "<div style='padding:10px 20px;flex-direction:row;vertical-align:middle!important;text-align:center;'><button onclick=\"dw3_menu_toggle(); ".$row["url"]." \">  <div style='display:inline-block;vertical-align:middle;'>".$title_trad."</div> <span class=\"material-icons\" style=\"font-size:30px;color:".$row["icon_color"].";text-shadow:".$row["icon_textShadow"].";\">".$row["icon"]."</span></button></td>";
                        }
                        $x_s++;
                    }
                }
                echo "</div></td>";
                if ($INDEX_DSP_LANG=="true"){ $TABINDEX++; 
                    if ($USER_LANG == "FR"||$USER_LANG == ""){ ?>
                    <td width="30" tabindex='<?php echo $TABINDEX;?>' onclick="dw3_lang_set('EN');" style="padding-top:5px;vertical-align:middle!important;text-align:center;cursor:pointer;"> 
                        <div id="dw3_lang_span" style="display:inline-block;cursor:pointer;color:#<?php echo $CIE_COLOR9; ?>"><span class='dw3_font'>ě</span>EN</div>
                    </td>
                    <?php } else {
                    ?>
                    <td width="30" tabindex='<?php echo $TABINDEX;?>' onclick="dw3_lang_set('FR');" style="padding-top:5px;vertical-align:middle!important;text-align:center;cursor:pointer;"> 
                        <div id="dw3_lang_span" style="display:inline-block;cursor:pointer;color:#<?php echo $CIE_COLOR9; ?>"><span class='dw3_font'>ě</span>FR</div>
                    </td>
                    <?php
                    }
                }
                if ($INDEX_SEARCH=="true"){ $TABINDEX++;
                    ?>
                    <td width="10px" style="min-width:10px;max-width:10px;"> </td>
                    <td width="40" tabindex='<?php echo $TABINDEX;?>' onclick="dw3_search_open()" style="max-width:50px;overflow:hidden;vertical-align:middle;text-align:right;cursor:pointer;max-height:50px;height:50px;"> 
                        <span class='dw3_font' style='display:inline-block;text-shadow: 1px 1px #222;cursor:pointer;font-size:40px;'>X</span>
                    </td>
                    <?php }
                if ($INDEX_WISH=="true"){ $TABINDEX++;
                    ?>
                    <td width="10px" style="min-width:10px;max-width:10px;"> </td>
                    <td width="40" tabindex='<?php echo $TABINDEX;?>' onclick="dw3_wish_open()" style="max-width:50px;overflow:hidden;vertical-align:middle;text-align:center;cursor:pointer;max-height:50px;height:50px;"> 
                        <div id='dw3_wish_qty' style='position:absolute;display:inline-block;font-family:Arial;font-size:16px;color:#<?php echo $CIE_COLOR9; ?>;width:35px;font-weight:bold;padding:10px 0px 0px 2.5px;text-align:center;z-index:+1;'><?php echo $dw3_wish_count; ?></div>
                        <span class='dw3_font' style='display:inline-block;text-shadow: 1px 1px #222;cursor:pointer;font-size:40px;'>Q</span>
                    </td>
                    <?php }
                if ($INDEX_CART=="true"){$TABINDEX++;
            ?>
            <td width="10px" style="min-width:10px;max-width:10px;"> </td>
            <td width="40" tabindex='<?php echo $TABINDEX;?>' onclick="dw3_cart_open()" style="max-width:50px;overflow:hidden;vertical-align:middle;text-align:center;cursor:pointer;max-height:50px;height:50px;"> 
                <div id='dw3_cart_qty' style='position:absolute;display:inline-block;font-family:Arial;font-size:16px;color:#<?php echo $CIE_COLOR9; ?>;width:35px;font-weight:bold;padding:7px 0px 0px 4px;text-align:center;z-index:+1;'><?php echo $dw3_cart_count; ?></div>
                <span class='dw3_font' style='display:inline-block;text-shadow: 1px 1px #222;cursor:pointer;font-size:40px;'>x</span>
            </td>
            <?php } ?><td width="10"> </td>
            <td id='dw3_small_view_menu' onclick='dw3_menu_toggle();' style="padding:10px 0px 0px 10px;vertical-align:middle!important;text-align:right;cursor:pointer;">
                <div id='dw3_menu_bars'>
                    <div class="dw3_menu_bar1"></div>
                    <div class="dw3_menu_bar2"></div>
                    <div class="dw3_menu_bar3"></div>
                </div>
            </td>
            <td width="10px" style="min-width:10px;max-width:10px;"> </td>
        </tr></table>
    </div>
</div>
    <?php echo "\n<script type='text/javascript'>
        function addLoadEvent(func) {
            var oldonload = window.onload;
            if (typeof window.onload != 'function') {
            window.onload = func;
            } else {
            window.onload = function() {
                if (oldonload) {
                oldonload();
                }
                func();
            }
            }
        }
        
        function setSubMenusPos(){".$aftermath."\n} 
        addLoadEvent(setSubMenusPos());
    </script>";?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_menu.php'; ?>