<?php
if (trim($PAGE_ID) == "0" || trim($PAGE_URL) == "/"){
    if($INDEX_SCENE != ""){
        echo "<script type='module' src='/pub/scene/". $INDEX_SCENE."/canvas_bg.js?t=". rand(100,100000).">' data-bg3='/pub/img/". $CIE_BG3 ."'></script>";
    }
}else{
    if($PAGE_SCENE != ""){
        echo "<script type='module' src='/pub/scene/". $PAGE_SCENE."/canvas_bg.js?t=". rand(100,100000).">' data-bg3='/pub/img/". $CIE_BG3 ."'></script>";
    }
}
?>