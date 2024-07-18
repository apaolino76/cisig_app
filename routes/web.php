<?php

use App\Http\Controllers\Admin\Academico\ModalidadesController;
use App\Http\Controllers\Admin\Adjust\AdjustController;
use App\Http\Controllers\Admin\Financeiro\APIInterController;
use App\Http\Controllers\Admin\Financeiro\Baixa4iesArquivoController;
use App\Http\Controllers\Admin\Financeiro\Baixa4iesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('site.index');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/admin/financeiro/bancoInter/{reference?}', [APIInterController::class, 'index'])
    ->name('admin.financeiro.bancoInter')
    ->where([
        'reference', '[0-9]+',
    ]);
});
