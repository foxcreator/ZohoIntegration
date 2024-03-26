<?php

namespace App\Http\Controllers\B2C;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\CreateDealRequest;
use App\Services\ZohoServices\AccountService;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function store(CreateAccountRequest $request)
    {
        $formData = $request->validated();

        $data = [
            'data' => [
                [
                    'Owner' => [
                        'id' => $formData['ownerId']
                    ],
                    'Account_Name' => $formData['accountName'],
                    'Website' => $formData['accountWebsite'],
                    'Phone' => $formData['accountPhone'],
                ]
            ]
        ];

        return response()->json(AccountService::insertAccount($data));
    }
}
