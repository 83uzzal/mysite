<?php

// 🔒 security key
if ($_GET['key'] !== "12345") {
    die("Access Denied");
}

// 🔐 CONFIG
$api_key = "PASTE_YOUR_ADSTERRA_API_KEY";
$bot_token = "PASTE_YOUR_TELEGRAM_BOT_TOKEN";
$chat_id = "PASTE_YOUR_CHAT_ID";

// 📅 today date
$today = date("Y-m-d");

// 📡 Adsterra API
$url = "https://api3.adsterratools.com/publisher/stats.json?start_date=$today&finish_date=$today";

$headers = [
    "Accept: application/json",
    "X-API-Key: $api_key"
];

// 🔁 curl call
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$data = json_decode($response, true);

// 📊 data extract
$balance = $data['total']['revenue'] ?? "0.00";
$clicks = $data['total']['clicks'] ?? "0";

// 🤖 Telegram message
$message = "📊 Adsterra Report\n\n💰 Revenue: $balance USD\n🖱 Clicks: $clicks\n📅 Date: $today";

// 📤 send telegram
file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($message));

// 🌐 return to website
echo json_encode([
    "balance" => $balance
]);