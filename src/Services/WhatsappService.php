<?php

namespace App\Services;

class WhatsappService
{
    private $apiUrl;
    private $apiToken;

    public function __construct($apiUrl, $apiToken)
    {
        $this->apiUrl = $apiUrl;
        $this->apiToken = $apiToken;
    }

    public function sendMessage($groupId, $message)
    {
        $data = [
            'group_id' => $groupId,
            'message' => $message
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\nAuthorization: Bearer {$this->apiToken}\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($this->apiUrl, false, $context);

        return $result;
    }
}