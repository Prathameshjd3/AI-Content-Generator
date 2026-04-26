<?php
if(isset($_POST['prompt'])){
    $prompt = $_POST['prompt'];

    $data = [
        "model" => "gpt-4o-mini",
        "messages" => [
            ["role" => "user", "content" => $prompt]
        ]
    ];

    $ch = curl_init("https://api.openai.com/v1/chat/completions");

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer sk-xxxxxxx",
        "Content-Type: application/json"
    ]);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if(curl_errno($ch)){
        echo "Curl Error: " . curl_error($ch);
        exit;
    }

    $result = json_decode($response, true);

    if(isset($result['choices'][0]['message']['content'])){
        echo $result['choices'][0]['message']['content'];
    } else {
        echo "API Error:<br>";
        print_r($result);
    }
}
?>