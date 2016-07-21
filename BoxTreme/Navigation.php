<?php

class Navigation{
    private $here;
    private $there;


    
    
    function __construct(){

        $this->go($there = 'home');
    }

    
    function where(){
        return $this->here;
    }
    
    function go($there){
        if (isset($_GET["home"])){
            $GLOBALS['body'] = file_get_contents('gui/home.php');
        }
        
        $this->there = $there;
        
    }
}