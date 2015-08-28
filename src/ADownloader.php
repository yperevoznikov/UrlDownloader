<?php

namespace YPUrldownloader;

abstract class ADownloader {

    public abstract function download($url, $params=array());

    protected function getFullUrl($url, $params)
    {
        $suffix = '';
        if (is_array($params) && !empty($params)) {
            $sep = substr_count('?', $url) > 0 ? '&' : '?';
            $suffix = $sep . http_build_query($params);
        }
        return $url . $suffix;
    }

    protected function emulatorNameFromUrl($url, $ext=null) {
        return md5($url) . (isset($ext) ? ".$ext" : '');
    }

}