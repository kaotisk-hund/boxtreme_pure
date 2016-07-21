<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Div
 *
 * @author kaotisk
 */

namespace BoxTreme\Gui;

class Div {
    var $author = 'kaotisk';
    var $description = '';
    //put your code here
    
    private $id = '';
    private $class = '';
    private $data = '';
    
    function setId($id){
        $this->id = $id;
    }
    
    function setClass($class){
        $this->class = $class;
    }
    
    function setData($data){
        $this->data = $data;
    }
    
    function getDiv(){
        return '<div id="'.$this->id.'" class="'.$this->class.'">'.$this->data."</div>";
    }
}

