<?php
        class Paintingsform_Controller extends Base_Controller { 
public function action_index() 
 { 
$record = new Paintings(); 
$record-> topic=$_POST['topic']; 
$record-> style=$_POST['style']; 
$record->save();
$array = array('success' => 'true', 'msg' => 'Record added successfully' );
$json = json_encode($array);
return $json;

 } 
 }