<?php 
if ($CIE_G_ID != ""){
    require_once $_SERVER["DOCUMENT_ROOT"].'/api/google/vendor/autoload.php';
}
if ($CIE_STRIPE_KEY != ""){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
}

if ($CIE_G_ID != "" && $INDEX_DSP_SIGNIN == "true"){
    // init configuration
    $clientID = $CIE_G_ID;
    $clientSecret = $CIE_G_SECRET;
    $redirectUri = "https://".$_SERVER["SERVER_NAME"].'/client';

    // create Client Request to access Google API
    $client = new Google_Client();
    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);
    $client->addScope("email");
    $client->addScope("profile");
}
    // authenticate code from Google OAuth Flow
    if (isset($_GET['code']) && $CIE_G_ID != "") {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;

    // now you can use this profile info to create account in your website and make user logged in.
    $key_expire = date('Y-m-d H:i:s', strtotime( date("Y-m-d H:i:s") . ' + 2 days'));
    $sql = "SELECT *, user.id as USER_ID FROM user LEFT JOIN app ON app.id = user.app_id WHERE LCASE(eml1)= '" . trim(strtolower($email)) . "' OR LCASE(eml2)= '" . trim(strtolower($email)) . "' OR LCASE(eml3)= '" . trim(strtolower($email)). "' LIMIT 1";
    $sql2 = "SELECT * FROM customer WHERE eml1= '" . dw3_crypt(trim(strtoupper($email))) . "' LIMIT 1";
    $KEY = dw3_make_key(128) ;

    //check user first
        $result = $dw3_conn->query($sql);
        if ($result->num_rows == 0) {
            //if not a user maybe a customer
            $result2 = $dw3_conn->query($sql2);
            if ($result2->num_rows == 0) {
                //create a new user
                $sql = "INSERT INTO customer (eml1,key_128,last_name,key_expire,two_factor_valid,lang,date_created) 
                VALUES ('" .  dw3_crypt(trim(strtolower($email))) . "','" .  $KEY . "','".dw3_crypt($name)."', key_expire = '". $key_expire . "', two_factor_valid='1','" . $USER_LANG . "', '" . $datetime . "')";
                if ($dw3_conn->query($sql) === FALSE) {
                        //$err = $dw3_conn->connect_error;
                        //$dw3_conn->close();
                        //die($err."<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='openCONTACT();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide/Help</button>");
                        header("Location: https://".$_SERVER["SERVER_NAME"]);
                        exit();
                } else{
                    $USER = $dw3_conn->insert_id;
                    if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/fs/customer/" . $USER)){
                        mkdir($_SERVER['DOCUMENT_ROOT'] . "/fs/customer/" . $USER);
                    }
                }
                if ($CIE_STRIPE_KEY != ""){
                    $cleanName = substr($name,0,20);
                    $stripe_result = $stripe->customers->create([
                        'description' => 'Customer #' . $USER  . ' ' . $email,   
                        'name' => $cleanName,    
                        'balance' => 0,     
                        'email' => $email
                    ]);
                    //echo $result;
                    $new_stripe_id = $stripe_result->id;
                }else{
                    $new_stripe_id = "";
                }
                //$jresult = json_decode($result, true);
                //$new_stripe_id = $jresult['id'];
                $sql = "UPDATE customer SET    
                date_modified   = '" . $datetime   . "',
                stripe_id   = '" .  $new_stripe_id . "',
                activated = 1
                WHERE id = '" . $USER . "' 
                LIMIT 1";
                if ($dw3_conn->query($sql) === TRUE) {
                    //echo $new_stripe_id;
                } else {
                    //echo $dw3_conn->error;
                }
            } else {
                if ($row2["stat"]!="0"){
                    header("Location: https://".$_SERVER["SERVER_NAME"]);
                }
                $USER = $row2["id"];
                $sql = "UPDATE customer SET key_128= '" .  $KEY . "', key_expire = '". $key_expire . "', two_factor_valid='0'
                WHERE id= '" . $USER . "' LIMIT 1";
                if ($dw3_conn->query($sql) === FALSE) {
                    //$dw3_conn->close();
                    //die("3");
                }
            }
            //key cookie for customer
            $cookie_name = "KEY";
            $cookie_value = $KEY;
            $cookie_domain = $_SERVER["SERVER_NAME"];
            setcookie($cookie_name, $cookie_value, [
                'expires' => time() + 86400,
                'path' => '/',
                'domain' => $cookie_domain,
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None',
            ]);
            header("Location: https://".$_SERVER["SERVER_NAME"]."/client");

        } else { //a user was found	
            while($row = $result->fetch_assoc()) {
                if ($row["stat"]!="0"){
                    header("Location: https://".$_SERVER["SERVER_NAME"]);
                }
                $cookie_name = "KEY";
                $cookie_value = $KEY;
                $cookie_domain =  $_SERVER["SERVER_NAME"];
                setcookie($cookie_name, $cookie_value, [
                    'expires' => time() + 86400,
                    'path' => '/',
                    'domain' => $cookie_domain,
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'None',
                ]);
                $USER = $row["USER_ID"]; 
                $sql = "UPDATE user SET key_128= '" .  $KEY . "', key_expire = '". $key_expire . "'
                WHERE id= '" . $USER . "'  LIMIT 1";
                if ($dw3_conn->query($sql) === FALSE) {
                    $dw3_conn->close();
                    die("3");
                }
                if ( $row["filename"] != "") {
                    header("Location: https://".$_SERVER["SERVER_NAME"]."/app/" . $row["filename"] . "/" . $row["filename"] .".php?KEY=" . $KEY );
                } else {
                    header("Location: https://".$_SERVER["SERVER_NAME"] . "/app/message/message.php?KEY=" . $KEY );
                }
            }
        }

    } else {

    //TEXTE & TRADUCTIONS GENERALES
    $dw3_lbl = array("DW3"=>"Design Web 3D");
    $sql = "SELECT * FROM config WHERE kind = 'LBL'";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $code = strval($row["code"]);
    /*             if ($USER_LANG == "FR"){ $val = strval($row["text1"]); }
                else if($USER_LANG == "EN") { $val = strval($row["text2"]); }
                else if($USER_LANG == "ES") { $val = strval($row["text3"]); }
                else if($USER_LANG == "IT") { $val = strval($row["text4"]); }
                else { $val = strval($row["text1"]); } */
                $val = strval($row["text1"]);
                $dw3_lbl += array($code=>$val);
            }
        }
?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<title>Se connecter - <?php echo $CIE_NOM; ?></title>
    <meta name="robots" content="noindex">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Orelega+One&family=Roboto:wght@100&display=swap" rel="stylesheet">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
    <link rel="icon" type="image/png" href="/favicon.png">

    <style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/main.css.php'; ?>

#message {
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 5px;
  margin: 0px 10px;
  text-align:left;
  line-height:1.15em;
}

#message div {
  padding: 1px 5px;
  font-size: 12px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -5px;
  content: "☑";
  font-size:12px;
}

/* Add a red text color and an "x" icon when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -5px;
  content: "⍚";
  font-size:12px;
}
    </style>
</head>
<body style='text-align:center;'>
<div id="divHEAD" style='left:0px;'>
	<table width="100%"><tr>
        <td style="width:40px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;">
				<a href='/'><button style="margin:0px 0px 0px 2px;padding:8px;">
				<span class="material-icons">arrow_back</span></button></a>
		</td>
        <td width="*"><h3><img id='imgLOGO_TOP' src="/pub/img/<?php echo $CIE_LOGO4."?t=" . rand(100,100000); ?>" style="width:auto;height:32px;"></h3></td>
		<td width="30" onclick='dw3_lang_open();' style="width:40px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;"> 
        <button style="margin:0px 0px 0px 2px;padding:8px;">
				<span id="dw3_lang_span" class="material-icons">translate</span></button>
        </td>
	</tr></table>
</div>

<div id='divDB_LOGIN' class='dw3_msg' style='top: 35%;z-index:700;display:inline-block;min-height:320px;max-width:350px;padding:20px;'>
    <div id='divDB_LOGIN_HEADER' class='dw3_form_head' style='vertical-align:middle;'>		
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Ouverture de session";}else{echo "Login";} ?></div></h3>
		<button class='dw3_form_close' onclick='showLOGIN_HELP(this);'><span class='material-icons'>live_help</span></button>
    </div>
    <div class='dw3_form_data' style='overflow:hidden;'>
        <?php if ($INDEX_DSP_SIGNIN == "true"){ ?>
        <button onclick='signIn();' style='padding:3px 10px;position:absolute;top:2px;right:4px;border-radius:5px;'><span class='material-icons' style='vertical-align:middle;'>history_edu</span> <b><?php if ($USER_LANG == "FR"){echo "S'inscrire";}else{echo "SignIn";} ?></b></button>
        <?php } ?>
        <form style='margin:30px 0px 0px 0px;'>
            <div class='divBOX' style='min-height:135px;margin:10px 0px 0px 0px; padding:0;background:rgba(0,0,0,0);box-shadow:0px 0px 0px;font-size:17px;'>
                <?php if ($USER_LANG == "FR"){echo "Nom d'utilisateur / Courriel";}else{echo "Username / Email";} ?>:
                <table style="margin-bottom:10px;border-radius:10px;border:0px solid white;background:white;width:100%;    white-space:nowrap;border-collapse: collapse;">
                    <tr style='padding:0px;'>
                        <td style='width:40px;text-align:center;' onclick='document.getElementById("txtEML").focus();' style='text-align:center;'><span class='material-icons' style='font-size:24px;'>contact_mail</span></td>
                        <td style='padding:0px;text-align:left;'><input style='width:290px;margin:1px 3px 3px 0px;padding:5px 0px 5px 5px;' type='text' id='txtEML'></td>
                    </tr>
                </table>
                <?php if ($USER_LANG == "FR"){echo "Mot de passe";}else{echo "Password";} ?>:
                <table style="border-radius:10px;border:0px solid white;background:white;width:100%;    white-space:nowrap;border-collapse: collapse;">
                    <tr style='padding:0px;'>
                        <td style='width:40px;text-align:center;' onclick='document.getElementById("txtPW").focus();' style='text-align:center;'><span class='material-icons' style='font-size:24px;'>password</span></td>
                        <td style='padding:0px;text-align:left;'><input style='width:255px;margin:1px 3px 3px 0px;padding:5px 0px 5px 5px;' readonly="readonly" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete='off' type='password' id='txtPW'></td>
                        <td style='width:40px;text-align:center;cursor:pointer;' onclick="showPW();"><span class='material-icons' id='span_pw' style='font-size:24px;'>visibility_off</span></td>
                    </tr>
                </table><div id='btnReset' style='float:right;cursor:pointer;margin:3px;'><span onclick='resetPW();' style='font-size:13px;'><?php if ($USER_LANG == "FR"){echo "Mot de passe oublié";}else{echo "Forgot your password";} ?>?</div>
            </div>
        </form>
        <div id="message" style='font-size:12px;display:block;border-radius:7px;font-family:Roboto;'>
            <div style='display:block;'><b><?php if ($USER_LANG == "FR"){echo "Le mot de passe doit contenir les éléments suivants";}else{echo "The password must contain the following elements";} ?>:</b></div>
            <div id="letter" class="invalid" style='display:inline-block;font-size:16px;vertical-align:middle;'><span style='font-size:11px;vertical-align:middle;'><b><?php if ($USER_LANG == "FR"){echo "Minuscule";}else{echo "Lowercase";} ?></b></span></div> 
            <div id="capital" class="invalid" style='display:inline-block;font-size:16px;vertical-align:middle;'><span style='font-size:11px;vertical-align:middle;'><b><?php if ($USER_LANG == "FR"){echo "Majuscule";}else{echo "Uppercase";} ?></b></div> 
            <div id="number" class="invalid" style='display:inline-block;font-size:16px;vertical-align:middle;'><span style='font-size:11px;vertical-align:middle;'><b><?php if ($USER_LANG == "FR"){echo "Nombre";}else{echo "Number";} ?></b></div> 
            <div id="length" class="invalid" style='display:inline-block;font-size:16px;vertical-align:middle;'><span style='font-size:11px;vertical-align:middle;'><b><?php if ($USER_LANG == "FR"){echo "8 charactères";}else{echo "8 caracters";} ?></b></div> 
        </div>
        <div style='position:absolute;bottom:5px;left:0px;width:100%;text-align:left;line-height:1em;font-size:11px;margin:5px 0px;'><div style='padding:0px 10px;'>
                    <?php if ($USER_LANG == "FR"){echo "En me connectant, j'accepte et signe la";}else{echo "By logging in, I accept and sign the";} ?> <a href='/legal/PRIVACY.html' target='_blank'><u><?php if ($USER_LANG == "FR"){echo "politique de confidentialité </u></a>, les";}else{echo "privacy policy</u></a>, the";} ?> <a href='/legal/LICENSE.html' target='_blank'><u><?php if ($USER_LANG == "FR"){echo "conditions d'utilisation";}else{echo "terms of use";} ?></u></a> <?php if ($USER_LANG == "FR"){ echo "et la ";} else { echo " and the ";}?> <a href='/legal/RETURN.html' target='_blank'><u><?php if ($USER_LANG == "FR"){ echo "politique de transport et de retour";} else {echo "Transport & Return Policy";} ?></u></a>.
<!--             <div style='float:right;padding:10px 5px 0px 5px;vertical-align:middle;'>
                <input id='inLICENSE' type='checkbox' style='margin-top:5px;' checked>
            </div> -->
        </div></div>
    </div>
    <div class='dw3_form_foot' style='padding:0px;height:37px;'>
        <button id='btnLOGIN' class='<?php echo $LOGIN_BTN_CLASS; ?>' onclick='logIn();' style='border:0px;width:100%;margin:0px;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:15px;border-bottom-right-radius:15px;'>
            <span class='material-icons' style='vertical-align:middle;'>login</span> 
            <b><?php if ($USER_LANG == "FR"){echo "Se connecter";}else{echo "Login";} ?></b>
        </button>
    </div>
    <?php if ($CIE_G_ID != "" && $INDEX_DSP_SIGNIN == "true"){ ?><div style='position:absolute;bottom:-60px;left:85px;'><a href="<?php echo $client->createAuthUrl(); ?>"><img style='width:200px;height:auto;' src='/pub/img/dw3/<?php echo $CIE_G_IMG; ?>'></a></div><?php } ?>
</div>

<div id='divDB_SIGNIN' class='dw3_msg' style='top: 35%;display:none;z-index:700;min-height:320px;max-width:350px;padding:20px;'>
    <div id='divDB_SIGNIN_HEADER' class='dw3_form_head' style='vertical-align:middle;'>		
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Ouverture de compte";}else{echo "SignIn";} ?></div></h3>
		<button class='dw3_form_close' onclick='showSIGNIN_HELP(this);'><span class='material-icons'>live_help</span></button>
    </div>
    <div class='dw3_form_data'>
        <button onclick='toLogIn();' style='padding:3px 10px;position:absolute;top:2px;right:4px;border-radius:5px;'><span class='material-icons' style='vertical-align:middle;'>login</span> <b><?php if ($USER_LANG == "FR"){echo "Se connecter";}else{echo "LogIn";} ?></b></button>
        <form  style='margin:20px 0px 0px 0px;'>
            <div class='divBOX' style='min-height:150px;margin:10px 0px 0px 0px; padding:0;background:rgba(0,0,0,0);box-shadow:0px 0px 0px;font-size:17px;'>
                <?php if ($USER_LANG == "FR"){echo "Courriel";}else{echo "Email";} ?>:
                <table style="margin-bottom:10px;border-radius:10px;border:0px solid white;background:white;width:100%;    white-space:nowrap;border-collapse: collapse;">
                    <tr style='padding:0px;'>
                        <td style='width:40px;text-align:center;' onclick='document.getElementById("txtEML2").focus();' style='text-align:center;'><span class='material-icons' style='font-size:24px;'>contact_mail</span></td>
                        <td style='padding:0px;text-align:left;'><input style='width:290px;margin:1px 3px 3px 0px;padding:5px 0px 5px 5px;' type='text' id='txtEML2'></td>
                    </tr>
                </table>
                <?php if ($USER_LANG == "FR"){echo "Mot de passe";}else{echo "Password";} ?>:
                <table style="border-radius:10px;border:0px solid white;background:white;width:100%;    white-space:nowrap;border-collapse: collapse;">
                    <tr style='padding:0px;'>
                        <td style='width:40px;text-align:center;' onclick='document.getElementById("txtPW2").focus();' style='text-align:center;'><span class='material-icons' style='font-size:24px;'>password</span></td>
                        <td style='padding:0px;text-align:left;'><input style='width:255px;margin:1px 3px 3px 0px;padding:5px 0px 5px 5px;' readonly="readonly" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete='off' type='password' id='txtPW2'></td>
                        <td style='width:40px;text-align:center;cursor:pointer;' onclick="showPW2();"><span class='material-icons' id='span_pw2' style='font-size:24px;'>visibility_off</span></td>
                    </tr>
                </table>
                <table style="border-radius:10px;border:0px solid white;background:white;width:100%;    white-space:nowrap;border-collapse: collapse;">
                    <tr style='padding:0px;'>
                        <td style='width:40px;text-align:center;' onclick='document.getElementById("txtPW3").focus();' style='text-align:center;'><span class='material-icons' style='font-size:24px;'>password</span></td>
                        <td style='padding:0px;text-align:left;'><input style='width:255px;margin:1px 3px 3px 0px;padding:5px 0px 5px 5px;' readonly="readonly" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete='off' type='password' id='txtPW3'></td>
                        <td style='width:40px;text-align:center;cursor:pointer;' onclick="showPW3();"><span class='material-icons' id='span_pw3' style='font-size:24px;'>visibility_off</span></td>
                    </tr>
                </table>
            </div>
        </form>
        <div id="message" style='font-size:11px;display:block;border-radius:7px;margin:12px;font-family:Roboto;'>
            <div style='display:block;'><b><?php if ($USER_LANG == "FR"){echo "Le mot de passe doit contenir les éléments suivants";}else{echo "The password must contain the following elements";} ?>:</b></div>
            <div id="letter2" class="invalid" style='display:inline-block;font-size:16px;vertical-align:middle;'><span style='font-size:11px;vertical-align:middle;'><b><?php if ($USER_LANG == "FR"){echo "Minuscule";}else{echo "Lowercase";} ?></b></span></div> 
            <div id="capital2" class="invalid" style='display:inline-block;font-size:16px;vertical-align:middle;'><span style='font-size:11px;vertical-align:middle;'><b><?php if ($USER_LANG == "FR"){echo "Majuscule";}else{echo "Uppercase";} ?></b></div> 
            <div id="number2" class="invalid" style='display:inline-block;font-size:16px;vertical-align:middle;'><span style='font-size:11px;vertical-align:middle;'><b><?php if ($USER_LANG == "FR"){echo "Nombre";}else{echo "Number";} ?></b></div> 
            <div id="length2" class="invalid" style='display:inline-block;font-size:16px;vertical-align:middle;'><span style='font-size:11px;vertical-align:middle;'><b><?php if ($USER_LANG == "FR"){echo "8 charactères";}else{echo "8 caracters";} ?></b></div> 
        </div>
        <div style='position:absolute;bottom:5px;left:0px;width:100%;text-align:center;line-height:1em;font-size:11px;margin:5px 0px;'>
                    <?php if ($USER_LANG == "FR"){echo "En m'inscrivant, j'accepte la";}else{echo "By siging in, I accept the";} ?> <a href='/legal/PRIVACY.html' target='_blank'><u><?php if ($USER_LANG == "FR"){echo "politique de confidentialité </u></a> et les";}else{echo "privacy policy</u></a> and the";} ?> <a href='/legal/LICENSE.html' target='_blank'><u><?php if ($USER_LANG == "FR"){echo "conditions d'utilisation";}else{echo "terms of use";} ?></u></a>.
<!--             <div style='float:right;padding:10px 5px 0px 5px;vertical-align:middle;'>
                <input id='inLICENSE' type='checkbox' style='margin-top:5px;' checked>
            </div> -->
        </div>
    </div>
    <div class='dw3_form_foot' style='padding:0px;height:37px;'>
        <button id='btnSIGNIN' class='green' onclick='signIn2();' style='width:100%;margin:0px;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-right-radius:15px;border-bottom-left-radius:15px;'>
            <span class='material-icons' style='vertical-align:middle;'>history_edu</span>
            <b><?php if ($USER_LANG == "FR"){echo "S'inscrire";}else{echo "Register";} ?></b>
        </button>
    </div>
    <?php if ($CIE_G_ID != "" && $INDEX_DSP_SIGNIN == "true"){ ?><div style='position:absolute;bottom:-60px;left:85px;'><a href="<?php echo $client->createAuthUrl(); ?>"><img style='width:200px;height:auto;' src='/pub/img/dw3/<?php echo $CIE_G_IMG; ?>'></a></div><?php } ?>
</div>


</div>
<div id='divFADE'></div>
<div id="divMSG"></div>


<script>
var KEY = '<?php echo $KEY; ?>';
var LANG = '<?php if(isset($_COOKIE["LANG"])) { echo $_COOKIE["LANG"]; } else if ($USER_LANG != "") { echo $USER_LANG; } else { echo 'FR';} ?>';
var USER_TYPE = '<?php //echo $USER_TYPE; ?>';
var USER_NAME = '<?php //echo $USER_NAME; ?>';

var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");
var button_before_color = document.getElementById("btnSIGNIN").style.color;

$(document).ready(function ()
    {
        //document.getElementById("btnSIGNIN").disabled = true;
        //document.getElementById("btnSIGNIN").style.color = "red";
        //document.getElementById("btnLOGIN").disabled = true;
        //document.getElementById("btnLOGIN").style.color = "red";
        //checkPW();
        dragElement(document.getElementById('divDB_LOGIN'));
        document.getElementById("txtEML").setAttribute( "autocomplete", "off" ); 
        document.getElementById("txtPW").setAttribute( "autocomplete", "off" ); 
        document.getElementById("txtPW2").setAttribute( "autocomplete", "off" ); 
        document.getElementById("txtPW3").setAttribute( "autocomplete", "off" ); 
        document.getElementById("txtEML").value ="";
        document.getElementById("txtPW").value ="";
        document.getElementById("txtPW2").value ="";
        document.getElementById("txtPW3").value ="";
        document.getElementById("txtEML").placeholder = "";
       document.getElementById("txtPW").placeholder = "";
       document.getElementById("txtPW2").placeholder = "";
       document.getElementById("txtPW3").placeholder = "";
       document.getElementById("txtPW").removeAttribute('readonly');
       document.getElementById("txtPW2").removeAttribute('readonly');
       document.getElementById("txtPW3").removeAttribute('readonly');
       document.getElementById("txtEML").focus();
});



var dw3_login_listen1 = document.getElementById("txtEML");
dw3_login_listen1.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	logIn();
  }
});
var dw3_login_listen2 = document.getElementById("txtPW");
dw3_login_listen2.addEventListener("input", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	logIn();
  } else {
    checkPW();
  }
});
dw3_login_listen2.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	logIn();
  } else {
    checkPW();
  }
});
var dw3_login_listen3 = document.getElementById("txtEML2");
dw3_login_listen3.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	signIn2();
  }
});
var dw3_login_listen4 = document.getElementById("txtPW2");
dw3_login_listen4.addEventListener("input", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	signIn2();
  } else {
    checkPW2();
  }
});
dw3_login_listen4.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	signIn2();
  } else {
    checkPW2();
  }
});
var dw3_login_listen5 = document.getElementById("txtPW3");
dw3_login_listen5.addEventListener("input", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	signIn2();
  } else {
    checkPW2();
  }
});
dw3_login_listen5.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	signIn2();
  } else {
    checkPW2();
  }
});

function checkPW() {
    var bVALID = true;
    var lowerCaseLetters = /[a-z]/g;
    if(dw3_login_listen2.value.match(lowerCaseLetters)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
        bVALID = false;
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(dw3_login_listen2.value.match(upperCaseLetters)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
        bVALID = false;
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(dw3_login_listen2.value.match(numbers)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
    } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
        bVALID = false;
    }

    // Validate length
    if(dw3_login_listen2.value.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
    } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
        bVALID = false;
    }

    // Validate confirmation
    //if(dw3_login_listen1.value == dw3_login_listen2.value) {
        //length.classList.remove("invalid");
        //length.classList.add("valid");
    //} else {
        //length.classList.remove("valid");
        //length.classList.add("invalid");
        //bVALID = false;
    //}

    //if (bVALID == true){
        //document.getElementById("btnSIGNIN").disabled = false;
        //document.getElementById("btnSIGNIN").style.color = button_before_color;
        //document.getElementById("btnLOGIN").disabled = false;
        //document.getElementById("btnLOGIN").style.color = button_before_color;
    //} else {
        //document.getElementById("btnSIGNIN").disabled = true;
        //document.getElementById("btnSIGNIN").style.color = "darkred";
        //document.getElementById("btnLOGIN").disabled = true;
        //document.getElementById("btnLOGIN").style.color = "darkred";
    //}
}
function checkPW2() {
    var bVALID = true;
    var lowerCaseLetters = /[a-z]/g;
    if(dw3_login_listen4.value.match(lowerCaseLetters)) {
        letter2.classList.remove("invalid");
        letter2.classList.add("valid");
    } else {
        letter2.classList.remove("valid");
        letter2.classList.add("invalid");
        bVALID = false;
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(dw3_login_listen4.value.match(upperCaseLetters)) {
        capital2.classList.remove("invalid");
        capital2.classList.add("valid");
    } else {
        capital2.classList.remove("valid");
        capital2.classList.add("invalid");
        bVALID = false;
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(dw3_login_listen4.value.match(numbers)) {
        number2.classList.remove("invalid");
        number2.classList.add("valid");
    } else {
        number2.classList.remove("valid");
        number2.classList.add("invalid");
        bVALID = false;
    }

    // Validate length
    if(dw3_login_listen4.value.length >= 8) {
        length2.classList.remove("invalid");
        length2.classList.add("valid");
    } else {
        length2.classList.remove("valid");
        length2.classList.add("invalid");
        bVALID = false;
    }

    // Validate confirmation
    //if(dw3_login_listen1.value == dw3_login_listen2.value) {
        //length.classList.remove("invalid");
        //length.classList.add("valid");
    //} else {
        //length.classList.remove("valid");
        //length.classList.add("invalid");
        //bVALID = false;
    //}

    //if (bVALID == true){
        //document.getElementById("btnSIGNIN").disabled = false;
        //document.getElementById("btnSIGNIN").style.color = button_before_color;
        //document.getElementById("btnLOGIN").disabled = false;
        //document.getElementById("btnLOGIN").style.color = button_before_color;
    //} else {
        //document.getElementById("btnSIGNIN").disabled = true;
        //document.getElementById("btnSIGNIN").style.color = "darkred";
        //document.getElementById("btnLOGIN").disabled = true;
        //document.getElementById("btnLOGIN").style.color = "darkred";
    //}
}
function showLOGIN_HELP() {
    //document.getElementById("divFADE").innerHTML = "<img style='width:100px;height:auto;' src='/pub/img/load.gif'>";
    document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divFADE").style.opacity = "0.7";
    document.getElementById("divMSG").style.display = "inline-block";
    //document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:0.8em;'>Pour vous inscrire ou vous connecter entrez votre adresse courriel et un mot de passe</div><br><button>Générer un mot de passe sécuritaire</button><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><hr><button onclick='closeMSG()'>Terminé</button>";
    if (LANG == "FR"){
        document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Pour vous connecter entrez votre adresse courriel et votre mot de passe</div><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><button class='dw3_form_close' onclick='closeMSG()'><span class='material-icons'>close</span></button>";
    } else {
        document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>To log in, enter your email address and your password</div><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><button class='dw3_form_close' onclick='closeMSG()'><span class='material-icons'>close</span></button>";
    }
}
function showSIGNIN_HELP() {
    //document.getElementById("divFADE").innerHTML = "<img style='width:100px;height:auto;' src='/pub/img/load.gif'>";
    document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divFADE").style.opacity = "0.7";
    document.getElementById("divMSG").style.display = "inline-block";
    //document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:0.8em;'>Pour vous inscrire ou vous connecter entrez votre adresse courriel et un mot de passe</div><br><button>Générer un mot de passe sécuritaire</button><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><hr><button onclick='closeMSG()'>Terminé</button>";
    if (LANG == "FR"){
        document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Pour vous inscrire entrez votre adresse courriel et un mot de passe</div><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><button class='dw3_form_close' onclick='closeMSG()'><span class='material-icons'>close</span></button>";
    } else {
        document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>To register enter your email address and a password</div><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><button class='dw3_form_close' onclick='closeMSG()'><span class='material-icons'>close</span></button>";
    }
}

function dw3_lang_open() {
    document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divFADE").style.opacity = "0.7";
    document.getElementById("divMSG").style.display = "inline-block";
    if (LANG == "FR"){
        document.getElementById("divMSG").innerHTML = "Veuillez choisir votre langue:<br><button onclick='dw3_lang_set(\"FR\");'><img src=\"https://dataia.ca/img/flags/84.png\"' style='height:32px;width:auto;'> Français</button> <button onclick='dw3_lang_set(\"EN\");'><img src=\"https://dataia.ca/img/flags/86.png\"' style='height:32px;width:auto;'> English</button>";
    }else{
        document.getElementById("divMSG").innerHTML = "Please choose your language:<br><button onclick='dw3_lang_set(\"FR\");'><img src=\"https://dataia.ca/img/flags/84.png\"' style='height:32px;width:auto;'> Français</button> <button onclick='dw3_lang_set(\"EN\");'><img src=\"https://dataia.ca/img/flags/86.png\"' style='height:32px;width:auto;'> English</button>";
    }
}


function dw3_lang_set(language) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('GET', '/pub/page/set_lang.php?LANG=' + language , true);
	xmlhttp.send();
    var myDate = new Date();
    myDate.setMonth(myDate.getMonth() + 12);
    document.cookie = "LANG="+language+";expires=" + myDate +";path=/;domain=.<?php echo $_SERVER['SERVER_NAME']; ?>;";
    closeMSG();
    if (document.getElementById('dw3_lang_span')) {
        document.getElementById('dw3_lang_span').innerHTML = "<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>' style='border-radius:5px;width:24px;height:24px;margin-top:-6px;'>";
    }
    setTimeout(() => {
        location.reload();
        return false;
    }, "1500");

}

function changeAVATAR(avatarId){
    if (avatarId == ""){avatarId=" ";}
	var svgCode = multiavatar(avatarId);
	document.getElementById("imgAVATAR").innerHTML=svgCode;
}
function closeMSG() {
	document.getElementById('divFADE').style.display = 'none';
	document.getElementById('divMSG').style.display = 'none';

}
function setLANG() {
	document.getElementById('divFADE').style.display = 'none';
	document.getElementById('divMSG').style.display = 'none';

}

function logIn() {
	var sPW  	= document.getElementById("txtPW").value;
	var sEML  	= document.getElementById("txtEML").value;
    if (sEML.trim() == ""){
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divFADE").style.opacity = "0.7";
        document.getElementById("divMSG").style.display = "inline-block";
        //document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:0.8em;'>Pour vous inscrire ou vous connecter entrez votre adresse courriel et un mot de passe</div><br><button>Générer un mot de passe sécuritaire</button><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><hr><button onclick='closeMSG()'>Terminé</button>";
        if (LANG == "FR"){
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Veuillez saisir votre adresse courriel pour vous connecter.</div><br><br><button onclick='document.getElementById(\"txtPW\").focus(); document.getElementById(\"txtPW\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        } else {
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Please enter your email to login.</div><br><br><button onclick='document.getElementById(\"txtPW\").focus(); document.getElementById(\"txtPW\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        }
        return;
    } else {
        document.getElementById("txtEML").style.boxShadow = "5px 10px 15px #000;";
    }
    if (sPW.trim() == ""){
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divFADE").style.opacity = "0.7";
        document.getElementById("divMSG").style.display = "inline-block";
        //document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:0.8em;'>Pour vous inscrire ou vous connecter entrez votre adresse courriel et un mot de passe</div><br><button>Générer un mot de passe sécuritaire</button><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><hr><button onclick='closeMSG()'>Terminé</button>";
        if (LANG == "FR"){
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Veuillez entrer votre mot de passe pour continuer.</div><br><br><button onclick='document.getElementById(\"txtPW\").focus(); document.getElementById(\"txtPW\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        } else {
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Please enter your password to continue.</div><br><br><button onclick='document.getElementById(\"txtPW\").focus(); document.getElementById(\"txtPW\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        }
        return;
    } else {
        document.getElementById("txtPW").style.boxShadow = "5px 10px 15px #000;";
    }

    var bVALID = true;
    // Validate that there is at least one lower case character
    var lowerCaseLetters = /[a-z]/g;
    if(dw3_login_listen2.value.match(lowerCaseLetters)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
        bVALID = false;
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(dw3_login_listen2.value.match(upperCaseLetters)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
        bVALID = false;
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(dw3_login_listen2.value.match(numbers)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
    } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
        bVALID = false;
    }

    // Validate length
    if(dw3_login_listen2.value.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
    } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
        bVALID = false;
    }
    
    if (bVALID == false){
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divFADE").style.opacity = "0.7";
        document.getElementById("divMSG").style.display = "inline-block";
        //document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:0.8em;'>Pour vous inscrire ou vous connecter entrez votre adresse courriel et un mot de passe</div><br><button>Générer un mot de passe sécuritaire</button><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><hr><button onclick='closeMSG()'>Terminé</button>";
        if (LANG == "FR"){
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Le mot de passe doit contenir 8 caractères dont minimum une minuscule, une majuscule et un nombre entre 0 et 9.</div><br><br><button onclick='document.getElementById(\"txtPW\").focus(); document.getElementById(\"txtPW\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        } else {
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>The password must contain 8 characters including a minimum of one lowercase letter, one uppercase letter and a number between 0 and 9.</div><br><br><button onclick='document.getElementById(\"txtPW\").focus(); document.getElementById(\"txtPW\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        }
        return;
    } else {
        document.getElementById("btnLOGIN").disabled = true;
        document.getElementById("divFADE").innerHTML = "<img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divFADE").style.opacity = "0.6";

        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText.trim()=="00"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    if (LANG=="FR"){
                        document.getElementById("divMSG").innerHTML = "<b>La connexion a échoué.</b><br>L’identifiant ou le mot de passe que vous avez entré n’est pas valide.<br>Veuillez Réessayer.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
                    }else{
                        document.getElementById("divMSG").innerHTML = "<b>The connection failed.</b><br>The username or password you entered is invalid.<br>Please try Again.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Help</button>";
                    }
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="01"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    if (LANG=="FR"){
                        document.getElementById("divMSG").innerHTML = "<b>La connexion a échoué.</b><br>L’identifiant ou le mot de passe que vous avez entré n’est pas valide. <br><span style='font-size:11px;'>4 tentatives restantes.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
                    }else {
                        document.getElementById("divMSG").innerHTML = "<b>The connection failed.</b><br>The username or password you entered is invalid. <br><span style='font-size:11px;'>4 attempts remaining.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Help</button>";
                    }
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="02"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    if (LANG=="FR"){
                        document.getElementById("divMSG").innerHTML = "<b>La connexion a échoué.</b><br>L’identifiant ou le mot de passe que vous avez entré n’est pas valide. <br><span style='font-size:11px;'>3 tentatives restantes.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
                    }else {
                        document.getElementById("divMSG").innerHTML = "<b>The connection failed.</b><br>The username or password you entered is invalid. <br><span style='font-size:11px;'>3 attempts remaining.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Help</button>";
                    }
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="03"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    if (LANG=="FR"){
                        document.getElementById("divMSG").innerHTML = "La connexion a échoué.<br>L’identifiant ou le mot de passe que vous avez entré n’est pas valide. <br><span style='font-size:11px;'>2 tentatives restantes.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
                    }else {
                        document.getElementById("divMSG").innerHTML = "The connection failed.<br>The username or password you entered is invalid. <br><span style='font-size:11px;'>2 attempts remaining.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Help</button>";
                    }
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="04"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    if (LANG=="FR"){
                        document.getElementById("divMSG").innerHTML = "La connexion a échoué. L’identifiant ou le mot de passe que vous avez entré n’est pas valide. <br><span style='font-size:11px;'>1 tentatives restantes.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
                    }else {
                        document.getElementById("divMSG").innerHTML = "The connection failed. The username or password you entered is invalid. <br><span style='font-size:11px;'>1 attempts remaining.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Help</button>";
                    }
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="05"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    if (LANG=="FR"){
                        document.getElementById("divMSG").innerHTML = "La connexion a échoué. L’identifiant ou le mot de passe que vous avez entré n’est pas valide. <br><span style='font-size:11px;'>0 tentatives restantes.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
                    }else {
                        document.getElementById("divMSG").innerHTML = "The connection failed. The username or password you entered is invalid. <br><span style='font-size:11px;'>0 attempts remaining.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Help</button>";
                    }
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="06"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    if (LANG=="FR"){
                        document.getElementById("divMSG").innerHTML = "La connexion a échoué. L’identifiant ou le mot de passe que vous avez entré n’est pas valide. <br><span style='font-size:11px;'>0 tentatives restantes.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
                    }else {
                        document.getElementById("divMSG").innerHTML = "The connection failed. The username or password you entered is invalid. <br><span style='font-size:11px;'>0 attempts remaining.</span><br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Help</button>";
                    }
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="1"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    document.getElementById("divMSG").innerHTML = "ERR1: System Error.";
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="2"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    if (LANG=="FR"){
                        document.getElementById("divMSG").innerHTML = "La connexion a expiré ou l’identifiant et le mot de passe que vous avez entrés ne sont pas valides. Veuillez Réessayer.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
                    }else{
                        document.getElementById("divMSG").innerHTML = "The connection has expired or the username and password you entered are invalid. Try Again.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Help</button>";
                    }                        
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="2.1"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    if (LANG=="FR"){
                        document.getElementById("divMSG").innerHTML = "Votre compte n'a pas encore été activé. Veuillez vérifier votre boîte de réception ou cliquez sur 'Mot de passe oublié?' pour proceder à l'activation.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
                    }else{
                        document.getElementById("divMSG").innerHTML = "Your account has not yet been activated. Please check your inbox or click on 'Forgot your password?' to proceed with activation.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Help</button>";
                    }
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="3"){
                    document.getElementById("divFADE").innerHTML = "";
                    document.getElementById("divMSG").style.display = "inline-block";
                    document.getElementById("divMSG").innerHTML = "ERR3:Erreur système.";
                    document.getElementById("btnLOGIN").disabled = false;
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                } else if (this.responseText.trim()=="4"){
                    document.getElementById("txtPW").value = "";
                    document.getElementById("txtEML").value = "";
                    if (LANG=="FR"){
                        addMsg("Trop de tentatives échoués aujourd'hui.<br>Veuillez contacter l'administrateur pour débloquer votre adresse ip.<br><br><button style='background:#444;color:#EEE;' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>close</span>Ok</button>");
                    }else{
                        addMsg("Too many failed attempts today.<br>Please contact administrator to unblock your IP address.<br><br><button style='background:#444;color:#EEE;' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>close</span>Ok</button>");
                    }                        

                } else {
                document.getElementById("divFADE").innerHTML = "";
                document.getElementById("divFADE").style.display = "none";
                //document.getElementById("divLOGIN").style.display = "none";
                document.getElementById("btnLOGIN").disabled = false;
                window.open(this.responseText.trim(),"_self");
                }
            }
            };
            xmlhttp.open('GET', '/sbin/login.php?USER=' + encodeURIComponent(sEML) + "&PW=" + encodeURIComponent(sPW), true);
            xmlhttp.send();
    }
}

function toLogIn() {
    document.getElementById("divDB_LOGIN").style.display = "inline-block";
    document.getElementById("divDB_SIGNIN").style.display = "none";
    document.getElementById('txtEML').focus();
}
function signIn() {
    document.getElementById("divDB_LOGIN").style.display = "none";
    document.getElementById("divDB_SIGNIN").style.display = "inline-block";
    document.getElementById('txtEML2').focus();
    document.getElementById('txtEML2').value = document.getElementById('txtEML').value;
}
function signIn2() {
	var sPW  	= document.getElementById("txtPW2").value;
	var sEML  	= document.getElementById("txtEML2").value;
	
    if (sEML.trim() == ""){
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divFADE").style.opacity = "0.7";
        document.getElementById("divMSG").style.display = "inline-block";
        if (LANG == "FR"){
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Veuillez saisir votre adresse courriel pour vous inscrire.</div><br><br><button onclick='document.getElementById(\"txtEML2\").focus(); document.getElementById(\"txtEML2\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        } else {
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Please enter your email to signin.</div><br><br><button onclick='document.getElementById(\"txtEML2\").focus(); document.getElementById(\"txtEML2\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        }
        return;
    } else {
        document.getElementById("txtEML").style.boxShadow = " 0px 5px 5px rgba(0, 0, 0, 0.35)";
    }
    if (sPW.trim() == ""){
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divFADE").style.opacity = "0.7";
        document.getElementById("divMSG").style.display = "inline-block";
        if (LANG == "FR"){
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Veuillez entrer votre nouveau mot de passe pour continuer.</div><br><br><button onclick='document.getElementById(\"txtPW2\").focus(); document.getElementById(\"txtPW2\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        } else {
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Please enter your new password to continue.</div><br><br><button onclick='document.getElementById(\"txtPW2\").focus(); document.getElementById(\"txtPW2\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        }
        return;
    } else {
        document.getElementById("txtPW").style.boxShadow = " 0px 5px 5px rgba(0, 0, 0, 0.35)";
    }

    var bVALID = true;
    // Validate that there is at least one lower case character
    var lowerCaseLetters = /[a-z]/g;
    if(dw3_login_listen4.value.match(lowerCaseLetters)) {
        letter2.classList.remove("invalid");
        letter2.classList.add("valid");
    } else {
        letter2.classList.remove("valid");
        letter2.classList.add("invalid");
        bVALID = false;
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(dw3_login_listen4.value.match(upperCaseLetters)) {
        capital2.classList.remove("invalid");
        capital2.classList.add("valid");
    } else {
        capital2.classList.remove("valid");
        capital2.classList.add("invalid");
        bVALID = false;
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(dw3_login_listen4.value.match(numbers)) {
        number2.classList.remove("invalid");
        number2.classList.add("valid");
    } else {
        number2.classList.remove("valid");
        number2.classList.add("invalid");
        bVALID = false;
    }

    // Validate length
    if(dw3_login_listen4.value.length >= 8) {
        length2.classList.remove("invalid");
        length2.classList.add("valid");
    } else {
        length2.classList.remove("valid");
        length2.classList.add("invalid");
        bVALID = false;
    }

    if (dw3_login_listen4.value != dw3_login_listen5.value){
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divFADE").style.opacity = "0.7";
        document.getElementById("divMSG").style.display = "inline-block";
        //document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:0.8em;'>Pour vous inscrire ou vous connecter entrez votre adresse courriel et un mot de passe</div><br><button>Générer un mot de passe sécuritaire</button><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><hr><button onclick='closeMSG()'>Terminé</button>";
        if (LANG == "FR"){
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Les mots de passe doivent correspondre dans les deux cases</div><br><br><button onclick='document.getElementById(\"txtPW3\").focus(); document.getElementById(\"txtPW3\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        } else {
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>The password must correspond in the two boxes.</div><br><br><button onclick='document.getElementById(\"txtPW3\").focus(); document.getElementById(\"txtPW3\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        }
        return;
    }
    if (bVALID == false){
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divFADE").style.opacity = "0.7";
        document.getElementById("divMSG").style.display = "inline-block";
        //document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:0.8em;'>Pour vous inscrire ou vous connecter entrez votre adresse courriel et un mot de passe</div><br><button>Générer un mot de passe sécuritaire</button><br><b style='font-size:15px;'>Demander de l'aide:</b><br><a href='tel:<?php echo $CIE_TEL1; ?>'><button onclick='dw3_tel1()' style='padding:15px;width:auto;'><span class='material-icons'>phone</span> Nous téléphoner</button></a> <a href='mailto:<?php echo $CIE_EML1; ?>'><button style='padding:15px;'><span class='material-icons'>mail</span> Nous écrire</button></a><hr><button onclick='closeMSG()'>Terminé</button>";
        if (LANG == "FR"){
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>Le mot de passe doit contenir 8 caractères dont minimum une minuscule, une majuscule et un nombre entre 0 et 9.</div><br><br><button onclick='document.getElementById(\"txtPW\").focus(); document.getElementById(\"txtPW\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        } else {
            document.getElementById("divMSG").innerHTML = "<div style='margin-top:-10px;font-size:1.1em;'>The password must contain 8 characters including a minimum of one lowercase letter, one uppercase letter and a number between 0 and 9.</div><br><br><button onclick='document.getElementById(\"txtPW\").focus(); document.getElementById(\"txtPW\").style.boxShadow = \"5px 10px 15px red\";closeMSG();' style='padding:15px;width:auto;'><span class='material-icons'>done</span> OK </button>";
        }
        return;
    } else {

	document.getElementById("btnSIGNIN").disabled = true;
    document.getElementById("divMSG").style.display = "inline-block";
    if (LANG=="FR"){
	    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }else{
	    document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";

  	var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
				document.getElementById("divFADE").innerHTML = "";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText;
				document.getElementById("btnSIGNIN").disabled = false;
		  }
		};
		xmlhttp.open('GET', '/sbin/signin.php?USER=' + encodeURIComponent(sEML) + "&PW=" + encodeURIComponent(sPW) + "&LANG=" + LANG, true);
		xmlhttp.send();
    }
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
function addMsg(text) { //rename to dw3_alert(text);
	document.getElementById("divFADE").style.opacity = "0.6";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = text ;
}

function showPW() {  //rename to dw3_pw_show(event,that);
  	var that = document.getElementById("txtPW");
  	var thut = document.getElementById("span_pw");
	  if (that.type === "password") {
        that.type ="text";
        thut.innerHTML ="visibility";
	  } else {
		that.type = "password";
        thut.innerHTML ="visibility_off";
	  }
}
function showPW2() {  //rename to dw3_pw_show(event,that);
  	var that = document.getElementById("txtPW2");
  	var thut = document.getElementById("span_pw2");
	  if (that.type === "password") {
        that.type ="text";
        thut.innerHTML ="visibility";
	  } else {
		that.type = "password";
        thut.innerHTML ="visibility_off";
	  }
}
function showPW3() {  //rename to dw3_pw_show(event,that);
  	var that = document.getElementById("txtPW3");
  	var thut = document.getElementById("span_pw3");
	  if (that.type === "password") {
        that.type ="text";
        thut.innerHTML ="visibility";
	  } else {
		that.type = "password";
        thut.innerHTML ="visibility_off";
	  }
}
function showPW_old(event,that) {  //rename to dw3_pw_show(event,that);
  	var x = event.offsetX;
	if (x > (that.offsetWidth-25)){
	  that.classList.toggle("eye_off");
	  if (that.type === "password") {
        that.type ="text";
        //addMsg("Choisissez une methode d'authentification<br><br><button onclick='authBySMS();'>Message texte</button><button onclick='authByEmail();'>Courriel</button><hr>Entrez le code reçu:<br><form><input style='width:120px;' type='password' id='authViewPw'></form><br><button style='background-color:#444;' onclick='closeMSG();'>Annuler</button><button onclick='document.getElementById(\""+that.id+"\").type =\"text\";closeMSG();'>Valider</button>");
	  } else {
		that.type = "password";
	  }
	}
}

function resetPW() {
	var sEML = document.getElementById("txtEML").value;
    if (sEML.indexOf("@") == -1){
        document.getElementById("divFADE").style.opacity = "0.6";
	    document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        if (LANG=="FR"){
		    document.getElementById("divMSG").innerHTML = "Veuillez entrer votre adresse courriel pour réinitialiser le mot de passe.<br><br><button onclick='closeMSG();document.getElementById(\"txtEML\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide</button>";
        }else{
		    document.getElementById("divMSG").innerHTML = "Please enter your email address to reset the password.<br><br><button onclick='closeMSG();document.getElementById(\"txtEML\").focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='fncAide();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Help</button>";
        }
        document.getElementById("txtEML").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtEML").focus();
        return;
    }
    document.getElementById("txtEML").style.boxShadow = "5px 10px 15px grey";
    //document.getElementById("divFADE").innerHTML = "<img style='width:100px;height:auto;' src='/pub/img/load.gif'>";
    document.getElementById("divFADE").style.verticalAlign = "middle";
    document.getElementById("divFADE").style.opacity = "0.6";
	document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
    if (LANG=="FR"){
	    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    } else{
	    document.getElementById("divMSG").innerHTML = "Please wait..<br><img style='width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD."?t=" . rand(100,100000); ?>'>";
    }

		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != ""){
                document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                //document.getElementById("btnReset").innerHTML="Verifiez votre boite courriel.";
            } else {
                document.getElementById("divMSG").style.display = "inline-block";
                if (LANG=="FR"){
				    document.getElementById("divMSG").innerHTML = "Si vous avez un compte avec nous, un courriel pour réinitialiser le mot de passe vous sera envoyé.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                    document.getElementById("btnReset").innerHTML="<div style='font-size:14px;color:green;'>Vérifiez votre boite courriel.</div>";
                }else{
				    document.getElementById("divMSG").innerHTML = " If you have an account with us, an email to reset the password will be sent to you.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                    document.getElementById("btnReset").innerHTML="<div style='font-size:14px;color:green;'>Check your email box.</div>";
                }
                document.getElementById("btnReset").style.cursor="default";
            }
		  };
        }
        xmlhttp.open('GET', '/sbin/resetPW.php?EML=' + encodeURIComponent(sEML), true);
		xmlhttp.send();
}
</script>
<?php } $dw3_conn->close(); ?>
</body>
</html>