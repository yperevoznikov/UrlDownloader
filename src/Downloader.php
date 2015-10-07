<?php

namespace YPUrldownloader;

class Downloader extends ADownloader {

    public function download($baseUrl, $params=array())
    {
        $url = $this->getFullUrl($baseUrl, $params);

        $userAgent = $this->getRandomUserAgent();

        $options = array(
            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $userAgent, //set user agent
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
//        $err     = curl_errno( $ch );
//        $errmsg  = curl_error( $ch );
//        $header  = curl_getinfo( $ch );

//        $header['effective_url'] = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
//        $header['errno']   = $err;
//        $header['errmsg']  = $errmsg;
//        $header['content'] = $content;

        curl_close( $ch );

        return $content;
    }

	public function downloadPost($baseUrl, $paramsUrl=array(), $postData=array()){
		$url = $this->getFullUrl($baseUrl, $paramsUrl);

		$userAgent = $this->getRandomUserAgent();

		$options = array(
			CURLOPT_CUSTOMREQUEST  =>"POST",        //set request type post or get
			CURLOPT_POST           => true,        //set to GET
			CURLOPT_POSTFIELDS	   => http_build_query($postData),
			CURLOPT_USERAGENT      => $userAgent, //set user agent
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		);

		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );

		curl_close( $ch );

		return $content;
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

    public function getRandomUserAgent()
    {
        $agents = array(
            'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0',
            'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.16 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17',
            'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:25.0) Gecko/20100101 Firefox/25.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:25.0) Gecko/20100101 Firefox/25.0',
            'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20130406 Firefox/23.0',
            'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14',
            'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0) Opera 12.14',
            'Opera/12.80 (Windows NT 5.1; U; en) Presto/2.10.289 Version/12.02',
            'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)',
        );

        return $agents[array_rand($agents)];
    }

}