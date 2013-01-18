<?php
        class Usersform_Controller extends Base_Controller { 
public function action_index() 
 { 
$record = new Users(); 
$record-> first_name=$_POST['first_name']; 
$record-> last_name=$_POST['last_name']; 
$record-> birth_date=date( "Y-m-d", strtotime($_POST['birth_date'] ) );
$record->save();
$array = array('success' => 'true', 'msg' => 'User added successfully' );
$json = json_encode($array);
return $json;

 } 
 }