<?php


/*
 * Removes namespace from Class name and returns it
 * 
 * param $namespace
 */

function strip_namespace($namespace, $class){
    
    $stripped = trim(preg_replace( "/".$namespace."/", "", $class), '\\');
    return $stripped;
}