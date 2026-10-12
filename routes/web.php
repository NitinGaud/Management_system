<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Inventory;
use App\Http\Controllers\Master_data;
use App\Http\Controllers\Report;
use App\Http\Controllers\Dealer_data;



Route::get('/signin', [Authentication::class, 'index'])->name('signin');
Route::post('/authenticate', [Authentication::class, 'authenticate'])->name('authenticate');
Route::get('/dashboard', [Dashboard::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/add_inventory', [Inventory::class, 'add_inventory'])->middleware('auth')->name('add_inventory');
Route::post('/inventory_insert', [Inventory::class, 'inventory_insert'])->middleware('auth')->name('inventory_insert');
Route::get('/add_master_data', [Master_data::class, 'add_master_data'])->middleware('auth')->name('add_master_data');
Route::post('/master_insert', [Master_data::class, 'master_insert'])->middleware('auth')->name('master_insert');
Route::get('/inventory_list', [Inventory::class, 'index'])->middleware('auth')->name('inventory_list');
Route::get('/master_list', [Master_data::class, 'index'])->middleware('auth')->name('master_list');
Route::post('/set_inventory_session', [Inventory::class, 'set_inventory_session'])->name('set_inventory_session');
Route::get('/update_inventory', [Inventory::class, 'update_inventory'])->middleware('auth')->name('update_inventory');
Route::post('/delete_inventory_image', [Inventory::class, 'delete_inventory_image'])->name('delete_inventory_image');
Route::post('/delete_inventory', [Inventory::class, 'delete_inventory'])->name('delete_inventory');
Route::get('/log_list', [Inventory::class, 'log_list'])->name('log_list');
Route::post('/update_inventory_data', [Inventory::class, 'update_inventory_data'])->name('update_inventory_data');
Route::get('/reports', [Report::class, 'index'])->name('reports');
Route::post('/generate_report', [Report::class, 'generate_report'])->name('generate_report');
Route::get('/dealer_details', [Dealer_data::class, 'index'])->name('dealer_details');
Route::get('/add_dealer', [Dealer_data::class, 'add_dealer'])->name('add_dealer');
Route::post('/insert_dealer_data', [Dealer_data::class, 'insert_dealer_data'])->name('insert_dealer_data');
Route::post('/set_dealer_session', [Dealer_data::class, 'set_dealer_session'])->name('set_dealer_session');
Route::get('/edit_dealer', [Dealer_data::class, 'edit_dealer'])->name('edit_dealer');
Route::post('/delete_dealer', [Dealer_data::class, 'delete_dealer'])->name('delete_dealer');

require __DIR__.'/auth.php';