</main>
<!-- Épuré -->
<footer>
    <?php if (!isset($dw3_conn)){header('Location: https://'.$_SERVER["SERVER_NAME"].'/');exit;}?>
        <div style='font-size:0.7em;padding:3px;mix-blend-mode: difference;'>
                <?php if($USER_LANG == "FR"){ echo "Créé avec"; }else{echo "Created with";} ?> Design Web 3D | <a style='mix-blend-mode: difference;color:unset;' href='https://dw3.ca' target='dw3'>https://dw3.ca</a>
            </div>
    <div style="width:100%;display:inline-block;">
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
    <a href="/legal/PRIVACY.html" target="_blank" style='color:unset;'><u><?php if($USER_LANG == "FR"){ echo "Politique de confidentialité"; }else{echo "Privacy Policy";} ?></u></a>
        <div style='z-index:-2;position:absolute;left:0px;overflow:hidden;font-size:1.2em;width:100%;padding:7px 0px;color:#<?php echo $CIE_COLOR7; ?>;background-color:transparent;'>
            © <?php echo $CIE_NOM; if ($CIE_DOUV != date("Y") && $CIE_DOUV != "" && $CIE_DOUV != "0"){echo " " . $CIE_DOUV . "-" . date("Y");}else{echo " " . date("Y");} ?>
        </div>
    </div>
    <?php 
        require_once ($_SERVER['DOCUMENT_ROOT'] . "/pub/section/foot_scene.php");
        $dw3_conn->close();
    ?>
</footer>
</body>
</html>