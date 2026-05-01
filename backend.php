<?php

// ===============================
// 🔒 SECURITY KEY (change this)
$secret_key = "uZx9!Kp@2026Secure";

if (!isset($_GET['key']) || $_GET['key'] !== $secret_key) {
    die("Access Denied");
}
// ===============================

// 🔐 CONFIG (PUT YOUR NEW KEYS HERE)
$adsterra_api_key = "715e55d346ca162105ae15021869de2b";
$telegram_token   = "8658112528:AAF8nhTpsN6rUmfYrqrzxevKxcmV9lD5t7s";
$chat_id          = "-1003956397850"; // group হলে -100 দিয়ে শুরু

// ===============================
// 📅 DATE
$today = date("Y-m-d");

// 📡 API URL
$url = "https://api3.adsterratools.com/publisher/stats.json?start_date=$today&finish_date=$today";

// 📡 HEADERS
$headers = [
    "Accept: application/json",
    "X-API-Key: $adsterra_api_key"
];

// ===============================
// 🔁 CURL REQUEST
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// ❌ CURL ERROR
if ($response === false) {
    echo json_encode([
        "status" => "error",
        "message" => "API request failed"
    ]);
    exit;
}

// ===============================
// 📊 PARSE DATA
$data = json_decode($response, true);

$revenue = $data['total']['revenue'] ?? "0.00";
$clicks  = $data['total']['clicks'] ?? "0";

// ===============================
// 🤖 TELEGRAM MESSAGE
$message = "📊 Adsterra Report\n\n";
$message .= "💰 Revenue: $revenue USD\n";
$message .= "🖱 Clicks: $clicks\n";
$message .= "📅 Date: $today";

// ===============================
// 📤 SEND TO TELEGRAM
$telegram_url = "https://api.telegram.org/bot$telegram_token/sendMessage";

$post_data = [
    "chat_id" => $chat_id,
    "text" => $message
];

$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $telegram_url);
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($post_data));
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

curl_exec($ch2);

// ===============================
// 🌐 RETURN JSON (for frontend)
header('Content-Type: application/json');

echo json_encode([
    "status" => "success",
    "revenue" => $revenue,
    "clicks" => $clicks,
    "date" => $today
]);
