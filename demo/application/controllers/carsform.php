<?php
        class Carsform_Controller extends Base_Controller { 
public function action_index() 
 { 
$record = new Cars(); 
$record-> manufacturer=$_POST['manufacturer']; 
$record-> model=$_POST['model']; 
$record-> year=$_POST['year']; 
$record->save();
$array = array('success' => 'true', 'msg' => 'Record added successfully' );
$json = json_encode($array);
return $json;

 } 
 }