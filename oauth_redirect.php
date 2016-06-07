<?php
require_once('./config.php');

require_once('include/abraham-twitteroauth/autoload.php');

session_start();

use Abraham\TwitterOAuth\TwitterOAuth;

// TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, 
	TWITTER_CONSUMER_SECRET);

// コールバック URL をセット
$request_token = $connection -> oauth ('oauth/request_token', 
	array('oauth_callback' => TWITTER_OAUTH_CALLBACK) );

// callback.php で使うためセッションに格納
$_SESSION['oauth_token'] = $request_token['oauth_token'];

$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

// twitter.com での認証画面 URL を取得
$url = $connection -> url('oauth_authenticate', 
	array('oauth_token' => $request_token ['oauth_token']) );

// twitter.com へリダイレクト
header('location: '. $url);

?>
