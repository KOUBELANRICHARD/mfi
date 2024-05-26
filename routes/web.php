<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;

Route::get('/', function () {
//    abort(404);
    return redirect('/secret/mfi/admin');
});

Route::get('/secret/mfi/certificate/{account}', [AccountController::class, 'certificate'])->name('accounts.certificate');
Route::get('/secret/mfi/statement/{account}', [AccountController::class, 'statement'])->name('accounts.statement');

Route::get('test', function () {
    return view('certificate', [
        'account_number' => '1234',
        'name' => 'Grumpy Cat',
    ]);
});
Route::get('test1', function () {
    return Browsershot::url('http://localhost:12000/test')->pdf();
});
