
<html>
<head>
    <link rel = "stylesheet" type="text/css" href="style.css" media="screen"/>
</head>
<body>
<form>
<h1>username:</h1>
<input type = "text"><br/><br/>
<h1>choose a new password:</h1>
<h2>don't forget to write it down</h2>
<ul>

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
        $password = $pwgen->generate();
        if(strlen($password)==$length)
        echo "<li>".$password."</li>";
    }


?>
</ul>
<input type ="submit" value = "I don't like these ones"/><br/>
<h1>now, practice it 3 times:</h1>
<input type ="password">
<input type ="password">
<input type ="password">
<h1>and just to make sure you're you, type your old password:</h1>
<input type ="password"><br/><br/>
<input type ="submit" value = "Submit"/>
</form>
</body>
</html>
