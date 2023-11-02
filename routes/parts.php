<?php

use App\Http\Controllers\PartsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Parts routes
|--------------------------------------------------------------------------
*/

Route::prefix('parts')->group(function () {
    Route::get('/', [PartsController::class, 'index'])->name('parts.index');
});
