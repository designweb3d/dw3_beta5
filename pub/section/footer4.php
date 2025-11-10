</main>
<!-- Minimal Fixe -->
<footer>
    <?php if (!isset($dw3_conn)){header('Location: https://'.$_SERVER["SERVER_NAME"].'/');exit;}?>
        <div id='dw3_foot4_pos' style="width:100%;text-align:center;padding:7px 0px 50px 0px;background-color:#<?php echo $CIE_COLOR6; ?>;color:#<?php echo $CIE_COLOR7; ?>;">
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
        <div style="font-size:1em;padding-top:5px;width:100%;max-width:100%;display:inline-block;text-align:center;">
            <a href="/legal/PRIVACY.html" target="_blank" style='color:#<?php echo $CIE_COLOR7; ?>;'><u><?php if($USER_LANG == "FR"){ echo "Politique de confidentialité"; }else{echo "Privacy Policy";} ?></u></a>
        </div>
    </div>
    <div style='line-height:1;position:fixed;bottom:0px;left:0px;overflow:hidden;font-size:1.2em;width:100%;min-height:40px;padding:5px 0px;background-color:#<?php echo $CIE_COLOR6; ?>;color:#<?php echo $CIE_COLOR7; ?>;'>
        © <?php echo $CIE_NOM; if ($CIE_DOUV != date("Y") && $CIE_DOUV != "" && $CIE_DOUV != "0"){echo " " . $CIE_DOUV . "-" . date("Y");}else{echo " " . date("Y");} ?>
        <div style='font-size:0.9em;padding-bottom:43px;'>
            <?php if($USER_LANG == "FR"){ echo "Créé avec"; }else{echo "Created with";} ?> Design Web 3D | <a href='https://dw3.ca' target='dw3'>https://dw3.ca</a>
        </div>
    </div>

    <?php 
        require_once ($_SERVER['DOCUMENT_ROOT'] . "/pub/section/foot_scene.php");
        $dw3_conn->close();
    ?>
</footer>
</body>
</html>