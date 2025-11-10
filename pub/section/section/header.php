<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<title><?php echo $CIE_NOM; ?></title>
	<script src="https://d3js.org/d3.v7.min.js"></script>	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Orelega+One&family=Roboto:wght@100&display=swap" rel="stylesheet">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
 
	<meta name="msapplication-TileImage" content="https://<?php echo $_SERVER['SERVER_NAME']; ?>/pub/img/favicon.png" />
    <link rel="icon" type="image/png" href="/pub/img/favicon.png">
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/index.css.php'; ?>
    </style>
</head>
<body>
    <div id="dw3_head">
        <img id="imgLOGO" src="/pub/img/logo2.png?t=<?php echo(rand(100,100000)); ?>" style="vertical-align:middle;height:40px;width:auto;">
                <?php echo $CIE_NOM_HTML; ?>
    </div>
