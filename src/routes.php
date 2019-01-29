<?php


Route::group(['prefix' => config('passKit.routePrefix') . "/{account}/v1", 'namespace' => 'External\PassKit', "middleware" => "passKitConnection"], function () {
    Route::post('log', 'PassKitController@log')->name('passKit.log');
    Route::get('devices/{libraryIdentifier}/registrations/{passType}', 'PassKitController@index')->name('passKit.index');
    Route::group(['middleware' => "passKitToken"], function () {
        Route::post('devices/{libraryIdentifier}/registrations/{passType}/{serialNumber}', 'PassKitController@register')->name('passKit.register');
        Route::delete('devices/{libraryIdentifier}/registrations/{passType}/{serialNumber}', 'PassKitController@unregister')->name('passKit.unregister');
    });
});

