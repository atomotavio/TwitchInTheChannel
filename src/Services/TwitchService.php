<?php

namespace App\Services;

class TwitchService
{
    private $clientId;
    private $clientSecret;

    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getLiveInfo($streamerUsername)
    {
        // Obter token de acesso
        $tokenUrl = "https://id.twitch.tv/oauth2/token";
        $tokenResponse = file_get_contents("$tokenUrl?client_id={$this->clientId}&client_secret={$this->clientSecret}&grant_type=client_credentials");
        $token = json_decode($tokenResponse, true)['access_token'];

        // Verificar status da live
        $apiUrl = "https://api.twitch.tv/helix/streams?user_login=$streamerUsername";
        $context = stream_context_create([
            "http" => [
                "header" => "Client-ID: {$this->clientId}\r\nAuthorization: Bearer $token\r\n"
            ]
        ]);
        $response = file_get_contents($apiUrl, false, $context);
        $data = json_decode($response, true);

        return isset($data['data'][0]) ? $data['data'][0] : null; // Retorna informações da live ou null se offline
    }
}