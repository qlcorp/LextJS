<?php
        class Carsform_Controller extends Base_Controller { 
public function action_index() 
 { 
$record = new Cars(); 
$record-> parent_id=$_POST['parent_id']; 
$record-> text=$_POST['text']; 
$record-> leaf=$_POST['leaf']; 
$record->save();
$array = array('success' => 'true', 'msg' => 'Record added successfully' );
$json = json_encode($array);
return $json;

 } 
 }