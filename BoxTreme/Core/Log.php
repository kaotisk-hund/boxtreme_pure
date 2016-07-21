<?php



/*
 * class Log :) We log what happens in the program so we can understand what is
 * okay and what is not. At this version, in order to use just globalize the
 * variable that has the Log class and enter $var->log('the logging text');
 * 
 */

namespace BoxTreme\Core;

class Log extends Generic{
    const LOG_DIR = ROOT_DIR.'/log/';
    const LOG_FILENAME = self::LOG_DIR.'boxtreme.log';
    /*
     * We get the filename from the defined 'LOG_FILENAME'
     * @param String $filename Full path of log_filename
     */
    private $filename = self::LOG_FILENAME;
    
    /*
     * @param File $file Where we store our opened file
     */
    static private $file;
    
    /*
     * @param String $mode The file mode we open the file
     */
    private $mode = 'a';
    
    /*
     * At __construct we open/create the log file and we log that!
     * @function __construct() Creates/Opens logfile
     */
    function init() {
        self::$file = fopen($this->filename, $this->mode);
        self::log('Logging started. Session Id');
    }
    
    /* 
     * When the class is about to be destructed we close the logfile
     * @function __destruct() Closes logfile
     */
    function __destruct() {
        fclose(self::$file);
    }
    
    /*
     * We log $that!
     * @function log()
     * @param String $that Text to be logged plus an PHP_EOL
     */
    static function log($that){
        fwrite(self::$file, $that. PHP_EOL);
    }
    
    /*
     * @function show()
     * @returns logfile
     */
    function show(){
        
        return file_get_contents($this->filename);
    }
    
}
  

