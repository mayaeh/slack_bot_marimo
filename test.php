<?php

require_once ('config.php') ;
use PhpSlackBot\Bot ;

if ( ! defined ('SLACK_API_TOKEN') )
{ exit ("SLACK_API_TOKEN is not set.\n") ; }




// This special command executes on all events
class SuperCommand extends \PhpSlackBot\Command\BaseCommand {

	protected function configure() {
		// We don't have to configure a command name in this case
	}

	protected function execute($data, $context) {
		if ($data['type'] == 'message') {
			$channel = $this->getChannelNameFromChannelId($data['channel']);
			$username = $this->getUserNameFromUserId($data['user']);
            //echo $username.' from '.($channel ? $channel : 'DIRECT MESSAGE').' : '.$data['text'].PHP_EOL;


			// 文の最初に @marimo を付けて呼ばれた場合
			if (preg_match ("/^<@" . 
				BOT_USER_ID . ">/u", 
				$data['text']) ) {

				$action_flg = 1;

			}
			// 文の末尾に @marimo を付けて呼ばれた場合
			else if (preg_match ("/<@" . 
				BOT_USER_ID . ">$/u", 
				$data['text']) ) {
				
				$action_flg = 2;
			}
			// 文の途中で @marimo を付けて呼ばれた場合
			else if (preg_match ("/<@" . 
				BOT_USER_ID . ">/u", 
				$data['text']) ) {
				
				$action_flg = 3;
			}


			switch ($action_flg) {

			case 1:

			case 2:

// for debug
//$thismessage = $username . ' from ' . 
//	($channel ? $channel : 'DM' ) . 
//	' : ' . $data['text'] ;
//var_dump($data['text']);

				$db = new SQLite3 (DB_FILE);

				$db_res = $db -> 
					query ('SELECT * FROM word_verb;');

				while ($row = $db_res -> 
					fetchArray(SQLITE3_ASSOC)) {

					if (preg_match('/'. $row['word']. '/u', 
						$data['text'], $matches) ) {

// for debug
//var_dump($matches);

						switch ($row['action']) {

						case 'tweet':

							$action_res = action_tweet ($matches[1]);

							break;

						case 'tweet_delete':

							$action_res = action_tweet_delete();

							break;

						case 'search':

							$action_res = 
								action_search ($matches);

							break;

						case 'help':

							$action_res = action_help();

							break;

						}

					}

				}

				$db -> close();

				if (isset($action_res)) {

					$thismessage = $action_res;

					break;
				}

			case 3:

				$thismessage = 'よんだ？';

			}


			if (isset($thismessage) ) {

				$this -> send($data['channel'], 
					$data['user'], $thismessage);
  
 			}
        }
    }
}


$bot = new Bot () ;
$bot -> setToken (SLACK_API_TOKEN) ;

$bot->loadCatchAllCommand(new SuperCommand());

$bot -> run () ;

?>
