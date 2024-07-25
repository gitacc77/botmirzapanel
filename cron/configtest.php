<?php
date_default_timezone_set('Asia/Tehran');
require_once '../config.php';
require_once '../botapi.php';
require_once '../panels.php';
require_once '../functions.php';
$ManagePanel = new ManagePanel();
$stmt = $pdo->prepare("SELECT * FROM invoice WHERE status = 'active' AND name_product = 'usertest'");
$stmt->execute();
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $resultt  = trim($result['username']);
        $result = $result;
        $marzban_list_get = select("marzban_panel","*","name_panel",$result['Service_location'],"select");
        $get_username_Check = $ManagePanel->DataUser($result['Service_location'],$result['username']);
    if (!in_array($get_username_Check['status'],['active','on_hold'])) {
        $ManagePanel->RemoveUser($result['Service_location'],$resultt);
        update("invoice","status","disabled","username",$resultt);
         $Response = json_encode([
        'inline_keyboard' => [
            [
                ['text' => "🛍 خرید اشتراک اختصاصی", 'callback_data' => 'buy'],
            ],
        ]
    ]);
        $textexpire = "کاربر گرامی، اشتراک تست رایگان $resultt به پایان رسید.🍃
در صورت رضایت، اشتراک اختصاصی خود را تهیه کنید و از داشتن اینترنت آزاد با نهایت کیفیت لذت ببرید.😉🔥
(تو بهترینی و لایق بهترین ها رفیق ♥️)";
        sendmessage($result['id_user'], $textexpire, $Response, 'HTML');
    }
}
