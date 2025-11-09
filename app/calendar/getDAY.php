<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$that_date  = mysqli_real_escape_string($dw3_conn, $_GET['D']);
$dspUser  = $_GET['DU'];
$dspCustomer  = $_GET['DC'];
$dspEvent  = $_GET['E'];
$dspEmail  = $_GET['A'];
$dspOrder  = $_GET['O'];
$dspSH  = $_GET['SH'];
$dspSL  = $_GET['SL'];
$dspTask  = $_GET['T']??'';
$dspNewCustomer  = $_GET['NC'];

if ($dspUser == ""){$dspUser = "ALL";}
if ($dspCustomer == ""){$dspCustomer = "ALL";}

//EVENT
if ($dspEvent=="true"){
    $sql = "SELECT COUNT(*) as counter FROM event WHERE SUBSTRING(date_start,1,10) = '".$that_date."'; ";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    if ($data['counter'] > 0){
        echo "<div class='divPAGE' style='background:rgba(255,255,255,0.7);'><h4>Évenements (<b>".$data['counter']."</b>)</h4>";
        $sql2="SELECT * FROM event WHERE SUBSTRING(date_start,1,10) = '".$that_date."'; ";
        $result = $dw3_conn->query($sql2);
        if ($result->num_rows > 0) {	
            echo "<table class='tblSEL'><tr><th>ID</th><th>Description</th><th style='text-align:center;'>Heure</th></tr>";
            while($row = $result->fetch_assoc()) {  
                echo "<tr><td>".$row["id"]."</td><td>".$row["event_type"]." - ".$row["name"]."</td><td style='text-align:center;'>".substr($row["date_start"],11,8)."</td></tr>";
            }   
            echo "</table>";
        }       
        echo "</div>";         
    }
}

//EMAILs DISABLED FOR NOW 
//if ($dspEmail=="true"){
/*     $sql = "SELECT COUNT(*) as counter FROM email WHERE SUBSTRING(date_created,1,10) = '".$that_date."'; ";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    if ($data['counter'] > 0){
        echo "<div class='divPAGE' style='background:rgba(255,255,255,0.7);'><h4>Courriels (<b>".$data['counter']."</b>)</h4>";
        $sql2="SELECT * FROM email WHERE SUBSTRING(date_created,1,10) = '".$that_date."'; ";
        $result = $dw3_conn->query($sql2);
        if ($result->num_rows > 0) {	
            echo "<table class='tblSEL'><tr><th>ID</th><th>Description</th><th style='text-align:center;'>Heure</th></tr>";
            while($row = $result->fetch_assoc()) {  
                echo "<tr><td>".$row["id"]."</td><td>".$row["box"]." ".$row["head_from"]." - ".$row["subject"]."</td><td style='text-align:center;'>".substr($row["date_created"],11,8)."</td></tr>";
            } 
            echo "</table>";
    
        }       
        echo "</div>";        
    } */
//}

//ORDER
if ($dspOrder=="true"){
    $sql = "SELECT COUNT(*) as counter FROM order_head WHERE SUBSTRING(date_created,1,10) = '".$that_date."'; ";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    if ($data['counter'] > 0){
        echo "<div class='divPAGE' style='background:rgba(255,255,255,0.7);'><h4>Commandes (<b>".$data['counter']."</b>)</h4>";
        $sql2="SELECT A.id as order_id, A.adr1 as adr1, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name,D.name as user_face,D.picture_url as user_pic,D.picture_type as user_pic_type, A.customer_id, CONCAT(B.first_name, ' ',B.last_name) as customer_name,A.date_created as start_date, A.date_created as end_date
        FROM order_head A
        LEFT JOIN customer B ON B.id = A.customer_id
        LEFT JOIN user D ON D.id = A.user_id WHERE SUBSTRING(A.date_created,1,10) = '".$that_date."'; ";
        $result = $dw3_conn->query($sql2);
        if ($result->num_rows > 0) {	
            echo "<table class='tblSEL'><tr><th>ID</th><th>Description</th><th style='text-align:center;'>Heure</th></tr>";
            while($row = $result->fetch_assoc()) {  
                echo "<tr><td>".$row["id"]."</td><td>".dw3_decrypt($row["customer_name"])." - ".dw3_decrypt($row["adr1"])."</td><td style='text-align:center;'>".substr($row["start_date"],11,8)."</td></tr>";
            }   
            echo "</table>";

        }       
        echo "</div>";        
    }
}

//SCHEDULE_HEAD
if ($dspSH=="true"){
    $sql = "SELECT COUNT(*) as counter FROM schedule_head WHERE SUBSTRING(start_date,1,10) = '".$that_date."'; ";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    if ($data['counter'] > 0){
        echo "<div class='divPAGE' style='background:rgba(255,255,255,0.7);'><h4>Plages horaires (<b>".$data['counter']."</b>)</h4>";
        $sql2="SELECT A.id as schedule_id,A.description as description, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name,D.name as user_face,D.picture_url as user_pic,D.picture_type as user_pic_type, A.start_date as start_date, A.end_date
        FROM schedule_head A
        LEFT JOIN user D ON D.id = A.user_id WHERE SUBSTRING(start_date,1,10) = '".$that_date."'; ";
        $result = $dw3_conn->query($sql2);
        if ($result->num_rows > 0) {	
            echo "<table class='tblSEL'><tr><th>ID</th><th>Description</th><th style='text-align:center;'>Heure</th></tr>";
            while($row = $result->fetch_assoc()) {  
                echo "<tr><td>".$row["schedule_id"]."</td><td>".$row["user_name"]." ".$row["description"]."</td><td style='text-align:center;'>".substr($row["start_date"],11,8)." - ".substr($row["end_date"],11,8)."</td></tr>";
            }
            echo "</table>";
    
        }       
        echo "</div>";        
    }
}

//SCHEDULE_LINE
if ($dspSL="true"){
    $sql = "SELECT COUNT(*) as counter FROM schedule_line WHERE SUBSTRING(start_date,1,10) = '".$that_date."'; ";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    if ($data['counter'] > 0){
        echo "<div class='divPAGE' style='background:rgba(255,255,255,0.7);'><h4>Rendez-vous (<b>".$data['counter']."</b>)</h4>";
        $sql2="SELECT A.id as schedule_id, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name,D.name as user_face,D.picture_url as user_pic,D.picture_type as user_pic_type, A.customer_id, CONCAT(D.first_name, ' ',D.last_name) as customer_name, A.product_id, C.name_fr as product_name,C.price1 as product_price,C.service_length as service_length,C.inter_length as inter_length, A.start_date as start_date, A.end_date as end_date
        FROM schedule_line A
        LEFT JOIN customer B ON B.id = A.customer_id
        LEFT JOIN product C ON C.id = A.product_id
        LEFT JOIN user D ON D.id = A.user_id WHERE SUBSTRING(start_date,1,10) = '".$that_date."'; ";
        $result = $dw3_conn->query($sql2);
        if ($result->num_rows > 0) {	
            echo "<table class='tblSEL'><tr><th>ID</th><th>Description</th><th style='text-align:center;'>Heure</th></tr>";
            while($row = $result->fetch_assoc()) {  
                echo "<tr><td>".$row["id"]."</td><td>".$row["user_name"]." - ".$row["customer_name"]."<br><b>".$row["product_name"]."</b></td><td style='text-align:center;'>".substr($row["start_date"],11,8)." - ".substr($row["end_date"],11,8)."</td></tr>";
            }
            echo "</table>";
    
        }       
        echo "</div>";        
    }
}

//CUSTOMER
if ($dspNewCustomer=="true"){
    $sql = "SELECT COUNT(*) as counter FROM customer WHERE SUBSTRING(date_created,1,10) = '".$that_date."'; ";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    if ($data['counter'] > 0){
        echo "<div class='divPAGE' style='background:rgba(255,255,255,0.7);'><h4>Nouveaux clients (<b>".$data['counter']."</b>)</h4>";
        $sql2="SELECT * FROM customer WHERE SUBSTRING(date_created,1,10) = '".$that_date."'; ";
        $result = $dw3_conn->query($sql2);
        if ($result->num_rows > 0) {	
            echo "<table class='tblSEL'><tr><th>ID</th><th>Description</th><th style='text-align:center;'>Heure</th></tr>";
            while($row = $result->fetch_assoc()) {  
                echo "<tr><td>".$row["id"]."</td><td>".$row["first_name"]." ".$row["last_name"]." ".$row["eml1"]."</td><td style='text-align:center;'>".substr($row["date_created"],11,8)."</td></tr>";
            }   
            echo "</table>";

        }       
        echo "</div>";      
    }
}

$dw3_conn->close();
?>