<?php
class Movies_Controller extends Base_Controller {
    public $restful = true;
    
    public function get_index()
    {
        $data = Movies::all();
        $result = array();
        foreach ($data as $v)
            $result[] = $v->to_array();
        $json = json_encode($result);
        return $json;
    }
    public function post_index()
    {
         $new = new Movies();
            $new->save();          
        
        $response = array('success' => true, 'data' => array('id' => $new->id));
        
        $json = json_encode($response);
        return $json;
    }
    public function put_index()
    {
            $data =  file_get_contents('php://input');  
            $temp = json_decode($data);
            
        //save to database
            $new = new Movies();
            $new->title = $temp->title;
            $new->year = $temp->year;
            $new->save();          
            
       //response
            $array = array('success' => 'true');
            $json = json_encode($array );
            return $json;
    }
    public function delete_index()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);
        
        $id = $json->id;
        $affected = DB::table('movies')->where('id', '=', $id)->delete();       
        return '';
    }
}
