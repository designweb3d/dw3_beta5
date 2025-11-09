<?php
header("X-Robots-Tag: noindex, nofollow", true);
$REDIR = "<html><head><title>Redirected</title><meta http-equiv=\"refresh\" content=\"0;URL='https://" . $_SERVER["SERVER_NAME"] . "'\"></head></html>";  

$key_code  = $_GET['K'];
if ($key_code != "2G356J5464E357S346N45L73P564R73"){
    die($REDIR);
}

date_default_timezone_set('America/New_York');
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");
if ($dw3_conn->connect_error) {
    $dw3_conn->close();
    die($REDIR);
}	

$page_id  = $_GET['P'];
$comment_id  = $_GET['C'];
$approved  = $_GET['AA'];
$article_id  = $_GET['A'];

if($approved == "YES"){
    $sql = "UPDATE article_comment SET verified = 1 WHERE id = ".$comment_id." LIMIT 1;";
    $html = "Commentaire approuvé.";
} else if ($approved == "NO"){
    $sql = "DELETE FROM article_comment WHERE id = ".$comment_id." LIMIT 1;";
    $html = "Commentaire supprimé.";
}

$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $eml_to = trim($row["text1"]);
    }
} else {
    $eml_to = 'info@'.$_SERVER['SERVER_NAME'];
}
$dw3_conn->close();
?><!DOCTYPE html>
<html><head>
	<meta charset="utf-8">
	<title><?php echo $CIE_NOM; ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Orelega+One&family=Roboto:wght@100&display=swap" rel="stylesheet">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<meta name="msapplication-TileImage" content="https://dw3.ca/img/favicon.ico" />
    <link rel="icon" type="image/png" href="/pub/img/favicon.ico">
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/index.css.php'; ?>
</style></head><body style='text-align:center;'>
<div id="divHEAD" style='left:0px;border-radius:0px;height:40px;background:rgba(0,0,0,0.8);color:#fff;'>
	<table width="100%"><tr>
		<td onclick="window.open('https://<?php echo $_SERVER["SERVER_NAME"]; ?>','_self');" style="text-align:center;vertical-align:middle;cursor:pointer;">
            <img src="/pub/img/<?php echo $CIE_LOGO3; ?>" style="vertical-align:middle;height:32px;width:auto;"> <?php echo $CIE_NOM; ?>
        </td>
		<td width="30" onclick="window.open('https://<?php echo $_SERVER["SERVER_NAME"]; ?>/client','_self');" style="vertical-align:middle;text-align:center;cursor:pointer;background-color:#eee;border-radius:10px;"> 
            <span id="dw3_lang_span" class="material-icons" style="cursor:pointer;font-size:24px;color:#333;">login</span>
        </td>
	</tr></table>
</div>
<div class='divMAIN' style='background:rgba(0,0,0,0.8);color:#fff;line-height:2;box-shadow:3px 3px 6px 2px #333;width:auto;padding:10px 0px;position:fixed;top: 50%;left: 50%;-moz-transform: translateX(-50%) translateY(-50%);-webkit-transform: translateX(-50%) translateY(-50%);transform: translateX(-50%) translateY(-50%);min-width:350px;border-style: double;border:1px solid #777;border-radius:20px;'>  
    <br>
    <?php 
    echo "<div class='divBOX' style='font-size:0.8em;max-width:400px;'>" . $html . "<br><a href='https://".$_SERVER["SERVER_NAME"]."/pub/page/article/article.php?ID=".$article_id."&P1=".$page_id."'>Lien vers l'article</a></div>";
    ?>
</div>
</body></html>