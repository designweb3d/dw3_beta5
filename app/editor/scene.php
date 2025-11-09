<?php
//require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'fr_CA');
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$today = date("Y-m-d");
$time = date("H:i:s");
$datetime = date("Y-m-d H:i:s");  
$dw3_conn->set_charset('utf8mb4');

	if ($dw3_conn->connect_error) {
		$dw3_conn->close();
		die("");
	}
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/env_var.php';

//require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php'; 
$SCENE_ID  = $_GET['SCENE_ID'];

$sql = "SELECT * FROM scene WHERE id = '" . $SCENE_ID . "';";
$result = mysqli_query($dw3_conn, $sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $SCENE_NAME = $row["name_fr"];
        $SCENE_BG   = $row["bg_filename"];
        $SCENE_DESC = $row["description_fr"];
    }
} else {
    $SCENE_NAME = "Ocean";
    $SCENE_BG   = "";
    $SCENE_DESC = "Éditeur 3D";
}
?>
<!DOCTYPE html><html lang="fr-CA"><head><meta charset="utf-8">
	<script src="/pub/js/jquery-3.7.1.min.js"></script>
	<meta name="viewport" content="width=device-width, viewport-fit=cover, user-scalable=no, shrink-to-fit=no, initial-scale=1.0, maximum-scale=1.0" />
	<meta name="msapplication-TileImage" content="<?php echo $domain_path; ?>pub/img/favicon.ico" />
    <script type="importmap">{"imports": {"three": "/api/three.js/build/three.module.js","three/addons/": "./jsm/"}}</script>
    <script async src="https://unpkg.com/es-module-shims@1.3.6/dist/es-module-shims.js"></script>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/main.css.php'; ?>
</style>   
</head>
<body>


<div id='scene_container'></div>

<script>  
var KEY = '<?php echo($KEY); ?>';
</script>
<?php echo "<script type='module' src='/pub/scene/Editor/editor.js.php?ID=". $SCENE_ID ."' data-bg3='/pub/img/". $SCENE_BG ."'></script>"; ?>
</body>
</html>
