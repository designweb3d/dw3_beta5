<?php 
/* $SID = $_GET['SID']??''; */
/* if (isset($_SERVER['HTTP_SECTION_ID'])) {header("SECTION_ID:".$_SERVER['HTTP_SECTION_ID']);}
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.min.php'; */
if 	($SECTION_IMG_DSP  =="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}

echo "<div style='background-color:".$SECTION_BG.";color:". $SECTION_FG.";width:100%;text-align:center;margin:". $SECTION_MARGIN.";display:inline-block;text-align:center;height:auto;border-radius:". $SECTION_RADIUS.";max-width:". $SECTION_MAXW.";box-shadow:". $SECTION_SHADOW.";".$bg_gradiant.$font_family."'>";
//img
    if ($SECTION_IMG_DSP == "header"){
        echo "<img src='/pub/upload/".$SECTION_IMG."' style='border-top-right-radius:".$SECTION_RADIUS.";border-top-left-radius:".$SECTION_RADIUS.";width:100%;height:auto;'>";
        echo "<div style='margin-top:-1px;display:inline-block;text-align:center;width:100%;height:auto;max-width:100%;line-height:1.5em;border-bottom-left-radius:".$SECTION_RADIUS.";border-bottom-right-radius:".$SECTION_RADIUS.";'>";
    } else {
        echo "<div style='margin-top:-1px;display:inline-block;text-align:center;width:100%;height:auto;max-width:100%;line-height:1.5em;border-radius:". $SECTION_RADIUS .";'>";
    }

    if ($SECTION_IMG_DSP=="floatLeft"){
        echo "<div style='float:left;width:50%;'><img src='/pub/upload/".$SECTION_IMG."' style='width:99%;border-radius:5px;margin:10px;'></div>";
    }
    if ($SECTION_IMG_DSP=="floatRight"){
        echo "<div style='float:right;width:50%;'><img src='/pub/upload/".$SECTION_IMG."' style='width:99%;border-radius:5px;margin:10px;'></div>";
    }
echo  "<section itemscope itemtype='https://schema.org/FAQPage'>";
    if ($SECTION_TITLE_DSP!="none" && $SECTION_TITLE_DSP!=""){
        if ($USER_LANG == "FR"){
            echo "<h3 style='padding:10px 0px 6px 0px;text-align:".$SECTION_TITLE_DSP."'>".$SECTION_TITLE."</h3>";
        } else {
            echo "<h3 style='padding:10px 0px 6px 0px;text-align:".$SECTION_TITLE_DSP."'>".$SECTION_TITLE_EN."</h3>";
        }
    }    
$sql = "SELECT * FROM faq ORDER BY sort_index ASC;"; 
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($USER_LANG == "FR"){
                echo "<div itemscope itemtype='https://schema.org/Question' itemprop='mainEntity'>
                    <div onclick=\"dw3_sub_toggle('dw3_subQR".$row["id"]."','300','tickQR".$row["id"]."')\" style='cursor:pointer;display: flex;flex-wrap: nowrap;background:rgba(200,200,200,0.2);width:100%;'><div style='margin: 10px 10px 7px 10px;vertical-align:middle;'><div id='tickQR".$row["id"]."' style='font-size:12px;'>⏵</div></div><div style='vertical-align:middle;'><h4 itemprop='name' style='margin: 14px 10px 10px 0px;text-align:left;vertical-align:middle;'>".$row["q_fr"]."</h4></div></div>
                    <div id='dw3_subQR".$row["id"]."' class='dw3_sub' itemscope itemtype='https://schema.org/Answer' itemprop='acceptedAnswer' style='margin-bottom:2px;'>
                        <p itemprop='text' style='overflow:hidden;margin:10px 10px 0px 10px;padding:10px;border-radius:10px 10px;background:rgba(225,225,225,0.3);text-align:left;max-width:95%;display:inline-block;'>".$row["r_fr"]."</p>
                    </div>
                </div>";
            } else {
                echo "<div itemscope itemtype='https://schema.org/Question' itemprop='mainEntity'>
                    <div onclick=\"dw3_sub_toggle('dw3_subQR".$row["id"]."','300','tickQR".$row["id"]."')\" style='cursor:pointer;display: flex;flex-wrap: nowrap;background:rgba(200,200,200,0.2);width:100%;'><div style='margin: 10px 10px 7px 10px;vertical-align:middle;'><div id='tickQR".$row["id"]."' style='font-size:12px;'>⏵</div></div><div style='vertical-align:middle;'><h4 itemprop='name' style='margin: 14px 10px 10px 0px;text-align:left;vertical-align:middle;'>".$row["q_en"]."</h4></div></div>
                    <div id='dw3_subQR".$row["id"]."' class='dw3_sub' itemscope itemtype='https://schema.org/Answer' itemprop='acceptedAnswer' style='margin-bottom:2px;'>
                        <p itemprop='text' style='overflow:hidden;margin:10px 10px 0px 10px;padding:10px;border-radius:10px 10px;background:rgba(225,225,225,0.3);text-align:left;max-width:95%;display:inline-block;'>".$row["r_en"]."</p>
                    </div>
                </div>";
            }
        }
    }
echo "</section></div></div>";
?>
