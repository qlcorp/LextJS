<?php
        class Moviesform_Controller extends Base_Controller { 
public function action_index() 
 { 
$record = new Movies(); 
$record-> title=$_POST['title']; 
$record-> director=$_POST['director']; 
$record-> year=$_POST['year']; 
$record-> genre=$_POST['genre']; 
$record->save();
$array = array('success' => 'true', 'msg' => 'Record added successfully' );
$json = json_encode($array);
return $json;

 } 
 }