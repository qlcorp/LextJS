<?php
        class Carsgrid_Controller extends Base_Controller {
            public $restful = true;
 public function get_index()
            {
              $data = Cars::all();
        $result = array();
        foreach ($data as $v)
            $result[] = $v->to_array();
        $json = json_encode($result);
        return $json;
    } 
public function post_index()
    {
         $new = new Cars();$new->save();          
        
        $response = array('success' => true, 'data' => array('id' => $new->id));
        
        $json = json_encode($response);
        return $json;
    }
public function put_index()
    {
            $data =  file_get_contents('php://input');  
            $temp = json_decode($data);
$new= Cars::find($temp->id);
$new->id=$temp->id;
$new->manufacturer=$temp->manufacturer;
$new->model=$temp->model;
$new->year=$temp->year;
$new->save();  $array = array('success' => 'true');
            $json = json_encode($array );
            return $json;
    }
public function delete_index()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);
        
        $id = $json->id;$affected = DB::table('cars')->where('id', '=', $id)->delete(); $array = array('success' => 'true');
            $json = json_encode($array );
            return $json; }
}