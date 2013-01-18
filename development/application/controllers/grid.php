<?php

class Grid_Controller extends Base_Controller {
    public function action_index()
    {
        $this->layout->nest('content', 'grid.index' );
    }
    
}
