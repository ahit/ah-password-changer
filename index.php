
<html>
<head>
    <link rel = "stylesheet" type="text/css" href="style.css" media="screen"/>
    <script type ="text/javascript" src="checkpass.js"></script>
</head>
<body>

<?php
session_start();
if(isset($_SESSION['generated_pws']))
    $generated_pws = $_SESSION['generated_pws'];
else
    $generated_pws = Array();


//case first time or want to regenerate passwords
if(!empty($_POST['regen']) || empty($_POST['submit']) || empty($_POST['pass_id'])){?>
<div id = "message">
<p><strong>It's password changing time!</strong></p>
<p>Once you change your password on this form the following will happen:
<ul>
	<li>your OpenSIS password will be changed <strong>immediately</strong></li>
	<li>you will get an email confirming that your password has changed</li>
	<li>your computer logon password will be changed to this password <strong>in the first week of June</strong></li>
	<li>your email password will be changed to this password <strong>in the first week of June</strong></li>
</ul>
You have until <strong>June 2nd</strong> to choose a new password, at which point a random one will be assigned to you</p>
</div>

<form action = "index.php" method = "post">
<h1>your username:

<?php
    if(empty($_POST['username']) && !empty($_POST['submit'])){
        ?>
            <strong style = "color: red;">* </strong>
        <?php
    }
?>

</h1>
<input type = "text" name = "username" value = "<?php if(!empty($_POST['username'])) echo $_POST['username'];?>"><br/><br/>
<h1>here are some new password options, select one</h1>
    <?php
    if(empty($_POST['pass_id']) && !empty($_POST['submit'])){
        ?>
            <strong style = "color: red;">Make sure you click the button next to the password!</strong>
        <?php
    }
    ?>


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

    if(isset($_SESSION['i']) && !empty($_SESSION['i']))$i = $_SESSION['i'];
    else { $i = 0; $_SESSION['i'] = 0;}

    for($i; $i<$_SESSION['i']+10; $i++){
        $password = $pwgen->generate();
        if(strlen($password)==$length)
        echo "<div class = \"new_pass\"><input type =\"radio\" name = \"pass_id\" value =\"$i\">$password</input></div>\n";
        $generated_pws[$i] = $password;
    }

    $_SESSION['i'] = $i;
    $_SESSION['generated_pws'] = $generated_pws;


?>
<br/>
<input type ="submit" name = "regen" value = "I don't like these ones"/><br/>
<h1>now, practice your favorite one 3 times:</h1>
<h2>(this is optional - if you put nothing here, I won't tell)</h2>
<input type ="password" id="pass1">
<input type ="password" id ="pass2" onkeyup="checkPass(); return false;">
<input type ="password" id ="pass3" onkeyup="checkPass(); return false;">
<h1>and just to make sure you're you, type your opensis password:</h1>
<input type ="password" name ="password"><br/><br/>
<input type ="submit" name = "submit" value = "Submit"/>
</form>
<?php
}//end initial view
else{
    include('db.php');

    if(empty($_SESSION['attempts'])) $_SESSION['attempts'] = 1;
    else $_SESSION['attempts']++;

    $pass_id = $_POST['pass_id'];
    $new_pass = $generated_pws[$pass_id];
    $old_pass = $_POST['password'];
    $username = $_POST['username'];

    $dbh = connectDB();

    $sql = "SELECT student_id as sid FROM students WHERE username = '$username' AND password = '".md5($old_pass)."'";
    $query = $dbh->prepare($sql);
    $query->execute();
    $res = $query->fetch();
    $sid = $res['sid'];

    if(!empty($sid)){ //that is, if res is non-zero
        echo "<h4>you changed your password!</h4>";
        echo "<p>Don't forget it: <div class = \"new_pass\">$new_pass</div></p>";
        //actually change the password and update student records

        $sql = "UPDATE students set password = '".md5($new_pass)."' WHERE username = '$username'";
        $query = $dbh->prepare($sql);
        $query->execute();

        $sql = "INSERT INTO student_mp_comments values ('','$sid','2012','0','31','Student updated password to: $new_pass','".date("Y-m-d")."')";
        $query = $dbh->prepare($sql);
        $query->execute();

        //send an email alerting the user their password has been changed
        $to      = $username.'@students.logoscambodia.org';
        $subject = 'password change for Asian Hope services';
        $message = 'This is to alert you that the password for '.$username.' has been changed
        If you did not make this request please send an email to it@asianhope.org to report this incident';
        $headers = 'From: no-reply@opensis.logoscambodia.org' . "\r\n" .
                   'Reply-To: no-reply@opensis.logoscambodia.org' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);

        session_destroy();
    }
    else if($_SESSION['attempts']<3){
        echo "<h3>incorrect username or password</h3>";
        echo "<h1>on attempt: ".($_SESSION['attempts']+1)."/3</h1>";
        echo "<h2>you selected password: </h2><div class = \"new_pass\">$new_pass</div>";
    ?>
    <form action = "index.php" method = "post">
    <input type = "hidden" name = "pass_id" value = "<?php echo $pass_id;?>">
    <h1>username:</h1>
    <input type = "text" name = "username"/>
    <h1>password</h1>
    <input type = "password" name = "password"/>
    <input type = "submit" value = "Submit" name = "submit">

    </form>
    <?php
    }
    else {

        echo "Sorry, bro. <a href = \"index.php\">Try again?</a>";


        session_destroy();
    }
}
?>

</body>
</html>
