<?php

namespace YPUrldownloader;

class Downloader extends ADownloader {

    public function download($url, $params=array())
    {
        return file_get_contents($this->getFullUrl($url, $params));
    }

    public function downloadForEmulator($baseUrl, $params=array(), $inDir='.') {

        $dir = rtrim($inDir, ' /') . '/';
        $url = $this->getFullUrl($baseUrl, $params);

        $content = $this->download($url);

        file_put_contents($dir . $this->emulatorNameFromUrl($url), $content);

        // save meta info for file
        $meta = array(
            'url' => $url,
        );
        file_put_contents($dir . $this->emulatorNameFromUrl($url, 'json'), json_encode($meta));
    }

}