<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$COUPON = $_GET['C'];

$sql = "SELECT * FROM coupon WHERE UCASE(trim(code)) = '" . strtoupper(trim($COUPON)) . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if (isset($data["id"])){
    $date_start = new DateTime($data["date_start"]);
    $date_end = new DateTime($data["date_end"]);
    $now = new DateTime();
    if ($date_start > $now){
        if ($USER_LANG == "FR"){
            echo "Le coupon sera valide le ".substr($data['date_start'],0,10). " à " . substr($data['date_start'],11,8);
        } else {
            echo "The coupon will be valid on ".substr($data['date_start'],0,10). " at " . substr($data['date_start'],11,8);
        }
    } else if ($date_end < $now){
        if ($USER_LANG == "FR"){
            echo "Le coupon a expiré le ".substr($data['date_end'],0,10) . " à " . substr($data['date_end'],11,8);
        } else {
            echo "The coupon expired on ".substr($data['date_end'],0,10) . " at " . substr($data['date_end'],11,8);
        }
    } else {
        //set cookie for coupon
        $cookie_name = "COUPON";
        $cookie_value = $COUPON;
        $cookie_domain = $_SERVER["SERVER_NAME"];
        setcookie($cookie_name, $cookie_value, [
            'expires' => time() + 86400,
            'path' => '/',
            'domain' => $cookie_domain,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None',
        ]);
    }
} else {
    if ($USER_LANG == "FR"){
        echo "Code de coupon invalide.";
    } else {
        echo "Invalid coupon code.";
    }
}
?>