<?php


/*
 * This is the index.php. Therefore it's the page that anybody will go when sh/he
 * visits the site/cms.
 */
// Show all errors
error_reporting(E_ALL);

// Define the ROOT_DIR
define('ROOT_DIR', __DIR__);

try {
    // Load functions
    include 'functions/string_manipulators.php';
    include 'functions/setAutoload.php';
    include 'functions/configuration.php';
    
    
    setAutoload();

    $config = check_config();

    /* 
     * From now on we create our basic objects
     */

    // Starts the logging class
    $log = new BoxTreme\Core\Log();

    // Controller class
    $controller = new BoxTreme\Core\Controller();

    /*
     *  For some reason we started MySQL class too but it seems it does nothing at the point
     */
    $mySQL = new BoxTreme\Core\MySQL(SQL_USER, SQL_PASS, SQL_DB, SQL_HOST);

    /*
     *  BoxTreme class (let us say main() ? )
     */
    $bxtreme = new BoxTreme\BxTreme();

    // Start i18n
    $i18n = new BoxTreme\i18n();
    // Gui class
    $gui = new BoxTreme\Core\Gui($i18n->getLanguage());
    // For start we need an object of these "core classes"
    $user = new BoxTreme\Core\User();
    //$user->login('boxer', 'boxer');
    $post = new BoxTreme\Post();

    // Widget.Date class
    //new BoxTreme\Widget\Date();
    // Widget.Link class
    // new BoxTreme\Widget\Links();

    // We call
    $controller->call();
    
    // Output body
    $gui->body();
    

    
    
 //   include 'gui/tests/tests.php';
    
 //   $controller->printInfo();


} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}