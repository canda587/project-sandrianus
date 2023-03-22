<?php

use App\Models\Item;
use App\Models\Apriori;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SelfController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\admin\ItemController;
use App\Http\Controllers\ExpeditionController;
use App\Http\Controllers\user\OrderController;
use App\Http\Controllers\AutenticateController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\OrderAdminController;
use App\Http\Controllers\user\TransactionController;
use App\Http\Controllers\admin\TransactionAdminController;

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
// main -----------------------------------------
// home
Route::get('/', [HomeController::class,'index'])->name("home");
// detail item
Route::get('/detail/{item:slug}',[HomeController::class,'detail']);


Route::middleware(['auth'])->group(function() {
    // region
    Route::get('/region/allProvince',[RegionController::class,'all_province']);
    Route::get('/region/allCity',[RegionController::class,'all_city']);
    Route::post('/region/store',[RegionController::class,'store']);
    Route::post('/region/getRegion',[RegionController::class,'get_region']);
    Route::put('/region/{region:code}',[RegionController::class,'update']);
    Route::delete('/region/{region:code}',[RegionController::class,'destroy']);
    Route::post('/expedition',[ExpeditionController::class,'get_service']);
    // end region

    // self
    Route::put("/self/{user:email}",[SelfController::class,'update']);
    // end self
});

// user---------------------------------------
Route::middleware(['is_user'])->group(function(){

    // my profile
    Route::get('/user',[UserController::class,'index']);
    // end my profile

    // cart
    Route::post("/user/carts/getList",[CartController::class,"get_list"]);
    Route::delete("/user/carts/deleteAll",[CartController::class,"delete_all"]);
    Route::get("/user/carts/checkout",[CartController::class,"checkout"]);
    Route::resource('/user/carts', CartController::class);
    // end cart
    
    // order
    Route::resource('/user/orders', OrderController::class);
    Route::put('/user/orders/upload/{order:code}', [OrderController::class,"upload"]);
    Route::post('/user/orders/addAll', [OrderController::class,"store_all"]);
    Route::put('/user/orders/cancel/{order:code}', [OrderController::class,"order_cancel"]);
    // end order

    // transaction
    Route::get('/user/transactions',[TransactionController::class,"index"]);
    Route::get('/user/transactions/{order:code}',[TransactionController::class,"show"]);
    Route::delete('/user/transactions/{order:code}',[TransactionController::class,"destroy"]);
    // end transaction
});





// end user -----------------------------------------------

// admin ------------------------------------------------
Route::middleware(['is_admin'])->group(function(){
    // dashboard
    Route::get('/admin', [DashboardController::class,"index"]);
    Route::get('/admin/test', [DashboardController::class,"test"]);
    // end dashboard

    // product
    Route::post("/admin/items/generateSlug",[ItemController::class,"generate_slug"]);
    Route::resource('/admin/items', ItemController::class)->except("show");
    // end product

    // category
    Route::post("/admin/categories/generateSlug",[CategoryController::class,"generate_slug"]);
    Route::resource('/admin/categories', CategoryController::class)->except('show');
    // end category

    // order
    Route::get("/admin/orders",[OrderAdminController::class,"index"]);
    Route::get("/admin/orders/{order:code}",[OrderAdminController::class,"show"]);
    Route::put("/admin/orders/updateStatus/{order:code}",[OrderAdminController::class,"update_status"]);
    Route::put("/admin/orders/setPayment/{order:code}",[OrderAdminController::class,"set_payment"]);
    // end order

    // transaction
    Route::get("/admin/transactions",[TransactionAdminController::class,"index"]);
    Route::get("/admin/transactions/{transaction:code}",[TransactionAdminController::class,"show"]);
    Route::delete("/admin/transactions/{transaction:code}",[TransactionAdminController::class,"destroy"]);
    // end transaction
});






// end admin -----------------------------------------------



Route::get('/auth', [AutenticateController::class,'index'])->middleware("guest")->name("login");
Route::post('/auth', [AutenticateController::class,'autenticate'])->middleware("guest");
Route::post('/logout', [AutenticateController::class,'logout'])->middleware("auth");



Route::get('/regis',[RegisterController::class,'index'])->middleware("guest")->name("regis");
Route::post('/regis',[RegisterController::class,'store'])->middleware("guest");



// tester

Route::get('/tester', function () {
    
    return view('tester');
});

Route::get('/apriori', function () {
    $recomendation = new Apriori();
    $data = [
        'frekuensi' => $recomendation->get_frequency(),
        'item_set' => $recomendation->item_set_data(),
        'apriori_data' => $recomendation->all_apriori_data(),
        'find_apriori'=> $recomendation->find_apriori_data("baju-hitam-wanita|baju-wanita-cantik"),
    ];
    
    // $test = new Apriori("waooo");
    // $data = [
    //     'data' => $test->test()
    // ];
    return view('apriori',$data);
});