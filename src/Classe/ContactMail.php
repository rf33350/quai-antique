<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class ContactMail
{
    private $api_key = '44f64fae0544c355a3276e6d8a9d0c8a';
    private $api_key_secret = 'fa0cb44ffd905f02c501413e5e3d1fae';

    public function send($firstName, $lastName, $email, $subject, $message)
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "michant@quai-antique-studi-faure.fr",
                        'Name' => "Le Quai Antique Restaurant"
                    ],
                    'To' => [
                        [
                            'Email' => "michant@quai-antique-studi-faure.fr",
                            'Name' => "Le Quai Antique Restaurant"
                        ]
                    ],
                    'TemplateID' => 4755826,
                    'TemplateLanguage' => true,
                    'Subject' => "Formulaire de contact quai antique",
                    'Variables' => [
                        'FirstName' => $firstName,
                        'LastName' => $lastName,
                        'Email' => $email,
                        'Subject' => $subject,
                        'Message' => $message,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}