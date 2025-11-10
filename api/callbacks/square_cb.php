<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.min.php';
if ($CIE_SQUARE_KEY != ""){
    //
}else {
    $dw3_conn->close();
    header('Status: 200');
    die("");
}
$payload = @file_get_contents('php://input');

/* $dw3_conn->close(); */
http_response_code(200);
error_log("SQUARE_HOOK: ".$payload );
//exit(); 

$event = json_decode($payload, true);

/* if (isset($event->data->object->payment->status)){
    $status = $event->data->object->payment->status;
    $order_id = $event->data->object->payment->order_id; */
if (isset($event["data"]["object"]["payment"]["status"])){
    $status = $event["data"]["object"]["payment"]["status"];
    $order_id = $event["data"]["object"]["payment"]["order_id"];
    error_log("SQUARE_ORDER_ID: ".$order_id. " STATUS:" .$status );
    if ($status == "COMPLETED"){
        //data from transaction
        $sql = "SELECT * FROM invoice_head WHERE stripe_checkout_session_id = '" .  $order_id . "' AND stripe_checkout_session_id <> '' ORDER BY id DESC LIMIT 1;";
        $result = mysqli_query($dw3_conn, $sql);
        $data = mysqli_fetch_assoc($result);
        if (isset($data["id"])){
            $invoice_id= $data["id"];
            $paid = $data["paid_stripe"] + $data["paid_moneris"] + $data["paid_cash"] + $data["paid_paypal"];
            $to_pay = round($data["total"]-$paid,2);
            $square_cost = round(($to_pay*2.9)/100,2)+.3;

            $sql = "INSERT INTO transaction (invoice_id,paid_amount,payment_status,paid_amount_currency,payment_type,created,modified) VALUES('" . $invoice_id . "','" . $to_pay . "','succeeded', 'CAD', 'Square','".$datetime."','".$datetime."')";
            $result = mysqli_query($dw3_conn, $sql);

            $sql = "UPDATE invoice_head SET paid_stripe = '" . $to_pay . "',transaction_cost = '".$square_cost."', date_modified = '" . $datetime . "' WHERE id = '" . $invoice_id  . "' ";
            $result = mysqli_query($dw3_conn, $sql);
        }
    }

} else {
    $status = "failed";
}
?>

<!-- EXEMPLE PAYMENT COMPLETED -->
<!-- {
    "merchant_id":"MLNCS4AQA2SJ5",
    "type":"payment.updated",
    "event_id":"45853451-3b5c-3a24-be05-d65cec535909",
    "created_at":"2025-09-01T00:36:09.524Z",
    "data":{
        "type":"payment",
        "id":"vlXcwbpzILBeD4SxiRI2GM0ymsYZY",
        "object":{
            "payment":{
                "amount_money":{
                    "amount":7416,
                    "currency":"CAD"
                },
                "application_details":{
                    "application_id":"sandbox-sq0idb-lky4CaPAWmDnHY3YtYxINg",
                    "square_product":"ECOMMERCE_API"
                },
                "capabilities":[
                    "EDIT_AMOUNT_UP",
                    "EDIT_AMOUNT_DOWN",
                    "EDIT_TIP_AMOUNT_UP",
                    "EDIT_TIP_AMOUNT_DOWN"],
                "created_at":"2025-09-01T00:36:08.361Z",
                "external_details":{
                    "source":"Developer Control Panel",
                    "type":"CARD"
                },
                "id":"vlXcwbpzILBeD4SxiRI2GM0ymsYZY",
                "location_id":"LGVN4PJWVF7JH",
                "order_id":"kmOpc0aUwUD7LrKPGJLEozJQZtOZY",
                "receipt_number":"vlXc",
                "receipt_url":"https://squareupsandbox.com/receipt/preview/vlXcwbpzILBeD4SxiRI2GM0ymsYZY",
                "source_type":"EXTERNAL",
                "status":"COMPLETED",
                "total_money":{
                    "amount":7416,
                    "currency":"CAD"
                },
                "updated_at":"2025-09-01T00:36:08.470Z",
                "version":1
            }
        }
    }
} -->


<!-- EXEMPLE OF FAILED PAYMENT  
1331. [23-Aug-2025 15:52:32 America/New_York] SQUARE_HOOK: 
{
    "merchant_id":"MLCWHKQQT9M7N",
    "type":"payment.created",
    "event_id":"b2b2ba68-8a37-35c7-9e0e-fa55ff56b427",
    "created_at":"2025-08-23T19:52:29.761Z",
    "data":{
        "type":"payment",
        "id":"LpuUlxhpEeTwRfXoJ9O94dkmY2aZY",
        "object":{
            "payment":{
                "amount_money":{
                    "amount":184,
                    "currency":"CAD"
                },
                "application_details":{
                    "application_id":"sq0idp-w46nJ_NCNDMSOywaCY0mwA",
                    "square_product":"ECOMMERCE_API"
                },
                "approved_money":{
                    "amount":0,
                    "currency":"CAD"
                },
                "billing_address":{
                    "first_name":"Julien",
                    "last_name":"Béliveau"
                },
                "buyer_email_address":"beliveau@live.ca",
                "card_details":{
                    "avs_status":"AVS_ACCEPTED",
                    "card":{
                        "bin":"552612",
                        "card_brand":"MASTERCARD",
                        "card_type":"CREDIT",
                        "exp_month":7,
                        "exp_year":2026,
                        "fingerprint":"sq-1-ynEWDzTEIAf6DMA7O_fkl4RQByvSPCY227A0YM_s41FHx29xWxPqrabwFj4aeLhiaA",
                        "last_4":"3207",
                        "payment_account_reference":"500174PIY2B7UF0RRZ8CAZ3O2XYY0",
                        "prepaid_type":"NOT_PREPAID"
                    },
                "card_payment_timeline":{
                    "authorized_at":"2025-08-23T19:52:29.747Z"
                },
                "cvv_status":"CVV_ACCEPTED",
                "entry_method":"KEYED",
                "errors":[{
                    "category":"PAYMENT_METHOD_ERROR",
                    "code":"INSUFFICIENT_FUNDS",
                    "detail":"Authorization error: 'INSUFFICIENT_FUNDS'"
                }],
                "statement_description":"SQ *DESIGN WEB 3D",
                "status":"FAILED"
                },
                "created_at":"2025-08-23T19:52:29.062Z",
                "delay_action":"CANCEL",
                "delay_duration":"PT168H",
                "delayed_until":"2025-08-30T19:52:29.062Z",
                "id":"LpuUlxhpEeTwRfXoJ9O94dkmY2aZY",
                "location_id":"LMEWC8HX6EYXB",
                "order_id":"8L4x2C5DB3KpnBvkw2gi9ZD4EHMZY",
                "shipping_address":{
                    "first_name":"Julien",
                    "last_name":"Béliveau"
                },
                "source_type":"CARD",
                "status":"FAILED",
                "tip_money":{
                    "amount":0,
                    "currency":"CAD"
                },
                "total_money":{
                    "amount":184,
                    "currency":"CAD"
                },
                "updated_at":"2025-08-23T19:52:29.747Z",
                "version":1
            }
        }
    }
} -->