<?php 

Route::middleware('auth')->group(function ()
{
	Route::post('/logout', 'AuthController@logout')->name('logout');

	Route::prefix('cart')->name('cart.')->group(function ()
	{
		Route::view('/', 'cart')->name('index');
		Route::post('/store', 'CartController@store')->name('store');
	});

	Route::middleware('verified')->group(function ()
	{
		Route::prefix('user')->name('user.')->group(function ()
		{
			Route::get('/', function ()
			{
				return 'oke';
			});
			Route::view('/profile', 'user.profile')->name('profile');
		});

		Route::get('/transaction/payment/{id}', 'TransactionController@payment')->name('transaction.payment');

		Route::resource('/transaction', 'TransactionController', ['only' => ['index', 'create', 'store', 'show']]);

	});
	
	Route::prefix('/email/verify')->name('verification.')->middleware('not-verified')->group(function ()
	{
		Route::view('/', 'auth.verify')->name('notice');
		Route::get('/{id}/{hash}', 'AuthController@verify')->middleware('signed')->name('verify');
	});

});


Route::middleware('guest')->group(function ()
{
	Route::view('/login', 'auth.login')->name('login');
	Route::view('/register', 'auth.register')->name('register');
});

 ?>