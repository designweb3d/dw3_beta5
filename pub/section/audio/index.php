<?php 
/* $SID = $_GET['SID']??'';
if (isset($_SERVER['HTTP_SECTION_ID'])) {header("SECTION_ID:".$_SERVER['HTTP_SECTION_ID']);}
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.min.php'; */
?><div style='margin:<?php echo $SECTION_MARGIN; ?>;display:inline-block;width:100%;height:auto;background-color:<?php echo $SECTION_BG; ?>;border-radius:<?php echo $SECTION_RADIUS; ?>;'>
    
    <h3 style='color:#111;text-shadow:1px 1px 2px #fff;'><?php if($USER_LANG == "FR"){echo $SECTION_TITLE;}else{echo $SECTION_TITLE_EN;} ?></h3>
    <audio id="audio_control_<?php echo $SECTION_ID; ?>" style='display:none;' src="/pub/mp3/<?php echo $SECTION_LIST; ?>" controls></audio>
    <button id='audio_start_<?php echo $SECTION_ID; ?>' onclick='InitAudio("<?php echo $SECTION_ID; ?>")'> <?php if($USER_LANG == "FR"){echo "Écouter";}else{echo "Play";}?> </button>
    <div id="audio_container_<?php echo $SECTION_ID; ?>" style="overflow:hidden;width: 100%;vertical-align:top;text-align: center;min-height:240px;"></div>

</div>