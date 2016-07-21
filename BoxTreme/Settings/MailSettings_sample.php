<?php

namespace BoxTreme\Settings;

use BoxTreme\Core;

class MailSettings extends Core\Generic{
    
    private static $data = ['username' => 'sender email',
        'password' => 'password'];
    
    function init(){
        $this->getSettings();
    }
    
    static function getSettings(){
        return self::$data;
    }
}