<?php

require_once('vendor/autoload.php');

//
// Download pages for downloader emulator
//
function downloadPage($downloader, $dir, $url) {
    $downloader->downloadForEmulator($url, array(), $dir);
}

$downloader = new \YPUrldownloader\Downloader();
$dirToSave = dirname(dirname(__FILE__)) . '/tests/example-data/downloader-emulator';
$urls = array(
    'http://yandex.ru',
    'http://google.com',
    'http://yandex.ru/search/?lr=21653&text=test',
);

foreach ($urls as $url) {
    downloadPage($downloader, $dirToSave, $url);
}