<?php 
use Laravelclassified\Stake\One\MainController;
use Laravelclassified\Stake\One\AdsController;
use Laravelclassified\Stake\One\SearchController;

Route::middleware(['web' , "XssSanitizer"])->controller(MainController::class)->group(function () {
    Route::get('/', 'home');
    Route::get('/home', 'home')->name('home');
    Route::get('/search', 'search')->name('search');
    Route::get('/category/{slug}', 'category')->name('category');
    Route::get('/location/{slug}', 'location')->name('location');
    Route::get('/detail/{slug}', 'detail')->name('item_detail');
    Route::get('/user/{name}', 'userAds')->name('user-ads');
});


Route::middleware(['web' , "auth" , "XssSanitizer" , 'is_verify_email'])->controller(AdsController::class)->group(function () {
    Route::get('post-an-ad', 'postAd')->name('post-an-ad');
    Route::post('post-an-ad', 'postAdSave')->name('save-an-ad');
    Route::get('post-success/{id}', 'postSuccess')->name('post-success');
    Route::post('ad-city-areas', 'getCityAreas')->name('ad-city-areas');
    Route::post('get-child-categories', 'getChildCategories')->name('get-child-categories');
    Route::get('post-a-request', 'postARequest')->name('post-an-request');
    Route::post('post-a-request', 'postARequestSave')->name('save-an-request');
    Route::post('ads/get-custom-fields', 'getCustomFields')->name('get-custom-fields');
    Route::post('ads/make_favorite', 'makeFavorite')->name('make_favorite');
});

Route::middleware(['web' , "auth"])->controller(SearchController::class)->group(function () {
    Route::get('find', 'searchResult')->name('search_result');
    Route::post('search/get-sub-cat', 'checkSubCat')->name('get-sub-cat');
    Route::post('search/get-sub-areas', 'checkSubAreas')->name('get-sub-areas');
    Route::post('search/get-city-areas', 'getCityAreas')->name('get-city-areas');
});

Route::get('{slug}', [App\Http\Controllers\HomeController::class, 'page']);