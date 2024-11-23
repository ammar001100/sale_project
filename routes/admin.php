<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AccountTypeController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AdminShiftController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CollectController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DelegateController;
use App\Http\Controllers\Admin\ExchangeController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\ItemcardCategoryController;
use App\Http\Controllers\Admin\ItemCardController;
use App\Http\Controllers\Admin\SaleInvoiceController;
use App\Http\Controllers\Admin\SalesMatrialTypeController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\SupplierCategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SupplierWithOrderController;
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
    route::post('/item_cards/ajax_search', [ItemCardController::class, 'ajax_search'])
        ->name('item_cards.ajax_search');
    /***  END ITEMCARD  ***/
    /***  ACCOUNT TYPES  ***/
    Route::get('/account_types', [AccountTypeController::class, 'index'])
        ->name('account_types.index');
    /***  END ACCOUNT TYPES  ***/
    /***  ACCOUNTS  ***/
    Route::resource('/accounts', AccountController::class);
    route::post('/accounts/ajax_search', [AccountController::class, 'ajax_search'])
        ->name('accounts.ajax_search');
    /***  END ACCOUNTS  ***/
    /***  CUSTOMERS  ***/
    Route::resource('/customers', CustomerController::class);
    route::post('/customers/ajax_search', [CustomerController::class, 'ajax_search'])
        ->name('customers.ajax_search');
    /***  END CUSTOMERS  ***/
    /***  SUPPLIER CATEGORIES  ***/
    Route::resource('/supplier_categories', SupplierCategoryController::class);
    /***  END SUPPLIER CATEGORIES  ***/
    /***  Suppliers  ***/
    Route::resource('/suppliers', SupplierController::class);
    route::post('/suppliers/ajax_search', [SupplierController::class, 'ajax_search'])
        ->name('suppliers.ajax_search');
    /***  END Suppliers  ***/
    /***  delegates  ***/
    Route::resource('/delegates', DelegateController::class);
    route::post('/delegates/ajax_search', [DelegateController::class, 'ajax_search'])
        ->name('delegates.ajax_search');
    /***  END delegates  ***/
    /***  supplier with orders  ***/
    Route::resource('/supplier_orders', SupplierWithOrderController::class);
    route::post('/supplier_orders/ajax_search', [SupplierWithOrderController::class, 'ajax_search'])
        ->name('supplier_orders.ajax_search');
    route::post('/supplier_orders/ajax_get_uom', [SupplierWithOrderController::class, 'ajax_get_uom'])
        ->name('supplier_orders.ajax_get_uom');
    route::post('/supplier_orders/ajax_add_uom', [SupplierWithOrderController::class, 'ajax_add_uom'])
        ->name('supplier_orders.ajax_add_uom');
    route::post('/supplier_orders/ajax_delete_item_card', [SupplierWithOrderController::class, 'ajax_delete_item_card'])
        ->name('supplier_orders.ajax_delete_item_card');
    route::post('/supplier_orders/load_modal_approve_invoice', [SupplierWithOrderController::class, 'approve_invoice'])
        ->name('supplier_orders.load_modal_approve_invoice');
    route::post('/supplier_orders/approve_invoice_now', [SupplierWithOrderController::class, 'approve_invoice_now'])
        ->name('supplier_orders.approve_invoice_now');
    route::post('/supplier_orders/approved', [SupplierWithOrderController::class, 'do_approved'])
        ->name('supplier_orders.approved');
    /***  END supplier with orders  ***/
    /***  CUSTOMERS  ***/
    Route::resource('/admin_accounts', AdminAccountController::class);
    route::get('/admin_accounts/add/treasury/{id}', [AdminAccountController::class, 'add_treasury'])
        ->name('admin_accounts.add_treasury');
    route::post('/admin_accounts/store/treasury/{id}', [AdminAccountController::class, 'store_treasury'])
        ->name('admin_accounts.store_treasury');
    route::get('/admin_accounts/deleted/treasury/{id}', [AdminAccountController::class, 'delete_treasury'])
        ->name('admin_accounts.delete_treasury');
    /***  END CUSTOMERS  ***/
    /***  ADMIN SHIFTS  ***/
    Route::resource('/admin_shifts', AdminShiftController::class);
    route::post('/admin_shifts/ajax_search', [AdminShiftController::class, 'ajax_search'])
        ->name('admin_shifts.ajax_search');
    /***  END ADMIN SHIFTS  ***/
    /***  collect transactions  ***/
    Route::resource('/collect_transactions', CollectController::class);
    route::post('/collect_transactions/ajax_search', [CollectController::class, 'ajax_search'])
        ->name('collect_transactions.ajax_search');
    /***  END collect transactions  ***/
    /***  exchange transactions  ***/
    Route::resource('/exchange_transactions', ExchangeController::class);
    route::post('/exchange_transactions/ajax_search', [ExchangeController::class, 'ajax_search'])
        ->name('exchange_transactions.ajax_search');
    /***  END exchange transactions  ***/
    /**  sale invoices  ***/
    Route::resource('/sale_invoices', SaleInvoiceController::class);
    route::post('/sale_invoices/ajax_search', [SaleInvoiceController::class, 'ajax_search'])
        ->name('sale_invoices.ajax_search');
    route::post('/sale_invoices/ajax_get_uom', [SaleInvoiceController::class, 'ajax_get_uom'])
        ->name('sale_invoices.ajax_get_uom');
    route::post('/sale_invoices/ajax_get_uom_', [SaleInvoiceController::class, 'ajax_get_uom_'])
        ->name('sale_invoices.ajax_get_uom_');
    route::post('/sale_invoices/get_item_card_batches', [SaleInvoiceController::class, 'get_item_card_batches'])
        ->name('sale_invoices.get_item_card_batches');
    route::post('/sale_invoices/get_item_card_batches_', [SaleInvoiceController::class, 'get_item_card_batches_'])
        ->name('sale_invoices.get_item_card_batches_');
    route::post('/sale_invoices/get_unit_cost_price', [SaleInvoiceController::class, 'get_unit_cost_price'])
        ->name('sale_invoices.get_unit_cost_price');
    route::post('/sale_invoices/get_unit_cost_price_', [SaleInvoiceController::class, 'get_unit_cost_price_'])
        ->name('sale_invoices.get_unit_cost_price_');
    route::post('/sale_invoices/get_new_item_row', [SaleInvoiceController::class, 'get_new_item_row'])
        ->name('sale_invoices.get_new_item_row');
    route::post('/sale_invoices/get_new_item_row_', [SaleInvoiceController::class, 'get_new_item_row_'])
        ->name('sale_invoices.get_new_item_row_');
    //route::post('/sale_invoices/ajax_delete_item_card', [SaleInvoiceController::class, 'ajax_delete_item_card'])
    //    ->name('sale_invoices.ajax_delete_item_card');
    //route::post('/sale_invoices/load_modal_approve_invoice', [SaleInvoiceController::class, 'approve_invoice'])
    //    ->name('sale_invoices.load_modal_approve_invoice');
    /***  END sale invoices  ***/
});
