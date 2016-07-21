<?php

function setAutoload(){
    // Autoloader class
    require 'BoxTreme/Core/Autoloader.php';

    // Sets the default implementation for __autoload()
    spl_autoload_register( 'BoxTreme\Core\Autoloader::load' );
}