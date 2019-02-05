<?php

namespace RevoSystems\iOSPassKit\Services;


use App\Models\Config\Business;

class PassKitGenerator
{
    public static function generate($username, $pass)
    {
        $tableName  = $pass->getTable();
        $basePass   = json_decode(file_get_contents(public_path() . "/gift_cards_pass.json"), true);
        $passValues = json_decode(Business::first()->passes, true)[$pass->getTable()];
        $basePass["serialNumber"]       = $pass->uuid;
        $basePass["locations"]          = $passValues["locations"];
        $basePass["barcode"]["message"] = $passValues["barcode"]["message"];
        $basePass["organizationName"]   = $passValues["organizationName"];
        $basePass["description"]        = $passValues["description"];
        $basePass["logoText"]           = $passValues["logoText"];
        $basePass["backgroundColor"]    = $passValues["backgroundColor"];
        $basePass["foregroundColor"]    = $passValues["foregroundColor"];
        $basePass["labelColor"]         = $passValues["labelColor"];
        $basePass["storeCard"]["primaryFields"]["value"]    = $pass->balance;
        $basePass["storeCard"]["backFields"]                = $passValues["storeCard"]["backFields"];
        $file = fopen(public_path("tenants") . "/${username}/passes/{$tableName}.pass/pass.json", "w");
        fwrite($file, json_encode($basePass));
        fclose($file);
    }
}
