<?php
namespace App\Services\ZohoServices;

use App\Services\ZohoServices\Abstract\ZohoConnector;
use GuzzleHttp\Client;

class AccountService extends ZohoConnector
{
    const ACCOUNTS_END_POINT = '/crm/v2/Accounts';

    public static function insertAccount()
    {
        $data = [
            'data' => [
                [
                    'Owner' => [
                        'id' => self::getOwnerId()
                    ],
                    'Account_Site' => 'Account_Site',
                    'Phone' => '0987776677',
                    'Account_Name' => 'Namname'
                ]
            ]
        ];


        self::insertRecord(self::ACCOUNTS_END_POINT, $data);
    }

    public static function getAccounts()
    {
        self::isExpiredToken();
        $headers = [
            'Authorization' => 'Bearer ' . session('access_token')
        ];

        $url = self::API_DOMAIN . self::ACCOUNTS_END_POINT;

        $client = new Client();

        $response = $client->request('GET', $url, [
            'headers' => $headers,
        ]);

        $accounts = json_decode($response->getBody()->getContents());

        return $accounts->data;
    }
}
