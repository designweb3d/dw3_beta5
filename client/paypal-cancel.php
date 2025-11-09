<?php
$KEY = $_GET['KEY']??"";
header("HTTP/1.1 303 See Other");
header("Location: dashboard.php?KEY=". $KEY. "&PAYPAL_RESULT=cancel");
?>