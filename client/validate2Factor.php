<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$CODE = $_GET['CODE']; 
$sql = "SELECT * FROM customer WHERE key_128 = '" . $KEY . "' LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $date1=date_create(date("Y-m-d H:i:s"));
        $date2=date_create($row["two_factor_expire"]);
        $diff=date_diff($date1,$date2);
        $num_minutes = (int) $diff->format("%i");
        if ($num_minutes > 21){
            $dw3_conn->close();
            die("expired".$num_minutes);
        }
        if ($CODE!=$row["two_factor_code"]){
            $dw3_conn->close();
            die("invalid");
        }
        $KEY = generateRandomString(128) ;
        $sql2 = "UPDATE customer SET key_128='".$KEY."',two_factor_valid='1',two_factor_expire=CURRENT_TIMESTAMP()  WHERE id='".$USER."' LIMIT 1";
        if ($dw3_conn->query($sql2) === FALSE) {
            $dw3_conn->close();
            die("err2");
        }else {
            $dw3_conn->close();
            die("/client/dashboard.php?KEY=".$KEY) ;
        }
    }
} else {
    $dw3_conn->close();
    die("err1");
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>