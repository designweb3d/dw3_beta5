<?php
$CIE_GRAB_POURCENT = "0";
$CIE_GRAB_AMOUNT = "0";
$CIE_DFT_ADR1 = "0";
$CIE_DFT_ADR2 = "0";
$CIE_DFT_ADR3 = "0"; 
$CIE_LOC_TITLE_FR = "Magasin préféré";
$CIE_LOC_TITLE_EN = "Favorite store";
$CIE_SQUARE_APP = "";
$CIE_SQUARE_DEV = "";
$CIE_SQUARE_MODE = "DEV";
$CIE_COLOR5 = "#ffffff";
//$GLOBALS["x"] = 100;

    $sql = "SELECT * FROM config WHERE kind = 'CIE'";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($row["code"] == "TITRE")			{$CIE_TITRE = trim($row["text1"]);
			} else if ($row["code"] == "NOM")		{$CIE_NOM = trim($row["text1"]);$CIE_DOUV = trim($row["text3"]);$MAG_INTERAC = trim($row["text4"]);	
			} else if ($row["code"] == "NOM_HTML")		{$CIE_NOM_HTML = trim($row["text1"]);	
			} else if ($row["code"] == "THEME")	{$CIE_THEME = trim($row["text1"]); //css theme	
			} else if ($row["code"] == "HOME")	{$CIE_HOME = trim($row["text1"]);$CIE_CART_ACT = trim($row["text2"]);$CIE_CART_API = trim($row["text3"]);
			} else if ($row["code"] == "TYPE")	{$CIE_TYPE = trim($row["text1"]);
			} else if ($row["code"] == "CAT")		{$CIE_CAT = trim($row["text1"]);
			} else if ($row["code"] == "EML1")	{$CIE_EML1 = trim($row["text1"]);$CIE_EML1PW = trim($row["text2"]);			
			} else if ($row["code"] == "EML2")	{$CIE_EML2 = trim($row["text1"]);$CIE_EML2PW = trim($row["text2"]);		
			} else if ($row["code"] == "EML3")	{$CIE_EML3 = trim($row["text1"]);$CIE_EML3PW = trim($row["text2"]);
			} else if ($row["code"] == "EML4")	{$CIE_EML4 = trim($row["text1"]);$CIE_EML4PW = trim($row["text2"]);	
			} else if ($row["code"] == "LOGO1")	{$CIE_LOGO1 = trim($row["text1"]);
			} else if ($row["code"] == "LOGO2")	{$CIE_LOGO2 = trim($row["text1"]);
			} else if ($row["code"] == "LOGO3")	{$CIE_LOGO3 = trim($row["text1"]);
			} else if ($row["code"] == "LOGO4")	{$CIE_LOGO4 = trim($row["text1"]);
			} else if ($row["code"] == "LOGO5")	{$CIE_LOGO5 = trim($row["text1"]);
			} else if ($row["code"] == "BG1")	{$CIE_BG1 = trim($row["text1"]);
			} else if ($row["code"] == "BG2")	{$CIE_BG2 = trim($row["text1"]);
			} else if ($row["code"] == "BG3")	{$CIE_BG3 = trim($row["text1"]);
			} else if ($row["code"] == "BG4")	{$CIE_BG4 = trim($row["text1"]);$CIE_BG4_PAD = trim($row["text2"]); 
			} else if ($row["code"] == "BG5")	{$CIE_BG5 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR1")	{$CIE_COLOR1 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR1_2")	{$CIE_COLOR1_2 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR1_3")	{$CIE_COLOR1_3 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR2")	{$CIE_COLOR2 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR3")	{$CIE_COLOR3 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR4")	{$CIE_COLOR4 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR5")	{$CIE_COLOR5 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR0")	{$CIE_COLOR0 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR0_1")	{$CIE_COLOR0_1 = trim($row["text1"]);
			} else if ($row["code"] == "COLOR6")	{$CIE_COLOR6 = trim($row["text1"]);$CIE_COLOR6_2 = trim($row["text2"]);
			} else if ($row["code"] == "COLOR7")	{$CIE_COLOR7 = trim($row["text1"]);$CIE_COLOR7_2 = trim($row["text2"]);$CIE_COLOR7_3 = trim($row["text3"]);$CIE_COLOR7_4 = trim($row["text4"]);
			} else if ($row["code"] == "COLOR8")	{$CIE_COLOR8 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8_2")	{$CIE_COLOR8_2 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8_3")	{$CIE_COLOR8_3 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8_4")	{$CIE_COLOR8_4 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8_3S")	{$CIE_COLOR8_3S = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8_4S")	{$CIE_COLOR8_4S = trim($row["text1"]);
			} else if ($row["code"] == "COLOR9")	{$CIE_COLOR9 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR10")	{$CIE_COLOR10 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR11")	{$CIE_COLOR11_1 = trim($row["text1"]);$CIE_COLOR11_2 = trim($row["text2"]);$CIE_COLOR11_3 = trim($row["text3"]);
            } else if ($row["code"] == "LOAD")	    {$CIE_LOAD = trim($row["text1"]);
			} else if ($row["code"] == "FADE")	    {$CIE_FADE = trim($row["text1"]);
			} else if ($row["code"] == "FRAME")	    {$CIE_FRAME = trim($row["text1"]);
			} else if ($row["code"] == "BTN_RADIUS")	    {$CIE_BTN_RADIUS = trim($row["text1"]);
			} else if ($row["code"] == "BTN_SHADOW")	    {$CIE_BTN_SHADOW = trim($row["text1"]);
			} else if ($row["code"] == "BTN_BORDER")	    {$CIE_BTN_BORDER = trim($row["text1"]);
			} else if ($row["code"] == "FONT1")	    {$CIE_FONT1 = trim($row["text1"]);
			} else if ($row["code"] == "FONT2")	    {$CIE_FONT2 = trim($row["text1"]);
			} else if ($row["code"] == "FONT3") 	{$CIE_FONT3 = trim($row["text1"]);
			} else if ($row["code"] == "FONT4") 	{$CIE_FONT4 = trim($row["text1"]);
			} else if ($row["code"] == "ADR1")	{$CIE_ADR1 = trim($row["text1"]); 
			} else if ($row["code"] == "ADR2")	{$CIE_ADR2 = trim($row["text1"]); 
			} else if ($row["code"] == "DFT_ADR1")	{$CIE_DFT_ADR1 = trim($row["text1"]); //location fct dft
			} else if ($row["code"] == "DFT_ADR2")	{$CIE_DFT_ADR2 = trim($row["text1"]); //location exped dft
			} else if ($row["code"] == "DFT_ADR3")	{$CIE_DFT_ADR3 = trim($row["text1"]);$CIE_LOC_TITLE_FR = trim($row["text2"]);$CIE_LOC_TITLE_EN = trim($row["text3"]); //location pickup dft, titre magasin préféré
			} else if ($row["code"] == "TEL1")	{$CIE_TEL1 = trim($row["text1"]);
			} else if ($row["code"] == "TEL2")	{$CIE_TEL2 = trim($row["text1"]);
			} else if ($row["code"] == "TX_YT")	{$TPS_YT = trim($row["text1"]);$TVP_YT = trim($row["text2"]);$TVH_YT = trim($row["text3"]);			
			} else if ($row["code"] == "TX_QC")	{$TPS_QC = trim($row["text1"]);$TVP_QC = trim($row["text2"]);$TVH_QC = trim($row["text3"]);			
			} else if ($row["code"] == "TX_SK")	{$TPS_SK = trim($row["text1"]);$TVP_SK = trim($row["text2"]);$TVH_SK = trim($row["text3"]);			
			} else if ($row["code"] == "TX_PE")	{$TPS_PE = trim($row["text1"]);$TVP_PE = trim($row["text2"]);$TVH_PE = trim($row["text3"]);			
			} else if ($row["code"] == "TX_ON")	{$TPS_ON = trim($row["text1"]);$TVP_ON = trim($row["text2"]);$TVH_ON = trim($row["text3"]);			
			} else if ($row["code"] == "TX_MB")	{$TPS_MB = trim($row["text1"]);$TVP_MB = trim($row["text2"]);$TVH_MB = trim($row["text3"]);			
			} else if ($row["code"] == "TX_NU")	{$TPS_NU = trim($row["text1"]);$TVP_NU = trim($row["text2"]);$TVH_NU = trim($row["text3"]);			
			} else if ($row["code"] == "TX_NL")	{$TPS_NL = trim($row["text1"]);$TVP_NL = trim($row["text2"]);$TVH_NL = trim($row["text3"]);			
			} else if ($row["code"] == "TX_NS")	{$TPS_NS = trim($row["text1"]);$TVP_NS = trim($row["text2"]);$TVH_NS = trim($row["text3"]);			
			} else if ($row["code"] == "TX_NT")	{$TPS_NT = trim($row["text1"]);$TVP_NT = trim($row["text2"]);$TVH_NT = trim($row["text3"]);			
			} else if ($row["code"] == "TX_NB")	{$TPS_NB = trim($row["text1"]);$TVP_NB = trim($row["text2"]);$TVH_NB = trim($row["text3"]);			
			} else if ($row["code"] == "TX_BC")	{$TPS_BC = trim($row["text1"]);$TVP_BC = trim($row["text2"]);$TVH_BC = trim($row["text3"]);			
			} else if ($row["code"] == "TX_AB")	{$TPS_AB = trim($row["text1"]);$TVP_AB = trim($row["text2"]);$TVH_AB = trim($row["text3"]);			
			} else if ($row["code"] == "TPS")		{$CIE_TPS = trim($row["text1"]);
			} else if ($row["code"] == "TVQ")		{$CIE_TVQ = trim($row["text1"]);
			} else if ($row["code"] == "NEQ")		{$CIE_NEQ = trim($row["text1"]);
			} else if ($row["code"] == "NE")		{$CIE_NE = trim($row["text1"]);	
			} else if ($row["code"] == "RBQ")		{$CIE_RBQ = trim($row["text1"]);
			} else if ($row["code"] == "VILLE")		{$CIE_VILLE = trim($row["text1"]);
			} else if ($row["code"] == "PROV")		{$CIE_PROV = trim($row["text1"]);
			} else if ($row["code"] == "PAYS")		{$CIE_PAYS = trim($row["text1"]);			
            } else if ($row["code"] == "CP")	{$CIE_CP = trim($row["text1"]);				
			} else if ($row["code"] == "VILLE_ID")		{$CIE_VILLE_ID = trim($row["text1"]);
			} else if ($row["code"] == "PROV_ID")		{$CIE_PROV_ID = trim($row["text1"]);
			} else if ($row["code"] == "PAYS_ID")		{$CIE_PAYS_ID = trim($row["text1"]);
			} else if ($row["code"] == "SQUARE_KEY")		{$CIE_SQUARE_KEY = trim($row["text1"]);$CIE_SQUARE_DEV = trim($row["text2"]);$CIE_SQUARE_MODE = trim($row["text3"]);$CIE_SQUARE_APP = trim($row["text4"]);
			} else if ($row["code"] == "DATAIA_KEY")		{$CIE_DATAIA_KEY = trim($row["text1"]);
			} else if ($row["code"] == "DOORDASH_DEV")		{$CIE_DOORDASH_DEV = trim($row["text1"]);
			} else if ($row["code"] == "DOORDASH_KEY")		{$CIE_DOORDASH_KEY = trim($row["text1"]);
			} else if ($row["code"] == "DOORDASH_SECRET")		{$CIE_DOORDASH_SECRET = trim($row["text1"]);
			} else if ($row["code"] == "DOORDASH_AUTH")		{$CIE_DOORDASH_AUTH = trim($row["text1"]);
			} else if ($row["code"] == "TWILIO_SID")		{$CIE_TWILIO_SID = trim($row["text1"]);	
			} else if ($row["code"] == "TWILIO_AUTH")		{$CIE_TWILIO_AUTH = trim($row["text1"]);
			} else if ($row["code"] == "TWILIO_SENDER")		{$CIE_TWILIO_SENDER = trim($row["text1"]);
			} else if ($row["code"] == "SMS_KEY")		{$CIE_SMS_KEY = trim($row["text1"]);
			} else if ($row["code"] == "LIVAR_KEY")		{$CIE_LIVAR_KEY = trim($row["text1"]);$CIE_LIVAR_DEV = trim($row["text2"]);
			} else if ($row["code"] == "LIVAR_MODE")		{$CIE_LIVAR_MODE = trim($row["text1"]);
			} else if ($row["code"] == "PAYPAL_KEY")		{$CIE_PAYPAL_USER = trim($row["text1"]);$CIE_PAYPAL_USER_DEV = trim($row["text2"]);$CIE_PAYPAL_MODE = trim($row["text3"]);
			//} else if ($row["code"] == "PAYPAL_MODE")		{$CIE_PAYPAL_MODE = trim($row["text1"]);$CIE_PAYPAL_USER = trim($row["text2"]);$CIE_PAYPAL_PW = trim($row["text3"]);
			} else if ($row["code"] == "STRIPE_KEY")		{$CIE_STRIPE_KEY = trim($row["text1"]);$CIE_STRIPE_TKEY = trim($row["text2"]);$CIE_STRIPE_MODE = trim($row["text3"]);
			} else if ($row["code"] == "STRIPE_SECRET")		{$CIE_STRIPE_SECRET = trim($row["text1"]);$CIE_STRIPE_TSECRET = trim($row["text2"]);
			} else if ($row["code"] == "SMS_SENDER")		{$CIE_SMS_SENDER = trim($row["text1"]);
			} else if ($row["code"] == "POSTE_USER")		{$CIE_POSTE_USER = trim($row["text1"]);			
			} else if ($row["code"] == "POSTE_PW")		{$CIE_POSTE_PW = trim($row["text1"]);			
			} else if ($row["code"] == "POSTE_KEY")		{$CIE_POSTE_KEY = trim($row["text1"]);			
			} else if ($row["code"] == "POSTE_MODE")		{$CIE_POSTE_MODE = trim($row["text1"]);			
			} else if ($row["code"] == "GANALYTICS")		{$CIE_GANALYTICS = trim($row["text1"]);			
			} else if ($row["code"] == "GEMINI_KEY")		{$CIE_GEMINI_KEY = trim($row["text1"]);			
			} else if ($row["code"] == "GMAP_KEY")		{$CIE_GMAP_KEY = trim($row["text1"]);			
			} else if ($row["code"] == "GMAP_MAP")		{$CIE_GMAP_MAP = trim($row["text1"]);	
			} else if ($row["code"] == "GOOGLE_MAP")		{$CIE_GOOGLE_MAP = trim($row["text1"]);	
            } else if ($row["code"] == "G_ID")		{$CIE_G_ID = trim($row["text1"]);			
            } else if ($row["code"] == "G_SECRET")		{$CIE_G_SECRET = trim($row["text1"]);			
            } else if ($row["code"] == "G_IMG")		{$CIE_G_IMG = trim($row["text1"]);			
			} else if ($row["code"] == "DEEPL")		{$CIE_DEEPL_KEY = trim($row["text1"]);			
			} else if ($row["code"] == "GPT_KEY")		{$CIE_GPT_KEY = trim($row["text1"]);					
			} else if ($row["code"] == "GROK_KEY")		{$CIE_GROK_KEY = trim($row["text1"]);					
			} else if ($row["code"] == "SCHAT_KEY")		{$CIE_SCHAT_KEY = trim($row["text1"]);$CIE_SCHAT_KEY1 = trim($row["text2"]);$CIE_SCHAT_KEY2 = trim($row["text3"]);	$CIE_SCHAT_ACTIVE = trim($row["text4"]);				
            } else if ($row["code"] == "RS_IG")		{$CIE_IG = trim($row["text1"]);
			} else if ($row["code"] == "RS_FB")		{$CIE_FB = trim($row["text1"]);	
			} else if ($row["code"] == "ADR_PUB")		{$CIE_ADR_PUB = trim($row["text1"]);
			} else if ($row["code"] == "ADR_PUB2")		{$CIE_ADR_PUB2 = trim($row["text1"]);
            } else if ($row["code"] == "TRANSPORT")		{$CIE_TRANSPORT = trim($row["text1"]);		
            } else if ($row["code"] == "TRANSPORT_PRICE")		{$CIE_TRANSPORT_PRICE = trim($row["text1"]);$CIE_HIDE_PRICE = trim($row["text2"]);		
            } else if ($row["code"] == "FREE_MIN")		{$CIE_FREE_MIN = trim($row["text1"]);$CIE_PICK_CAL= trim($row["text2"]);$CIE_PK_F1 = trim($row["text3"]);$CIE_PK_F2 = trim($row["text4"]);		
			} else if ($row["code"] == "PROTECTOR")		{$CIE_PROTECTOR = trim($row["text1"]);	
            } else if ($row["code"] == "OPEN_JFR1")		{$CIE_OPEN_J0_FR = trim($row["text1"]);$CIE_OPEN_J1_FR = trim($row["text2"]);$CIE_OPEN_J2_FR = trim($row["text3"]);$CIE_OPEN_J3_FR = trim($row["text4"]);		
            } else if ($row["code"] == "OPEN_JFR2")		{$CIE_OPEN_J4_FR = trim($row["text1"]);$CIE_OPEN_J5_FR = trim($row["text2"]);$CIE_OPEN_J6_FR = trim($row["text3"]);		
            } else if ($row["code"] == "OPEN_JEN1")		{$CIE_OPEN_J0_EN = trim($row["text1"]);$CIE_OPEN_J1_EN = trim($row["text2"]);$CIE_OPEN_J2_EN = trim($row["text3"]);$CIE_OPEN_J3_EN = trim($row["text4"]);		
            } else if ($row["code"] == "OPEN_JEN2")		{$CIE_OPEN_J4_EN = trim($row["text1"]);$CIE_OPEN_J5_EN = trim($row["text2"]);$CIE_OPEN_J6_EN = trim($row["text3"]);		
            } else if ($row["code"] == "OPEN_J0")		{$CIE_OPEN_J0_H1 = trim($row["text1"]);$CIE_OPEN_J0_H2 = trim($row["text2"]);$CIE_OPEN_J0_H3 = trim($row["text3"]);$CIE_OPEN_J0_H4 = trim($row["text4"]);		
            } else if ($row["code"] == "OPEN_J1")		{$CIE_OPEN_J1_H1 = trim($row["text1"]);$CIE_OPEN_J1_H2 = trim($row["text2"]);$CIE_OPEN_J1_H3 = trim($row["text3"]);$CIE_OPEN_J1_H4 = trim($row["text4"]);		
            } else if ($row["code"] == "OPEN_J2")		{$CIE_OPEN_J2_H1 = trim($row["text1"]);$CIE_OPEN_J2_H2 = trim($row["text2"]);$CIE_OPEN_J2_H3 = trim($row["text3"]);$CIE_OPEN_J2_H4 = trim($row["text4"]);		
            } else if ($row["code"] == "OPEN_J3")		{$CIE_OPEN_J3_H1 = trim($row["text1"]);$CIE_OPEN_J3_H2 = trim($row["text2"]);$CIE_OPEN_J3_H3 = trim($row["text3"]);$CIE_OPEN_J3_H4 = trim($row["text4"]);		
            } else if ($row["code"] == "OPEN_J4")		{$CIE_OPEN_J4_H1 = trim($row["text1"]);$CIE_OPEN_J4_H2 = trim($row["text2"]);$CIE_OPEN_J4_H3 = trim($row["text3"]);$CIE_OPEN_J4_H4 = trim($row["text4"]);		
            } else if ($row["code"] == "OPEN_J5")		{$CIE_OPEN_J5_H1 = trim($row["text1"]);$CIE_OPEN_J5_H2 = trim($row["text2"]);$CIE_OPEN_J5_H3 = trim($row["text3"]);$CIE_OPEN_J5_H4 = trim($row["text4"]);		
            } else if ($row["code"] == "OPEN_J6")		{$CIE_OPEN_J6_H1 = trim($row["text1"]);$CIE_OPEN_J6_H2 = trim($row["text2"]);$CIE_OPEN_J6_H3 = trim($row["text3"]);$CIE_OPEN_J6_H4 = trim($row["text4"]);		
            } else if ($row["code"] == "GRAB")		{$CIE_GRAB = trim($row["text1"]);$CIE_GRAB_POURCENT = trim($row["text2"]);$CIE_GRAB_AMOUNT = trim($row["text3"]);$CIE_DIST_AD = trim($row["text4"]);		
            } else if ($row["code"] == "INVOICE_NOTE")		{$CIE_INVOICE_NOTE = trim($row["text1"]);		
            } else if ($row["code"] == "DTLVDU")		{$CIE_LV_F1 = trim($row["text1"]);	$CIE_LV_F2 = trim($row["text2"]); $CIE_DU_F1 = trim($row["text3"]);	$CIE_DU_F2 = trim($row["text4"]);			
            } else if ($row["code"] == "COOKIE_MSG")		{$CIE_COOKIE_MSG = trim($row["text1"]);	$CIE_COOKIE_MSG_EN = trim($row["text2"]);	$CIE_COOKIES_IMG = trim($row["text3"]);		

			}
		}
        $CIE_ADR = trim($CIE_ADR1 . " " .$CIE_ADR2). ", " .$CIE_VILLE. ", " .$CIE_PROV. " " .$CIE_PAYS. " " .$CIE_CP;
	}
    if (trim($CIE_GRAB_POURCENT) == ""){$CIE_GRAB_POURCENT = "0";}
    if (trim($CIE_GRAB_AMOUNT) == ""){$CIE_GRAB_AMOUNT = "0";}
    
    $sql = "SELECT * FROM location ORDER BY id ASC LIMIT 1";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $CIE_LNG = $row["longitude"];			
            $CIE_LAT = $row["latitude"];			
        }
        if ($CIE_LNG == "" || $CIE_LAT == ""){
            $CIE_LNG = 45;			
            $CIE_LAT = -73;
        }
    }else{
        $CIE_LNG = 45;			
        $CIE_LAT = -73;	
    }

//STRUCTURE DU SITE index/pages/sections
$sql = "SELECT *
FROM config
WHERE kind = 'INDEX'";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row["code"] == "HEADER"){
            $INDEX_HEADER = trim($row["text1"]);
            $INDEX_BLOCK_DEBUG = trim($row["text2"]);
        } else if ($row["code"] == "FOOTER"){	
            $INDEX_FOOTER = trim($row["text1"]);	
            $INDEX_NEWS = trim($row["text2"]);			
        } else if ($row["code"] == "PERSO1"){	
            $INDEX_PERSO1= trim($row["text1"]);				
        } else if ($row["code"] == "INDEX_LANG"){	
            $INDEX_LANG = trim($row["text1"]);				
            $LOGIN_BTN_CLASS = trim($row["text2"]);				
        } else if ($row["code"] == "INDEX_DSP_LANG"){	
            $INDEX_DSP_LANG= trim($row["text1"]);				
            $INDEX_DSP_SIGNIN= trim($row["text2"]);				
        } else if ($row["code"] == "INDEX_TITLE_FR"){	
            $INDEX_TITLE_FR= trim($row["text1"]);				
        } else if ($row["code"] == "INDEX_TITLE_EN"){	
            $INDEX_TITLE_EN= trim($row["text1"]);				
        } else if ($row["code"] == "INDEX_TOP_FR"){	
            $INDEX_TOP_FR= trim($row["text1"]);				
            $INDEX_POPUP_FR= trim($row["text2"]);				
        } else if ($row["code"] == "INDEX_TOP_EN"){	
            $INDEX_TOP_EN= trim($row["text1"]);				
            $INDEX_POPUP_EN= trim($row["text2"]);				
        } else if ($row["code"] == "INDEX_META_DESC"){	
            $INDEX_META_DESC= trim($row["text1"]);				
        } else if ($row["code"] == "INDEX_META_KEYW"){	
            $INDEX_META_KEYW= trim($row["text1"]);				
        } else if ($row["code"] == "CART"){	
            $INDEX_CART = trim($row["text1"]);				
            $INDEX_WISH = trim($row["text2"]);	
        } else if ($row["code"] == "FOOT_MARGIN"){	
            $FOOT_MARGIN = trim($row["text1"]);	
            $INDEX_DSP_SUPPLIER = trim($row["text2"]);		
        } else if ($row["code"] == "SCENE"){	
            $INDEX_SCENE = trim($row["text1"]);			
            $INDEX_SEARCH = trim($row["text2"]);			
        } else if ($row["code"] == "FACEBOOK"){	
            $INDEX_FACEBOOK = trim($row["text1"]);				
        } else if ($row["code"] == "TWITTER"){	
            $INDEX_TWITTER = trim($row["text1"]);				
        } else if ($row["code"] == "INSTAGRAM"){	
            $INDEX_INSTAGRAM = trim($row["text1"]);				
        } else if ($row["code"] == "LINKEDIN"){	
            $INDEX_LINKEDIN = trim($row["text1"]);				
        } else if ($row["code"] == "SNAPCHAT"){	
            $INDEX_SNAPCHAT = trim($row["text1"]);				
        } else if ($row["code"] == "TIKTOK"){	
            $INDEX_TIKTOK = trim($row["text1"]);				
        } else if ($row["code"] == "YOUTUBE"){	
            $INDEX_YOUTUBE = trim($row["text1"]);				
        } else if ($row["code"] == "PINTEREST"){	
            $INDEX_PINTEREST = trim($row["text1"]);	
        } else if ($row["code"] == "TOTAL_VISITED"){	
            $INDEX_VISITED = trim($row["text1"]);				
        } else if ($row["code"] == "COUNTER1"){	
            $COUNTER1_FR = trim($row["text1"]);			
            $COUNTER1_EN = trim($row["text2"]);			
            $COUNTER1_VAL = trim($row["text3"]);			
            $COUNTER1_ICON = trim($row["text4"]);			
        } else if ($row["code"] == "COUNTER2"){	
            $COUNTER2_FR = trim($row["text1"]);			
            $COUNTER2_EN = trim($row["text2"]);			
            $COUNTER2_VAL = trim($row["text3"]);			
            $COUNTER2_ICON = trim($row["text4"]);			
        } else if ($row["code"] == "COUNTER3"){	
            $COUNTER3_FR = trim($row["text1"]);			
            $COUNTER3_EN = trim($row["text2"]);			
            $COUNTER3_VAL = trim($row["text3"]);			
            $COUNTER3_ICON = trim($row["text4"]);	
        }
    }
}
?>