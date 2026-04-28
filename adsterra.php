<?php
// ১. আপনার তথ্য
$adsterra_api_key = '715e55d346ca162105ae15021869de2b'; 
$telegram_token   = '8658112528:AAF8nhTpsN6rUmfYrqrzxevKxcmV9lD5t7s';
$chat_id          = '-1003956397850';

// ২. Adsterra থেকে ডাটা আনা (সার্ভার টু সার্ভার)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.adsterra.com/publisher/v1/balance.json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-Key: $adsterra_api_key"]);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$balance = isset($data['balance']) ? $data['balance'] : "0.00";

// ৩. বাটন ক্লিক করলে টেলিগ্রামে পাঠানো
if (isset($_POST['send'])) {
    $msg = "📢 *Adsterra Publisher Update*\n💰 Balance: $" . $balance . "\n🌐 usaoffers.online\n👤 Panel: Alamgir";
    file_get_contents("https://api.telegram.org/bot$telegram_token/sendMessage?chat_id=$chat_id&parse_mode=Markdown&text=" . urlencode($msg));
    $status = "✅ Sent to Telegram!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Adsterra Real Dashboard</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; display: flex; justify-content: center; padding-top: 50px; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; width: 350px; }
        .balance { font-size: 2.5rem; color: #27ae60; font-weight: bold; margin: 20px 0; }
        .btn { background: #0088cc; color: white; border: none; padding: 12px; border-radius: 8px; width: 100%; cursor: pointer; font-weight: bold; }
        .success { color: #27ae60; margin-top: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <h3>Adsterra Publisher</h3>
        <p>usaoffers.online</p>
        <div class="balance">$<?php echo $balance; ?></div>
        <form method="post">
            <button type="submit" name="send" class="btn">Update & Send Telegram</button>
        </form>
        <?php if(isset($status)) echo "<p class='success'>$status</p>"; ?>
    </div>
</body>
</html>
