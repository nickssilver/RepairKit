<?php
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BackupController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CustomPageController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DefectController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\ImportController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\Language\LanguageController as LocaleLanguageController;
use App\Http\Controllers\Api\Media\MediaController;
use App\Http\Controllers\Api\PaymentGatewaysController;
use App\Http\Controllers\Api\PrintController;
use App\Http\Controllers\Api\QuickReplyController;
use App\Http\Controllers\Api\RepairLogController;
use App\Http\Controllers\Api\RepairOrderAxillaryController;
use App\Http\Controllers\Api\RepairOrderController;
use App\Http\Controllers\Api\RepairPriorityController;
use App\Http\Controllers\Api\RepairStatusController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SettingAxillaryController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SmsGatewaysController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserRoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::get('system-config', [ApiController::class, 'protection'])->name('system.config');

Route::group(['middleware' => 'isAjax', 'prefix' => config('app.version', 'codehas')], function () {
    Route::post('/contact-us', [SupportController::class, 'contactUs'])->name('contact.us');
    Route::get('files/{file}', [MediaController::class, 'show'])->name('files.show');
    Route::post('files', [MediaController::class, 'store'])->name('files.store');
    Route::get('quick/replies/list', [QuickReplyController::class, 'quickRepliesList'])->name('quick-replies.list');
    Route::get('print/{repairOrder}/repair/order', [PrintController::class, 'repair'])->name('repair-orders.print');
    Route::get('print/{repairOrder}/dispatch/info', [PrintController::class, 'dispatchInfo'])->name('repair-dispatch.print');
    Route::get('tax/implementation', [RepairOrderAxillaryController::class, 'getTax'])->name('repair.get.tax');

    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::post('register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('recover', [AuthController::class, 'recover'])->name('auth.recover');
        Route::post('reset', [AuthController::class, 'reset'])->name('auth.reset');
        Route::get('user', [AuthController::class, 'user'])->name('auth.user');
        Route::post('check', [AuthController::class, 'check'])->name('auth.check');
    });

    Route::group(['prefix' => 'lang', 'namespace ' => 'Language'], function () {
        Route::get('/', [LocaleLanguageController::class, 'languageList'])->name('language.list');
        Route::get('/{lang}', [LocaleLanguageController::class, 'get'])->name('language.get');
    });

    Route::group(['prefix' => 'account', 'middleware' => 'auth:sanctum'], function () {
        Route::post('update', [AccountController::class, 'update'])->name('account.update');
        Route::post('password', [AccountController::class, 'password'])->name('account.password');
    });

    Route::group(['prefix' => 'repair'], function () {
        Route::post('booking', [RepairOrderController::class, 'store'])->name('repair.order.book');
        Route::get('brand/list', [RepairOrderAxillaryController::class, 'brandList'])->name('repair.brand.list');
        Route::post('device/list', [RepairOrderAxillaryController::class, 'brandDevices'])->name('repair.device.list');
        Route::post('defect/list', [RepairOrderAxillaryController::class, 'deviceDefects'])->name('repair.defect.list');
        Route::post('quick/actions', [RepairOrderAxillaryController::class, 'quickActions'])->name('repair-orders.quick.actions');
        Route::post('track', [RepairOrderAxillaryController::class, 'track'])->name('repair.track');
        /*-----under auth--------*/
        Route::get('filers', [RepairOrderAxillaryController::class, 'filters'])->name('repair-orders.filters');
        Route::post('assign/{repairOrder}/user', [RepairOrderAxillaryController::class, 'assignUser'])->name('repair-orders.assign.user');
        Route::post('pay-due-amount/{repairOrder}', [RepairOrderAxillaryController::class, 'payDueAmount'])->name('repair.pay-due');
        Route::post('send/{repairOrder}/reminder', [RepairOrderAxillaryController::class, 'sendDispatchReminder'])->name('repair.send.reminder');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function () {
        Route::get('repair-report', [ReportController::class, 'generate'])->name('repair.report');
        Route::post('import/brands', [ImportController::class, 'brands'])->name('brands.import');
        Route::post('import/devices', [ImportController::class, 'devices'])->name('devices.import');
        Route::post('import/defects', [ImportController::class, 'defects'])->name('defects.import');
        Route::post('import/multiple/defects', [ImportController::class, 'multipleDefects'])->name('multiple-defects.import');

        Route::get('dashboard/states', [DashboardController::class, 'states'])->name('dashboard.states');
        Route::get('dashboard/graph', [DashboardController::class, 'annualGraph'])->name('dashboard.annual.graph');

        Route::get('backups', [BackupController::class, 'index'])->name('backup.index');
        Route::post('backups', [BackupController::class, 'generate'])->name('backup.generate');
        Route::patch('backups/{file}/restore', [BackupController::class, 'restore'])->name('backup.restore');
        Route::post('backups/{file}/remove', [BackupController::class, 'destroy'])->name('backup.destroy');

        Route::get('brands/list', [BrandController::class, 'brandList'])->name('brand.list');
        Route::get('devices/list', [DeviceController::class, 'deviceList'])->name('device.list');
        Route::post('repair/logs', [RepairLogController::class, 'store'])->name('repair-log.store');
        Route::get('users/user/roles', [UserController::class, 'userRoles'])->name('users.user-roles');
        Route::get('user/as /technicians', [UserController::class, 'technicians'])->name('users.technicians');
        Route::get('roles/permissions', [UserRoleController::class, 'permissions'])->name('user-roles.permissions');
        Route::post('languages/sync', [LanguageController::class, 'sync'])->name('language.sync');

        Route::group(['prefix' => 'settings'], function () {
            Route::post('setting-optimize', [SettingController::class, 'optimize'])->name('settings.optimize');
            Route::get('user-roles', [SettingController::class, 'userRoles'])->name('settings.user-roles');
            Route::get('languages', [SettingController::class, 'languages'])->name('settings.languages');

            Route::get('general', [SettingController::class, 'getGeneral'])->name('settings.get.general');
            Route::post('general', [SettingController::class, 'setGeneral'])->name('settings.set.general');

            Route::get('seo', [SettingController::class, 'getSeo'])->name('settings.get.seo');
            Route::post('seo', [SettingController::class, 'setSeo'])->name('settings.set.seo');

            Route::get('appearance', [SettingController::class, 'getAppearance'])->name('settings.get.appearance');
            Route::post('appearance', [SettingController::class, 'setAppearance'])->name('settings.set.appearance');

            Route::get('localization', [SettingController::class, 'getLocalization'])->name('settings.get.localization');
            Route::post('localization', [SettingController::class, 'setLocalization'])->name('settings.set.localization');

            Route::get('authentication', [SettingAxillaryController::class, 'getAuthentication'])->name('settings.get.authentication');
            Route::post('authentication', [SettingAxillaryController::class, 'setAuthentication'])->name('settings.set.authentication');

            Route::get('outgoing/mail', [SettingAxillaryController::class, 'getOutgoingMail'])->name('settings.get.outgoing.mail');
            Route::post('outgoing/mail', [SettingAxillaryController::class, 'setOutgoingMail'])->name('settings.set.outgoing.mail');

            Route::get('captcha', [SettingAxillaryController::class, 'getCaptcha'])->name('settings.get.captcha');
            Route::post('captcha', [SettingAxillaryController::class, 'setCaptcha'])->name('settings.set.captcha');

            Route::get('currency', [SettingAxillaryController::class, 'getCurrency'])->name('settings.get.currency');
            Route::post('currency', [SettingAxillaryController::class, 'setCurrency'])->name('settings.set.currency');

            Route::get('tax', [SettingAxillaryController::class, 'getTax'])->name('settings.get.tax');
            Route::post('tax', [SettingAxillaryController::class, 'setTax'])->name('settings.set.tax');

            Route::get('braintree', [PaymentGatewaysController::class, 'getBraintreeApi'])->name('settings.get.braintree');
            Route::post('braintree', [PaymentGatewaysController::class, 'setBraintreeApi'])->name('settings.set.braintree');

            Route::get('stripe', [PaymentGatewaysController::class, 'getStripeApi'])->name('settings.get.stripe');
            Route::post('stripe', [PaymentGatewaysController::class, 'setStripeApi'])->name('settings.set.stripe');

            Route::get('cod', [PaymentGatewaysController::class, 'getCodApi'])->name('settings.get.cod');
            Route::post('cod', [PaymentGatewaysController::class, 'setCodApi'])->name('settings.set.cod');

            Route::get('square', [PaymentGatewaysController::class, 'getSquareApi'])->name('settings.get.square');
            Route::post('square', [PaymentGatewaysController::class, 'setSquareApi'])->name('settings.set.square');

            Route::get('sms', [SmsGatewaysController::class, 'getSmsApi'])->name('settings.get.sms');
            Route::post('sms', [SmsGatewaysController::class, 'setSmsApi'])->name('settings.set.sms');

            Route::get('terms', [SettingAxillaryController::class, 'getTerms'])->name('settings.get.terms');
            Route::post('terms', [SettingAxillaryController::class, 'setTerms'])->name('settings.set.terms');
        });

        Route::post('workshop-repair-update/{repairOrder}', [RepairOrderController::class, 'workshopUpdate'])->name('ws-repair-up');
        Route::apiResource('repair-priorities', RepairPriorityController::class);
        Route::apiResource('repair-statuses', RepairStatusController::class);
        Route::apiResource('faq', FaqController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('user-roles', UserRoleController::class);
        Route::apiResource('brands', BrandController::class);
        Route::apiResource('devices', DeviceController::class);
        Route::apiResource('defects', DefectController::class);
        Route::apiResource('repair-orders', RepairOrderController::class);
        Route::apiResource('quick-replies', QuickReplyController::class);
        Route::apiResource('custom-pages', CustomPageController::class);
        Route::apiResource('languages', LanguageController::class);
    });
});
