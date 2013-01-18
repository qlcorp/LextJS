<?php
class MODELform_Controller extends Base_Controller
{
    public function action_index()
    {
        $record = new MODEL();
        SAVE_FIELDS;
        $record->save();
        $array = array('success' => 'true', 'msg' => 'Record added successfully');
        $json = json_encode($array);
        return $json;

    }
}