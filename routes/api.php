<?php

use App\Http\Controllers\Api\SuggestController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PromocodeController;
use App\Http\Controllers\CalculatorChecksController;
use App\Http\Controllers\CalculatorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([], function () {
    Route::prefix('calculator')->name('calculator.')->group(function () {
        Route::prefix('check')->name('check.')->group(function () {
            Route::get('readonly/{calculator}', [CalculatorChecksController::class, 'checkEqualOr'])
                ->where('calculator', '[0-9]+')
                ->name('readonly');

            Route::get('readonly-items-in/{calculator}', [CalculatorChecksController::class, 'checkEqualOrAndData'])
                ->where('calculator', '[0-9]+')
                ->name('readonly-items');
        });

        // если передать 1 калькулятор, то он выведется на страницу, при передаче в параметры типа, выведутся все
        // и переданный калькулятор станет активным
        Route::get('calculator/{calculator}/{calculatorType?}', [CalculatorController::class, 'types'])->name('types');

        Route::post('configs_by_ids', [CalculatorController::class, 'configsByIds']);

        Route::get('config/{calculator?}', [CalculatorController::class, 'config'])->name('config');
        Route::get('knifes/{calculator?}', [CalculatorController::class, 'knifes'])->name('knifes');
        Route::get('materials/{calculator?}', [CalculatorController::class, 'materials'])->name('materials');
        Route::get('preview/{calculator?}', [CalculatorController::class, 'preview'])->name('preview');
        Route::get('laminations/{calculator?}', [CalculatorController::class, 'laminations'])->name('laminations');
        Route::get('cuttings/{calculator?}', [CalculatorController::class, 'cuttings'])->name('cuttings');
        Route::get('count/{calculator?}', [CalculatorController::class, 'count'])->name('count');
        Route::get('discount/{calculator?}', [CalculatorController::class, 'discount'])->name('discount');
        Route::get('prices/{calculator?}', [CalculatorController::class, 'prices'])->name('prices');
    });
});

Route::any('test', [CalculatorController::class, 'test']);

Route::get('/get_calc_types', [CalculatorController::class, 'getCalcTypes']);
Route::get('/get_calc_config', [CalculatorController::class, 'getCalcConfig']);
Route::get('/get_calc_materials', [CalculatorController::class, 'getCalcMaterials']);
Route::get('/get_calc_lams', [CalculatorController::class, 'getCalcLams']);
Route::get('/get_calc_cuttings', [CalculatorController::class, 'getCalcCuttings']);
Route::get('/get_calc_preview', [CalculatorController::class, 'getCalcPreview']);
Route::any('/count_calc', [CalculatorController::class, 'countCalc']);

Route::get('calculator/service/test/{calculator}', [CalculatorController::class, 'test']);

Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/promocodes', [PromocodeController::class, 'check']);

Route::post('/orders', [OrderController::class, 'create']);

Route::prefix('suggest')->group(function () {
    Route::post('/companies', [SuggestController::class, 'company']);
    Route::post('/addresses', [SuggestController::class, 'address']);
    Route::post('/names', [SuggestController::class, 'name']);
});
