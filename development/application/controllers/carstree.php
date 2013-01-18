<?php
class Carstree_Controller extends Base_Controller
{
    public function action_nodes()
    {
        //$this->layout->nest('content', 'carstree.index' );
        return View::make('carstree/nodes');
    }
    public function action_nodesss()
    {
        return View::make('tree/nodes');
    }
    public function action_save()
    {
        $model ='Cars';
        $data =  file_get_contents('php://input');  
            $data = json_decode($data);
            
            $toEdit = $model::find($data->ids[0]);
            $editFrom = $model::find($data->to);
            
            if($data->action == 'before' || $data->action == 'after' )
            {
            $toEdit->parent_id = $editFrom->parent_id;
            $toEdit->save();
            }
            elseif ($data->action == 'append' )
            {
                $toEdit->parent_id = $editFrom->id;
                $toEdit->save();
            }
            
            return true;
    }
    
}