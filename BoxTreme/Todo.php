<?php
/**
 * Description of todo
 *
 * @author marios
 */

class Todo extends Calendar {
    var $todo_list = array();
    
    public function __construct() {
        parent::__construct();
    }
    
    public function todo_out(){
        echo "<pre>".print_r($this->todo_list)."</pre>";
    }
}
