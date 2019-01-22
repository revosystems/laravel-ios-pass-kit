<?php


Route::group(['prefix' => config('wallet.routePrefix', 'api/wallet'), 'namespace' => 'RevoSystems\Wallet\Controllers\Api', 'middleware' => ["wallet-token"]], function () {
    Route::post('', 'WalletController@register')->name('wallet.register');
    Route::delete('', 'WalletController@unregister')->name('wallet.unregister');
});