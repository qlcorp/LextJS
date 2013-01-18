<?php
        class Carsnodes_Controller extends Base_Controller {
            public $restful = true;
 public function get_index()
            {

                $records = Cars::where('parent_id', '=', (int)$_GET['node'])->get();
                $result = '[';
                foreach ($records as $record) {


                $result .= '{
                    text: \'' . $record->text . '\',
                    leaf: ' . ($record->leaf ? 'true' : 'false') . ',
                    id: ' . $record->id . '
                 },';
                }
                $result .= ']';
                return $result;
            } 
public function post_index()
    {

        $data = file_get_contents('php://input');
        $temp = json_decode($data);
        $new = new Cars();
        $new->text = $temp->text;
        $new->parent_id = $temp->parentId;
        $new->leaf = $temp->leaf;$new->save();

        $response = array('success' => true, 'data' => array('id' => $new->id));

        $json = json_encode($response);
        return $json;
    }
public function put_index()
    {
            $data =  file_get_contents('php://input');
            $temp = json_decode($data);
$new= Cars::find($temp->id);
$new->text=$temp->text;
$new->parent_id=$temp->parentId;
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