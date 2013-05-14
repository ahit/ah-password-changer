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
    echo "<html><form>";
    for($i = 0; $i<10; $i++){
        $password = $pwgen->generate();
        if(strlen($password)==$length)
        echo "<input type = \"radio\" name=\"password\">".$password."</radio><br/>";
    }
    echo "<input type =\"submit\" value = \"Submit\"/>";
    echo "<input type =\"submit\" value = \"Generate a new set\"/>";

    echo "</form></html>";

?>
