<?php
    include('pwgen.class.php');
    $length = 8;
    $secure = false;
    $numerals = true;
    $capitalize = true;
    $ambiguous = false;
    $no_vowels = false;
    $symbols = true;
    $pwgen = new PWGen($length,$secure,$numerals,$capitalize,$ambiguous,$no_vowels,$symbols);
    for($i = 0; $i<10; $i++){
        for($j = 0; $j<8; $j++){
            $password = $pwgen->generate();
            echo $password."\t";
        }
        echo "\n";
    }

?>
