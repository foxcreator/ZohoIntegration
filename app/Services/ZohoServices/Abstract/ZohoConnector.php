<?php

namespace app\Services\ZohoServices\Abstract;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Mockery\Exception;

class ZohoConnector
{
    const ACCOUNTS_URL = 'https://accounts.zoho.eu';
    const REDIRECT_URI = 'http://localhost:8000/zoho/callback';
    const API_DOMAIN = 'https://www.zohoapis.eu';

    public static function getAccessToken()
    {
        $grantToken = cache('grant_token');
        $refreshToken = cache('refresh_token');

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

            Cache::put('access_token', $responseData['access_token']);
            Cache::put('access_token_expiry', now()->addHour());

            if (isset($responseData['refresh_token'])) {
                Cache::put('refresh_token', $responseData['refresh_token']);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function isExpiredToken()
    {

        if (cache('access_token') && cache('access_token_expiry')) {
            if (now()->gt(cache('access_token_expiry'))) {
                self::getAccessToken();
            }
        }
    }

    public static function insertRecord($endPoint, array $data)
    {
        self::isExpiredToken();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . cache('access_token')
        ];

        $url = self::API_DOMAIN . $endPoint;

        $client = new Client();

        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $data
        ]);

        return $response->getStatusCode();
    }

    /**
     * @throws GuzzleException
     */
    public static function getRecords($endPoint, array $query = [])
    {
        self::isExpiredToken();
        $headers = [
            'Authorization' => 'Bearer ' . cache('access_token'),
            'Content-Type' => 'application/json'
        ];

        $url = self::API_DOMAIN . $endPoint;


        $client = new Client();
        $response = $client->request('GET', $url, [
            'headers' => $headers,
            'query' => $query,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
