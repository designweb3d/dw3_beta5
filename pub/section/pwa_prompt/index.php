<?php 
if($USER_LANG == "FR"){
    echo "<button id='btn_install_pwa' style='display:none;' class='no-effect green'>Installer le site web comme application</button>";
}else{
    echo "<button id='btn_install_pwa' style='display:none;' class='no-effect green'>Install Website</button>";
}
?>

<!-- <script src="/pub/section/pwa_prompt/section.js"></script> -->
<script src="/pub/section/pwa_prompt/section.js?t=<?php echo(rand(100,100000)); ?>"></script>