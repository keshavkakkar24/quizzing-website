<?php
    session_start();
    include "../config.php";

    // Prevent caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // Redirect if not logged in
    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit();
    }

    $id = $_GET['id'];
    $subject = $_GET['sub'];
    mysqli_query($connect,"DELETE FROM questions WHERE id='$id'");
    $_SESSION['selected_subject'] = $subject;
    header("Location: questions_view.php?isSuccess=delete");
    exit();
?>