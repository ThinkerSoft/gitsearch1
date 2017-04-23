<?php

// корень
Route::get('/', function () {
    // перенапрявляем на страницу поиска
    return redirect('search');
});

Auth::routes();

// роуты для авторизации на GitHub через OAuth
Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

// роут до страницы поиска
Route::get('search', 'SearchController@index');
