<?php

$dsn = 'mysql:host=localhost;dbname=resume_database';  
$username = 'shajid';
$password = 'enter'; 


    
    $pdo = new PDO($dsn, $username, $password);
    $sql = $pdo->query("SELECT * FROM users");
    
 


?>
