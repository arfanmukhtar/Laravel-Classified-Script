<?php

use App\Http\Controllers\Backend\AdsController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\CustomFieldController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PackageController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\Settings\GeoSettingController;
use App\Http\Controllers\Backend\Settings\MetaController;
use App\Http\Controllers\Backend\Settings\SettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\TemplatesController;
use App\Http\Controllers\Backend\TypeController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\UpdateController;
use App\Http\Controllers\Backend\MenuController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'admin'], function () {
    Route::controller(DashboardController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('/', 'index')->name('admin');
        Route::get('dashboard', 'index')->name('dashboard');
    });
    Route::controller(AdsController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('listings', 'index')->name("listings");
        Route::delete('listings/{id}', 'destroy');
        Route::get('listings/view/{id}', 'show');
        Route::post('listings/change-status', 'changeStatus')->name('change-status');
        Route::get('getListings', 'getListings')->name('getListings');
    });
    Route::controller(UserController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('users', 'index')->name('users');
    });
    Route::controller(CategoryController::class)->middleware(['auth' , 'XssSanitizer' , 'isAdmin'])->group(function () {
        Route::get('categories', 'index');
        Route::post('categories', 'store');
        Route::get('categories/{id}/edit', 'edit');
        Route::get('categories/create', 'create');
        Route::put('categories/{id}', 'update');
        Route::delete('categories/{id}', 'destroy');
        Route::post('category/upload_photo_crop', 'updatePhotoCrop');

    });
    Route::controller(TypeController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('types', 'index')->name('types');
        Route::post('types', 'store')->name('types.save');
        Route::get('types/{id}/edit', 'edit');
        Route::get('types/create', 'create')->name('types.create');
        Route::put('types/{id}', 'update');

    });

    Route::controller(PageController::class)->middleware(['auth', 'XssSanitizer' , 'isAdmin'])->group(function () {
        Route::get('/pages', 'index');
        Route::post('/pages/save', 'save');
        Route::get('/pages/add', 'add');
        Route::get('/pages/delete/{id}', 'delete');
        Route::get('/pages/edit/{id}', 'edit');
        Route::get('/pages/footer/', 'footer');
        Route::post('/pages/save-footer', 'saveFooter')->name('save-footer');
    });
    Route::controller(SliderController::class)->group(function () {
        Route::get('/sliders', 'index');
        Route::post('slider/save', 'save');
        Route::post('slider/get', 'get');
        Route::post('slider/delete', 'delete');
    });
    Route::controller(PackageController::class)->middleware(['auth', 'XssSanitizer' , 'isAdmin'])->group(function () {
        Route::get('/packages', 'index');
        Route::post('packages/save', 'save');
        Route::post('packages/get', 'get');
        Route::post('packages/delete', 'delete');
        Route::get('/featured-packages', 'featuredPackages');
        Route::post('featured-packages/save', 'saveFeatured');
        Route::post('featured-packages/get', 'getFeatured');
        Route::post('featured-packages/delete', 'deleteFeatured');
    });

    Route::controller(CustomFieldController::class)->middleware(['auth', 'XssSanitizer' , 'isAdmin'])->group(function () {
        Route::get('customfields', 'index')->name('custom-fields');
        Route::get('customfields/create', 'create')->name('custom-fields-create');
        Route::get('customfields/{id}/edit', 'edit')->name('custom-fields-edit');
        Route::post('customfields/store', 'store')->name('custom-fields-store');
    });

    Route::controller(UserController::class)->middleware(['auth', 'XssSanitizer' , 'isAdmin'])->group(function () {
        Route::get('staff', 'index');
        Route::post('staff', 'store');
        Route::get('staff/{id}/edit', 'edit');
        Route::get('staff/create', 'create');
        Route::put('staff/{id}', 'update');
    });
    Route::controller(CustomerController::class)->middleware(['auth', 'XssSanitizer' , 'isAdmin'])->group(function () {
        Route::get('users', 'index');
        Route::post('users', 'store');
        Route::get('users/{id}/edit', 'edit');
        Route::get('users/create', 'create');
        Route::put('users/{id}', 'update');
        Route::get('users/getUsers', 'getUsers')->name('getUsers');
    });

    Route::controller(RoleController::class)->middleware(['auth', 'XssSanitizer' , 'isAdmin'])->group(function () {
        Route::get('roles', 'index');
        Route::post('roles', 'store');
        Route::get('roles/edit/{id}', 'edit');
        Route::get('roles/create', 'create');
        Route::post('roles/update', 'update');
    });

    Route::controller(ProfileController::class)->middleware(['auth', 'XssSanitizer' , 'isAdmin'])->group(function () {
        Route::get('profile', 'edit');
        Route::post('profile', 'update');
        Route::post('update_password', 'updatePassword');
    });

    Route::controller(SettingController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('settings/general', 'generalSetting')->name('general-settings');
        Route::get('settings/branding', 'branding')->name('branding');
        Route::post('settings/save-branding', 'saveBranding')->name('save-branding');
        Route::post('settings/save', 'saveSetting')->name('save-settings');
        Route::get('settings/payments', 'payments')->name('payments');
        Route::get('settings/seo', 'seoSettings')->name('seo-settings');
        Route::get('settings/advertisements', 'advertisements')->name('advertisements');
        Route::get('settings/pages-views', 'pagesView')->name('pages-views');

        Route::get('settings/home-videos', 'homeVideos')->name('home-videos');
        Route::post('settings/delete-videos', 'deleteVideo')->name('delete-home-video');
        Route::post('settings/save-videos', 'saveVideo')->name('save-home-video');

        Route::get('settings/home-budget-filters', 'homeBudgets')->name('home-budget-filters');
        Route::post('settings/delete-budget', 'deleteBudget')->name('delete-home-budget');
        Route::post('settings/save-budget', 'saveBudget')->name('save-home-budget');
        Route::post('settings/validate_smtp', 'validate_smtp')->name('validate-smtp');
        
       
        
    });
    Route::controller(MenuController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('update_menu', 'home')->name('update-menu');
        Route::post('save_menu', 'saveMenu')->name('save-menu');
    });
    
    Route::controller(UpdateController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('update', 'index')->name('update-classified');
        Route::post('download-update', 'downloadUpdate')->name('download-update');
        Route::post('copy-files', 'copyFiles')->name('copy-files');
    });
    Route::controller(MetaController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('settings/pages', 'index')->name('pages-meta');
        Route::post('settings/meta-save', 'store')->name('save-meta');
        Route::post('settings/get-meta', 'get')->name('get-meta');
    });
    Route::controller(GeoSettingController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('settings/countries', 'countries')->name('countries');
        Route::get('settings/cities/{country_id?}', 'cities')->name('cities');
        Route::post('settings/cities/save', 'saveCity')->name('save-city');
        Route::post('settings/cities/get', 'getCity')->name('get-city');
        Route::post('settings/cities/delete', 'deleteCity')->name('delete-city');
        Route::post('settings/cities/import', 'importCitiesList')->name('import-cities-list');
        Route::post('settings/areas/import', 'importAreasList')->name('import-areas-list');

        Route::get('settings/cities/areas/{city_id?}', 'areas')->name('areas');
        Route::post('settings/cities/areas/save', 'saveArea')->name('save-area');
        Route::post('settings/cities/areas/get', 'getArea')->name('get-area');
        Route::post('settings/cities/areas/delete', 'deleteArea')->name('delete-area');

        Route::get('settings/currencies', 'currencies')->name('currencies');
        Route::post('settings/edit-currency', 'editCurrency')->name('get-currency');
        Route::post('settings/save-currency', 'storeCurrency')->name('save-currency');
        Route::get('settings/timezones', 'timezones')->name('timezones');
        Route::post('settings/get-timezone', 'editTimezone')->name('get-timezone');
        Route::post('settings/save-timezone', 'storeTimezone')->name('save-timezone');
    });

    Route::controller(ProfileController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('settings/profile', 'profile')->name('profile');
        Route::post('settings/profile', 'saveProfile')->name('save-profile');
        Route::post('settings/update-password', 'updatePassword')->name('update-password');
    });

    Route::controller(TemplatesController::class)->middleware(['auth' , 'isAdmin'])->group(function () {
        Route::get('map-templates', 'index')->name('map-templates');
        Route::get('templates', 'index')->name('templates');
        Route::get('templates', 'notificationTemplates')->name('templates');
        Route::get('templates/add', 'addTemplates')->name('add-template');
        Route::get('templates/edit/{id}', 'editTemplates')->name('edit-template');
        Route::get('templates/get-all-templates', 'getEmailTemplates')->name('get-all-templates');
        Route::get('templates/delete', 'deleteClientTemplate')->name('delete-template');
        Route::post('templates/save', 'saveClientTemplate')->name('save-template');
        Route::post('templates/mapped', 'saveMapedTemplate')->name('save-map-template');
    });

});
