<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
//require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$assistant  = $_GET['S'];
$question  = $_GET['Q'];

if($assistant == ""){$assistant = "You are a poetic assistant, skilled in explaining complex programming concepts with creative flair.";}
if($question == ""){$question = "Hi, what is your name ?";}

$request_body = '{
  "messages": [
    {
      "role": "system",
      "content": "'.$assistant.'"
    },
    {
      "role": "user",
      "content": "'.$question.'"
    }
  ],
  "model": "grok-2-latest",
  "stream": false,
  "temperature": 0
}';

//$request_body = json_encode($data);

$headers = array(
  "Content-type: application/json",
  "Authorization: Bearer ".$CIE_GROK_KEY
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.x.ai/v1/chat/completions");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

$response = json_decode($result,true);
//die($response->carriers[1]->carrierCode);
if (isset($response["choices"][0]["message"]["content"])){
    $output_var = $response["choices"][0]["message"]["content"];
    die($output_var);
}   
/* if (isset($response->choices[0]->message->content)){
    $output_var = $response["choices"][0]["message"]["content"];
    die("wtf".$output_var."esti");
}    */
//Response exemple
/* {"id":"",
    "object":"chat.completion",
    "created":1743454126,
    "model":"grok-2-1212",
    "choices":
    [
        {"index":0,
            "message":{
                "role":"assistant",
                "content":"Hi there! I'm doing great, thanks for asking! Just hanging out in the digital realm, ready to assist with any questions or tasks you might have. How can I help you today?",
                "refusal":null
            },
            "finish_reason":"stop"
        }
    ],
    "usage":{
        "prompt_tokens":23,
        "completion_tokens":40,
        "reasoning_tokens":0,
        "total_tokens":63,
        "prompt_tokens_details":{
            "text_tokens":23,
            "audio_tokens":0,
            "image_tokens":0,
            "cached_tokens":0
        }
    },
    "system_fingerprint":""
}
    1 */

?>