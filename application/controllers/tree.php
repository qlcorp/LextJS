<?php
class Tree_Controller extends Base_Controller
{
    public function action_index()
    {
        $this->layout->nest('content', 'tree.index' );
    }
}