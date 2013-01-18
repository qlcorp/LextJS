<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/
Route::get('/', array('as' => 'homepage', 'uses' => 'grid@index' ) );

Route::get('grid', array('as' => 'grid' ,'uses' => 'grid@index' )  );

Route::get('form', array('as' => 'form', 'uses' => 'form@index' ) );

Route::get('tree', array('as' => 'tree', 'uses' => 'tree@index' ) );

Route::any('nodes/(:num?)', function() { echo 'test'; } ); 

Route::post('save', array('as' => 'save', 'uses' => 'filestree@save' )  ); //

Route::any('movies/(:num?)', array('as' => 'movies', 'uses' => 'movies@index' ) );

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});

Route::any('cc', function() {     //tylko do debuggowania
    $name = 'extCars';
    echo  'entry to delete ' . $name;
    Cache::forget($name);
    echo "<br/>after clear cache:";
    echo '<pre>';
    var_dump ( Cache::get($name) );
} );


Route::any('moviesgrid/(:num?)', array( 'uses' => 'moviesgrid@index' ) ); 
Route::any('update_movies', array('uses' => 'moviesform@index' ) ); 
Route::any('moviesnodes/(:all?)', array('uses' => 'moviesnodes@index' ));

Route::any('filesgrid/(:num?)', array( 'uses' => 'filesgrid@index' ) ); 
Route::any('update_files', array('uses' => 'filesform@index' ) ); 
Route::any('filesnodes/(:all?)', array('uses' => 'filesnodes@index' ));

Route::any('carsgrid/(:num?)', array( 'uses' => 'carsgrid@index' ) ); 
Route::any('update_cars', array('uses' => 'carsform@index' ) ); 
Route::any('carsnodes/(:all?)', array('uses' => 'carsnodes@index' ));

Route::any('carsgrid/(:num?)', array( 'uses' => 'carsgrid@index' ) ); 
Route::any('update_cars', array('uses' => 'carsform@index' ) ); 
Route::any('carsnodes/(:all?)', array('uses' => 'carsnodes@index' ));
Route::any('moviesgrid/(:num?)', array( 'uses' => 'moviesgrid@index' ) ); 
Route::any('update_movies', array('uses' => 'moviesform@index' ) ); 
Route::any('moviesnodes/(:all?)', array('uses' => 'moviesnodes@index' ));
Route::any('filesgrid/(:num?)', array( 'uses' => 'filesgrid@index' ) ); 
Route::any('update_files', array('uses' => 'filesform@index' ) ); 
Route::any('filesnodes/(:all?)', array('uses' => 'filesnodes@index' ));