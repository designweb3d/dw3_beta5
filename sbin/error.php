<?php
$err_num   = $_GET['e']??"";
/** DW3 Platform BETA5
/*+---------------------------------------------------------------------------------+
  | DW3 Platform BETA                                                               |
  | Version 5                                                                       |
  |                                                                                 | 
  |  The MIT License                                                                |
  |  Copyright © 2025 Design Web 3D                                                 | 
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
 date_default_timezone_set('America/New_York');
 $remote_ip = $_SERVER['REMOTE_ADDR'];
 $today = date("Y-m-d");
 $time = date("H:i:s");
 $datetime = date("Y-m-d H:i:s");
 
switch ($err_num) {
	case "203": $err_desc = "NON_AUTHORITATIVE";http_response_code(203);break;
	case "204": $err_desc = "NO_CONTENT";http_response_code(204);break;
	case "205": $err_desc = "RESET_CONTENT";http_response_code(205);break;
	case "206": $err_desc = "PARTIAL_CONTENT";http_response_code(206);break;
	case "207": $err_desc = "MULTI_STATUS";http_response_code(207);break;
	case "300": $err_desc = "MULTIPLE_CHOICES";http_response_code(300);break;                            
	case "301": $err_desc = "MOVED_PERMANENTLY";http_response_code(301);break;                            
	case "302": $err_desc = "MOVED_TEMPORARILY";http_response_code(302);break;                            
	case "303": $err_desc = "SEE_OTHER";http_response_code(303);break;                            
	case "304": $err_desc = "NOT_MODIFIED";http_response_code(304);break;                            
	case "305": $err_desc = "USE_PROXY";http_response_code(305);break;                            
	case "307": $err_desc = "TEMPORARY_REDIRECT";http_response_code(307);break;                            
	case "400": $err_desc = "BAD_REQUEST";http_response_code(400);break;                            
	case "401": $err_desc = "UNAUTHORIZED";http_response_code(401);break;                            
	case "402": $err_desc = "PAYMENT_REQUIRED";http_response_code(402);break;                            
	case "403": $err_desc = "FORBIDDEN";http_response_code(403);break;                            
	case "404": $err_desc = "NOT_FOUND";http_response_code(404);break;                            
	case "405": $err_desc = "METHOD_NOT_ALLOWED";http_response_code(405);break;                            
	case "406": $err_desc = "NOT_ACCEPTABLE";http_response_code(406);break;                            
	case "407": $err_desc = "PROXY_AUTHENTICATION_REQUIRED";http_response_code(407);break;                            
	case "408": $err_desc = "REQUEST_TIME_OUT";http_response_code(408);break;                            
	case "409": $err_desc = "CONFLICT";http_response_code(409);break;                            
	case "410": $err_desc = "GONE";http_response_code(410);break;                            
	case "411": $err_desc = "LENGTH_REQUIRED";http_response_code(411);break;                            
	case "412": $err_desc = "PRECONDITION_FAILED";http_response_code(412);break;                            
	case "413": $err_desc = "REQUEST_ENTITY_TOO_LARGE";http_response_code(413);break;                            
	case "414": $err_desc = "REQUEST_URI_TOO_LARGE";http_response_code(414);break;                            
	case "415": $err_desc = "UNSUPPORTED_MEDIA_TYPE";http_response_code(415);break;                            
	case "416": $err_desc = "RANGE_NOT_SATISFIABLE";http_response_code(416);break;                            
	case "417": $err_desc = "EXPECTATION_FAILED";http_response_code(417);break;                            
	case "422": $err_desc = "UNPROCESSABLE_ENTITY";http_response_code(422);break;                            
	case "423": $err_desc = "LOCKED";http_response_code(423);break;                            
	case "424": $err_desc = "FAILED_DEPENDENCY";http_response_code(424);break;                            
	case "426": $err_desc = "UPGRADE_REQUIRED";http_response_code(426);break;                            
	case "500": $err_desc = "INTERNAL_SERVER_ERROR";http_response_code(500);exit();break;                            
	case "501": $err_desc = "NOT_IMPLEMENTED";http_response_code(501);break;                            
	case "502": $err_desc = "BAD_GATEWAY";http_response_code(502);break;                            
	case "503": $err_desc = "SERVICE_UNAVAILABLE";http_response_code(503);break;                            
	case "504": $err_desc = "GATEWAY_TIME_OUT";http_response_code(504);break;                            
	case "505": $err_desc = "VERSION_NOT_SUPPORTED";http_response_code(505);break;                            
	case "506": $err_desc = "VARIANT_ALSO_VARIES";http_response_code(506);break;                            
	case "507": $err_desc = "INSUFFICIENT_STORAGE";http_response_code(507);break;                            
	case "510": $err_desc = "NOT_EXTENDED";http_response_code(510);break;                            
    default:      $err_desc = " UNKNOWN_ERROR";break;
}
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");
if ($dw3_conn->connect_error) {
    $dw3_conn->close();
    $CIE_EML1 = 'info@dw3.ca';
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/env_var.php';
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/pub/section/header.php";
?>
<!-- MAIN -->
<div style='background-image: linear-gradient(to right, transparent, rgba(0,0,0,0.7), rgba(0,0,0,0.85), rgba(0,0,0,0.7),transparent);min-height:100vh;width:100vw;text-align:center;padding:20px;line-height:1.5em;color:#eee;'>
    <!-- ERROR -->
    <div style="    position: fixed;width:100%;    top: 50%;    left: 0%;    -moz-transform: translateY(-50%);    -webkit-transform: translateY(-50%);    transform:  translateY(-50%);">
        <br>
        Erreur #<b><?php echo $err_num; ?></b>
        <br><hr style='margin:15px 0px;height: 1px;border: none;background: -webkit-gradient(linear, 0 0, 100% 0, from(transparent), to(transparent), color-stop(50%,  #f17144));'>
        <div style='font-size:36px;font-weight:bold;text-align:center;'>
        <?php echo $err_desc; ?>
        </div><hr style='margin:15px 0px;height: 1px;border: none;background: -webkit-gradient(linear, 0 0, 100% 0, from(transparent), to(transparent), color-stop(50%,  #f17144));'>
        <br><div style='background-image: linear-gradient(to right, transparent, rgba(200,200,200,0.85), rgba(200,200,200,0.95), rgba(200,200,200,0.85),transparent);color:#333;font-weight:bold;padding:30px 0px;'><div>Redirection vers la page d'accueil dans <b><span id='count_down'>7</span></b> secondes:<br><a href='https://<?php echo $_SERVER["SERVER_NAME"]; ?>' target='_self'>https://<?php echo $_SERVER["SERVER_NAME"]; ?></a></div>
        <br> 
        <progress value="0" max="7" id="progressBar"></progress>
        <br></div>
        <br>If the problem persist please contact the system administrator.<u> 
            <br><a href='mailto:<?php echo $CIE_EML1; ?>'><?php echo $CIE_EML1; ?></a></u>
        <br> 
    </div>
</div>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/pub/section/footer.php";
?>    
<script>

var timeleft = 7;
var downloadTimer = setInterval(function(){
    timeleft -= 1;
  document.getElementById("progressBar").value = 7 - timeleft;
  document.getElementById('count_down').innerHTML = timeleft;
  if(timeleft < 1){
    clearInterval(downloadTimer);
    window.open("https://<?php echo $_SERVER["SERVER_NAME"]; ?>","_self");
  }
}, 1000);

</script>
</body>
</html>