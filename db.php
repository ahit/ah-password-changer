<?php
    function connectDB(){
                include("data.php");
                $dsn = $DatabaseType.":host=".$DatabaseServer.";dbname=".$DatabaseName;
                return(new PDO($dsn, "$DatabaseUsername", "$DatabasePassword"));
        }
?>
