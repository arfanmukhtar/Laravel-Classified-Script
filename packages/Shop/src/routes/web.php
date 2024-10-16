<?php 

Route::group(['prefix' => 'shop'], function () {
    Route::get('dashboard', function() {
        echo "I am in my shop";
    });
});