<?php
	$words = file('wordsEn.txt');
	$specials = array("#","_","-","!","@","$","%","^","&","*","+","=");

	for($i = 0; $i<25; $i++){
	$word1 = trim($words[array_rand($words)]);
	$word2 = trim($words[array_rand($words)]);
	$special = $specials[array_rand($specials)];

	print($word1.$special.$word2."\n");
	}
?>
