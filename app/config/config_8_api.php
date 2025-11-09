<?php /**
 +---------------------------------------------------------------------------------+
 | DW3 PME Kit BETA                                                                |
 | Version 0.1                                                                     |
 |                                                                                 | 
 |  The MIT License                                                                |
 |  Copyright © 2023 Design Web 3D                                                 | 
 |                                                                                 |
 |  Permission is hereby granted, free of charge, to any person obtaining a copy   |
 |   of this software and associated documentation files (the "Software"), to deal |
 |   in the Software without restriction, including without limitation the rights  |
 |   to use, copy, modify, merge, publish, distribute, sublicense, and/or sell     |
 |   copies of the Software, and to permit persons to whom the Software is         |
 |   furnished to do so, subject to the following conditions:                      | 
 |                                                                                 |
 |   The above copyright notice and this permission notice shall be included in    | 
 |   all copies or substantial portions of the Software.                           |
 |                                                                                 | 
 |   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR    |
 |   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,      |
 |   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE   | 
 |   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER        |
 |   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, | 
 |   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN     |
 |   THE SOFTWARE.                                                                 |
 |                                                                                 |
 +---------------------------------------------------------------------------------+
 | Author: Julien Béliveau <info@dw3.ca>                                           |
 +---------------------------------------------------------------------------------+*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
$APNAME = "API's, IA's et Réseaux Sociaux";
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';
?>
<div id="divHEAD">
	<table style="width:100%;margin:0px;white-space:nowrap;margin-top:5px;">
		<tr style="margin:0px;padding:0px;">
			<td width="*">
                <select id="config_select" onchange="window.open(this.value+'?KEY='+KEY,'_self')">
                    <option value="/app/config/config.php"> Tableau de Bord </option>
                    <option value="/app/config/config_1_info.php"> Infos générales & Facturation </option>
                    <option value="/app/config/config_2_location.php"> Adresses et Divisions </option>
                    <option value="/app/config/config_3_structure.php"> Structure de l'entreprise </option>
                    <option value="/app/config/config_4_gouv.php"> Renseignements Gouvernementaux </option>
                    <option value="/app/config/config_5_plan.php"> Plan d'affaire </option>
                    <option value="/app/config/config_6_display.php"> Affichage </option>
                    <option value="/app/config/config_7_index.php"> Index & Pages Web </option>
                    <option selected value="/app/config/config_8_api.php"> API's, IA's et Réseaux Sociaux</option>
                    <option value="/app/config/config_9_update.php"> Mises à jour & Sécurité </option>
                    <option value="/app/config/config_10_license.php"> Licenses, politiques, conditions et sitemap </option>
                </select>
            </td>
		</tr>
	</table>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>

<h4 onclick="toggleSub('divSub1','up1');" style="display:inline-block;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;margin-top:46px;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">add_reaction</span> Réseaux Sociaux <span id='up1' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class="divMAIN" id='divSub1' style='height:0px;display:none;background:transparent;'>
    <div class='divPAGE' style='text-align:center;'>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/twitter.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>twitter</div></h3>
            <a href='https://www.twitter.com/' target='_blank'><div style='width:100%;'>https://www.twitter.com/</div></a>
            <div style='margin-top:10px;'>Lien public du profil:</div>
            <input type='text' id='INDEX_TWITTER' value="<?php echo $INDEX_TWITTER ; ?>">
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/linkedin.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>LinkedIn</div></h3>
            <a href='https://www.linkedin.com/' target='_blank'><div style='width:100%;'>https://www.linkedin.com/</div></a>
            <div style='margin-top:10px;'>Lien public du profil:</div>
            <input type='text' id='INDEX_LINKEDIN' value="<?php echo $INDEX_LINKEDIN ; ?>">
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/tiktok.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>TikTok</div></h3>
            <a href='https://www.tiktok.com/' target='_blank'><div style='width:100%;'>https://www.tiktok.com/</div></a>
            <div style='margin-top:10px;'>Lien public du profil:</div>
            <input type='text' id='INDEX_TIKTOK' value="<?php echo $INDEX_TIKTOK ; ?>">
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/youtube.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>YouTube</div></h3>
            <a href='https://www.youtube.com/' target='_blank'><div style='width:100%;'>https://www.youtube.com/</div></a>
            <div style='margin-top:10px;'>Lien public du profil:</div>
            <input type='text' id='INDEX_YOUTUBE' value="<?php echo $INDEX_YOUTUBE ; ?>">
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/facebook.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Facebook</div></h3>
            <a href='https://facebook.com/' target='_blank'><div style='width:100%;'>https://facebook.com/</div></a>
            <div style='margin-top:10px;'>Lien public du profil:</div>
            <input type='text' id='INDEX_FACEBOOK' value="<?php echo $INDEX_FACEBOOK ; ?>">
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/instagram.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Instagram</div></h3>
            <a href='https://instagram.com/' target='_blank'><div style='width:100%;'>https://instagram.com/</div></a>
            <div style='margin-top:10px;'>Lien public du profil:</div>
            <input type='text' id='INDEX_INSTAGRAM' value="<?php echo $INDEX_INSTAGRAM; ?>">
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/pinterest.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Pinterest</div></h3>
            <a href='https://www.pinterest.com/' target='_blank'><div style='width:100%;'>https://www.pinterest.com/</div></a>
            <div style='margin-top:10px;'>Lien public du profil:</div>
            <input type='text' id='INDEX_PINTEREST' value="<?php echo $INDEX_PINTEREST ; ?>">
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/snapchat.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Snapchat</div></h3>
            <a href='https://www.snapchat.com/' target='_blank'><div style='width:100%;'>https://www.snapchat.com/</div></a>
            <div style='margin-top:10px;'>Lien public du profil:</div>
            <input type='text' id='INDEX_SNAPCHAT' value="<?php echo $INDEX_SNAPCHAT ; ?>">
        </div>
        <hr>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/pj.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Pages Jaunes</div></h3>
            <a href='https://www.pagesjaunes.ca/' target='_blank'><div style='width:100%;'>https://www.pagesjaunes.ca/</div></a>
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/apple.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Apple Maps</div></h3>
            <a href='https://www.apple.com/ca/maps/' target='_blank'><div style='width:100%;'>https://www.apple.com/ca/maps/</div></a>
            <a href='https://businessconnect.apple.com/' target='_blank'><div style='width:100%;'>https://businessconnect.apple.com/</div></a>
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/google.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Google Maps</div></h3>
            <a href='https://maps.google.com/' target='_blank'><div style='width:100%;'>https://maps.google.com/</div></a>
            <a href='https://www.google.com/intl/en_ca/business/' target='_blank'><div style='width:100%;'>https://www.google.com/intl/en_ca/business/</div></a>
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/yelp.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Yelp</div></h3>
            <a href='https://www.yelp.com/' target='_blank'><div style='width:100%;'>https://www.yelp.com/</div></a>
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/bing.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Bing</div></h3>
            <a href='https://www.bing.com/' target='_blank'><div style='width:100%;'>https://www.bing.com/</div></a>
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/foursquare.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>FourSquare</div></h3>
            <a href='https://foursquare.com/' target='_blank'><div style='width:100%;'>https://foursquare.com/</div></a>
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/acompio.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Acompio</div></h3>
            <a href='https://www.acompio.ca/' target='_blank'><div style='width:100%;'>https://www.acompio.ca/</div></a>
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/bbb.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>BBB</div></h3>
            <a href='https://www.bbb.org/' target='_blank'><div style='width:100%;'>https://www.bbb.org/</div></a>
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/mq.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Mapquest</div></h3>
            <a href='https://www.mapquest.com/' target='_blank'><div style='width:100%;'>https://www.mapquest.com/</div></a>
            <a href='https://business.mapquest.com/products/business-listing' target='_blank'><div style='width:100%;'>https://business.mapquest.com/products/business-listing</div></a>
        </div>
        <div class='divBOX'>
            <h3><img src='/pub/img/dw3/tomtom.png' style='height:30px;vertical-align:middle;'><br>
            <div style='display:inline-block;vertical-align:middle;margin-bottom:10px;'>Tomtom</div></h3>
            <a href='https://www.tomtom.com/' target='_blank'><div style='width:100%;'>https://www.tomtom.com/</div></a>
        </div>

        <br><button onclick="updRS();" class="green"><span class="material-icons">save</span>Sauvegarder</button>
        <br>
    </div>
</div>

<h4 onclick="toggleSub('divSub2','up2');" style="display:inline-block;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">auto_awesome</span> Intelligences Artificielles <span id='up2' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
    <div class="divMAIN" id='divSub2' style='height:0px;display:none;background:transparent;'>
        <!-- CHAT_GPT -->
        <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/gpt.webp' style='height:40px;width:auto;border-radius:5px;'> ChatGPT</h2> 
        <a href='https://platform.openai.com/account/api-keys' target='_blank'> Platform</a><br>
        <hr>
        <div class="divBOX">API KEY:
            <input id='cgptKEY' value="<?php echo $CIE_GPT_KEY; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">User Id#: 
            <input id='cgptUSER' value="" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Message test:
            <input id='txtGPT' type="text" value="Hi, how are you doing ?" onclick="detectCLICK(event,this);">
        </div>
        <br>
        <button onclick="updGPT()"><span class="material-icons">save</span>Sauvegarder</button>
        <button onclick="testGPT();"><span class="material-icons">cruelty_free</span> Tester chatGPT</button>
    </div>

    <!-- GROK xAI -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/grok.png' style='height:40px;width:auto;border-radius:5px;'> Grok</h2> 
        <a href='https://console.x.ai/' target='_blank'> Console</a><br>
        <hr>
        <div class="divBOX">API KEY:
            <input id='grokKEY' value="<?php echo $CIE_GROK_KEY; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Message test:
            <input id='txtGROK' type="text" value="Hi, how are you doing ?" onclick="detectCLICK(event,this);">
        </div>
        <br>
        <button onclick="updGROK()"><span class="material-icons">save</span>Sauvegarder</button>
        <button onclick="testGROK_CHAT();"><span class="material-icons">cruelty_free</span> Tester Grok Chat</button>
        <button onclick="testGROK_IMG();"><span class="material-icons">cruelty_free</span> Tester Grok Img</button>
    </div>

    <!-- SUPPORT CHAT .ca-->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/schat.png' style='height:40px;width:auto;border-radius:5px;'> Support Chat</h2> 
        <a href='https://supportchat.ca/dashboard/index' target='_blank'> Dashboard</a><br>
        <hr>
        <div class="divBOX">API KEY:
            <input id='schatkKEY' value="<?php echo $CIE_SCHAT_KEY; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Inactif / Actif:<br>
            <label class='switch'><input id='chkSCHAT' <?php  echo $CIE_SCHAT_ACTIVE; ?> type="checkbox"><span class='slider round'></span></label><label for='chkSCHAT' style='margin-left:5px;vertical-align:middle;'> Afficher sur le site web.</label>
        </div><br>
        <div class="divBOX">Chat Bot 1 Key:
            <input id='schatkKEY1' value="<?php echo $CIE_SCHAT_KEY1; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Chat Bot 2 Key:
            <input id='schatkKEY2' value="<?php echo $CIE_SCHAT_KEY2; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <button onclick="updSCHAT()"><span class="material-icons">save</span>Sauvegarder</button>
    </div>
</div>

<h4 onclick="toggleSub('divSub3','up3');" style="display:inline-block;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">api</span> API's de paiements et transport <span id='up3' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_down</span>
</h4>
<div class='divMAIN' id='divSub3' style='height:0px;display:none;background:transparent;'>
    <!-- PAYPAL -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/paypal.png' style='height:40px;width:auto;border-radius:5px;'> Paypal API</h2> 
        <a href='https://www.paypal.com/myaccount ' target='_blank'> Paypal Account</a> / <a href='https://developer.paypal.com/dashboard/' target='_blank'> Paypal Dashboard</a>
        <hr>
        <div class="divBOX">Nom d'utilisateur (Production):
            <input id='paypalUSER' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_PAYPAL_USER; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Nom d'utilisateur (Développement):
            <input id='paypalUSER_DEV' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_PAYPAL_USER_DEV; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX" style='display:none;'>Mot de passe:
            <input id='paypalPW' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php //echo $CIE_PAYPAL_PW; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX" style='display:none;'>Key production (ClientID):
            <input id='paypalKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php //echo $CIE_PAYPAL_KEY; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX" style='display:none;'>Secret production:
            <input id='paypalSECRET' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php //echo $CIE_PAYPAL_SECRET; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX" style='display:none;'>Key dévelopement (ClientID):
            <input id='paypalKEY_DEV' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php //echo $CIE_PAYPAL_KEY_DEV; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX" style='display:none;'>Secret dévelopement:
            <input id='paypalSECRET_DEV' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php //echo $CIE_PAYPAL_SECRET_DEV; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Mode:
            <select style='width:50%;float:right;' id='paypalMODE' size=2 class='multiple'>
                <option value='DEV' <?php if ($CIE_PAYPAL_MODE == "" || $CIE_PAYPAL_MODE == "DEV") {echo "selected";} ?>>Développement</option>
                <option value='PROD' <?php if ($CIE_PAYPAL_MODE == "PROD") {echo "selected";} ?>>Production</option>
            </select>
        </div>
        <br><button onclick="updPaypal();"><span class="material-icons">save</span>Sauvegarder</button>
    </div>

    <!-- SQUARE -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/square.png' style='height:40px;width:auto;border-radius:5px;'> Square API</h2> 
        <a href='https://app.squareup.com/dashboard//' target='_blank'> Square Dashboard</a> / 
        <a href='https://developer.squareup.com/' target='_blank'> Square API developer ressoreces</a><br>
        <hr>
        <div class="divBOX">Application ID:
            <input id='squareAPP' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_SQUARE_APP; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Production Secret Key:
            <input id='squareKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_SQUARE_KEY; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Developement Key:
            <input id='squareKEY_DEV' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_SQUARE_DEV; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Mode:
            <select style='width:50%;float:right;' id='squareMODE' size=2 class='multiple'>
                <option value='DEV' <?php if ($CIE_SQUARE_MODE == "" || $CIE_SQUARE_MODE == "DEV") {echo "selected";} ?>>Développement</option>
                <option value='PROD' <?php if ($CIE_SQUARE_MODE == "PROD") {echo "selected";} ?>>Production</option>
            </select>
        </div>
        <br><button onclick="updSquare();"><span class="material-icons">save</span>Sauvegarder</button>
        <button onclick="squareBalance();"><span class="material-icons">save</span>Balance</button>
        <button onclick="squareTest();"><span class="material-icons">save</span>Test</button>
    </div>

    <!-- STRIPE -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/stripe.jfif' style='height:40px;width:auto;border-radius:5px;'> Stripe API</h2> 
        <a href='https://dashboard.stripe.com/' target='_blank'> Stripe Dashboard</a><br>
        <hr>
        <div class="divBOX">Secret:
            <input id='stripeKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_STRIPE_KEY; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Key:
            <input id='stripeSECRET' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_STRIPE_SECRET; ?>" onclick="showPW(event,this);">
        </div><hr>
        <div class="divBOX">Secret (Développement):
            <input id='stripeTKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_STRIPE_TKEY; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Key (Développement):
            <input id='stripeTSECRET' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_STRIPE_TSECRET; ?>" onclick="showPW(event,this);">
        </div><hr>
        <div class="divBOX">Mode:
            <select style='width:50%;float:right;' id='stripeMODE' size=2 class='multiple'>
                <option value='DEV' <?php if ($CIE_STRIPE_MODE == ""||$CIE_STRIPE_MODE == "DEV") {echo "selected";} ?>>Développement</option>
                <option value='PROD' <?php if ($CIE_STRIPE_MODE == "PROD") {echo "selected";} ?>>Production</option>
            </select>
        </div>
        <br><button onclick="updStripe();"><span class="material-icons">save</span>Sauvegarder</button>
        <button onclick="stripeBalance();"><span class="material-icons">info</span>Afficher le solde</button>
        <button onclick="stripeWebhooks();"><span class="material-icons">update</span>Créer les Webhooks</button>
    </div>

    <!-- POSTE CANADA -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/poste_canada.png' style='height:40px;width:auto;border-radius:5px;'> Poste Canada API</h2> 
        <a href='https://www.canadapost-postescanada.ca/dash-tableau/fr' target='_blank'> Tableau de bord</a><br>
        <hr>
        <div class="divBOX">Nom d'utilisateur:
            <input style='width:50%;float:right;' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" id='posteUSER' type="password" value="<?php echo $CIE_POSTE_USER; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Mot de passe:
            <input style='width:50%;float:right;' id='postePW' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_POSTE_PW; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Key:
            <input style='width:50%;float:right;' id='posteKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');"  type="password" value="<?php echo $CIE_POSTE_KEY; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Mode:
            <select style='width:50%;float:right;' id='posteMODE' size=2 class='multiple'>
                <option value='DEV' <?php if ($CIE_POSTE_MODE == ""||$CIE_POSTE_MODE == "DEV") {echo "selected";} ?>>Développement</option>
                <option value='PROD' <?php if ($CIE_POSTE_MODE == "PROD") {echo "selected";} ?>>Production</option>
            </select>
        </div>
        <br><button onclick="updPoste();"><span class="material-icons">save</span>Sauvegarder</button>
        <button onclick="posteTest();"><span class="material-icons">quiz</span>Disponibilité du ramassage</button>
        <button onclick="posteTest2();"><span class="material-icons">price_check</span>Prix du rammassage</button>
        <hr>
        <div class="divBOX">Nombre de paquets à ramasser:
            <input id='PC_nb_box' value='0' type='number' style='width:50px;text-align:center;float:right;'>
        </div><br>
        <div class="divBOX">Note pour le ramassage:
            <input id='PC_note' value='' type='text'>
        </div><br>
        <button onclick="posteTest3();"><span class="material-icons">shopping_cart_checkout</span>Demande de rammassage</button><br>
        Contact : <?php echo $USER_FULLNAME . " " . $CIE_TEL1 . " " . $CIE_EML1; ?>
        <hr>
        <div class="divBOX">Dernière requête:
            <input style='width:40%;' id='postePID' type="text" value="<?php /* echo $CIE_POSTE_PID; */ ?>">
            <button onclick="posteTest4();"><span class="material-icons">price_check</span>Détails</button>
        </div>
    </div>

    <!-- MONTREAL DROP_SHIP -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/livar.png' style='height:40px;width:auto;border-radius:5px;'> Livraison à Rabais</h2> 
        <a href='https://client.livraisonsarabais.com/dashboards/default' target='_blank'> Console</a><br>
        <hr>
        <div class="divBOX">Clé d’accès (Production):
            <input id='livarKEY' value="<?php echo $CIE_LIVAR_KEY; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Clé d’accès (Dévelopement):
            <input id='livarDEV' value="<?php echo $CIE_LIVAR_DEV; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Mode:
            <select style='width:50%;float:right;' id='livarMODE' size=2 class='multiple'>
                <option value='DEV' <?php if ($CIE_LIVAR_MODE == ""||$CIE_LIVAR_MODE == "DEV") {echo "selected";} ?>>Développement</option>
                <option value='PROD' <?php if ($CIE_LIVAR_MODE == "PROD") {echo "selected";} ?>>Production</option>
            </select>
        </div>
        <br><button onclick="testLIVAR();">Test Carrier Quote</button>
        <button onclick="updLIVAR();"><span class="material-icons">save</span>Sauvegarder</button>
        <button onclick="window.open('https://client.livraisonsarabais.com/ship/pickup','_blank')"><span class='material-icons'>open_in_new</span> Demande de cueillette </button>
        <br>
    </div>

    <!-- DOORDASH -->
    <div class='divPAGE' style='display:none'><br>
        <h2><img src='/pub/img/dw3/paypal.png' style='height:40px;width:auto;border-radius:5px;'> DoorDash API</h2> 
        <a href='https://developer.doordash.com/portal' target='_blank'> DoorDash Dashboard</a>
        <hr>
        <div class="divBOX">ID de développeur:
            <input id='DoorDashDEV' type="text" value="<?php echo $CIE_DOORDASH_DEV; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">ID de clé:
            <input id='DoorDashKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_DOORDASH_KEY; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Secret de signature:
            <input id='DoorDashSECRET' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_DOORDASH_SECRET; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Webhook Auth:
            <input id='DoorDashAUTH' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_DOORDASH_AUTH; ?>" onclick="showPW(event,this);">
        </div>
        <br><button onclick="updDoorDash();"><span class="material-icons">save</span>Sauvegarder</button>
        <button onclick="doordashTest();"><span class="material-icons">save</span>Test</button>
    </div>


    <!-- MONERIS -->
    <div class='divPAGE' style='display:none;'><br>
        <h2>Moneris API</h2> 
        <a href='https://moneris.com/' target='_blank'> Moneris Dashboard</a> / 
        <a href='https://github.com/Moneris' target='_blank'> Moneris API files source</a><br>
        <hr>
        <div class="divBOX">Secret Key:
            <input id='monerisKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php //echo $CIE_MONERIS_KEY; ?>" onclick="showPW(event,this);">
        </div>
        <br><button onclick="updMoneris();"><span class="material-icons">save</span>Sauvegarder</button>
        <button onclick="monerisBalance();"><span class="material-icons">save</span>Balance</button>
        <button onclick="monerisTest();"><span class="material-icons">save</span>Test</button>
    </div>  
</div>


<h4 onclick="toggleSub('divSub4','up4');" style="display:inline-block;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">groups</span> API's de meetings <span id='up4' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class="divMAIN" id='divSub4'  style='height:0px;display:none;background:transparent;'>
    <!-- TEAMS -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/teams.png' style='height:40px;width:auto;border-radius:5px;'> Teams API</h2> 
        <a href='https://learn.microsoft.com/en-us/graph/api/application-post-onlinemeetings?view=graph-rest-1.0&tabs=http' target='_blank'> Documentation</a> / 
        <a href='https://teams.live.com/' target='_blank'> Dashboard</a><br>
        <hr>
        <div class="divBOX">API KEY:
            <input id='teamsKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php if (isset($CIE_TEAMS_KEY)){ echo $CIE_TEAMS_KEY; } ; ?>" onclick="showPW(event,this);">
        </div>
        <br><button onclick="updTEAMS();"><span class="material-icons">save</span>Sauvegarder</button>
    </div>
    <!-- ZOOM -->
    <div class='divPAGE' style='display:none;'><br>
        <h2>Zoom API</h2> 
        <a href='https://developers.zoom.us/' target='_blank'> Documentation</a> / 
        <a href='https://zoom.us/myhome' target='_blank'> Dashboard</a><br>
        <hr>
        <div class="divBOX">API KEY:
            <input id='zoomKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php if (isset($CIE_ZOOM_KEY)){ echo $CIE_ZOOM_KEY; } ; ?>" onclick="showPW(event,this);">
        </div>
        <br><button onclick="updZOOM();"><span class="material-icons">save</span>Sauvegarder</button>
    </div>
</div>

<h4 onclick="toggleSub('divSub6','up6');" style="display:inline-block;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">sms</span> API's de SMS <span id='up6' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class="divMAIN" id='divSub6' style='height:0px;display:none;background:transparent;'>
        <!-- TWILIO -->
        <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/twillio.svg' style='height:40px;width:auto;border-radius:5px;'> Twilio API</h2> 
        <a href='https://console.twilio.com/?frameUrl=%2Fconsole%3Fx-target-region%3Dus1&newCustomer=true' target='_blank'> Console</a><br>
        <hr>
        <div class="divBOX">Account SID:
            <input id='twilioSID' value="<?php echo $CIE_TWILIO_SID; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Auth Token:
            <input id='twilioAUTH' value="<?php echo $CIE_TWILIO_AUTH; ?>"  autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">2-Way #: 
            <input id='twilioSENDER'type="text" value="<?php echo $CIE_TWILIO_SENDER; ?>" onclick="detectCLICK(event,this);">
        </div>
        <br>
        <div class="divBOX">#Téléphone test:
            <input style='float:right;' id='twilioPHONE' type="number" value="1">
        </div>
        <div class="divBOX">Message test:
            <input id='twilioMSG' type="text" value="Test" onclick="detectCLICK(event,this);">
        </div>
        <br><button onclick="testtwilio();">Envoi SMS test</button>
        <hr>
        <button onclick="balancetwilio();">Balance Twilio</button>
        <button onclick="recenttwilio();">Recent sms's</button>
        <button onclick="updTWILIO();"><span class="material-icons">save</span>Sauvegarder</button>
        <br>
    </div>

    <!-- SMS.TO -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/sms.to.png' style='height:40px;width:auto;border-radius:5px;'> SMS.to API</h2> 
        <a href='https://sms.to/register?referral=c81bf338-c068-4900-b797-34a69b381aa3' target='_blank'> Référence</a><br>
        <hr>
        <div class="divBOX">API KEY:
            <input id='smsKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_SMS_KEY; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Sender #: 
            <input id='smsSENDER' type="text" value="<?php echo $CIE_SMS_SENDER; ?>" onclick="detectCLICK(event,this);">
        </div>
        <br>
        <div class="divBOX">#Téléphone test:
            <input style='float:right;' id='smsPHONE' type="number" value="1">
        </div>
        <div class="divBOX">Message test:
            <input id='smsMSG' type="text" value="Test" onclick="detectCLICK(event,this);">
        </div>
        <br><button onclick="testsms();">Envoi SMS test</button>
        <hr>
        <button onclick="getbalance();">Balance sms.to</button>
        <button onclick="recentsms();">Recent sms's</button>
        <button onclick="updSMS();"><span class="material-icons">save</span>Sauvegarder</button>
        <br>
    </div>
</div>

<h4 onclick="toggleSub('divSub5','up5');" style="display:inline-block;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">account_tree</span> API's de données <span id='up5' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class="divMAIN" id='divSub5' style='height:0px;display:none;background:transparent;'>
    <!-- DEEPL -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/deepl.png' style='height:40px;width:auto;border-radius:5px;'> DeepL Traduction</h2> 
        <a href='https://www.deepl.com/account/summary' target='_blank'> Platform</a>
        <a href='https://developers.deepl.com/docs/getting-started/intro' target='_blank'> Documentation</a><br>
        <hr>
        <div class="divBOX">API KEY:
            <input id='deeplKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_DEEPL_KEY; ?>" onclick="showPW(event,this);">
        </div>
        <br><button onclick="updDEEPL()"><span class="material-icons">save</span>Sauvegarder</button>
    </div>
    
    <!-- DATA IA -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/dataia.png' style='height:40px;width:auto;border-radius:5px;'> DW3 Data IA</h2> 
        <a href='https://dataia.ca' target='_blank'> Platforme</a><br>
        <hr>
        <div class="divBOX">API KEY:
            <input id='dataiaKEY' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_DATAIA_KEY; ?>" onclick="showPW(event,this);">
        </div>
        <br><button onclick="updDATAIA();"><span class="material-icons">save</span>Sauvegarder</button>
    </div>
</div>

<h4 onclick="toggleSub('divSub7','up7');" style="display:inline-block;background: rgba(255, 255, 255, 0.7);color:#222;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-radius: 8px 8px;border-bottom: 1mm ridge rgba(127, 127, 127, .6);">
	<span class="material-icons">android</span> API's de Google <span id='up7' class="material-icons" style='float:right;margin-right:10px;'>keyboard_arrow_up</span>
</h4>
<div class="divMAIN" id='divSub7' style='height:0px;display:none;background:transparent;'>
    <!-- GOOGLE -->
    <div class='divPAGE'><br>
        <h2><img src='/pub/img/dw3/google.png' style='height:40px;width:auto;border-radius:5px;'> Google API's</h2> 
        <a href='https://console.cloud.google.com/google/maps-apis/overview' target='_blank'> Maps Référence</a><br>
        <a href='https://aistudio.google.com/apikey' target='_blank'> Gemini API Key</a><br>
        <a href='https://ai.google.dev/gemini-api/docs?hl=fr' target='_blank'> Gemini Docs</a><br>
        <hr>
        <div class="divBOX">Client ID:
            <input id='gmapID' value="<?php echo $CIE_G_ID; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Secret Code:
            <input id='gmapSECRET' value="<?php echo $CIE_G_SECRET; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div><br>
        <div class="divBOX">Image de SignIn:<br><div style='text-align:center;width:100%;'>
            <input type='radio' id='G_SIGNIN_IMG1' value="google_login_1.svg" <?php if ($CIE_G_IMG =="google_login_1.svg"){echo "checked";}?> name='G_SIGNIN_IMG'><label for="G_SIGNIN_IMG1"><img style='width:200px;height:auto;' src='/pub/img/dw3/google_login_1.svg'></label><br>
            <input type='radio' id='G_SIGNIN_IMG2' value="google_login_2.svg" <?php if ($CIE_G_IMG =="google_login_2.svg"){echo "checked";}?> name='G_SIGNIN_IMG'><label for="G_SIGNIN_IMG2"><img style='width:200px;height:auto;' src='/pub/img/dw3/google_login_2.svg'></label><br>
            <input type='radio' id='G_SIGNIN_IMG3' value="google_login_3.svg" <?php if ($CIE_G_IMG =="google_login_3.svg"){echo "checked";}?> name='G_SIGNIN_IMG'><label for="G_SIGNIN_IMG3"><img style='width:200px;height:auto;' src='/pub/img/dw3/google_login_3.svg'></label><br>
            <input type='radio' id='G_SIGNIN_IMG4' value="google_login_4.svg" <?php if ($CIE_G_IMG =="google_login_4.svg"){echo "checked";}?> name='G_SIGNIN_IMG'><label for="G_SIGNIN_IMG4"><img style='width:200px;height:auto;' src='/pub/img/dw3/google_login_4.svg'></label><br>
        </div></div><br><hr>
        <div class="divBOX">Gemini Key:
            <input id='geminiKEY' value="<?php echo $CIE_GEMINI_KEY; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Gemini Message test:
            <input id='txtGEMINI' type="text" value="Hi, how are you doing ?" onclick="detectCLICK(event,this);">
            <select id='selGEMINI_MODEL'>
                <option value='Pro2.5'>Gemini 2.5 Pro</option>
                <option value='Flash2.5'>Gemini 2.5 Flash</option>
                <option value='Flash2.0'>Gemini 2.0 Flash</option>
                <option value='FlashLite2.5'>Gemini 2.5 Flash-Lite</option>
                <option value='FlashLite2.0'>Gemini 2.0 Flash-Lite</option>
            </select>
            <button onclick="testGEMINI();"><span class="material-icons">cruelty_free</span> Tester Gemini</button>
        </div>
        
        <hr>
        <div class="divBOX">Map Key:
            <input id='gmapKEY' value="<?php echo $CIE_GMAP_KEY; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Map Id#: 
            <input id='gmapMAP' value="<?php echo $CIE_GMAP_MAP; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <div class="divBOX">Analytics Id: 
            <input id='gANALYTICS' value="<?php echo $CIE_GANALYTICS; ?>" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" onclick="showPW(event,this);">
        </div>
        <br><button onclick="updGMAP();"><span class="material-icons">save</span>Sauvegarder</button>
    </div>
</div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var STRIPE_MODE = '<?php echo$CIE_STRIPE_MODE; ?>';
var client_devtools = function() {};

$(document).ready(function (){
    document.getElementById('config_select').value="/app/config/config_8_api.php";
});

window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    window.location.reload();
  }
});

function toggleSub(sub,up){
	if(document.getElementById(sub).style.height=="0px"){
		document.getElementById(up).innerHTML="keyboard_arrow_down";
		document.getElementById(sub).style.height="auto";
		document.getElementById(sub).style.display="inline-block";
	} else {
		document.getElementById(up).innerHTML="keyboard_arrow_up";
		document.getElementById(sub).style.height="0px";
		document.getElementById(sub).style.display="none";
	}
}

function updRS(){
    var sINDEX_FACEBOOK = document.getElementById("INDEX_FACEBOOK").value;
    var sINDEX_TWITTER = document.getElementById("INDEX_TWITTER").value;
    var sINDEX_INSTAGRAM = document.getElementById("INDEX_INSTAGRAM").value;
    var sINDEX_TIKTOK = document.getElementById("INDEX_TIKTOK").value;
    var sINDEX_LINKEDIN = document.getElementById("INDEX_LINKEDIN").value;
    var sINDEX_YOUTUBE = document.getElementById("INDEX_YOUTUBE").value;
    var sINDEX_PINTEREST = document.getElementById("INDEX_PINTEREST").value;
    var sINDEX_SNAPCHAT = document.getElementById("INDEX_SNAPCHAT").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim() == ""){
            addNotif("Sauvegarde des réseaux sociaux terminée.");
        } else {
            addMsg(this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        }     
	  }
	};
		xmlhttp.open('GET', 'updRS.php?KEY=' + KEY 
            + "&RS1=" + encodeURIComponent(sINDEX_FACEBOOK)
            + "&RS2=" + encodeURIComponent(sINDEX_TWITTER)
            + "&RS3=" + encodeURIComponent(sINDEX_INSTAGRAM)
            + "&RS4=" + encodeURIComponent(sINDEX_LINKEDIN)
            + "&RS5=" + encodeURIComponent(sINDEX_TIKTOK)
            + "&RS6=" + encodeURIComponent(sINDEX_YOUTUBE)
            + "&RS7=" + encodeURIComponent(sINDEX_PINTEREST)
            + "&RS8=" + encodeURIComponent(sINDEX_SNAPCHAT)
            , true);
		xmlhttp.send();
}

function updLIVAR(){
	var sAUTH = document.getElementById("livarKEY").value;
	var sDEV = document.getElementById("livarDEV").value;
    var GRPBOX  = document.getElementById("livarMODE");
	var sMODE = GRPBOX.options[GRPBOX.selectedIndex].value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updLIVAR.php?KEY=' + KEY 
        + '&MODE=' +  sMODE
        + '&DEV=' +  sDEV
        + '&AUTH=' +  sAUTH,
        true);
		xmlhttp.send();
}

function updTWILIO(){
	var sSID = document.getElementById("twilioSID").value;
	var sAUTH = document.getElementById("twilioAUTH").value;
	var sSENDER = document.getElementById("twilioSENDER").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updTWILIO.php?KEY=' + KEY 
										+ '&SID=' + sSID 
										+ '&AUTH=' +  sAUTH
										+ '&SENDER=' +  sSENDER ,
										true);
		xmlhttp.send();
}

function updGPT(){
	var sKEY = document.getElementById("cgptKEY").value;
	var sUSER = document.getElementById("cgptUSER").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updGPT.php?KEY=' + KEY 
										+ '&GPT_KEY=' +  sKEY
										+ '&GPT_USER=' +  sUSER ,
										true);
		xmlhttp.send();
}
function updSCHAT(){
	var sKEY = document.getElementById("schatkKEY").value;
	var sKEY1 = document.getElementById("schatkKEY1").value;
	var sKEY2 = document.getElementById("schatkKEY2").value;
    if (document.getElementById("chkSCHAT").checked == true){var sCHECK = "checked"; } else { var sCHECK = "";}
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updSCHAT.php?KEY=' + KEY 
										+ '&SKEY=' +  sKEY
										+ '&SKEY1=' +  sKEY1
										+ '&SKEY2=' +  sKEY2
										+ '&SCHECK=' +  sCHECK,
										true);
		xmlhttp.send();
}
function updGROK(){
	var sKEY = document.getElementById("grokKEY").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updGROK.php?KEY=' + KEY 
										+ '&GPT_KEY=' +  sKEY,
										true);
		xmlhttp.send();
}
function updSMS(){
	var sKEY = document.getElementById("smsKEY").value;
	var sSENDER = document.getElementById("smsSENDER").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updSMS.php?KEY=' + KEY 
										+ '&SMS_KEY=' +  sKEY
										+ '&SMS_SENDER=' +  sSENDER ,
										true);
		xmlhttp.send();
}

function updDATAIA(){
	var sKEY = document.getElementById("dataiaKEY").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
    xmlhttp.open('GET', 'updDATAIA.php?KEY=' + KEY + '&DKEY=' + sKEY,true);
    xmlhttp.send();
}

function updDEEPL(){
	var sKEY = document.getElementById("deeplKEY").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
    xmlhttp.open('GET', 'updDEEPL.php?KEY=' + KEY + '&DKEY=' + sKEY,true);
    xmlhttp.send();
}

function updPoste(){
	var sUSER = document.getElementById("posteUSER").value;
	var sPW = document.getElementById("postePW").value;
	var sKEY = document.getElementById("posteKEY").value;
    var GRPBOX  = document.getElementById("posteMODE");
	var sMODE = GRPBOX.options[GRPBOX.selectedIndex].value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updPOSTE.php?KEY=' + KEY 
										+ '&POSTE_MODE=' +  sMODE
										+ '&POSTE_USER=' +  sUSER
										+ '&POSTE_PW=' +  sPW
										+ '&POSTE_KEY=' +  sKEY,
										true);
		xmlhttp.send();
}
function testLIVAR(){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText+ "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
	  }
	};
		xmlhttp.open('GET', '/api/livar/quote.php?KEY=' + KEY, true);
		xmlhttp.send();
}
function testGPT(){
	var sQUESTION = document.getElementById("txtGPT").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText+ "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
	  }
	};
		xmlhttp.open('GET', '/api/chatGPT/chat.php?KEY=' + KEY + "&S=&Q=" + sQUESTION, true);
		xmlhttp.send();
}
function testGROK_CHAT(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var sROLE = "You are a test assistant.";
	var sQUESTION = document.getElementById("txtGROK").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText+ "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
	  }
	};
		xmlhttp.open('GET', '/api/Grok/chat.php?KEY=' + KEY + "&S="+encodeURIComponent(sROLE)+"&Q=" + encodeURIComponent(sQUESTION), true);
		xmlhttp.send();
}
function testGROK_IMG(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var sQUESTION = document.getElementById("txtGROK").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substring(0,3)=="Err"){
            addMsg(this.responseText+ "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            addMsg("<img src='/pub/upload/"+this.responseText+"' style='width:75vw;max-width:700px;height:auto;'><br>"+this.responseText+"<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        }
	  }
	};
		xmlhttp.open('GET', '/api/Grok/image.php?KEY=' + KEY + "&P=&Q=" + encodeURIComponent(sQUESTION), true);
		xmlhttp.send();
}
function testGEMINI(){
    var GRPBOX  = document.getElementById("selGEMINI_MODEL");
	var sMODEL = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sQUESTION = document.getElementById("txtGEMINI").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg("<div id='geminiElement' style='font-weight:bold;margin:-5px 0px 10px 0px;text-align:left;'>"+this.responseText+ "</div><button onclick=\"dw3_element_to_clipboard('geminiElement');\"><span class='material-icons' style='vertical-align:middle;'>copy_all</span> Copier</button><br><div style='text-align:left;width:100%;'>Répondre:<input id='txtGEMINIrp' type='text' style='width:80%;'><button onclick='answerGEMINI();'><span class='material-icons' style='vertical-align:middle;'>question_answer</span></button></div><div style='height:20px;'> </div> <button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Fermer</button>");
	  }
	};
		xmlhttp.open('GET', '/api/google/gemini.php?KEY=' + KEY + "&S=&Q=" + encodeURIComponent(sQUESTION) + "&M=" + encodeURIComponent(sMODEL), true);
		xmlhttp.send();
}
function answerGEMINI(){
	var sQUESTION = document.getElementById("txtGEMINIrp").value;
    var GRPBOX  = document.getElementById("selGEMINI_MODEL");
	var sMODEL = GRPBOX.options[GRPBOX.selectedIndex].value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg("<div id='geminiElement' style='font-weight:bold;margin:-10px 0px 10px 0px;text-align:left;'>"+this.responseText+ "</div><button onclick=\"dw3_text_to_clipboard('geminiElement');closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>copy_all</span> Copier</button><br><div style='text-align:left;width:100%;'>Répondre:</div><input id='txtGEMINIrp' type='text' style='width:80%;'><button onclick='answerGEMINI();'><span class='material-icons' style='vertical-align:middle;'>question_answer</span></button></div><div style='height:20px;'> </div> <button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Fermer</button>");
	  }
	};
		xmlhttp.open('GET', '/api/google/gemini.php?KEY=' + KEY + "&S=&Q=" + encodeURIComponent(sQUESTION)+ "&M=" + encodeURIComponent(sMODEL), true);
		xmlhttp.send();
}
function posteTest(){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText+ "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
	  }
	};
		xmlhttp.open('GET', '/api/poste_canada/REST/pickup/GetPickupAvailability/GetPickupAvailability.php?KEY=' + KEY ,
										true);
		xmlhttp.send();
}
function posteTest2(){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText+ "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
	  }
	};
		xmlhttp.open('GET', '/api/poste_canada/REST/pickup/PickupRequest/GetPickupPriceRequest.php?KEY=' + KEY ,
										true);
		xmlhttp.send();
}
function posteTest3(){
    const nBox = document.getElementById("PC_nb_box").value;
    const notes = document.getElementById("PC_note").value;
    if (nBox == 0){
        addMsg("Veuillez entrer un nombre de colis à expédier.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        return;
    }
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText+ "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
	  }
	};
		xmlhttp.open('GET', '/api/poste_canada/REST/pickup/PickupRequest/CreatePickupRequest.php?KEY=' + KEY + '&nb=' + nBox + '&note=' + encodeURIComponent(notes) ,
										true);
		xmlhttp.send();
}

function updSquare(){
	var sAPP = document.getElementById("squareAPP").value;
	var sKEY = document.getElementById("squareKEY").value;
	var sDEV = document.getElementById("squareKEY_DEV").value;
	var sMODE = document.getElementById("squareMODE").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updSquare.php?KEY=' + KEY 
										+ '&SQUARE_APP=' +  sAPP
										+ '&SQUARE_KEY=' +  sKEY
										+ '&SQUARE_DEV=' +  sDEV
										+ '&SQUARE_MODE=' +  sMODE,
										true);
		xmlhttp.send();
}
/* function updZOOM(){
	var sKEY = document.getElementById("zoomKEY").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updZOOM.php?KEY=' + KEY 
										+ '&ZOOM_KEY=' +  sKEY,
										true);
		xmlhttp.send();
} */
function updMoneris(){
	var sKEY = document.getElementById("monerisKEY").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updMONERIS.php?KEY=' + KEY 
										+ '&MONERIS_KEY=' +  sKEY,
										true);
		xmlhttp.send();
}
function monerisTest(){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText);
	  }
	};
		xmlhttp.open('GET', '/api/moneris/Examples/CA/....php?KEY=' + KEY,
										true);
		xmlhttp.send();
}

function updPaypal(){ 
	//var sKEY_DEV = document.getElementById("paypalKEY_DEV").value;
	//var sSECRET_DEV = document.getElementById("paypalSECRET_DEV").value;
	//var sKEY = document.getElementById("paypalKEY").value;
	//var sSECRET = document.getElementById("paypalSECRET").value;
    var sUSER = document.getElementById("paypalUSER").value;
    var sUSERDEV = document.getElementById("paypalUSER_DEV").value;
	//var sPW = document.getElementById("paypalPW").value;
    var GRPBOX  = document.getElementById("paypalMODE");
	var sMODE = GRPBOX.options[GRPBOX.selectedIndex].value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
/* 		xmlhttp.open('GET', 'updPAYPAL.php?KEY=' + KEY 
										+ '&PPKEY_DEV=' +  encodeURIComponent(sKEY_DEV)
										+ '&PPKEY=' +  encodeURIComponent(sKEY)
										+ '&PPSECRET_DEV=' +  encodeURIComponent(sSECRET_DEV)
										+ '&PPSECRET=' +  encodeURIComponent(sSECRET)
										+ '&PPUSER=' +  encodeURIComponent(sUSER)
										+ '&PPPW=' +  encodeURIComponent(sPW)
										+ '&PPMODE=' +  sMODE,
										true); */
		xmlhttp.open('GET', 'updPAYPAL.php?KEY=' + KEY 
										+ '&PPUSER=' +  encodeURIComponent(sUSER)
										+ '&PPUSERDEV=' +  encodeURIComponent(sUSERDEV)
										+ '&PPMODE=' +  sMODE,
										true);
		xmlhttp.send();
}
function updDoorDash(){
	var sAUTH = document.getElementById("DoorDashAUTH").value;
	var sDEV = document.getElementById("DoorDashDEV").value;
	var sKEY = document.getElementById("DoorDashKEY").value;
	var sSECRET = document.getElementById("DoorDashSECRET").value;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updDOORDASH.php?KEY=' + KEY 
										+ '&DD_DEV=' +  sDEV
										+ '&DD_AUTH=' +  sAUTH
										+ '&DD_KEY=' +  sKEY
										+ '&DD_SECRET=' +  sSECRET,
										true);
		xmlhttp.send();
}
function updStripe(){
	var sKEY = document.getElementById("stripeKEY").value;
	var sSECRET = document.getElementById("stripeSECRET").value;
	var sTKEY = document.getElementById("stripeTKEY").value;
	var sTSECRET = document.getElementById("stripeTSECRET").value;
    var GRPBOX  = document.getElementById("stripeMODE");
	var sMODE = GRPBOX.options[GRPBOX.selectedIndex].value;
    STRIPE_MODE = sMODE;
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updSTRIPE.php?KEY=' + KEY 
										+ '&STRIPE_MODE=' +  sMODE
										+ '&STRIPE_KEY=' +  sKEY
										+ '&STRIPE_SECRET=' +  sSECRET
										+ '&STRIPE_TKEY=' +  sTKEY
										+ '&STRIPE_TSECRET=' +  sTSECRET,
										true);
		xmlhttp.send();
}
function stripeTest(){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText);
	  }
	};
    xmlhttp.open('GET', '/client/create-checkout-session.php?KEY=' + KEY, true);
    xmlhttp.send();
}

function stripeWebhooks(){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'stripe_create_webhooks.php?KEY=' + KEY, true);
		xmlhttp.send();
}

function stripeBalance(){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (STRIPE_MODE == "DEV"){
            var modeText = "(Mode Test)";
        } else if (STRIPE_MODE == "PROD"){
            var modeText = "(Mode Production)";
        } else {
            var modeText = "(Mode non-défini)";
        }
        addMsg("<b>" + modeText + "</b><div style='height:20px;'> </div>" + this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
	  }
	};
		xmlhttp.open('GET', 'stripeBalance.php?KEY=' + KEY, true);
		xmlhttp.send();
}

function updGMAP(){
	var sID = document.getElementById("gmapID").value;
	var sSECRET = document.getElementById("gmapSECRET").value;
	var sKEY = document.getElementById("gmapKEY").value;
	var sGEMINI = document.getElementById("geminiKEY").value;
	var sMAP = document.getElementById("gmapMAP").value;
	var sANALYTICS = document.getElementById("gANALYTICS").value;
	var sIMG = document.querySelector('input[name="G_SIGNIN_IMG"]:checked').value;

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updGMAP.php?KEY=' + KEY 
										+ '&GANALYTICS=' +  sANALYTICS
										+ '&GEMINI_KEY=' +  sGEMINI
										+ '&GMAP_KEY=' +  sKEY
										+ '&GMAP_ID=' +  sID
										+ '&GMAP_SECRET=' +  sSECRET
										+ '&GMAP_IMG=' +  sIMG
										+ '&GMAP_MAP=' +  sMAP ,
										true);
		xmlhttp.send();
}

function testsms() {
    if (document.getElementById("smsPHONE").value.length < 10){
        document.getElementById("divFADE").style.opacity = "0.6";
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Le # doit contenir 10 ou 11 chiffres.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
    }
    var phone =  document.getElementById("smsPHONE").value;
    var msg =  document.getElementById("smsMSG").value;
    sendSMS(phone,msg);
}

function getbalance() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";

	  }
	};
		xmlhttp.open('GET', 'getbalance.php?KEY='+KEY , true);
		xmlhttp.send();
		
}
function recentsms() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";

	  }
	};
		xmlhttp.open('GET', 'getSMS.php?KEY='+KEY , true);
		xmlhttp.send();
		
}
function testtwilio() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	  }
	};
		xmlhttp.open('GET', 'testtwilio.php?KEY='+KEY , true);
		xmlhttp.send();
		
}

</script>
</body>
</html>
<?php $dw3_conn->close();exit(); ?>