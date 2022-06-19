<?php

namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SmsService {
    public static function sendSms($phone) {
        $rand_number = rand(100000,999999);
        $client = new Client(['base_uri' => 'http://91.204.239.44/broker-api/']);
        $res = $client->request('POST', 'send', [
            'auth' => ['makro', '4M2shT92tH'],
            'json' => [
                'messages' => [
                    [
                        'recipient' => "+$phone",
                        'message-id' => 'makro',
                        'sms' => [
                            'originator' => 'Makro',
                            'content' => [
                                'text' => "$rand_number"
                            ]
                        ]
                    ]
                ],
            ],
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8',
            ]
        ]);
        return $rand_number;
    }
}
