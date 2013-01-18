<?php
        class Paintings_Controller extends Base_Controller {
            public $restful = true;
 public function get_index()
            {
              $data = Paintings::all();
        $result = array();
        foreach ($data as $v)
            $result[] = $v->to_array();
        $json = json_encode($result);
        return $json;
    } 
public function post_index()
    {
         $new = new Paintings();$new->save();          
        
        $response = array('success' => true, 'data' => array('id' => $new->id));
        
        $json = json_encode($response);
        return $json;
    }
public function put_index()
    {
            $data =  file_get_contents('php://input');  
            $temp = json_decode($data);
$new= Paintings::find($temp->id);
$new->id=$temp->id;
$new->topic=$temp->topic;
$new->style=$temp->style;
$new->save();  $array = array('success' => 'true');
            $json = json_encode($array );
            return $json;
    }
public function delete_index()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);
        
        $id = $json->id;$affected = DB::table('paintings')->where('id', '=', $id)->delete(); $array = array('success' => 'true');
            $json = json_encode($array );
            return $json; }
}