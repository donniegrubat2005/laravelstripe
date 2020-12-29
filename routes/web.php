<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;
use App\Mail\EmailConfirmation;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email', function () {

    //Mail::to('donniegrubat2005@gmail.com')->send(new EmailConfirmation);
    return new EmailConfirmation;
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('create/plan', [PlanController::class, 'createPlan'])->name('create.plan');
    Route::post('store/plan', [PlanController::class, 'storePlan'])->name('store.plan');
    Route::get('allplans', [PlanController::class, 'allplans'])->name('plans.allplans');
    // Route::get('plans/{id}', [PlanController::class, 'editPlan'])->name('plans.editPlan');
    // Route::put('plans/{id}', [PlanController::class, 'updateUpdate'])->name('plans.updateUpdate');


    Route::get('/plans/{plan}', [SubscriptionController::class, 'show'])->name('plans.show');

    //Route::post('/payments', [SubscriptionController::class, 'store'])->name('payment.store');
    Route::post('/payments', [SubscriptionController::class, 'subscribe'])->name('payments.subscribe');
    Route::get('/payments/invoices', [SubscriptionController::class, 'sendInvoiceReceipt'])->name('payment.invoices.sendInvoiceReceipt');
    Route::get('/invoices', [SubscriptionController::class, 'viewInvoiceReceipt'])->name('payment.invoices.viewInvoiceReceipt');

    Route::get('/sendemail', [PlanController::class, 'sendEmail'])->name('sendEmail');

    Route::get('/transactions', [SubscriptionController::class, 'transaction'])->name('transaction');


    Route::post('subscription', [SubscriptionController::class, 'create'])->name('subscription.create');
});
