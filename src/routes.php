<?php
Route::bind('menulinks', function ($value) {
    return TypiCMS\Modules\Menulinks\Models\Menulink::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Menulinks\Http\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('menus.menulinks', 'AdminController');
        Route::post(
            'menulinks/sort',
            array('as' => 'admin.menulinks.sort', 'uses' => 'AdminController@sort')
        );
    }
);

Route::group(['prefix'=>'api'], function() {
    Route::resource('menulinks', 'ApiController');
});
