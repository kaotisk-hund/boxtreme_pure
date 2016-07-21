<?php
namespace Plugins;



class Bitcoin {
    
    private $Blockchain;
    
    function __construct() {
        
        require '../../../../api-v1-client-php/lib/Blockchain.php';
        $this->Blockchain = new \Blockchain();
        
        $this->status();
    }
    
    function status(){
        $stats = $this->Blockchain->Stats->get();
        return $stats;
    }
}

$hi = new Bitcoin();