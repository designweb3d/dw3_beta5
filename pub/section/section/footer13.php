</main>
<!-- footer pour godaddy/yaaka lien site seal  -->
<footer>
    <?php if (!isset($dw3_conn)){header('Location: https://'.$_SERVER["SERVER_NAME"].'/');exit;}?>
        <div class='dw3_page_foot'>
        <div style="margin:0px;padding-top:5px;padding-right:20px;z-index:+1;width:100%;font-size:0.8em;display:inline-block;text-align:right;">
        <?php 
            if (trim($INDEX_FACEBOOK) != "" || trim($INDEX_TWITTER) != "" || trim($INDEX_INSTAGRAM) != "" || trim($INDEX_LINKEDIN) != "" || trim($INDEX_TIKTOK) != "" || trim($INDEX_YOUTUBE) != "" || trim($INDEX_PINTEREST) != "" || trim($INDEX_SNAPCHAT) != ""){
                if($USER_LANG == "FR"){echo "Suivez-nous sur: ";}else{echo "Follow us on: ";}
                if (trim($INDEX_SNAPCHAT) != ""){
                    echo "<a rel='noopener' href='" . $INDEX_SNAPCHAT . "' target='_blank' aria-label='SnapChat'><img alt='Logo de SnapChat' src='/pub/img/dw3/snapchat.png' style='height:2vw;min-height:40px;width:auto;margin:5px;'></a>";
                }
                if (trim($INDEX_FACEBOOK) != ""){
                    echo "<a rel='noopener' href='" . $INDEX_FACEBOOK . "' target='_blank' aria-label='Facebook'><img alt='Logo de Facebook' src='/pub/img/dw3/facebook.png' style='height:2vw;min-height:40px;width:auto;margin:5px;'></a>";
                }
                if (trim($INDEX_TWITTER) != ""){
                    echo "<a rel='noopener' href='" . $INDEX_TWITTER . "' target='_blank' aria-label='Twitter'><img alt='Logo de Twitter' src='/pub/img/dw3/twitter.png' style='height:2vw;min-height:40px;width:auto;margin:5px;'></a>";
                }
                if (trim($INDEX_INSTAGRAM) != ""){
                    echo "<a rel='noopener' href='" . $INDEX_INSTAGRAM . "' target='_blank' aria-label='Instagram'><img alt='Logo de Instagram' src='/pub/img/dw3/instagram.png' style='height:2vw;min-height:40px;width:auto;margin:5px;'></a>";
                }
                if (trim($INDEX_LINKEDIN) != ""){
                    echo "<a rel='noopener' href='" . $INDEX_LINKEDIN . "' target='_blank' aria-label='LinkedIn'><img alt='Logo de Linkedin' src='/pub/img/dw3/linkedin.png' style='height:2vw;min-height:40px;width:auto;margin:5px;'></a>";
                }
                if (trim($INDEX_TIKTOK) != ""){
                    echo "<a rel='noopener' href='" . $INDEX_TIKTOK . "' target='_blank' aria-label='TikTok'><img alt='Logo de Tiktok' src='/pub/img/dw3/tiktok.png' style='height:2vw;min-height:40px;width:auto;margin:5px;'></a>";
                }
                if (trim($INDEX_YOUTUBE) != ""){
                    echo "<a rel='noopener' href='" . $INDEX_YOUTUBE . "' target='_blank' aria-label='YouTube'><img alt='Logo de Youtube' src='/pub/img/dw3/youtube.png' style='height:2vw;min-height:40px;width:auto;margin:5px;'></a>";
                }
                if (trim($INDEX_PINTEREST) != ""){
                    echo "<a rel='noopener' href='" . $INDEX_PINTEREST . "' target='_blank' aria-label='Pinterest'><img alt='Logo de Pinterest' src='/pub/img/dw3/pinterest.png' style='height:2vw;min-height:40px;width:auto;margin:5px;'></a>";
                }
            }
        ?>
        </div>
        <hr style='background: -webkit-gradient(linear, 0 0, 100% 0, from(transparent), to(transparent), color-stop(50%, #<?php echo $CIE_COLOR7; ?>));'>
        <?php 
                if ($CIE_LOGO5 != ""){
                    if ($CIE_LOGO5 == "1"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/ecoresponsable/?aff=3153&gbid=1fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=610, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-1-fr.svg' width='130' alt='Sceau hébergement écoresponsable' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/green-powered/?aff=3153&gbid=1en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=538, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-1.svg' width='130' alt='Green Hosting Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "2"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/ecoresponsable/?aff=3153&gbid=2fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=610, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-2-fr.svg' width='88' alt='Sceau hébergement écoresponsable' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/green-powered/?aff=3153&gbid=2en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=538, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-2.svg' width='88' alt='Green Hosting Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "3"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/ecoresponsable/?aff=3153&gbid=3fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=610, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-3-fr.svg' width='88' alt='Sceau hébergement écoresponsable' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/green-powered/?aff=3153&gbid=3en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=538, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-3.svg' width='88' alt='Green Hosting Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "4"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/ecoresponsable/?aff=3153&gbid=4fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=610, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-4-fr.svg' width='130' alt='Sceau hébergement écoresponsable' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/green-powered/?aff=3153&gbid=4en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=538, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-4.svg' width='130' alt='Green Hosting Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "5"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/ecoresponsable/?aff=3153&gbid=5fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=610, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-5-fr.svg' width='130' alt='Sceau hébergement écoresponsable' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/green-powered/?aff=3153&gbid=5en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=538, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-5.svg' width='130' alt='Green Hosting Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "6"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/ecoresponsable/?aff=3153&gbid=6fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=610, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-6-fr.svg' width='130' alt='Sceau hébergement écoresponsable' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/green-powered/?aff=3153&gbid=6en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=538, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-6.svg' width='130' alt='Green Hosting Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "7"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/ecoresponsable/?aff=3153&gbid=7fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=610, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-7-fr.svg' width='150' alt='Sceau hébergement écoresponsable' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/green-powered/?aff=3153&gbid=7en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=538, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-7.svg' width='150' alt='Green Hosting Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "8"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/ecoresponsable/?aff=3153&gbid=8fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=610, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-8-fr.svg' width='180' alt='Sceau hébergement écoresponsable' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/green-powered/?aff=3153&gbid=8en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=538, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/green-badge-8.svg' width='180' alt='Green Hosting Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "10"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/heberge-au-canada/?aff=3153&gbid=1fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=740, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/proudly-canadian-badge-fr.svg' width='130' alt='Badge canadien' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/hosted-in-canada/?aff=3153&gbid=1en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=695, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/proudly-canadian-badge.svg' width='130' alt='Canadian Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "11"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/heberge-au-canada/?aff=3153&gbid=2fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=740, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/hosted-in-canada-badge-fr.svg' width='110' alt='Badge canadien' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/hosted-in-canada/?aff=3153&gbid=2en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=695, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/hosted-in-canada-badge.svg' width='110' alt='Canadian Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "12"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/heberge-au-canada/?aff=3153&gbid=3fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=740, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/proudly-canadian-badge-2-fr.svg' width='150' alt='Badge canadien' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/hosted-in-canada/?aff=3153&gbid=3en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=695, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/proudly-canadian-badge-2.svg' width='150' alt='Canadian Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "13"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/heberge-au-canada/?aff=3153&gbid=4fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=740, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/proudly-canadian-badge-3-fr.svg' width='175' alt='Badge canadien' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/hosted-in-canada/?aff=3153&gbid=4en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=695, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/proudly-canadian-badge-3.svg' width='175' alt='Canadian Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "14"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/heberge-au-canada/?aff=3153&gbid=6fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=740, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/hosted-in-canada-badge-2-fr.svg' width='160' alt='Badge canadien' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/hosted-in-canada/?aff=3153&gbid=6en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=695, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/hosted-in-canada-badge-2.svg' width='160' alt='Canadian Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "15"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/heberge-au-canada/?aff=3153&gbid=7fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=740, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/proudly-canadian-badge-4-fr.svg' width='132' alt='Badge canadien' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/hosted-in-canada/?aff=3153&gbid=7en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=695, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/proudly-canadian-badge-4.svg' width='132' alt='Canadian Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "16"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/heberge-au-canada/?aff=3153&gbid=8fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=740, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/hosted-in-canada-badge-3-fr.svg' width='110' alt='Badge canadien' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/hosted-in-canada/?aff=3153&gbid=8en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=695, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/hosted-in-canada-badge-3.svg' width='110' alt='Canadian Badge' /></a>";
                        }
                    } else if ($CIE_LOGO5 == "17"){
                        if($USER_LANG == "FR"){ 
                            echo "<a href='https://whc.ca/heberge-au-canada/?aff=3153&gbid=9fr' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=740, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/proudly-canadian-fierement-canadien-badge.svg' width='145' alt='Badge canadien' /></a>";
                        } else {
                            echo "<a href='https://whc.ca/hosted-in-canada/?aff=3153&gbid=9en' onclick=\"window.open(this.href, 'popupWindow', 'width=450, height=695, status=no, scrollbars=no, menubar=no'); return false;\"><img src='https://s.whc.ca/badges/proudly-canadian-fierement-canadien-badge.svg' width='145' alt='Canadian Badge' /></a>";
                        }    
                    } else {
                        echo "<img src='/pub/img/".  $CIE_LOGO5 . "' width='130'><br>";
                    }
                }
        ?>
        <div style="margin-bottom:20px;">
            <?php 
            $dw3_sql = "SELECT * FROM index_head WHERE target='page' AND is_in_menu='true' ORDER BY parent_id ASC, menu_order ASC";
            $dw3_result = $dw3_conn->query($dw3_sql);
                if ($dw3_result->num_rows > 0) {
                    while($row = $dw3_result->fetch_assoc()) {
                        if ($row["is_in_menu"] == "true"){
                            if ($row["target"] == "page"){
                                if($USER_LANG == "FR"){
                                    echo "<div style='display:inline-block;padding:10px 15px;font-size:20px;'><a href='".$row["url"]."?PID=".$row["id"]."&P1=".$row["cat_list"]."' style='color:#".$CIE_COLOR7.";font-weight:bold; text-shadow: 1px 1px 2px #222;text-align:center;'>".$row["title"]."</a></div>";
                                }else{
                                    echo "<div style='display:inline-block;padding:10px 15px;font-size:20px;'><a href='".$row["url"]."?PID=".$row["id"]."&P1=".$row["cat_list"]."' style='color:#".$CIE_COLOR7.";font-weight:bold; text-shadow: 1px 1px 2px #222;text-align:center;'>".$row["title_en"]."</a></div>";
                                }
                            }
                        }
                    }
                }
            ?>
        </div>
        <?php 
        if (trim($CIE_STRIPE_KEY) != "" || trim($MAG_INTERAC??'false') != "false"){
            echo "<div style='width:100%;display:inline-block;text-align:left;'>";
            echo "<img alt='Image de cartes de crédit' src='/pub/img/dw3/cc.png' style='height:2vw;min-height:40px;width:2vw;min-width:40px;margin:10px;'>";
            echo "<img alt='Image de Interact' src='/pub/img/dw3/interac.png' style='height:2vw;min-height:40px;width:2vw;min-width:40px;margin:10px;'>";
            echo "</div>";
        }
        ?> 
        <span id="siteseal"><script async="" type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=AeJwTXAdU3qjjw9FtujzhsmeR0dL0ObmlbaYC3Hm33jitJpWaFsaf7YhBda9"></script><img style="cursor:pointer;cursor:hand" src="https://seal.starfieldtech.com/images/3/fr/siteseal_sf_3_h_l_m.gif" onclick="verifySeal();" alt="SSL site seal - click to verify"></span>
        <br>
        <?php 
        if ($CIE_COOKIES_IMG == ""){ 
            echo "<button onclick='dw3_cookie_pref();'>";
                if($USER_LANG == "FR"){ 
                    echo "Préférences en matière de conservation des données"; 
                }else{
                    echo "Data retention preferences";
                }
            echo "</button>";
        } else {
            echo "<img title='"; 
            if($USER_LANG == "FR"){ 
                echo "Préférences en matière de conservation des données"; 
            }else{
                echo "Data retention preferences";
            }
            echo "' style='cursor:pointer;position:absolute;left:5px;width:auto;height:2vw;min-height:40px;z-index:+1;' src='/pub/img/cookies/". $CIE_COOKIES_IMG."' onclick='dw3_cookie_pref();'>";
        }
        ?>
        <div style="font-size:1em;padding:5px 0px;width:100%;max-width:100%;overflow:hidden;display:inline-block;text-align:center;">
            <a href="/legal/PRIVACY.html" target="_blank" style='color:unset;'><u><?php if($USER_LANG == "FR"){ echo "Politique de confidentialité"; }else{echo "Privacy Policy";} ?></u></a>
        </div>
        <div style='font-size:0.9em;padding:3px;'>
            <?php if($USER_LANG == "FR"){ echo "Créé avec"; }else{echo "Created with";} ?> Design Web 3D | <a href='https://dw3.ca' target='dw3'>https://dw3.ca</a>
        </div>
        <div style='overflow:hidden;font-size:1.2em;width:100%;padding:13px 0px;background-color:#<?php echo $CIE_COLOR6; ?>;color:#<?php echo $CIE_COLOR7; ?>;'>
            © <?php echo $CIE_NOM; if ($CIE_DOUV != date("Y") && $CIE_DOUV != "" && $CIE_DOUV != "0"){echo " " . $CIE_DOUV . "-" . date("Y");}else{echo " " . date("Y");} echo " RBQ#".$CIE_RBQ;?>
        </div>
    </div>
    <?php 
        require_once ($_SERVER['DOCUMENT_ROOT'] . "/pub/section/foot_scene.php");
        $dw3_conn->close();
    ?>
</footer>
</body>
</html>