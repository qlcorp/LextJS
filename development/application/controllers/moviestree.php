<?php
class Moviestree_Controller extends Base_Controller
{
    public function action_index()
    {
        $this->layout->nest('content', 'tree.index' );
    }
    public function action_nodes()
    {
        return View::make('tree/nodes');
    }
    public function action_save()
    {
        $model ='Movies';
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