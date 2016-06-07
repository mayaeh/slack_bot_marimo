<?php

session_start();

require_once 'config.php';
require_once 'include/abraham-twitteroauth/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

//login.phpでセットしたセッション
$request_token = array();

$request_token['oauth_token'] = null;
$request_token['oauth_token_secret'] = null;

if (!array_get_value($_SESSION, 'oauth_token','') or 
	!array_get_value($_SESSION, 'oauth_token_secret','') or 
	!array_get_value($_REQUEST, 'oauth_token','') ) {

	header('location: oauth_index.html');
}

$request_token['oauth_token'] = $_SESSION['oauth_token'];

$request_token['oauth_token_secret'] = 
	$_SESSION['oauth_token_secret'];

// Twitterから返されたOAuthトークンと、あらかじめ login.php 
// で入れておいたセッション上のものと一致するかをチェック
if (isset($_REQUEST['oauth_token']) && 
	$request_token['oauth_token'] !== 
	$_REQUEST['oauth_token']) {

    	die( 'Error!' );
    }

//OAuth トークンも用いて TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, 
	TWITTER_CONSUMER_SECRET, $request_token['oauth_token'], 
	$request_token['oauth_token_secret']);


$_SESSION['access_token'] = $connection -> 
	oauth("oauth/access_token", array("oauth_verifier" => 
	$_REQUEST['oauth_verifier']));

//セッションIDをリジェネレート
session_regenerate_id();

//ユーザー情報をGET
$user = $connection -> get("account/verify_credentials");

if (isset($user -> name)) {

	//リダイレクト
	header('location: oauth_success.html');
}
else {

	echo "ユーザー情報の取得に失敗しました。\n";
}

?>
