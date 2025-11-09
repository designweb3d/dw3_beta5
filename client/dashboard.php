<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$STRIPE_RESULT = $_GET["STRIPE_RESULT"]??''; 
$STRIPE_FROM = $_GET["STRIPE_FROM"]??'';
$SQUARE_RESULT = $_GET["SQUARE_RESULT"]??''; 
$SQUARE_FROM = $_GET["SQUARE_FROM"]??'';
$PAYPAL_RESULT = $_GET["PAYPAL_RESULT"]??''; 
$PAYPAL_FROM = $_GET["PAYPAL_FROM"]??'';

//STRUCTURE DU DASHBOARD CLIENT
$sql = "SELECT * FROM config WHERE kind = 'INDEX' AND code = 'DASHBOARD_DSP';";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $DASH_PROFIL    = trim(substr($row["text1"],0,1));				
        $DASH_MARKET    = trim(substr($row["text1"],1,1));				
        $DASH_CART      = trim(substr($row["text1"],2,1));				
        $DASH_INVOICE   = trim(substr($row["text1"],3,1));				
        $DASH_ORDER     = trim(substr($row["text1"],4,1));				
        $DASH_RDV       = trim(substr($row["text1"],5,1));				
        $DASH_HIST      = trim(substr($row["text1"],6,1));				
        $DASH_DOC       = trim(substr($row["text1"],7,1));				
        $DASH_PROMO     = trim(substr($row["text1"],8,1));				
        $DASH_COOKIES   = trim(substr($row["text1"],9,1));				
        $DASH_PHONE     = trim(substr($row["text1"],10,1));				
        $DASH_EML       = trim(substr($row["text1"],11,1));				
        $DASH_PRIVACY   = trim(substr($row["text1"],12,1));				
        $DASH_LICENSE   = trim(substr($row["text1"],13,1));				
        $DASH_COMPLAINT = trim(substr($row["text1"],14,1));				
        $DASH_END       = trim(substr($row["text1"],15,1));				
        $DASH_RETURN    = trim(substr($row["text1"],16,1));				
        $DASH_SUBSCRIBE = trim(substr($row["text1"],17,1));				
    }
} else {
	$DASH_PROFIL = "1";				
	$DASH_MARKET = "0";				
	$DASH_CART = "0";				
	$DASH_INVOICE = "1";				
	$DASH_ORDER = "1";				
	$DASH_RDV = "1";				
	$DASH_HIST = "1";				
	$DASH_DOC = "0";				
	$DASH_PROMO = "0";				
	$DASH_COOKIES = "1";				
	$DASH_PHONE = "1";				
	$DASH_EML = "1";				
	$DASH_PRIVACY = "1";				
	$DASH_LICENSE = "1";				
	$DASH_COMPLAINT = "0";				
	$DASH_END = "0";
	$DASH_SUBSCRIBE = "0";
}
if ($CIE_DFT_ADR2 !=""){
    $location_id = $CIE_DFT_ADR2; //location exped dft
} else {
    $location_id = "1";
}
foreach ($_COOKIE as $cookie_key=>$val) {
    if ($cookie_key == "STORE"){
        $location_id = $val;
    }
}

$sql2 = "SELECT * FROM location WHERE id = '" .  $location_id . "'";
$result2 = mysqli_query($dw3_conn, $sql2);
$data2 = mysqli_fetch_assoc($result2);
if (isset($data2["id"])){
    $location_adress = $data2["adr1"]." ".$data2["city"]." ".$data2["postal_code"];
    $province_tx = $data2["province"];
}

if(isset($_COOKIE["DEVICE"])) { 
    if ($_COOKIE["DEVICE"] != "") {
        $USER_DEVICE = $_COOKIE["DEVICE"]; 
    } else {
        $USER_DEVICE = dw3_make_key(64); 
        $cookie_name = "DEVICE";
        $cookie_value = $USER_DEVICE;
        $cookie_domain = $_SERVER["SERVER_NAME"];
        setcookie($cookie_name, $cookie_value, [
            'expires' => time() + 34560000,
            'path' => '/',
            'domain' => $cookie_domain,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None',
        ]);
    }
} else {
    $USER_DEVICE = dw3_make_key(64);
    $cookie_name = "DEVICE";
    $cookie_value = $USER_DEVICE;
    $cookie_domain = $_SERVER["SERVER_NAME"];
    setcookie($cookie_name, $cookie_value, [
        'expires' => time() + 34560000,
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None',
    ]);
}

?>
<!DOCTYPE html><html lang="<?php if ($USER_LANG == "FR"){echo "fr";} else{echo "en";} ?>"><head><meta charset="utf-8">
<title>Espace Client - <?php echo $CIE_NOM; ?></title>
    <meta name="robots" content="noindex">
	<script src="https://d3js.org/d3.v7.min.js"></script>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<link rel="icon" type="image/png" href="/pub/img/favicon.ico" />
	<meta name="application-name" content="<?php echo $CIE_NOM; ?>"/>
	<meta name="msapplication-TileColor" content="#FFFFFF" />
	<meta name="msapplication-TileImage" content="favicon.svg" />
    <script src="https://js.stripe.com/v3/"></script>
<style> 
<?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/main.css.php'; ?>
        .menu{
            cursor: pointer;
            text-align:right;
            font-size:17px;
        }
        .menu_container {        
            position:fixed;
            top:50px;
            right:0px;
            opacity:1;
            height: auto;
            width:110px;
            transition: 0.7s;
            border-radius:3px;
            overflow:hidden;
            background-color: #<?php echo $CIE_COLOR3; ?>;
            transform: translate(-20px,-275px) scale3d(0,0,0);
        }
        .menu_container button {
            background:#<?php echo $CIE_COLOR1; ?>;
            border:1px solid #<?php echo $CIE_COLOR2; ?>;
            border-radius:5px;
            color:#<?php echo $CIE_COLOR2; ?>;
            font-weight:bold;
            width:100px;
            padding:10px;
            filter: drop-shadow(1px 1px 1px #<?php echo $CIE_COLOR2; ?>);
            cursor: pointer;
        } 
        .menu_container button:hover {
            text-shadow: -2px 2px #000;
        } 
        .menu_bar1, .menu_bar2, .menu_bar3 {
            width: 45px;
            height: 6px;
            background-color: #<?php echo $CIE_COLOR2; ?>;
            margin: 6px 0;
            transition: 0.4s;
            border-radius:3px;
            filter: drop-shadow(1px 1px 1px #222);
        }
        .change .menu_bar1 {
            transform: translate(0, 24px);
            opacity: 0;
        }
        .change .menu_bar2 {
            opacity: 0;
            transform: translate(0, 12px);
        }
        .change .menu_bar3 {
            transform: translate(0, 6px);
            
        }
        .change2 {
            transform: initial;
        }

        /* date-time pick */
        .calendar {
        /* width: 350px; */
            margin-top:40px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }
        .calendar-header button {
            background-color: transparent;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
        }
        #month-year {
            font-size: 1.2em;
            font-weight: bold;
        }
        .calendar-weekdays, .calendar-dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }
        .calendar-weekdays div, .calendar-dates div {
            text-align: center;
            padding: 10px;
        }
        .calendar-weekdays {
            background-color: #eaeef3;
        }
        .calendar-weekdays div {
            font-weight: bold;
        }
        .calendar-dates div {
            border-bottom: 1px solid #eaeef3;
        }
        .valid-day {
            cursor: pointer;
            color:#000;
        }
        .valid-day:hover {
            background-color: #f1f1f1;
        }
        .current-date {
            background-color: var(--dw3_selected_border);
            color: #fff;
            border-radius: 50%;
        }
        .current-date:hover {
            background-color: #fff;
            color: var(--dw3_selected_border);
        }
        .past-date {
            color: #bbb;
            cursor: default;
        }
</style>
</head>
<body style="overflow-y:scroll;overflow-x:hidden;">
<div id='divFADE' onclick="closeMSG();"></div>
<div id='divFADE2'></div>
<div id="divHEAD" style='left:0px;padding:0px;'>
	<table style="width:100%;margin:0px;white-space:nowrap;">
		<tr style="margin:0px;padding:0px;">
            <td style="width:40px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;">
				<a href="https://<?php echo $_SERVER["SERVER_NAME"]; ?>"><button style="margin:2px 0px 0px 2px;padding:7px;border-bottom-left-radius:10px;" class="grey">
				<span class="material-icons">arrow_back</span><?php if ($USER_LANG == "FR"){ echo "Accueil"; }else{echo "Home";}?></button></a>
			 </td>
			<td width="*"><h4 style='text-align:center;'><?php if ($USER_LANG == "FR"){ echo "Espace-Client"; }else{echo "Customer Area";}?></h4></td>
			<td style="width:40px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;">
				<button style="margin:2px 2px 0px 0px;padding:7px;border-bottom-right-radius:10px;" class="grey" onclick="logOUT_CTS();">
				    <span class="material-icons">logout</span><?php if ($USER_LANG == "FR"){ echo "Déconnexion"; }else{echo "Disconnect";}?>
                </button>
			 </td>
		</tr>
	</table>
</div>
<!-- END OF HEADER -->
<div id='dw3_notif_container'></div>
    <div id='dw3_datetime_pick' class='divEDITOR'>
        <div id='dw3_datetime_pick_HEAD' class='dw3_form_head'>
            <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>Date et heure de ramassage</div></h3>
            <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeCALENDAR();'><span class='material-icons'>cancel</span></button>
        </div>
        <div class="calendar">
            <div class="calendar-header">
            <button id="prev-month">‹</button>
            <div id="month-year"></div>
            <button id="next-month">›</button>
            </div>
            <div class="calendar-body">
            <div class="calendar-weekdays">
                <?php 
                    if ($USER_LANG == "FR"){
                        echo "<div>Dim</div>
                        <div>Lun</div>
                        <div>Mar</div>
                        <div>Mer</div>
                        <div>Jeu</div>
                        <div>Ven</div>
                        <div>Sam</div>";
                    } else {
                        echo "<div>Sun</div>
                        <div>Mon</div>
                        <div>Tue</div>
                        <div>Wed</div>
                        <div>Thu</div>
                        <div>Fri</div>
                        <div>Sat</div>";
                    }
                ?>
            </div>
            <div class="calendar-dates">
                <!-- Dates will be populated here -->
            </div>
            </div>
        </div>
        <div id='hours-selection'></div>
    </div>
<!-- PROFIL -->
<h4 onclick="toggleSub('divSub1','up1');" style="display:<?php if ($DASH_PROFIL == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;margin-top:46px;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">local_offer</span> <?php if ($USER_LANG == "FR"){ if ($USER_TYPE == "RETAILER"){echo "Mon profil détaillant";}else {echo "Mon profil";} }else{if ($USER_TYPE == "RETAILER"){echo "My retailer profil";}else {echo "My profil";}}?><span id='up1' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class="divMAIN" id='divSub1'  style='height:0px;display:none;'>
    <span style='border-radius:20px;background:#eee;color:orange;padding:15px;'><?php if ($USER_LANG == "FR"){ echo "*Champs requis pour les commandes avec livraisons ou paiements par carte de crédit"; }else{echo "*Fields required for orders with shipping or credit card payments";}?></span><br>
    <div class="divBOX"> <?php if ($USER_LANG == "FR"){ echo "Langue";}else{echo "Language";}?>:
        <select name='clLANG' id='clLANG'>
            <option value='FR' <?php if($USER_LANG == "FR"){echo "selected";} ?>>Français</option>
            <option value='EN' <?php if($USER_LANG == "EN"){echo "selected";} ?>>English</option>
        </select>
    </div><br>
    <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Nom d'utilisateur"; }else{echo "Username";}?>:
        <input id="clUSER_NAME" type="text" value="<?php echo $USER_USER_NAME; ?>" onclick="detectCLICK(event,this);">
        <small><?php if ($USER_LANG == "FR"){ echo "Veuillez ne pas entrer d'information personnelle dans votre nom d'utilisateur, car il sera utilisé publiquement si vous commentez un article ou un produit ou pour tout autres intéractions sur les pages publiques du site"; }else{echo "Please do not enter any personal information in your username, as it will be used publicly if you comment on an article or product or for any other interactions on the site's public pages.";}?></small>
    </div><br>
    <br>    
    <div class="divBOX" style='display:none;'>Titre:
        <input id="clPREFIX" type="text" value="<?php echo $USER_PREFIX; ?>" onclick="detectCLICK(event,this);">
    </div>
    <div class="divBOX" style='display:none;'>Prénom:
        <input id='clPRENOM' type="text" value="<?php echo $USER_FIRST_NAME; ?>" onclick="detectCLICK(event,this);">
    </div>
    <div class="divBOX" style='display:none;'>Deuxième prénom:
        <input id='clPRENOM2' type="text" value="<?php echo $USER_MIDDLE_NAME; ?>" onclick="detectCLICK(event,this);">
    </div>
    <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Nom Complet"; }else{echo "Comlplete Name";}?>: <span style='color:orange;'>*</span>
        <input id="clNOM" type="text" value="<?php echo $USER_LAST_NAME; ?>" onclick="detectCLICK(event,this);" style='box-shadow:0px 0px 4px 2px orange;'>
    </div>
    <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Nom de la compagnie"; }else{echo "Company Name";}?>:
        <input id="clCOMPANY" type="text" value="<?php echo $USER_COMPANY; ?>" onclick="detectCLICK(event,this);">
    </div>
    <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Votre site web"; }else{echo "Your web site";}?>:
        <input id="clWEB" type="text" value="<?php echo $USER_WEB; ?>" onclick="detectCLICK(event,this);">
    </div>
    <div class="divBOX" style='display:none;'>Suffix du nom:
        <input id="clSUFFIX" type="text" value="<?php echo $USER_SUFFIX; ?>" onclick="detectCLICK(event,this);">
    </div>
    <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Téléphone"; }else{echo "Phone";}?>: <span style='color:orange;'>*</span>
        <input id='clTEL1' type="text" value="<?php echo $USER_TEL1; ?>" onclick="detectCLICK(event,this);" style='box-shadow:0px 0px 4px 2px orange;'>
    </div>		
    <div class="divBOX"  style='height:0px;display:none;'>Téléphone secondaire:
        <input id='clTEL2' type="text" value="" onclick="detectCLICK(event,this);">
    </div><br>	
    <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Courriel"; }else{echo "Email";}?>: <span style='color:orange;'>*</span>
        <input disabled id='clEML1' type="text" value="<?php echo $USER_EML1; ?>" onclick="detectCLICK(event,this);">
    </div>	
    <div class="divBOX" style='display:none;'>Courriel secondaire: (ne peut pas servir à se connecter)
        <input id='clEML2' type="text" style='height:0px;display:none;' value="" onclick="detectCLICK(event,this);">
    </div>
    <div class="divBOX"><div style='margin-top:5px;display:inline-block;vertical-align:middle;'><?php if ($USER_LANG == "FR"){ echo "Mot de passe"; }else{echo "Password";}?>:</div>
        <button id='btnReset' onclick="resetPW();" style='float:right;vertical-align:middle;'><span class="material-icons">password</span> <?php if ($USER_LANG == "FR"){ echo "Modifier"; }else{echo "Modify";}?></button>
    </div>
    <div class="divBOX" style='<?php if($CIE_SMS_KEY == "" && $CIE_TWILIO_SID == ""){echo "display:none;";} ?>'><label for='cl2Factor'><div style='margin-top:2px;display:inline-block;vertical-align:middle;'><?php if ($USER_LANG == "FR"){ echo "Connexion à 2 facteurs"; }else{echo "2-factor login";}?>:</div></label>
        <input type='checkbox' id='cl2Factor' <?php if($USER_2FACTOR=="1"){echo " checked ";} ?> style='margin:10px;float:right;vertical-align:middle;'>
    </div>
    <div class="divBOX" style='height:0px;display:none;'>Site web:
        <input id='clHOME' type="text" value="" onclick="detectCLICK(event,this);">
    </div>
    <br>
    <div class='divPAGE'> <h2><?php if ($USER_LANG == "FR"){ echo "Adresse de facturation"; }else{echo "Billing address";}?>:</h2>               
        <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Adresse ligne 1"; }else{echo "Address line 1";}?>: <span style='color:orange;'>*</span>
            <input id='clADR1' type="text" value="<?php echo $USER_ADR1; ?>" onclick="detectCLICK(event,this);" style='box-shadow:0px 0px 4px 2px orange;'>
        </div>
        <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Adresse ligne 2"; }else{echo "Address line 2";}?>:
            <input id='clADR2' type="text" value="<?php echo $USER_ADR2; ?>" onclick="detectCLICK(event,this);">
        </div><br>
        <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Ville"; }else{echo "City";}?>: <span style='color:orange;'>*</span>
            <input id='clVILLE' type="text" value="<?php echo $USER_VILLE; ?>" onclick="detectCLICK(event,this);" style='box-shadow:0px 0px 4px 2px orange;'>
        </div>
        <div class="divBOX">Province: <span style='color:orange;'>*</span>
        <?php 
            if ($USER_LANG == "FR"){
                echo "<select id='clPROV'>
                        <option "; if ($USER_PROV == "AB"){echo "selected";} echo " value='AB'>Alberta</option>
                        <option "; if ($USER_PROV == "BC"){echo "selected";} echo " value='BC'>Colombie-Britannique</option>
                        <option "; if ($USER_PROV == "PE"){echo "selected";} echo " value='PE'>Île du Prince-Édouard.</option>
                        <option "; if ($USER_PROV == "MB"){echo "selected";} echo " value='MB'>Manitoba</option>
                        <option "; if ($USER_PROV == "NB"){echo "selected";} echo " value='NB'>Nouveau-Brunswick</option>
                        <option "; if ($USER_PROV == "NS"){echo "selected";} echo " value='NS'>Nouvelle-Écosse</option>
                        <option "; if ($USER_PROV == "NU"){echo "selected";} echo " value='NU'>Nunavut</option>
                        <option "; if ($USER_PROV == "ON"){echo "selected";} echo " value='ON'>Ontario</option>
                        <option "; if ($USER_PROV == "QC"){echo "selected";} echo " value='QC'>Québec</option>
                        <option "; if ($USER_PROV == "SK"){echo "selected";} echo " value='SK'>Saskatchewan</option>
                        <option "; if ($USER_PROV == "NL"){echo "selected";} echo " value='NL'>Terre-Neuve-et-Labrador</option>
                        <option "; if ($USER_PROV == "NT"){echo "selected";} echo " value='NT'>Territoires du Nord-Ouest</option>
                        <option "; if ($USER_PROV == "YT"){echo "selected";} echo " value='YT'>Yukon</option>
                    </select>";
            } else {
                echo "<select id='clPROV'>
                        <option "; if ($USER_PROV == "AB"){echo "selected";} echo " value='AB'>Alberta</option>
                        <option "; if ($USER_PROV == "BC"){echo "selected";} echo " value='BC'>British Columbia</option>
                        <option "; if ($USER_PROV == "MB"){echo "selected";} echo " value='MB'>Manitoba</option>
                        <option "; if ($USER_PROV == "NB"){echo "selected";} echo " value='NB'>New Brunswick</option>
                        <option "; if ($USER_PROV == "NL"){echo "selected";} echo " value='NL'>Newfoundland and Labrador</option>
                        <option "; if ($USER_PROV == "NT"){echo "selected";} echo " value='NT'>Northwest Territories</option>
                        <option "; if ($USER_PROV == "NS"){echo "selected";} echo " value='NS'>Nova Scotia</option>
                        <option "; if ($USER_PROV == "NU"){echo "selected";} echo " value='NU'>Nunavut</option>
                        <option "; if ($USER_PROV == "ON"){echo "selected";} echo " value='ON'>Ontario</option>
                        <option "; if ($USER_PROV == "PE"){echo "selected";} echo " value='PE'>Prince Edward Island</option>
                        <option "; if ($USER_PROV == "QC"){echo "selected";} echo " value='QC'>Québec</option>
                        <option "; if ($USER_PROV == "SK"){echo "selected";} echo " value='SK'>Saskatchewan</option>
                        <option "; if ($USER_PROV == "YT"){echo "selected";} echo " value='YT'>Yukon</option>
                    </select>";
            }
        ?>
        </div><br>
        <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Pays"; }else{echo "Country";}?>: <span style='color:orange;'>*</span>
            <input id='clPAYS' type="text" disabled value="<?php echo $USER_PAYS; ?>" onclick="detectCLICK(event,this);" style='box-shadow:0px 0px 4px 2px orange;'>
        </div>
        <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Code Postal"; }else{echo "Postal code";}?>: <span style='color:orange;'>*</span>
            <input id='clCP' type="text" value="<?php echo $USER_CP; ?>" onclick="detectCLICK(event,this);" style='box-shadow:0px 0px 4px 2px orange;'>
        </div>			
    </div>
    <div class='divPAGE'> <h2><?php if ($USER_LANG == "FR"){ echo "Adresse de livraison"; }else{echo "Shipping address";}?>:</h2><button onclick='copyADR_TO_SH();'><?php if ($USER_LANG == "FR"){ echo "Même adresse que la facturation"; }else{echo "Same address as billing";}?></button><br>             
        <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Adresse ligne 1"; }else{echo "Address line 1";}?>: <span style='color:orange;'>*</span>
            <input id='clADR1_SH' type="text" value="<?php echo $USER_ADR1_SH; ?>" onclick="detectCLICK(event,this);" style='box-shadow:0px 0px 4px 2px orange;'>
        </div>
        <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Adresse ligne 2"; }else{echo "Address line 2";}?>:
            <input id='clADR2_SH' type="text" value="<?php echo $USER_ADR2_SH; ?>" onclick="detectCLICK(event,this);">
        </div><br>
        <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Ville"; }else{echo "City";}?>: <span style='color:orange;'>*</span>
            <input id='clVILLE_SH' type="text" value="<?php echo $USER_VILLE_SH; ?>" onclick="detectCLICK(event,this);" style='box-shadow:0px 0px 4px 2px orange;'>
        </div>
        <div class="divBOX">Province: <span style='color:orange;'>*</span>
            <?php 
            if ($USER_LANG == "FR"){
                echo "<select id='clPROV_SH'>
                        <option "; if ($USER_PROV_SH == "AB"){echo "selected";} echo " value='AB'>Alberta</option>
                        <option "; if ($USER_PROV_SH == "BC"){echo "selected";} echo " value='BC'>Colombie-Britannique</option>
                        <option "; if ($USER_PROV_SH == "PE"){echo "selected";} echo " value='PE'>Île-du-Prince-Édouard.</option>
                        <option "; if ($USER_PROV_SH == "MB"){echo "selected";} echo " value='MB'>Manitoba</option>
                        <option "; if ($USER_PROV_SH == "NB"){echo "selected";} echo " value='NB'>Nouveau-Brunswick</option>
                        <option "; if ($USER_PROV_SH == "NS"){echo "selected";} echo " value='NS'>Nouvelle-Écosse</option>
                        <option "; if ($USER_PROV_SH == "NU"){echo "selected";} echo " value='NU'>Nunavut</option>
                        <option "; if ($USER_PROV_SH == "ON"){echo "selected";} echo " value='ON'>Ontario</option>
                        <option "; if ($USER_PROV_SH == "QC"){echo "selected";} echo " value='QC'>Québec</option>
                        <option "; if ($USER_PROV_SH == "SK"){echo "selected";} echo " value='SK'>Saskatchewan</option>
                        <option "; if ($USER_PROV_SH == "NL"){echo "selected";} echo " value='NL'>Terre-Neuve-et-Labrador</option>
                        <option "; if ($USER_PROV_SH == "NT"){echo "selected";} echo " value='NT'>Territoires du Nord-Ouest</option>
                        <option "; if ($USER_PROV_SH == "YT"){echo "selected";} echo " value='YT'>Yukon</option>
                    </select>";
                } else {
                    echo "<select id='clPROV_SH'>
                            <option "; if ($USER_PROV_SH == "AB"){echo "selected";} echo " value='AB'>Alberta</option>
                            <option "; if ($USER_PROV_SH == "BC"){echo "selected";} echo " value='BC'>British Columbia</option>
                            <option "; if ($USER_PROV_SH == "MB"){echo "selected";} echo " value='MB'>Manitoba</option>
                            <option "; if ($USER_PROV_SH == "NB"){echo "selected";} echo " value='NB'>New Brunswick</option>
                            <option "; if ($USER_PROV_SH == "NL"){echo "selected";} echo " value='NL'>Newfoundland and Labrador</option>
                            <option "; if ($USER_PROV_SH == "NT"){echo "selected";} echo " value='NT'>Northwest Territories</option>
                            <option "; if ($USER_PROV_SH == "NS"){echo "selected";} echo " value='NS'>Nova Scotia</option>
                            <option "; if ($USER_PROV_SH == "NU"){echo "selected";} echo " value='NU'>Nunavut</option>
                            <option "; if ($USER_PROV_SH == "ON"){echo "selected";} echo " value='ON'>Ontario</option>
                            <option "; if ($USER_PROV_SH == "PE"){echo "selected";} echo " value='PE'>Prince Edward Island</option>
                            <option "; if ($USER_PROV_SH == "QC"){echo "selected";} echo " value='QC'>Québec</option>
                            <option "; if ($USER_PROV_SH == "SK"){echo "selected";} echo " value='SK'>Saskatchewan</option>
                            <option "; if ($USER_PROV_SH == "YT"){echo "selected";} echo " value='YT'>Yukon</option>
                        </select>";
                }
            ?>
        </div><br>
        <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Pays"; }else{echo "Country";}?>: <span style='color:orange;'>*</span>
            <input id='clPAYS_SH' disabled type="text" value="<?php echo $USER_PAYS_SH; ?>" onclick="detectCLICK(event,this);" style='box-shadow:0px 0px 4px 2px orange;'>
        </div>
        <div class="divBOX"><?php if ($USER_LANG == "FR"){ echo "Code Postal"; }else{echo "Postal code";}?>: <span style='color:orange;'>*</span>
            <input id='clCP_SH' type="text" value="<?php echo $USER_CP_SH; ?>" onclick="detectCLICK(event,this);" style='box-shadow:0px 0px 4px 2px orange;'>
        </div>			

    </div>
    <br><button onclick="updCLI();"><span class="material-icons">save</span><?php if ($USER_LANG == "FR"){ echo "Sauvegarder"; }else{echo "Save";}?></button>
</div>
<h4 onclick="toggleSub('divSub6','up6');" style="display:<?php if ($DASH_DOC == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">folder_special</span> <?php if ($USER_LANG == "FR"){ echo "Mes Documents"; }else{echo "My Documents";}?> <span id='up6' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div style='display:none;'>
    <form id='frmUPLOAD0' action="upload0.php?KEY=<?php echo $KEY;?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload0" id="fileToUpload0" oninput="document.getElementById('submitUPLOAD0').click();">    
    <input type="submit" value="Upload Image" name="submit" id='submitUPLOAD0'>
    </form>
</div>
<div class="divMAIN" id='divSub6' style='height:0px;display:none;background-color:rgba(0,0,0,0.1);'>
    <?php 
//________________________
// MES DOCUMENTS
//‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾ 

echo "
<div class='divPAGE'>
    <div class='dw3_drop_area' style='height:300px;' ondrop=\"client_upload_file(event)\" ondragover=\"this.style.background='rgba(190,220,180,0.5)'; return false\" ondragleave=\"this.style.background='transparent'; return false\">
        <span class='material-icons' style='font-size:40px;'>cloud_upload</span>
        <div id='drop_header'>Déposez des documents ici pour les téléverser dans votre dossier.</div>
        <span>OU</span><br>";
        if ($USER_LANG == "FR"){ 
            echo "<button class='blue' onclick=\"document.getElementById('fileToUpload0').click();\"><span class='dw3_font'>5</span> Téléverser un fichier</button>";
        } else {
            echo "<button class='blue' onclick=\"document.getElementById('fileToUpload0').click();\"><span class='dw3_font'>5</span> Upload a file</button>";
        }
        echo "<button id='dw3_btn_upload' style='display:none;'>Choisir un ou plusieurs fichiers</button>
        <input type='file' name='dw3_file' id='dw3_file' hidden multiple>
    </div>
</div>
<hr>
<div id='dw3_user_docs'></div>
</div>";
//_____________
// RENDEZ-VOUS
//‾‾‾‾‾‾‾‾‾‾‾‾‾ 

$sql = "SELECT A.id as schedule_id, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name, A.customer_id, CONCAT(B.first_name, ' ',B.middle_name, ' ',B.last_name) as customer_name, A.product_id, C.name_fr as product_name,C.price1 as product_price,C.service_length as service_length,C.inter_length as inter_length, A.start_date as start_date, A.end_date as end_date, A.iso_start as iso_start, A.iso_end as iso_end
FROM schedule_line A
LEFT JOIN customer B ON B.id = A.customer_id
LEFT JOIN product C ON C.id = A.product_id
LEFT JOIN user D ON C.id = A.user_id
WHERE customer_id = '" . $USER . "'  AND A.end_date >= NOW()
ORDER  BY A.start_date";

    $result = $dw3_conn->query($sql);
/*  if ($result->num_rows??0 == 0) {
        echo "<div class='divMAIN' id='divSub9' style='height:0px;display:none;'>";
        echo "<table style='width:100%;border:0;'>";
        echo "<tr><td colspan=5>Aucuns rendez-vous prévus.</td></tr>";
    }else{	
        echo "<div class='divMAIN' id='divSub9'>";
        echo "<table style='width:100%;border:0;'>"; */
    $QTY_ROWS = $result->num_rows??0;
    if ($QTY_ROWS < 1) { ?>
        <h4 onclick="toggleSub('divSub9','up9');" style="display:<?php if ($DASH_RDV == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
            <span class="material-icons">event_available</span> <?php if ($USER_LANG == "FR"){ echo "Mes rendez-vous"; }else{echo "My appointments";}?> <span id='up9' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
        </h4>
        <div class='divMAIN' id='divSub9' style='height:0px;display:none;background-color:rgba(255,255,255,0.8);color:#333;'>
        <div class='divBOX' style='text-align:center;'><?php if ($USER_LANG == "FR"){ echo "Aucun rendez-vous actif trouvé."; }else{echo "No active appointment found.";}?><br><button onclick="window.open('/pub/page/agenda','_self');" style='padding:7px;'><span class='material-icons' style='font-size:16px;'>event_available</span> <?php if ($USER_LANG == "FR"){ echo "Prendre rendez-vous"; }else{echo "Make an appointment";}?></button></div>
    <?php }else{ ?>
        <h4 onclick="toggleSub('divSub9','up9');" style="display:<?php if ($DASH_RDV == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
            <span class="material-icons">event_available</span> <?php if ($USER_LANG == "FR"){ echo "Mes rendez-vous"; }else{echo "My appointments";}?><span id='up9' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_down</span>
        </h4>
        <div class='divMAIN' id='divSub9' style="height: auto; display: display:<?php if ($DASH_RDV == "1"){ echo "inline-block"; }else{echo "none";}?>;;background-color:rgba(255,255,255,0.8);color:#333;">
    <?php 
        echo "<table class='tblDATA'>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . substr($row["start_date"],0,10)  . "<br>" . substr($row["start_date"],11,5)  . "-" . substr($row["end_date"],11,5)  . "</td><td>" . $row["user_name"]  . "<br>" . $row["product_name"]  . "</td><td style='width:25px;'><button onclick='delSchedule(\"" .  $row["schedule_id"]  . "\");' style='padding:7px;'><span class='material-icons' style='font-size:16px;'>backspace</span></button></td></tr>
            <tr><td colspan=3 style='text-align:center;border-bottom:1px solid #777;'>Pour ajouter ce rendez-vous à votre calendrier:<br>
            <a target='_blank' href='https://" . $_SERVER["SERVER_NAME"]  . "/client/schedule_ics.php?KEY=". $KEY ."&ID=". $row["schedule_id"] ."'><button style='padding:7px;'><span class='material-icons' style='font-size:16px;'>event_available</span> Agenda par défault (.ics)</button></a>
            <a target='_blank' href='https://calendar.google.com/calendar/render?action=TEMPLATE&text=Rendez-vous&dates=" . $row["iso_start"] . "/" . $row["iso_end"] . "&details=" . rawurlencode($row["product_name"]) . "&location=" . rawurlencode($CIE_ADR1." ".$CIE_ADR2.", ".$CIE_VILLE.", ".$CIE_CP) . "&ctz=America/New_York'><button style='padding:7px;'><span class='material-icons' style='font-size:16px;'>event_available</span> Google Agenda</button></a>
            </td></tr>";  
            }
        }
        echo "</table></div>";
//______________
// MES ANNONCES
//‾‾‾‾‾‾‾‾‾‾‾‾‾‾
if ($USER_TYPE == "RETAILER" && $CIE_DIST_AD == true){
?>
<h4 onclick="toggleSub('divSub10','up10');" style="display:<?php if ($DASH_MARKET == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
    <span class="material-icons">add_business</span> <?php if ($USER_LANG == "FR"){ echo "Mes annonces"; }else{echo "My classified ads";}?> <span id='up10' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class='divMAIN' id='divSub10' style='height:0px;display:none;background-color:rgba(0,0,0,0.1);'>
    <div class='divBOX' style='display:block;font-size:12px;margin-left:5px;text-align:left;'>
        <span style='width:24px;border-radius:5px;height:12px;background-color:white;border:1px solid green;'></span> Annonces actives<br>
        <span style='width:24px;border-radius:5px;height:12px;background-color:white;border:1px solid red;'></span> Annonces inactives ou quantité disponible = 0<br>
        <b><?php 
            if ($CIE_GRAB_POURCENT != "0" || $CIE_GRAB_AMOUNT != "0"){
                echo $CIE_NOM;
                if ($USER_LANG == "FR"){ echo " conservera "; } else {  echo " will keep "; }
                if ($CIE_GRAB_POURCENT != "0") { echo $CIE_GRAB_POURCENT."%"; }
                if ($CIE_GRAB_POURCENT != "0" && $CIE_GRAB_AMOUNT != "0") { echo " + "; }
                if ($CIE_GRAB_AMOUNT != "0") { echo $CIE_GRAB_AMOUNT."$"; }            
                if ($USER_LANG == "FR"){ echo " du montant payé par le client sur ce site."; } else {  echo " of the amount paid by the customer on this site."; }
            } else {
                if ($USER_LANG == "FR"){ echo $CIE_NOM." ne conserve aucun montant sur les achats fait par les clients sur ce site mais d'autres frais peuvent se retrouver sur votre facture."; } else {  echo $CIE_NOM." does not retain any amount from purchases made by customers on this site but other charges may appear on your invoice."; }
            }
        ?></b>
    </div>
    <div style='max-width:600px;display:inline-block;'><table><tr>
        <td><input type='search' id='rechAD' oninput='getADS(0,ADS_LIMIT)'></td>
        <td width='50'><button onclick='addAD()'><span class="material-icons">add</span></button></td>
    </tr></table></div>
    <div id='divCLASSIFIEDS' style='text-align:center;font-size:0px;'>
    </div>
</div>
<div id="divEDIT_AD" class="divEDITOR"></div>
<div id='divUPLOAD' style='display:none;'>
    <!-- image 1 -->
    <form id='frmUPLOAD7' action="upload.php?KEY=<?php echo $KEY;?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload7" id="fileToUpload7" oninput="document.getElementById('submitUPLOAD7').click();">    
    <input type="text" name="fileName7" id="fileName7" value='0'>
    <input type="submit" value="Upload Image" name="submit" id='submitUPLOAD7'>
    </form>
    <!-- image 2 -->
    <form id='frmUPLOAD8' action="upload2.php?KEY=<?php echo $KEY;?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload8" id="fileToUpload8" oninput="document.getElementById('submitUPLOAD8').click();">    
    <input type="text" name="fileName8" id="fileName8" value='0'>
    <input type="submit" value="Upload Image" name="submit" id='submitUPLOAD8'>
    </form>
    <!-- image 3 -->
    <form id='frmUPLOAD9' action="upload3.php?KEY=<?php echo $KEY;?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload9" id="fileToUpload9" oninput="document.getElementById('submitUPLOAD9').click();">    
    <input type="text" name="fileName9" id="fileName9" value='0'>
    <input type="submit" value="Upload Image" name="submit" id='submitUPLOAD9'>
    </form>
</div>
<?php } 
//_________________________
// MES VENTES SUR LE MARCHÉ
//‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
if ($USER_TYPE == "RETAILER" && $CIE_DIST_AD == true){
?>
<h4 onclick="toggleSub('divSub13','up13');" style="display:<?php if ($DASH_MARKET == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
    <span class="material-icons">business</span> <?php if ($USER_LANG == "FR"){ echo "Mes ventes sur le marché"; }else{echo "My sales on the market";}?> <span id='up13' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class='divMAIN' id='divSub13' style='height:0px;display:none;background-color:rgba(0,0,0,0.1);'>
    <img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>
</div>
<?php } 

if ($CIE_DIST_AD == true && $USER_TYPE != "RETAILER"){
//_______
// MARCHÉ
//‾‾‾‾‾‾‾
   $transport_code = "";
   $coupon_valid = false;
   $coupon_code = "";
   $coupon_amount = "0";
   $coupon_pourcent = "0";
   $coupon_prd = "0";
   $coupon_msg = "Le coupon est expiré.";
   $coupon_saving = 0;
    $ad_string = "";
    foreach ($_COOKIE as $key=>$val)
    {
        if (substr($key, 0, 3) == "AD_" && $val != "0"){
            $ad_string .= ltrim($key,"AD_").",";
        }
        if ($key == "COUPON"){
            $coupon_code = $val;
        }
        if ($key == "TRANSPORT"){
            $transport_code = $val;
        }
    }
    $ad_string = rtrim($ad_string,",");

    //get coupon info
    if ($coupon_code != ""){
        $sql = "SELECT * FROM coupon WHERE trim(code) = '" . trim($coupon_code) . "' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);
        $data = mysqli_fetch_assoc($result);
        if (isset($data["id"])){
            $date_start = new DateTime($data["date_start"]);
            $date_end = new DateTime($data["date_end"]);
            $now = new DateTime();
            if ($date_start > $now){
                $coupon_msg = "Le coupon sera valide le ".substr($data['date_start'],0,10). " à " . substr($data['date_start'],11,8);
            } else if ($date_end < $now){
                $coupon_msg = "Le coupon a expiré le ".substr($data['date_end'],0,10) . " à " . substr($data['date_end'],11,8);
            } else {
                $coupon_valid = true;
                $coupon_msg = "Coupon validé.";
                $coupon_amount = $data['amount_val'];
                $coupon_pourcent = $data['pourcent_val'];
                $coupon_prd = $data['product_id'];
            }
        }
    }

//______________________________
// ACHATS EN COURS SUR LE MARCHÉ
//‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
?>
<h4 onclick="toggleSub('divSub11','up11');" style="display:<?php if ($DASH_MARKET == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
    <span class="material-icons">business</span> <?php if ($USER_LANG == "FR"){ echo "En achat sur le Marché"; }else{echo "Purchasing on the Market";}?> <span id='up11' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class='divMAIN' id='divSub11' style='<?php if ($ad_string != "" && $DASH_MARKET == "1"){echo "height:auto;display:inline-block;";}else{echo "height:0px;display:none;";} ?>background-color:rgba(0,0,0,0.1);'>
        <?php
            if($CIE_FREE_MIN !="" && $CIE_FREE_MIN!="0"){
                echo "<b>Livraison GRATUITE avec une commande avant taxes de ". $CIE_FREE_MIN . "$ et plus!</b><br>";
            }
            $ship_required = false;
            $cart_dimensions = 0.00; //dimension total
            $cart_width = 0.00;
            $cart_height = 0.00;
            $cart_depth = 0.00;
            $cart_weight = 0.00; //weight total
            $cart_total = 0.00;
            $taxable = 0;
            $non_taxable = 0;
            $stotal = 0.00; //sub-total
            $stotal_tx = 0.00; //sub-total-taxable
            $gtotal = 0.00; //grand total
            $tps = 0.00;
            $tvq = 0.00;
            $transport = 0.00;
            if ($ad_string == ""){$ad_string = "0";}
            $sql = "SELECT A.*, B.company AS company, B.last_name as last_name, B.province as province FROM classified A
            LEFT JOIN (SELECT id as retailer_id, company, last_name, province FROM customer) B ON A.customer_id = B.retailer_id
            WHERE id IN (" . $ad_string . ") ORDER BY A.customer_id ASC";
            //echo $sql;
            $result = $dw3_conn->query($sql);
            $QTY_ROWS = $result->num_rows??0;
            //if ($QTY_ROWS > 0) { 
            if ($QTY_ROWS > 0 && $STRIPE_RESULT != 'success' && $STRIPE_FROM != 'market') { 
                $customer_idx = "";
                while($row = $result->fetch_assoc()) {
                    if ($row["province"] != ""){
                        $retailer_prov = $row["province"] ; 
                    } else {
                        $retailer_prov = $province_tx;
                    }
                    switch ($retailer_prov) {
                        case "AB":case "Alberta":
                            $PTPS = $TPS_AB;$PTVP = $TVP_AB;$PTVH = $TVH_AB;break;
                        case "BC":case "British Columbia":
                            $PTPS = $TPS_BC;$PTVP = $TVP_BC;$PTVH = $TVH_BC;break;
                        case "QC":case "Quebec":case "Québec":
                            $PTPS = $TPS_QC;$PTVP = $TVP_QC;$PTVH = $TVH_QC;break;
                        case "MB":case "Manitoba":
                            $PTPS = $TPS_MB;$PTVP = $TVP_MB;$PTVH = $TVH_MB;break;
                        case "NB":case "New Brunswick":
                            $PTPS = $TPS_NB;$PTVP = $TVP_NB;$PTVH = $TVH_NB;break;
                        case "NT":
                            $PTPS = $TPS_NT;$PTVP = $TVP_NT;$PTVH = $TVH_NT;break;
                        case "NL":
                            $PTPS = $TPS_NL;$PTVP = $TVP_NL;$PTVH = $TVH_NL;break;
                        case "NS":case "Nova Scotia":
                            $PTPS = $TPS_NS;$PTVP = $TVP_NS;$PTVH = $TVH_NS;break;
                        case "NU":
                            $PTPS = $TPS_NU;$PTVP = $TVP_NU;$PTVH = $TVH_NU;break;
                        case "ON":case "Ontario":
                            $PTPS = $TPS_ON;$PTVP = $TVP_ON;$PTVH = $TVH_ON;break;
                        case "PE":
                            $PTPS = $TPS_PE;$PTVP = $TVP_PE;$PTVH = $TVH_PE;break;
                        case "SK":case "Saskatshewan":
                            $PTPS = $TPS_SK;$PTVP = $TVP_SK;$PTVH = $TVH_SK;break;
                        case "YT":case "Yukon":
                            $PTPS = $TPS_YT;$PTVP = $TVP_YT;$PTVH = $TVH_YT;break;
                    }

                    $RNDSEQ=rand(100,100000);
                    $filename= $row["img_link"];
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    } else {
                        if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        }else{
                            $filename = "/fs/customer/" . $row["customer_id"] . "/" . $filename;
                        }
                    }
                    $is_tx_fed = false;
                    $is_tx_prov = false;
                    $line_tvq = 0.00;
                    $line_tps = 0.00;
                    $line_qty = $_COOKIE['AD_'.$row["id"]];
                    $line_price = $row["price"];
        
                    if ($row["ship_type"] == "CARRIER"){
                        $ship_required = true;
                        $cart_weight = $cart_weight + floatval($row["kg"]*$line_qty);
                        $cart_dimensions = $cart_dimensions + (round($row["width"]*$line_qty,2)*round($row["height"]*$line_qty,2)*round($row["depth"]*$line_qty,2));
                        $cart_width = $cart_width + round($row["width"]*$line_qty,2);
                        $cart_height = $cart_height + round($row["height"]*$line_qty,2);
                        $cart_depth = $cart_depth + round($row["depth"]*$line_qty,2);
                    }
                    if ($row["tax_fed"] == "1"){
                        if ($PTPS != ""){
                            $line_tps = round(floatval(($line_price*$line_qty)*$PTPS)/100,2);
                        } else if ($PTVH != ""){
                            $line_tps = round(floatval(($line_price*$line_qty)*$PTVH)/100,2);
                        }
                        $is_tx_fed = true;
                    }
                    if ($row["tax_prov"] == "1"){
                        $line_tvp = round(floatval(($line_price*$line_qty)*$PTVP)/100,2);
                        $is_tx_prov = true;
                        //$stotal_tx = $stotal_tx + (floatval($line_price)*$line_qty);
                    }
                    if ($is_tx_prov==false && $is_tx_fed == false){
                        $non_taxable = $non_taxable + ($line_price*$line_qty);
                    } else{
                        $taxable = $taxable + ($line_price*$line_qty);
                    } 
                    $ltotal = (floatval($line_price)*$line_qty) + $line_tps + $line_tvq;
                    echo "<div style='text-align:center;border:1px solid #444;margin:15px; box-shadow: 5px 5px 5px 5px rgba(0,0,0,0.5);max-width:220px;width:220px;display:inline-block;border-radius:10px;background:rgba(255,255,255,0.9);color:#222;'>
                            <button style='float:left;margin:-15px;' onclick=\"deleteSelectedAd('".$row["id"]."')\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>cancel</span></button>
                            <table style='border-collapse: collapse;border:0px;width:220px;min-height:100%;border-radius:10px;'>";
                        //nom                           
                        echo "<tr style='padding:0px;border:0px;' onclick='getAD(". $row["id"] . ");'>";
                        if ($USER_LANG=="FR"){
                           echo "<td style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:50px;width:170px;font-size:16px;'>". $row["name_fr"] . "</td></tr>";
                        } else {
                           echo "<td style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:50px;width:170px;font-size:16px;'>". $row["name_en"] . "</td></tr>";
                        }    
                        //image                           
                        echo "<tr style='padding:0px;border:0px;' onclick='getAD(". $row["id"] . ");'>"
                            . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;vertical-align:middle;height:170px;'><img class='dw3_category_photo' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"/pub/img/dw3/nd.png\";'></td></tr>";
                        //retailer   
                        /* if ($row["company"] == ""){
                            echo "<tr style='padding:0px;border:0px;' onclick='getAD(". $row["id"] . ");'>"
                            . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'>". dw3_decrypt($row["last_name"]) . "</td></tr>";
                        } else {                       
                            echo "<tr style='padding:0px;border:0px;' onclick='getAD(". $row["id"] . ");'>"
                                . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'>". $row["company"] . "</td></tr>";
                        } */
                        //prix
                        $tot_line = round($row["price"]*$line_qty,2);
                        $plitted = explode(".",$tot_line);
                        $whole = $plitted[0]??$tot_line;
                        $fraction = $plitted[1]??0; 
                        if ($fraction == 0){
                            $fraction = "00";
                        }else{
                            $fraction = str_pad(rtrim($fraction, "0"), 2 , "0");
                        }
                        echo "<tr style='height:35px;'><td style='font-family:Sunflower;border:0px;text-align:center;padding-right:5px;padding-top:13px;padding-bottom:13px;'><strong>". number_format($whole) . ".<sup>" . $fraction . "</sup></strong></td></tr>";
                        //quantité
                        if ($line_qty < $row["qty_available"]){
                            echo "<tr><td style='text-align:center;'><button style='padding:5px 10px;' onclick=\"minusAdCookie('".$row["id"] ."')\">-1</button> &nbsp;". $line_qty . " &nbsp;<button style='padding:5px 10px;' onclick=\"plusAdCookie('".$row["id"] ."')\">+1</button></td></tr>";
                        } else {
                            echo "<tr><td style='text-align:center;'><button style='padding:5px 10px;' onclick=\"minusAdCookie('".$row["id"] ."')\">-1</button> &nbsp;". $line_qty . " &nbsp;<button disabled style='padding:5px 10px;' onclick=\"plusAdCookie('".$row["id"] ."')\">+1</button></td></tr>";
                        }
                        //vendu par
                        if ($row["company"] == ""){
                            $retailer_name = dw3_decrypt($row["last_name"]);
                        } else {  
                            $retailer_name = $row["company"];                     
                        }
                        if($USER_LANG == "FR"){
                            echo "<tr><td style='font-size:10px;padding:8px 0px;'>Vendu par: <u><a href='/pub/page/retailer/classifieds.php?KEY=".$KEY."&P1=".$row["customer_id"]."'>".$retailer_name."</a></u></td></tr>";
                        } else {
                            echo "<tr><td style='font-size:10px;padding:8px 0px;'>Sold by: <u><a href='/pub/page/retailer/classifieds.php?KEY=".$KEY."&P1=".$row["customer_id"]."'>".$retailer_name."</a></u></td></tr>";
                        }
                        //checkout
                        /* if($USER_LANG == "FR"){
                            echo "<tr><td><button onclick=\"marketTOcheckout('".$row["id"]."','". $line_qty."');\" style='min-height:50px;margin-left:0px;border-bottom-right-radius:10px;'><span style='width:92px;'>Payer</span> <span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span></button></td></tr>";
                        } else {
                            echo "<tr><td><button onclick=\"marketTOcheckout('".$row["id"]."''". $line_qty."');\" style='min-height:50px;margin-left:0px;border-bottom-right-radius:10px;'><span style='width:92px;'>Pay</span> <span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span></button></td></tr>";
                        } */
                        echo "</table></div>";
                    }

                    $stotal = $non_taxable + $taxable;
                    if (trim($CIE_TRANSPORT) == "INTERNAL") {
                        $transport = floatval($CIE_TRANSPORT_PRICE);
                    }
                    $is_transport_free = false;
                    if (floatval($stotal) >= floatval($CIE_FREE_MIN) && floatval($CIE_FREE_MIN) > 0){
                        $transport = 0.00;
                        $is_transport_free = true;
                    }
                    if ($coupon_valid==true){
                        if($coupon_amount > 0 && $coupon_prd =='0'){
                            $coupon_saving = $coupon_amount;
                        }
                        if($coupon_pourcent > 0 && $coupon_prd =='0'){
                            $coupon_saving = $coupon_saving + round(($stotal)*($coupon_pourcent/100),2);
                        }
                        $coupon_desc = "";
                        if ($coupon_amount > 0){
                            $coupon_desc .= $coupon_amount."$";
                        }
                        if ($coupon_pourcent > 0){
                            if ($coupon_amount > 0){$coupon_desc .= "+"; }
                            $coupon_desc .= $coupon_pourcent."%";
                        }
                    }
                    $stotal = $stotal - $coupon_saving;
                    $tot_tvq = round((($taxable-$coupon_saving)/100)*$PTVP,2);
                    $tot_tps = round((($taxable-$coupon_saving)/100)*$PTPS,2);
                    $gtotal = $stotal + $tot_tvq + $tot_tps + $transport;
                    $cart_total = $stotal + $tot_tvq + $tot_tps ;
                    echo "<hr><div style='width:100%;text-align:right;font-family:  var(--dw3_form_font);vertical-align:top;'>";
                    if ($USER_LANG == "FR"){
                        if (trim($CIE_TRANSPORT) == "MONTREAL_DROPSHIP" && $ship_required == true){
                            //kg to lb for MONTREAL_DROPSHIP
                            //$cart_weight = $cart_weight * 2.20462; will be defined in the quote.php file
                            echo "<div style='vertical-align:top;background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;width:300px;text-align:left;'>
                            Choisissez un mode de livraison:
                            <select class='multiple' size='3' id='trpTYPE2' onchange='changeRATE2();' style='font-size:17px;text-align:center;'>
                            <option value='PICKUP'"; if ($transport_code == "PICKUP" || $transport_code == ""){ echo "selected";} echo ">Ramasser en magasin</option>";
                            echo "<option value='REGULAR'"; if ($transport_code == "REGULAR"){ echo "selected";} echo ">Livraison régulière</option>";
                            echo "<option value='EXPRESS '"; if ($transport_code == "EXPRESS"){ echo "selected";} echo ">Livraison accélérée</option></select>";
                            echo "<div id='pickup_adress_type2' style='font-size:0.7em;min-height:19px;display:inline-block;'>Ramasser à: </div> <div id='pickup_adress_zone2' style='font-weight:bold;font-size:0.7em;padding:10px 0px 0px 5px;min-height:19px;display:inline-block;'>".$location_adress."</div>";
                            echo "<div id='delivery_estimated_date2' style='vertical-align:middle;width:100%;text-align:center;font-weight:bold;font-size:0.7em;min-height:19px;'></div></div>";
                        }
                        echo "<div style='vertical-align:top;background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;width:300px;text-align:right;'>
                            Sous-total: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($stotal+$coupon_saving,2,"."," ")."$</div><hr>";
                            if ($coupon_saving > 0){
                                echo "Rabais ".$coupon_desc.": <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>-".number_format($coupon_saving,2,"."," ")."$</div><hr>";
                            }
                            echo "+TPS 5%: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($tot_tps,2,"."," ")."$</div><hr>
                            +TVQ 9.975%: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($tot_tvq,2,"."," ")."$</div><hr>";
                            echo "Transport : <div id='transportRate2' style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($transport,2,"."," ")."$</div><hr>";
                            echo "Total avec taxes: <div id='marketGTOT' style='width:120px;display:inline-block;font-family:Roboto-Light;'><b>".number_format($gtotal,2,"."," ")."$</b></div>
                                    <div style='width:100%; text-align:left;'><img src='/pub/img/dw3/flag-canada.svg' style='width:20px;'> <span style='font-size:12px;'>Tous les prix sont en CAD</span></div>";
                    }else{
                        if (trim($CIE_TRANSPORT) == "MONTREAL_DROPSHIP" && $ship_required == true){
                            echo "<div style='background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;width:300px;text-align:left;'>
                            Select a delivery mode:
                            <select class='multiple' size='3' id='trpTYPE' onchange='changeRATE2();' style='font-size:17px;text-align:center;'>
                            <option selected value='PICKUP'"; if ($transport_code == "PICKUP"){ echo "selected";} echo ">Pickup in store</option>";
                            echo "<option value='REGULAR'"; if ($transport_code == "REGULAR"){ echo "selected";} echo ">Regular delivery</option>";
                            echo "<option value='EXPRESS'"; if ($transport_code == "EXPRESS"){ echo "selected";} echo ">Accelerated delivery</option></select>";  
                            echo "<div id='pickup_adress_zone2' style='font-weight:bold;font-size:0.7em;padding:5px;min-height:19px;'>".$location_adress."</div>";    
                            echo "<div id='delivery_estimated_date2' style='vertical-align:middle;width:100%;text-align:center;font-weight:bold;font-size:0.7em;padding:5px;min-height:19px;'></div></div>";    
                        }
                        echo "<div style='width:100%;text-align:right;font-family:  var(--dw3_form_font);'><div style='background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;width:300px;text-align:right;'>
                            Subtotal: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($stotal+$coupon_saving,2,"."," ")."$</div><hr>";
                            if ($coupon_saving > 0){
                                echo "Discount ".$coupon_desc.": <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>-".number_format($coupon_saving,2,"."," ")."$</div><hr>";
                            }
                            echo "+TPS 5%: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($tot_tps,2,"."," ")."$</div><hr>
                            +TVQ 9.975%: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($tot_tvq,2,"."," ")."$</div><hr>";
                            echo "Transport : <div id='transportRate2' style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($transport,2,"."," ")."$</div><hr>";
                            echo "Total with taxes: <div id='marketGTOT' style='width:120px;display:inline-block;font-family:Roboto-Light;'><b>".number_format($gtotal,2,"."," ")."$</b></div>
                            <div style='width:100%; text-align:left;'><img src='/pub/img/dw3/flag-canada.svg' style='width:20px;'> <span style='font-size:12px;'>All prices are in CAD</span></div>";
                    }
                    
                    echo "</div><br>";
                    if ($USER_LANG == "FR"){ 
                        echo "<button id='btnMarketToCheckout' class='green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('marketTOcheckout');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span> Passer à la caisse</button> </div>"; 
                    }else {
                        echo "<button id='btnMarketToCheckout' class='green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('marketTOcheckout');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span> Proceed to checkout</button> </div>"; 
                    }
                echo "</div>";            
                    //prix en CAD
                /*  if($USER_LANG == "FR"){
                        echo "<br><img src='/pub/img/dw3/flag-canada.svg' style='width:20px;'> <span style='font-size:12px;'>Tous les prix sont en CAD</span><br>";
                    } else {
                        echo "<br><img src='/pub/img/dw3/flag-canada.svg' style='width:20px;'> <span style='font-size:12px;'>All prices are in CAD</span><br>";
                    } */
                } else {
                    //echo $sql;
                    echo "<div class='divBOX' style='text-align:center;'>"; if ($USER_LANG == "FR"){ echo "Aucune annonce sélectionnée pour achat."; }else{echo "No listings selected for purchase.";} echo "</div>";
                }
        ?>
</div>
<?php
}
//____________ 
//  WISHLIST
//‾‾‾‾‾‾‾‾‾‾‾‾
$dw3_wish_string = "";
$dw3_wish=array();
foreach ($_COOKIE as $key=>$val){
  if (substr($key, 0, 5) == "WISH_"){
    $dw3_wish[$key] = intval($dw3_wish[$key]??0) + intval($val);
  }
}
foreach ($dw3_wish as $key=>$val){
  if (intval($dw3_wish[$key]) > 0){
    $dw3_wish_string .= ltrim($key,"WISH_") . ",";
    }
}
$dw3_wish_string = rtrim($dw3_wish_string,",");
$sql = "SELECT A.*, IFNULL(B.total,0) AS invTOT FROM product A
LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) B ON A.id = B.product_id
WHERE stat = 0 AND web_dsp = 1 AND id IN (" . $dw3_wish_string . ") 
ORDER BY price1 ASC, id DESC";
if (trim($dw3_wish_string)!=""){
    $result = $dw3_conn->query($sql);
    $QTY_ROWS = $result->num_rows??0;
} else {
    $QTY_ROWS = 0 ;
}
if ($QTY_ROWS < 1) { ?>
    <h4 onclick="toggleSub('divSub00','up00');" style="display:<?php if ($DASH_CART == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
        <span class="material-icons">favorite_border</span> <?php if ($USER_LANG == "FR"){ echo "Liste de souhaits"; }else{echo "Wishlist";}?> <span id='up00' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
    </h4>
    <div class='divMAIN' id='divSub00' style='height:0px;display:none;background-color:rgba(0,0,0,0.1);'>
    <div class='divBOX' style='text-align:center;'><?php if ($USER_LANG == "FR"){ echo "Aucun article disponible dans la liste de souhaits."; }else{echo "No items available in wish list.";}?></div>
<?php }else{ ?>
    <h4 onclick="toggleSub('divSub00','up00');" style="display:<?php if ($DASH_CART == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
        <span class="material-icons">favorite</span> <?php if ($USER_LANG == "FR"){ echo "Liste de souhaits"; }else{echo "Wishlist";}?> <span id='up00' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_down</span>
    </h4>
    <div class='divMAIN' id='divSub00' style="height:0px; display:none;background-color:rgba(0,0,0,0.1);">
    <?php 
    echo "<table class='tblSEL'>";
    while($row = $result->fetch_assoc()) {
        $RNDSEQ=rand(100,100000);
        $filename= $row["url_img"];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
            $filename = "/pub/img/dw3/nd.png";
        } else {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                $filename = "/pub/img/dw3/nd.png";
            }else{
                $filename = "/fs/product/" . $row["id"] . "/" . $filename;
            }
        }
        if ($row["invTOT"] > 0 || $row["qty_max_by_inv"] == 0){
            if ($USER_LANG == "FR"){
                echo "<tr><td width='50' onclick='getPRD(".$row["id"].");' style='text-align:center;'><img class='photo' style='height:50px;width:auto;max-width:100%;' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./pub/img/dw3/nd.png\";'></td><td width='*' onclick='getPRD(".$row["id"].");'>".$row["name_fr"]."</td><td width='10%' style='text-align:center;'><button onclick='dw3_cart_add(".$row["id"].",this);'><span class='material-icons'>add_shopping_cart</span></button></td><td width='10%' style='text-align:center;'><button onclick='dw3_wish_del(".$row["id"].");'><span class='material-icons'>delete</span></button></td></tr>";
            } else {
                echo "<tr><td width='50' onclick='getPRD(".$row["id"].");' style='text-align:center;'><img class='photo' style='height:50px;width:auto;max-width:100%;' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./pub/img/dw3/nd.png\";'></td><td width='*' onclick='getPRD(".$row["id"].");'>".$row["name_en"]."</td><td width='10%' style='text-align:center;'><button onclick='dw3_cart_add(".$row["id"].",this);'><span class='material-icons'>add_shopping_cart</span></button></td><td width='10%' style='text-align:center;'><button onclick='dw3_wish_del(".$row["id"].");'><span class='material-icons'>delete</span></button></td></tr>";
            }
        } else {
            if ($USER_LANG == "FR"){
                echo "<tr><td width='50' onclick='getPRD(".$row["id"].");' style='text-align:center;'><img class='photo' style='height:50px;width:auto;max-width:100%;' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./pub/img/dw3/nd.png\";'></td><td width='*' onclick='getPRD(".$row["id"].");'>".$row["name_fr"]."</td><td width='10%' style='text-align:center;'><button onclick=\"addNotif('Rupture de stock');\"><span style='color:orange;' class='material-icons'>warning</span></button></td><td width='10%' style='text-align:center;'><button onclick='dw3_wish_del(".$row["id"].");'><span class='material-icons'>delete</span></button></td></tr>";
            } else {
                echo "<tr><td width='50' onclick='getPRD(".$row["id"].");' style='text-align:center;'><img class='photo' style='height:50px;width:auto;max-width:100%;' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./pub/img/dw3/nd.png\";'></td><td width='*' onclick='getPRD(".$row["id"].");'>".$row["name_en"]."</td><td width='10%' style='text-align:center;'><button onclick=\"addNotif('Out of stock');\"><span style='color:orange;' class='material-icons'>warning</span></button></td><td width='10%' style='text-align:center;'><button onclick='dw3_wish_del(".$row["id"].");'><span class='material-icons'>delete</span></button></td></tr>";
            }
        }
    }
    echo "</table>";
}
echo "</div>";
//__________ 
//   CART
//‾‾‾‾‾‾‾‾‾‾ 
switch ($province_tx) {
    case "AB":case "Alberta":
        $PTPS = $TPS_AB;$PTVP = $TVP_AB;$PTVH = $TVH_AB;break;
    case "BC":case "British Columbia":
        $PTPS = $TPS_BC;$PTVP = $TVP_BC;$PTVH = $TVH_BC;break;
    case "QC":case "Quebec":case "Québec":
        $PTPS = $TPS_QC;$PTVP = $TVP_QC;$PTVH = $TVH_QC;break;
    case "MB":case "Manitoba":
        $PTPS = $TPS_MB;$PTVP = $TVP_MB;$PTVH = $TVH_MB;break;
    case "NB":case "New Brunswick":
        $PTPS = $TPS_NB;$PTVP = $TVP_NB;$PTVH = $TVH_NB;break;
    case "NT":
        $PTPS = $TPS_NT;$PTVP = $TVP_NT;$PTVH = $TVH_NT;break;
    case "NL":
        $PTPS = $TPS_NL;$PTVP = $TVP_NL;$PTVH = $TVH_NL;break;
    case "NS":case "Nova Scotia":
        $PTPS = $TPS_NS;$PTVP = $TVP_NS;$PTVH = $TVH_NS;break;
    case "NU":
        $PTPS = $TPS_NU;$PTVP = $TVP_NU;$PTVH = $TVH_NU;break;
    case "ON":case "Ontario":
        $PTPS = $TPS_ON;$PTVP = $TVP_ON;$PTVH = $TVH_ON;break;
    case "PE":
        $PTPS = $TPS_PE;$PTVP = $TVP_PE;$PTVH = $TVH_PE;break;
    case "SK":case "Saskatshewan":
        $PTPS = $TPS_SK;$PTVP = $TVP_SK;$PTVH = $TVH_SK;break;
    case "YT":case "Yukon":
        $PTPS = $TPS_YT;$PTVP = $TVP_YT;$PTVH = $TVH_YT;break;
}
        $txt_estimated_date = "";
        $transport_code = "";
        $coupon_valid = false;
        $coupon_code = "";
        $coupon_amount = "0";
        $coupon_pourcent = "0";
        $coupon_prd = "0";
        $coupon_msg = "Le coupon est expiré.";
        $coupon_saving = 0;
        //$dw3_cart_string = "";
        //$dw3_cart=array();
        foreach ($_COOKIE as $key=>$val)
        {
          /* if (substr($key, 0, 5) == "CART_"){
            $dw3_cart[$key] = intval($dw3_cart[$key]??0) + intval($val);
            //echo "key: ". $key . "; dw3_cart[key]:".$dw3_cart[$key]. " ; value: ". $val. " calc=" . round($dw3_cart[$key] + $val);
            //$dw3_cart_string .= ltrim($key,"CART_") . ",";
            } */
            if ($key == "COUPON"){
                $coupon_code = $val;
            }
            if ($key == "TRANSPORT"){
                $transport_code = $val;
            }
        }

        /* foreach ($dw3_cart as $key=>$val)
        {
          if (intval($dw3_cart[$key]) > 0){
            $dw3_cart_string .= ltrim($key,"CART_") . ",";
            }
        }
        $dw3_cart_string = rtrim($dw3_cart_string,","); */
        
        //get coupon info
        if ($coupon_code != ""){
            $sql = "SELECT * FROM coupon WHERE trim(code) = '" . trim($coupon_code) . "' LIMIT 1";
            $result = mysqli_query($dw3_conn, $sql);
            $data = mysqli_fetch_assoc($result);
            if (isset($data["id"])){
                $date_start = new DateTime($data["date_start"]);
                $date_end = new DateTime($data["date_end"]);
                $now = new DateTime();
                if ($date_start > $now){
                    $coupon_msg = "Le coupon sera valide le ".substr($data['date_start'],0,10). " à " . substr($data['date_start'],11,8);
                } else if ($date_end < $now){
                    $coupon_msg = "Le coupon a expiré le ".substr($data['date_end'],0,10) . " à " . substr($data['date_end'],11,8);
                } else {
                    $coupon_valid = true;
                    $coupon_msg = "Coupon validé.";
                    $coupon_amount = $data['amount_val'];
                    $coupon_pourcent = $data['pourcent_val'];
                    $coupon_prd = $data['product_id'];
                }
            }
        }

    $sql_cart = "SELECT  * FROM cart_line WHERE device_id ='" . $USER_DEVICE . "' AND product_id IN( SELECT id FROM product WHERE stat = 0 AND web_dsp = 1) ORDER BY id ASC;";
    $result_cart = $dw3_conn->query($sql_cart);

    /* $sql = "SELECT A.*, IFNULL(B.total,0) AS qty_inv FROM product A
            LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) B ON A.id = B.product_id
            WHERE stat = 0 AND web_dsp = 1 AND id IN (" . $dw3_cart_string . ") 
            ORDER BY price1 ASC, id DESC"; */
    $ship_required = false;
    $cart_dimensions = 0.00; //dimension total
    $cart_width = 0.00;
    $cart_height = 0.00;
    $cart_depth = 0.00;
    $cart_weight = 0.00; //weight total
    $cart_total = 0.00;
    $taxable = 0;
    $non_taxable = 0;
    $stotal = 0.00; //sub-total
    $stotal_tx = 0.00; //sub-total-taxable
    $gtotal = 0.00; //grand total
    $tps = 0.00;
    $tvq = 0.00;
    $transport = 0.00;
    $transport_mem = 0.00; //memoryize transport cost when switching from pickup to delivery
    /* if (trim($dw3_cart_string)!=""){
        $result_cart = $dw3_conn->query($sql);
        $QTY_ROWS = $result_cart->num_rows??0;
    } else {
        $QTY_ROWS = 0 ;
    } */
           $QTY_ROWS = $result_cart->num_rows??0;
        //echo $QTY_ROWS;
       
    if ($QTY_ROWS < 1) { ?>
        <h4 onclick="toggleSub('divSub0','up0');" style="display:<?php if ($DASH_CART == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
            <span class="material-icons">shopping_cart</span> <?php if ($USER_LANG == "FR"){ echo "Mon panier"; }else{echo "My Basket";}?> <span id='up0' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
        </h4>
        <div class='divMAIN' id='divSub0' style='height:0px;display:none;background-color:rgba(0,0,0,0.1);'>
        <div class='divBOX' style='text-align:center;'><?php if ($USER_LANG == "FR"){ echo "Le panier est vide."; }else{echo "The cart is empty.";}?>
        <img src='/pub/img/dw3/empty_cart.jpg' style='width:100%;height:auto;'></div>
        <?php }else{ ?>
        <h4 onclick="toggleSub('divSub0','up0');" style="display:<?php if ($DASH_CART == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
            <span class="material-icons">shopping_cart</span> <?php if ($USER_LANG == "FR"){ echo "Mon panier"; }else{echo "My Basket";}?> <span id='up0' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_down</span>
        </h4>
        <div class='divMAIN' id='divSub0' style="padding:0px 0px 10px 0px;height: auto; display:<?php if ($DASH_CART == "1"){ echo "inline-block"; }else{echo "none";}?>;background-color:rgba(0,0,0,0.1);overflow:hidden;">
            <div style="margin-bottom:10px;width:100%;background-color:#<?php echo $CIE_COLOR8; ?>;color:#<?php echo $CIE_COLOR9; ?>;font-family:<?php echo $CIE_FONT3??'Roboto';?>;text-align:center;padding:4px;overflow:hidden;">
            <?php
            //choix de location
                $sql = "SELECT * FROM location WHERE id = '".$location_id."' LIMIT 1;"; 
                $result = $dw3_conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        if ($USER_LANG == "FR"){
                            echo "<a arial-label='".$CIE_LOC_TITLE_FR.": ".$row['name']."' href='/pub/page/location/index.php'><div style='padding:5px 0px;border-radius:5px;color:#".$CIE_COLOR9.";'><span class='material-icons'>location_on</span> ".$CIE_LOC_TITLE_FR.": <span id='retailer_loc_span'> <u>".$row['name']." ".$row['city']." ".$row['postal_code']."</u></span></div></a>";
                        } else {
                            echo "<a arial-label='".$CIE_LOC_TITLE_EN.": ".$row['name']."' href='/pub/page/location/index.php'><div style='padding:5px 0px;border-radius:5px;color:#".$CIE_COLOR9.";'><span class='material-icons'>location_on</span> ".$CIE_LOC_TITLE_EN.": <span id='retailer_loc_span'> <u>".$row['name']." ".$row['city']." ".$row['postal_code']."</u></span></div></a>";
                        }
                    }
                } else {
                    if ($USER_LANG == "FR"){
                        echo "<a arial-label='".$CIE_LOC_TITLE_FR."' href='/pub/page/location/index.php' style=''><div style='padding:5px 0px;border-radius:5px;color:#".$CIE_COLOR9.";'>".$CIE_LOC_TITLE_FR.": <u>-CHOISIR-</u></div></a>";
                    } else {
                        echo "<a arial-label='".$CIE_LOC_TITLE_EN."' href='/pub/page/location/index.php' style=''><div style='padding:5px 0px;border-radius:5px;color:#".$CIE_COLOR9.";'>".$CIE_LOC_TITLE_EN.": <u>-CHOOSE-</u></div></a>";
                    }
                }
        if($CIE_FREE_MIN !="" && $CIE_FREE_MIN!="0"){
            echo "<div><b>Livraison GRATUITE avec une commande avant taxes de ". $CIE_FREE_MIN . "$ et plus!</b></div>";
        }
        echo "</div>";
        while($row_cart = $result_cart->fetch_assoc()) {
            $sql = "SELECT  A.*, IFNULL(B.total,0) AS invTOT FROM product A
            LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) B ON A.id = B.product_id
            WHERE stat = 0 AND web_dsp = 1 AND id ='" . $row_cart["product_id"] . "' LIMIT 1;";
            //echo $sql_cart;
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) { 
                while($row = $result->fetch_assoc()) {
                $RNDSEQ=rand(100,100000);
                $filename= $row["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                    }
                }
                
                $is_tx_fed = false;
                $is_tx_prov = false;
                $line_tvq = 0.00;
                $line_tps = 0.00;
                $line_price = $row["price1"];
                $line_qty = $row_cart["quantity"];
                $transport = $transport + $row["transport_supp"]*$line_qty;
                if ($row["ship_type"] == "CARRIER" || $row["ship_type"] == "INTERNAL"){
                    $ship_required = true;
                    $cart_weight = $cart_weight + floatval($row["kg"]*$line_qty);
                    $cart_dimensions = $cart_dimensions + (round($row["width"]*$line_qty,2)*round($row["height"]*$line_qty,2)*round($row["depth"]*$line_qty,2));
                    $cart_width = $cart_width + round($row["width"]*$line_qty,2);
                    $cart_height = $cart_height + round($row["height"]*$line_qty,2);
                    $cart_depth = $cart_depth + round($row["depth"]*$line_qty,2);
                }

                //verif si prix 2 applicable
                /* if ($row["price2"] != 0 && $row["qty_min_price2"] >=2 && $line_qty >=$row["qty_min_price2"]){
                    $line_price = $row["price2"];
                } */
               //prix product_pack
                $sql_inc_z = "SELECT  * FROM product_pack WHERE product_id ='" . $row["id"] . "' ORDER BY pack_qty ASC";
                $result_inc_z = $dw3_conn->query($sql_inc_z);
                if ($result_inc_z->num_rows> 0) { 
                    while($row_inc_z = $result_inc_z->fetch_assoc()) {
                        if ($line_qty >= $row_inc_z["pack_qty"]){
                            $line_price = $row_inc_z["pack_price"];
                        }
                    }
                }
                //verif is promo applicable
                $date_promo = new DateTime($row["promo_expire"]);
                $now = new DateTime();
                if($date_promo > $now && $line_price > $row["promo_price"] && $line_price > $row["promo_price"] && $row["promo_price"] >= 0) {
                    $line_price = $row["promo_price"];
                }
                //verif si escompte produit du fournisseur pour ce client
                $sqlx = "SELECT * FROM customer_discount WHERE customer_id = '".$USER."' AND supplier_id = '" . $row["supplier_id"] . "' AND supplier_id <> 0 LIMIT 1";
                $resultx = mysqli_query($dw3_conn, $sqlx);
                $datax = mysqli_fetch_assoc($resultx);
                if (isset($datax["escount_pourcent"]) && $datax["escount_pourcent"] != 0){
                    $discount_price = $line_price - (round($line_price*($datax["escount_pourcent"]/100),2));
                } else {$discount_price = 0;}
                if ($discount_price < $line_price && $discount_price > 0){
                    $line_price = $discount_price;
                }
                /*                 if ($row["id"]==$coupon_prd){
                    if ($coupon_valid==true){
                        if($coupon_amount > 0){
                            $coupon_saving = $coupon_amount;
                            $coupon_amount = 0;
                        }
                        if($coupon_pourcent > 0){
                            $coupon_saving = $coupon_saving + round(($line_price)*($coupon_pourcent/100),2);
                            $coupon_pourcent = 0;
                        }
                    }
                } */
                //options 
                $sql2 = "SELECT * FROM cart_option WHERE line_id = '".$row_cart["id"]."';";
                $result2 = $dw3_conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while($row2 = $result2->fetch_assoc()) { 
                        $line_price = $line_price + $row2["price"];
                    }
                }
                echo "<div style='font-family:  var(--dw3_form_font);display:inline-block;background:rgba(255,255,255,0.7);color:#222;padding:3px;margin:12px;border-radius:7px;min-width:200px;max-width:500px;box-shadow: inset 0px 0px 5px #777;'>
                        <button style='float:left;margin:-15px;' onclick=\"dw3_cart_del('".$row_cart["id"] ."')\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>cancel</span></button>
                        <table style='min-width:200px;max-width:500px;white-space:wrap;margin-right:auto;margin-left:auto;font-family:  var(--dw3_table_font);'>
                            <tr onclick=\"getPRD('". $row["id"] . "');\" style='cursor:pointer;'>";
                            if ($USER_LANG == "FR"){
                                echo "<td style='text-align:center;'><b>". strtoupper($row["name_fr"]) ."</b></td></tr>";
                            } else {
                                echo "<td style='text-align:center;'><b>". strtoupper($row["name_en"]) ."</b></td></tr>";
                            }
                            echo "<tr onclick=\"getPRD('". $row["id"] . "');\" style='cursor:pointer;'>"
                            . "<td style='text-align:center;'><img class='photo' style='height:100px;width:auto;max-width:100%;' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./pub/img/dw3/nd.png\";'></td></tr>";
                            /* if ($row["tax_fed"] == "1"){
                                $line_tps = round((floatval($line_price)*$line_qty)*0.05,2);
                                $is_tx_fed = true;
                            }
                            if ($row["tax_prov"] == "1"){
                                $line_tvq = round((floatval($line_price)*$line_qty)*0.09975,2);
                                $is_tx_prov = true;
                                //$stotal_tx = $stotal_tx + (floatval($line_price)*$line_qty);
                            } else {
                                //$stotal = $stotal + (floatval($line_price)*$line_qty);
                            } */
                            if ($row["tax_fed"] == "1"){
                                if ($PTPS != ""){
                                    $line_tps = round(floatval(($line_price*$line_qty)*$PTPS)/100,2);
                                } else if ($PTVH != ""){
                                    $line_tps = round(floatval(($line_price*$line_qty)*$PTVH)/100,2);
                                }
                                $is_tx_fed = true;
                            }
                            if ($row["tax_prov"] == "1"){
                                $line_tvp = round(floatval(($line_price*$line_qty)*$PTVP)/100,2);
                                $is_tx_prov = true;
                                //$stotal_tx = $stotal_tx + (floatval($line_price)*$line_qty);
                            }
                            if ($is_tx_prov==false && $is_tx_fed == false){
                                $non_taxable = $non_taxable + ($line_price*$line_qty);
                            } else{
                                $taxable = $taxable + ($line_price*$line_qty);
                            }   
                    //check inv?
                    $is_service = true;
                    if ($row["billing"] == "FINAL" || $row["billing"] == "LOCATION"){
                        $is_service = false;
                    }                   
                    if ($is_service == false && $row["qty_max_by_inv"] == 1){
                        $qty_inv = $row["invTOT"];
                    } else {
                        $qty_inv = "";
                    }
                    //get product options
                    $sql2 = "SELECT * FROM product_option WHERE product_id = '".$row["id"]."' ORDER BY name_fr ASC;";
                    $result2 = $dw3_conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        echo "<tr><td>";
                        while($row2 = $result2->fetch_assoc()) {
                            echo "<div class='divBOX' style='text-align:left;'><b>".$row2["name_fr"].":</b><br><div style='width:100%;max-width:100%;'><div style='margin:0px 0px 0px 10px;text-align:left;display:inline-block;'>";	
                                //option_line selected
                                $sqlx = "SELECT * FROM cart_option WHERE line_id = '".$row_cart["id"] ."' AND option_id = '".$row2["id"]."' LIMIT 1;";
                                $resultx = mysqli_query($dw3_conn, $sqlx);
                                    $datax = mysqli_fetch_assoc($resultx);
                                    $selected_option_line = $datax["option_line_id"];
                                    $option_line_id = $datax["id"];
                                    //product_option_line
                                    $sql3 = "SELECT * FROM product_option_line WHERE option_id = '".$row2["id"]."' ORDER BY amount ASC;";
                                    $result3 = $dw3_conn->query($sql3);
                                    if ($result3->num_rows > 0) {
                                        while($row3 = $result3->fetch_assoc()) {
                                            if ($row3["amount"] != 0){
                                                $option_amount_dsp = "";
                                                //$option_amount_dsp = " <small>+" . $row3["amount"] . "$</small>";
                                            } else {
                                                $option_amount_dsp = "";
                                            }
                                            if ($selected_option_line == $row3["id"]){
                                                echo "<input onclick=\"updCART_OPTION('".$option_line_id."','".$row2["id"]."','".$row3["id"]."')\" id='opt".$row3["id"]."' name='opts".$row2["id"]."' type='radio' value='". $row3["id"] . "' checked> <label for='opt".$row3["id"]."' style='padding-top:0px;'>". $row3["name_fr"] . $option_amount_dsp . "</label><br>";		
                                            } else {
                                                echo "<input onclick=\"updCART_OPTION('".$option_line_id."','".$row2["id"]."','".$row3["id"]."')\" id='opt".$row3["id"]."' name='opts".$row2["id"]."' type='radio' value='". $row3["id"] . "'> <label for='opt".$row3["id"]."' style='padding-top:0px;'>". $row3["name_fr"] . $option_amount_dsp . "</label><br>";		
                                            }
                                        }
                                    }
                            echo "</div></div></div>";
                        }
                        echo "</td></tr>";
                    }
                //echo "<tr><td style='text-align:center;font-size:22px;'><button class='no-effect' style='width:42px;padding:10px;margin-right:5px;font-family:Consolas,monospace;font-weight:bold;' onclick=\"dw3_cart_minusX('".$row_cart["id"] ."','".$row["qty_min_sold"]."')\">-".($row["qty_step"]*10)."</button> <button class='no-effect' style='width:42px;padding:10px;margin-right:10px;font-family:Consolas,monospace;font-weight:bold;' onclick=\"dw3_cart_minus('".$row_cart["id"] ."','".$row["qty_min_sold"]."')\">-".$row["qty_step"]."</button> <b>". round($line_qty). "</b> <button class='no-effect' style='width:42px;padding:10px;margin-left:10px;font-family:Consolas,monospace;font-weight:bold;' onclick=\"dw3_cart_plus('".$row_cart["id"] ."','".$qty_inv ."')\">+".$row["qty_step"]."</button> <button class='no-effect' style='width:42px;padding:10px;margin-left:5px;font-family:Consolas,monospace;font-weight:bold;' onclick=\"dw3_cart_plusX('".$row_cart["id"] ."','".$qty_inv ."')\">+".($row["qty_step"]*10)."</button></td></tr>";                          
                echo "<tr><td style='text-align:center;'>
                <button class='no-effect' style='width:42px;padding:10px;margin-right:10px;font-family:Consolas,monospace;font-weight:bold;' onclick=\"dw3_cart_minus('".$row_cart["id"] ."','".$row["qty_min_sold"]."')\">-".$row["qty_step"]."</button>";
                echo "<input id='dw3_cart_item_qty_".$row_cart["id"]."' type='text' style='background:rgba(255,255,255,0.9);color:#222;text-align:center;border:0px;width:50px;font-weight:bold;border-radius:5px;padding:5px;background-image:none;font-size:16px;' value='". round($line_qty) ."' onchange=\"dw3_cart_change('".$row_cart["id"] ."','".$qty_inv ."','".$row["qty_min_sold"]."')\"></b>";
                if ($line_qty < $row["invTOT"] || $row["qty_max_by_inv"] == 0 || $qty_inv = ""){
                    echo "<button style='width:42px;padding:10px;margin-left:10px;font-family:Consolas,monospace;font-weight:bold;' onclick=\"dw3_cart_plus('".$row_cart["id"] ."','".$qty_inv ."')\">+".$row["qty_step"]."</button></td></tr>";
                } else {
                    echo "<button style='width:42px;padding:10px;margin-left:10px;font-family:Consolas,monospace;font-weight:bold;' disabled>+".$row["qty_step"]."</button></td></tr>";
                }
                if ($CIE_HIDE_PRICE == "true"){
                    echo "<tr><td style='text-align:center;display:none;'>";
                } else {
                    echo "<tr><td style='text-align:center;'>";
                }
                $ltotal = (floatval($line_price)*$line_qty) + $line_tps + $line_tvq;

                //$gtotal = $gtotal + $ltotal;
                //$tps = $tps + $line_tps;
                //$tvq = $tvq + $line_tvq;
                if ( trim($row["price_text_fr"]) == "") {
                    $plitted = explode(".",floatval($line_price));
                    $whole = $plitted[0];
                    if (count($plitted)>1){
                        $fraction = $plitted[1];
                    } else {
                        $fraction = "00";
                    }
                    $plitted2 = explode(".",floatval($line_price)*$line_qty);
                    $whole2 = $plitted2[0];
                    if (count($plitted2)>1){
                        $fraction2 = $plitted2[1];
                    } else {
                        $fraction2 = "00";
                    }
                    if ($fraction == 0){$fraction = "00";}//else{$fraction = ".".$fraction;}
                    if ($fraction2 == 0){$fraction2 = "00";}//else{$fraction = ".".$fraction;}
                        /* if ($USER_LANG == "FR"){ 
                            echo "<b>".$line_qty . "x</b> " . number_format($line_price,2,"."," ") . " + " . number_format($line_tps,2,"."," ") . "<span style='font-size:11px;'>TPS </span> + " .  number_format($line_tvq,2,"."," ") ."<span style='font-size:11px;'>TVQ </span> = <b><span style='font-size:21px;'>". number_format($whole) . ".<sup>" . str_pad(rtrim($fraction, "0"), 2 , "0") . "</sup><span></b>";
                        }else{
                            echo "<b>".$line_qty . "x</b> " . number_format($line_price,2,"."," ") . " + " . number_format($line_tps,2,"."," ") . "<span style='font-size:11px;'>TPS </span> + " .  number_format($line_tvq,2,"."," ") ."<span style='font-size:11px;'>TVQ </span> = <b><span style='font-size:21px;'>". number_format($whole) . ".<sup>" . str_pad(rtrim($fraction, "0"), 2 , "0") . "</sup><span></b>";
                        } */
                        echo number_format($whole) . ".<sup>" . str_pad(rtrim($fraction, "0"), 2 , "0") . "</sup>/<small>". $row["pack_desc"]. "</small> <b>x".round($line_qty) . "</b>  = ". number_format($whole2) . ".<sup>" . str_pad(rtrim($fraction2, "0"), 2 , "0") . "</sup>";
                    } else { 
                        if ($USER_LANG == "FR"){ 
                            echo " " . $row["price_text_fr"] . "</b>";
                        }else{
                            echo " " . $row["price_text_en"] . "</b>";
                        }
                    }
                    echo "</td></tr></table>";
                    if ($row["tax_verte"] != "0"){
                        if ($USER_LANG == "FR"){
                            echo "<div style='color:#444;font-size:0.8em;margin:5px 5px 0px 0px;width:100%;text-align:right;'>Frais inclus: ".number_format($row["tax_verte"],2,"."," ")." $ Envir <span onclick='taxeVERTE_INFO();' class='material-icons' style='font-size:19px;vertical-align:middle;cursor:pointer;'>info</span></div>";
                        }else{
                            echo "<div style='color:#444;font-size:0.8em;margin:5px 5px 0px 0px;width:100%;text-align:right;'>Incl $".number_format($row["tax_verte"],2,"."," ")." Env. fees <span onclick='taxeVERTE_INFO();' class='material-icons' style='font-size:19px;vertical-align:middle;cursor:pointer;'>info</span></div>";
                        }
                    }
                    echo "</div>";
                }
            }
        }

        $stotal = $non_taxable + $taxable;
        if (trim($CIE_TRANSPORT) == "INTERNAL" && $transport_code != "") {
            $transport = $transport + floatval($CIE_TRANSPORT_PRICE);
            $transport_mem = $transport;
        }
        if ($transport_code == "PICKUP") {
            $transport = 0.00;
        }
        $is_transport_free = false;
        if (floatval($stotal) >= floatval($CIE_FREE_MIN) && floatval($CIE_FREE_MIN) > 0){
            $transport = 0.00;
            $is_transport_free = true;
        }
        if ($coupon_valid==true){
            if($coupon_amount > 0 && $coupon_prd =='0'){
                $coupon_saving = $coupon_amount;
            }
            if($coupon_pourcent > 0 && $coupon_prd =='0'){
                $coupon_saving = $coupon_saving + round(($stotal)*($coupon_pourcent/100),2);
            }
            $coupon_desc = "";
            if ($coupon_amount > 0){
                $coupon_desc .= $coupon_amount."$";
            }
            if ($coupon_pourcent > 0){
                if ($coupon_amount > 0){$coupon_desc .= "+"; }
                $coupon_desc .= $coupon_pourcent."%";
            }
        }
        $stotal = $stotal - $coupon_saving;
        $tot_tvq = round((($taxable-$coupon_saving)/100)*$PTVP,2);
        $tot_tps = round((($taxable-$coupon_saving)/100)*$PTPS,2);
        $gtotal = $stotal + $tot_tvq + $tot_tps + $transport;
        $cart_total = $stotal + $tot_tvq + $tot_tps;

        //get box size
        $sql = "SELECT *, ROUND((depth*width*height),2) as size FROM supply WHERE supply_type = 'BOX' ORDER BY size ASC";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($cart_dimensions <= $row["size"]){
                    $cart_width = $row["width"];
                    $cart_height = $row["height"];
                    $cart_depth = $row["depth"];
                    $cart_weight = $cart_weight+$row['weight'];
                    $cart_dimensions = $row["size"];
                    break;
                }
            }
        }

        /*             $stotal_tx = $stotal_tx - $coupon_saving;
        $tvq = round(($stotal_tx/100)*9.975,2);
        $tps = round(($stotal_tx/100)*5,2);
        $gtotal = $stotal +$tps +$tvq - $coupon_saving; */
        if ($CIE_HIDE_PRICE == "true"){
            echo "<hr><div style='width:100%;text-align:right;font-family:  var(--dw3_form_font);vertical-align:top;display:none;'>";
        } else {
            echo "<hr><div style='width:100%;text-align:right;font-family:  var(--dw3_form_font);vertical-align:top;'>";
        }
        if ($USER_LANG == "FR"){
            if (trim($CIE_TRANSPORT) == "POSTE_CANADA" && $ship_required == true) {
                echo "<div style='vertical-align:top;background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;min-width:250px;max-width:400px;text-align:left;'>
                Choisissez un mode de livraison:
                <select class='multiple' size='4' id='trpTYPE' onchange='getRATE();' style='font-size:17px;text-align:center;'>
                <option selected value='PICKUP'>Ramasser en magasin</option>";
                echo "<option value='DOM.RP'>Poste Canada Régulier</option>";
                echo "<option value='DOM.EP'>Poste Canada Accéléré</option>";
                echo "<option value='DOM.XP'>Poste Canada Express</option></select>";
                echo "<div id='pickup_adress_type' style='font-size:0.7em;min-height:19px;display:inline-block;'>Ramasser à: </div>";
                echo "<div id='pickup_adress_zone' style='font-weight:bold;font-size:0.7em;padding:5px;min-height:19px;'>".$location_adress."</div>";
            } else if (trim($CIE_TRANSPORT) == "MONTREAL_DROPSHIP" && $ship_required == true){
                //kg to lb for MONTREAL_DROPSHIP
                //$cart_weight = $cart_weight * 2.20462; will be defined in the quote.php file
                echo "<div style='vertical-align:top;background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;min-width:250px;max-width:400px;text-align:left;'>
                Choisissez un mode de livraison:
                <select class='multiple' size='3' id='trpTYPE' onchange='changeRATE2();' style='font-size:17px;text-align:center;'>
                <option value='PICKUP'"; if ($transport_code == "PICKUP" || $transport_code == ""){ echo "selected";} echo ">Ramasser en magasin</option>";
                echo "<option value='REGULAR'"; if ($transport_code == "REGULAR"){ echo "selected";} echo ">Livraison régulière</option>";
                echo "<option value='EXPRESS '"; if ($transport_code == "EXPRESS"){ echo "selected";} echo ">Livraison accélérée</option></select>";
                echo "<div id='pickup_adress_type' style='font-size:0.7em;min-height:19px;display:inline-block;'>Ramasser à: </div> <div id='pickup_adress_zone' style='font-weight:bold;font-size:0.7em;padding:10px 0px 0px 5px;min-height:19px;display:inline-block;'>".$location_adress."</div>";
            } else if (trim($CIE_TRANSPORT) == "INTERNAL" && $ship_required == true){
                echo "<div style='vertical-align:top;background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;min-width:250px;max-width:400px;text-align:left;'>
                Choisissez un mode de livraison:
                <select class='multiple' size='3' id='trpTYPE' onchange='changeRATE3();' style='font-size:17px;text-align:center;'>
                <option value='PICKUP'"; if ($transport_code == "PICKUP" || $transport_code == ""){ echo "selected";} echo ">Ramasser en magasin</option>";
                echo "<option value='INTERNAL'"; if ($transport_code == "INTERNAL"){ echo "selected";} echo ">Livraison</option></select>";
                echo "<div id='pickup_adress_type' style='font-size:0.7em;min-height:19px;display:inline-block;'>Ramasser à: </div> <div id='pickup_adress_zone' style='font-weight:bold;font-size:0.7em;padding:10px 0px 0px 5px;min-height:19px;display:inline-block;'>".$location_adress."</div>";
            } else if (trim($CIE_TRANSPORT) == "PICKUP" && $ship_required == true){
                echo "<div style='vertical-align:top;background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;min-width:250px;max-width:400px;text-align:left;'>
                Livraison non-disponible
                <select class='multiple' size='3' style='font-size:17px;text-align:center;'>
                <option value='PICKUP' selected >Ramasser en magasin</option></select>";
                echo "<div id='pickup_adress_type' style='font-size:0.7em;min-height:19px;display:inline-block;'>Ramasser à: </div> <div id='pickup_adress_zone' style='font-weight:bold;font-size:0.7em;padding:10px 0px 0px 5px;min-height:19px;display:inline-block;'>".$location_adress."</div>";
            }
            //delivery/pickup date details
                if ($transport_code == "PICKUP" || $transport_code == ""){ $dsp_pick_date = "inline-block";} else { $dsp_pick_date = "none";}
                if ($CIE_PICK_CAL == "PICK_DATE"){
                    $txt_estimated_date = "Veuillez choisir un moment pour ramasser la commande.";
                    echo "<div style='text-align:center;width:100%;'><button id='btnOPEN_CAL' onclick='openCALENDAR()' style='margin:10px;display:".$dsp_pick_date.";'>Choisir une date et <br>une heure de ramassage</button></div>";
                    echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;min-height:19px;'>".$txt_estimated_date."</div></div>";
                } else if($CIE_PICK_CAL == "CALL"){
                    $txt_estimated_date = "Vous serez contactés pour ramasser la commande.";
                    echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;min-height:19px;'>".$txt_estimated_date."</div></div>";
                } else if($CIE_PICK_CAL == "DELAY"){
                    $txt_estimated_date = "Vous pouvez venir ramasser votre commande dans ".$CIE_PK_F1." ".$CIE_PK_F2;
                    echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;min-height:19px;'>".$txt_estimated_date."</div></div>";
                } else {
                    $txt_estimated_date = "";
                    echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;min-height:19px;'>".$txt_estimated_date."</div></div>";
                }

            echo "<div style='vertical-align:top;background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;min-width:250px;max-width:400px;text-align:right;'>
                Sous-total: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($stotal+$coupon_saving,2,"."," ")."$</div><hr>";
                if ($coupon_saving > 0){
                    echo "Rabais ".$coupon_desc.": <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>-".number_format($coupon_saving,2,"."," ")."$</div><hr>";
                }
                echo "+TPS 5%: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($tot_tps,2,"."," ")."$</div><hr>
                +TVQ 9.975%: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($tot_tvq,2,"."," ")."$</div><hr>";
                if (trim($CIE_TRANSPORT) != "" && trim($CIE_TRANSPORT) != "INTERNAL" && $is_transport_free == false && $ship_required == true) {
                    echo "Transport : <div id='transportRate' style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($transport,2,"."," ")."$</div><hr>";
                } else if ($ship_required == true){
                    echo "Transport : <div id='transportRate' style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($transport,2,"."," ")."$</div><hr>";
                }
                echo "TOTAL: <div id='cartGTOT' style='width:120px;display:inline-block;font-family:Roboto-Light;font-weight:bold;'>".number_format($gtotal,2,"."," ")."$</div>
                        <div style='width:100%; text-align:left;'><img src='/pub/img/dw3/flag-canada.svg' style='width:20px;'> <span style='font-size:12px;'>Tous les prix sont en CAD</span></div>";
        }else{
            if (trim($CIE_TRANSPORT) == "POSTE_CANADA" && $ship_required == true) {
                echo "<div style='background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;min-width:250px;max-width:400px;text-align:left;'>
                Select a delivery mode:
                <select class='multiple' size='4' id='trpTYPE' onchange='getRATE();' style='font-size:17px;text-align:center;'>
                <option selected value='PICKUP'>Pickup in store</option>";
                echo "<option value='DOM.RP'>Poste Canada Regular</option>";
                echo "<option value='DOM.EP'>Poste Canada Expedited</option>";
                echo "<option value='DOM.XP'>Poste Canada Express</option></select>";
                echo "<div id='pickup_adress_type' style='font-size:0.7em;min-height:19px;display:inline-block;'>Pickup adress: </div><div id='pickup_adress_zone' style='font-weight:bold;font-size:0.7em;padding:10px 0px 0px 5px;min-height:19px;display:inline-block;'>".$location_adress."</div>";
            }  else if (trim($CIE_TRANSPORT) == "MONTREAL_DROPSHIP" && $ship_required == true){
                echo "<div style='background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;min-width:250px;max-width:400px;text-align:left;'>
                Select a delivery mode:
                <select class='multiple' size='3' id='trpTYPE' onchange='changeRATE2();' style='font-size:17px;text-align:center;'>
                <option selected value='PICKUP'"; if ($transport_code == "PICKUP"){ echo "selected";} echo ">Pickup in store</option>";
                echo "<option value='REGULAR'"; if ($transport_code == "REGULAR"){ echo "selected";} echo ">Regular delivery</option>";
                echo "<option value='EXPRESS'"; if ($transport_code == "EXPRESS"){ echo "selected";} echo ">Accelerated delivery</option></select>";  
                echo "<div id='pickup_adress_type' style='font-size:0.7em;min-height:19px;display:inline-block;'>Pickup adress: </div> <div id='pickup_adress_zone' style='font-weight:bold;font-size:0.7em;padding:5px;min-height:19px;'>".$location_adress."</div>";    
                echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;padding:5px;min-height:19px;'></div>";  
            } else if (trim($CIE_TRANSPORT) == "INTERNAL" && $ship_required == true){
                echo "<div style='vertical-align:top;background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;min-width:250px;max-width:400px;text-align:left;'>
                Select a delivery mode:
                <select class='multiple' size='3' id='trpTYPE' onchange='changeRATE3();' style='font-size:17px;text-align:center;'>
                <option value='PICKUP'"; if ($transport_code == "PICKUP" || $transport_code == ""){ echo "selected";} echo ">Pickup in store</option>";
                echo "<option value='INTERNAL'"; if ($transport_code == "INTERNAL"){ echo "selected";} echo ">Delivery</option>";
                echo "<div id='pickup_adress_type' style='font-size:0.7em;min-height:19px;display:inline-block;'>Pickup adress: </div> <div id='pickup_adress_zone' style='font-weight:bold;font-size:0.7em;padding:10px 0px 0px 5px;min-height:19px;display:inline-block;'>".$location_adress."</div>";
                echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;min-height:19px;'></div>";
            } else if (trim($CIE_TRANSPORT) == "PICKUP" && $ship_required == true){
                echo "<div style='vertical-align:top;background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;min-width:250px;max-width:400px;text-align:left;'>
                Delivery not available
                <select class='multiple' size='3' style='font-size:17px;text-align:center;'>
                <option value='PICKUP' selected >Pickup in store</option></select>"; 
                echo "<div id='pickup_adress_type' style='font-size:0.7em;min-height:19px;display:inline-block;'>Pickup adress: </div> <div id='pickup_adress_zone' style='font-weight:bold;font-size:0.7em;padding:10px 0px 0px 5px;min-height:19px;display:inline-block;'>".$location_adress."</div>";
                echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;min-height:19px;'></div>";
            }
                //delivery/pickup date details
                if ($transport_code == "PICKUP" || $transport_code == ""){ $dsp_pick_date = "inline-block";} else { $dsp_pick_date = "none";}
                if ($CIE_PICK_CAL == "PICK_DATE"){
                    $txt_estimated_date = "Please choose moment to pickup your order.";
                    echo "<div style='text-align:center;width:100%;'><button id='btnOPEN_CAL' onclick='openCALENDAR()' style='margin:10px;display:".$dsp_pick_date.";'>Choisir une date et <br>une heure de ramassage</button></div>";
                    echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;min-height:19px;'>".$txt_estimated_date."</div></div>";
                } else if($CIE_PICK_CAL == "CALL"){
                    $txt_estimated_date = "You will be contacted to pickup your order.";
                    echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;min-height:19px;'>".$txt_estimated_date."</div></div>";
                } else if($CIE_PICK_CAL == "DELAY"){
                    $txt_estimated_date = "You can pickup your order in ".$CIE_PK_F1." ".$CIE_PK_F2;
                    echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;min-height:19px;'>".$txt_estimated_date."</div></div>";
                } else {
                    $txt_estimated_date = "";
                    echo "<div id='delivery_estimated_date' style='vertical-align:middle;width:100%;font-weight:bold;font-size:0.7em;min-height:19px;'>".$txt_estimated_date."</div></div>";
                }
            echo "<div style='width:100%;text-align:right;font-family:  var(--dw3_form_font);'><div style='background:rgba(255,255,255,0.8);color:#222;padding:15px 15px 5px 15px;border-radius:3px;box-shadow:0px 0px 6px 2px green;margin:15px;display:inline-block;min-width:250px;max-width:400px;text-align:right;'>
                Subtotal: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($stotal+$coupon_saving,2,"."," ")."$</div><hr>";
                if ($coupon_saving > 0){
                    echo "Discount ".$coupon_desc.": <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>-".number_format($coupon_saving,2,"."," ")."$</div><hr>";
                }
                echo "+TPS 5%: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($tot_tps,2,"."," ")."$</div><hr>
                +TVQ 9.975%: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($tot_tvq,2,"."," ")."$</div><hr>";
                if (trim($CIE_TRANSPORT) != "" && trim($CIE_TRANSPORT) != "INTERNAL" && $is_transport_free == false && $ship_required == true) {
                    echo "Transport : <div id='transportRate' style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($transport,2,"."," ")."$</div><hr>";
                } else if ($ship_required == true){
                    echo "Transport : <div id='transportRate' style='width:120px;display:inline-block;font-family:Roboto-Light;'>".number_format($transport,2,"."," ")."$</div><hr>";
                }
                echo "TOTAL: <div id='cartGTOT' style='width:120px;display:inline-block;font-family:Roboto-Light;font-weight:bold;'>".number_format($gtotal,2,"."," ")."$</div>
                <div style='width:100%; text-align:left;'><img src='/pub/img/dw3/flag-canada.svg' style='width:20px;'> <span style='font-size:12px;'>All prices are in CAD</span></div>";
        }
        
        echo "</div></div><br>";
        echo "<div style='width:100%;text-align:right;font-family:  var(--dw3_form_font);vertical-align:top;'>";
        if ($USER_LANG == "FR"){ 
            if ($CIE_CART_ACT == "CHECKOUT" && $CIE_CART_API == "STRIPE" && $CIE_STRIPE_KEY != ""){
                echo "<button id='btnCartToCheckout' class='green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('cartTOcheckout');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span> Passer à la caisse</button> </div>"; 
            } else if ($CIE_CART_ACT == "CHECKOUT" && $CIE_CART_API == "SQUARE" && ($CIE_SQUARE_KEY != "" || $CIE_SQUARE_DEV != "")){           
                echo "<button id='btnCartToCheckout' class='green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('cartTOsquare');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span> Passer à la caisse</button> </div>";             
            } else if ($CIE_CART_ACT == "CHECKOUT" && $CIE_CART_API == "PAYPAL" && $CIE_PAYPAL_KEY != ""){           
                echo "<button id='btnCartToCheckout' class='green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('cartTOpaypal');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span> Passer à la caisse</button> </div>";             
            } else if ($CIE_CART_ACT == "ORDER" || $CIE_CART_ACT == ""){           
                echo "<button id='btnCartToOrder' class='green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('cartTOorder');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>navigate_next</span> Confirmer la commande</button> </div>"; 
            } else if ($CIE_CART_ACT == "INVOICE"){ 
                if ($CIE_DU_F2 == "day"){if ($CIE_DU_F1 == "1"){$due_text = "jour";}else{$due_text = "jours";} }        
                if ($CIE_DU_F2 == "week"){if ($CIE_DU_F1 == "1"){$due_text = "semaine";}else{$due_text = "semaines";}}          
                if ($CIE_DU_F2 == "month"){$due_text = "mois";} 
                if ($CIE_DU_F1 == "" || $CIE_DU_F1 == ""){$CIE_DU_F1 = "";$due_text = " paiement: payer sur réception";}         
                echo "<button id='btnCartToInvoice' class='no-effect green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('cartTOinvoice');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>navigate_next</span> Recevoir la facture</button> <br><span style='padding:5px;font-size:0.8em;background:#ddd;color:#444;border-radius:4px;border:1px solid #555;'>La facture vous sera envoyé par courriel.<br>Échéance de ".$CIE_DU_F1." ".$due_text.".</span></div>"; 
            }
        }else {
            if ($CIE_CART_ACT == "CHECKOUT" && $CIE_CART_API == "STRIPE" && $CIE_STRIPE_KEY != ""){
                echo "<button id='btnCartToCheckout' class='green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('cartTOcheckout');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span> Proceed to checkout</button> </div>"; 
            } else if ($CIE_CART_ACT == "CHECKOUT" && $CIE_CART_API == "SQUARE" && ($CIE_SQUARE_KEY != "" || $CIE_SQUARE_DEV != "")){           
                echo "<button id='btnCartToCheckout' class='green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('cartTOsquare');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span> Proceed to checkout</button> </div>";             
            } else if ($CIE_CART_ACT == "CHECKOUT" && $CIE_CART_API == "PAYPAL" && $CIE_PAYPAL_KEY != ""){           
                echo "<button id='btnCartToCheckout' class='green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('cartTOpaypal');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span> Proceed to checkout</button> </div>";             
            } else  if ($CIE_CART_ACT == "ORDER" || $CIE_CART_ACT == ""){            
                echo "<button id='btnCartToOrder' class='green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('cartTOorder');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>navigate_next</span> Confirm order</button> </div>"; 
            } else if ($CIE_CART_ACT == "INVOICE"){ 
                if ($CIE_DU_F2 == "day"){if ($CIE_DU_F1 != "1"){$due_text = "days";}else{$due_text = "day";}}        
                if ($CIE_DU_F2 == "week"){if ($CIE_DU_F1 != "1"){$due_text = "weeks";}else{$due_text = "week";}}          
                if ($CIE_DU_F2 == "month"){if ($CIE_DU_F1 != "1"){$due_text = "months";}else{$due_text = "month";}}  
                if ($CIE_DU_F1 == "" || $CIE_DU_F1 == ""){$CIE_DU_F1 = "";$due_text = " Pay on reception ";}        
                echo "<button id='btnCartToInvoice' class='no-effect green' style='margin:0px 30px 10px 0px;' onclick=\"updCLI('cartTOinvoice');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>navigate_next</span> Receive the invoice</button> <br><span style='padding:5px;font-size:0.8em;background:#ddd;color:#444;border-radius:4px;border:1px solid #555;'>The invoice will be sent to you by email.<br>".$CIE_DU_F1." ".$due_text." terms.</span></div>"; 
            }
        }
    }
echo "</div>";
//________________
// MES ABONNEMENTS
//‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
if(isset($_COOKIE["SUBSCRIBE"])) {
    $sub_prd_id = $_COOKIE["SUBSCRIBE"];
} else {
    $sub_prd_id = "";
}
    ?>
    <h4 onclick="toggleSub('divSub15','up15');" style="display:<?php if ($DASH_SUBSCRIBE == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
        <span class="material-icons">autorenew</span> <?php if ($USER_LANG == "FR"){ echo "Mes abonnements"; }else{echo "My subscriptions";}?> <span id='up15' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
    </h4>
    <div class='divMAIN' id='divSub15' style='<?php if ($DASH_SUBSCRIBE == "1" && $sub_prd_id != ""){ echo "display:inline-block;height:auto;"; }else{echo "display:none;height:0px;";}?>background-color:rgba(0,0,0,0.1);'>
        <?php 
            //En achat
            $sql = "SELECT * FROM product WHERE id = '" . $sub_prd_id . "' AND id NOT IN 
            (SELECT product_id FROM invoice_line WHERE head_id IN 
            (SELECT id FROM invoice_head WHERE customer_id = '" . $USER . "' AND stat <> 3 AND subscription_stat <> 'canceled' OR customer_id = '" . $USER . "' AND date_renew > NOW()));";
            //echo $sql;
            $result = $dw3_conn->query($sql);
            $row_count = $result->num_rows;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $line_price = floatval($row["price1"]);
                    $line_tps = 0;
                    $line_tvp = 0;
                    //image
                    $filename= $row["url_img"];
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    } else {
                        if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        }else{
                            $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                        }
                    }

                    //verif is promo applicable
                    $date_promo = new DateTime($row["promo_expire"]);
                    $now = new DateTime();
                    if($date_promo > $now && $line_price > $row["promo_price"] && $line_price > $row["promo_price"] && $row["promo_price"] >= 0) {
                        $line_price = $row["promo_price"];
                    }
                    //taxes
                    if ($row["tax_fed"] == "1"){
                        if ($PTPS != ""){
                            $line_tps = round(($line_price*$PTPS)/100,2);
                        } else if ($PTVH != ""){
                            $line_tps = round(($line_price*$PTVH)/100,2);
                        }
                    }
                    if ($row["tax_prov"] == "1"){
                        $line_tvp = round(floatval(($line_price*$line_qty)*$PTVP)/100,2);
                    }
                    //billing cycle
                    if ($row["billing"] == "HEBDO"){
                        $billing_desc_en = "week";
                        $billing_desc_fr = "semaine";
                    } else if ($row["billing"] == "MENSUEL"){
                        $billing_desc_en = "month";
                        $billing_desc_fr = "mois";
                    } else if ($row["billing"] == "ANNUEL"){
                        $billing_desc_en = "year";
                        $billing_desc_fr = "an";
                    } else {
                        $billing_desc_en = $row["billing"];
                        $billing_desc_fr = $row["billing"];
                    }
                    //formattage du prix
                    $line_price = $line_price + $line_tps + $line_tvp;
                    if (floor($line_price) == $line_price){
                        $line_price = number_format($line_price, 0, '.', '');
                    } else {
                        $line_price = number_format($line_price, 2, '.', '');
                    }
                    $RNDSEQ = rand(10000,99999);
                    echo "<div class='divBOX' style='text-align:center;'><img class='photo' style='border:0px;height:100px;width:auto;max-width:100%;' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./pub/img/dw3/nd.png\";'>";
                    if ($USER_LANG == "FR"){
                        echo "<br><span style='font-size:1.2em;'>" . $row["name_fr"] . "</span><table class='tblDATA' style='margin:10px 0px;'>";
                        echo "<tr><th>Prix:</th><td style='text-align:center;'>" . $line_price . "$ / ".$billing_desc_fr."</td></tr>";
                        echo "<tr><th>Status:</th><td style='text-align:center;'>Inactif</td></tr>";
                        echo "</table>";
                        echo "<button class='green' id='btnPrdToCheckout' onclick=\"stripe_pay_subscription('".$row["id"]."')\"><span class='material-icons'>shopping_cart_checkout</span> S'abonner</button>";
                    } else {
                        echo "<br><span style='font-size:1.2em;'>" . $row["name_en"] . "</span><table class='tblDATA' style='margin:10px 0px;'>";
                        echo "<tr><th>Price:</th><td style='text-align:center;'>" . $line_price . "$ / ".$billing_desc_en."</td></tr>";
                        echo "<tr><th>Status:</th><td style='text-align:center;'>Inactive</td></tr>";
                        echo "</table>";
                        echo "<button class='green' id='btnPrdToCheckout' onclick=\"stripe_pay_subscription('".$row["id"]."')\"><span class='material-icons'>shopping_cart_checkout</span> Subscribe</button>";
                    }
                    echo "</div>";
                }
            }
            //Facturé
            $sql = "SELECT A.*, B.subscription_stat AS subscription_stat, 
            C.name_fr AS name_fr, C.name_en AS name_en , C.url_img AS url_img,C.tax_fed AS tax_fed, C.tax_prov AS tax_prov, 
            C.promo_price AS promo_price, C.promo_expire AS promo_expire, C.billing AS billing, D.date_renew AS date_renew
            FROM invoice_line A
            LEFT JOIN invoice_head B ON A.head_id = B.id
            LEFT JOIN order_head D ON D.id = B.order_id
            LEFT JOIN product C ON A.product_id = C.id
            WHERE B.customer_id = '" . $USER . "' AND B.subscription_stat <> '' AND B.subscription_stat <> 'canceled' OR B.customer_id = '" . $USER . "' AND D.date_renew > NOW();";
            $result = $dw3_conn->query($sql);
            $row_count2 = $result->num_rows;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $line_price = floatval($row["price"]);
                    $line_tps = 0;
                    $line_tvp = 0;
                    //image
                    $filename= $row["url_img"];
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    } else {
                        if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        }else{
                            $filename = "/fs/product/" . $row["product_id"] . "/" . $filename;
                        }
                    }

                    //verif is promo applicable
                    $date_promo = new DateTime($row["promo_expire"]);
                    $now = new DateTime();
                    if($date_promo > $now && $line_price > $row["promo_price"] && $line_price > $row["promo_price"] && $row["promo_price"] >= 0) {
                        $line_price = $row["promo_price"];
                    }
                    if ($row["tax_fed"] == "1"){
                        if ($PTPS != ""){
                            $line_tps = round(($line_price*$PTPS)/100,2);
                        } else if ($PTVH != ""){
                            $line_tps = round(($line_price*$PTVH)/100,2);
                        }
                    }
                    if ($row["tax_prov"] == "1"){
                        $line_tvp = round(floatval(($line_price*$line_qty)*$PTVP)/100,2);
                    }
                    //billing cycle
                    if ($row["billing"] == "HEBDO"){
                        $billing_desc_en = "week";
                        $billing_desc_fr = "semaine";
                    } else if ($row["billing"] == "MENSUEL"){
                        $billing_desc_en = "month";
                        $billing_desc_fr = "mois";
                    } else if ($row["billing"] == "ANNUEL"){
                        $billing_desc_en = "year";
                        $billing_desc_fr = "an";
                    } else {
                        $billing_desc_en = $row["billing"];
                        $billing_desc_fr = $row["billing"];
                    }
                    //formattage du prix
                    $line_price = $line_price + $line_tps + $line_tvp;
                    if (floor($line_price) == $line_price){
                        $line_price = number_format($line_price, 0, '.', '');
                    } else {
                        $line_price = number_format($line_price, 2, '.', '');
                    }
                    $RNDSEQ = rand(10000,99999);
                    echo "<div class='divBOX' style='text-align:center;'><img class='photo' style='border:0px;height:100px;width:auto;max-width:100%;' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./pub/img/dw3/nd.png\";'>";
                    if ($USER_LANG == "FR"){
                        if ($row["subscription_stat"] == "expired"){
                            $sub_stat = "Expiré";
                        } else if ($row["subscription_stat"] == "active"){
                            $sub_stat = "Actif";
                        } else if ($row["subscription_stat"] == "canceled"){
                            $sub_stat = "Annulé";
                        } else if ($row["subscription_stat"] == "unpaid"){
                            $sub_stat = "Impaye";
                        } else {
                            $sub_stat = $row["subscription_stat"];
                        }
                        echo "<br><span style='font-size:1.2em;'>" . $row["name_fr"] . "</span><table class='tblDATA' style='margin:10px 0px;'>";
                        echo "<tr><th>Prix:</th><td style='text-align:center;'>" . $line_price . "$ / ".$billing_desc_fr."</td></tr>";
                        if ($row["subscription_stat"] == "active"){
                            echo "<tr><th>Status:</th><td style='text-align:center;'><span style='padding:2px 10px;background-color:green;color:white;border-radius:15px;'><span class='material-icons'>check_circle</span> Actif</span></td></tr>";
                            echo "<tr><th>Renouvellement:</th><td style='text-align:center;'>" . substr($row["date_renew"], 0, 10) . "</td></tr>";
                            echo "</table>";
                            echo "<button class='red' id='btnCancelSubscription' onclick=\"stripe_cancel_subscription('".$row["head_id"]."')\"><span class='material-icons'>block</span> Se désabonner</button>";
                         } else if ($row["subscription_stat"] == "expired" || $row["subscription_stat"] == "canceled" || $row["subscription_stat"] == "unpaid"){
                            echo "<tr><th>Status:</th><td style='text-align:center;'><span style='padding:2px 10px;background-color:red;color:white;border-radius:15px;'><span class='material-icons'>cancel</span> ".$sub_stat."</span></td></tr>";
                            echo "<tr><th>Expiration:</th><td style='text-align:center;'>" . substr($row["date_renew"], 0, 10) . "</td></tr>";
                            echo "</table>";
                            echo "<button class='green' id='btnPrdToCheckout' onclick=\"stripe_pay_subscription('".$row["product_id"]."')\"><span class='material-icons'>shopping_cart_checkout</span> S'abonner</button>";
                        }
                    } else {
                        if ($row["subscription_stat"] == "expired"){
                            $sub_stat = "Expired";
                        } else if ($row["subscription_stat"] == "active"){
                            $sub_stat = "Active";
                        } else if ($row["subscription_stat"] == "canceled"){
                            $sub_stat = "Canceled";
                        } else if ($row["subscription_stat"] == "unpaid"){
                            $sub_stat = "Unpaid";
                        } else {
                            $sub_stat = $row["subscription_stat"];
                        }
                        echo "<br><span style='font-size:1.2em;'>" . $row["name_en"] . "</span><table class='tblDATA' style='margin:10px 0px;'>";
                        echo "<tr><th>Price:</th><td style='text-align:center;'>" . $line_price . "$ / ".$billing_desc_en."</td></tr>";
                        if ($row["subscription_stat"] == "active"){
                            echo "<tr><th>Status:</th><td style='text-align:center;'><span style='padding:2px 10px;background-color:green;color:white;border-radius:15px;'><span class='material-icons'>check_circle</span> Active</span></td></tr>";
                            echo "<tr><th>Renew:</th><td style='text-align:center;'>" . substr($row["date_renew"], 0, 10) . "</td></tr>";
                            echo "</table>";
                            echo "<button class='red' id='btnCancelSubscription' onclick=\"stripe_cancel_subscription('".$row["head_id"]."')\"><span class='material-icons'>block</span> Unsuscribe</button>";
                        } else if ($row["subscription_stat"] == "expired" || $row["subscription_stat"] == "canceled" || $row["subscription_stat"] == "unpaid"){
                            echo "<tr><th>Status:</th><td style='text-align:center;'><span style='padding:2px 10px;background-color:red;color:white;border-radius:15px;'><span class='material-icons'>cancel</span> ".$sub_stat."</span></td></tr>";
                            echo "<tr><th>Expiration:</th><td style='text-align:center;'>" . substr($row["date_renew"], 0, 10) . "</td></tr>";
                            echo "</table>";
                            echo "<button class='green' id='btnPrdToCheckout' onclick=\"stripe_pay_subscription('".$row["product_id"]."')\"><span class='material-icons'>shopping_cart_checkout</span> Subscribe</button>";
                        }
                    }
                    echo "</div>";
                }
            }
            if ($row_count + $row_count2 == 0){
                if ($USER_LANG == "FR"){
                    echo "<div class='divBOX' style='text-align:center;'>Aucun abonnement trouvé.</div>";
                } else {
                    echo "<div class='divBOX' style='text-align:center;'>No subscription found.</div>";
                }
            }
        ?>
    </div>
<?php

//___________
// COMMANDES
//‾‾‾‾‾‾‾‾‾‾‾   
    $sql = "SELECT * FROM order_head WHERE customer_id = '" . $USER . "' AND id NOT IN (SELECT order_id FROM invoice_head WHERE customer_id =  '" . $USER . "') ORDER BY id DESC";
    $result = $dw3_conn->query($sql);
        $QTY_ROWS = $result->num_rows??0;
        if ($QTY_ROWS < 1) { ?>
            <h4 onclick="toggleSub('divSub12','up12');" style="display:<?php if ($DASH_ORDER == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
                <span class="material-icons">grading</span> <?php if ($USER_LANG == "FR"){ echo "Mes commandes"; }else{echo "My orders";}?> <span id='up12' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
            </h4>
            <div class='divMAIN' id='divSub12' style='height:0px;display:none;background-color:rgba(0,0,0,0.1);'>
            <div class='divBOX' style='text-align:center;'><?php if ($USER_LANG == "FR"){ echo "Aucune commande non-facturée trouvée."; }else{echo "No orders not invoiced found.";}?></div>
        <?php }else{ ?>
            <h4 onclick="toggleSub('divSub12','up12');" style="display:<?php if ($DASH_ORDER == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
                <span class="material-icons">grading</span> <?php if ($USER_LANG == "FR"){ echo "Mes commandes"; }else{echo "My orders";}?> <span id='up12' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_down</span>
            </h4>
            <div class='divMAIN' id='divSub12' style="height: auto; display:<?php if ($DASH_ORDER == "1"){ echo "inline-block"; }else{echo "none";}?>;background-color:rgba(0,0,0,0.1);">
        <?php 
            while($row = $result->fetch_assoc()) {
                echo "<div class='divBOX' style='width:90%;height:auto;background:rgba(255,255,255,0.7);color:#222;margin:12px;border-radius:7px;'>
                        <table class='tblDATA'>
                            <tr><td>#ID</td><td style='text-align:center;'><b>". $row["id"] ."</b></td>";
                            if ($CIE_HIDE_PRICE == "true" || $row["total"] < 0) {
                                echo "<td style='display:none;'>Sous-Total</td><td style='text-align:center;display:none;'><b>". round($row["total"],2) ."</b>$</td></tr>";
                            } else {
                                echo "<td width='25%'>Sous-Total</td><td width='25%' style='text-align:right;'><b>". round($row["total"],2) ."</b>$</td></tr>";
                            }
                        echo "</table>";
                if ($row["ship_type"]=="PICKUP"){
                    echo "
                    <div class='divBOX' >Adresse d'expédition:<br><b>Ramasser en magasin</b></div>";
                } else {
                echo "
                    <div class='divBOX' >Adresse d'expédition:<br><b>                
                        ". dw3_decrypt($row["adr1"]). " ".  dw3_decrypt($row["adr2"]). "<br>
                        ".  $row["city"]. ",
                        ".  $row["prov"]. "<br>
                        ".  $row["country"]. ",
                        ".  $row["postal_code"]. "</b>                            
                    </div>";
                }
                if ($USER_LANG == "FR"){
                    echo "<br><button style='margin:10px;' onclick=\"getORDERlines('".$row["id"]."');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>info</span> Détails</button>";
                    echo "<button style='float:right;margin:10px;' onclick=\"orderExpeds('".$row["id"]."');\"> Expéditions <span class='material-icons' style='font-size:24px;vertical-align:middle;'>local_shipping</span> </button>";
                } else {
                    echo "<br><button style='margin:10px;' onclick=\"getORDERlines('".$row["id"]."');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>info</span> Details</button>";
                    echo "<button style='float:right;margin:10px;' onclick=\"orderExpeds('".$row["id"]."');\"> Expeditions <span class='material-icons' style='font-size:24px;vertical-align:middle;'>local_shipping</span> </button>";
                }
                    //echo "<button style='display:none;float:right;margin:0px 30px 30px 0px;' onclick=\"orderTOfct('".$row["id"]."');\"> Payer <span class='material-icons' style='font-size:24px;vertical-align:middle;'>navigate_next</span> </button>";
                echo "</div>";
            }
  
        }
        echo "</div>";

//__________
// FACTURES
//‾‾‾‾‾‾‾‾‾‾
    $sql = "SELECT A.*, IFNULL(B.total_paid,0) as total_paid
    FROM invoice_head A 
    LEFT JOIN (SELECT invoice_id, IFNULL(SUM(ROUND(paid_amount,2)),0) as total_paid FROM transaction WHERE payment_status = 'succeeded' GROUP BY invoice_id) B ON B.invoice_id = A.id
    WHERE A.customer_id = '" . $USER . "' AND A.stat=1 AND subscription_stat = '' ORDER BY A.id DESC";
    //die ($sql);
    $result = $dw3_conn->query($sql);
/*     if ($result->num_rows??0 == 0) {
        echo "<div class='divMAIN' id='divSub7' style='height:0px;display:none;'>";
        echo "Aucun résultat trouvé..";
    }else{	
        echo "<div class='divMAIN' id='divSub7'>"; */
            $QTY_ROWS = $result->num_rows??0;
            if ($QTY_ROWS < 1) { ?>
            <h4 onclick="toggleSub('divSub7','up7');" style="display:<?php if ($DASH_INVOICE == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
                <span class="material-icons">receipt_long</span> <?php if ($USER_LANG == "FR"){ echo "Mes factures"; }else{echo "My invoices";}?><span id='up7' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
            </h4>
            <div class='divMAIN' id='divSub7' style='height:0px;display:none;background-color:rgba(0,0,0,0.1);'>
            <div class='divBOX' style='text-align:center;'><?php if ($USER_LANG == "FR"){ echo "Aucunes factures actives dans le dossier."; }else{echo "No active invoice found.";}?></div>
        <?php }else{ ?>
            <h4 onclick="toggleSub('divSub7','up7');" style="display:<?php if ($DASH_INVOICE == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
                <span class="material-icons">receipt_long</span> <?php if ($USER_LANG == "FR"){ echo "Mes factures"; }else{echo "My invoices";}?> <span id='up7' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_down</span>
            </h4>
            <div class='divMAIN' id='divSub7' style="height: auto; display:<?php if ($DASH_INVOICE == "1"){ echo "inline-block"; }else{echo "none";}?>;background-color:rgba(0,0,0,0.1);">
        <?php 
        if ($USER_LANG == "FR"){
            echo "<table class='tblDATA'><tr><th style='text-align:center;'>#</th><th>Échéance</th><th>Total</th><th style='text-align:center;'>État</th><th></th><th></th></tr>";
        } else {
            echo "<table class='tblDATA'><tr><th style='text-align:center;'>#</th><th>Due</th><th>Total</th><th style='text-align:center;'>Stat</th><th></th><th></th></tr>";
        }
            while($row = $result->fetch_assoc()) {
                echo "<tr style='font-size:0.8em;'><td style='text-align:center;'><b>". $row["id"] ."</b></td>
                          <td style='text-align:left;'>". substr($row["date_due"],0,10)."</td>
                          <td style='text-align:left;'>". number_format($row["total"],2,"."," ") ."$</td>";
                    if($row["stat"] == "0" || $row["stat"] == "1"){
                        if ($USER_LANG == "FR"){
                            echo "<td style='text-align:center;color:red;font-size:0.6em;'><b>Impayé</b></td><td width='80'>";
                            if ($CIE_STRIPE_KEY != "" && $CIE_CART_API == "STRIPE"){
                                echo "<form action='create-checkout-session.php?KEY=".  $KEY."&FCT=" . $row["id"] . "' method='POST' style='text-align:right;'>
                                        <button type='submit' style=''><span class='material-icons'>shopping_cart_checkout</span> Payer</button>
                                      </form>";
                            } else if($CIE_SQUARE_KEY != "" && $CIE_CART_API == "SQUARE"){
                                echo "<button onclick=\"square_pay_invoice('".$row["id"]."')\"><span class='material-icons'>shopping_cart_checkout</span> Payer</button>";
                            } else if($CIE_PAYPAL_USER != "" && $CIE_CART_API == "PAYPAL"){
                                if ($CIE_PAYPAL_MODE == "PROD"){
                                    $paypal_url='https://www.paypal.com/cgi-bin/webscr';
                                } else {
                                    $paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr';
                                }
                                echo "<form action='".$paypal_url."' method='post' name='frmPayPal" . $row["id"] . " 'style='text-align:right;'>
                                        <input type='hidden' name='business' value='". $CIE_PAYPAL_USER."'>
                                        <input type='hidden' name='cmd' value='_xclick'>
                                        <input type='hidden' name='item_name' value='Facture #" . $row["id"] . "'>
                                        <input type='hidden' name='item_number' value='1'>
                                        <input type='hidden' name='credits' value=''>
                                        <input type='hidden' name='userid' value='".$row["customer_id"]."'>
                                        <input type='hidden' name='amount' value='".round($row["total"]-$row["total_paid"],2)."'>
                                        <input type='hidden' name='cpp_header_image' value='https://".$_SERVER["SERVER_NAME"]."/pub/img/".$CIE_LOGO1."'>
                                        <input type='hidden' name='no_shipping' value='1'>
                                        <input type='hidden' name='currency_code' value='CAD'>
                                        <input type='hidden' name='handling' value='0'>
                                        <input type='hidden' name='cancel_return' value='https://".$_SERVER["SERVER_NAME"]."/client/paypal-cancel.php?KEY=".  $KEY."'>
                                        <input type='hidden' name='return' value='https://".$_SERVER["SERVER_NAME"]."/client/paypal-success.php?KEY=".  $KEY."&FCT=" . $row["id"] . "&FROM=cart'>
                                        <button type='submit' style=''><span class='material-icons'>shopping_cart_checkout</span> Payer</button>
                                    </form>";
                            }
                        }else{
                            echo "<td style='text-align:center;color:red;font-size:0.6em;'><b>Unpaid</b></td><td width='80'>";
                            if ($CIE_STRIPE_KEY != "" && $CIE_CART_API == "STRIPE"){
                                echo "<form action='create-checkout-session.php?KEY=".  $KEY."&FCT=" . $row["id"] . "' method='POST' style='text-align:right;'>
                                        <button type='submit' style=''><span class='material-icons'>shopping_cart_checkout</span> Pay</button>
                                      </form>";
                            } else if($CIE_SQUARE_KEY != "" && $CIE_CART_API == "SQUARE"){
                                echo "<button onclick=\"square_pay_invoice('".$row["id"]."')\"><span class='material-icons'>shopping_cart_checkout</span> Pay</button>";
                            }else if($CIE_PAYPAL_USER != "" && $CIE_CART_API == "PAYPAL"){
                                if ($CIE_PAYPAL_MODE == "PROD"){
                                    $paypal_url='https://www.paypal.com/cgi-bin/webscr';
                                    $paypal_user = $CIE_PAYPAL_USER ;
                                } else {
                                    $paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr';
                                    $paypal_user = $CIE_PAYPAL_USER_DEV;
                                }
                                echo "<form action='".$paypal_url."' method='post' name='frmPayPal" . $row["id"] . " 'style='text-align:right;'>
                                        <input type='hidden' name='business' value='". $paypal_user."'>
                                        <input type='hidden' name='cmd' value='_xclick'>
                                        <input type='hidden' name='item_name' value='Invoice #" . $row["id"] . "'>
                                        <input type='hidden' name='item_number' value='1'>
                                        <input type='hidden' name='credits' value=''>
                                        <input type='hidden' name='userid' value='".$row["customer_id"]."'>
                                        <input type='hidden' name='amount' value='".round($row["total"]-$row["total_paid"],2)."'>
                                        <input type='hidden' name='cpp_header_image' value='https://".$_SERVER["SERVER_NAME"]."/pub/img/".$CIE_LOGO1."'>
                                        <input type='hidden' name='no_shipping' value='1'>
                                        <input type='hidden' name='currency_code' value='CAD'>
                                        <input type='hidden' name='handling' value='0'>
                                        <input type='hidden' name='cancel_return' value='https://".$_SERVER["SERVER_NAME"]."/client/paypal-cancel.php?KEY=".  $KEY."'>
                                        <input type='hidden' name='return' value='https://".$_SERVER["SERVER_NAME"]."/client/paypal-success.php?KEY=".  $KEY."&FCT=" . $row["id"] . "&FROM=cart'>
                                        <button type='submit' style=''><span class='material-icons'>shopping_cart_checkout</span> Payer</button>
                                    </form>";
                            }
                        }
                    }
                    if ($USER_LANG == "FR"){
                        echo "</td><td width='75'>
                                <button style='cursor:help;' onclick='getFCT(".$row["id"].")'><span class='material-icons'>file_download</span> Voir </button>
                                <button title='Expéditions' onclick=\"orderExpeds('".$row["order_id"]."');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>local_shipping</span> </button>
                            </td></tr>";             
                    } else{
                        echo "</td><td width='75'>
                                <button style='cursor:help;' onclick='getFCT(".$row["id"].")'> <span class='material-icons'>file_download</span> </button>
                                <button title='Expeditions' onclick=\"orderExpeds('".$row["order_id"]."');\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>local_shipping</span> </button>
                            </td></tr>";             
                    }
                echo "</tr>";
            }
            echo "</table>";
        }
    ?>
    </div>
<h4 onclick="toggleSub('divSub2','up2');" style="display:<?php if ($DASH_HIST == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">inventory_2</span> <?php if ($USER_LANG == "FR"){ echo "Historique de factures"; }else{echo "Invoices history";}?> <span id='up2' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class="divMAIN" id='divSub2' style='height:0px;display:none;background-color:rgba(0,0,0,0.1);'>
<!-- HISTORIQUE DE FACTURES -->
<img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>
</div>

<h4 onclick="toggleSub('divSub8','up8');" style="display:<?php if ($DASH_PROMO == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">inventory_2</span> <?php if ($USER_LANG == "FR"){ echo "Produits et services en promotion"; }else{echo "Promotional products and services";}?> <span id='up8' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class="divMAIN" id='divSub8' style='height:0px;display:none;background-color:rgba(0,0,0,0.1);'>
    <?php 
//______________________
// PRODUITS EN PROMO
//‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾    
    $sql = "SELECT *
            FROM product
            WHERE stat = 0 AND web_dsp = 1
            AND promo_expire > CURRENT_TIMESTAMP()
            ORDER BY promo_price ASC, id DESC";

    $result = $dw3_conn->query($sql);
    $QTY_ROWS = $result->num_rows??0;
    if ($QTY_ROWS > 0) { 
            while($row = $result->fetch_assoc()) {
                $RNDSEQ=rand(100,100000);
                $filename= $row["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                    }
                }
                $line_price = $row["price1"];
                $date_promo = new DateTime($row["promo_expire"]);
                $now = new DateTime();
                if($date_promo > $now) {
                    $line_price = $row["promo_price"];
                }
                echo "<div style='width:320px;display:inline-block;background:rgba(0,0,0,0);color:#222;margin:12px;border-radius:10px;border:0px;'>
                        <table class='tblDATA' style='width:100%;width:320px;border-radius:10px;border:0px;'>
                            <tr style='cursor:help;border-top-right-radius:10px;border-top-left-radius:10px;border:0px;' onclick=\"getPRD('". $row["id"] . "');\">"
                            . "<th style='text-align:center;border-top-right-radius:10px;border-top-left-radius:10px;cursor:help;border:0px;'><b>". strtoupper($row["name_fr"]) ."</b></th></tr>
                            <tr style='cursor:help;' onclick=\"getPRD('". $row["id"] . "');\">"
                                . "<td style='text-align:center;background-color:#fff;color:#333;'><img class='photo' style='height:100px;width:auto;max-width:100%;' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./pub/img/dw3/nd.png\";'></td></tr>";
                    if ( trim($row["price_text_fr"]) == "") {
                        $plitted = explode(".",$line_price);
                        $whole = $plitted[0]??$line_price;
                        $fraction = $plitted[1]??0;
                        if ($fraction == 0){$fraction = ".00";}else{$fraction = ".".$fraction;}
                            echo "<tr style='cursor:help;' onclick=\"getPRD('". $row["id"] . "');\"><td style='text-align:center;background-color:#fff;color:#333;'><span><b>". number_format($whole) . "<sup>" . str_pad(rtrim($fraction, "0"), 3 , "0") . "</sup>". $row["price_suffix_fr"] . "</b> <span style='text-decoration: line-through;text-decoration-thickness: 2px;'>".number_format($row["price1"]). $row["price_suffix_fr"] ."</span></span></td></tr>";
                        } else { echo " <tr style='cursor:help;' onclick=\"getPRD('". $row["id"] . "');\"><td style='background-color:#fff;color:#333;'><span><b>". $row["price_text_fr"] . "</b></span></td></tr>";
                        }
                    switch ($row["btn_action1"]) {
                        case "DOWNLOAD":
                            $ACTION = 'dw3_download("' . $row["id"]  . '","' . $row["url_action1"]  . '",this);';
                        break;
                        case "INFO":
                            $ACTION = 'getPRD("' . $row["id"]  . '");';
                        break;
                        case "SUBMIT":
                            $ACTION = 'dw3_action_submit(' . $row["id"]  . ',this);';
                        break;
                        case "CART":
                            $ACTION = "dw3_cart_add(" . $row["id"]  . ",this);";
                        break;
                        case "LINK":
                            $ACTION = 'dw3_page_open("' . $row["url_action1"]  . '",this);';
                        break;
                        case "BUY":
                            $ACTION = "dw3_cart_add(" . $row["id"]  . ",this);";
                        break;
                        default:
                            $ACTION = "";
                    }
                    echo "<tr style='border:0px;border-bottom-right-radius:10px;border-bottom-left-radius:10px;'><td colspan=2 style='text-align:center;border-bottom-right-radius:10px;border-bottom-left-radius:10px;border:0px;'>";
                    if ($row["btn_action1"] != "NONE" && $row["btn_action1"] != ""){
                        echo "<button onclick='" . $ACTION . "' style=''>" . $row["web_btn_fr"] . " <span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn_icon"] . "</span></button>";
                    } else {
                        echo "<button onclick='" . $ACTION . "' style=''>" . $row["web_btn_fr"] . " <span class='material-icons' style='font-size:24px;vertical-align:middle;'>info</span> Info</button>";
                    }  

                        echo "</td></tr>
                    </table></div>";
            }
        } else {
            echo "<div class='divBOX' style='text-align:center;'>"; if ($USER_LANG == "FR"){ echo "Aucune promotion trouvée pour le moment."; }else{echo "No promotions found at this time.";} echo "</div>";            
        }
        echo "</div>";
    ?>
<!-- 
_________________________
 NOTIFICATIONS & COOKIES
‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾  -->
    <h4 onclick="toggleSub('divSub3','up3');" style="display:<?php if ($DASH_COOKIES == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">markunread_mailbox</span> Notifications & Cookies<span id='up3' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span></h4>
	<div class="divMAIN" id='divSub3' style='height:0px;display:none;'>
		<div class="divBOX"><br> Lors de la facturation:
			<select id='cfgNOTIF1'>
				<option value='EML' selected>Par courriel</option>
				<option value='SMS'>Par message texte (des frais peuvent s'appliquer)</option>
				<option value='ALL'>Les deux (courriel et message texte)</option>
			</select>
		</div>	
		<div class="divBOX"><br> Lors de l'expédition:
			<select id='cfgNOTIF2'>
				<option value='EML' selected>Par courriel</option>
				<option value='NON'>Non merci</option>
			</select>
		</div>	
		<div class="divBOX"><br> Lors d'un solde en souffrance:
			<select id='cfgNOTIF3'>
				<option value='EML' selected>Par courriel</option>
				<option value='SMS'>Par message texte (des frais peuvent s'appliquer)</option>
				<option value='ALL'>Les deux (courriel et message texte)</option>
			</select>
		</div>	
		<div class="divBOX"><br> Pour les évènements et les promotions:
			<select id='cfgNOTIF4'>
				<option value='EML' selected>Par courriel</option>
				<option value='SMS'>Par message texte (des frais peuvent s'appliquer)</option>
				<option value='ALL'>Les deux (courriel et message texte)</option>
				<option value='NON'>Non merci</option>
			</select>
		</div><br>
		<div class='divBOX' style='font-size:0.8em;'>			
            <input id='clAGREE' type='checkbox' style='float:left;vertical-align:middle;margin:2px 5px 0px 0px;'> 
            <?php if ($USER_LANG == "FR"){ 
                echo " En cochant cette case, j'accepte de recevoir des messages texte et multimédia de notre part sur le numéro de portable fourni
                et acceptez également la </span><a href='#divSub5'>politique de confidentialité</a>.
                <br>Des frais de messages et de données peuvent s'appliquer.";
            } else {
                echo " By checking this box, I agree to receive text and multimedia messages from us to the provided mobile number
                and also agree the </span><a href='#divSub5'>privacy policy</a>.
                <br>Message and data rates may apply.";                
            }?>
		</div>
		<br><br><button class='green' onclick="saveNOTIF();"><span class="material-icons">save</span>Save</button>
	</div>
<!-- 
_________
 PRIVACY 
‾‾‾‾‾‾‾‾‾  -->
	<h4 onclick="toggleSub('divSub5','up5');" style="display:<?php if ($DASH_PRIVACY == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
		<span class="material-icons">policy</span> <?php if ($USER_LANG == "FR"){ echo "Politique de confidentialité";} else {echo "Privacy policy";} ?><span id='up5' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
	</h4>
	<div class='divMAIN' id='divSub5' style='height:0px;display:none;text-align:left;'>
        <b>Accord signé numériquement le <?php echo $USER_LASTLOGIN; ?>.</b>
        <hr>  
        <pre style='max-width:100%; padding:5px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; '><?php
            $myfile = fopen($_SERVER["DOCUMENT_ROOT"] . "/legal/PRIVACY", "r")??null;
            $HTML = fread($myfile,filesize($_SERVER["DOCUMENT_ROOT"] . "/legal/PRIVACY"))??null;
            fclose($myfile);
            echo $HTML;
            ?></pre>
	</div>
<!-- 
_________
 LICENSE & CONDITIONS
‾‾‾‾‾‾‾‾‾ -->
	<h4 onclick="toggleSub('divSub4','up4');" style="display:<?php if ($DASH_LICENSE == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
		<span class="material-icons">handshake</span> <?php if ($USER_LANG == "FR"){ echo "Conditions d'utilisation";} else {echo "License Agreement";} ?><span id='up4' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
	</h4>
	<div class='divMAIN' id='divSub4' style='height:0px;display:none;text-align:left;'>
        <b>Accord signé numériquement le <?php echo $USER_LASTLOGIN; ?>.</b>
        <hr>  
        <pre style='max-width:100%; padding:5px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; '><?php
            $myfile = fopen($_SERVER["DOCUMENT_ROOT"] . "/legal/LICENSE", "r")??null;
            $HTML = fread($myfile,filesize($_SERVER["DOCUMENT_ROOT"] . "/legal/LICENSE"))??null;
            fclose($myfile);
            echo $HTML;
            ?></pre>
	</div>
<!--
_________
 RETURN
‾‾‾‾‾‾‾‾‾ -->
	<h4 onclick="toggleSub('divSub14','up14');" style="display:<?php if ($DASH_RETURN == "1"){ echo "inline-block"; }else{echo "none";}?>;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
		<span class="material-icons">handshake</span> <?php if ($USER_LANG == "FR"){ echo "Politique de transport et de retour";} else {echo "Transport & Return Policy";} ?><span id='up14' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
	</h4>
	<div class='divMAIN' id='divSub14' style='height:0px;display:none;text-align:left;'>
        <b>Accord signé numériquement le <?php echo $USER_LASTLOGIN; ?>.</b>
        <hr>  
        <pre style='max-width:100%; padding:5px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; '><?php
            $myfile = fopen($_SERVER["DOCUMENT_ROOT"] . "/legal/RETURNS.html", "r")??null;
            $HTML = fread($myfile,filesize($_SERVER["DOCUMENT_ROOT"] . "/legal/RETURNS.html"))??null;
            fclose($myfile);
            echo $HTML;
            ?></pre>
	</div>

<?php if ($USER_LANG == "FR"){ ?>
    <button style='width:90%;max-width:500px;display:none;'><span class="material-icons">phone_callback</span> Demander un rappel</button>
    <a href='tel:<?php echo $CIE_TEL1; ?>'><button style='display:<?php if ($DASH_PHONE == "1"){ echo "inline-block"; }else{echo "none";}?>;width:90%;max-width:500px;'><span class="material-icons">phone</span> <?php echo $CIE_TEL1; ?></button></a>
    <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='display:<?php if ($DASH_EML == "1"){ echo "inline-block"; }else{echo "none";}?>;width:90%;max-width:500px;'><span class="material-icons">mail</span> <?php echo $CIE_EML1; ?></button></a>
    <button style='width:90%;max-width:500px;' onclick="resetPW();"><span class="material-icons">lock_reset</span> Modifier le mot de passe</button>
    <button style='width:90%;max-width:500px;display:none;' onclick="enterCODE();"><span class="material-icons">qr_code_2</span> Entrer un code de promotion</button>
    <button style='width:90%;max-width:500px;display:none;' onclick="changeTHEME();"><span class="material-icons">monochrome_photos</span> Modifier le theme</button>
    <button class='grey' style='width:90%;max-width:500px;display:<?php if ($DASH_COMPLAINT == "1"){ echo "inline-block"; }else{echo "none";}?>;'><span class="material-icons">report</span> Commentaires / rapporter une erreur</button>
    <button class='grey' onclick='closeACCOUNT();' style='width:90%;max-width:500px;display:<?php if ($DASH_END == "1"){ echo "inline-block"; }else{echo "none";}?>;'><span class="material-icons">delete_forever</span> Fermer le compte </button>
<?php }else { ?>
    <button style='width:90%;max-width:500px;background:#444;display:none;'><span class="material-icons">phone_callback</span> Request a callback</button>
    <a href='tel:<?php echo $CIE_TEL1; ?>'><button style='width:90%;max-width:500px;'><span class="material-icons">phone</span> <?php echo $CIE_TEL1; ?></button></a>
    <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='width:90%;max-width:500px;'><span class="material-icons">mail</span> <?php echo $CIE_EML1; ?></button></a>
    <button style='width:90%;max-width:500px;' onclick="resetPW();"><span class="material-icons">lock_reset</span> Change the password</button>
    <button style='width:90%;max-width:500px;display:none;' onclick="enterCODE();"><span class="material-icons">qr_code_2</span> Enter a promotion code</button>
    <button style='width:90%;max-width:500px;display:none;' onclick="changeTHEME();"><span class="material-icons">monochrome_photos</span> Modify the theme</button>
    <button class='grey' style='width:90%;max-width:500px;display:<?php if ($DASH_COMPLAINT == "1"){ echo "inline-block"; }else{echo "none";}?>;'><span class="material-icons">report</span> Comments / report an error</button>
    <button class='grey' onclick='closeACCOUNT();' style='width:90%;max-width:500px;display:<?php if ($DASH_END == "1"){ echo "inline-block"; }else{echo "none";}?>;'><span class="material-icons">delete_forever</span> Close the account </button>
<?php } ?>

<div id="divMSG"></div>
<div id="divNEW" class="divEDITOR"></div>
<div id="divEDIT" class="divEDITOR">
	<div id='googleMap' style='width:100%;height:200px;'></div>
	<div id="divEDIT_MAIN"></div>
</div>

<div id='dw3_editor'></div>
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $CIE_GMAP_KEY; ?>"></script> -->
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']??''); ?>';
var meetingID = '<?php echo($_GET['MID']??''); ?>';
var USER = '<?php echo($USER); ?>';
var HNDL = '<?php echo($HNDL); ?>'; //1=activation, 2=confirmation de rdv
var USER_ACTIVATED = '<?php echo $USER_ACTIVATED; ?>';
var USER_ACTIVATE = '<?php if ($HNDL == "1" && $USER_ACTIVATED == "0"){ echo("1");} ?>';
var STRIPE_FROM = '<?php echo $_GET["STRIPE_FROM"]??''; ?>';
var STRIPE_RESULT = '<?php echo $_GET["STRIPE_RESULT"]??''; ?>';
var SQUARE_FROM = '<?php echo $_GET["SQUARE_FROM"]??''; ?>';
var SQUARE_RESULT = '<?php echo $_GET["SQUARE_RESULT"]??''; ?>';
var PAYPAL_FROM = '<?php echo $_GET["PAYPAL_FROM"]??''; ?>';
var PAYPAL_RESULT = '<?php echo $_GET["PAYPAL_RESULT"]??''; ?>';
var SUCCESS_FCT = '<?php echo $CURRENT_FCT??''; ?>';
var USER_LANG = '<?php echo $USER_LANG??'FR'; ?>';
var CIE_PICK_CAL = '<?php echo $CIE_PICK_CAL; ?>'; //type de ramassage
var CIE_PK_F1 = '<?php echo $CIE_PK_F1; ?>'; //delais de ramassage chiffre
var CIE_PK_F2 = '<?php echo $CIE_PK_F2; ?>'; //delais de ramassage hour/day/week/month
var CIE_TRP = '<?php echo $CIE_TRANSPORT; ?>';
var TRP_FAV = '<?php echo $transport_code??'PICKUP'; ?>';
var TRP_REQ = '<?php echo $ship_required??'0'; ?>';
var txt_estimated_date = '<?php echo $txt_estimated_date; ?>';
var ship_price = '0.00'; //ship price from api's only default 0.00
var ship_carrier = "PICKUP"; //default value
var ship_service = "PICKUP"; //default value
var ADS_LIMIT = '5';
var TABLES_LIMIT = '10';
var PROMO_OFFSET = '0';
var ORDER_OFFSET = '0';
var INVOICE_OFFSET = '0';
var HISTORIC_OFFSET = '0';
var ADS_OFFSET = '0';
var cfgHOME = "<?php echo $CIE_HOME; ?>";
var myloc;
var map;
var dw3_inactivity_time = new Date().getTime();
var pickup_date = "";

$(document).ready(function () {

    const dw3_client_msg = localStorage.getItem("dw3_client_msg");
    if (dw3_client_msg !== null && dw3_client_msg != "") {
        dw3_notif_add(dw3_client_msg);
        localStorage.setItem("dw3_client_msg", "");
    }

    //fill My Documents
    <?php if ($DASH_DOC == "1"){ echo "getUSER_DOCS();"; }?>

    if (document.querySelector(".dw3_drop_area")){
        dropArea = document.querySelector(".dw3_drop_area");
        drop_button = document.getElementById("dw3_btn_upload");
        drop_input = document.getElementById("dw3_file");
        dragText = document.getElementById("drop_header");

        drop_button.onclick = ()=>{
        drop_input.click(); //if user click on the button then the input also clicked
        file_browse(ID);
        }

        //If user Drag File Over DropArea
        dropArea.addEventListener("dragover", (event)=>{
        event.preventDefault(); //preventing from default behaviour
        });
    }

    dw3_drag_init(document.getElementById('dw3_datetime_pick'));

    if (USER_ACTIVATE=="1" || USER_ACTIVATED == "1" && HNDL == "1"){ //bug to fix here
        history.pushState({}, "", "/client/dashboard.php?KEY="+KEY);
        if (USER_LANG == "FR"){
            addMsg("Votre compte a été activé! Veuillez entrer vos informations pour completer l'inscription.<br><br><button onclick=\"toggleSub('divSub1','up1');closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        }else{
            addMsg("Your account has been activated! Please enter your information to complete the registration.<br><br><button onclick=\"toggleSub('divSub1','up1');closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        }
    } else if (HNDL == "2"){
        confirmMeeting();
    }

    if (STRIPE_RESULT=="success" || PAYPAL_RESULT=="success" || SQUARE_RESULT=="success"){
        document.getElementById("divMSG").style.display = "inline-block";
        if (USER_LANG == "FR"){
            document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
        }else{
            document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
        }
        //if (SUCCESS_FCT !=""){
            if (STRIPE_FROM=="cart" || PAYPAL_FROM=="cart" || SQUARE_FROM=="cart"){
                sendEmailInvoice2(SUCCESS_FCT);
                //sendEmailShipping('invoice',SUCCESS_FCT);
                sendEmailFinance(SUCCESS_FCT);
                writeGLS(SUCCESS_FCT);
                clear_cart();
            } else if (STRIPE_FROM=="market" || PAYPAL_FROM=="market"){
                //sendEmailInvoice2(SUCCESS_FCT);
                sendEmailRetailer(SUCCESS_FCT);
                deleteAdCookies();
                writeGLS(SUCCESS_FCT);
            } else if (STRIPE_FROM=="subscription"){
                sendEmailInvoice2(SUCCESS_FCT);
                sendEmailFinance(SUCCESS_FCT);
                writeGLS(SUCCESS_FCT);
            }
        //}
        window.history.replaceState('', '', updateURLParameter(window.location.href, "STRIPE_RESULT", ""));
        window.history.replaceState('', '', updateURLParameter(window.location.href, "PAYPAL_RESULT", ""));
        window.history.replaceState('', '', updateURLParameter(window.location.href, "SQUARE_RESULT", ""));
    } else if (STRIPE_RESULT=="error" || SQUARE_RESULT=="error" || PAYPAL_RESULT=="error" || PAYPAL_RESULT=="cancel" || document.getElementById("trpTYPE")) {
        if (STRIPE_RESULT=="error" || SQUARE_RESULT=="error" || PAYPAL_RESULT=="error" || PAYPAL_RESULT=="cancel"){
            if (USER_LANG == "FR"){
                addMsg('<h1>Peut-être un autre jour!</h1><p>Faites-nous savoir pourquoi le paiement a été annulée!<br>Veuillez communiquer avec nous.</p><br><br><button onclick="closeMSG();"><span class="material-icons" style="vertical-align:middle;">done</span>Ok</button>');
            }else{
                addMsg('<h1>Maybe another day!</h1><p>Let us know why the payment was canceled!<br>Please contact us.</p><br><br><button onclick="closeMSG();"><span class="material-icons" style="vertical-align:middle;">done</span>Ok</button>');
            }
        }
        document.getElementById("trpTYPE").value = TRP_FAV;
        if (TRP_FAV != "PICKUP" && TRP_FAV != "" && CIE_TRP == "POSTE_CANADA" && TRP_REQ == "1"){
            document.getElementById("trpTYPE").focus();
            getRATE();
        }
        if (TRP_FAV != "PICKUP" && TRP_FAV != "" && CIE_TRP == "MONTREAL_DROPSHIP" && TRP_REQ == "1"){
            document.getElementById("trpTYPE").focus();
            getRATE2();
        }
        if (TRP_FAV == "INTERNAL" && TRP_REQ == "1"){
            document.getElementById("trpTYPE").focus();
            changeRATE3();
        }
        window.history.replaceState('', '', updateURLParameter(window.location.href, "STRIPE_RESULT", ""));
        window.history.replaceState('', '', updateURLParameter(window.location.href, "PAYPAL_RESULT", ""));
        window.history.replaceState('', '', updateURLParameter(window.location.href, "SQUARE_RESULT", ""));
    }
    /* upload fichiers section mes documents */

    function updateURLParameter(url, param, paramVal){
        var TheAnchor = null;
        var newAdditionalURL = "";
        var tempArray = url.split("?");
        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp = "";

        if (additionalURL) 
        {
            var tmpAnchor = additionalURL.split("#");
            var TheParams = tmpAnchor[0];
                TheAnchor = tmpAnchor[1];
            if(TheAnchor)
                additionalURL = TheParams;

            tempArray = additionalURL.split("&");

            for (var i=0; i<tempArray.length; i++)
            {
                if(tempArray[i].split('=')[0] != param)
                {
                    newAdditionalURL += temp + tempArray[i];
                    temp = "&";
                }
            }        
        }
        else
        {
            var tmpAnchor = baseURL.split("#");
            var TheParams = tmpAnchor[0];
                TheAnchor  = tmpAnchor[1];

            if(TheParams)
                baseURL = TheParams;
        }

        if(TheAnchor)
            paramVal += "#" + TheAnchor;

        var rows_txt = temp + "" + param + "=" + paramVal;
        return baseURL + "?" + newAdditionalURL + rows_txt;
    }

    function dw3_upload_file(e,section_id) {
        e.preventDefault();
        //for each..files[0]
        const upfiles = e.dataTransfer.files;
        var is_last = false;
        for (i = 0; i < upfiles.length; i++) {
            //console.log(numbers[i]);
            fileobj = upfiles[i];
            if (i==upfiles.length-1){is_last=true;}
            js_file_upload(fileobj,section_id,is_last);
        } 
    }
    function js_file_upload(file_obj,section_id,is_last) {
        if(file_obj != undefined) {
            var form_data = new FormData();                  
            form_data.append('fileToSlide', file_obj);
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "upload_file.php?KEY=" + KEY + "&sid="+section_id, true);
            xhttp.onload = function(event) {
                addNotif(xhttp.responseText);
                if (is_last==true){
                    get_section_gallery(section_id);
                }
            }
    
            xhttp.send(form_data);
        }
    }
    function file_browse(section_id) {
    document.getElementById('dw3_file').onchange = function() {
        const upfiles = document.getElementById('dw3_file').files;
        var is_last = false;
        for (i = 0; i < upfiles.length; i++) {
            //console.log(numbers[i]);
            fileobj = upfiles[i];
            if (i==upfiles.length-1){is_last=true;}
            js_file_upload(fileobj,section_id,is_last);
        }
        //fileobj = document.getElementById('dw3_file').files[0];
        //js_file_upload(fileobj,section_id);
    };
    }

    $('#frmUPLOAD0').on('submit',function(e){
        var file = $('#fileToUpload0')[0].files[0];
            if (!file){return;}
            if (file.size > 10000000){
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = "Veuillez réduire la taille du fichier. Maximum 10MB par image.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                e.preventDefault();
                return false;
            }
            //var iPRD = document.getElementById("prID").value;
            e.preventDefault(); //prevent default form submition
            data = new FormData();
            data.append('fileToUpload0', file);
            //data.append('fileName0', document.getElementById("fileName0").value); //filename without .&extention
            //var output = document.getElementById('imgPRD');
            //output.src = URL.createObjectURL($('#fileToUpload')[0].files[0]);
            if (data){
                $.ajax({
                    type : 'post',
                    url : 'upload0.php?KEY=<?php echo $KEY;?>',
                    data : data,
                    dataTYpe : 'multipart/form-data',
                    processData: false,
                    contentType: false, 
                    beforeSend : function(){
                        document.getElementById("divFADE2").style.display = "inline-block";
                        document.getElementById("divFADE2").style.opacity = "0.6";
                        document.getElementById("divMSG").style.display = "inline-block";
                        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
                    },
                    success : function(response){

                        //response = JSON.parse(response);

                        if(response.substr(0,5) != "ERROR"){
                            //closeMSG();
                            //getFILES(document.getElementById("fileName7").value);
                            //adID = document.getElementById("fileName0").value;
                            //addNotif(response);
                            //var sFN = document.getElementById("fileToUpload0").value.replace(/^.*[\\/]/, '');
                            //sFN = adID + "." + sFN.split('.').pop();
                            //updAD_IMG(adID.substr(0, adID.lastIndexOf('.')),sFN,'1');
                            //document.getElementById("adIMG").src = "/fs/customer/"+USER+"/"+response+"?t="+Math.floor(Math.random()*1000000);
                            //document.getElementById("imgPRD").src = "";
                            //document.getElementById("fileToUpload0").value = "";
                            getUSER_DOCS();
                            document.getElementById("divMSG").innerHTML = "Téléversement terminé! <br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        }else{
                            //addNotif("Erreur avec l'image..");
                            document.getElementById("divMSG").style.display = "inline-block";
                            document.getElementById("divMSG").innerHTML = response + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        }

                    }

                }); 
            }
        });
    /* annonces image 1 */
    $('#frmUPLOAD7').on('submit',function(e){
        var file = $('#fileToUpload7')[0].files[0];
            if (!file){return;}
            if (file.size > 50000){
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = "Veuillez réduire la taille du fichier. Maximum 50kb par image.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                e.preventDefault();
                return false;
            }
            //var iPRD = document.getElementById("prID").value;
            e.preventDefault(); //prevent default form submition
            data = new FormData();
            data.append('fileToUpload7', file);
            data.append('fileName7', document.getElementById("fileName7").value); //filename without .&extention
            //var output = document.getElementById('imgPRD');
            //output.src = URL.createObjectURL($('#fileToUpload')[0].files[0]);
            if (data){
                $.ajax({
                    type : 'post',
                    url : 'upload.php?KEY=<?php echo $KEY;?>',
                    data : data,
                    dataTYpe : 'multipart/form-data',
                    processData: false,
                    contentType: false, 
                    beforeSend : function(){
                        document.getElementById("divFADE2").style.display = "inline-block";
                        document.getElementById("divFADE2").style.opacity = "0.6";
                    },
                    success : function(response){

                        //response = JSON.parse(response);

                        if(response.substr(0,5) != "ERROR"){
                            closeMSG();
                            //getFILES(document.getElementById("fileName7").value);
                            adID = document.getElementById("fileName7").value;
                            //addNotif(response);
                            var sFN = document.getElementById("fileToUpload7").value.replace(/^.*[\\/]/, '');
                            sFN = adID + "." + sFN.split('.').pop();
                            updAD_IMG(adID.substr(0, adID.lastIndexOf('.')),sFN,'1');
                            document.getElementById("adIMG").src = "/fs/customer/"+USER+"/"+response+"?t="+Math.floor(Math.random()*1000000);
                            //document.getElementById("imgPRD").src = "";
                            document.getElementById("fileToUpload7").value = "";
                            //document.getElementById("divMSG").innerHTML = "Image uploaded! <br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        }else{
                            //addNotif("Erreur avec l'image..");
                            document.getElementById("divMSG").style.display = "inline-block";
                            document.getElementById("divMSG").innerHTML = response + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        }

                    }

                }); 
            }
        });


    /* annonces image 2 */
    $('#frmUPLOAD8').on('submit',function(e){
        var file = $('#fileToUpload8')[0].files[0];
            if (!file){return;}
            if (file.size > 50000){
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = "Veuillez réduire la taille de l'image. Maximum 50Kb par image.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                e.preventDefault();
                return false;
            }
            //var iPRD = document.getElementById("prID").value;
            e.preventDefault(); //prevent default form submition
            data = new FormData();
            data.append('fileToUpload8', file);
            data.append('fileName8', document.getElementById("fileName8").value); //filename without .&extention
            //var output = document.getElementById('imgPRD');
            //output.src = URL.createObjectURL($('#fileToUpload')[0].files[0]);
            if (data){
                $.ajax({
                    type : 'post',
                    url : 'upload2.php?KEY=<?php echo $KEY;?>',
                    data : data,
                    dataTYpe : 'multipart/form-data',
                    processData: false,
                    contentType: false, 
                    beforeSend : function(){
                        document.getElementById("divFADE2").style.display = "inline-block";
                        document.getElementById("divFADE2").style.opacity = "0.6";
                    },
                    success : function(response){

                        //response = JSON.parse(response);

                        if(response.substr(0,5) != "ERROR"){
                            closeMSG();
                            //getFILES(document.getElementById("fileName7").value);
                            adID = document.getElementById("fileName8").value;
                            //addNotif(response);
                            var sFN = document.getElementById("fileToUpload8").value.replace(/^.*[\\/]/, '');
                            sFN = adID + "." + sFN.split('.').pop();
                            updAD_IMG(adID.substr(0, adID.lastIndexOf('.')),sFN,'2');
                            document.getElementById("adIMG2").src = "/fs/customer/"+USER+"/"+response+"?t="+Math.floor(Math.random()*1000000);
                            //document.getElementById("imgPRD").src = "";
                            document.getElementById("fileToUpload8").value = "";
                            //document.getElementById("divMSG").innerHTML = "Image uploaded! <br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        }else{
                            //addNotif("Erreur avec l'image..");
                            document.getElementById("divMSG").style.display = "inline-block";
                            document.getElementById("divMSG").innerHTML = response + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        }

                    }

                }); 
            }
        });

    /* annonces image 3 */
    $('#frmUPLOAD9').on('submit',function(e){
        var file = $('#fileToUpload9')[0].files[0];
            if (!file){return;}
            if (file.size > 50000){
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = "Veuillez réduire la taille de l'image. Maximum 50Kb par image.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                e.preventDefault();
                return false;
            }
            //var iPRD = document.getElementById("prID").value;
            e.preventDefault(); //prevent default form submition
            data = new FormData();
            data.append('fileToUpload9', file);
            data.append('fileName9', document.getElementById("fileName9").value); //filename without .&extention
            //var output = document.getElementById('imgPRD');
            //output.src = URL.createObjectURL($('#fileToUpload')[0].files[0]);
            if (data){
                $.ajax({
                    type : 'post',
                    url : 'upload3.php?KEY=<?php echo $KEY;?>',
                    data : data,
                    dataTYpe : 'multipart/form-data',
                    processData: false,
                    contentType: false, 
                    beforeSend : function(){
                        document.getElementById("divFADE2").style.display = "inline-block";
                        document.getElementById("divFADE2").style.opacity = "0.6";
                    },
                    success : function(response){

                        //response = JSON.parse(response);

                        if(response.substr(0,5) != "ERROR"){
                            closeMSG();
                            //getFILES(document.getElementById("fileName7").value);
                            adID = document.getElementById("fileName9").value;
                            //addNotif(response);
                            var sFN = document.getElementById("fileToUpload9").value.replace(/^.*[\\/]/, '');
                            sFN = adID + "." + sFN.split('.').pop();
                            updAD_IMG(adID.substr(0, adID.lastIndexOf('.')),sFN,'3');
                            document.getElementById("adIMG3").src = "/fs/customer/"+USER+"/"+response+"?t="+Math.floor(Math.random()*1000000);
                            //document.getElementById("imgPRD").src = "";
                            document.getElementById("fileToUpload9").value = "";
                            //document.getElementById("divMSG").innerHTML = "Image uploaded! <br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        }else{
                            //addNotif("Erreur avec l'image..");
                            document.getElementById("divMSG").style.display = "inline-block";
                            document.getElementById("divMSG").innerHTML = response + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        }

                    }

                }); 
            }
        });
    <?php
        if ($USER_TYPE == "RETAILER" && $CIE_DIST_AD == true){
            echo "getADS(0,ADS_LIMIT);";
        }
    ?>

    setInterval(function () {dw3_check_inactivity();}, 5000);
    window.addEventListener("focus", dw3_check_inactivity, false);
    window.addEventListener("blur", dw3_set_activity, false);
    window.addEventListener("click", dw3_set_activity, false);
    window.addEventListener("mousemove", dw3_set_activity, false);
    window.addEventListener("keypress", dw3_set_activity, false);
    window.addEventListener("scroll", dw3_set_activity, false);
    document.addEventListener("touchMove", dw3_set_activity, false);
    document.addEventListener("touchEnd", dw3_set_activity, false);
    document.addEventListener("popstate", dw3_check_inactivity, false);

    function dw3_set_activity() {
        dw3_inactivity_time = new Date().getTime();
    }
    function dw3_check_inactivity() {
        if(new Date().getTime() - dw3_inactivity_time >= 600000) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //
            }
            };
            xmlhttp.open('GET', 'logout.php?KEY='+KEY, true);
            xmlhttp.send();
            history.pushState("", document.title, window.location.pathname);
            setInterval(function () {window.open("/client","_self");}, 1000);
        }
    }
});

window.onhashchange = function() {
    window.scrollTo({top: 0, behavior: 'smooth'});
}


function taxeVERTE_INFO() {
    if (USER_LANG == "FR"){
        addMsg("<h2>Que sont les frais environnementaux?</h2><p style='line-height:1;text-align:justify;'>Les frais environnementaux sont des montants recueillis pour financer l'élimination et le recyclage des produits ménagers faisant partie de la réglementation provinciale visant la gestion des déchets. <br>En payant ces frais, vous contribuez à la collecte d'articles, à leur recyclage, à leur réutilisation ou dans les cas où cela n'est pas possible, leur élimination de la façon qui respecte le plus l'environnement. Au Québec, la loi 60 indique que le prix affiché d'un article doit comprendre les frais environnementaux et les frais de reprise. <br>Sur le site "+window.location.host +", les clients du Québec pourront voir les frais environnementaux et les frais de reprise clairement indiqués dans le prix total d'un article.</p><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
    }else{
        addMsg("<h2>What is an environmental Fee?</h2><p style='line-height:1;text-align:justify;'>Sometimes called an Eco Fee, is a fee collected by manufacturers and retails to help fund recycling programs that divert potentially hazardous items, such as fire exinguishers, household cleaners, and paint, from landfills.</p><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
    }
}

function addMsg(text) { //rename to dw3_alert(text);
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = text ;
}
function copyADR_TO_SH() {
    document.getElementById("clADR1_SH").value =  document.getElementById("clADR1").value ;
    document.getElementById("clADR2_SH").value =  document.getElementById("clADR2").value ;
    document.getElementById("clVILLE_SH").value =  document.getElementById("clVILLE").value ;
    document.getElementById("clPROV_SH").value =  document.getElementById("clPROV").value ;
    document.getElementById("clPAYS_SH").value =  document.getElementById("clPAYS").value ;
    document.getElementById("clCP_SH").value =  document.getElementById("clCP").value ;
}

function closeMSG() { //rename to dw3_alert_close();
	document.getElementById("divFADE2").style.opacity = "0";
	document.getElementById("divFADE2").classList.remove('divFADE_IN');
    setTimeout(function () {
		document.getElementById("divFADE2").style.display = "none";

		}, 500);
	document.getElementById("divMSG").style.display = "none";
}
function closeMSG_STRIPE() { //rename to dw3_alert_close();
	document.getElementById("divFADE2").style.opacity = "0";
	document.getElementById("divFADE2").classList.remove('divFADE_IN');
    setTimeout(function () {
		document.getElementById("divFADE2").style.display = "none";
        window.open('dashboard.php?KEY=' + KEY,'_self');
		}, 500);
	document.getElementById('divMSG').style.display = 'none';
}
function editDOCUMENT(did,rid) {
        window.open('/pub/page/quiz/index.php?KEY=' + KEY + '&ID=' + did + '&RID=' + rid,'_self');
}
function deleteSelectedAd(adID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        if (cookie.substr(0,3) == 'AD_' && name.substr(3,name.length-3) == adID){
            document.cookie = name + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            location.reload();
        }
    }
}
function deleteAllCookies() {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        if (name != 'KEY' && name != 'LANG' && name != 'STORE' && name != 'DEVICE' && name != 'TRANSPORT' && name.substr(0,3)!="AD_" && name.substr(0,5)!="WISH_"){
            document.cookie = name + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
        }
    }
}
function deleteAdCookies() {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        if (name.substr(0,3) == "AD_"){
            document.cookie = name + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
        }
    }
}
/* function deleteOneCookie(prID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(5, (eqPos-5));
        if (cprid==prID && name.substr(0,5) == "CART_"){
            document.cookie = name + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            //browser.cookies.remove({name:name});
            location.reload();
        }
    }
} */
function setTrpCookie(TrpValue) {
    document.cookie = "TRANSPORT" + "=" + TrpValue + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
    document.cookie = "TRANSPORT_CARRIER" + "=" + ship_carrier + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
    document.cookie = "TRANSPORT_SERVICE" + "=" + ship_service + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
}
function plusAdCookie(adID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(3, (eqPos-3));
        const cookieVal = getCookie("AD_"+adID);
        const newVal = Number(cookieVal) + 1;
        if (cprid==adID && name.substr(0,3) == "AD_"){
            document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            //browser.cookies.remove({name:name});
            location.reload();
        }
    }
}
function minusAdCookie(adID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(3, (eqPos-3));
        const cookieVal = getCookie("AD_"+adID);
        const newVal = Number(cookieVal) - 1;
        if (cprid==adID && name.substr(0,3) == "AD_"){
            document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            //browser.cookies.remove({name:name});
            location.reload();
        }
    }
}

function plusCookie(prID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(5, (eqPos-5));
        const cookieVal = getCookie("CART_"+prID);
        const newVal = Number(cookieVal) + 1;
        if (cprid==prID && name.substr(0,5) == "CART_"){
            document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            //browser.cookies.remove({name:name});
            location.reload();
        }
    }
}
function minusCookie(prID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(5, (eqPos-5));
        const cookieVal = getCookie("CART_"+prID);
        const newVal = Number(cookieVal) - 1;
        if (cprid==prID && name.substr(0,5) == "CART_"){
            document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            //browser.cookies.remove({name:name});
            location.reload();
        }
    }
}
function dw3_wish_toogle(id){
    if (document.getElementById("dw3_wish_"+id)){
        if (document.getElementById("dw3_wish_"+id).innerText=="Q"){
            dw3_wish_del(id);
        } else {
            dw3_wish_add(id);
        }
    } else if (document.getElementById("dw3_wish3_"+id)){
        //if (document.getElementById("dw3_wish3_"+id).src=="/pub/img/dw3/fav_full.png"){
        if (document.getElementById("dw3_wish3_"+id).innerText=="Q"){
            dw3_wish_del(id);
        } else {
            dw3_wish_add(id);
        }
    }
}
function dw3_wish_add(id){
    document.cookie = "WISH_" + id + "=1;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    if(USER_LANG == "FR"){
        addNotif("Un item a été ajouté à votre liste de souhaits.");
    } else {
        addNotif("An item has been added to your wishlist.");
    }
    if (document.getElementById("dw3_wish_"+id)){
        document.getElementById("dw3_wish_"+id).innerText="Q";  
    }
    if (document.getElementById("dw3_wish3_"+id)){
        document.getElementById("dw3_wish3_"+id).innerText="Q";  
    }
    //dw3_wish_count();
}
function dw3_wish_del(prID) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        const cprid = cookie.substr(5, (eqPos-5));
        const cookieVal = getCookie("WISH_"+prID);
        const newVal = "0";
        if (cprid==prID){
            document.cookie = name + "=" + newVal + ";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>";
            if (document.getElementById("dw3_wish_"+prID)){
                document.getElementById("dw3_wish_"+prID).innerText="R";
            }
            if (document.getElementById("dw3_wish3_"+prID)){
                document.getElementById("dw3_wish3_"+prID).innerText="R";
            }
            if(USER_LANG == "FR"){
                addNotif("Un item a été retiré à votre liste de souhaits.");
            } else {
                addNotif("An item has been removed from your wishlist.");
            }
        }
    }
    //dw3_wish_count();
}
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

//POSTE CANADA
function getRATE() {
    if (document.getElementById("clNOM").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clNOM');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clADR1").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clVILLE").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clCP").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clPROV").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clADR1_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clVILLE_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clCP_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clPROV_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }

    var selectBox = document.getElementById("trpTYPE");
    var ship_code = selectBox.options[selectBox.selectedIndex].value;
    if(ship_code == "PICKUP"){
        document.getElementById("pickup_adress_zone").innerHTML = "<?php echo $location_adress; ?>";
        document.getElementById("transportRate").innerHTML = "0.00$";
        document.getElementById("btnOPEN_CAL").style.display = "inline-block";
        document.getElementById("delivery_estimated_date").innerHTML = txt_estimated_date;
        ship_price = 0.00;
        ship_carrier = "PICKUP";
        document.getElementById("cartGTOT").innerHTML = "<?php echo $cart_total; ?>$";
        //set total
        return;
    }else{
        document.getElementById("pickup_adress_zone").innerHTML = "";
        if(ship_code =="DOM.RP"||ship_code =="DOM.EP"||ship_code =="DOM.XP")  {
            var ship_type = "POSTE_CANADA";
            var cp_from = "<?php echo $CIE_CP; ?>";
            var cp_to = "<?php echo $USER_CP_SH; ?>";
            var weight = "<?php echo $cart_weight; ?>";
            var dimensions = "<?php echo $cart_dimensions; ?>";
            var service_code = ship_code;
        } 
    }
    if (ship_type == "POSTE_CANADA"){
        document.getElementById("divFADE2").style.opacity = "0.6";
        document.getElementById("divFADE2").style.display = "inline-block";	 
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("transportRate").innerHTML = this.responseText.trim() + "$";
            ship_price = this.responseText.trim();
            document.getElementById("cartGTOT").innerHTML = parseFloat(this.responseText) + parseFloat("<?php echo $cart_total; ?>") + "$";
            document.getElementById('divFADE2').style.display = 'none';
            document.getElementById("divFADE2").style.opacity = "1";
            //dw3_drag_init(document.getElementById('dw3_cart'));
          }
        };
            cp_from = cp_from.toUpperCase().replaceAll(" ","");
            cp_to = cp_to.toUpperCase().replaceAll(" ","");
            xmlhttp.open('GET', '/api/poste_canada/REST/rating/GetRates/GetRates.php?KEY=' + KEY + '&CP1=' + cp_from + '&CP2=' + cp_to + '&D=' + dimensions + '&W=' + weight+ '&S=' + service_code, true);
            xmlhttp.send();
    }
}

//LIVRAISON A RABAIS
var best_price_r = 50000;
var best_carrier_r = "NA";
var best_service_r = "ND";
var best_date_r = "";
var best_price_x = 50000;
var best_carrier_x = "NA";
var best_service_x = "ND";
var best_date_x = "";
function changeRATE2() {
    if (document.getElementById("trpTYPE")){
        var selectBox = document.getElementById("trpTYPE");
        if (selectBox.selectedIndex == -1){
            var ship_code = "PICKUP";
            selectBox.value = "PICKUP";
        } else {
            var ship_code = selectBox.options[selectBox.selectedIndex].value.trim();
            var ship_text = selectBox.options[selectBox.selectedIndex].text;
        }
    } else {
        ship_code = "PICKUP";
        if (USER_LANG == "FR"){
            document.getElementById("pickup_adress_type").innerHTML = "Ramasser à: ";
        } else {
            document.getElementById("pickup_adress_type").innerHTML = "Pickup at: ";
        }
        document.getElementById("pickup_adress_zone").innerHTML = "<?php echo $location_adress; ?>";
    }

    if (ship_code == "REGULAR"){
        if (best_carrier_r == "NA"){
            ship_code = "PICKUP"
            if (USER_LANG == "FR"){
                addMsg('Le transporteur pour la '+ship_text.toLowerCase()+' est indisponible pour le moment.<br><br><button onclick="closeMSG();document.getElementById(\'trpTYPE\').focus();"><span class="material-icons" style="vertical-align:middle;">done</span>Ok</button>');
            }else{
                addMsg('The carrier for the '+ship_text.toLowerCase()+' is not available for now.<br><br><button onclick="closeMSG();document.getElementById(\'trpTYPE\').focus();"><span class="material-icons" style="vertical-align:middle;">done</span>Ok</button>');
            }
        } else {
            ship_price = best_price_r.trim();
            ship_carrier = best_carrier_r;
            ship_service = best_service_r;
            document.getElementById("transportRate").innerHTML = ship_price + "$";
            document.getElementById("btnOPEN_CAL").style.display = "none";
            document.getElementById("delivery_estimated_date").innerHTML = "<span style='font-weight:normal;'>Livraison le:</span> <span class='material-icons' style='font-size:16px;'>calendar_month</span> <span> " + best_date_r.trim()+ "</span>";
            document.getElementById("cartGTOT").innerHTML = (parseFloat(ship_price) + parseFloat("<?php echo $cart_total; ?>")).toFixed(2) + "$";
            document.getElementById("pickup_adress_zone").innerHTML = document.getElementById("clADR1_SH").value + ", " + document.getElementById("clVILLE_SH").value;
            if (USER_LANG == "FR"){
                document.getElementById("pickup_adress_type").innerHTML = "Livraison à: ";
            } else {
                document.getElementById("pickup_adress_type").innerHTML = "Delivery at: ";
            }
        }
    } else if (ship_code == "EXPRESS"){
        if (best_carrier_x == "NA"){
            ship_code = "PICKUP"
            if (USER_LANG == "FR"){
                addMsg('Le transporteur pour la '+ship_text.toLowerCase()+' est indisponible pour le moment.<br><br><button onclick="closeMSG();document.getElementById(\'trpTYPE\').focus();"><span class="material-icons" style="vertical-align:middle;">done</span>Ok</button>');
            }else{
                addMsg('The carrier for the '+ship_text.toLowerCase()+' is not available for now.<br><br><button onclick="closeMSG();document.getElementById(\'trpTYPE\').focus();"><span class="material-icons" style="vertical-align:middle;">done</span>Ok</button>');
            }
        } else {
            ship_price = best_price_x.trim();
            ship_carrier = best_carrier_x;
            ship_service = best_service_x;
            document.getElementById("transportRate").innerHTML = ship_price + "$";
            document.getElementById("btnOPEN_CAL").style.display = "none";
            document.getElementById("delivery_estimated_date").innerHTML = "<span style='font-weight:normal;'>Livraison le:</span> <span class='material-icons' style='font-size:16px;'>calendar_month</span> <span> " + best_date_x.trim()+ "</span>";
            document.getElementById("cartGTOT").innerHTML = (parseFloat(ship_price) + parseFloat("<?php echo $cart_total; ?>")).toFixed(2) + "$";
            document.getElementById("pickup_adress_zone").innerHTML = document.getElementById("clADR1_SH").value + ", " + document.getElementById("clVILLE_SH").value;
            if (USER_LANG == "FR"){
                document.getElementById("pickup_adress_type").innerHTML = "Livraison à: ";
            } else {
                document.getElementById("pickup_adress_type").innerHTML = "Delivery at: ";
            }
        }
    }

    if(ship_code == "PICKUP"){
        document.getElementById("pickup_adress_zone").innerHTML = "<?php echo $location_adress; ?>";
        if (USER_LANG == "FR"){
            document.getElementById("pickup_adress_type").innerHTML = "Ramasser à: ";
        } else {
            document.getElementById("pickup_adress_type").innerHTML = "Pickup at: ";
        }
        document.getElementById("btnOPEN_CAL").style.display = "inline-block";
        document.getElementById("transportRate").innerHTML = "0.00$";
        document.getElementById("delivery_estimated_date").innerHTML = txt_estimated_date;
        ship_price = 0.00;
        ship_carrier = "PICKUP";
        document.getElementById("trpTYPE").value = "PICKUP";
        document.getElementById("cartGTOT").innerHTML = "<?php echo $cart_total; ?>$";
    }
    setTrpCookie(ship_code);
}
//internal
function changeRATE3() {
    var cie_trp_price = '<?php echo number_format($transport_mem,2,"."," "); ?>';
    var cie_trp_delay = '<?php echo $CIE_LV_F1; ?>';
    var cie_trp_delay2 = '<?php echo $CIE_LV_F2; ?>';
    var cie_pickup_delay = '<?php echo $CIE_PK_F1; ?>';
    var cie_pickup_delay2 = '<?php echo $CIE_PK_F2; ?>';

if (USER_LANG == "FR"){
    //delais de transport
    if (cie_trp_delay2 == "day"){
        if (cie_trp_delay == "1") {
            cie_trp_delay2 = " jour ouvrable";
        } else {
            cie_trp_delay2 = " jours ouvrables";
        }
    } else if (cie_trp_delay2 == "week"){
        if (cie_trp_delay == "1") {
            cie_trp_delay2 = " semaine";
        } else {
            cie_trp_delay2 = " semaines";
        }
    } else if (cie_trp_delay2 == "month"){
            cie_trp_delay = " mois";
    }
    //delais de ramassage
    if (cie_pickup_delay2 == "day"){
        if (cie_pickup_delay == "1") {
            cie_pickup_delay2 = " jour ouvrable";
        } else {
            cie_pickup_delay2 = " jours ouvrables";
        }
    } else if (cie_pickup_delay2 == "week"){
        if (cie_pickup_delay == "1") {
            cie_pickup_delay2 = " semaine";
        } else {
            cie_pickup_delay2 = " semaines";
        }
    } else if (cie_pickup_delay2 == "month"){
            cie_pickup_delay2 = " mois";
    }
} else {
    //delais de transport
    if (cie_trp_delay2 == "day"){
        if (cie_trp_delay == "1") {
            cie_trp_delay2 = " opening day";
        } else {
            cie_trp_delay2 = " opening days";
        }
    } else if (cie_trp_delay2 == "week"){
        if (cie_trp_delay == "1") {
            cie_trp_delay2 = " week";
        } else {
            cie_trp_delay2 = " weeks";
        }
    } else if (cie_trp_delay2 == "month"){
        if (cie_trp_delay == "1") {
            cie_trp_delay2 = " month";
        } else {
            cie_trp_delay2 = " months";
        }
    }
    //delais de ramassage
    if (cie_pickup_delay2 == "day"){
        if (cie_pickup_delay == "1") {
            cie_pickup_delay2 = " opening day";
        } else {
            cie_pickup_delay2 = " opening days";
        }
    } else if (cie_pickup_delay2 == "week"){
        if (cie_pickup_delay == "1") {
            cie_pickup_delay2 = " week";
        } else {
            cie_pickup_delay2 = " weeks";
        }
    } else if (cie_pickup_delay2 == "month"){
        if (cie_pickup_delay == "1") {
            cie_pickup_delay2 = " month";
        } else {
            cie_pickup_delay2 = " months";
        }
    }
}

    if (document.getElementById("clNOM").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clNOM');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clADR1").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clVILLE").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clCP").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clPROV").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clADR1_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clVILLE_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clCP_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clPROV_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("trpTYPE")){
        var selectBox = document.getElementById("trpTYPE");
        if (selectBox.selectedIndex == -1){
            var ship_code = "PICKUP";
            selectBox.value = "PICKUP";
        } else {
            var ship_code = selectBox.options[selectBox.selectedIndex].value.trim();
        }
    } else {
        var ship_code = "PICKUP";
    }
    var ship_text = selectBox.options[selectBox.selectedIndex].text;
    if(ship_code == "PICKUP"){
        document.getElementById("pickup_adress_zone").innerHTML = "<?php echo $location_adress; ?>";
        if (USER_LANG == "FR"){
            document.getElementById("pickup_adress_type").innerHTML = "Ramasser à: ";
        } else {
            document.getElementById("pickup_adress_type").innerHTML = "Pickup at: ";
        }
        document.getElementById("transportRate").innerHTML = "0.00$";
        document.getElementById("delivery_estimated_date").innerHTML = txt_estimated_date;
        document.getElementById("btnOPEN_CAL").style.display = "inline-block";
        ship_price = 0.00;
        ship_carrier = "PICKUP";
        document.getElementById("cartGTOT").innerHTML = "<?php echo number_format($cart_total,2,"."," "); ?>$";
    }else{
        document.getElementById("pickup_adress_zone").innerHTML = document.getElementById("clADR1_SH").value + ", " + document.getElementById("clVILLE_SH").value;
        if (USER_LANG == "FR"){
            document.getElementById("pickup_adress_type").innerHTML = "Livraison à: ";
        } else {
            document.getElementById("pickup_adress_type").innerHTML = "Delivery at: ";
        }
        document.getElementById("transportRate").innerHTML = cie_trp_price + "$";
        document.getElementById("btnOPEN_CAL").style.display = "none";
        document.getElementById("delivery_estimated_date").innerHTML = "<span style='font-weight:normal;'>Livraison le:</span> <span class='material-icons' style='font-size:16px;'>calendar_month</span> <span> " + cie_trp_delay + " " + cie_trp_delay2 + "</span>";
        document.getElementById("cartGTOT").innerHTML = (parseFloat(cie_trp_price) + parseFloat("<?php echo $cart_total; ?>")).toFixed(2) + "$";
    }
    setTrpCookie(ship_code);
}
function getRATE2() {
    if (document.getElementById("clNOM").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clNOM');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clADR1").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clVILLE").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clCP").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clPROV").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clADR1_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clVILLE_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clCP_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("clPROV_SH").value == ""){
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    if (document.getElementById("trpTYPE")){
        var selectBox = document.getElementById("trpTYPE");
        if (selectBox.selectedIndex == -1){
            var ship_code = "PICKUP";
            selectBox.value = "PICKUP";
        } else {
            var ship_code = selectBox.options[selectBox.selectedIndex].value.trim();
        }
    } else {
        var ship_code = "PICKUP";
    }
    var ship_text = selectBox.options[selectBox.selectedIndex].text;
    if(ship_code == "PICKUP"){
        document.getElementById("pickup_adress_zone").innerHTML = "<?php echo $location_adress; ?>";
        if (USER_LANG == "FR"){
            document.getElementById("pickup_adress_type").innerHTML = "Ramasser à: ";
        } else {
            document.getElementById("pickup_adress_type").innerHTML = "Pickup at: ";
        }
        document.getElementById("transportRate").innerHTML = "0.00$";
        document.getElementById("btnOPEN_CAL").style.display = "inline-block";
        document.getElementById("delivery_estimated_date").innerHTML = txt_estimated_date;
        ship_price = 0.00;
        ship_carrier = "PICKUP";
        document.getElementById("cartGTOT").innerHTML = "<?php echo $cart_total; ?>$";
        //setTrpCookie(ship_code);
        //return;
    }else{
        document.getElementById("pickup_adress_zone").innerHTML = document.getElementById("clADR1_SH").value + ", " + document.getElementById("clVILLE_SH").value;
        if (USER_LANG == "FR"){
            document.getElementById("pickup_adress_type").innerHTML = "Livraison à: ";
        } else {
            document.getElementById("pickup_adress_type").innerHTML = "Delivery at: ";
        }
    }
        var cp_from = "<?php echo $CIE_CP; ?>";
        var cp_to = "<?php echo $USER_CP_SH; ?>";
        var weight = "<?php echo $cart_weight; ?>";
        var dimensions = "<?php echo $cart_dimensions; ?>";
        var cart_height = "<?php echo $cart_height; ?>";
        var cart_width = "<?php echo $cart_width; ?>";
        var cart_depth = "<?php echo $cart_depth; ?>";
        //document.getElementById("divFADE2").style.opacity = "0.6";
        //document.getElementById("divFADE2").style.display = "inline-block";
        //document.getElementById("divMSG").style.display = "inline-block";
        //if (USER_LANG == "FR"){
           // document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
        //}else{
           // document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
        //}
        document.getElementById("transportRate").innerHTML = "<img style='width:20px;height:20px;border-radius:3px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
        if (document.getElementById("btnCartToCheckout")){
            document.getElementById("btnCartToCheckout").disabled = true;
            document.getElementById("btnCartToCheckout").classList.toggle("green");
        }else if (document.getElementById("btnCartToOrder")){
            document.getElementById("btnCartToOrder").disabled = true;
            document.getElementById("btnCartToOrder").classList.toggle("green");
        }else if (document.getElementById("btnCartToInvoice")){
            document.getElementById("btnCartToInvoice").disabled = true;
            document.getElementById("btnCartToInvoice").classList.toggle("green");
        }
        document.getElementById("trpTYPE").disabled = true;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            best_price_r   = response.price_r;
            best_carrier_r = response.carrier_r;
            best_service_r = response.service_r;
            best_date_r    = response.date_r;
            best_price_x   = response.price_x;
            best_carrier_x = response.carrier_x;
            best_service_x = response.service_x;
            best_date_x    = response.date_x;

            if (ship_code == "REGULAR" && response.carrier_r == "NA" || ship_code == "EXPRESS" && response.carrier_x == "NA"){
                if (USER_LANG == "FR"){
                    addMsg('Le transporteur pour la '+ship_text.toLowerCase()+' est indisponible pour le moment.<br><br><button onclick="closeMSG();document.getElementById(\'trpTYPE\').focus();"><span class="material-icons" style="vertical-align:middle;">done</span>Ok</button>');
                }else{
                    addMsg('The carrier for the '+ship_text.toLowerCase()+' is not available for now.<br><br><button onclick="closeMSG();document.getElementById(\'trpTYPE\').focus();"><span class="material-icons" style="vertical-align:middle;">done</span>Ok</button>');
                }
                ship_code == "PICKUP";
            } else {
                if (ship_code == "REGULAR"){
                    ship_price = response.price_r.trim();
                    ship_carrier = response.carrier_r;
                    ship_service = response.service_r;
                    document.getElementById("transportRate").innerHTML = ship_price + "$";
                    document.getElementById("btnOPEN_CAL").style.display = "none";
                    document.getElementById("delivery_estimated_date").innerHTML = "<span style='font-weight:normal;'>Livraison le:</span>  <span class='material-icons' style='font-size:16px;'>calendar_month</span> <span> " + response.date_r.trim()+ "</span>";
                    document.getElementById("cartGTOT").innerHTML = (parseFloat(ship_price) + parseFloat("<?php echo $cart_total; ?>")).toFixed(2) + "$";
                } else if(ship_code == "EXPRESS"){
                    ship_price = response.price_x.trim();
                    ship_carrier = response_x.carrier;
                    ship_service = response_x.service;
                    document.getElementById("transportRate").innerHTML = ship_price + "$";
                    document.getElementById("btnOPEN_CAL").style.display = "none";
                    document.getElementById("delivery_estimated_date").innerHTML = "<span style='font-weight:normal;'>Livraison le:</span>  <span class='material-icons' style='font-size:16px;'>calendar_month</span> <span> " + response.date_x.trim()+ "</span>";
                    document.getElementById("cartGTOT").innerHTML = (parseFloat(ship_price) + parseFloat("<?php echo $cart_total; ?>")).toFixed(2) + "$";
                }
                //document.getElementById('divFADE2').style.display = 'none';
                //document.getElementById("divFADE2").style.opacity = "1";
                //dw3_drag_init(document.getElementById('dw3_cart'));
                //document.getElementById("divMSG").style.display = "none";
            }
            if (ship_code == "PICKUP"){
                document.getElementById("transportRate").innerHTML = "0.00$";
                document.getElementById("btnOPEN_CAL").style.display = "inline-block";
                document.getElementById("delivery_estimated_date").innerHTML = txt_estimated_date;
                document.getElementById("pickup_adress_zone").innerHTML = "<?php echo $location_adress; ?>";
                document.getElementById("pickup_adress_type").innerHTML = "Ramasser à: ";
                ship_price = "0.00";
                ship_carrier = "PICKUP";
                document.getElementById("cartGTOT").innerHTML = (parseFloat("<?php echo $cart_total; ?>")).toFixed(2) + "$";
                document.getElementById("trpTYPE").value = "PICKUP";
            }
            if (document.getElementById("btnCartToCheckout")){
                document.getElementById("btnCartToCheckout").disabled = false;
                document.getElementById("btnCartToCheckout").classList.toggle("green");
            }else if (document.getElementById("btnCartToOrder")){
                document.getElementById("btnCartToOrder").disabled = false;
                document.getElementById("btnCartToOrder").classList.toggle("green");
            }else if (document.getElementById("btnCartToInvoice")){
                document.getElementById("btnCartToInvoice").disabled = false;
                document.getElementById("btnCartToInvoice").classList.toggle("green");
            }
            document.getElementById("trpTYPE").disabled = false;
            document.getElementById("trpTYPE").focus();
          }
        };
            cp_from = cp_from.toUpperCase().replaceAll(" ","");
            cp_to = cp_to.toUpperCase().replaceAll(" ","");
            xmlhttp.open('GET', '/api/livar/quote.php?KEY=' + KEY + '&CP1=' + cp_from + '&CP2=' + cp_to + '&H=' + cart_height + '&W=' + cart_width + '&L=' + cart_depth + '&LB=' + weight+ '&S=' + ship_code, true);
            xmlhttp.send();
            setTrpCookie(ship_code);
    //}
}

function stripe_cancel_subscription(invoiceId) {
    if (USER_LANG == "FR"){
        addMsg("<br>Voulez-vous vraiment annuler votre abonnement?<br><span style='font-size:0.7em;'><i>Si oui veuillez en indiquer la raison.</i></span><br>"
        +"<select id='cancelReason' size='8' style='width:auto;background:#EEE;overflow: hidden;'>"
        +"<option style='padding:3px 0px;' value='customer_service'>Le service client était moins que prévu</option>"
        +"<option style='padding:3px 0px;' value='low_quality'>La qualité était inférieure à mes attentes</option>"
        +"<option style='padding:3px 0px;' value='missing_features'>Certaines fonctionnalités manquent</option>"
        +"<option selected style='padding:3px 0px;' value='other'>Autre raison</option>"
        +"<option style='padding:3px 0px;' value='switched_service'>Je change de service</option>"
        +"<option style='padding:3px 0px;' value='too_complex'>La facilité d'utilisation était inférieure à mes attentes</option>"
        +"<option style='padding:3px 0px;' value='too_expensive'>C'est trop cher</option>"
        +"<option style='padding:3px 0px;' value='unused'>Je n'utilise pas assez le service</option>"
        +"</select><br><textarea id='cancelComment' placeholder='Commentaires supplémentaires (facultatif)' style='width:90%;height:80px;margin-top:10px;'></textarea><br>"
        +"<button onclick=\"closeMSG();\" class='grey'><span class='material-icons' style='vertical-align:middle;'>done</span> Garder l’abonnement</button>"
        +"<button onclick=\"stripe_cancel_subscription2('" + invoiceId + "');closeMSG();\" class='red'><span class='material-icons' style='vertical-align:middle;'>block</span> Se désabonner</button>"
        +"<br><span style='font-size:0.7em;'><i>Le service sera annulé à la fin de la période de facturation en cours.</i></span><br><br>");
    }else{
        addMsg("<br>Are you sure you want to cancel your subscription?<br><span style='font-size:0.7em;'><i>If so, please indicate the reason.</i></span><br>"
        +"<select id='cancelReason' size='8' style='width:auto;background:#EEE;overflow: hidden;'>"
        +"<option style='padding:3px 0px;' value='customer_service'>Customer service was less than expected</option>"
        +"<option style='padding:3px 0px;' value='low_quality'>Quality was less than expected</option>"
        +"<option style='padding:3px 0px;' value='missing_features'>Some features are missing</option>"
        +"<option selected style='padding:3px 0px;' value='other'>Other reason</option>"
        +"<option style='padding:3px 0px;' value='switched_service'>I’m switching to a different service</option>"
        +"<option style='padding:3px 0px;' value='too_complex'>Ease of use was less than expected</option>"
        +"<option style='padding:3px 0px;' value='too_expensive'>It’s too expensive</option>"
        +"<option style='padding:3px 0px;' value='unused'>I don’t use the service enough</option>"
        +"</select><br><textarea id='cancelComment' placeholder='Additional comments (optional)' style='width:90%;height:80px;margin-top:10px;'></textarea><br>"
        +"<button onclick=\"closeMSG();\" class='grey'><span class='material-icons' style='vertical-align:middle;'>done</span> Keep subscription</button>"
        +"<button onclick=\"stripe_cancel_subscription2('" + invoiceId + "');closeMSG();\" class='red'><span class='material-icons' style='vertical-align:middle;'>block</span> Unsubscribe</button>"
        +"<br><span style='font-size:0.7em;'><i>The service will be canceled at the end of the billing period.</i></span><br><br>");    
    }
}
function stripe_cancel_subscription2(invoiceId) {
    var GRPBOX    = document.getElementById("cancelReason");
	var sREASON      = GRPBOX.options[GRPBOX.selectedIndex].value;
    var sCOMMENT    = document.getElementById("cancelComment").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()!= ""){
            addMsg(this.responseText + "<br><br><button onclick='closeMSG();location.reload();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            //addNotif("");
            location.reload();
        }
      }
    };
    xmlhttp.open('GET', 'stripe_cancel_subscription.php?KEY='+KEY+'&INVOICE_ID='+invoiceId+'&REASON='+sREASON+'&COMMENT='+encodeURIComponent(sCOMMENT), true);
    xmlhttp.send();
}
function getUSER_DOCS() {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("dw3_user_docs").innerHTML = this.responseText;
	    }
	};
    xmlhttp.open('GET', 'getUSER_DOCS.php?KEY='+KEY, true);
    xmlhttp.send();
}
function confirmMeeting() {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.trim()== ""){
                if (USER_LANG == "FR"){
                addMsg("Votre rendez-vous a été confirmé! Veuillez vérifier si vos informations sont exactes pour completer l'inscription.<br><br><button onclick=\"toggleSub('divSub1','up1');closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
            }else{
                addMsg("Your meeting has been confirmed! Please verify if your information are exact to complete the registration.<br><br><button onclick=\"toggleSub('divSub1','up1');closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
            }
        }
	  }
	};
    xmlhttp.open('GET', 'confirmMeeting.php?KEY='+KEY + '&MID=' + meetingID, true);
    xmlhttp.send();
}
//lorsque la commande ou la facture est créée
function sendEmailShipping(action,ID) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()!= ""){
            //addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            //addNotif("");
            //location.reload();
        }
	  }
	};
    xmlhttp.open('GET', 'sendEmailShipping.php?KEY='+KEY + '&ACT=' + action+ '&ID=' + ID, true);
    xmlhttp.send();
}
//lorsque la facture est payée
function sendEmailFinance(ID) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()!= ""){
            //addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            //addNotif("");
            //location.reload();
        }
	  }
	};
    xmlhttp.open('GET', 'sendEmailFinance.php?KEY='+KEY + '&ID=' + ID, true);
    xmlhttp.send();
}
function sendEmailRetailer(ID) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()!= ""){
            //addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            //addNotif("");
            //location.reload();
        }
	  }
	};
    xmlhttp.open('GET', 'sendEmailRetailer.php?KEY='+KEY + '&ID=' + ID, true);
    xmlhttp.send();
}
function writeGLS(ID) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (STRIPE_FROM=="subscription"){
            if (USER_LANG == "FR"){
                addMsg("<h2>Paiement accepté</h2><p> Votre abonnement est activé.<br>Si vous avez des questions n'hésitez pas à communiquer avec nous.<br><a style='color:#aaa;' href='mailto:<?php echo($CIE_EML1); ?>'><?php echo($CIE_EML1); ?></a><br><a style='color:#aaa;' href='tel:<?php echo($CIE_TEL1); ?>'><?php echo($CIE_TEL1); ?></a></p><br><br><button onclick='closeMSG_STRIPE();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
            }else{
                addMsg("<h2>Payment accepted</h2><p> Your subscription is now activated.<br>If you have any questions do not hesitate to contact us.<br><a style='color:#aaa;' href='mailto:<?php echo($CIE_EML1); ?>'><?php echo($CIE_EML1); ?></a><br><a style='color:#aaa;' href='tel:<?php echo($CIE_TEL1); ?>'><?php echo($CIE_TEL1); ?></a></p><br><br><button onclick='closeMSG_STRIPE();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
            }
        } else {
            if (USER_LANG == "FR"){
                addMsg("<h2>Paiement accepté</h2><p> Votre commande sera traitée dans les plus brefs délais.<br>Si vous avez des questions n'hésitez pas à communiquer avec nous.<br><a style='color:#aaa;' href='mailto:<?php echo($CIE_EML1); ?>'><?php echo($CIE_EML1); ?></a><br><a style='color:#aaa;' href='tel:<?php echo($CIE_TEL1); ?>'><?php echo($CIE_TEL1); ?></a></p><br><br><button onclick='closeMSG_STRIPE();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
            }else{
                addMsg("<h2>Payment accepted</h2><p> Your order will be processed as soon as possible.<br>If you have any questions do not hesitate to contact us.<br><a style='color:#aaa;' href='mailto:<?php echo($CIE_EML1); ?>'><?php echo($CIE_EML1); ?></a><br><a style='color:#aaa;' href='tel:<?php echo($CIE_TEL1); ?>'><?php echo($CIE_TEL1); ?></a></p><br><br><button onclick='closeMSG_STRIPE();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
            }
        }
	  }
	};
    xmlhttp.open('GET', 'writeGLS.php?KEY='+KEY + '&ID=' + ID, true);
    xmlhttp.send();
}

function sendEmailOrder(ID) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()!= ""){
            addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            addMsg("Votre commande a bien été reçu et sera traité dans les plus brefs délais! <br><br><button onclick='closeMSG();location.reload();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        }
	  }
	};
    xmlhttp.open('GET', 'sendOrderEmail.php?KEY='+KEY + '&ID=' + ID, true);
    xmlhttp.send();
}

function sendEmailInvoice(ID) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()!= ""){
            addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            addMsg("Votre facture a été envoyé par courriel et votre commande sera traité dans les plus brefs délais! <br><br><button onclick='closeMSG();location.reload();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");

        }
	  }
	};
    xmlhttp.open('GET', 'sendInvoiceEmail.php?KEY='+KEY + '&ID=' + ID, true);
    xmlhttp.send();
}

function sendEmailInvoice2(ID) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()!= ""){
            addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            //addNotif("");
            //location.reload();
        }
	  }
	};
    xmlhttp.open('GET', 'sendInvoiceEmail.php?KEY='+KEY + '&ID=' + ID, true);
    xmlhttp.send();
}
function dw3_page_open(url,target){
  window.open(url,target);
}
//my purchase ad
function getAD(ID) {
    //document.getElementById("divFADE").style.opacity = "0.6";
    //document.getElementById("divFADE").style.display = "inline-block";	 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("dw3_editor").innerHTML = this.responseText;
        document.getElementById("dw3_editor").style.display = "inline-block";
        document.getElementById("dw3_editor").style.opacity = "1";
        dw3_drag_init(document.getElementById('dw3_editor'));
	  }
	};
    xmlhttp.open('GET', '/pub/section/classifieds/getAD.php?KEY=' + KEY + '&A=' + ID + '&M=DISPLAY', true);
    xmlhttp.send();
}

//my ads
function addAD() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        openAD(this.responseText);
        getADS(0,ADS_LIMIT);
	  }
	};
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
    xmlhttp.open('GET', 'newAD.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function openAD(adID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("fileName7").value = adID+".1";
		 document.getElementById("fileName8").value = adID+".2";
		 document.getElementById("fileName9").value = adID+".3";
		 document.getElementById("divEDIT_AD").innerHTML = this.responseText;
		 document.getElementById("divEDIT_AD").style.display = "inline-block";
         dragElement(document.getElementById('divEDIT_AD'));
	  }
	};
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
    xmlhttp.open('GET', 'getAD.php?KEY=' + KEY + '&ID=' + adID, true);
    xmlhttp.send();
}
function minusAdDispo(adID) {
    newQty = document.getElementById("AdDispo_"+adID).value;
    if (newQty=="0"){return false;}else{newQty=Number(newQty)-1;}
    document.getElementById("AdDispo_"+adID).value = newQty;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("La quantité a été mise à jour.")
	  }
	};
    xmlhttp.open('GET', 'setAdDispo.php?KEY=' + KEY + '&ID='+adID+ '&Q='+newQty, true);
    xmlhttp.send();
}
function plusAdDispo(adID) {
    newQty = document.getElementById("AdDispo_"+adID).value;
    if (newQty=="0"){return false;}else{newQty=Number(newQty)+1;}
    document.getElementById("AdDispo_"+adID).value = newQty;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("La quantité a été mise à jour.")
	  }
	};
    xmlhttp.open('GET', 'setAdDispo.php?KEY=' + KEY + '&ID='+adID+ '&Q='+newQty, true);
    xmlhttp.send();
}
function setAdDispo(adID) {
    newQty = document.getElementById("AdDispo_"+adID).value;
    if (Number(newQty)=="NaN"){return false;}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("La quantité a été mise à jour.")
	  }
	};
    xmlhttp.open('GET', 'setAdDispo.php?KEY=' + KEY + '&ID='+adID+ '&Q='+newQty, true);
    xmlhttp.send();
}
function getADS(sOFFSET,sLIMIT) {
    ssF = document.getElementById("rechAD").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divCLASSIFIEDS").innerHTML = this.responseText;
/*          document.getElementById("divFADE").style.opacity = "0";
         setTimeout(function () {
            document.getElementById("divFADE").style.display = "none";
        }, 500); */
	  }
	};
	//document.getElementById("divFADE").style.display = "inline-block";
	//document.getElementById("divFADE").style.opacity = "0.6";
    xmlhttp.open('GET', 'getADS.php?KEY=' + KEY 
    + '&SS='+encodeURIComponent(ssF)												
    + '&OFFSET=' + sOFFSET 
    + '&LIMIT=' + sLIMIT, true);
    xmlhttp.send();
    is_ADS_LOADED = true;
}
function delAD(adID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim() == ""){
			  	closeEDITOR();
			  	closeMSG();
                getADS(0,ADS_LIMIT) 
                addNotif("L'annonce #" + adID + " a été supprimé.");
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  }
	};
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
    xmlhttp.open('GET', 'delAD.php?KEY=' + KEY + '&ID=' + adID, true);
    xmlhttp.send();
}
function deleteAD(adID) {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.6";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button class='red' onclick='delADD(" + adID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}
function closeACCOUNTconfirmed() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim() == ""){
            document.getElementById("divFADE2").style.display = "inline-block";
            document.getElementById("divFADE2").style.opacity = "1";
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = "<?php if ($USER_LANG == "FR"){echo "Le compte a été fermé.";}else{echo "The account is now closed.";}?><br><br><button onclick='logOUT_CTS();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } else {
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  }
	};
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
    xmlhttp.open('GET', 'closeACCOUNT.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function closeACCOUNT() {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.6";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php if ($USER_LANG == "FR"){echo "Êtes-vous sûr de fermer le compte? Vous ne pourrez pas vous connecter ou créer un autre compte avec ce courriel. Pour réactiver votre compte, vous devrez nous contacter.";}else{echo "Are you sure to close the account? You will not be able to login or create another account with this email. To reactivate your account you will need to contact us.";} ?><br><br><button class='red' onclick='closeACCOUNTconfirmed();'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php if ($USER_LANG == "FR"){echo "Fermer le compte";}else{echo "Close the account";} ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}

function updAD_IMG(adID,sFN,imgSEQ){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('GET', 'updAD_IMG.php?KEY=' + KEY + '&ID=' + adID + '&SEQ=' + imgSEQ + '&FN=' + encodeURIComponent(sFN),true);
	xmlhttp.send();
    getADS(0,ADS_LIMIT);
}

function saveNOTIF(){

}
function updAD(sID){
    var sACTIVE	  = document.getElementById("adACTIVE").checked;
    var sDROP	  = document.getElementById("adDROP").checked;
	var GRPBOX    = document.getElementById("adCAT");
	var sCAT      = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX    = document.getElementById("adETAT");
	var sETAT      = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX    = document.getElementById("adSHIP");
	var sSHIP    = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sNAME_FR  = document.getElementById("adNAME_FR").value;
	var sNAME_EN  = document.getElementById("adNAME_EN").value;
	var sDESC_FR  = document.getElementById("adDESC_FR").value;
	var sDESC_EN  = document.getElementById("adDESC_EN").value;
	var sQTY      = document.getElementById("adQTY").value;
	var sKG      = document.getElementById("adKG").value;
	var sHEIGHT      = document.getElementById("adHEIGHT").value;
	var sWIDTH      = document.getElementById("adWIDTH").value;
	var sDEPTH      = document.getElementById("adDEPTH").value;
	var sPRICE    = document.getElementById("adPRICE").value;
    var sTAX_FED      = document.getElementById("adTX_FED").checked;
    var sTAX_PROV      = document.getElementById("adTX_PROV").checked;
	var sMODEL    = document.getElementById("adMODEL").value;
	var sBRAND    = document.getElementById("adBRAND").value;
	var sYEAR     = document.getElementById("adYEAR").value;
	var sRECOMMENDED  = document.getElementById("adRECOMMENDED").value;

	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.4";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				closeMSG();
                closeEDITOR();
                getADS(0,ADS_LIMIT);
                addNotif("L'annonce de " + sNAME_FR + " a été mise &#224; jour.");
		  } else {
                document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updAD.php?KEY=' + KEY 
										+ '&ID='     + encodeURIComponent(sID)  
										+ '&ETAT=' + encodeURIComponent(sETAT)     
										+ '&SHIP=' + encodeURIComponent(sSHIP)     
										+ '&ACTIVE=' + encodeURIComponent(sACTIVE)     
										+ '&DROP=' + encodeURIComponent(sDROP)     
										+ '&CAT='    + encodeURIComponent(sCAT)     
										+ '&NAME_FR=' + encodeURIComponent(sNAME_FR)
										+ '&NAME_EN=' + encodeURIComponent(sNAME_EN)
										+ '&DESC_FR=' + encodeURIComponent(sDESC_FR)
										+ '&DESC_EN=' + encodeURIComponent(sDESC_EN)
										+ '&QTY='   + encodeURIComponent(sQTY)
										+ '&KG='   + encodeURIComponent(sKG)
										+ '&H='   + encodeURIComponent(sHEIGHT)
										+ '&W='   + encodeURIComponent(sWIDTH)
										+ '&D='   + encodeURIComponent(sDEPTH)
										+ '&PRICE=' + encodeURIComponent(sPRICE)
										+ '&TAX_FED='   + encodeURIComponent(sTAX_FED)
										+ '&TAX_PROV='   + encodeURIComponent(sTAX_PROV)
										+ '&MODEL=' + encodeURIComponent(sMODEL)
										+ '&BRAND=' + encodeURIComponent(sBRAND)
										+ '&YEAR='  + encodeURIComponent(sYEAR)
										+ '&RECOMMENDED=' + encodeURIComponent(sRECOMMENDED),                 
										true);
		xmlhttp.send();
}
// Function to make an element/element_HEADER draggable
function dragElement(elmnt) { //rename to dw3_drag_set(elmnt);
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    if (document.getElementById(elmnt.id + "_HEADER")) {
        // if present, the header is where you move the DIV from:
        document.getElementById(elmnt.id + "_HEADER").onmousedown = dragMouseDown;
    } else {
        // otherwise, move the DIV from anywhere inside the DIV:
        elmnt.onmousedown = dragMouseDown;
    }
    function dragMouseDown(e) { //rename to dw3_drag_start(e);
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
    }
    function elementDrag(e) { //rename to dw3_drag_move(e);
        e = e || window.event;
        e.preventDefault();
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }
    function closeDragElement() { //rename to dw3_drag_end();
        document.onmouseup = null;
        document.onmousemove = null;
    }
}
function closeEDITOR() { //rename to dw3_editor_close();
	document.getElementById("divFADE").style.opacity = "0";
	setTimeout(function () {
		document.getElementById("divFADE").style.display = "none";
	}, 500);
	if ($('#divEDIT_AD').length > 0) {
		document.getElementById("divEDIT_AD").style.display = 'none';
	}
	if ($('#divNEW_AD').length > 0) {
		document.getElementById('divNEW_AD').style.display = 'none';
	}
}


function verify_code_coupon() {
    document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";
    sCODE = document.getElementById("dw3_input_coupon").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        location.reload();
	  }
	};
		xmlhttp.open('GET', '/pub/section/products/validateCOUPON.php?KEY=' + KEY + '&C=' + sCODE , true);
		xmlhttp.send();
}

function marketTOcheckout() {
	var sNOM     = document.getElementById("clNOM").value.trim();
	var sTEL1     = document.getElementById("clTEL1").value.trim();
	var sADR1    = document.getElementById("clADR1").value.trim();
	var sVILLE   = document.getElementById("clVILLE").value.trim();
	var sPROV    = document.getElementById("clPROV").value.trim();
    var sCP      = document.getElementById("clCP").value.trim();
	var sADR1s    = document.getElementById("clADR1_SH").value.trim();
	var sADR2s    = document.getElementById("clADR2_SH").value.trim();
	var sVILLEs   = document.getElementById("clVILLE_SH").value.trim();
	var sPROVs    = document.getElementById("clPROV_SH").value.trim();
	var sCPs      = document.getElementById("clCP_SH").value.trim();

	if (sNOM == ""){
        document.getElementById("clNOM").focus();
        document.getElementById("clNOM").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clNOM');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clNOM").style.boxShadow = "initial";
    }
    if (sTEL1 == ""){
        document.getElementById("clTEL1").focus();
        document.getElementById("clTEL1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clTEL1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clTEL1").style.boxShadow = "initial";
    }
	if (sADR1 == ""){
        document.getElementById("clADR1").focus();
        document.getElementById("clADR1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1").style.boxShadow = "initial";
    }
	if (sVILLE == ""){
        document.getElementById("clVILLE").focus();
        document.getElementById("clVILLE").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE").style.boxShadow = "initial";
    }
	if (sPROV == ""){
        document.getElementById("clPROV").focus();
        document.getElementById("clPROV").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV").style.boxShadow = "initial";
    }
	if (sCP == ""){
        document.getElementById("clCP").focus();
        document.getElementById("clCP").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP").style.boxShadow = "initial";
    }
	if (sADR1s == ""){
        document.getElementById("clADR1_SH").focus();
        document.getElementById("clADR1_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1_SH").style.boxShadow = "initial";
    }
	if (sVILLEs == ""){
        document.getElementById("clVILLE_SH").focus();
        document.getElementById("clVILLE_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE_SH").style.boxShadow = "initial";
    }
	if (sPROVs == ""){
        document.getElementById("clPROV_SH").focus();
        document.getElementById("clPROV_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV_SH").style.boxShadow = "initial";
    }
	if (sCPs == ""){
        document.getElementById("clCP_SH").focus();
        document.getElementById("clCP_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP_SH").style.boxShadow = "initial";
    }
    if (document.getElementById("trpTYPE2")){
        var selectBox = document.getElementById("trpTYPE2");
        var ship_code = selectBox.options[selectBox.selectedIndex].value;
    } else{
        var ship_code = "";
    }
    window.open('/client/marketTOcheckout.php?KEY=' + KEY + '&SS=' + ship_code + '&P=' + ship_price + '&C=' + ship_carrier+ '&S=' + ship_service,'_self');
    //setTimeout(function () {deleteAdCookies();location.reload();}, 2000);
}

function cartTOorder() {
    if (document.getElementById("trpTYPE")){
        var selectBox = document.getElementById("trpTYPE");
        var ship_code = selectBox.options[selectBox.selectedIndex].value;
    } else{
        var ship_code = "";
    }
	var sNOM     = document.getElementById("clNOM").value.trim();
	var sTEL1     = document.getElementById("clTEL1").value.trim();
	var sADR1    = document.getElementById("clADR1").value.trim();
	var sVILLE   = document.getElementById("clVILLE").value.trim();
	var sPROV    = document.getElementById("clPROV").value.trim();
    var sCP      = document.getElementById("clCP").value.trim();
	var sADR1s    = document.getElementById("clADR1_SH").value.trim();
	var sADR2s    = document.getElementById("clADR2_SH").value.trim();
	var sVILLEs   = document.getElementById("clVILLE_SH").value.trim();
	var sPROVs    = document.getElementById("clPROV_SH").value.trim();
	var sCPs      = document.getElementById("clCP_SH").value.trim();

    if (ship_code == "PICKUP" && CIE_PICK_CAL == "PICK_DATE" && TRP_REQ == "1" && pickup_date == ""){
        addMsg("Veuillez choisir une date et heure de ramassage, avant de continuer.<br><br><button onclick=\"closeMSG();openCALENDAR();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }

	if (sNOM == ""){
        document.getElementById("clNOM").focus();
        document.getElementById("clNOM").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clNOM');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clNOM").style.boxShadow = "initial";
    }
    if (sTEL1 == ""){
        document.getElementById("clTEL1").focus();
        document.getElementById("clTEL1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clTEL1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clTEL1").style.boxShadow = "initial";
    }
	if (sADR1 == ""){
        document.getElementById("clADR1").focus();
        document.getElementById("clADR1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1").style.boxShadow = "initial";
    }
	if (sVILLE == ""){
        document.getElementById("clVILLE").focus();
        document.getElementById("clVILLE").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE").style.boxShadow = "initial";
    }
	if (sPROV == ""){
        document.getElementById("clPROV").focus();
        document.getElementById("clPROV").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV").style.boxShadow = "initial";
    }
	if (sCP == ""){
        document.getElementById("clCP").focus();
        document.getElementById("clCP").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP").style.boxShadow = "initial";
    }
	if (sADR1s == ""){
        document.getElementById("clADR1_SH").focus();
        document.getElementById("clADR1_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1_SH").style.boxShadow = "initial";
    }
	if (sVILLEs == ""){
        document.getElementById("clVILLE_SH").focus();
        document.getElementById("clVILLE_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE_SH").style.boxShadow = "initial";
    }
	if (sPROVs == ""){
        document.getElementById("clPROV_SH").focus();
        document.getElementById("clPROV_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV_SH").style.boxShadow = "initial";
    }
	if (sCPs == ""){
        document.getElementById("clCP_SH").focus();
        document.getElementById("clCP_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP_SH").style.boxShadow = "initial";
    }

    document.getElementById("btnCartToOrder").disabled = true;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim().substr(0, 3) == "ERR"){
            addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            sendEmailOrder(this.responseText.trim());
            sendEmailShipping('order',this.responseText.trim());
            clear_cart();
            //location.reload();
            
        }
	  }
	};
    xmlhttp.open('GET', '/client/cartTOorder.php?KEY='+KEY + '&SS=' + ship_code+ '&P=' + ship_price+ '&C=' + ship_carrier+ '&S=' + ship_service, true);
    xmlhttp.send();
}

function cartTOinvoice() {
    if (document.getElementById("trpTYPE")){
        var selectBox = document.getElementById("trpTYPE");
        var ship_code = selectBox.options[selectBox.selectedIndex].value;
    } else{
        var ship_code = "";
    }
	var sNOM     = document.getElementById("clNOM").value.trim();
	var sTEL1     = document.getElementById("clTEL1").value.trim();
	var sADR1    = document.getElementById("clADR1").value.trim();
	var sVILLE   = document.getElementById("clVILLE").value.trim();
	var sPROV    = document.getElementById("clPROV").value.trim();
    var sCP      = document.getElementById("clCP").value.trim();
	var sADR1s    = document.getElementById("clADR1_SH").value.trim();
	var sADR2s    = document.getElementById("clADR2_SH").value.trim();
	var sVILLEs   = document.getElementById("clVILLE_SH").value.trim();
	var sPROVs    = document.getElementById("clPROV_SH").value.trim();
	var sCPs      = document.getElementById("clCP_SH").value.trim();

    if (ship_code == "PICKUP" && CIE_PICK_CAL == "PICK_DATE" && TRP_REQ == "1" && pickup_date == ""){
        addMsg("Veuillez choisir une date et heure de ramassage, avant de continuer.<br><br><button onclick=\"closeMSG();openCALENDAR();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }

	if (sNOM == ""){
        document.getElementById("clNOM").focus();
        document.getElementById("clNOM").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clNOM');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clNOM").style.boxShadow = "initial";
    }
    if (sTEL1 == ""){
        document.getElementById("clTEL1").focus();
        document.getElementById("clTEL1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clTEL1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clTEL1").style.boxShadow = "initial";
    }
	if (sADR1 == ""){
        document.getElementById("clADR1").focus();
        document.getElementById("clADR1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1").style.boxShadow = "initial";
    }
	if (sVILLE == ""){
        document.getElementById("clVILLE").focus();
        document.getElementById("clVILLE").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE").style.boxShadow = "initial";
    }
	if (sPROV == ""){
        document.getElementById("clPROV").focus();
        document.getElementById("clPROV").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV").style.boxShadow = "initial";
    }
	if (sCP == ""){
        document.getElementById("clCP").focus();
        document.getElementById("clCP").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP").style.boxShadow = "initial";
    }
	if (sADR1s == ""){
        document.getElementById("clADR1_SH").focus();
        document.getElementById("clADR1_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1_SH").style.boxShadow = "initial";
    }
	if (sVILLEs == ""){
        document.getElementById("clVILLE_SH").focus();
        document.getElementById("clVILLE_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE_SH").style.boxShadow = "initial";
    }
	if (sPROVs == ""){
        document.getElementById("clPROV_SH").focus();
        document.getElementById("clPROV_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV_SH").style.boxShadow = "initial";
    }
	if (sCPs == ""){
        document.getElementById("clCP_SH").focus();
        document.getElementById("clCP_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP_SH").style.boxShadow = "initial";
    }

    document.getElementById("btnCartToInvoice").disabled = true;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim().substr(0, 3) == "ERR"){
            addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            sendEmailInvoice(this.responseText.trim());
            sendEmailShipping('invoice',this.responseText.trim());
            clear_cart();
            //location.reload();
            
        }
	  }
	};
    xmlhttp.open('GET', '/client/cartTOinvoice.php?KEY=' + KEY + '&SS=' + ship_code+ '&P=' + ship_price + '&C=' + ship_carrier + '&S=' + ship_service + '&PK=' + encodeURIComponent(pickup_date), true);
    xmlhttp.send();
}

function stripe_pay_subscription() {
    document.getElementById("btnPrdToCheckout").disabled = true;
    window.open('/client/prdTOcheckout.php?KEY='+KEY,'_self');
}

function cartTOcheckout() {
    if (document.getElementById("trpTYPE")){
        var selectBox = document.getElementById("trpTYPE");
        var ship_code = selectBox.options[selectBox.selectedIndex].value;
    } else{
        var ship_code = "";
    }
	var sNOM     = document.getElementById("clNOM").value.trim();
	var sTEL1     = document.getElementById("clTEL1").value.trim();
	var sADR1    = document.getElementById("clADR1").value.trim();
	var sVILLE   = document.getElementById("clVILLE").value.trim();
	var sPROV    = document.getElementById("clPROV").value.trim();
    var sCP      = document.getElementById("clCP").value.trim();
	var sADR1s    = document.getElementById("clADR1_SH").value.trim();
	var sADR2s    = document.getElementById("clADR2_SH").value.trim();
	var sVILLEs   = document.getElementById("clVILLE_SH").value.trim();
	var sPROVs    = document.getElementById("clPROV_SH").value.trim();
	var sCPs      = document.getElementById("clCP_SH").value.trim();

    if (ship_code == "PICKUP" && CIE_PICK_CAL == "PICK_DATE" && TRP_REQ == "1" && pickup_date == ""){
        addMsg("Veuillez choisir une date et heure de ramassage, avant de continuer.<br><br><button onclick=\"closeMSG();openCALENDAR();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }

	if (sNOM == ""){
        document.getElementById("clNOM").focus();
        document.getElementById("clNOM").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clNOM');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clNOM").style.boxShadow = "initial";
    }
    if (sTEL1 == ""){
        document.getElementById("clTEL1").focus();
        document.getElementById("clTEL1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clTEL1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clTEL1").style.boxShadow = "initial";
    }
	if (sADR1 == ""){
        document.getElementById("clADR1").focus();
        document.getElementById("clADR1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1").style.boxShadow = "initial";
    }
	if (sVILLE == ""){
        document.getElementById("clVILLE").focus();
        document.getElementById("clVILLE").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE").style.boxShadow = "initial";
    }
	if (sPROV == ""){
        document.getElementById("clPROV").focus();
        document.getElementById("clPROV").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV").style.boxShadow = "initial";
    }
	if (sCP == ""){
        document.getElementById("clCP").focus();
        document.getElementById("clCP").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP").style.boxShadow = "initial";
    }
	if (sADR1s == ""){
        document.getElementById("clADR1_SH").focus();
        document.getElementById("clADR1_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1_SH").style.boxShadow = "initial";
    }
	if (sVILLEs == ""){
        document.getElementById("clVILLE_SH").focus();
        document.getElementById("clVILLE_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE_SH").style.boxShadow = "initial";
    }
	if (sPROVs == ""){
        document.getElementById("clPROV_SH").focus();
        document.getElementById("clPROV_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV_SH").style.boxShadow = "initial";
    }
	if (sCPs == ""){
        document.getElementById("clCP_SH").focus();
        document.getElementById("clCP_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP_SH").style.boxShadow = "initial";
    }
    document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";        
    document.getElementById("divMSG").style.display = "inline-block";
    if (USER_LANG == "FR"){
	    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    }else{
	    document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    }

    document.getElementById("btnCartToCheckout").disabled = true;
    window.open('/client/cartTOcheckout.php?KEY='+KEY + '&SS=' + ship_code+ '&P=' + ship_price+ '&C=' + ship_carrier+ '&S=' + ship_service,'_self');
    //setTimeout(function () {clear_cart();location.reload();}, 2000);
/*     var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim().substr(0, 3) == "ERR"){
            addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            sendEmailInvoice(this.responseText.trim());
            deleteAllCookies();
            //location.reload();
            
        }
	  }
	};
		xmlhttp.open('GET', '/client/cartTOcheckout.php?KEY='+KEY + '&S=' + ship_code+ '&P=' + ship_price, true);
		xmlhttp.send(); */
}

function square_pay_invoice(IID) {
    document.getElementById("divMSG").style.display = "inline-block";
    if (USER_LANG == "FR"){
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }else{
        document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        window.open(this.responseText.trim(),'_self');
    }
    };
    xmlhttp.open('GET', 'square-invoice.php?KEY='+KEY+'&IID='+IID, true);
    xmlhttp.send();
}

function cartTOsquare() {
    if (document.getElementById("trpTYPE")){
        var selectBox = document.getElementById("trpTYPE");
        var ship_code = selectBox.options[selectBox.selectedIndex].value;
    } else{
        var ship_code = "";
    }
	var sNOM     = document.getElementById("clNOM").value.trim();
	var sTEL1     = document.getElementById("clTEL1").value.trim();
	var sADR1    = document.getElementById("clADR1").value.trim();
	var sVILLE   = document.getElementById("clVILLE").value.trim();
	var sPROV    = document.getElementById("clPROV").value.trim();
    var sCP      = document.getElementById("clCP").value.trim();
	var sADR1s    = document.getElementById("clADR1_SH").value.trim();
	var sADR2s    = document.getElementById("clADR2_SH").value.trim();
	var sVILLEs   = document.getElementById("clVILLE_SH").value.trim();
	var sPROVs    = document.getElementById("clPROV_SH").value.trim();
	var sCPs      = document.getElementById("clCP_SH").value.trim();

    if (ship_code == "PICKUP" && CIE_PICK_CAL == "PICK_DATE" && TRP_REQ == "1" && pickup_date == ""){
        addMsg("Veuillez choisir une date et heure de ramassage, avant de continuer.<br><br><button onclick=\"closeMSG();openCALENDAR();\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
	if (sNOM == ""){
        document.getElementById("clNOM").focus();
        document.getElementById("clNOM").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clNOM');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clNOM").style.boxShadow = "initial";
    }
    if (sTEL1 == ""){
        document.getElementById("clTEL1").focus();
        document.getElementById("clTEL1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clTEL1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clTEL1").style.boxShadow = "initial";
    }
	if (sADR1 == ""){
        document.getElementById("clADR1").focus();
        document.getElementById("clADR1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1").style.boxShadow = "initial";
    }
	if (sVILLE == ""){
        document.getElementById("clVILLE").focus();
        document.getElementById("clVILLE").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE").style.boxShadow = "initial";
    }
	if (sPROV == ""){
        document.getElementById("clPROV").focus();
        document.getElementById("clPROV").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV").style.boxShadow = "initial";
    }
	if (sCP == ""){
        document.getElementById("clCP").focus();
        document.getElementById("clCP").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP").style.boxShadow = "initial";
    }
	if (sADR1s == ""){
        document.getElementById("clADR1_SH").focus();
        document.getElementById("clADR1_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1_SH").style.boxShadow = "initial";
    }
	if (sVILLEs == ""){
        document.getElementById("clVILLE_SH").focus();
        document.getElementById("clVILLE_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE_SH").style.boxShadow = "initial";
    }
	if (sPROVs == ""){
        document.getElementById("clPROV_SH").focus();
        document.getElementById("clPROV_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV_SH").style.boxShadow = "initial";
    }
	if (sCPs == ""){
        document.getElementById("clCP_SH").focus();
        document.getElementById("clCP_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP_SH").style.boxShadow = "initial";
    }
    document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";        
    document.getElementById("divMSG").style.display = "inline-block";
    if (USER_LANG == "FR"){
	    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    } else {
	    document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    }

    document.getElementById("btnCartToCheckout").disabled = true;

    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                window.open(this.responseText.trim(),'_self'); 
            }
        };
        xmlhttp.open('GET', '/client/square-checkout.php?KEY='+KEY + '&SS=' + ship_code+ '&P=' + ship_price+ '&C=' + ship_carrier+ '&S=' + ship_service + '&PK=' + encodeURIComponent(pickup_date), true);
        xmlhttp.send();
        document.getElementById("divMSG").style.display = "inline-block";
        if (USER_LANG == "FR"){
            document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
        }else{
            document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
        }
    //window.open('/client/square-checkout.php?KEY='+KEY + '&SS=' + ship_code+ '&P=' + ship_price+ '&C=' + ship_carrier+ '&S=' + ship_service,'_self'); 
    //setTimeout(function () {clear_cart();location.reload();}, 2000);
/*     var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim().substr(0, 3) == "ERR"){
            addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            sendEmailInvoice(this.responseText.trim());
            deleteAllCookies();
            //location.reload();
            
        }
	  }
	};
		xmlhttp.open('GET', '/client/cartTOcheckout.php?KEY='+KEY + '&S=' + ship_code+ '&P=' + ship_price, true);
		xmlhttp.send(); */
}
/* function marketTOcheckout() {
    if (document.getElementById("trpTYPE2")){
        var selectBox = document.getElementById("trpTYPE2");
        var ship_code = selectBox.options[selectBox.selectedIndex].value;
    } else{
        var ship_code = "";
    }
	var sNOM     = document.getElementById("clNOM").value.trim();
	var sTEL1     = document.getElementById("clTEL1").value.trim();
	var sADR1    = document.getElementById("clADR1").value.trim();
	var sVILLE   = document.getElementById("clVILLE").value.trim();
	var sPROV    = document.getElementById("clPROV").value.trim();
    var sCP      = document.getElementById("clCP").value.trim();
	var sADR1s    = document.getElementById("clADR1_SH").value.trim();
	var sADR2s    = document.getElementById("clADR2_SH").value.trim();
	var sVILLEs   = document.getElementById("clVILLE_SH").value.trim();
	var sPROVs    = document.getElementById("clPROV_SH").value.trim();
	var sCPs      = document.getElementById("clCP_SH").value.trim();

	if (sNOM == ""){
        document.getElementById("clNOM").focus();
        document.getElementById("clNOM").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clNOM');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clNOM").style.boxShadow = "initial";
    }
    if (sTEL1 == ""){
        document.getElementById("clTEL1").focus();
        document.getElementById("clTEL1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clTEL1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clTEL1").style.boxShadow = "initial";
    }
	if (sADR1 == ""){
        document.getElementById("clADR1").focus();
        document.getElementById("clADR1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1").style.boxShadow = "initial";
    }
	if (sVILLE == ""){
        document.getElementById("clVILLE").focus();
        document.getElementById("clVILLE").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE").style.boxShadow = "initial";
    }
	if (sPROV == ""){
        document.getElementById("clPROV").focus();
        document.getElementById("clPROV").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV").style.boxShadow = "initial";
    }
	if (sCP == ""){
        document.getElementById("clCP").focus();
        document.getElementById("clCP").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP").style.boxShadow = "initial";
    }
	if (sADR1s == ""){
        document.getElementById("clADR1_SH").focus();
        document.getElementById("clADR1_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1_SH").style.boxShadow = "initial";
    }
	if (sVILLEs == ""){
        document.getElementById("clVILLE_SH").focus();
        document.getElementById("clVILLE_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE_SH").style.boxShadow = "initial";
    }
	if (sPROVs == ""){
        document.getElementById("clPROV_SH").focus();
        document.getElementById("clPROV_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV_SH").style.boxShadow = "initial";
    }
	if (sCPs == ""){
        document.getElementById("clCP_SH").focus();
        document.getElementById("clCP_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP_SH").style.boxShadow = "initial";
    }

    document.getElementById("btnMarketToCheckout").disabled = true;
    window.open('/client/marketTOcheckout.php?KEY='+KEY + '&SS=' + ship_code+ '&P=' + ship_price+ '&C=' + ship_carrier+ '&S=' + ship_service,'_self');
    setTimeout(function () {deleteAdCookies();location.reload();}, 2000);
} */

//downloads
var dw3_cancel_download = false;
function dw3_download(product_id,file_url,that_button) {
    that_button.disabled = true;
    document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";        
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "<span class='material-icons'>system_update_alt</span><br><div id='dw3_download_msg' style='width:300px;'></div><br><br><button class='grey' onclick='closeMSG();dw3_cancel_download=true;'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Cancel</button>";

    const startTime = new Date().getTime();
    request = new XMLHttpRequest();
    request.responseType = "blob";
    request.open("get", file_url, true);
    request.send();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        const imageURL = window.URL.createObjectURL(this.response);
        const anchor = document.createElement("a");
        anchor.href = imageURL;
        anchor.download = file_url.substring(file_url.lastIndexOf('/')+1);
        document.body.appendChild(anchor);
        anchor.click();
        that_button.innerHTML ='<span class="material-icons">download_done</span> Done';
        closeMSG();
        dw3_updatedl_count(product_id);
        }
    };

    request.onprogress = function (e) {
        const percent_complete = Math.floor((e.loaded / e.total) * 100); 
        const duration = (new Date().getTime() - startTime) / 1000;
        const bps = e.loaded / duration;
        const kbps = Math.floor(bps / 1024);
        const time = (e.total - e.loaded) / bps;
        const seconds = Math.floor(time % 60);
        const minutes = Math.floor(time / 60);
        document.getElementById('dw3_download_msg').innerHTML = `<b>${percent_complete}%</b> - ${kbps} Kbps <br> <b>${minutes}</b> min <b>${seconds}</b> sec remaining`;
        //that.innerText = `${percent_complete}%`;
        //that.innerText = `${percent_complete}% - ${kbps} Kbps - ${minutes} min ${seconds} sec remaining`;
        if (dw3_cancel_download == true){
            dw3_cancel_download = false;
            request.abort();
            that_button.innerHTML ='<span class="material-icons">file_download_off</span> Canceled';
        }
    };
}

function dw3_updatedl_count(product_id){
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('GET', '/pub/section/products/dw3_updatedl_count.php?ID=' + product_id , true);
	xmlhttp.send();
}
//cart

function dw3_cart_add(product_id){
    var counter = dw3_get_cookie("CART_COUNT");
    //console.log(counter);
    if (counter == "" || counter == undefined){ counter = 0;}
    //console.log(counter);
    counter++;
    //console.log(counter);
    document.cookie = "CART_COUNT="+counter+";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText)
        }
    }
    xmlhttp.open('GET', '/pub/section/products/dw3_cart_add.php?ID=' + product_id , true);
    xmlhttp.send();
    dw3_notif_add("Un item a été ajouté à votre panier.");
}

function clear_cart(){
    //if(Number(counter) < qtyMAX || qtyMAX == ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                //location.reload();
            }
        }
        xmlhttp.open('GET', 'clear_cart.php?KEY=' + KEY, true);
        xmlhttp.send();        
    //}
}
function dw3_cart_plus(line_id,qtyMAX = ""){
    //if(Number(counter) < qtyMAX || qtyMAX == ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                location.reload();
            }
        }
        xmlhttp.open('GET', '/pub/section/products/dw3_cart_plus.php?ID=' + line_id + '&MAX=' + qtyMAX, true);
        xmlhttp.send();        
    //}
}
function dw3_cart_minus(line_id,qtyMIN = ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.cookie = "CART_COUNT="+this.responseText+";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
                location.reload();
            }
        }
        xmlhttp.open('GET', '/pub/section/products/dw3_cart_minus.php?ID=' + line_id + '&MIN=' + qtyMIN, true);
        xmlhttp.send(); 
}
function dw3_cart_change(line_id, qtyMAX = "", qtyMIN = ""){
    var cart_qty = document.getElementById('dw3_cart_item_qty_'+line_id).value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            document.getElementById('dw3_cart_item_qty'+line_id).value = response.line_qty;
            document.cookie = "CART_COUNT="+response.cart_count+";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
            localStorage.setItem("dw3_client_msg", response.response_text);
            location.reload();
        }
    }
    xmlhttp.open('GET', '/pub/section/products/dw3_cart_change.php?ID=' + line_id + '&MIN=' + qtyMIN + '&MAX=' + qtyMAX + '&QTY=' + cart_qty, true);
    xmlhttp.send(); 
}
function dw3_cart_plusX(line_id,qtyMAX = ""){
    //if(Number(counter) < qtyMAX || qtyMAX == ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                location.reload();
            }
        }
        xmlhttp.open('GET', '/pub/section/products/dw3_cart_plusX.php?ID=' + line_id + '&MAX=' + qtyMAX, true);
        xmlhttp.send();        
    //}
}
function dw3_cart_minusX(line_id,qtyMIN = ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.cookie = "CART_COUNT="+this.responseText+";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
                location.reload();
            }
        }
        xmlhttp.open('GET', '/pub/section/products/dw3_cart_minusX.php?ID=' + line_id + '&MIN=' + qtyMIN, true);
        xmlhttp.send(); 
}
function updCART_OPTION(lnID,optID,optlID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        dw3_notif_add("Option mise à jour.");
        location.reload();
	  }
	};
		xmlhttp.open('GET', '/pub/section/products/updCART_OPTION.php?KEY=' + KEY + '&lnID=' + lnID + '&optID=' + optID + '&optlID=' + optlID , true);
		xmlhttp.send();
}

function dw3_cart_del(line_id){
/*     document.cookie = "CART_" + id + "=0;path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    dw3_cart_count();
    dw3_notif_add("Un item a été retiré de votre panier.");
    location.reload(); */
    var counter = dw3_get_cookie("CART_COUNT");
    if (counter == "" || counter == undefined || counter <= 0|| counter == "0"){ counter = 0;} else {counter = counter -1;}
    document.cookie = "CART_COUNT="+counter+";path=/;domain=.<?php echo $_SERVER["SERVER_NAME"]; ?>;";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText);
            location.reload();
        }
    }
    xmlhttp.open('GET', '/pub/section/products/dw3_cart_del.php?ID=' + line_id , true);
	xmlhttp.send();
    dw3_notif_add("Un item a été retiré de votre panier.");
}

function dw3_get_cookie(name) {
    const regex = new RegExp(`(^| )${name}=([^;]+)`)
    const match = document.cookie.match(regex)
    if (match) {
        return match[2];
    }
}

function dw3_notif_add(text) { //rename to dw3_notif(text);
	//sNotifCount++;
    const newDiv = document.createElement("div");
    //const newContent = document.createTextNode(String());
    //const newContent2 = document.createTextNode(" X ");
    //newDiv.style.position = "fixed";
    //newDiv.style.right = "2px";
    //newDiv.style.top = (35*sNotifCount) + "px";
    newDiv.style.background = "#EEE";
    newDiv.style.borderRadius = "5px";
    newDiv.style.color = "darkgreen";
    newDiv.style.border = "1px dotted darkgreen";
    //newDiv.style.zIndex = "3000";
    newDiv.style.transition ="all 1s";
    newDiv.style.fontWeight ="bold";
    newDiv.style.width ="auto";
    newDiv.style.textShadow ="2px 2px #DDDDDD";
    newDiv.style.padding ="0px 5px 5px 5px";
    newDiv.style.margin ="5px";
    newDiv.style.cursor ="pointer";
    newDiv.style.display ="table";
    newDiv.style.float ="right";
    newDiv.style.whiteSpace ="nowrap";
    //newContent2.style.background = "white";
    //newContent2.style.color = "darkgreen";
    //newDiv.appendChild(newContent2);
    newDiv.innerHTML = "<span style='font-size:1.1em;margin-top:-3px;font-weight:normal;color:goldenrod;vertical-align:middle;'>&#x26A0;</span> <span style='vertical-align:middle;'>&nbsp; " + text + "&nbsp; </span> <sup><span class='material-icons' style='font-size:0.8em;font-weight:normal;color:#990000'>close</span></sup>";
    const currentDiv = document.getElementById("dw3_notif_container");
    //document.body.insertBefore(newDiv, currentDiv);
	currentDiv.appendChild(newDiv);
/*     newDiv.addEventListener("click", function(event) {
            newDiv.style.opacity = "0";
            setTimeout(function () {
                newDiv.style.display = "none";
            }, 1000);
    }); */
    setTimeout(function () {
		newDiv.style.opacity = "0";
	}, 5000);
    setTimeout(function () {
		newDiv.style.display = "none";
        newDiv.remove();
		//sNotifCount = sNotifCount-1;
	}, 6000);
}
function deleteFILE(fn) {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.6";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button class='red' onclick=\"delFILE('" + fn + "');\"><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}
function delFILE(fn) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            location.reload();
	  }
	};
		xmlhttp.open('GET', 'deleteFILE.php?KEY=' + KEY + '&fn=' + encodeURIComponent(fn) , true);
		xmlhttp.send();
}

function getPRD(prID) {
    //document.getElementById("divFADE2").style.opacity = "0.6";
	    //document.getElementById("divFADE2").style.display = "inline-block";	 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("dw3_editor").innerHTML = this.responseText;
        document.getElementById("dw3_editor").style.display = "inline-block";
        document.getElementById("dw3_editor").style.opacity = "1";
        dw3_drag_init(document.getElementById('dw3_editor'));
	  }
	};
		xmlhttp.open('GET', '/pub/section/products/getPRD.php?KEY=' + KEY + '&P=' + prID , true);
		xmlhttp.send();
}
function dw3_change_image(filename,element) {
    document.getElementById(element).src=filename;
}
function downloadFILE(userID,fn) {
    window.open('secure_download.php?KEY=' + KEY + '&fn=/fs/customer/' + userID +'/'+fn);
}
function getFCT(ID) {
    window.open('secure_download.php?KEY=' + KEY + '&fn=/fs/invoice/' + ID +'.pdf');
}
function dw3_editor_close() {
	document.getElementById('dw3_editor').style.display = 'none';
    document.getElementById('dw3_editor').style.opacity = '0';
	//document.getElementById('divFADE2').style.display = 'none';
    //document.getElementById("divFADE2").style.opacity = "0";
}
function orderTOfct(order_id) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim() != ""){
            addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            location.reload();

        }
	  }
	};
		xmlhttp.open('GET', '/client/orderTOfct.php?KEY='+KEY+'&ID='+order_id, true);
		xmlhttp.send();
}

function getORDERlines(head_id) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            addMsg(this.responseText + "<br><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>close</span> Fermer</button>");
	  }
	};
		xmlhttp.open('GET', '/client/getORDERlines.php?KEY='+KEY+'&ID='+head_id, true);
		xmlhttp.send();
}

function orderExpeds(head_id) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            addMsg(this.responseText + "<br><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>close</span> Fermer</button>");
	  }
	};
		xmlhttp.open('GET', '/client/getORDERexpeds.php?KEY='+KEY+'&ID='+head_id, true);
		xmlhttp.send();
}


function openSub(sub,up,then){
    //alert (document.getElementById(sub).style.height);
    if(document.getElementById(sub).style.height=="0px"){
        document.getElementById(up).innerHTML="keyboard_arrow_down";
        document.getElementById(sub).style.height="auto";
        document.getElementById(sub).style.display="inline-block";
    }
    document.getElementById(then).focus();
}

var is_ADS_LOADED = false;
var is_HIST_FCT_LOADED = false;
var is_SALES_LOADED = false;
function toggleSub(sub,up){
	if(document.getElementById(sub).style.height=="0px"){
		document.getElementById(up).innerHTML="keyboard_arrow_down";
		document.getElementById(sub).style.height="auto";
		document.getElementById(sub).style.display="inline-block";
        if (sub == "divSub2" && !is_HIST_FCT_LOADED){
            getHIST_FCT(0,TABLES_LIMIT);
        } else if (sub=="divSub10" && !is_ADS_LOADED){
            getADS(0,ADS_LIMIT);
        } else if (sub=="divSub13" && !is_SALES_LOADED){
            getSALES(0,TABLES_LIMIT);
        }
	} else {
		document.getElementById(up).innerHTML="keyboard_arrow_up";
		document.getElementById(sub).style.height="0px";
		document.getElementById(sub).style.display="none";
	}
}


function getSALES(sOFFSET,sLIMIT) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divSub13").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getSALES.php?KEY='+KEY + '&OFFSET=' + sOFFSET + '&LIMIT=' + sLIMIT, true);
		xmlhttp.send();
        is_SALES_LOADED = true;
}
function getHIST_FCT(sOFFSET,sLIMIT) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divSub2").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getHIST_FCT.php?KEY='+KEY + '&OFFSET=' + sOFFSET + '&LIMIT=' + sLIMIT, true);
		xmlhttp.send();
        is_HIST_FCT_LOADED = true;
}
function logOUT_CTS() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		//location.reload();
        window.open("https://<?php echo $_SERVER["SERVER_NAME"]; ?>","_self");
	  }
	};
		xmlhttp.open('GET', 'logout.php?KEY='+KEY, true);
		xmlhttp.send();
}
function delSchedule(schedule_id) {
    if (USER_LANG == "FR"){
        addMsg("Pour annuler votre rendez-vous, veuillez communiquer avec nous au: <span style='white-space:no-wrap;'><?php echo $CIE_TEL1; ?></span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
    }else{
        addMsg("To cancel your appointment, please contact us at: <span style='white-space:no-wrap;'><?php echo $CIE_TEL1; ?></span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
    }
    return false;
/* 	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		location.reload();
        
	  }
	};
		xmlhttp.open('GET', 'delSchedule.php?KEY='+KEY+'&ID='+schedule_id, true);
		xmlhttp.send(); */
		
}
function saveOPT(){
	var GRPBOX  = document.getElementById("cfgTYPE");
	var sTYPE  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("cfgCAT");
	var sCAT  = GRPBOX.options[GRPBOX.selectedIndex].value;


	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updPLAN.php?KEY=' + KEY 
										+ '&TYPE=' + encodeURIComponent(sTYPE)
										+ '&CAT=' + encodeURIComponent(sCAT),
										true);
		xmlhttp.send();
}
function resetPW() {
	var sEML = document.getElementById("clEML1").value;
    if (sEML.indexOf("@") == -1){
        document.getElementById("divFADE2").style.opacity = "0.6";
	    document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        if (USER_LANG == "FR"){
		    document.getElementById("divMSG").innerHTML = "Veuillez entrer votre adresse courriel pour réinitialiser le mot de passe.<br><br><button onclick='closeMSG();document.getElementById(\"clEML1\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        }else{
		    document.getElementById("divMSG").innerHTML = "Please enter your email address to reset the password.<br><br><button onclick='closeMSG();document.getElementById(\"clEML1\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        }
        document.getElementById("clEML1").style.boxShadow = "5px 10px 15px red";
		document.getElementById("clEML1").focus();
        return;
    }
    document.getElementById("clEML1").style.boxShadow = "5px 10px 15px grey";
    document.getElementById("divFADE2").innerHTML = "";
    document.getElementById("divFADE2").style.verticalAlign = "middle";
    document.getElementById("divFADE2").style.opacity = "0.6";
	document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
    if (USER_LANG == "FR"){
	    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    }else{
	    document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    }

		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
                document.getElementById("divMSG").style.display = "inline-block";
                if (USER_LANG == "FR"){
				    document.getElementById("divMSG").innerHTML = this.responseText + "Un courriel pour réinitialiser le mot de passe vous a été envoyé.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                    document.getElementById("btnReset").innerHTML="Verifiez votre boite courriel.";
                }else{
				    document.getElementById("divMSG").innerHTML = this.responseText + "An email to reset the password has been sent to you.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                    document.getElementById("btnReset").innerHTML="Check your email box.";
                }                    
                document.getElementById("btnReset").disabled = true;
		  };
        }
        xmlhttp.open('GET', '/sbin/resetPW.php?EML=' + encodeURIComponent(sEML), true);
		xmlhttp.send();
}

function addNotif(text) { //rename to dw3_notif(text);
	//sNotifCount++;
    const newDiv = document.createElement("div");
    //const newContent = document.createTextNode(String());
    //const newContent2 = document.createTextNode(" X ");
    //newDiv.style.position = "fixed";
    //newDiv.style.right = "2px";
    //newDiv.style.top = (35*sNotifCount) + "px";
    newDiv.style.background = "#EEE";
    newDiv.style.borderRadius = "5px";
    newDiv.style.color = "darkgreen";
    newDiv.style.border = "1px dotted darkgreen";
    //newDiv.style.zIndex = "3000";
    newDiv.style.transition ="all 1s";
    newDiv.style.fontWeight ="bold";
    newDiv.style.width ="auto";
    newDiv.style.textShadow ="2px 2px #DDDDDD";
    newDiv.style.padding ="0px 5px 5px 5px";
    newDiv.style.margin ="5px";
    newDiv.style.cursor ="pointer";
    newDiv.style.display ="table";
    newDiv.style.float ="right";
    newDiv.style.whiteSpace ="nowrap";
    //newContent2.style.background = "white";
    //newContent2.style.color = "darkgreen";
    //newDiv.appendChild(newContent2);
    newDiv.innerHTML = "<span style='font-size:1.1em;margin-top:-3px;font-weight:normal;color:goldenrod;vertical-align:middle;'>&#x26A0;</span> <span style='vertical-align:middle;'>&nbsp; " + text + "&nbsp; </span> <sup><span class='material-icons' style='font-size:0.8em;font-weight:normal;color:#990000'>close</span></sup>";
    const currentDiv = document.getElementById("dw3_notif_container");
    //document.body.insertBefore(newDiv, currentDiv);
	currentDiv.appendChild(newDiv);
/*     newDiv.addEventListener("click", function(event) {
            newDiv.style.opacity = "0";
            setTimeout(function () {
                newDiv.style.display = "none";
            }, 1000);
    }); */
    setTimeout(function () {
		newDiv.style.opacity = "0";
	}, 5000);
    setTimeout(function () {
		newDiv.style.display = "none";
        newDiv.remove();
		//sNotifCount = sNotifCount-1;
	}, 6000);
}


//drag obj using first child 
function dw3_drag_init(elmnt) {
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    if (document.getElementById(elmnt.id + "_HEADER")) {
        // if present, the header is where you move the DIV from:
        document.getElementById(elmnt.id + "_HEADER").onmousedown = dragMouseDown;
    } else if (document.getElementById(elmnt.id + "_HEAD")){
        document.getElementById(elmnt.id + "_HEAD").onmousedown = dragMouseDown;
    } else {
        // otherwise, move the DIV from anywhere inside the DIV:
        elmnt.onmousedown = dragMouseDown;
    }
    function dragMouseDown(e) {
      e = e || window.event;
      e.preventDefault();
      pos3 = e.clientX;
      pos4 = e.clientY;
      document.onmouseup = closeDragElement;
      document.onmousemove = elementDrag;
    }
    function elementDrag(e) {
      e = e || window.event;
      e.preventDefault();
      pos1 = pos3 - e.clientX;
      pos2 = pos4 - e.clientY;
      pos3 = e.clientX;
      pos4 = e.clientY;
      elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
      elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }
    function closeDragElement() {
      document.onmouseup = null;
      document.onmousemove = null;
    }
}

function initMap() {
	//navigator.geolocation.getCurrentPosition(function(position) {
		var pos = {
				lat: <?php echo $CIE_LAT; ?>,
				lng: <?php echo $CIE_LNG; ?>
		};
		window.pos = pos;
		//directionsService = new google.maps.DirectionsService;
		//directionsDisplay = new google.maps.DirectionsRenderer;
		//directionsRenderer = new google.maps.DirectionsRenderer();
		map = new google.maps.Map(document.getElementById("googleMap"), {
			zoom: 16,
			center: {lat: pos.lat, lng: pos.lng},
		});
		//directionsDisplay.setMap(map);
		//directionsRenderer.setMap(map);
		var me = new google.maps.LatLng(pos.lat, pos.lng);
		myloc = new google.maps.Marker({
			clickable: false,
			icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
															new google.maps.Size(22,22),
															new google.maps.Point(0,18),
															new google.maps.Point(11,11)),
			shadow: null,
			zIndex: 999,
			map: map
		});	
		myloc.setPosition(me);
	//});
}
function detectCLICK(event,that){  //rename to dw3_input_click(event,that);
	var x = event.offsetX;
	if (x > (that.offsetWidth-25)){
        that.select();
	}
}

//set map coords after adress update
function setLngLat() {
var geocoder = new google.maps.Geocoder();
var address = document.getElementById("clADR1_SH").value
				+ " " + document.getElementById("clADR2_SH").value
				+ ", " + document.getElementById("clVILLE_SH").value
				+ " " + document.getElementById("clCP_SH").value
				+ " " + document.getElementById("clPROV_SH").value
				+ " Canada";
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK)
    {
        var sLNG = results[0].geometry.location.lng();
        var sLAT = results[0].geometry.location.lat();
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                addNotif("Vos coordonées ont étés mises à jour.");
            }
        };
            xmlhttp.open('GET', 'updcoords.php?KEY=' + KEY 
                                            + '&ID=' + USER   
                                            + '&LNG=' + encodeURIComponent(sLNG)   
                                            + '&LAT=' + encodeURIComponent(sLAT),                 
                                            true);
            xmlhttp.send();
    }
});
}

function updCLI(then_what){
    var GRPBOX  = document.getElementById("clLANG");
	var sLANG = GRPBOX.options[GRPBOX.selectedIndex].value;
/* 	var sPREFIX  = document.getElementById("clPREFIX").value;
	var sPRENOM  = document.getElementById("clPRENOM").value;
	var sPRENOM2  = document.getElementById("clPRENOM2").value;
	var sSUFFIX  = document.getElementById("clSUFFIX").value; */
	var sUSER_NAME     = document.getElementById("clUSER_NAME").value.trim();
	var sNOM     = document.getElementById("clNOM").value.trim();
	var sCIE    = document.getElementById("clCOMPANY").value.trim();
	var sWEB    = document.getElementById("clWEB").value.trim();
	var sTEL1    = document.getElementById("clTEL1").value.trim();
	var sADR1    = document.getElementById("clADR1").value.trim();
	var sADR2    = document.getElementById("clADR2").value.trim();
	var sVILLE   = document.getElementById("clVILLE").value.trim();
	var GRPBOX = document.getElementById("clPROV");
	var sPROV = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sCP      = document.getElementById("clCP").value.trim();
	var sADR1s    = document.getElementById("clADR1_SH").value.trim();
	var sADR2s    = document.getElementById("clADR2_SH").value.trim();
	var sVILLEs   = document.getElementById("clVILLE_SH").value.trim();
	var GRPBOX = document.getElementById("clPROV_SH");
	var sPROVs = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sCPs      = document.getElementById("clCP_SH").value.trim();
    if (document.getElementById("cl2Factor").checked == false){var s2Factor = 0; } else {var s2Factor = 1; }
	
    if (sNOM == ""){
        document.getElementById("clNOM").focus();
        document.getElementById("clNOM").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clNOM');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clNOM").style.boxShadow = "initial";
    }
    if (sTEL1 == ""){
        document.getElementById("clTEL1").focus();
        document.getElementById("clTEL1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clTEL1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clTEL1").style.boxShadow = "initial";
    }
	if (sADR1 == ""){
        document.getElementById("clADR1").focus();
        document.getElementById("clADR1").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1").style.boxShadow = "initial";
    }
	if (sVILLE == ""){
        document.getElementById("clVILLE").focus();
        document.getElementById("clVILLE").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE").style.boxShadow = "initial";
    }
	if (sPROV == ""){
        document.getElementById("clPROV").focus();
        document.getElementById("clPROV").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV").style.boxShadow = "initial";
    }
	if (sCP == ""){
        document.getElementById("clCP").focus();
        document.getElementById("clCP").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP").style.boxShadow = "initial";
    }
	if (sADR1s == ""){
        document.getElementById("clADR1_SH").focus();
        document.getElementById("clADR1_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clADR1_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clADR1_SH").style.boxShadow = "initial";
    }
	if (sVILLEs == ""){
        document.getElementById("clVILLE_SH").focus();
        document.getElementById("clVILLE_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clVILLE_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clVILLE_SH").style.boxShadow = "initial";
    }
	if (sPROVs == ""){
        document.getElementById("clPROV_SH").focus();
        document.getElementById("clPROV_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clPROV_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clPROV_SH").style.boxShadow = "initial";
    }
	if (sCPs == ""){
        document.getElementById("clCP_SH").focus();
        document.getElementById("clCP_SH").style.boxShadow = "5px 10px 15px red";
        addMsg("Veuillez terminer de remplir vos informations dans la section -Profil- et de les enregistrer.<br><br><button onclick=\"closeMSG();openSub('divSub1','up1','clCP_SH');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    } else {
        document.getElementById("clCP_SH").style.boxShadow = "initial";
    }
    
    document.getElementById("divFADE2").style.opacity = "0.6";
	document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
    if (USER_LANG == "FR"){
	    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }else{
	    document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
                toggleSub('divSub1','up1');
                if (then_what =="cartTOorder"){
                    cartTOorder();
                } else if (then_what =="cartTOinvoice"){
                    cartTOinvoice();
                } else if (then_what =="cartTOcheckout"){
                    cartTOcheckout();
                } else if (then_what =="cartTOpaypal"){
                    cartTOpaypal();
                } else if (then_what =="cartTOsquare"){
                    cartTOsquare();
                } else {
                    if (sLANG != "<?php echo $USER_LANG; ?>"){
                        location.reload();
                    } else {
                        closeMSG();
                        addNotif("Vos informations de profil ont étés mises à jour.");
                    }
                }
		  } else {
		        document.getElementById("divFADE2").style.display = "inline-block";
		        document.getElementById("divFADE2").style.opacity = "0.4";
                document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updinfo.php?KEY=' + KEY 
										+ '&ID=' + USER 
										+ '&LANG=' + sLANG   
										+ '&F=' + s2Factor    
										+ '&USER_NAME=' + encodeURIComponent(sUSER_NAME)   
										+ '&NOM=' + encodeURIComponent(sNOM)   
										+ '&CIE=' + encodeURIComponent(sCIE)   
										+ '&WEB=' + encodeURIComponent(sWEB)   
										+ '&TEL1=' + encodeURIComponent(sTEL1)   
	    								+ '&ADR1=' + encodeURIComponent(sADR1)   
										+ '&ADR2=' + encodeURIComponent(sADR2)   
										+ '&VILLE=' + encodeURIComponent(sVILLE)   
										+ '&PROV=' + encodeURIComponent(sPROV)     
										+ '&CP=' + encodeURIComponent(sCP)                
	    								+ '&ADR1_SH=' + encodeURIComponent(sADR1s)   
										+ '&ADR2_SH=' + encodeURIComponent(sADR2s)   
										+ '&VILLE_SH=' + encodeURIComponent(sVILLEs)   
										+ '&PROV_SH=' + encodeURIComponent(sPROVs)     
										+ '&CP_SH=' + encodeURIComponent(sCPs),                 
										true);
		xmlhttp.send();
        setLngLat();
}


//dw3_datetime_pick
const calendarDates = document.querySelector('.calendar-dates');
const monthYear = document.getElementById('month-year');
const prevMonthBtn = document.getElementById('prev-month');
const nextMonthBtn = document.getElementById('next-month');

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

const is_j0_open = <?php if (intval(substr($CIE_OPEN_J0_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J0_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J0_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J0_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j1_open = <?php if (intval(substr($CIE_OPEN_J1_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J1_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J1_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J1_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j2_open = <?php if (intval(substr($CIE_OPEN_J2_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J2_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J2_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J2_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j3_open = <?php if (intval(substr($CIE_OPEN_J3_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J3_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J3_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J3_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j4_open = <?php if (intval(substr($CIE_OPEN_J4_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J4_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J4_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J4_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j5_open = <?php if (intval(substr($CIE_OPEN_J5_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J5_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J5_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J5_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;
const is_j6_open = <?php if (intval(substr($CIE_OPEN_J6_H1,0,2)) != 0 || intval(substr($CIE_OPEN_J6_H2,0,2)) != 0 || intval(substr($CIE_OPEN_J6_H3,0,2)) != 0 || intval(substr($CIE_OPEN_J6_H4,0,2)) != 0) {echo "true";} else {echo "false";}?>;

        <?php 
            if ($USER_LANG == "FR"){
                echo "const months = [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ];";
            } else {
                echo "const months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
                ];";
            }
        ?>

function renderCalendar(month, year) {
  calendarDates.innerHTML = '';
  monthYear.textContent = `${months[month]} ${year}`;

  // Get the first day of the month
  const firstDay = new Date(year, month, 1).getDay();

  // Get the number of days in the month
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  // Create blanks for days of the week before the first day
  for (let i = 0; i < firstDay; i++) {
    const blank = document.createElement('div');
    calendarDates.appendChild(blank);
  }


  //calculate pickup delay date
  var pk_date = new Date();
  if (CIE_PK_F1 != "0" && CIE_PK_F1 != ""){
    if (CIE_PK_F2 == "hour"){
         pk_date.setHour(pk_date.getHours() + parseInt(CIE_PK_F1));
    } else if (CIE_PK_F2 == "day"){
        pk_date.setDate(pk_date.getDate() + parseInt(CIE_PK_F1));
    } else if (CIE_PK_F2 == "week"){
        pk_date.setDate(pk_date.getDate() + (parseInt(CIE_PK_F1)*7));
    } else if (CIE_PK_F2 == "month"){
        pk_date.setMonth(pk_date.getMonth() + parseInt(CIE_PK_F1));
    }
  }

  // Get today's date
  const today = new Date();

  // Populate the days
  for (let i = 1; i <= daysInMonth; i++) {
    const day = document.createElement('div');
    day.textContent = i;
    var valid_day = true;

    // Disable past dates
    if (i < today.getDate() && year <= today.getFullYear() && month <= today.getMonth() ) {
      day.classList.add('past-date');
      valid_day = false;
    }

    // Disable dates before pickup delay
    if (i < pk_date.getDate() && year <= pk_date.getFullYear() && month <= pk_date.getMonth() ) {
      day.classList.add('past-date');
      valid_day = false;
    }

    if (new Date(year, month, i).getDay() == "0" && is_j0_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "1" && is_j1_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "2" && is_j2_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "3" && is_j3_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "4" && is_j4_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "5" && is_j5_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    } else if (new Date(year, month, i).getDay() == "6" && is_j6_open == false){
        day.classList.add('past-date');
        valid_day = false;   
    }

    // Highlight today's date
    if (i === today.getDate() && year === today.getFullYear() && month === today.getMonth() ) {
      day.classList.add('current-date');
      if (valid_day == true){
        getCAL_HOURS(currentDate.getDate(),currentMonth,currentYear);
      } else {
        document.getElementById('hours-selection').innerHTML = "<br><div class='divBOX' style='max-width:none;'>Aucunes disponibilités cette journée. Veuillez en choisir une autre.</div>";
      }
    }

    if (valid_day == true){
        day.classList.add('valid-day');
    }

    calendarDates.appendChild(day);
  }

}

renderCalendar(currentMonth, currentYear);

prevMonthBtn.addEventListener('click', () => {
  currentMonth--;
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  }
  renderCalendar(currentMonth, currentYear);
});

nextMonthBtn.addEventListener('click', () => {
  currentMonth++;
  if (currentMonth > 11) {
    currentMonth = 0;
    currentYear++;
  }
  renderCalendar(currentMonth, currentYear);
});

calendarDates.addEventListener('click', (e) => {
  if (e.target.textContent !== '' && e.target.classList.contains("valid-day")) {
    //alert(`You clicked on ${e.target.textContent} ${months[currentMonth]} ${currentYear}`);
    getCAL_HOURS(e.target.textContent,currentMonth,currentYear);
  }
});

function updCAL_HOUR(year,month,day,hour,minute){
    pickup_date = year + "/" + month + "/" + day + " " + hour + ":" + minute;
    txt_estimated_date = "<span style='font-weight:normal;'>Ramasser le:</span> " + pickup_date;
    closeCALENDAR();
    addNotif("La date et l'heure de ramassage a été mise à jour.");
    document.getElementById('delivery_estimated_date').innerHTML = txt_estimated_date;
}
function getCAL_HOURS(day,month,year){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById('hours-selection').innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getCAL_HOURS.php?KEY=' + KEY 
                                    + '&D=' + day
                                    + '&M=' + month
                                    + '&Y=' + year,
                                    true);
    xmlhttp.send();
}


function openCALENDAR() {
		document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "0.6";
		document.getElementById("dw3_datetime_pick").style.display = "inline-block";
}
function closeCALENDAR() {
		document.getElementById("divFADE").style.display = "none";
		document.getElementById("divFADE").style.opacity = "0";
		document.getElementById("dw3_datetime_pick").style.display = "none";
}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $CIE_GMAP_KEY; ?>&callback=initMap"></script>
</body>
</html><?php $dw3_conn->close(); ?>