<?php
class MODELnodes_Controller extends Base_Controller
{
    public $restful = true;

    public function get_index()
    {
        $records = MODEL::where('PARENT_ID', '=', (int)$_GET['node'])->get();
        $result = '[';
        foreach ($records as $record) {
            $result .= '{
                    text: \'' . $record->DEFAULT_FIELD . '\',
                    leaf: ' . ($record->LEAF ? 'true' : 'false') . ',
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
        $new = new MODEL();
        $new->DEFAULT_FIELD = $temp->text;
        $new->PARENT_ID = $temp->parentId;
        $new->LEAF = $temp->leaf;
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
        $new->DEFAULT_FIELD = $temp->text;
        $new->PARENT_ID = $temp->parentId;
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