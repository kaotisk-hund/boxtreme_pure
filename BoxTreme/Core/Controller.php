<?php
namespace BoxTreme\Core;
/*
 * This is a controller xD
 * 
 * It'll be useful for some things, most of things. ty
 * 
 */

class Controller extends Generic{
    /* Hi! I am the Controller! People tell me what they want
     * and I forward their requests to the right (or left)
     * direction.
     * Soooo, I have to know who is where in order to successfully
     * complete my job.
     * Then, I need an array to store the "$actions" I forward.
     * Now, every time this page reloads I'll be created and have
     * to find out what the user wants.
     */
    
    /*
     * Array $actions{
     *      Int $id{
     *          String $classname, String $action
     *      }
     */
    static private $actions = [];
    
    /*
     * Array $requests
     *      
     */
    private $requests = [];
    
    /*
     * Array $data
     */
    private $data = [];
    
    /*
     * String $lastClass
     */
    private $lastClass;
    
    /*
     * String $lastObject
     */
    private $lastObject;
    
    /*
     * String $lastSignal
     */
    private $lastSignal;
    
    function init(){
        $this->requests = $this->escapeData($_GET);
        $this->data = $this->escapeData($_POST);
    }
    
    /*
     * Some basic escape
     */    
    function escapeData($data){
        if(isset($data) && is_array($data)){
            foreach ($data as $key => $value) {
                if(is_string($key)){
                    $data[$key] = mysql_real_escape_string($value);
                }
            } 
        } else {
            $data = mysql_real_escape_string($data);
        }
        return $data;
        
    }
    
    /*
     * Just registers a new action in order to know what to do
     */
    static function register($class, $action){
        self::$actions[] = [$class, $action] ;
        Log::log(__CLASS__.'::Registered actions: '. $class.', '.$action);
        
    }
        
    /*
     * call() is called when the program is ready
     */
    function call(){
        $this->parseData();
        if($this->requests != NULL){
            foreach ($this->requests as $key => $value) {
                $classname = strtolower($this->classFinder($key));
                
                        $to_run = ''
                            . 'global $'.$classname.';'
                            . 'if($'.  $classname.' != null){'
                                . '$' . $classname . '->signal(\'' . $key . '\',$this->data);'
                            . '} else {'
                                . '$' . $classname . '= new ' . $this->classFinder($key) . '();'
                                . '$' . $classname . '->signal(\'' . $key . '\',$this->data);'
                            . '}';
                    eval($to_run);
            }
        } else {
            global $bxtreme;
            $bxtreme->home();
        }
        
    }
    
    /*
     * Find the class of the action requested
     */
    function classFinder($key){
        for($i=0; $i < count(self::$actions); $i++){
            if(self::$actions[$i][1]== $key){
                return self::$actions[$i][0];
            }
        }
    }
    
    /* 
     * Parses requests and data to a specific format so the controller can provide
     * both $_GET and $_POST variables, to the requested function.
     * 
     * So as we have 3 things we get and 2 things to provide.
     * 
     */
    function parseData(){
        if($this->requests != NULL){
            foreach ($this->requests as $key => $value) {
                if($key != null){
                    //Gui::setMessage('$lastObject = '. $this->lastObject = strtolower($this->classFinder($key)));
                    //Gui::setMessage('$lastClass = ' . $this->lastClass = $this->classFinder($key));
                    //Gui::setMessage('$lastSignal = ' . $this->lastSignal = $key);
                }
                if($value != null){
                    $this->data[] = $value;
                }
                
            }
        } else {
            Gui::setMessage(NULL);
        }
    }
    
    function printInfo(){
        echo '<pre>';
        var_dump(self::$actions);
        echo '</pre>';
    }
}