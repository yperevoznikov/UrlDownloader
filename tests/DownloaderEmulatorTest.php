<?php

namespace YPUrldownloader;

class DownloaderEmulatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \YPUrldownloader\DownloaderEmulator
     */
    private $downloader;

    public function setUp(){
        $testDir = dirname(__FILE__) . '/example-data/downloader-emulator/';
        $this->downloader = new DownloaderEmulator($testDir);
    }

    /**
     * @dataProvider dataProviderDownload
     */
    public function testDownload($baseUrl, $params, $shouldContain) {
        $content = $this->downloader->download($baseUrl, $params);
        $this->assertContains($shouldContain, $content);
    }

    public function dataProviderDownload() {
        return array(
            array('http://yandex.ru/search/', array('lr' => '21653', 'text' => 'test'), 'yandex'),
            array('http://yandex.ru/search', array('lr' => '21653', 'text' => 'test'), 'yandex'),
            array('http://yandex.ru', array(), 'yandex'),
            array('http://google.com', array(), 'google'),
        );
    }

    /**
     * @expectedException \YPUrldownloader\Exception404
     */
    public function testDownloadNotFound(){
        $testUrl = 'http://yandexksljf8s88s.sdfru';
        $content = $this->downloader->download($testUrl);
        $this->assertContains('yandex', $content);
    }
    
}