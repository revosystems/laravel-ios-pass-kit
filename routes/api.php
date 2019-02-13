<?php

Route::group(['prefix' => config('passKit.routePrefix', 'api/external/passKit') . "/{account}/v1", 'namespace' => 'RevoSystems\iOSPassKit\Http\Controllers\Api', "middleware" => "passKitApiConnection"], function () {
    Route::post('log', 'PassKitController@log')->name('passKit.log');
    Route::get('devices/{libraryIdentifier}/registrations/{passType}', 'PassKitController@index')->name('passKit.index');
    Route::group(['middleware' => "passKitApiToken"], function () {
        Route::get('passes/{passType}/{serialNumber}', 'PassKitController@show')->name('passKit.index');
        Route::post('devices/{libraryIdentifier}/registrations/{passType}/{serialNumber}', 'PassKitController@register')->name('passKit.register');
        Route::delete('devices/{libraryIdentifier}/registrations/{passType}/{serialNumber}', 'PassKitController@unregister')->name('passKit.unregister');
    });
});


