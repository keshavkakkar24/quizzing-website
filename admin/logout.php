<?php
    session_start();
    $_SESSION = array();

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    if (session_destroy())
    {
        header("Location: login.php");
        die();;
    }
?>
