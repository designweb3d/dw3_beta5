<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';
?>

<div id='divHEAD' style='padding:0px;height:70px;'>
<table style="width:100%;margin:0px;white-space:nowrap;">
    <tr style="margin:0px;padding:0px;">
        <td style="margin:0px;padding:0px;text-align:right;">
        <select id="selGraph" onchange='showGraph()' style="width:98%;">
        <?php
            class ExampleSortedIterator extends SplHeap{
                public function __construct(Iterator $iterator){
                    foreach ($iterator as $item) {
                        $this->insert($item);
                    }
                }
                public function compare($b,$a){
                    return strcmp($a->getRealpath(), $b->getRealpath());
                }
            }
            $dir = new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . '/app/statistic');
            $files = new RecursiveIteratorIterator($dir);
            $sorted = new ExampleSortedIterator($files);
            foreach($sorted as $file){
                $path_parts = pathinfo($file);
                if ($file != ".." && $file != "." && isset($path_parts['extension'])){
                    //$fn=basename($file->getFileName(), ".html");
                /*  echo $path_parts['dirname'], "\n";
                    echo $path_parts['basename'], "\n";
                    echo $path_parts['extension'], "\n";
                    echo $path_parts['filename'], "\n"; */
                    $file_base = $path_parts['basename'];
                    //error_log($path_parts['basename']);
                    $file_ext = strtolower($path_parts['extension']);
                    $file_name = $path_parts['filename'];
                    //$fn=pathinfo($file->getFileName(), PATHINFO_FILENAME);
                    //if ($fn!="." && $fn!=".."){
                    if ($file_ext == "php" && substr($file_name,0,5)=="STAT_"){
                        //$clean_fn = substr($fn,-5);
                        echo "<option value='". $file_base ."'>".substr($file_name,5)."</option>";
                    }
                }
            }
        ?></td>
    <td style='text-align:left;'>
        <select id="chart_type" onchange='showGraph()' style="width:95%;">
            <option selected value='bar'>Barres</option>
            <option value='line'>Lignes</option>
            <option value='pie'>Tarte</option>
            <option value='doughnut'>Beigne</option>
            <option value='polarArea'>Polaire</option>
            <option value='radar'>Radar</option>
        </select>
    </td></tr>
    <tr><td colspan=2 style='text-align:center;'>
    </select>
    <select id="month_from" onchange='showGraph()' style="display:inline-block;width:60px;">
        <option selected value='01'>01</option>
        <option value='02'>02</option>
        <option value='03'>03</option>
        <option value='04'>04</option>
        <option value='05'>05</option>
        <option value='06'>06</option>
        <option value='07'>07</option>
        <option value='08'>08</option>
        <option value='09'>09</option>
        <option value='10'>10</option>
        <option value='11'>11</option>
        <option value='12'>12</option>
    </select>
    <select id="year_from" onchange='showGraph()' style="display:inline-block;width:80px;">
        <option value=2023>2023</option>
        <option <?php if (date("Y")=="2024"){echo "selected";} ?> value=2024>2024</option>
        <option <?php if (date("Y")=="2025"){echo "selected";} ?> value=2025>2025</option>
        <option <?php if (date("Y")=="2026"){echo "selected";} ?> value=2026>2026</option>
        <option <?php if (date("Y")=="2027"){echo "selected";} ?> value=2027>2027</option>
        <option <?php if (date("Y")=="2028"){echo "selected";} ?> value=2028>2028</option>
        <option <?php if (date("Y")=="2029"){echo "selected";} ?> value=2029>2029</option>
        <option <?php if (date("Y")=="2030"){echo "selected";} ?> value=2030>2030</option>
        <option <?php if (date("Y")=="2031"){echo "selected";} ?> value=2031>2031</option>
        <option <?php if (date("Y")=="2032"){echo "selected";} ?> value=2032>2032</option>
        <option <?php if (date("Y")=="2033"){echo "selected";} ?> value=2033>2033</option>
        <option <?php if (date("Y")=="2044"){echo "selected";} ?> value=2034>2034</option>
        <option <?php if (date("Y")=="2035"){echo "selected";} ?> value=2035>2035</option>
        <option <?php if (date("Y")=="2036"){echo "selected";} ?> value=2036>2036</option>
        <option <?php if (date("Y")=="2037"){echo "selected";} ?> value=2037>2037</option>
        <option <?php if (date("Y")=="2038"){echo "selected";} ?> value=2038>2038</option>
        <option <?php if (date("Y")=="2039"){echo "selected";} ?> value=2039>2039</option>
        <option <?php if (date("Y")=="2040"){echo "selected";} ?> value=2040>2040</option>
    </select> -> 
    <select id="month_to" onchange='showGraph()' style="display:inline-block;width:60px;">
        <option value='01'>01</option>
        <option value='02'>02</option>
        <option value='03'>03</option>
        <option value='04'>04</option>
        <option value='05'>05</option>
        <option value='06'>06</option>
        <option value='07'>07</option>
        <option value='08'>08</option>
        <option value='09'>09</option>
        <option value='10'>10</option>
        <option value='11'>11</option>
        <option selected value='12'>12</option>
    </select>
    <select id="year_to" onchange='showGraph()' style="display:inline-block;width:80px;">
        <option value=2023>2023</option>
        <option <?php if (date("Y")=="2024"){echo "selected";} ?> value=2024>2024</option>
        <option <?php if (date("Y")=="2025"){echo "selected";} ?> value=2025>2025</option>
        <option <?php if (date("Y")=="2026"){echo "selected";} ?> value=2026>2026</option>
        <option <?php if (date("Y")=="2027"){echo "selected";} ?> value=2027>2027</option>
        <option <?php if (date("Y")=="2028"){echo "selected";} ?> value=2028>2028</option>
        <option <?php if (date("Y")=="2029"){echo "selected";} ?> value=2029>2029</option>
        <option <?php if (date("Y")=="2030"){echo "selected";} ?> value=2030>2030</option>
        <option <?php if (date("Y")=="2031"){echo "selected";} ?> value=2031>2031</option>
        <option <?php if (date("Y")=="2032"){echo "selected";} ?> value=2032>2032</option>
        <option <?php if (date("Y")=="2033"){echo "selected";} ?> value=2033>2033</option>
        <option <?php if (date("Y")=="2044"){echo "selected";} ?> value=2034>2034</option>
        <option <?php if (date("Y")=="2035"){echo "selected";} ?> value=2035>2035</option>
        <option <?php if (date("Y")=="2036"){echo "selected";} ?> value=2036>2036</option>
        <option <?php if (date("Y")=="2037"){echo "selected";} ?> value=2037>2037</option>
        <option <?php if (date("Y")=="2038"){echo "selected";} ?> value=2038>2038</option>
        <option <?php if (date("Y")=="2039"){echo "selected";} ?> value=2039>2039</option>
        <option <?php if (date("Y")=="2040"){echo "selected";} ?> value=2040>2040</option>
    </select>
        </div>	  
    </td></tr></table>
</div>

<div style='position:fixed;top:70px;left:0px;right:0px;bottom:0px;'>
    <iframe id='dspGraph' style='width:100%;height:100%;background:rgba(255,255,255,0.95);border:0;'></iframe>
</div>
<div id="divMSG"></div>
<div id="divOPT"></div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
$(document).ready(function (){
    showGraph();
});

function showGraph(){
/*     document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
 */
	var GRPBOX  = document.getElementById("selGraph");
	var sGraph  = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("year_from");
	var sYF = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("year_to");
	var sYT = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("month_from");
	var sMF = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("month_to");
	var sMT = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("chart_type");
	var sGT = GRPBOX.options[GRPBOX.selectedIndex].value;

    var w = window.innerWidth;
    var h = window.innerHeight;
    if (sGT == "bar" || sGT == "line"){
        document.getElementById("dspGraph").style.width = w + "px";
        document.getElementById("dspGraph").style.height = (h-70) + "px";    
    } else {
        if (h<w){
            document.getElementById("dspGraph").style.width = (h-70) + "px";
            document.getElementById("dspGraph").style.height = (h-70) + "px";
        } else {
            document.getElementById("dspGraph").style.width = w + "px";
            document.getElementById("dspGraph").style.height = (h-70) + "px";
        }
    }

    document.getElementById("dspGraph").src = "/app/statistic/"+sGraph+"?KEY=" + KEY + "&YF=" + sYF + "&YT=" + sYT + "&MF=" + sMF + "&MT=" + sMT + "&GT=" + sGT;
/* 	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divDISPO").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getDISPO.php?KEY=' + KEY + '&M=' + currentMonth + '&Y=' + currentYear + '&D=' + currentDay + '&P=' + xprd + '&L=' + xloc
										,true);
		xmlhttp.send(); */
}


</script>
</body>
</html>
