<?php

function action_search ($text) {

//var_dump($text);


	if (!isset ($text)) {

		return '検索語句が空欄のため中止しました。';
	}


//var_dump(yahoo_ma($text, 9));

	$res_array = yahoo_ma ($text, 9);

	$i=0;
	while (isset ($res_array ['feature'][$i])) {

		$tmp_array = explode(',', $res_array['feature'][$i]);

//var_dump($tmp_array);

		$word_array[] = $tmp_array[5];

		$i++;

	}

//var_dump($word_array);

	$search_word = implode (' ', $word_array);

//var_dump($search_word);

	$base_url='https://www.google.co.jp/search?q=';

// for debug
//$search_word = '明日 大阪 天気';
//$search_word = '6740';
//$search_word = '256/3';
//$search_word = '今日 何の日';
//$search_word = 'slack';
//$search_word = '新居浜市 地図';

//var_dump(urlencode($search_word));
//exit;

	$url = $base_url. urlencode ($search_word);

	$output_file_name = create_site_image ($url);

	if (isset ($output_file_name)) {

		$image_url = CAP_OUTPUT_URL. $output_file_name;

	}

}

?>
