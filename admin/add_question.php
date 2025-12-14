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

$error = "";
if($_SERVER['REQUEST_METHOD']=='POST'){
    $subject = $_POST['subject'];
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $answer = $_POST['answer'];

    $_SESSION['selected_subject'] = $subject;

    $insert = "INSERT INTO questions (subject, question, option1, option2, option3, option4, answer)
        VALUES ('$subject','$question','$option1','$option2','$option3','$option4','$answer')";
    

    if(mysqli_query($connect,$insert))
    {
        header("Location: questions_view.php?isSuccess=add");
        exit();
    }
}
?>

<html>
    <head>
        <title>Add a new question</title>
        <link rel="stylesheet" href="admin_style.css">
    </head>
    <body>
        <div class="container">
            <h2>Add a new question</h2>
            <form method="POST" action="">
                <label>Select subject:</label>
                <select name="subject" required>
                    <option value="cs">Computer Science</option>
                    <option value="math">Mathematics</option>
                    <option value="gk">General Knowledge</option>
                </select><br><br>
                <label>Question:</label>
                <input type="text" name="question" required><br><br>
                <label>Add options:</label>
                <input type="text" name="option1" required><br><br>
                <input type="text" name="option2" required><br><br>
                <input type="text" name="option3" required><br><br>
                <input type="text" name="option4" required><br><br>
                <label>Correct Answer (1-4):</label>
                <input type="number" name="answer" required><br><br>
                <button type="submit" class="btn">Submit</button>
            </form>
            <br>
            <a href="questions_view.php"><button class="btn btn-delete">Back to questions view</button></a>
        </div>
    </body>
</html>
