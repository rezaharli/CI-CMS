<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Public_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function build()
    {
        $this->template
        ->set_theme('public')
        ->set_layout('layout.html')
        ->set_partial('content', $this->controller, ci()->data)
        ->build($this->controller, ci()->data);
    }
}