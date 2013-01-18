<?php
class Form_Controller extends Base_Controller
{
    public function action_index()
    {
        $this->layout->nest('content', 'form.index' );
    }
}