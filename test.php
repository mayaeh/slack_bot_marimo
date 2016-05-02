<?php

require_once ('config.php') ;
use PhpSlackBot\Bot ;

if ( ! defined ('SLACK_API_TOKEN') )
{ exit ("SLACK_API_TOKEN is not set.\n") ; }

$bot = new Bot () ;
$bot -> setToken (SLACK_API_TOKEN) ;

$bot -> run () ;

?>
