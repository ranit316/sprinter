<?php


use App\Http\Controllers\User\AppInfoController;
use App\Http\Controllers\User\AppSettingController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\FaqController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\ReferalController;
use App\Http\Controllers\User\ResultController;
use App\Http\Controllers\User\RiviewController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\SupportController;
use App\Models\Notification;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/email/verify', [AuthController::class, 'checkemail']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//Route::post('/otp/validation',[AuthController::class,'otpvalidation']);
Route::get('/support', [AppInfoController::class, 'appinfo']);
Route::post('/forgot/password', [AuthController::class, 'forgotpassword']);
Route::post('/reset/password', [AuthController::class, 'resetpassword']);
//Route::post('/sendNotification',[NotificationController::class, 'sendpushnotification']);
Route::get('/platfrom', [GameController::class, 'platfrom']);
//Route::post('/support/feedback', [SupportController::class, 'support']);


Route::middleware('auth:api')->group(function () {
    Route::post('/appsetting', [AppSettingController::class, 'appsetting']);
    Route::get('/dashboard', [GameController::class, 'dashboard']);
    Route::put('/dashboard/list/{type}', [GameController::class, 'list_view']);
    Route::get('/category', [CategoryController::class, 'catagory']);
    //Route::get('/platfrom', [GameController::class, 'platfrom']);
    Route::get('/faq/categoy', [FaqController::class, 'category']);
    Route::get('/reviews', [RiviewController::class, 'review']);
    Route::post('/reviews/post', [RiviewController::class, 'postreview']);
    Route::post('/list/category/dashboard', [GameController::class, 'list_category']);
    Route::post('/search', [SearchController::class, 'index']);
    Route::post('/update/profile', [AuthController::class, 'profile']);
    Route::get('/offer', [NotificationController::class, 'offer']);
    Route::get('/refference/list', [ReferalController::class, 'list']);
    Route::get('/type', [FaqController::class, 'type']);
    Route::post('/faq/question', [FaqController::class, 'faq']);
    Route::get('/notification', [NotificationController::class, 'notification']);
    Route::post('/delete/notification',[NotificationController::class,'deleteNotification']);
    Route::post('/updatepassword', [AuthController::class, 'updatepassword']);
    Route::post('/google/sheet', [ResultController::class, 'getGoogleSheetValue']);
    Route::post('/support/feedback', [SupportController::class, 'support']);
    Route::get('/logout',[AuthController::class, 'logout']);
});
