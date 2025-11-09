<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$invoice_id  = $_GET['IID'];

$sql = "SELECT * FROM invoice_head WHERE id = '" . $invoice_id . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$customer_id = $data['customer_id'];
$location_id = $data['location_id'];
$to_pay = $data["total"] - ($data["prepaid"]+ $data["paid_cash"]+ $data["paid_check"]+ $data["paid_stripe"]+ $data["paid_moneris"]);

    $sql2 = "SELECT * FROM location WHERE id = '" .  $location_id . "'";
    $result2 = mysqli_query($dw3_conn, $sql2);
    $data2 = mysqli_fetch_assoc($result2);
    $square_loc_id = $data2["square_id"];

/* $request_body = '{
    "checkout_options": {
      "redirect_url": "https://'.$_SERVER["SERVER_NAME"].'/client/square-success.php"
    },
    "order": {
      "reference_id": "1234",
      "location_id": "LGVN4PJWVF7JH",
      "fulfillments": [
        {
          "type": "SHIPMENT"
        }
      ],
      "line_items": [
        {
          "base_price_money": {
            "amount": 100,
            "currency": "CAD"
          },
          "quantity": "1",
          "name": "facture 1234"
        }
      ]
    }
  }'; */

if ($CIE_SQUARE_MODE == "" || $CIE_SQUARE_MODE == "DEV"){
    $SQUARE_KEY = $CIE_SQUARE_DEV;
} else {
    $SQUARE_KEY = $CIE_SQUARE_KEY;
}

$request_body = '{
    "checkout_options": {
      "redirect_url": "https://'.$_SERVER['SERVER_NAME'].'/client/square-success.php?KEY='. $KEY. '&FCT='. $invoice_id.'&FROM=cart"
    },
    "quick_pay": {
      "name": "Facture #'.$invoice_id.'",
      "price_money": {
        "amount": '.round($to_pay*100).',
        "currency": "CAD"
      },
      "location_id": "'.$square_loc_id.'"
    }
  }';

//$request_body = json_encode($data);

$headers = array(
  "Square-Version: 2025-05-21",
  "Content-Type: application/json",
  "Authorization: Bearer ".$SQUARE_KEY
);

$ch = curl_init();
if ($CIE_SQUARE_MODE == "" || $CIE_SQUARE_MODE == "DEV"){
    curl_setopt($ch, CURLOPT_URL, "https://connect.squareupsandbox.com/v2/online-checkout/payment-links");
} else {
    curl_setopt($ch, CURLOPT_URL, "https://connect.squareup.com/v2/online-checkout/payment-links");
}
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

$response = json_decode($result,true);
//die($response->carriers[1]->carrierCode);
if (isset($response["payment_link"])){
    echo $response["payment_link"]["url"];
    $sql = "UPDATE invoice_head SET stripe_checkout_session_id ='" .  $response["payment_link"]["order_id"] . "' WHERE id = '" . $invoice_id  . "'";
    $result = mysqli_query($dw3_conn, $sql);
}   else {
    echo "ERR: ".$response;
}

$dw3_conn->close();
exit();
//Request exemple

/* curl https://connect.squareupsandbox.com/v2/online-checkout/payment-links \
  -X POST \
  -H 'Square-Version: 2025-05-21' \
  -H 'Authorization: Bearer EAAAl9seZ2kBbqg9i9naGGPaxIxhu6pRfx2P8215FgLuFxcshmmvDWdox505zoiL' \
  -H 'Content-Type: application/json' \
  -d '{
    "checkout_options": {},
    "order": {
      "reference_id": "1234",
      "location_id": "LGVN4PJWVF7JH",
      "fulfillments": [
        {
          "type": "SHIPMENT"
        }
      ],
      "line_items": [
        {
          "base_price_money": {
            "amount": 100,
            "currency": "CAD"
          },
          "quantity": "1",
          "name": "facture 1234"
        }
      ]
    }
  }'
  */


//Response exemple

/* // cache-control: max-age=0, private, must-revalidate
// content-encoding: gzip
// content-type: application/json
// date: Tue, 10 Jun 2025 23:15:50 GMT
// square-version: 2025-05-21

{
  "payment_link": {
    "id": "WCFUV2PLZDTZWSUJ",
    "version": 1,
    "order_id": "sU5I0neZv6RIkvfGDM6wsGbPUJYZY",
    "checkout_options": {},
    "url": "https://sandbox.square.link/u/v7v7nAwA",
    "long_url": "https://connect.squareupsandbox.com/v2/online-checkout/sandbox-testing-panel/MLNCS4AQA2SJ5/WCFUV2PLZDTZWSUJ",
    "created_at": "2025-06-10T23:42:23Z"
  },
  "related_resources": {
    "orders": [
      {
        "id": "sU5I0neZv6RIkvfGDM6wsGbPUJYZY",
        "location_id": "LGVN4PJWVF7JH",
        "reference_id": "1234",
        "source": {
          "name": "Sandbox for sq0idp-xq2-PBH2Oe6KYwPAX90Flw"
        },
        "line_items": [
          {
            "uid": "bCumhCOx4UxaoDZlOYJWZB",
            "name": "facture 1234",
            "quantity": "1",
            "item_type": "ITEM",
            "base_price_money": {
              "amount": 100,
              "currency": "CAD"
            },
            "variation_total_price_money": {
              "amount": 100,
              "currency": "CAD"
            },
            "gross_sales_money": {
              "amount": 100,
              "currency": "CAD"
            },
            "total_tax_money": {
              "amount": 0,
              "currency": "CAD"
            },
            "total_discount_money": {
              "amount": 0,
              "currency": "CAD"
            },
            "total_money": {
              "amount": 100,
              "currency": "CAD"
            },
            "total_service_charge_money": {
              "amount": 0,
              "currency": "CAD"
            }
          }
        ],
        "fulfillments": [
          {
            "uid": "rd2NckEpgX6ADCGGCqkGVC",
            "type": "SHIPMENT",
            "state": "PROPOSED"
          }
        ],
        "net_amounts": {
          "total_money": {
            "amount": 100,
            "currency": "CAD"
          },
          "tax_money": {
            "amount": 0,
            "currency": "CAD"
          },
          "discount_money": {
            "amount": 0,
            "currency": "CAD"
          },
          "tip_money": {
            "amount": 0,
            "currency": "CAD"
          },
          "service_charge_money": {
            "amount": 0,
            "currency": "CAD"
          }
        },
        "created_at": "2025-06-10T23:42:22.897Z",
        "updated_at": "2025-06-10T23:42:22.897Z",
        "state": "DRAFT",
        "version": 1,
        "total_money": {
          "amount": 100,
          "currency": "CAD"
        },
        "total_tax_money": {
          "amount": 0,
          "currency": "CAD"
        },
        "total_discount_money": {
          "amount": 0,
          "currency": "CAD"
        },
        "total_tip_money": {
          "amount": 0,
          "currency": "CAD"
        },
        "total_service_charge_money": {
          "amount": 0,
          "currency": "CAD"
        },
        "net_amount_due_money": {
          "amount": 100,
          "currency": "CAD"
        }
      }
    ]
  }
} */

?>