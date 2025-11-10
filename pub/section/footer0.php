</main>
<!-- Minimal -->
 <footer>
    <div class='dw3_page_foot' style='min-height:50px;'>
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
            echo "<img alt='Image pour les cookies' title='"; 
            if($USER_LANG == "FR"){ 
                echo "Préférences en matière de conservation des données"; 
            }else{
                echo "Data retention preferences";
            }
            echo "' style='cursor:pointer;position:absolute;left:5px;width:auto;height:2vw;min-height:40px;z-index:+1;' src='/pub/img/cookies/". $CIE_COOKIES_IMG."' onclick='dw3_cookie_pref();'>";
        }
        ?>
        <div style="line-height:1;font-size:1em;padding:7px 0px;width:100%;max-width:100%;overflow:hidden;display:inline-block;text-align:center;">
            <a href="/legal/PRIVACY.html" target="_blank"><u><?php if($USER_LANG == "FR"){ echo "Politique de confidentialité"; }else{echo "Privacy Policy";} ?></u></a>
        </div>
        <div style='font-size:0.9em;padding:5px 0px;'>
            <?php if($USER_LANG == "FR"){ echo "Créé avec"; }else{echo "Created with";} ?><a href='https://dw3.ca' target='dw3'> Design Web 3D</a>
        </div>
        <div style='overflow:hidden;font-size:1.2;width:100%;padding:13px 0px;background-color:#<?php echo $CIE_COLOR6; ?>;color:#<?php echo $CIE_COLOR7; ?>;'>
            © <?php echo $CIE_NOM; if ($CIE_DOUV != date("Y") && $CIE_DOUV != "" && $CIE_DOUV != "0"){echo " " . $CIE_DOUV . "-" . date("Y");}else{echo " " . date("Y");} ?>
        </div>

    <?php 
        require_once ($_SERVER['DOCUMENT_ROOT'] . "/pub/section/foot_scene.php");
        $dw3_conn->close();
    ?>
    </div>
</footer>
<script src="/pub/js/multiavatar.min.js"></script>
</body>
</html>