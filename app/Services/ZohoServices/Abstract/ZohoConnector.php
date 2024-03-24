<?php

namespace app\Services\ZohoServices\Abstract;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use function Laravel\Prompts\select;

abstract class ZohoConnector
{
    const ACCOUNTS_URL = 'https://accounts.zoho.eu';
    const REDIRECT_URI = 'http://localhost:8000/zoho/callback';
    const API_DOMAIN = 'https://www.zohoapis.eu';


    public static function getAccessToken()
    {
        $grantToken = session('grant_token');
        $refreshToken = session('refresh_token');

        $token = $refreshToken ?: $grantToken;
        $grantType = $refreshToken ? 'refresh_token' : 'authorization_code';
        $code = $refreshToken ? 'refresh_token' : 'code';
        try {
            $client = new Client();
            $url = self::ACCOUNTS_URL . '/oauth/v2/token';
            $data = [
                'form_params' => [
                    'client_id' => env('ZOHO_CLIENT_ID'),
                    'client_secret' => env('ZOHO_CLIENT_SECRET'),
                    'redirect_uri' => self::REDIRECT_URI,
                    $code => $token,
                    'grant_type' => $grantType
                ]
            ];

            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];

            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'form_params' => $data['form_params']
            ]);

            $responseData = json_decode($response->getBody(), true);

            Session::put('access_token', $responseData['access_token']);
            Session::put('access_token_expiry', now()->addHour()->format('H:i:s'));

            if (isset($responseData['refresh_token'])) {
                Session::put('refresh_token', $responseData['refresh_token']);
            }
            Session::save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function isExpiredToken()
    {
        if (session('access_token') && session('access_token_expiry')) {
            if (now()->gt(session('access_token_expiry'))) {
                self::getAccessToken();
            }
        }
    }

    public static function insertRecord($endPoint, array $data)
    {
        self::isExpiredToken();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . session('access_token')
        ];

        $url = self::API_DOMAIN . $endPoint;

        $client = new Client();

        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $data
        ]);

        dd($response->getBody()->getContents());
    }

    public static function getOwnerId()
    {
        self::isExpiredToken();
        $headers = [
            'Authorization' => 'Bearer ' . session('access_token')
        ];

        $url = self::API_DOMAIN . '/crm/v2/users';

        $client = new Client();

        $response = $client->request('GET', $url, [
            'headers' => $headers,
            'query' => ['type' => 'ActiveUsers']
        ]);

        $user = json_decode($response->getBody()->getContents(), true);

        return $user['users'][0]['id'];
    }

    public static function getRecords($endPoint, array $query = [])
    {
        self::isExpiredToken();

    }
}
