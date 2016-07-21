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
interface Plugin {
//    static private $author = 'kaotisk';
//    static private $description = 'The plugin class is the parent of all plugins.';
//    var $settings = array();
    
    //function __construct();
    /* Proccess that initiate the basics for loading a class with
     * settings from the db which connection with db is implemented by
     * the MySQL that has its settings in a file instead.
     * Therefore MySQL doesn't need to inherit this Plugin
     * but it has to live in a different sphere where the core
     * lives!
     */
    function __init();
    
    //function recover_Settings($table);
    //function install();
    /*
     * Checks the status of the plugin. If no tables of the settings
     * are set then an error returns and it asks for installation.
     */
    //function isInstalled();
    
    //function info();
}

