<?php

namespace YPUrldownloader;

class DownloaderEmulator extends ADownloader {

    private $dir;

    public function __construct($dir){
        $this->dir = rtrim($dir, ' /') . '/';
    }
    
    public function download($baseUrl, $params = array())
    {
        $url = $this->getFullUrl($baseUrl, $params);
        $name = $this->emulatorNameFromUrl($url);

        $fullpath = $this->dir . $name;
        if (!file_exists($fullpath)) {
            throw new Exception404();
        }

        return file_get_contents($fullpath);
    }
}