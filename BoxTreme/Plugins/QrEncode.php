<?php
namespace Plugins;

class QrEncode{
    private $command = '';
    private $filename = '';
    private $string = '';
    private $fullfilename = '';
    const QR_ENCODE_SAVE_PATH = 'images/qr/';
    const QR_ENCODE_FILE_EXT = '.png';
    
    public function __construct($string) {
        $this->init($string);
    }
    
    public function init($string){
        $this->createQrImage($string);
        $this->getQrImage();
    }
    public function createFilename($string){
        $this->filename = md5($string);
        $this->fullfilename = QR_ENCODE_SAVE_PATH . $this->filename. QR_ENCODE_FILE_EXT;
        return $this->fullfilename;
    }
    public function createQrImage($string){
        $this->createFilename($string);
        $this->command = 'qrencode -o \''. $this->fullfilename .'\' '
                . '\''. $string .'\'';
        shell_exec($this->command);
    }
    
    public function getQrImage(){
        return $this->fullfilename;
    }
    

    
    
}
