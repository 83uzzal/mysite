<?php
/*
 * Adsterra to Telegram - Complete Real-Time Solution
 * Domain: usaoffers.online
 */

// --- ১. আপনার কনফিগারেশন ---
$adsterra_api_key = '715e55d346ca162105ae15021869de2b'; // আপনার দেওয়া API Key
$telegram_token   = '8658112528:AAF8nhTpsN6rUmfYrqrzxevKxcmV9lD5t7s'; // আপনার বট টোকেন
$chat_id          = '-1003956397850'; // আপনার চ্যাট আইডি
$panel_name       = 'Alamgir';

// --- ২. Adsterra API থেকে আসল ডাটা সংগ্রহ ---
$url = "https://api.adsterra.com/publisher/v1/balance.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-Key: $adsterra_api_key"]);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$real_balance = isset($data['balance']) ? $data['balance'] : "0.00";

// --- ৩. অটোমেটিক মেসেজ পাঠানোর ফাংশন (যদি বাটন ক্লিক করা হয়) ---
if (isset($_POST['send_telegram'])) {
    $message = "📢 *Adsterra Real-Time Update* 🚨\n\n";
    $message .= "🌐 *Domain:* usaoffers.online\n";
    $message .= "💰 *Current Balance:* $" . $real_balance . "\n";
    $message .= "💻 *Panel:* " . $panel_name . "\n";
    $message .= "⏰ *Time:* " . date("d-M-Y H:i:s") . "\n\n";
    $message .= "✅ *Data Source:* Adsterra Official API";

    $telegram_url = "https://api.telegram.org/bot$telegram_token/sendMessage";
    $params = [
        'chat_id'    => $chat_id,
        'text'       => $message,
        'parse_mode' => 'Markdown'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $telegram_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    $status = "✅ মেসেজ টেলিগ্রামে পাঠানো হয়েছে!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adsterra Real-Time Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: #fff; padding: 40px; border-radius: 25px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); text-align: center; width: 100%; max-width: 380px; }
        .logo { color: #0088cc; font-size: 1.2rem; font-weight: bold; margin-bottom: 10px; }
        .balance-label { color: #888; font-size: 0.9rem; }
        .balance-amount { color: #27ae60; font-size: 3rem; font-weight: 800; margin: 15px 0; }
        .btn { background: #0088cc; color: #fff; border: none; padding: 15px 25px; border-radius: 12px; font-weight: bold; cursor: pointer; width: 100%; transition: 0.3s; }
        .btn:hover { background: #0077b5; }
        .status { margin-top: 15px; color: #27ae60; font-size: 0.9rem; font-weight: bold; }
    </style>
</head>
<body>

<div class="card">
    <div class="logo">ADSTERRA PUBLISHER</div>
    <div class="balance-label">Real-Time Balance</div>
    <div class="balance-amount">$<?php echo $real_balance; ?></div>
    
    <form method="post">
        <button type="submit" name="send_telegram" class="btn">Send Report to Telegram</button>
    </form>

    <?php if (isset($status)) echo "<div class='status'>$status</div>"; ?>
    <p style="font-size: 0.8rem; color: #bbb; margin-top: 20px;">Connected to: usaoffers.online</p>
</div>

</body>
</html>