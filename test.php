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


			if (preg_match ("/^<@" . 
				BOT_USER_ID . ">/u", 
				$data['text']) ) {


// for debug
				$thismessage = $username . ' from ' . 
					($channel ? $channel : 'DM' ) . 
					' : ' . $data['text'] ;

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
