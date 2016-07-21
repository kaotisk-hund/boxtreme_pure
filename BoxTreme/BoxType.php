<?php

class BoxType{
    var $id;
    var $box_name;
    public function __construct($data){
        if(is_array($data)){
            $this->id = $data['id'];
            $this->box_name = $data['box_name'];
        }
        else{
            exit();
        }
    }
}
