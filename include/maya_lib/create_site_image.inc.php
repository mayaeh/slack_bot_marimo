<?php

function create_site_image ($search_word) {

	$base_url='https://www.google.co.jp/search?q=';

// for debug
//$search_word = '明日 大阪 天気';
//$search_word = '6740';
//$search_word = '256/3';
//$search_word = '今日 何の日';
//$search_word = 'slack';
//$search_word = '新居浜市 地図';

	if (!isset ($search_word)) {

		return null;
	}

//var_dump(urlencode($search_word));
//exit;

	$url = $base_url. urlencode ($search_word);

// my default settings
//$cap_width = 600;
//$cap_height = 400;
//$cap_top = 30;
//$cap_left = 120;

	$output_path = CAP_OUTPUT_DIR_NAME;

	$output_file_name = date ('Y-m-d_His'). '.jpg';

//var_dump($url);
//exit;

// これではできない
//$phjs = new JonnyW\PhantomJs\Client();
//$client = $phjs -> getInstance();

	$client = JonnyW\PhantomJs\client::getInstance();

	$client -> getEngine() -> setPath 
		(SCRIPT_DIR. 'include/composer/bin/phantomjs');

	$request = $client -> getMessageFactory() -> 
		createCaptureRequest ($url, 'GET');

	$request -> setOutputFile ($output_path. $output_file_name);
	$request -> setViewportSize (CAP_WIDTH, CAP_HEIGHT);
	$request -> setCaptureDimensions (CAP_WIDTH, CAP_HEIGHT, 
		CAP_TOP, CAP_LEFT);

	$response = $client -> getMessageFactory() -> 
		createResponse();

	$client -> send ($request, $response);

	if ($response -> getStatus() === 200) {

		return 'success';
	}
	else {

// error
//var_dump('error');

		return null;
	}
}

?>
