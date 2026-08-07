<?php

use App\Http\Livewire\HomeDashboard;
use App\Http\Livewire\PaymentOrderManager;
use App\Http\Livewire\PurchaseRequestForm;
use App\Http\Livewire\PurchaseRequestList;
use App\Http\Livewire\PurchaseRequestShow;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeDashboard::class);

Route::get('/purchase-requests', PurchaseRequestList::class);
Route::get('/purchase-requests/create', PurchaseRequestForm::class);
Route::get('/purchase-requests/{purchaseRequest}', PurchaseRequestShow::class);
Route::get('/purchase-requests/{purchaseRequest}/edit', PurchaseRequestForm::class);
Route::get('/purchase-requests/{purchaseRequest}/payment-orders', PaymentOrderManager::class);
