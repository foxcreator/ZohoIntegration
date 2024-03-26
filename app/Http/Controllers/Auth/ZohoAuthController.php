<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ZohoServices\Abstract\ZohoConnector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ZohoAuthController extends Controller
{
    public function getGrantToken()
    {
        $queryParams = [
            'client_id' => env('ZOHO_CLIENT_ID'),
            'redirect_uri' => 'http://localhost:8000/zoho/callback',
            'response_type' => 'code',
            'access_type' => 'offline',
            'scope' => 'ZohoCRM.modules.all,ZohoCRM.users.all,ZohoCRM.settings.all',
        ];

        return redirect()->away('https://accounts.zoho.com/oauth/v2/auth?' . http_build_query($queryParams));
    }

    public function handleCallback(Request $request): RedirectResponse
    {
        $grantToken = $request->input('code');
        Cache::put('grant_token', $grantToken);

        return redirect()->route('zoho.token');
    }

    public function getAccessToken(): RedirectResponse
    {
        if (cache('refresh_token') || cache('grant_token')) {
            ZohoConnector::getAccessToken();
            return redirect()->to('/');
        } else {
            return redirect()->route('zoho.auth');
        }
    }
}
