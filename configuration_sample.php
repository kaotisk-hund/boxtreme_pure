<?php
    /* 
     * This file is the storage for some variables that are needed to
     * initiate the site. 
     */
    define('LANG_PATH', 'i18n/'); // We define LANG_PATH
    define('DEFAULT_LANG', 'en'); // We define DEFAULT_LANG

    define('SITE_NAME','BoXtreme');
    define('SITE_CHARSET','utf-8');
    define('VIEWPORT','width=device-width, initial-scale=1.0');

    
     /*
     * All the settings for connection with MySQL through the mysql.php class
     */
    define('SQL_HOST', 'localhost');
    define('SQL_USER', 'user');
    define('SQL_PASS', 'pass');
    define('SQL_DB', 'boxtreme');
    define('SQL_PREFIX', 'bx_');

    /*
     * Some various pre-settings (e.g. $time is used for cookie expiration)
     */
    define('HOST','127.0.0.1');
    define('HTTPS',false);
    define('COOKIE_TIME',time()+3600);
    define('COOKIE_PATH','/');
    /*
     * Some plugins to load or not.
     */
    define('PLUGINS_PATH','plugins/');
    class Configuration{
        static public $css = array(
            'css/foundation.css',
            'foundation-icons/foundation-icons.css',
            'css/custom.css'
            );
        static $script = '';
    }
