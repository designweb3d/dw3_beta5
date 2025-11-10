<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';

if ($PAGE_ID == "" || $PAGE_ID == "0"){
    $PAGE_HEADER = '/pub/section/header0.php';
    if ($PAGE_HEADER== '/pub/section/header0.php'){$INDEX_HEADER_HEIGHT = '70';}
    else if ($PAGE_HEADER== '/pub/section/header1.php'){$INDEX_HEADER_HEIGHT = '120';}
    else if ($PAGE_HEADER== '/pub/section/header2.php'){$INDEX_HEADER_HEIGHT = '105';}
    else if ($PAGE_HEADER== '/pub/section/header3.php'){$INDEX_HEADER_HEIGHT = '100';}
    else if ($PAGE_HEADER== '/pub/section/header4.php'){$INDEX_HEADER_HEIGHT = '100';}
    else if ($PAGE_HEADER== '/pub/section/header5.php'){$INDEX_HEADER_HEIGHT = '102';}
    else if ($PAGE_HEADER== '/pub/section/header6.php'){$INDEX_HEADER_HEIGHT = '70';}
    else if ($PAGE_HEADER== '/pub/section/header7.php'){$INDEX_HEADER_HEIGHT = '105';}
    else if ($PAGE_HEADER== '/pub/section/header8.php'){$INDEX_HEADER_HEIGHT = '100';}
    else if ($PAGE_HEADER== '/pub/section/header9.php'){$INDEX_HEADER_HEIGHT = '70';}
    else if ($PAGE_HEADER== '/pub/section/header10.php'){$INDEX_HEADER_HEIGHT = '70';}
    else if ($PAGE_HEADER== '/pub/section/header11.php'){$INDEX_HEADER_HEIGHT = '70';}
    else if ($PAGE_HEADER== '/pub/section/header12.php'){$INDEX_HEADER_HEIGHT = '82';}
    else if ($PAGE_HEADER== '/pub/section/header13.php'){$INDEX_HEADER_HEIGHT = '70';}
    else if ($PAGE_HEADER== '/pub/section/header14.php'){$INDEX_HEADER_HEIGHT = '100';}
    else if ($PAGE_HEADER== '/pub/section/header15.php'){$INDEX_HEADER_HEIGHT = '100';}
    else if ($PAGE_HEADER== '/pub/section/header16.php'){$INDEX_HEADER_HEIGHT = '100';}
    else if ($PAGE_HEADER== '/pub/section/header17.php'){$INDEX_HEADER_HEIGHT = '100';}
    else if ($PAGE_HEADER== '/pub/section/header18.php'){$INDEX_HEADER_HEIGHT = '90';}
    else if ($PAGE_HEADER== '/pub/section/header19.php'){$INDEX_HEADER_HEIGHT = '100';}
    else if ($PAGE_HEADER== '/pub/section/header20.php'){$INDEX_HEADER_HEIGHT = '90';}
    else if ($PAGE_HEADER== '/pub/section/header21.php'){$INDEX_HEADER_HEIGHT = '90';}
    else if ($PAGE_HEADER== '/pub/section/header22.php'){$INDEX_HEADER_HEIGHT = '70';}
    else {$INDEX_HEADER_HEIGHT='70';}
}

require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';

if ($PAGE_P1 == ""){
    if ($USER_LANG == "FR" || $USER_LANG == "fr") {
        $sqlC = "SELECT DISTINCT category_fr FROM article ORDER BY category_fr ASC";
        $resultC = $dw3_conn->query($sqlC);
        if ($resultC->num_rows > 0) {	
            while($rowC = $resultC->fetch_assoc()) {
                if (trim($rowC["category_fr"]) != ""){
                    echo "<a href='/pub/page/article/index.php?PID=".$PAGE_ID."&P1=".rawurlencode($rowC["category_fr"])."'><span class='grey_capsule'>".$rowC["category_fr"]."</span></a>";
                }
            }
        }
    } else {
        $sqlC = "SELECT DISTINCT category_en FROM article ORDER BY category_en ASC";
        $resultC = $dw3_conn->query($sqlC);
        if ($resultC->num_rows > 0) {
            while($rowC = $resultC->fetch_assoc()) {
                if (trim($rowC["category_en"]) != ""){
                    echo "<a href='/pub/page/article/index.php?PID=".$PAGE_ID."&P1=".rawurlencode($rowC["category_en"])."'><span class='grey_capsule'>".$rowC["category_en"]."</span></a>";
                }
            }
        }
    }
} else {
    if ($USER_LANG == "FR" || $USER_LANG == "fr") {
        echo "<div style='width:100%;text-align:left;margin-top:20px;'><div style='padding:0px 20px;'>
                <a href='/pub/page/article/index.php?PID=".$PAGE_ID."'><span style='color:white;background:#555;border-radius:10px;padding:12px 15px;margin:5px;font-size:18px;'>Toutes les catégories</span></a>
                <span style='vertical-align:middle;font-size:1.5em;font-weight:700;'> > <u>".$PAGE_P1."</u></span>
            </div></div>";
    } else {
        echo "<div style='width:100%;text-align:left;margin-top:20px;'><div style='padding:0px 20px;'>
                <a href='/pub/page/article/index.php?PID=".$PAGE_ID."'><span style='color:white;background:#555;border-radius:10px;padding:12px 15px;margin:5px;font-size:18px;'>All categories</span></a>
                <span style='vertical-align:middle;font-size:1.5em;font-weight:700;'> > <u>".$PAGE_P1."</u></span>
            </div></div>";
    }
}
?>
<br><div style='max-width:600px;display:inline-block;margin:15px 0px 10px 0px;'><input style='background-color:#fff;color:#333;' type='search' class='inputRECH' id='rechARTS' oninput='findARTS(0,TABLES_LIMIT)' value=''></div><br>
<div id='divARTS'><img src='/pub/img/load/<?php echo $CIE_LOAD; ?>' style='border-radius:10px;max-width:30px;height:auto;margin:150px 0px;'></div>

<script>
TABLES_LIMIT = '10';
CAT = '<?php echo $PAGE_P1; ?>';

//$(document).ready(function (){
    document.getElementById("dw3_body").innerHTML = "";
    //document.getElementById("rechAD").focus();
    bREADY = true;
    findARTS(0,TABLES_LIMIT);
//});

function openART(artID) {
    window.open('article.php?ID='+artID+'&P1='+'<?php echo $PAGE_ID;?>','_self')
}
function findARTS(sOFFSET,sLIMIT) { 
    var ssF = "";
    if (document.getElementById("rechARTS")){
        ssF = document.getElementById("rechARTS").value;
    }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divARTS").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getARTS.php?KEY=' + KEY 											
    + '&SS='+encodeURIComponent(ssF)												
    + '&CAT='+encodeURIComponent(CAT)												
    + '&OFFSET=' + sOFFSET 
    + '&LIMIT=' + sLIMIT, true);
    xmlhttp.send();
}
</script>
<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
    exit; 
?>