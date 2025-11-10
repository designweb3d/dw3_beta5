<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$ID = $_GET['A'];
$page_id = $_GET['P'];
$comment = str_replace("'","’", $_GET['C']);

if ($USER_TYPE == "user"){
    $sql = "INSERT INTO article_comment (article_id,user_id,comment,verified,date_created) 
    VALUES ('" . $ID  . "','" . $USER_ID  . "','" . $comment  . "','1','" . $datetime  . "')";
} else {
    $sql = "INSERT INTO article_comment (article_id,customer_id,comment,date_created) 
    VALUES ('" . $ID  . "','" . $USER_ID  . "','" . $comment  . "','" . $datetime  . "')"; 
}
if ($dw3_conn->query($sql) === TRUE) {
    $new_comment_id = $dw3_conn->insert_id;
    echo "Le commentaire sera vérifié et mis en ligne bientôt.";
} else {
    //echo "Erreur: " . $sql;
    echo "Erreur: caractère non valide.";
}

if ($USER_TYPE == "customer"){
    $sql = "SELECT title_fr as article_name FROM article WHERE id = '" . $ID . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $article_name = $data['article_name'];
    $sql = "SELECT * FROM customer WHERE id = '" . $USER_ID . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);

    $subject = "Commentaire à approuver pour article #".$ID;
    $htmlContent = "<br><table style='width:100%;font-size:10px;'><tr>
        </tr><tr><td colspan='2' style='text-align:center;'><h2>".$article_name."</h2></td></tr>
        <td width='50%' style='text-align:center;font-size:20px;'><a style='color:green;border:1px solid darkgrey;border-radius:5px;padding:10px;background:lightgrey;' href='https://".$_SERVER["SERVER_NAME"]."/sbin/approveART_COMMENT.php?K=2G356J5464E357S346N45L73P564R73&A=".$ID."&C=".$new_comment_id."&AA=YES&P=".$page_id."'><b>Approuver</b></a></td>
        <td width='50%' style='text-align:center;font-size:20px;'><a style='color:red;border:1px solid darkgrey;border-radius:5px;padding:10px;background:lightgrey;'  href='https://".$_SERVER["SERVER_NAME"]."/sbin/approveART_COMMENT.php?K=2G356J5464E357S346N45L73P564R73&A=".$ID."&C=".$new_comment_id."&AA=NO&P=".$page_id."'><b>Supprimer</b></a></td>
        </tr><tr><td colspan='2' style='text-align:left;border:1px solid grey;padding:15px 10px;'>".$comment."</td></tr>
        </tr><tr><td colspan='2' style='text-align:left;'>Par: ".$data['user_name']." - ".dw3_decrypt($data['first_name'])." ".dw3_decrypt($data['last_name'])."</td></tr>
        </table>
    </body>
    </html>";
    $email = new PHPMailer();
    $email->CharSet = "UTF-8";
    $email->SetFrom('no-reply@'.$_SERVER["SERVER_NAME"],$CIE_NOM); 
    $email->Subject   = $subject;
    $email->Body      = $htmlContent;
    $email->IsHTML(true); 
        if (trim($CIE_EML4) == ""){
            $email->AddAddress($CIE_EML1);
        } else {
            $email->AddAddress($CIE_EML4);
        }
    // $file_to_attach = $_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $enID . ".pdf";
    // $email->AddAttachment( $file_to_attach , $enID . '.pdf' );
    $mail_ret = $email->Send();
    if (!$mail_ret){}
}

$dw3_conn->close();
?>