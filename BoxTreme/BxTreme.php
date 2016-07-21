<?php
namespace BoxTreme;

use BoxTreme\Core;
use BoxTreme\Settings;

class BxTreme extends Core\Generic{
    
    private $mySQL;
    var $gui;
    
    
    var $installed;
    var $navigation;
    
    private $home_post_id;
    private $post;
    
    private $settings;

    private $home_template;

    
    var $plugin;
    var $debugmode = false;
    /*
     * HOME_TEMPLATE_FILENAME
     * Default: ROOT_DIR.'gui/home.php'
     */
    const HOME_TEMPLATE_FILENAME = ROOT_DIR.'/gui/home.php';
    
    
    const CLASSNAME = 'bxtreme';
    
    function init(){
        $this->settings = Settings\BoxTremeSettings::getSettings();
        
        Core\Controller::register(self::CLASSNAME,'home');
        Core\Gui::setTopbarMenu(['link'=>'?home', 'title'=>'Home'], 'all', 'left');
        $this->bxStart();
    }
    
    function signal($request, $data = null){
        switch ($request){
            case 'home':
                $this->home();
                break;
            default :
                $this->home();
                break;
        }
    }
    
    function home(){
        /*global $post;
        if(isset($post)){
            $post->setId($this->settings['home_post_id']);
        } else {
            $post = new Post();
            $post->setId($this->settings['home_post_id']);
            
        }*/
        $this->home_template = file_get_contents(self::HOME_TEMPLATE_FILENAME);
        Core\Gui::setBody($this->home_template);
    }
    
    function errPage(){
        
        Core\Gui::setBody('404');
    }

    public function bxStart(){
        
        
    }
    
    public function install(){
        
    }
    

}