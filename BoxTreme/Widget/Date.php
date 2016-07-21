<?php


namespace BoxTreme\Widget;

class Date{
    private $date = 'null';
    public function __construct(){
        $this->init();
    }
    public function init(){
        $this->date = date('d-m-Y');
        $this->send();
    }
    
    public function send(){
        $GLOBALS['widget'][] = '<div class="panel"><center><h3>Today is</h3><p>'.$this->date.'</p></center></div>';
    }
}