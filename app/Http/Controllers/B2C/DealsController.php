<?php

namespace App\Http\Controllers\B2C;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDealRequest;
use App\Services\ZohoServices\AccountService;
use App\Services\ZohoServices\DealService;
use App\Services\ZohoServices\LayoutsService;
use App\Services\ZohoServices\OwnerService;
use Illuminate\Http\JsonResponse;

class DealsController extends Controller
{
    public function getStages(): JsonResponse
    {
        $stages = LayoutsService::getDealStages();
        return response()->json($stages);
    }

    public function getAccounts(): JsonResponse
    {
        $accounts = AccountService::getAccounts();
        return response()->json($accounts);
    }

    public function getOwnerId(): JsonResponse
    {
        return response()->json(OwnerService::getOwnerId());
    }

    public function store(CreateDealRequest $request): JsonResponse
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
