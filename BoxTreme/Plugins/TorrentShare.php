<?php
namespace Plugins;

class TorrentShare {
    private $description = 'Use to share files through torrents';
    
    private $tracker = 'udp://10.42.0.1:6969/announce';
    private $filename = NULL;
    private $comment = 'Created by Torrent Share Plugin for BxTreme CMS';
    private $command = NULL;
    private $torrent = NULL;
    private $magnetURL = NULL;
    
    public function __construct() {
        parent::__construct();
            define('TORRENT_FOLDER','torrents/');
            define('TORRENT_SUFFIX','.torrent');

    }
    public function init(){}
    public function createTorrent($filename, $torrent){
        $this->filename = $filename;
        $this->createFullfilename($torrent);
        $this->command = 'transmission-create \''.
                $this->filename. '\''
                . ' -t '. $this->tracker. ''
                . ' -c \'' . $this->comment . '\''
                . ' -o \''. $this->torrent .'\'';
        shell_exec($this->command);
    }
    
    public function createFullfilename($filename){
        $this->torrent = TORRENT_FOLDER . $filename . TORRENT_SUFFIX;
        if(file_exists($this->torrent)){
            $this->torrent = $this->torrent . '.tmp';
        };
    }
    
    public function getMagnetURL(){
        $this->command = 'transmission-show -m \''.$this->torrent.'\'';
        $magnetURL = shell_exec($this->command);
        $this->magnetURL = $magnetURL;
        return $this->magnetURL;
    }
    
    public function info(){
        Debug::debug_out($this->description);
    }
    
    
    
    
    
}

