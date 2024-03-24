<?php

namespace App\Http\Controllers\Auth;

use App\Services\ZohoServices\AccountService;
use App\Http\Controllers\Controller;
use App\Services\ZohoServices\Abstract\ZohoConnector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ZohoAuthController extends Controller
{
    public function getGrantToken()
    {
        $queryParams = [
            'client_id' => env('ZOHO_CLIENT_ID'),
            'redirect_uri' => 'http://localhost:8000/zoho/callback',
            'response_type' => 'code',
            'access_type' => 'offline',
            'scope' => 'ZohoCRM.modules.all,ZohoCRM.users.all',
        ];


        return redirect()->away('https://accounts.zoho.com/oauth/v2/auth?' . http_build_query($queryParams));
    }

    public function handleCallback(Request $request)
    {
        $grantToken = $request->input('code');
        Session::put('grant_token', $grantToken);

        return redirect()->route('zoho');
    }

    public function getAccessToken()
    {
        if (session('refresh_token') || session('grant_token')) {
            ZohoConnector::getAccessToken();
            return redirect()->to('/');
        } else {
            return redirect()->route('zoho.auth');
        }
    }

    public function insertAccount()
    {
        AccountService::getAccounts();
//        AccountService::insertAccount();
    }

    public function getUser()
    {
        AccountService::getOwnerId();
    }
}
