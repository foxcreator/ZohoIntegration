<?php

namespace App\Services\ZohoServices;

use App\Services\ZohoServices\Abstract\ZohoConnector;

class DealService
{
    const DEALS_END_POINT = '/crm/v2/Deals';

    public static function insertDeal($data): int
    {
        return ZohoConnector::insertRecord(self::DEALS_END_POINT, $data);
    }
}
