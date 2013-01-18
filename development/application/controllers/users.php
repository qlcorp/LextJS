<?php
        class Users_Controller extends Base_Controller {
            public $restful = true;
 public function get_index()
            {
              $data = Users::all();
        $result = array();
        foreach ($data as $v)
            $result[] = $v->to_array();
        $json = json_encode($result);
        return $json;
    } 
public function post_index()
    {
         $new = new Users();$new->save();          
        
        $response = array('success' => true, 'data' => array('id' => $new->id));
        
        $json = json_encode($response);
        return $json;
    }
public function put_index()
    {
            $data =  file_get_contents('php://input');  
            $temp = json_decode($data);
$new= Users::find($temp->id);
$new->id=$temp->id;
$new->first_name=$temp->first_name;
$new->last_name=$temp->last_name;
$new->birth_date=$temp->birth_date;
$new->save();  $array = array('success' => 'true');
            $json = json_encode($array );
            return $json;
    }
public function delete_index()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);
        
        $id = $json->id;$affected = DB::table('users')->where('id', '=', $id)->delete(); $array = array('success' => 'true');
            $json = json_encode($array );
            return $json; }
}