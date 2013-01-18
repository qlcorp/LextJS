<?php
class MODELgrid_Controller extends Base_Controller
{
    public $restful = true;

    public function get_index()
    {
        $data = MODEL::all();
        $result = array();
        foreach ($data as $v)
            $result[] = $v->to_array();
        $json = json_encode($result);
        return $json;
    }

    public function post_index()
    {
        $new = new MODEL();
        $new->save();

        $response = array('success' => true, 'data' => array('id' => $new->id));

        $json = json_encode($response);
        return $json;
    }

    public function put_index()
    {
        $data = file_get_contents('php://input');
        $temp = json_decode($data);
        $new = MODEL::find($temp->id);
        SAVE_FIELDS;
        $new->save();
        $array = array('success' => 'true');
        $json = json_encode($array);
        return $json;
    }

    public function delete_index()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);

        $id = $json->id;
        $affected = DB::table('TABLE')->where('id', '=', $id)->delete();
        $array = array('success' => 'true');
        $json = json_encode($array);
        return $json;
    }
}