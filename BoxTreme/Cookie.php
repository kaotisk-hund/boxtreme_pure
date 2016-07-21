<?php

class Cookie{
        
    var $name;			// Last name of cookie handled
    var $content;		// Last content
    var $time;			// Usually time is constant and set at settings.php
    var $path;			// The path
    var $host;			// The host
    var $https;			// Https boolean also set in settings.php
    
    /*
     * When we create an instance of cookie class, we have to know the $host,
     * if $https or not, the $time and the $path. Then our cookie instance is
     * ready to create_cookie() and remove_cookie()
     */
    public function __construct($host, $https, $time, $path){
        $this->host = $host;
        $this->https = $https;
        $this->time = $time;
        $this->path = $path;
        $this->check();
    }
    /*
     * We just get the $name and the $content, everything else is default
     */
    public function create_cookie($name, $content){
        $this->name = $name;
        $this->content = $content;
        setcookie($this->name, $this->content, $this->time, $this->path, $this->host, $this->https);
    }
    /*
     * Sets the time of the selected cookie to 0.
     */
    public function remove_cookie($name){
	$this->name = $name;
	$this->time = 0;
	$this->content = '';
	setcookie($this->name, $this->content, $this->time, $this->path, $this->host, $this->https);
    }
    /*
     * We should check if any of our cookies exist so we don't send duplicates
     * or encourage cookie exploits. (Have no idea!!)
     */
    public function check(){
       // print_r($_COOKIE);
    }
    
}
