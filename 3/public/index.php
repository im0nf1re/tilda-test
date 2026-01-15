<?php
// public/index.php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Service\GeoIpService;
use App\Service\PhoneService;

$defaultPhoneNumber = '8-800-DIGITS';
$displayPhoneNumber = $defaultPhoneNumber;

// Для тестирования можно передать IP в строке запроса: ?ip=XXX.XXX.XXX.XXX
$clientIp = $_GET['ip'] ?? ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');

$geoIpService = new GeoIpService();
$phoneService = new PhoneService(__DIR__ . '/../config/phones.php');

$city = $geoIpService->getCityByIp($clientIp);

if ($city !== null) {
    $cityPhoneNumber = $phoneService->getPhoneByCity($city);
    if ($cityPhoneNumber !== null) {
        $displayPhoneNumber = $cityPhoneNumber;
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 20px auto; padding: 0 15px; }
        header, footer { background-color: #f4f4f4; padding: 10px 20px; text-align: center; margin-bottom: 20px; }
        footer { margin-top: 40px; }
        .phone-display { font-size: 1.5em; font-weight: bold; color: #007bff; }
        .debug-info { margin-top: 30px; padding: 10px; background-color: #f9f9f9; border: 1px solid #eee; font-size: 0.9em; color: #555; }
    </style>
</head>
<body>
    <header>
        <h1>Наши контакты</h1>
        <p>Звоните нам по телефону:</p>
        <div class="phone-display"><?= htmlspecialchars($displayPhoneNumber) ?></div>
    </header>

    <main>
        <p>Мы работаем в нескольких городах по всей России. Для получения актуальной информации, пожалуйста, свяжитесь с нами по указанному номеру.</p>
        <p>Наши офисы открыты с понедельника по пятницу, с 9:00 до 18:00.</p>
        <p>Если вы хотите узнать номер для вашего города, просто зайдите на эту страницу. Если ваш город не определился, будет показан общий номер.</p>
    </main>

    <footer>
        <p>Свяжитесь с нами:</p>
        <div class="phone-display"><?= htmlspecialchars($displayPhoneNumber) ?></div>
        <p>&copy; <?= date('Y') ?> Название Компании</p>
    </footer>

    <?php if (isset($_GET['debug'])): ?>
        <div class="debug-info">
            <h2>Отладочная информация:</h2>
            <p><strong>IP клиента:</strong> <?= htmlspecialchars($clientIp) ?></p>
            <p><strong>Определенный город:</strong> <?= htmlspecialchars($city ?? 'Не определен') ?></p>
            <p><strong>Отображаемый телефон:</strong> <?= htmlspecialchars($displayPhoneNumber) ?></p>
            <p><strong>Телефоны в конфигурации:</strong></p>
            <pre><?= htmlspecialchars(print_r($phoneService->getPhoneMapForDebug(), true)) ?></pre>
        </div>
    <?php endif; ?>
</body>
</html>
