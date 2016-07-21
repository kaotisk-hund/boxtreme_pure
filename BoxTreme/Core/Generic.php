<?php

namespace BoxTreme\Core;

class Generic {
    function __construct() {
        Log::log(get_called_class().' constructed.');
        $this->init();
    }
    
    function init(){
        
    }
}