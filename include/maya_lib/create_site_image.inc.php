<?php

function create_site_image ($url) {

	if(!isset ($url)) {

		return null;
	}

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
