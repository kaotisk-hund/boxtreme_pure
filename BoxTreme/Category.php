<?php

namespace BoxTreme;

use BoxTreme\Core;

class Category extends Core\Generic{
    private $categories = [];
    private $new_cat;
    private $mySQL;
    
    const CLASSNAME = 'category';
    
    
    
    function init(){
        $this->mySQL = new Core\MySQL(SQL_USER, SQL_PASS, SQL_DB, SQL_HOST);
        
        Core\Controller::register(Category::CLASSNAME,'category');
        $this->getCategories();
    }
    
    function signal($request, $data=null){
        switch ($request) {
            case 'category':
                $this->showCategory($data);

                break;

            default:
                break;
        }
    }
    
    function getCategories(){
        $this->mySQL->select("bx_Categories");
        if(is_array($this->mySQL->return_data)){
            $this->categories = $this->mySQL->return_data;
        } else {
            $this->categories = null;
        }
    }
    
    function getId($category){
        $id = $this->searchCategory($category);
        if( $id == null ){
            $this->new_cat = $category;
            $category = $this->addCategory();
            $id = $this->searchCategory($category);
        }
        return $id;
    }
    
    function searchCategory($category){
        foreach ($this->categories as $key => $value){
            if($category == $value['category']){
                $id = $value['id'];
            } else {
                $id = null;
            }
        }
        return $id;
    }
    
    function addCategory(){
        $this->mySQL->insert("bx_Categories",  [$this->new_cat]);
        $this->getCategories();
        return $this->new_cat;
    }
    
    function getCategory($id){
        $category = null;
        foreach ($this->categories as $key => $value){
            if($id == $value['id']){
                $category = $value['category'];
            }
        }
        return $category ;
    }
    
    function showCategory($data){
        $GLOBALS['body'][] = 'Hi all!!!!';
    }
}