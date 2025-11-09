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
$APNAME = "Renseignements Gouvernementaux";
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
                    <option selected value="/app/config/config_4_gouv.php"> Renseignements Gouvernementaux </option>
                    <option value="/app/config/config_5_plan.php"> Plan d'affaire </option>
                    <option value="/app/config/config_6_display.php"> Affichage </option>
                    <option value="/app/config/config_7_index.php"> Index & Pages Web </option>
                    <option value="/app/config/config_8_api.php"> API's, IA's et Réseaux Sociaux</option>
                    <option value="/app/config/config_9_update.php"> Mises à jour & Sécurité </option>
                    <option value="/app/config/config_10_license.php"> Licenses, politiques, conditions et sitemap </option>
                </select>
            </td>
		</tr>
	</table>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>

<div class="divMAIN" style="margin-top:50px;">
    <div class='divPAGE'>
        <!-- CANADA -->
        <hr><h3><img src='/pub/img/dw3/canada.svg' style='max-height:50px;'></h3>
        <div class="divBOX">Numéro d'Entreprise (NE): 
            <input id='cfgNE' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_NE; ?>" onclick="showPW(event,this);">
        </div>	
        <div class="divBOX">Numéro de TPS:
            <input id='cfgTPS' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');"  type="password" value="<?php echo $CIE_TPS; ?>" onclick="showPW(event,this);">
        </div>
        <hr>
        <!-- ALBERTA -->
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><svg xmlns="http://www.w3.org/2000/svg" width="149" height="42" viewBox="0 0 216 61" shape-rendering="geometricPrecision"><rect class="logo" fill="#00aad2" x="196.411" y="31.014" width="19.59" height="19.592"></rect><path class="logo" fill="#5f6a72" d="M91.271,47.934c-1.972,0.198-4.068,0.382-6.278,0.548c0.833-6.288,4.105-15.027,8.177-13.62C95.521,35.676,94.284,43.033,91.271,47.934 M86.106,52.264c-0.714,0.111-1.304,0.101-1.773,0.014c0.28-0.241,0.455-0.594,0.455-1.014c0-0.266,0.009-0.544,0.024-0.832c1.104-0.052,2.831-0.177,4.888-0.376C88.623,51.241,87.409,52.067,86.106,52.264 M111.223,37.314c2.598-2.413,3.89-2.237,4.231-1.589c0.736,1.403-2.325,6.345-8.184,9.047C107.774,42.114,109.176,39.216,111.223,37.314 M207.625,39.712c-0.251-4.887-4.579-5.683-5.176-4.293c-0.208,0.487,1.626,0.313,1.633,3.764c0.005,5.71-5.787,13.165-13.167,13.165c-8.04,0-10.114-6.254-10.502-9.348c-0.256-2.058,0.187-5.029-3.368-4.636c-2.486,0.28-4.733,5.12-7.885,9.196c-2.704,3.499-3.918,3.166-3.286,0.163c0.783-3.763,3.925-12.594,7.517-13.237c1.661-0.297,2.257,2.625,3.02,0.796c0.768-1.832,0.063-5.783-3.655-5.783c-2.605,0-5.73,2.762-8.292,5.905c-2.233,2.744-13.522,19.357-18.257,15.77c-2.215-1.676-2.035-8.506-0.643-16.553c5.618-2.167,10.292-1.456,12.936-0.188c1.305,0.626,1.485,0.532,0.929-0.903c-0.825-2.108-5.345-5.405-12.405-3.888c-0.17,0.033-0.336,0.079-0.505,0.119c0.569-2.613,1.231-5.268,1.954-7.849c0.661-2.364,2.6-6.454-2.462-7.242c-1.613-0.252-0.927,0.53-1.459,2.71c-0.978,4.015-2.214,9.227-3.109,14.458c-4.161,2.396-8.035,6.399-10.874,11.667c0.492-2.429,1.254-5.116,1.308-6.93c0.054-1.911-1.255-2.332-1.763-2.482c-1.111-0.314-2.453,0.236-3.776,2.106c-3.104,4.37-7.035,11.284-13.001,14.184c-4.28,2.081-6.157-0.015-6.262-3.238c0.845-0.259,1.601-0.525,2.24-0.813c7.756-3.437,10.419-8.621,8.448-11.774c-1.87-3-7.217-2.086-11.439,2.361c-2.081,2.193-3.684,5.956-3.871,9.387c-1.79,0.387-3.848,0.731-6.146,1.041c3.644-5.911,3.329-13.9-2.001-15.247c-6.182-1.561-9.309,4.44-10.633,9.436c0.408-4.996,1.206-11.077,2.335-16.725c0.472-2.361,2.087-6.455-3.041-7.24c-1.629-0.252-1.377,0.505-1.241,2.71c0.18,2.958-3.096,20.875-1.384,28.744c-2.206,0.714-3.101,2.375-0.264,4.127c1.955,1.203,6.258,1.603,10.605-0.537c1.559-0.771,2.909-1.854,4.034-3.125c2.59-0.326,5.314-0.744,7.796-1.241c0.425,3.45,2.677,6.095,7.905,5.606c7.433-0.691,14.035-9.826,16.528-14.226c-0.45,4.716-3.519,15.019,1.716,14.49c2.051-0.208,1.158-0.536,1.285-2.306c0.454-6.208,5.62-11.47,10.73-14.694c-0.887,7.602-0.579,14.391,2.868,16.546c6.341,3.963,15.326-6.477,20.27-12.862c-2.516,5.671-3.945,12.936-0.164,14.047c4.435,1.293,7.932-6.063,12.022-11.693c0.475,4.042,3.168,11.003,14.033,11.003C200.729,54.163,208.007,47.148,207.625,39.712 M51.101,52.114c-2.665-0.965-6.464-2.513-11.424-5.046c2.717-0.991,6.169-2.443,9.806-4.345C49.973,46.873,50.505,49.892,51.101,52.114M80.545,57.718c-0.125-0.258-0.849,0.105-1.587-0.003c-2.101-0.31-4.863-3.18-5.699-7.896c-1.504-8.489-0.612-16.865,1.88-29.348c0.47-2.361,2.084-6.451-3.041-7.243c-1.63-0.251-0.786,0.554-1.243,2.71c-1.971,9.297-9.574,15.999-17.207,20.493c-0.799-10.645-0.474-22.465,1.53-29.714c1.691-6.115,3.703-4.992,1.209-6.277c-2.624-1.352-5.445,0.435-7.726,4.989c-2.28,4.552-12.795,29.289-29.584,45.984c-8.592,8.545-16.363,4.146-17.919,2.831c-1.266-1.069-1.734,0.582-0.163,2.271c6.949,7.494,17.1,3.194,20.795-0.5c10.215-10.21,22.092-32.19,26.897-41.517c-0.443,5.251-0.593,14.058,0.385,24.379c-5.199,2.533-9.86,4.021-12.059,4.601c-2.381,0.624-3.854,1.593-3.898,2.697c-0.047,1.208,1.552,2.227,3.863,3.325c4.116,1.954,16.167,7.647,19.136,9.374c2.543,1.476,3.784,0.325,4.537-1.268c0.983-2.076-1.716-3.276-4.328-4.057c-1.006-3.495-1.81-8.196-2.345-13.377c6.126-3.772,12.158-8.793,15.635-15.068c-0.876,5.245-3.124,23.08,2.507,30.621c1.241,1.662,3.981,3.479,6.656,3.209C80.036,58.805,80.671,57.977,80.545,57.718"></path></svg></td><td style='text-align:left; padding:10px;'>
            <h2>Alberta</h2> <a href="https://www.alberta.ca/alberta-ca-account-available-services" target="_blank"><b>Account</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_AB' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_AB; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_AB' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_AB; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_AB' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_AB; ?>">
        </div>	<hr>	
        <!-- BC -->	
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/bc.png'></td><td style='text-align:left; padding:10px;'>
            <h2>Colombie-Britannique</h2> <a href="https://www2.gov.bc.ca/gov/content/governments/government-id/bcservicescardapp" target="_blank"><b>Services Card Login</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_BC' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_BC; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_BC' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_BC; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_BC' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_BC; ?>">
        </div>	<hr>
        <!-- NB -->	
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/nb.png'></td><td style='text-align:left; padding:10px;'>
            <h2>Nouveau-Brunswick</h2> <a href="https://www2.gnb.ca/content/gnb/en/gateways/for_business.html" target="_blank"><b>Business Information</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_NB' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_NB; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_NB' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_NB; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_NB' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_NB; ?>">
        </div><hr>
        <!-- NL Labrador -->
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/nl.svg'></td><td style='text-align:left; padding:10px;'>
            <h2>Terre-Neuve-et-Labrador</h2> <a href="https://www.gov.nl.ca/dgsnl/businesses/" target="_blank"><b>Information for Businesses</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_NL' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_NL; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_NL' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_NL; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_NL' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_NL; ?>">
        </div><hr>
        <!-- NS Nouvelle Écosse-->
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/NS.png'></td><td style='text-align:left; padding:10px;'>
            <h2>Nouvelle-Écosse</h2> <a href="https://novascotia.ca/sns/access/business.asp" target="_blank"><b>Services for Businesses</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_NS' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_NS; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_NS' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_NS; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_NS' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_NS; ?>">
        </div><hr>
        <!-- NT -->	
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/nt.png'></td><td style='text-align:left; padding:10px;'>
            <h2>Territoires du Nord-Ouest</h2> <a href="https://www.gov.nt.ca/en/service-directory/business-economy" target="_blank"><b>Business + Economy</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_NT' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_NT; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_NT' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_NT; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_NT' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_NT; ?>">
        </div>	<hr>
        <!-- NU -->	
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/nu.svg'></td><td style='text-align:left; padding:10px;'>
            <h2>Nunavut</h2> <a href="https://www.gov.nu.ca/en/business-and-entrepreneurship" target="_blank"><b>Business and Entrepreneurship</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_NU' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_NU; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_NU' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_NU; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_NU' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_NU; ?>">
        </div>	<hr>
        <!-- MB -->	
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/mb.jpg'></td><td style='text-align:left; padding:10px;'>
            <h2>Manitoba</h2> <a href="https://www.gov.mb.ca/business/startingsmart/index.html" target="_blank"><b>Start and Grow your Business</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_MB' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_MB; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_MB' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_MB; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_MB' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_MB; ?>">
        </div><hr>
        <!-- ON -->	
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/ontario.png'></td><td style='text-align:left; padding:10px;'>
            <h2>Ontario</h2> <a href="https://www.ontario.ca/page/ontario-business-registry" target="_blank"><b>Ontario Business Registry</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_ON' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_ON; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_ON' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_ON; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_ON' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_ON; ?>">
        </div><hr>
        <!-- PE -->	
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/PE.png'></td><td style='text-align:left; padding:10px;'>
            <h2>Île-du-Prince-Édouard</h2> <a href="https://www.princeedwardisland.ca/fr/entreprises" target="_blank"><b>Entreprises</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_PE' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_PE; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_PE' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_PE; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_PE' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_PE; ?>">
        </div><hr>

        <!-- QUEBEC -->	
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/quebec.svg'></td><td style='text-align:left; padding:10px;'>
            <h2>Québec</h2> <a href="https://www.quebec.ca/entreprises-et-travailleurs-autonomes/acceder-dossiers-entreprise/mon-bureau-registraire-entreprises/acceder" target="_blank"><b>Registre des entreprises</b>: <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
            <a href="https://entreprises.revenuquebec.ca/EntNa/SX/SX03/SX03B_01A_PIU_InscrireFichiersFiscaux/Vues/AvantCommencer/AvantCommencer.aspx?SVAR=01&CLNG=F" target="_blank"><b>Inscription à Revenu Québec</b>: <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
            <a href="https://www.revenuquebec.ca/fr/entreprises/mon-dossier-pour-les-entreprises/" target="_blank"><b>Mon Dossier Revenu Québec</b>: <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <br>Les dates d'échéances des déclarations de taxes trimestrielles sont le dernier jour du mois de janvier, avril, juillet et octobre.<br>
        <div class="divBOX">Numéro d'Entreprise Québec (NEQ):	
            <input id='cfgNEQ' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_NEQ; ?>" onclick="showPW(event,this);">
        </div>	
        <div class="divBOX">Numéro de Taxe de Vente Québec (TVQ):  
            <input id='cfgTVQ' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_TVQ; ?>" onclick="showPW(event,this);">
        </div>	
        <div class="divBOX">Numéro de RBQ:
            <input id='cfgRBQ' autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" type="password" value="<?php echo $CIE_RBQ; ?>" onclick="showPW(event,this);">
        </div>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_QC' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_QC; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_QC' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_QC; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_QC' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_QC; ?>">
        </div>	<hr>
        <!-- SK -->	
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/sk.png'></td><td style='text-align:left; padding:10px;'>
            <h2>Saskatchewan</h2> <a href="https://www.saskatchewan.ca/business" target="_blank"><b>Business and Industry</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TPS actuel:</span>
            <input id='cfgTPS_SK' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TPS_SK; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVP actuel:</span>
            <input id='cfgTVP_SK' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_SK; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_SK' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_SK; ?>">
        </div>	<hr>
        <!-- YT -->		
        <table style='width:90%;display:inline-block;'><tr><td width="200px"><img style="width:150px;" src='/pub/img/dw3/yt.png'></td><td style='text-align:left; padding:10px;'>
            <h2>Yukon</h2> <a href="https://yukon.ca/en/doing-business" target="_blank"><b>Doing business</b> <span class='material-icons' style='color:lightblue;'>arrow_outward</span></a><br style='margin:3px;'>
        </td></tr></table>
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;width:200px;width:200px;'>%TPS actuel:</span>
            <input id='cfgTPS_YT' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001" value="<?php echo $TPS_YT; ?>">
        </div>		
        <div class="divBOX" style="width:200px;"><span style='vertical-align:middle;padding:5px;width:200px;'>%TVP actuel:</span>
            <input id='cfgTVP_YT' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVP_YT; ?>">
        </div>		
        <div class="divBOX" style="width:200px;" style="width:200px;"><span style='vertical-align:middle;padding:5px;'>%TVH actuel:</span>
            <input id='cfgTVH_YT' style="background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;" type="number" required min="0.000" max="100" step="0.001"  value="<?php echo $TVH_YT; ?>">
        </div>	

        <br><br><button onclick="saveGOUV();"><span class="material-icons">save</span>Sauvegarder</button>
    </div>
</div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';

$(document).ready(function (){
    document.getElementById('config_select').value="/app/config/config_4_gouv.php";
});

window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    window.location.reload();
  }
});

function saveGOUV(){
	var sTPS   = document.getElementById("cfgTPS").value;
	var sTVQ   = document.getElementById("cfgTVQ").value;
	var sNEQ   = document.getElementById("cfgNEQ").value;
	var sNE   = document.getElementById("cfgNE").value;
	var sRBQ   = document.getElementById("cfgRBQ").value;

	var sTPS_YT   = document.getElementById("cfgTPS_YT").value;
	var sTVP_YT   = document.getElementById("cfgTVP_YT").value;
	var sTVH_YT   = document.getElementById("cfgTVH_YT").value;
	var sTPS_QC   = document.getElementById("cfgTPS_QC").value;
	var sTVP_QC   = document.getElementById("cfgTVP_QC").value;
	var sTVH_QC   = document.getElementById("cfgTVH_QC").value;
	var sTPS_SK   = document.getElementById("cfgTPS_SK").value;
	var sTVP_SK   = document.getElementById("cfgTVP_SK").value;
	var sTVH_SK   = document.getElementById("cfgTVH_SK").value;
	var sTPS_PE   = document.getElementById("cfgTPS_PE").value;
	var sTVP_PE   = document.getElementById("cfgTVP_PE").value;
	var sTVH_PE   = document.getElementById("cfgTVH_PE").value;
	var sTPS_ON   = document.getElementById("cfgTPS_ON").value;
	var sTVP_ON   = document.getElementById("cfgTVP_ON").value;
	var sTVH_ON   = document.getElementById("cfgTVH_ON").value;
	var sTPS_MB   = document.getElementById("cfgTPS_MB").value;
	var sTVP_MB   = document.getElementById("cfgTVP_MB").value;
	var sTVH_MB   = document.getElementById("cfgTVH_MB").value;
	var sTPS_NU   = document.getElementById("cfgTPS_NU").value;
	var sTVP_NU   = document.getElementById("cfgTVP_NU").value;
	var sTVH_NU   = document.getElementById("cfgTVH_NU").value;
	var sTPS_NL   = document.getElementById("cfgTPS_NL").value;
	var sTVP_NL   = document.getElementById("cfgTVP_NL").value;
	var sTVH_NL   = document.getElementById("cfgTVH_NL").value;
	var sTPS_NS   = document.getElementById("cfgTPS_NS").value;
	var sTVP_NS   = document.getElementById("cfgTVP_NS").value;
	var sTVH_NS   = document.getElementById("cfgTVH_NS").value;
	var sTPS_NT   = document.getElementById("cfgTPS_NT").value;
	var sTVP_NT   = document.getElementById("cfgTVP_NT").value;
	var sTVH_NT   = document.getElementById("cfgTVH_NT").value;
	var sTPS_NB   = document.getElementById("cfgTPS_NB").value;
	var sTVP_NB   = document.getElementById("cfgTVP_NB").value;
	var sTVH_NB   = document.getElementById("cfgTVH_NB").value;
	var sTPS_BC   = document.getElementById("cfgTPS_BC").value;
	var sTVP_BC   = document.getElementById("cfgTVP_BC").value;
	var sTVH_BC   = document.getElementById("cfgTVH_BC").value;
	var sTPS_AB   = document.getElementById("cfgTPS_AB").value;
	var sTVP_AB   = document.getElementById("cfgTVP_AB").value;
	var sTVH_AB   = document.getElementById("cfgTVH_AB").value;
    
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updGOUV.php?KEY=' + KEY  
										+ '&TPS=' + encodeURIComponent(sTPS)     
										+ '&TVQ=' + encodeURIComponent(sTVQ)   
										+ '&NEQ=' + encodeURIComponent(sNEQ) 
										+ '&NE=' + encodeURIComponent(sNE) 
										+ '&RBQ=' + encodeURIComponent(sRBQ) 
										+ '&TPS_YT=' + encodeURIComponent(sTPS_YT) 
										+ '&TVP_YT=' + encodeURIComponent(sTVP_YT) 
										+ '&TVH_YT=' + encodeURIComponent(sTVH_YT) 
										+ '&TPS_QC=' + encodeURIComponent(sTPS_QC) 
										+ '&TVP_QC=' + encodeURIComponent(sTVP_QC) 
										+ '&TVH_QC=' + encodeURIComponent(sTVH_QC) 
										+ '&TPS_SK=' + encodeURIComponent(sTPS_SK) 
										+ '&TVP_SK=' + encodeURIComponent(sTVP_SK) 
										+ '&TVH_SK=' + encodeURIComponent(sTVH_SK) 
										+ '&TPS_PE=' + encodeURIComponent(sTPS_PE) 
										+ '&TVP_PE=' + encodeURIComponent(sTVP_PE) 
										+ '&TVH_PE=' + encodeURIComponent(sTVH_PE) 
										+ '&TPS_ON=' + encodeURIComponent(sTPS_ON) 
										+ '&TVP_ON=' + encodeURIComponent(sTVP_ON) 
										+ '&TVH_ON=' + encodeURIComponent(sTVH_ON) 
										+ '&TPS_MB=' + encodeURIComponent(sTPS_MB) 
										+ '&TVP_MB=' + encodeURIComponent(sTVP_MB) 
										+ '&TVH_MB=' + encodeURIComponent(sTVH_MB) 
										+ '&TPS_NU=' + encodeURIComponent(sTPS_NU) 
										+ '&TVP_NU=' + encodeURIComponent(sTVP_NU) 
										+ '&TVH_NU=' + encodeURIComponent(sTVH_NU) 
										+ '&TPS_NL=' + encodeURIComponent(sTPS_NL) 
										+ '&TVP_NL=' + encodeURIComponent(sTVP_NL) 
										+ '&TVH_NL=' + encodeURIComponent(sTVH_NL) 
										+ '&TPS_NS=' + encodeURIComponent(sTPS_NS) 
										+ '&TVP_NS=' + encodeURIComponent(sTVP_NS) 
										+ '&TVH_NS=' + encodeURIComponent(sTVH_NS) 
										+ '&TPS_NT=' + encodeURIComponent(sTPS_NT) 
										+ '&TVP_NT=' + encodeURIComponent(sTVP_NT) 
										+ '&TVH_NT=' + encodeURIComponent(sTVH_NT) 
										+ '&TPS_NB=' + encodeURIComponent(sTPS_NB) 
										+ '&TVP_NB=' + encodeURIComponent(sTVP_NB) 
										+ '&TVH_NB=' + encodeURIComponent(sTVH_NB) 
										+ '&TPS_BC=' + encodeURIComponent(sTPS_BC) 
										+ '&TVP_BC=' + encodeURIComponent(sTVP_BC) 
										+ '&TVH_BC=' + encodeURIComponent(sTVH_BC) 
										+ '&TPS_AB=' + encodeURIComponent(sTPS_AB) 
										+ '&TVP_AB=' + encodeURIComponent(sTVP_AB) 
										+ '&TVH_AB=' + encodeURIComponent(sTVH_AB),
										true);
		xmlhttp.send();
}



</script>
</body>
</html>
<?php $dw3_conn->close();exit(); ?>