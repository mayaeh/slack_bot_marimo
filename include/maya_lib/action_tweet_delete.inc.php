<?php

function action_tweet_delete () {



	$connection = new Abraham\TwitterOAuth\TwitterOAuth 
		(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, 
		TWITTER_OAUTH_ACCESS_TOKEN, TWITTER_OAUTH_ACCESS_TOKEN_SECRET);


	$last_tweet = $connection -> get 
		('statuses/user_timeline', ['count' => 1]);

	if ($connection -> getLastHttpCode() == 200) {
 		// Tweet posted succesfully

// for debug
//return $last_tweet[0] -> id_str;
//$tweet_id = '730677513664368640';

 
	 	$tweet_id = $last_tweet[0] -> id_str;
 
 		if(isset($tweet_id)) {
 
 			$statuses = $connection -> post 
 					('statuses/destroy', ['id' => $tweet_id]);
 
 			unset($last_tweet);
 
 			if ($connection -> getLastHttpCode() == 200) {
				// Tweet posted succesfully

				unset($statuses);
				unset($connection);

				return '削除しました。';
 			}
 			else {
				// Handle error case

				$message = '削除に失敗しました。';

				if (property_exists($statuses, 'errors')) {

					$message .= "\n". $statuses -> errors [0] -> message;
				}

				unset($statuses);
				unset($connection);

				return $message;
 			}
 
 // for debug
 //var_dump($connection);
 //return $statuses;
 

 		}
	}
	else {
		// Handle error case
	}

	$message = '削除に失敗しました。\n最後のツイートの ID を検出できません。';

	if (property_exists($last_tweet, 'errors')) {

		$message .= "\n". $last_tweet -> errors [0] -> message;
	}

	unset($last_tweet);
	unset($connection);

	return $message;

}

?>
