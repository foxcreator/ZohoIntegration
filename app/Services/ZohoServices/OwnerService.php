<?php

namespace App\Services\ZohoServices;

use App\Services\ZohoServices\Abstract\ZohoConnector;
use GuzzleHttp\Exception\GuzzleException;

class OwnerService
{
    const OWNER_END_POINT = '/crm/v2/users';

    /**
     * @throws GuzzleException
     */
    public static function getOwnerId(): string
    {
        $response = ZohoConnector::getRecords(self::OWNER_END_POINT, ['type' => 'ActiveUsers']);
        return $response['users'][0]['id'];
    }
}
