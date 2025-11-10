<div style='display:inline-block;width:100%;background-color:#<?php echo $CIE_COLOR6; ?>;margin:0px;height:110%;'>
    <table style='width:100%;text-align:center;max-width:1100px;margin-right:auto;margin-left:auto;table-layout: fixed;border-collapse: collapse;'><tr>
        <td width='*' style='line-height: 150%;text-align:left;vertical-align:middle;color:#<?php echo $CIE_COLOR7; ?>;'><span style='margin:15px;'><b>
        <?php if($USER_LANG == "FR"){ 
                echo "Vous souhaitez nous rencontrer? Réservez votre rendez-vous, c’est simple et rapide!";
            }else{
                echo "Do you want to meet us? Book your appointment, it’s quick and easy!";
            }?>
        </b></span></td>
        <td width='100' style='vertical-align:middle;'><button onclick='window.open("/pub/page/contact3","_self")' style='padding:10px 25px;float:right;margin:20px;'><?php if($USER_LANG == "FR"){ echo "Réserver"; } else {echo "Book";} ?></button></td>
    </tr></table>
</div>