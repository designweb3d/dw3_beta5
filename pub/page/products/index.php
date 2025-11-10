<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';

/* if ($PAGE_HEADER== '/pub/section/header0.php'){$INDEX_HEADER_HEIGHT = '0';}
else if ($PAGE_HEADER== '/pub/section/header1.php'){$INDEX_HEADER_HEIGHT = '50';}
else if ($PAGE_HEADER== '/pub/section/header2.php'){$INDEX_HEADER_HEIGHT = '20';}
else if ($PAGE_HEADER== '/pub/section/header3.php'){$INDEX_HEADER_HEIGHT = '30';}
else {$INDEX_HEADER_HEIGHT='50';} */

if ($PAGE_HEADER== '/pub/section/header21.php'){$INDEX_HEADER_HEIGHT = '100px';}
if ($PAGE_HEADER== '/pub/section/header22.php'){$INDEX_HEADER_HEIGHT = '70px';}

if($USER_LANG == "FR"){
    echo ($PAGE_HTML_FR);
} else {
    echo ($PAGE_HTML_EN);
}
echo "<div style='min-height:5vh;margin-top:".$INDEX_HEADER_HEIGHT.";'>";
$sub_cats_count = 0;

/* if (trim($cat_lst) != "" && trim(strtolower($cat_lst)) != "promo" && trim(strtolower($cat_lst)) != "all"){
    $sql = "SELECT * FROM product_category WHERE id IN (".$cat_lst.") ";
    if ($USER_LANG == "FR"){
        $sql .= " ORDER BY name_fr ASC ";
    } else {
        $sql .= " ORDER BY name_en ASC ";
    }
    $result = mysqli_query($dw3_conn, $sql);
    //$data = mysqli_fetch_assoc($result);
    if ($result->num_rows > 0) {
        echo "<h3 onclick='history.back()' style='text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";vertical-align:middle;'><span class='material-icons'>skip_previous</span>";
        while($row = $result->fetch_assoc()) {
            if($USER_LANG == "FR"){  
                $trad_name = $row["name_fr"]; 
            } else {
                $trad_name = $row["name_en"];
            }
            //echo "<span style='vertical-align:middle;padding:0px 5px;'>| ".$trad_name." |</span>";
        }
        echo "</h3>";
    }
} else if(trim(strtolower($cat_lst)) != ""){ 
    echo "<h3 onclick='history.back()' style='cursor:pointer;text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";vertical-align:middle;'><span class='material-icons'>skip_previous</span></h3>";
} */



if($USER_LANG == "FR"){  
    echo "<h4 onclick='history.back()' style='cursor:pointer;text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-image: linear-gradient(125deg, #".$CIE_COLOR6.",#".$CIE_COLOR6_2.");vertical-align:middle;'>&#11104; <u>Retour</u></h4>";
} else {
    echo "<h4 onclick='history.back()' style='cursor:pointer;text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-image: linear-gradient(125deg, #".$CIE_COLOR6.",#".$CIE_COLOR6_2.");vertical-align:middle;'>&#11104; <u>Go Back</u></h4>";
}

//echo "<h3 onclick='history.back()' style='cursor:pointer;text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";vertical-align:middle;'><span class='material-icons'>skip_previous</span></h3>";


?>
<br>
<div style='max-width:600px;display:inline-block;margin:15px 0px 10px 0px;'>
    <div style='display:flex;'>
        <?php
            if($USER_LANG == "FR"){ 
                echo "<input style='background:#fff;color:#333;padding:7px;' type='search' placeholder='Rechercher' class='inputRECH' id='rechPROD' onkeyup='if (event.keyCode == 13){getPRODUCTS(0,ROWS_LIMIT);}'>";
            } else {
                echo "<input style='background:#fff;color:#333;padding:7px;' type='search' placeholder='Find' class='inputRECH' id='rechPROD' onkeyup='if (event.keyCode == 13){getPRODUCTS(0,ROWS_LIMIT);}'>";
            }
        ?>
        <button onclick='getPRODUCTS(0,ROWS_LIMIT);' class='no-effect'>&#128269;</button>
    </div>
    <select id='rechByCat' class='like_search'>
        <?php
        if($USER_LANG == "FR"){ 
            echo "<option value='all'>Toutes les catégories</option>";
        } else {
            echo "<option value='all'>All Categories</option>";
        }
        $sql = "SELECT A.*, IFNULL(B.product_found,'0') AS found_b, IFNULL(C.product_found,'0') AS found_c, IFNULL(D.product_found,'0') AS found_d
            FROM product_category A
            LEFT JOIN (SELECT count(id) AS product_found, category_id FROM product WHERE web_dsp=1 AND stat=0 GROUP BY category_id) B ON A.id = B.category_id
            LEFT JOIN (SELECT count(id) AS product_found, category2_id FROM product WHERE web_dsp=1 AND stat=0 GROUP BY category2_id) C ON A.id = C.category2_id
            LEFT JOIN (SELECT count(id) AS product_found, category3_id FROM product WHERE web_dsp=1 AND stat=0 GROUP BY category3_id) D ON A.id = D.category3_id ";
    if($USER_LANG == "FR"){
        $sql .= "ORDER BY A.name_fr ASC;"; 
    } else {
        $sql .= "ORDER BY A.name_en ASC;";
    }
        $result = $dw3_conn->query($sql);
        $cat_count = $result->num_rows;
        if ($cat_count > 0) {
            while($row = $result->fetch_assoc()) {
                $found_by_cat = $row["found_b"] + $row["found_c"] + $row["found_d"] ;
                if ($row["id"]==$cat_lst){
                    if($USER_LANG == "FR"){ 
                        echo "<option selected value='".$row["id"]."'>".str_replace("'","’",$row["name_fr"])."</option>";
                    }else {
                        echo "<option selected value='".$row["id"]."'>".str_replace("'","’",$row["name_en"])."</option>";
                    }
                } else {
                    if($USER_LANG == "FR"){ 
                        echo "<option value='".$row["id"]."'>".str_replace("'","’",$row["name_fr"])."</option>";
                    }else {
                        echo "<option value='".$row["id"]."'>".str_replace("'","’",$row["name_en"])."</option>";
                    }
                }
            }
        }
        ?>
    </select>
</div><br>
<div id='divPRODUCTS' style='min-height:10vh;'></div>
<?php

echo "</div>";

?>
<script>
var ROWS_LIMIT = '24';
var ROWS_OFFSET = '0';
var cat_list = '<?php echo($cat_lst); ?>';
var url_param2 = '<?php echo($PAGE_P2); ?>';

//$(document).ready(function (){
    if (url_param2 != ""){
        document.getElementById("rechPROD").value = url_param2;
    }
    document.getElementById("dw3_body").innerHTML = "";
    bREADY = true;
    getPRODUCTS(ROWS_OFFSET,ROWS_LIMIT);
//});

function getPRODUCTS(sOFFSET,sLIMIT) {
    var GRPBOX  = document.getElementById("rechByCat");
	var selected_cat = GRPBOX.options[GRPBOX.selectedIndex].value;

    if (document.getElementById("rechPROD")){
        ssF = document.getElementById("rechPROD").value;
    } else {
        ssF = "";
    }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divPRODUCTS").innerHTML = this.responseText;
         if (document.getElementById("rechPROD")){
            const input = document.getElementById('rechPROD');
            const length = input.value.length;
            input.focus();
            input.setSelectionRange(length, length);
         }
	  }
	};
    xmlhttp.open('GET', 'getPRODUCTS.php?KEY=' + KEY 
    + '&SS='+encodeURIComponent(ssF)												
    + '&P1=' + selected_cat 
    + '&OFFSET=' + sOFFSET 
    + '&SUBS=<?php echo $sub_cats_count; ?>' 
    + '&LIMIT=' + sLIMIT, true);
    xmlhttp.send();
}

</script>
<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
?>