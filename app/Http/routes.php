<?php
//Change the path of templates depending of the client dispositive.
if(!Agent::isDesktop()){
  View::addLocation(base_path().'/resources/views/mobile/');
}
View::addLocation(base_path().'/resources/views/desktop/');

//Frontend
Route::get('/', 'MainController@index');
Route::get('/getreward', 'MainController@getReward');
Route::get('/success', 'MainController@success');
Route::get('/extra-award', 'MainController@getExtraAward');
Route::get('/about', ['middleware'=>'mycache','time'=>'720','uses'=>'MainController@about']);
Route::post('/setpoints', 'MainController@setpoints');
Route::post('/sendreward', 'MainController@sendReward');
Route::get('contact', 'ContactController@getContact');
Route::post('contact', 'ContactController@postContact');
//Special Route - Antibot Purpouse.
Route::get('/pacman.js', 'MainController@pacmanjs');
//Authentication routes.
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::controllers([
    'password' => 'Auth\PasswordController',
]);
//Admin routes.
Route::get('/admin', 'Admin\AdminController@dashboard');
Route::get('/admin/transactions', 'Admin\AdminController@transactions');
Route::get('/admin/ajax/transactions', 'Admin\AdminController@ajaxTransactions');
Route::get('/admin/address', 'Admin\AdminController@addressList');
Route::get('/admin/ajax/address', 'Admin\AdminController@ajaxAddressList');
Route::get('/admin/address/{id}', 'Admin\AdminController@address');
Route::get('/admin/messages', 'Admin\AdminController@messageList');
Route::get('/admin/ajax/messages', 'Admin\AdminController@ajaxMessageList');
Route::get('/admin/message/{id}', 'Admin\AdminController@message');
Route::get('/admin/extra-awards', 'Admin\AdminController@extraAwardsList');
Route::get('/admin/ajax/extra-awards', 'Admin\AdminController@ajaxExtraAwardsList');
//Admin - Security Features
Route::any('/admin/whois', 'Admin\SecurityController@whois');
Route::post('/admin/bans', 'Admin\SecurityController@banNetByName');
Route::get('/admin/bans', 'Admin\SecurityController@bannedList');
Route::get('/admin/ajax/bans', 'Admin\SecurityController@ajaxBannedList');
Route::get('/admin/bans/new', 'Admin\SecurityController@banIP');
Route::post('/admin/bans/new', 'Admin\SecurityController@banIP');
Route::get('/admin/bans/del/{id}', 'Admin\SecurityController@delBan');
Route::get('/admin/banned-ranges', 'Admin\SecurityController@bannedRangesList');
Route::get('/admin/ajax/banned-ranges', 'Admin\SecurityController@ajaxBannedRangesList');
Route::get('/admin/banned-ranges/del/{id}', 'Admin\SecurityController@delBannedRange');
Route::get('/admin/search-asns', 'Admin\SecurityController@searchAsns');
Route::get('/admin/ajax/search-asns', 'Admin\SecurityController@ajaxSearchAsns');
Route::get('/admin/banned-ranges/export', 'Admin\SecurityController@exportToIpTables');
