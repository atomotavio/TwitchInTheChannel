<?php

require_once __DIR__ . '/../src/Services/TwitchService.php';
require_once __DIR__ . '/../src/Services/WhatsappService.php';

use App\Services\TwitchService;
use App\Services\WhatsappService;

$clientId = 'seu_client_id';
$clientSecret = 'seu_client_secret';
$twitchService = new TwitchService($clientId, $clientSecret);

$apiUrl = 'https://api.whatsapp.com/send';
$apiToken = 'seu_api_token';
$whatsappService = new WhatsappService($apiUrl, $apiToken);

$streamerUsername = 'nome_do_streamer';
$groupId = 'id_do_grupo';

$liveInfo = $twitchService->getLiveInfo($streamerUsername);

if ($liveInfo) {
    $message = "O streamer está ao vivo!\nTítulo: " . $liveInfo['title'];
    $whatsappService->sendMessage($groupId, $message);
} else {
    $message = "O streamer está offline.";
    $whatsappService->sendMessage($groupId, $message);
}