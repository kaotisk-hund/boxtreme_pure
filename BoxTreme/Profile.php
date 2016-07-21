<?php
namespace BoxTreme;
use BoxTreme\Core;

class Profile extends Core\Generic{
    private $user_id;
    
    private $avatar;
    private $first_name;
    private $last_name;
    private $middle_name;
    private $language;
    
    
    function init(){
        
    }
    
//    // Username
//    function getUsername(){
//        
//    }
//    function setUsername(){
//        
//    }
    
    // Avatar
    function getAvatar(){
        return $this->avatar;
    }
    function setAvatar(){
        
    }
    
    // Firstname
    function getFirstname(){
        return $this->first_name;
    }
    function setFirstname(){
        
    }
    
    // Middlename
    function getMiddlename(){
        return $this->middle_name;
    }
    function setMiddlename(){
        
    }
    
    // Lastname
    function getLastname(){
        return $this->last_name;
    }
    function setLastname(){
        
    }
    
    // Language
    function getLanguage(){
        return $this->language;
    }
    function setLanguage(){
        
    }
   
    
    
    
}

?>