<?php

function action_tweet ($text) {

	if (!isset($text)) {
		return '本文が空欄のため中止しました。';
	}

	// このやり方だけでは URL が含まれていた場合に正しく認識できない
	// ( 公式短縮 URL のため )
	if (mb_strlen($text) and mb_strlen($text) < 140) {

// for debug
//return mb_internal_encoding();
//return mb_strlen($text);
//$media_tmp_path = SCRIPT_DIR. 'resources/usagi_re_r.jpg';

		$connection = new Abraham\TwitterOAuth\TwitterOAuth 
			(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, 
			TWITTER_OAUTH_ACCESS_TOKEN, TWITTER_OAUTH_ACCESS_TOKEN_SECRET);

//	$content = $connection -> get 
//		("statuses/user_timeline", ["count" => 1, "page" => 1]);



		if(!isset($media_tmp_path)) {
		
			$parameters = ['status' => $text];
		}
		else {

			$media = $connection ->
				upload ('media/upload', 
				['media' => $media_tmp_path]);

			$parameters = ['status' => $text,
				'media_ids' => $media -> media_id_string];
		}

		$statuses = $connection -> post 
			('statuses/update', $parameters);


// for debug
//return $connection;

		if ($connection -> getLastHttpCode() == 200) {
		// Tweet posted succesfully

			$screen_name = 
				$statuses -> user -> screen_name;

			$id = $statuses -> id_str;

			if (isset($screen_name) and isset($id)) {

				$tweet_url = 'https://twitter.com/'. 
					$screen_name . '/status/'. 
					$id;

				unset($statuses);
				unset($connection);

				return "ツイートしました。\n". $tweet_url;
			}
		}
		else {

			$message = 'ツイートに失敗しました。';

			if (property_exists($statuses, 'errors')) {
				// Handle error case

				$message .= "\n". $statuses -> errors [0] -> message;
			}

			unset($statuses);
			unset($connection);

			return $message;
		}
	}
	else {

		return '文字数オーバーです。';
	}
}

?>
