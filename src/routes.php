<?php


Route::group(['prefix' => config('wallet.routePrefix', 'api/wallet'), 'namespace' => 'RevoSystems\iOSWallet\Controllers\Api', 'middleware' => ["wallet-token"]], function () {
    Route::post('', 'WalletController@register')->name('wallet.register');
    Route::delete('', 'WalletController@unregister')->name('wallet.unregister');
});
