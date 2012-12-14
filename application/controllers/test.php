<?php

class Test_Controller extends Base_Controller {
    public function action_index()
    {
        $this->layout->nest('content', 'test.index' );
    }
    
}
