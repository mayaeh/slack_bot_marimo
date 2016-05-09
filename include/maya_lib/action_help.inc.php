<?php

function action_help () {

	$res_text = "こまんどりすと";

	$patterns = array(
		'/\\\\s\?/u', '/\(\.\*\)/u', '/\$$/u', '/\\\\/u'
		);

	$db = new SQLite3 (DB_FILE);

	$db_res = $db -> query ('SELECT * FROM word_verb;');

	while ($row = $db_res -> fetchArray(SQLITE3_ASSOC)) {

		$res_text .= "\n". preg_replace 
			($patterns, '', $row['word']);

	}

	$db -> close();

	return $res_text;

}

?>
