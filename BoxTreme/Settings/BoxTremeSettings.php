<?php

namespace BoxTreme\Settings;

use BoxTreme\Core;

class BoxTremeSettings extends Core\Generic{
    
    static $settings;
    
    static private $mySQL;
    
    function init(){
        $this->getSettings();
    }
    
    static function getSettings(){
        self::$mySQL = new Core\MySQL(SQL_USER, SQL_PASS, SQL_DB, SQL_HOST);
        self::$mySQL->select('bx_Settings');
        if(isset(self::$mySQL->return_data)){
            foreach(self::$mySQL->return_data as $key => $data ){
                self::$settings[$data['what']] = $data['data'];
            }
            
        }
        
        return self::$settings;
    }
    
    static function setSettings($what, $data){
        self::$mySQL = new Core\MySQL(SQL_USER, SQL_PASS, SQL_DB, SQL_HOST);
        
        self::findId($what);
        self::$mySQL->update('bx_Settings', self::findId($what), ['data' => $data]);
    }
    
    static function findId($what){
        self::$mySQL->select('bx_Settings','*','what',$what);
        if(isset(self::$mySQL->return_data)){
            foreach(self::$mySQL->return_data as $key => $data ){
                
                $id = $data['id'];
            }
            
        }
        return $id;
    }
}