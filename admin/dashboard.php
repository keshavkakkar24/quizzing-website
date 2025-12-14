<?php
    session_start();
    include "../config.php";

    // Prevent browser from caching pages
    header("Cache-Control: no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

    if(!isset($_SESSION['admin'])){
        header("Location: login.php");
        die();
    }    
?>

<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<div class="container">
    <h1>Admin portal</h1>
    <p>Select one of the following options to</p>
    <br><br>
    <center>
        <a href="questions_view.php"><button class="btn">Questions view</button></a>
        <br><br>
        <a href="results_view.php"><button class="btn btn-admin">Results view</button></a>
    </center>
</div>
</body>
</html>
