<?php

namespace App\Services\ZohoServices;

use App\Services\ZohoServices\Abstract\ZohoConnector;

class OwnerService
{
    const OWNER_END_POINT = '/crm/v2/users';

    public static function getOwnerId()
    {
        $response = ZohoConnector::getRecords(self::OWNER_END_POINT, ['type' => 'ActiveUsers']);
        return $response['users'][0]['id'];
    }
}
