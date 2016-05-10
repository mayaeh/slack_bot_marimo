<?php
// written by maya minatsuki
// made this file : 2016.04.30
// last mod. : 2016.04.30
//


// 連想配列の要素が存在するかチェックする関数
require_once ( SCRIPT_DIR . "include/unoh_lib/array_get_value.inc.php" ) ;

// Include Slack API Library. thanks
//require_once ( SCRIPT_DIR . "include/slack-api/Slack.php" ) ;

// Include jclg-slack-bot Library, abraham-twitteroauth Library, PhantomJS Library. thanks
require_once ( SCRIPT_DIR . 'include/composer/vendor/autoload.php' ) ;

require_once ( MAYALIB_DIR . 'access_log_writer.inc.php' ) ;

if ( ! function_exists ('sqlite_escape_string') ) {
	require_once ( MAYALIB_DIR . 'sqlite_escape_string.inc.php' ) ;
}

require_once ( MAYALIB_DIR . 'yahoo_ma.inc.php' ) ;

require_once ( MAYALIB_DIR . 'gshorten.inc.php' ) ;

require_once ( MAYALIB_DIR . 'action_tweet.inc.php' ) ;

require_once ( MAYALIB_DIR . 'action_tweet_delete.inc.php' ) ;

require_once ( MAYALIB_DIR . 'action_search.inc.php' ) ;

require_once ( MAYALIB_DIR . 'action_help.inc.php' ) ;

?>
