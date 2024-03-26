<?php

namespace App\Services\ZohoServices;

use App\Services\ZohoServices\Abstract\ZohoConnector;

class LayoutsService
{
    const LAYOUTS_END_POINT = '/crm/v2/settings/layouts';

    public static function getDealStages() :array
    {
        $result = ZohoConnector::getRecords(self::LAYOUTS_END_POINT, ['module' => 'Deals']);

        foreach ($result['layouts'][0]['sections'] as $section) {
            if ($section['sequence_number'] === 2) {
                foreach ($section['fields'] as $item) {
                    if ($item['id'] == '690257000000000547') {
                        return $item['pick_list_values'];
                    }
                }
            }
        }

        return [];
    }
}
