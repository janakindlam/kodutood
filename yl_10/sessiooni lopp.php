<?php 
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-60000, '/');
    }
    session_destroy();
    header("Location: kontroller.php");
?>