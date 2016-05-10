<?php

function action_tweet ($text) {

	if (isset($text)) {
		return null;
	}

	$connection = new TwitterOAuth 
		(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, 
		TWITTER_OAUTH_ACCESS_TOKEN, TWITTER_OAUTH_ACCESS_TOKEN_SECRET);

	$content = $connection -> get 
		("statuses/user_timeline", ["count" => 10, "page" => 1]);

// for debug
var_dump($connection);

}

?>
