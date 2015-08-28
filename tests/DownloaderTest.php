<?php

namespace YPUrldownloader;

class DownloaderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \YPUrldownloader\Downloader
     */
    private $downloader;

    /**
     * @var string
     */
    private $filesDir;

    public function setUp(){
        $this->downloader = new Downloader();
        $this->filesDir = dirname(__FILE__) . '/example-data/downloader/';
    }

    public function tearDown(){
        foreach (scandir($this->filesDir) as $filename) {
            if (in_array($filename, array('.', '..'))) {
                continue;
            }
            unlink($this->filesDir . $filename);
        }
    }

    public function testDownload(){
        $content = $this->downloader->download('http://yandex.ru');
        $this->assertContains('yandex', $content);
    }

    public function testDownloadForEmulator(){
        $testUrl = 'http://yandex.ru';
        $this->downloader->downloadForEmulator($testUrl, array(), $this->filesDir);

        $this->assertFileExists($this->filesDir . '664b8054bac1af66baafa7a01acd15ee');
        $this->assertFileExists($this->filesDir . '664b8054bac1af66baafa7a01acd15ee.json');

        $metaContent = file_get_contents($this->filesDir . '664b8054bac1af66baafa7a01acd15ee.json');
        $meta = json_decode($metaContent);
        $this->assertEquals($testUrl, $meta->url);
    }
    
}