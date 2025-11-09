<?php
//to delete
exit();


require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$order_id  = $_GET['ID'];
    $sql_head = "";
    $sql_lines = "";
    $sql = "SELECT * FROM order_head WHERE id = '" . $order_id . "' LIMIT 1";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows == 0) {
        $dw3_conn->close();
        die("Erreur: commande #".$order_id." introuvable.");
        //die($sql);
    } else {
        while($row = $result->fetch_assoc()) {
            $sql_head = "INSERT INTO invoice_head (order_id,customer_id,user_id,total,transport,date_created,date_modified)"
            . " VALUES ('".$order_id."','".$row["customer_id"]."','".$row["user_id"]."','".$row["total"]."','".$row["transport"]."','".$datetime."','".$datetime."') ; ";          
        }
        if ($dw3_conn->query($sql_head) === TRUE) {
            $inserted_id = $dw3_conn->insert_id;
            $sql = "SELECT * FROM order_line WHERE head_id = '" . $order_id . "' ;";
            $result = $dw3_conn->query($sql);
            if ($result->num_rows == 0) {
                $dw3_conn->close();
                die("Erreur: commande #".$order_id." introuvable.");
                //die($sql);
            } else {
                while($row = $result->fetch_assoc()) {
                    $sql_lines .= "INSERT INTO invoice_line (head_id,product_id,product_desc,qty_order,price,tps,tvq,date_created,date_modified)"
                    . " VALUES ('".$inserted_id."','".$row["product_id"]."','".$row["product_desc"]."','".$row["qty_order"]."','".$row["price"]."','".$row["tps"]."','".$row["tvq"]."','".$datetime."','".$datetime."') ; ";
                }
                if ($dw3_conn->query($sql_lines) === TRUE) {
                    //ok
                } else {
                    echo "Erreur: " . $dw3_conn->error;
                }
            }
        } else {
          echo "Erreur: " . $dw3_conn->error;
        }
    }
    $dw3_conn->close();
    ?>

