<?php
/*
 * This part is for commenting what we need for this class to work.
 * 
 * In general terms, we create our i18n.class instance with default settings.
 * In case different settings are passed to the constructor we should change
 * the language.
 * If we call 'new i18n()' this goes default
 * 
 * If we want to change the language later we can simply do it with a function
 * set_language($new_lang).
 * 
 * We also need to define: LANG_PATH, DEFAULT_LANG. (currently in settings.php).
 * 
 */
namespace BoxTreme;

class i18n{
    var $language;
    var $language_path;
    var $filename;
    
    /*
     * We construct our Language class by getting the path where the language
     * files are stored, the specified language we searching for and then we
     * load the language asked or the default if the asked one doesn't exist.
     */
    public function __construct($language = DEFAULT_LANG) {
        $this->language_path = LANG_PATH;
        if($language!=NULL){
            $this->change_language($language);
        }
        else{
            $this->language = DEFAULT_LANG;
            $this->change_language($this->language);
        }
    }
    
    /*
     * This basically creates the path for the language file so we can load it.
     */
    private function createFilePath($language){
        $filename = $this->language_path;
        $filename .= $language;
        $filename .= ".php";
        $this->filename = $filename;
        return $this->filename;
    }
    /*
     * Setting language.
     */
    private function set_language($language){
        require_once $this->filename;
    }
    
    /*
     * We check here if file exists.
     */
    private function file_check($language){
        
        if(file_exists($this->filename)){    
            $this->language = $language;
        }
        else{
            $this->language = DEFAULT_LANG;
            $this->createFilePath($this->language);
        }
    }
    
    /* 
     * Changing a language should repeat the same procedure as setting initially
     * the language when the class is initiated for first time. So the checks are
     * normally the same as previous, so we just need to call the same function
     * in __construct().
     */
    public function change_language($language = DEFAULT_LANG){

        $this->createFilePath($language);   // Create filepath so we can check
        
        $this->file_check($language);       // Check

        $this->set_language($language);     // Load
    }
    
    public function getLanguage(){
        return $this->language;
    }
}

