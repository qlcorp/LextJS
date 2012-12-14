<?php
//Route::get('(:bundle)',  function()
//{
//    return 'Welcome to the extjs bundle!';
//});

//Route::get('(:bundle)', array('uses' => '' ) ) ;

Route::controller(Controller::detect());