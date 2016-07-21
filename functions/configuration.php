<?php

function check_config(){
// Check configuration
    if (file_exists(ROOT_DIR . '/configuration.php')) {
        $config = include_once(ROOT_DIR . '/configuration.php');
    } else {
        // Should start install progress
        // Not implemented yet
    }
    return $config;
}