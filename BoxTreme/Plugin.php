<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Plugin
 *
 * @author kaotisk-hund
 */
class Plugin {
//    static private $author = 'kaotisk';
//    static private $description = 'The plugin class is the parent of all plugins.';
//    var $settings = array();
    var $menu;
    
    function Plugin(){
        $this->init();
    }
    
    function init(){
        
    }
    function hook($menu){
        $this->menu .= $menu;
    }
    function get_menu(){
        echo $this->menu;
    }
    //function recover_Settings($table);
    //function install();
    /*
     * Checks the status of the plugin. If no tables of the settings
     * are set then an error returns and it asks for installation.
     */
    //function isInstalled();
    
    //function info();
}

