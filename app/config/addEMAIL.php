<?php 
exit;
//require_once $_SERVER['DOCUMENT_ROOT'] . '/security.php';
// Instantiate the CPANEL object.
require_once "/usr/local/cpanel/php/cpanel.php";

$cpanel = new CPANEL(); // Connect to cPanel - only do this once.
  
// Create the user@example.com email address.
$new_email = $cpanel->uapi(
    'Email', 'add_pop',
    array(
        'email'           => 'new_email',
        'password'        => 'my_s3cr3t_p0p!p4sswd',
        'quota'           => '0',
        'domain'          => '.ca',
        'skip_update_db'  => '1',
        )
);


echo $new_email;
header('Status: 200');
//$dw3_conn->close();
exit;
?>
