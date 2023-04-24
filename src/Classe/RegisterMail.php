<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class RegisterMail
{
    private $api_key = '44f64fae0544c355a3276e6d8a9d0c8a';
    private $api_key_secret = 'fa0cb44ffd905f02c501413e5e3d1fae';

    public function send($to_email, $to_firstName, $to_lastName)
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "djaroul@hotmail.fr",
                        'Name' => "Le Quai Antique Restaurant"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => "Le Quai Antique Restaurant"
                        ]
                    ],
                    'TemplateID' => 4757586,
                    'TemplateLanguage' => true,
                    'Subject' => "Inscription au restaurant quai antique",
                    'Variables' => [
                        'Prenom' => $to_firstName,
                        'Nom' => $to_lastName,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}