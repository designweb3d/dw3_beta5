<!-- Minimal 70px Sticky -->
 <?php if (!isset($TABINDEX)){$TABINDEX=0;} ?>
<div style='height:70px;'>
    <div id="dw3_head" style="position:fixed;top:0;left:0;border-top:<?php echo $CIE_COLOR8_3S; ?>px solid #<?php echo $CIE_COLOR8_3; ?>;border-bottom:<?php echo $CIE_COLOR8_4S; ?>px solid #<?php echo $CIE_COLOR8_4; ?>;">
        <table style='font-family:var(--dw3_menu_font);border-spacing:0px;border-collapse: collapse;border:0;padding:0;'>
          <tr style='height:70px;max-height:70px;border:0;padding:0;margin:0;'>
          <?php 
                if (trim($CIE_NOM_HTML)==""){
            ?>  <td width="10"> </td>  
                <td onclick='dw3_menu_toggle();' style="width:auto;border:0;padding:0;margin:0;vertical-align:middle;text-align:left;cursor:pointer;color:var(--dw3_menu_color);font-weight:bold;">
                    <img id="imgLOGO" src="/pub/img/<?php echo $CIE_LOGO3; ?>" style="max-width:100%;padding:0px;vertical-align:middle;height:70px;width:auto;" alt="Logo de l'entreprise pour le site web">
                </td>
            <?php } else if ($CIE_LOGO3 != ""){ ?>
                <td onclick='dw3_menu_toggle();' style="min-width:90px;border:0;padding:0;margin:0;vertical-align:middle;text-align:center;cursor:pointer;color:var(--dw3_menu_color);font-weight:bold;">
                    <img id="imgLOGO" src="/pub/img/<?php echo $CIE_LOGO3; ?>" style="padding:0px;vertical-align:middle;height:70px;width:auto;" alt="Logo de l'entreprise pour le site web">
                </td><td><?php echo $CIE_NOM_HTML; ?>
                </td>
            <?php 
                } else { ?>
                <td onclick='dw3_menu_toggle();' style="text-align:left;min-width:90px;border:0;padding:0px 0px 0px 10px;margin:0;vertical-align:middle;text-align:center;cursor:pointer;color:var(--dw3_menu_color);font-weight:bold;">
                    <?php echo $CIE_NOM_HTML; ?>
                </td>
            <?php 
                } 
                $aftermath='';
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
                                if (substr($row["url"],0,10)=="/pub/page/" || $row["url"] == "/" || $row["url"] == ""){
                                    if ($PAGE_ID == $row["id"] || $PAGE_ID == "0" && $row["url"] == "/" || $PAGE_ID == "" && $row["url"] == "/"){
                                        echo "<td class='dw3_wide_view_menu' style='min-width:100px;padding-top:5px;vertical-align:middle!important;text-align:center;'><a href='".$row["url"]."?PID=".$row["id"]."&P1=".$row["cat_list"]."' target='_self' style='color:#".$CIE_COLOR9.";text-decoration: underline;' arial-label='".$title_trad."' tabindex='".$TABINDEX."'>".$title_trad."</a></td>";
                                    } else {
                                        echo "<td class='dw3_wide_view_menu' style='min-width:100px;padding-top:5px;vertical-align:middle!important;text-align:center;'><a href='".$row["url"]."?PID=".$row["id"]."&P1=".$row["cat_list"]."' target='_self' style='color:#".$CIE_COLOR9.";' arial-label='".$title_trad."' tabindex='".$TABINDEX."'>".$title_trad."</a></td>";
                                    }
                                }else{
                                    echo "<td class='dw3_wide_view_menu' style='min-width:100px;padding-top:5px;vertical-align:middle!important;text-align:center;'><a href='".$row["url"]."' target='_self' style='color:#".$CIE_COLOR9.";' arial-label='".$title_trad."' tabindex='".$TABINDEX."'>".$title_trad."</a></td>";
                                }
                            } else if ($row["target"] == "sub" &&  $row["is_in_menu"] == "true"){
                                echo "<td class='dw3_wide_view_menu' style='min-width:100px;vertical-align:middle!important;text-align:center;' onmouseover=\"dw3_sub_menu_open('dw3_sub".$row["id"]."',1000)\" onmouseout=\"dw3_sub_menu_close('dw3_sub".$row["id"]."',1000)\" onclick=\"dw3_sub_menu_toggle('dw3_sub".$row["id"]."',1000)\"><a style='color:#".$CIE_COLOR9.";' class='no_underline' arial-label='".$title_trad."' tabindex='".$TABINDEX."'>".$title_trad." <span style='font-size:14px;'>&#11206;</span></a><br class='br_small'>";
                                //sub-menu
                                $sql2 = "SELECT * FROM index_head WHERE target='page' AND parent_id='".$row["id"] ."' ORDER BY menu_order ASC";
                                $result2 = $dw3_conn->query($sql2);
                                if ($result2->num_rows > 0) {
                                    echo "<div id='dw3_sub".$row["id"] ."' class='dw3_sub_menu'>";
                                    while($row2 = $result2->fetch_assoc()) {
                                        if ($USER_LANG == "FR"){$title_trad = $row2["title"];}else{$title_trad = $row2["title_en"];}
                                        if (substr($row2["url"],0,10)=="/pub/page/"){
                                            echo "<button onclick=\"window.open('".$row2["url"]."?PID=".$row2["id"]."&P1=".$row2["cat_list"]."','_self');\" style='white-space: normal;padding:8px 5px;margin:1px;width:97%;max-width:350px;display:inline-block;'>".$title_trad."</button><br class='br_tiny'>";
                                        }else{
                                            echo "<button onclick=\"window.open('".$row2["url"]."','_self');\" style='white-space:normal;padding:8px 5px;width:97%;max-width:350px;margin:1px;display:inline-block;'>".$title_trad."</button><br class='br_tiny'>";
                                        }
                                    }
                                    echo "</div>";
                                    //$aftermath .= "\n if (document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth>152) {document.getElementById('dw3_sub".$row["id"] ."').style.width = document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth+'px';document.getElementById('dw3_sub".$row["id"] ."').style.marginLeft='-6px';}else{document.getElementById('dw3_sub".$row["id"] ."').style.width='152px';document.getElementById('dw3_sub".$row["id"] ."').style.marginLeft='-'+(152-(document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth)+10).toString()+'px';} "; //(document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth/2)
                                    $aftermath .= "\n if (document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth>152) {document.getElementById('dw3_sub".$row["id"] ."').style.width = document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth+'px';document.getElementById('dw3_sub".$row["id"] ."').style.marginLeft='-6px';}else{document.getElementById('dw3_sub".$row["id"] ."').style.width='152px';document.getElementById('dw3_sub".$row["id"] ."').style.marginLeft='-'+((170-(document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth))/2).toString()+'px';} "; //(document.getElementById('dw3_sub".$row["id"] ."').parentElement.offsetWidth/2)
                                }
                                echo "</td>";
                            } else if ($row["target"] == "section" &&  $row["is_in_menu"] == "true"){
                                //echo "<td class='dw3_wide_view_menu' style='min-width:100px;padding-top:5px;vertical-align:middle!important;text-align:center;' onclick=\"window.scroll({top: document.getElementById('dw3_section_".$x_s."').getBoundingClientRect().top + window.scrollY,behavior: 'smooth'});\">".$title_trad."</td>";
                                echo "<td class='dw3_wide_view_menu' style='min-width:100px;padding-top:5px;vertical-align:middle!important;text-align:center;'><a href='#dw3_section_".$x_s."' style='color:#".$CIE_COLOR9.";' arial-label='".$title_trad."' tabindex='".$TABINDEX."'>".$title_trad."</a></td>";
                            } else if ($row["target"] == "button" &&  $row["is_in_menu"] == "true"){	
                               // echo "<td class='dw3_wide_view_menu' style='min-width:100px;padding-top:5px;vertical-align:middle!important;text-align:center;'><button onclick=\"dw3_menu_toggle(); ".$row["url"]." \">  <div style='display:inline-block;vertical-align:middle;'>".$title_trad."</div> <span class=\"material-icons\" style=\"font-size:30px;color:".$row["icon_color"].";text-shadow:".$row["icon_textShadow"].";\">".$row["icon"]."</span></button></td>";
                            }
                            $x_s++;
                        }
                    }

            if ($INDEX_DSP_LANG=="true"){ if ($USER_LANG == "FR"||$USER_LANG == ""){ ?>
                <td width="30" onclick="dw3_lang_set('EN');" style="vertical-align:middle!important;text-align:center;cursor:pointer;"> 
                    <div id="dw3_lang_span" style="display:inline-block;cursor:pointer;color:#<?php echo $CIE_COLOR9; ?>"><span class='dw3_font'>ě</span>EN</div>
                </td>
                <?php } else{
                ?>
                <td width="30" onclick="dw3_lang_set('FR');" style="vertical-align:middle!important;text-align:center;cursor:pointer;"> 
                    <div id="dw3_lang_span" style="display:inline-block;cursor:pointer;color:#<?php echo $CIE_COLOR9; ?>"><span class='dw3_font'>ě</span>FR</div>
                </td>
                <?php
            }}
            if ($INDEX_SEARCH=="true"){ $TABINDEX++;
                ?>
                <td width="10px" style="min-width:10px;max-width:10px;"> </td>
                <td width="40" tabindex='<?php echo $TABINDEX;?>' onclick="dw3_search_open()" style="max-width:50px;overflow:hidden;vertical-align:middle;text-align:right;cursor:pointer;max-height:50px;height:50px;"> 
                    <span class='dw3_font' style='display:inline-block;text-shadow: 1px 1px #222;cursor:pointer;font-size:40px;'>X</span>
                </td>
                <?php }
            if ($INDEX_WISH=="true"){
                ?>
                <td width="10px" style="min-width:10px;max-width:10px;"> </td>
                <td width="40" tabindex='<?php echo $TABINDEX;?>' onclick="dw3_wish_open()" style="max-width:50px;overflow:hidden;vertical-align:middle;text-align:center;cursor:pointer;max-height:50px;height:50px;"> 
                    <div id='dw3_wish_qty' style='position:absolute;display:inline-block;font-family:Arial;font-size:16px;color:#<?php echo $CIE_COLOR8; ?>;width:35px;font-weight:bold;padding:12px 0px 0px 3px;text-align:center;z-index:+1;'><?php echo $dw3_wish_count; ?></div>
                    <span class='dw3_font' style='display:inline-block;text-shadow: 1px 1px #222;cursor:pointer;font-size:40px;'>Q</span>
                </td>
                <?php }
            if ($INDEX_CART=="true"){
            ?>
            <td width="10px" style="min-width:10px;max-width:10px;"> </td>
            <td width="40" tabindex='<?php echo $TABINDEX;?>' onclick="dw3_cart_open()" style="max-width:50px;overflow:hidden;vertical-align:middle;text-align:center;cursor:pointer;max-height:50px;height:50px;"> 
                <div id='dw3_cart_qty' style='position:absolute;display:inline-block;font-family:Arial;font-size:16px;color:#<?php echo $CIE_COLOR8; ?>;width:35px;font-weight:bold;padding:7px 0px 0px 4px;text-align:center;z-index:+1;'><?php echo $dw3_cart_count; ?></div>
                <span class='dw3_font' style='display:inline-block;text-shadow: 1px 1px #222;cursor:pointer;font-size:40px;'>x</span>
            </td>
            <?php }  ?>
            <td width="10px" style="min-width:10px;max-width:10px;"> </td>
            <td id='dw3_small_view_menu' onclick='dw3_menu_toggle();' style="padding:10px 10px 0px 0px;vertical-align:middle!important;text-align:right;cursor:pointer;">
                <div id='dw3_menu_bars'>
                    <div class="dw3_menu_bar1"></div>
                    <div class="dw3_menu_bar2"></div>
                    <div class="dw3_menu_bar3"></div>
                </div>
            </td>
            <td width="10"> 
            </td>
        </tr></table>
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
        function setSubMenusPos(){".$aftermath."\n} addLoadEvent(setSubMenusPos());</script>";?>
    </div>
</div>
<?php  require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_menu.php'; ?>