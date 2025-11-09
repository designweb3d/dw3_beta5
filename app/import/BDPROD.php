<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$LST   = $_POST['LST'];
$sql = "INSERT INTO product 
(id,
stat,
category_id,
category2_id,
category3_id,
supplier_id,
upc,
sku,
name_fr,
name_en,
description_fr,
description_en,
price1,
price2,
tax_prov,
tax_fed,
kg,
height,
width,
depth,
brand,
model,
model_year,
allow_pickup,
web_dsp,
btn_action1,
web_btn_icon,
web_btn_fr,
web_btn_en,
url_action1,
btn_action2,
web_btn2_icon,
web_btn2_fr,
web_btn2_en,
url_action2,
price_text_fr,
price_text_en,
price_suffix_fr,
price_suffix_en,
ship_type,
dsp_inv,
dsp_upc,
dsp_mesure,
dsp_model,
date_modified)
VALUES 
" . $LST ." 
ON DUPLICATE KEY UPDATE 
stat = VALUES(stat),
category_id  = VALUES(category_id),
category2_id  = VALUES(category2_id),
category3_id  = VALUES(category2_id),
supplier_id = VALUES(supplier_id),
upc  = VALUES(upc),
sku= VALUES(sku),
name_fr   = VALUES(name_fr),
name_en  = VALUES(name_en),
description_fr  = VALUES(description_fr),
description_en  = VALUES(description_en),
price1 = VALUES(price1),
price2  = VALUES(price2),
tax_prov  = VALUES(tax_prov),
tax_fed    = VALUES(tax_fed),
kg  = VALUES(kg),
height  = VALUES(height),
width  = VALUES(width),
depth  = VALUES(depth),
brand  = VALUES(brand),
model  = VALUES(model),
model_year  = VALUES(model_year),
allow_pickup  = VALUES(allow_pickup),
web_dsp  = VALUES(web_dsp),
btn_action1  = VALUES(btn_action1),
web_btn_icon  = VALUES(web_btn_icon),
web_btn_fr  = VALUES(web_btn_fr),
web_btn_en  = VALUES(web_btn_en),
url_action1  = VALUES(url_action1),
btn_action2  = VALUES(btn_action2),
web_btn2_icon  = VALUES(web_btn2_icon),
web_btn2_fr  = VALUES(web_btn2_fr),
web_btn2_en  = VALUES(web_btn2_en),
url_action2  = VALUES(url_action2),
price_text_fr = VALUES(price_text_fr),
price_text_en = VALUES(price_text_en  ),
price_suffix_fr = VALUES(price_suffix_fr),
price_suffix_en = VALUES(price_suffix_en),
ship_type = VALUES(ship_type),
dsp_inv = VALUES(dsp_inv),
dsp_upc = VALUES(dsp_upc),
dsp_mesure = VALUES(dsp_mesure),
dsp_model = VALUES(dsp_model),
date_modified = NOW();";
            //die($sql);
	if ($dw3_conn->query($sql) === TRUE) {
	  $inserted_id = $dw3_conn->insert_id;
        if($inserted_id!="" && !file_exists($_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id)){
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id);
        }
        echo "";
	} else {
	  echo "Erreur: ".$dw3_conn->error;
	}
$dw3_conn->close();
?>