<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\ItemcardCategoryController;
use App\Http\Controllers\Admin\ItemCardController;
use App\Http\Controllers\Admin\SalesMatrialTypeController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\TreasuryController;
use App\Http\Controllers\Admin\UomController;
use Illuminate\Support\Facades\Route;

define('PAGINATION_COUNT', 5);

/***  ADMIN AUTH  ***/
Route::get('login', [AuthController::class, 'login'])->name('admin.login');
Route::post('login', [AuthController::class, 'getLogin'])->name('admin.getLogin');
/******* Group ****/
Route::group(['prefix' => '/', 'middleware' => 'auth:admin'], function () {
    /***  DASHBOARD  ***/
    route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');
    /***  LOGOUT  ***/
    route::get('/logout', [AuthController::class, 'logout'])
        ->name('admin.logout');
    /***  GENERAL SETTING  ***/
    Route::group(['prefix' => '/setting/general'], function () {
        route::get('/', [GeneralSettingController::class, 'index'])
            ->name('admin.setting.general');
        route::get('/edit', [GeneralSettingController::class, 'edit'])
            ->name('admin.setting.general.edit');
        route::post('/update', [GeneralSettingController::class, 'update'])
            ->name('admin.setting.general.update');
    });

    /***  TREASURIES  ***/
    Route::group(['prefix' => '/treasuries'], function () {
        route::get('/', [TreasuryController::class, 'index'])
            ->name('admin.treasuries');
        route::get('/create', [TreasuryController::class, 'create'])
            ->name('admin.treasuries.create');
        route::post('/store', [TreasuryController::class, 'store'])
            ->name('admin.treasuries.store');
        route::get('/edit/{id}', [TreasuryController::class, 'edit'])
            ->name('admin.treasuries.edit');
        route::post('/update/{id}', [TreasuryController::class, 'update'])
            ->name('admin.treasuries.update');
        route::post('/ajax_search', [TreasuryController::class, 'ajax_search'])
            ->name('admin.treasuries.ajax_search');
        route::get('/details/{id}', [TreasuryController::class, 'show'])
            ->name('admin.treasuries.show');
        // treasuries delivery
        route::get('/add_treasuries_delivery/{id}', [TreasuryController::class, 'add_treasuries_delivery'])
            ->name('admin.treasuries.add_treasuries_delivery');
        route::post('/store_treasuries_delivery/{id}', [TreasuryController::class, 'store_treasuries_delivery'])
            ->name('admin.treasuries.store_treasuries_delivery');
        route::get('/delete_treasuries_deliveryete/{id}', [TreasuryController::class, 'delete_treasuries_delivery'])
            ->name('admin.treasuries.delete_treasuries_delivery');
    });
    /***  END TREASURIES  ***/
    /***  SALES MATRIAL TYPES  ***/
    Route::group(['prefix' => '/sales_matrial_types'], function () {
        route::get('/', [SalesMatrialTypeController::class, 'index'])
            ->name('admin.sales_matrial_types');
        route::get('/create', [SalesMatrialTypeController::class, 'create'])
            ->name('admin.sales_matrial_types.create');
        route::post('/store', [SalesMatrialTypeController::class, 'store'])
            ->name('admin.sales_matrial_types.store');
        route::get('/edit/{id}', [SalesMatrialTypeController::class, 'edit'])
            ->name('admin.sales_matrial_types.edit');
        route::post('/update/{id}', [SalesMatrialTypeController::class, 'update'])
            ->name('admin.sales_matrial_types.update');
        route::get('/delete/{id}', [SalesMatrialTypeController::class, 'destroy'])
            ->name('admin.sales_matrial_types.delete');
    });
    /***  END SALES MATRIAL TYPES  ***/
    /***  STORES  ***/
    Route::group(['prefix' => '/stores'], function () {
        route::get('/', [StoreController::class, 'index'])
            ->name('admin.stores');
        route::get('/create', [StoreController::class, 'create'])
            ->name('admin.stores.create');
        route::post('/store', [StoreController::class, 'store'])
            ->name('admin.stores.store');
        route::get('/edit/{id}', [StoreController::class, 'edit'])
            ->name('admin.stores.edit');
        route::post('/update/{id}', [StoreController::class, 'update'])
            ->name('admin.stores.update');
        route::get('/delete/{id}', [StoreController::class, 'destroy'])
            ->name('admin.stores.delete');
    });
    /***  END STORES  ***/
    /***  UOMS  ***/
    Route::group(['prefix' => '/uoms'], function () {
        route::get('/', [UomController::class, 'index'])
            ->name('admin.uoms');
        route::get('/create', [UomController::class, 'create'])
            ->name('admin.uoms.create');
        route::post('/store', [UomController::class, 'store'])
            ->name('admin.uoms.store');
        route::get('/edit/{id}', [UomController::class, 'edit'])
            ->name('admin.uoms.edit');
        route::post('/update/{id}', [UomController::class, 'update'])
            ->name('admin.uoms.update');
        route::get('/delete/{id}', [UomController::class, 'destroy'])
            ->name('admin.uoms.delete');
        route::post('/ajax_search', [UomController::class, 'ajax_search'])
            ->name('admin.uoms.ajax_search');
    });
    /***  END UOMS  ***/
    /***  ITEMCARD CATEGORY  ***/
    Route::resource('/itemcard_categories', ItemcardCategoryController::class);
    /***  END ITEMCARD CATEGORY  ***/
    /***  ITEMCARD  ***/
    Route::resource('/item_cards', ItemCardController::class);
    /***  END ITEMCARD  ***/
});
