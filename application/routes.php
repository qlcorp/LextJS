<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/
 
Route::get('test', array( 'as' => 'test', 'uses' => 'test@index' )  );

Route::get('/', array('as' => 'homepage',  'uses' => 'home@index' )  );

//Route::get('movies', array('as' => 'movies',  function() {
//    $data = Movies::getMovies();
//    $json = json_encode($data);
//    echo $json;
//} 
//));

Route::any('movies/(:num?)', array('as' => 'movies', 'uses' => 'movies@index' ) );

//Route::put('movies', array('as' => 'movies_post',  function() {
//           $putdata = fopen("php://input", "r");
//            $data = fread($putdata, 1024);           
//            $temp = json_decode($data);
//            
//        //save to database
//            $new = new Movies();
//            $new->title = $temp->title;
//            $new->year = $temp->year;
//            $new->save();          
//            
//       //response
//            $array = array('success' => 'true');
//            $json = json_encode($array );
//            echo $json;
//} 
//));
//
//Route::put('movies/(:num)', array('as' => 'movies_update',  function() {
//    $putdata = fopen("php://input", "r");
//    $data = fread($putdata, 1024);           
//    $temp = json_decode($data);
//            
//        //save to database
//               
//            $affected = DB::table('movies')
//                ->where('id', '=', $temp->id)
//                ->update(
//                        array('title' => $temp->title , 'year' => $temp->year )
//                            );               
//           
//       //response
//            $array = array('success' => 'true');
//            $json = json_encode($array);
//            echo $json;
//} 
//));
//
//
//Route::post('movies', array('as' => 'movies_post',  function() {
//    $response = array('id' => $id );
//} 
//));
//
//
//Route::delete('movies/(:num)', array('as' => 'delete', function() {
//        $putdata = fopen("php://input", "r");
//        $data = fread($putdata, 1024);    
//        $json = json_decode($data);
//        
//        $id = $json->id;
//        $affected = DB::table('movies')->where('id', '=', $id)->delete();       
//       
//}     
//));


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