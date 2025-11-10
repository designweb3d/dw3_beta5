<!-- Transparent épuré 70px Sticky -->
<div id="dw3_head" style='position:fixed;top:0px;left:0px;height:70px;text-align:left;background-color:transparent;background-image: linear-gradient(to right,#<?php echo $CIE_COLOR8; ?>, #<?php echo $CIE_COLOR8; ?> , transparent,transparent,transparent,transparent, transparent, #<?php echo $CIE_COLOR8; ?>, #<?php echo $CIE_COLOR8; ?>);'>
    <img  onclick='dw3_menu_toggle();' id="imgLOGO" src="/pub/img/<?php echo $CIE_LOGO3; ?>" style="padding:0px;vertical-align:middle;height:70px;width:auto;" alt="Logo de l'entreprise pour le site web">
    <div id='dw3_menu_bars' style='position:fixed;top:10px;right:10px;cursor:pointer;' onclick='dw3_menu_toggle();'>
                    <div class="dw3_menu_bar1"></div>
                    <div class="dw3_menu_bar2"></div>
                    <div class="dw3_menu_bar3"></div>
                </div>
<?php  require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_menu.php'; ?>  </div></div>
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
          } function setSubMenusPos(){return}</script>";?>
