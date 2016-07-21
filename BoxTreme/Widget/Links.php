<?php

// This class creates a widget with a list of links
namespace BoxTreme\Widget;
use BoxTreme\Core;
class Links extends Core\Generic{
    /*
     * @param array $links Array of links
     */
    private $links = [];
    
    /*
     * @function __construct() Constructor
     */
    
    
    /*
     * @function init() Beloved init
     */
    function init(){
        global $mySQL;
        $mySQL->select('bx_Links');
        $this->links = $mySQL->return_data;
        $this->show();
    }
    
    /*
     * @function signal($request) For listen Controller's calls
     * @param string $request Requested action
     */
    function signal($request){
        switch ($request){
            case 'show':
                $this->show();
                break;
            default:
                $this->show();
                break;
        }
    }
    
    /*
     * @function show() Shows links
     */
    function show(){
        global $gui;
        
        $GLOBALS['widget'][] = '<h5>Links</h5><ul>'.$gui->listElements($gui->linkIt($this->links))."</ul>";
    }
    
}