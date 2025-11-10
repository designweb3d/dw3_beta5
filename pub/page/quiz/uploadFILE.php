<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$user_eml = $_GET['eml']??'';
$new_name = $_GET['t']??'';
$quiz_id = $_GET['q']??'';
$user_type = '';
$user_id = '';

    //get user folder
    $sql = "SELECT id FROM customer WHERE eml1 = '" . dw3_crypt(trim(strtolower($user_eml))) . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    if ($result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result);
        $user_id = $data['id'];
        $user_type = 'customer';
    } else {
        $sql = "SELECT id FROM user WHERE eml1 = '" . trim(strtolower($user_eml)) . "' OR eml2 = '" . trim(strtolower($user_eml)) . "' OR eml3 = '" . trim(strtolower($user_eml)) . "' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);
        if ($result->num_rows > 0) {
            $data = mysqli_fetch_assoc($result);
            $user_id = $data['id'];
            $user_type = 'user';
        } else {
            $sql = "SELECT * FROM prototype_head WHERE id = '" . $quiz_id . "';";
            $result = mysqli_query($dw3_conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $user_type = $data["parent_table"];
        }
    }
if(isset($_FILES['sample_image']))
{
/* 	$extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);
	$new_name = $timeNow . '.' . $extension; */
    if($user_type == 'customer'){
        if ($user_id !=''){
            move_uploaded_file($_FILES['sample_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/fs/customer/' . $user_id .'/'. $new_name);
        } else {
            move_uploaded_file($_FILES['sample_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/fs/customer/upload/'. $new_name);
        }
    } else if ($user_type == 'user') {
        if ($user_id !=''){
            move_uploaded_file($_FILES['sample_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/fs/user/' . $user_id .'/'. $new_name);
        } else {
            move_uploaded_file($_FILES['sample_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/fs/user/upload/'. $new_name); 
        }
    } else {
        move_uploaded_file($_FILES['sample_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/fs/upload/' . $new_name);
    }
	//$data = array('image_source'	=>	'/fs/upload/' . $new_name);
	//echo json_encode($data);
}
$dw3_conn->close();
exit; 
?>