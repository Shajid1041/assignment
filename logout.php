<?php
session_start();

if (basename(__FILE__) === 'logout.php') {
    unset($_SESSION['name']);
    unset($_SESSION['user_id']);

    session_destroy();

    header('Location: index.php');
    return;
}
?>
