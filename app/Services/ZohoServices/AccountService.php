<?php
namespace App\Services\ZohoServices;

use App\Services\ZohoServices\Abstract\ZohoConnector;

class AccountService
{
    const ACCOUNTS_END_POINT = '/crm/v2/Accounts';

    public static function insertAccount($data): int
    {
        return ZohoConnector::insertRecord(self::ACCOUNTS_END_POINT, $data);
    }

    public static function getAccounts()
    {
        $accounts = ZohoConnector::getRecords(self::ACCOUNTS_END_POINT);

        return $accounts['data'];
    }
}
