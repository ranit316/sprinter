<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqCategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\ProfileViewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\CmspaageController;
use App\Http\Controllers\FaqtypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::redirect('/' , '/login');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('global/search/{search}', [GlobalSearchController::class, 'index'])->name('global.search');
 
Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    
    Route::resource('notifications', NotificationController::class);
    Route::resource('profile', ProfileViewController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('platforms', PlatformController::class);
    Route::resource('contests', ContestController::class);
    Route::resource('offers', OfferController::class);
    Route::resource('events', EventController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('faq_category', FaqCategoryController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('support-whatsapp', SupportController::class);
    Route::resource('cms_pages', CmspaageController::class);
    Route::get('cms_pages/delete/{id}',[CmspaageController::class,'destroy'])->name('cms_page.destroy');
    Route::resource('faq_types', FaqtypeController::class);

    Route::POST('user-export', [UserController::class, 'exportexcel'])->name('user.excel.export');
    Route::POST('user-csv-export', [UserController::class, 'exportcsv'])->name('user.csv.export');
    Route::POST('user-pdf-export', [UserController::class, 'exportpdf'])->name('user.pdf.export');

    Route::POST('role-export', [RoleController::class, 'exportexcel'])->name('role.excel.export');
    Route::POST('role-csv-export', [RoleController::class, 'exportcsv'])->name('role.csv.export');
    Route::POST('role-pdf-export', [RoleController::class, 'exportpdf'])->name('role.pdf.export');

    Route::POST('permission-export', [PermissionController::class, 'exportexcel'])->name('permission.excel.export');
    Route::POST('permission-csv-export', [PermissionController::class, 'exportcsv'])->name('permission.csv.export');
    Route::POST('permission-pdf-export', [PermissionController::class, 'exportpdf'])->name('permission.pdf.export');

    Route::POST('platform-export', [PlatformController::class, 'exportexcel'])->name('platform.excel.export');
    Route::POST('platform-csv-export', [PlatformController::class, 'exportcsv'])->name('platform.csv.export');
    Route::POST('platform-pdf-export', [PlatformController::class, 'exportpdf'])->name('platform.pdf.export');


    Route::POST('faq_category-export', [FaqCategoryController::class, 'exportexcel'])->name('faq_category.excel.export');
    Route::POST('faq_category-csv-export', [FaqCategoryController::class, 'exportcsv'])->name('faq_category.csv.export');
    Route::POST('faq_category-pdf-export', [FaqCategoryController::class, 'exportpdf'])->name('faq_category.pdf.export');

    Route::POST('category-export', [CategoryController::class, 'exportexcel'])->name('category.excel.export');
    Route::POST('category-csv-export', [CategoryController::class, 'exportcsv'])->name('category.csv.export');
    Route::POST('category-pdf-export', [CategoryController::class, 'exportpdf'])->name('category.pdf.export');

    Route::POST('contest-export', [ContestController::class, 'exportexcel'])->name('contest.excel.export');
    Route::POST('contest-csv-export', [ContestController::class, 'exportcsv'])->name('contest.csv.export');
    Route::POST('contest-pdf-export', [ContestController::class, 'exportpdf'])->name('contest.pdf.export');

    Route::POST('event-export', [EventController::class, 'exportexcel'])->name('event.excel.export');
    Route::POST('event-csv-export', [EventController::class, 'exportcsv'])->name('event.csv.export');
    Route::POST('event-pdf-export', [EventController::class, 'exportpdf'])->name('event.pdf.export');

    Route::POST('offer-export', [OfferController::class, 'exportexcel'])->name('offer.excel.export');
    Route::POST('offer-csv-export', [OfferController::class, 'exportcsv'])->name('offer.csv.export');
    Route::POST('offer-pdf-export', [OfferController::class, 'exportpdf'])->name('offer.pdf.export');

    Route::POST('customer-export', [CustomerController::class, 'exportexcel'])->name('customer.excel.export');
    Route::POST('customer-csv-export', [CustomerController::class, 'exportcsv'])->name('customer.csv.export');
    Route::POST('customer-pdf-export', [CustomerController::class, 'exportpdf'])->name('customer.pdf.export');
    Route::get('customer/refferel/{id}',[CustomerController::class, 'refferel_list'])->name('customer.refferel');

    Route::POST('review-export', [ReviewController::class, 'exportexcel'])->name('review.excel.export');
    Route::POST('review-csv-export', [ReviewController::class, 'exportcsv'])->name('review.csv.export');
    Route::POST('review-pdf-export', [ReviewController::class, 'exportpdf'])->name('review.pdf.export');

    Route::POST('faq-export', [FaqController::class, 'exportexcel'])->name('faq.excel.export');
    Route::POST('faq-csv-export', [FaqController::class, 'exportcsv'])->name('faq.csv.export');
    Route::POST('faq-pdf-export', [FaqController::class, 'exportpdf'])->name('faq.pdf.export');


    Route::get('appinfo-index', [AppInfoController::class, 'index'])->name('appinfo.index');
    Route::post('appinfo-update', [AppInfoController::class, 'update'])->name('appinfo.update');

    Route::get('type-category/{type}',[FaqController::class,'category'])->name('type.category');

    Route::get('logout',[LoginController::class,'logout'])->name('logout');
    // Route::get('page',[LoginController::class,'pages'])->name('pages');
});
