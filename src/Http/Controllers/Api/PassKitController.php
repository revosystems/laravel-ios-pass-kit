<?php

namespace RevoSystems\iOSPassKit\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use RevoSystems\iOSPassKit\Traits\PassKitTrait;

class PassKitController extends Controller
{
    public function register($account, $deviceLibraryIdentifier, $passType, $serialNumber)
    {
        (config('passKit.passTypes')[$passType])::registerApn($deviceLibraryIdentifier, $passType, $serialNumber, request('pushToken'));
    }

    public function log($account)
    {
        // TODO: IGNORE IT
        collect(request('logs'))->each(function ($logLine) {
            \Log::info("LOG: {$logLine}");
        });
    }

    public function unRegister($account, $deviceLibraryIdentifier, $passType, $serialNumber)
    {
        (config('passKit.passTypes')[$passType])::unRegisterApn($deviceLibraryIdentifier, $passType, $serialNumber); /*, only have one passType request('passType')*/
    }

    public function show($account, $passType, $serialNumber)
    {
        if (PassKitTrait::findRegistration($serialNumber, $passType)->updated_at->lessThan(Carbon::parse(request()->header('If-Modified-Since')))) {
            return response()->json()->setStatusCode(Response::HTTP_NOT_MODIFIED);
        }
        $usernameField = config('passKit.username_field');
        return response()->file(config('passKit.passesDirectory') . auth()->user()->$usernameField . "/passes/RevoCard-{$serialNumber}.pkpass");
    }

    public function index($account, $deviceLibraryIdentifier, $passType)
    {
        $relation      = PassKitTrait::getPassTypeRelation($passType);
        $table         = PassKitTrait::getPassTypeTable($passType);
        $serialNumbers = config('passKit.deviceClass')::where('device_library_identifier', $deviceLibraryIdentifier)->get()->map(function ($device) use ($relation, $table) {
            return $device->$relation()->where("{$table}.updated_at", '>', Carbon::parse(request('passesUpdatedSince')))->get()->map(function ($pass) {
                return $pass->getSerialNumber();
            });
        })->flatten();
        if (! $serialNumbers || $serialNumbers == []) {
            return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
        }
        return response()->json([
            'lastUpdated'   => (Carbon::parse(request('passesUpdatedSince')) ? : Carbon::now())->toDateTimeString(),
            'serialNumbers'  => $serialNumbers
        ]);
    }
}
