<?php

use App\Http\Controllers\DataTableController;
use App\Http\Controllers\GstbillController;
use App\Http\Controllers\NewPostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiUserController;
use App\Models\State;

//Route::get('/',function (){
//   $state = State::all();
//   $city = \App\Models\City::first();
//
//   dd($state->toArray());
//});

//-----Login to Admin & User
Route::prefix('/authentication')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'login')->name('login')->middleware('alreadyLoggedIn');
        Route::get('register-user', 'register')->name('registerLogin');
        Route::post('register-user', 'store')->name('register-user');
        Route::post('check-login', 'checkLogin')->name('check-login');
        Route::get('email-verify/{id?}/{token_key?}', 'emailVerify')->name('email-verify');
        Route::post('set-new-password', 'setNewPassword')->name('set-new-password');
        Route::post('set-forgot-password', 'setForgotPassword')->name('set-forgot-password');
        Route::get('forgot-password', 'forgotPassword')->name('forgot-password');
        Route::post('email-check', 'emailCheck')->name('email-check');
        Route::get('view-forget-password/{id?}/{token_key?}', 'viewForgotPassword')->name('view-forget-password');

        //----For using collection methods
        Route::get('/collection-methods', 'implementCollection');

        //-- for using helpers method
        Route::get('/helpers-methods', 'implementHelper');
    });
});

Route::get('/index', [TestController::class, 'index']);
Route::middleware(['disableBackBtn','authAdmin'])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/register', 'index')->name('view-user-admin');
            Route::get('/getState', 'getState')->name('getState');
            Route::get('/getCity', 'getCity')->name('getCity');
            Route::post('/register', 'store')->name('register');
            Route::get('/registerList', 'show')->name('register.show');
            Route::delete('/delete/{id?}', 'delete')->name('register.delete');
            Route::get('edit/{id?}/{cityId?}', 'getUserDetails')->name('get.user.details');
            Route::post('edit/{id?}', 'store')->name('register.update');
            Route::get('/relation/{id?}', 'relation');


            //-------import excel file for multiple mail
            Route::view('/upload-excel-view', 'importxlsmail')->name('upload.excel.view');
            Route::post('users-excel-import', 'import')->name('users.excel.import');

            Route::get('test-http', 'testHttp');
            Route::get('api-test', 'apiTest');
            Route::get('api-demo', 'demo');
            Route::get('test', 'test')->name('test');
        });

        Route::resource('roles', RoleController::class);
        Route::get('datatable', [DataTableController::class, 'index'])->name('datatable');

        //-----Product Crud

        Route::controller(ProdController::class)->group(function () {
            Route::get('/product-list', 'index')->name('product-list');
            Route::post('/product-create/{id?}', 'store')->name('product-create');
            Route::get('/product-show', 'show')->name('product-show');
            Route::get('/product-delete/{product}', 'delete')->name('product-delete');
            Route::get('/product-edit/{id?}', 'edit')->name('product-edit');
            //Route::post('/product-update/{id?}','update')->name('product-update');
        });

        //----- Create Discount with product and variant wise (Using Eloquent relationship), List and Edit

        Route::controller(DiscountController::class)->group(function () {
            Route::get('/discount-list', 'index')->name('discount-list');
            Route::post('/discount-create', 'store')->name('discount-create');
            Route::get('/discount-show', 'show')->name('discount-show');
            Route::get('/discount-delete/{discount}', 'destroy')->name('discount-delete');
            Route::get('/discount-edit/{discount?}', 'edit')->name('discount-edit');
        });

        Route::controller(GstbillController::class)->group(function () {
            Route::get('/gstbill', 'create')->name('users');
            Route::post('/getUser/{id?}', 'getUser')->name('getUser');
            Route::post('/getProducts/{id?}', 'getProducts')->name('getProducts');
            Route::post('/invoice', 'store')->name('invoice.store');
            Route::get('/showbill', 'index')->name('index.show');
            Route::get('/viewgstbills', 'show')->name('view-gst-list');
            Route::get('/invoice-delete/{invoice}', 'destroy')->name('invoice-delete');
            Route::get('/invoice-edit/{invoice}', 'edit')->name('invoice-edit');

            //--Get Ajax data of Users____ limit-10
            Route::get('/get-users', 'getUsers')->name('get.users');
        });
    });
});

Route::controller(UserController::class)->group(function () {
    Route::get('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => ['disableBackBtn', 'authUser']], function () {
    Route::prefix('/user')->group(function () {
        Route::view('/home', 'user.home')->name('home1');
        // ----GST Invoice Using Jquery----


        Route::controller(ProfileController::class)->group(function () {

            Route::get('profile-create', 'create')->name('profile.create');
            Route::post('profile-create', 'changeProfile')->name('profile.change');
            Route::get('view-profile-password', 'viewPassword')->name('view.profile.password');
            Route::post('change-profile-password', 'changePassword')->name('change.profile.password');
            Route::get('export-user-data', 'exportUserData')->name('export.user.data');
        });

        Route::resource('posts', NewPostController::class);
    });
});
















//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


