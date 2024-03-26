<?php

namespace App\Http\Controllers\B2C;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDealRequest;
use App\Http\Resources\StageResource;
use App\Services\ZohoServices\AccountService;
use App\Services\ZohoServices\DealService;
use App\Services\ZohoServices\LayoutsService;
use App\Services\ZohoServices\OwnerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DealsController extends Controller
{
    public function getStages()
    {
        $stages = LayoutsService::getDealStages();
        return response()->json($stages);
    }

    public function getAccounts()
    {
        $accounts = AccountService::getAccounts();
        return response()->json($accounts);
    }

    public function getOwnerId()
    {
        return response()->json(OwnerService::getOwnerId());
    }

    public function store(CreateDealRequest $request)
    {
        $formData = $request->validated();

        $data = [
            'data' => [
                [
                    'Owner' => [
                        'id' => $formData['ownerId']
                    ],
                    'Account_Name' => [
                        'id' => $formData['accountId']
                    ],
                    'Deal_Name' => $formData['dealName'],
                    'Stage' => $formData['stage'],
                    'Closing_Date' => $formData['closingDate'],
                ]
            ]
        ];

        return response()->json(DealService::insertDeal($data));
    }
}
