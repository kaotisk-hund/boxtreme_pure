<?php
    /* 
     * This file is the storage for some variables that are needed to
     * initiate the site. 
     */

    define('LANG_PATH', 'i18n/'); // We define LANG_PATH
    define('DEFAULT_LANG', 'en'); // We define DEFAULT_LANG
    
    $title      = '';
    $charset    = 'utf-8';
    $viewport   = 'width=device-width, initial-scale=1.0';
    global $css;
    $css        = array('css/foundation.css');
    $script     = 'js/vendor/modernizr.js';
    
    
    /*
     * All the settings for connection with MySQL through the mysql.php class
     */
    define('SQL_HOST', '');
    define('SQL_USER', '');
    define('SQL_PASS', '');
    define('SQL_DB', '');
    
    /*
     * Some various pre-settings (e.g. $time is used for cookie expiration)
     */
    global $host, $https, $time, $path;
    $host       = '';
    $https      = '';			// true/false
    $cookie_time       = time()+3600;
    $cookie_path       = '/';
    
    /*
     * Some plugins to load or not.
     */
    global $plugins_path;
    $plugins_path = 'plugins/';

?>
