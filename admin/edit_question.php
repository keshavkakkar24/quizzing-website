<?php
    session_start();
    include "../config.php";

    // Redirect if not logged in
    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit();
    }

    $id = $_GET['id'];
    $q = mysqli_query($connect,"SELECT * FROM questions WHERE id='$id'");
    $question = mysqli_fetch_assoc($q);
    if(!$question)
    {
        echo "<script>alert(\"Invalid question selection\")</script>";
        header("Location: questions_view.php");
        exit();
    }
    $selected_subject = $question['subject'];

    function get_selection($selected_subject, $sub)
    {
        if ($selected_subject == $sub) return ' selected';
        else return '';
    }


    if($_SERVER['REQUEST_METHOD']=='POST'){
        $subject = $_POST['subject'];
        $qtext = $_POST['question'];
        $option1 = $_POST['option1'];
        $option2 = $_POST['option2'];
        $option3 = $_POST['option3'];
        $option4 = $_POST['option4'];
        $answer = $_POST['answer'];

        $update = "UPDATE questions SET subject='$subject', question='$qtext', option1='$option1',
                option2='$option2', option3='$option3', option4='$option4', answer='$answer' WHERE id='$id'";
        mysqli_query($connect,$update);
        $_SESSION['selected_subject'] = $subject;
        header("Location: questions_view.php?isSuccess=edit");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<div class="container">
    <h2>Edit Question</h2>
    <form method="POST">
        <label>Subject:</label>
        <select name="subject" required>
            <option value="cs" <?php echo get_selection($selected_subject, "cs") ?>>Computer Science</option>
            <option value="math" <?php echo get_selection($selected_subject, "math") ?>>Mathematics</option>
            <option value="gk" <?php echo get_selection($selected_subject, "gk") ?>>General Knowledge</option>
        </select><br><br>
        <label>Question:</label>
        <input type="text" name="question" value="<?php echo $question['question']?>" required><br><br>
        <label>Option 1:</label>
        <input type="text" name="option1" value="<?php echo $question['option1']?>" required><br><br>
        <label>Option 2:</label>
        <input type="text" name="option2" value="<?php echo $question['option2']?>" required><br><br>
        <label>Option 3:</label>
        <input type="text" name="option3" value="<?php echo $question['option3']?>" required><br><br>
        <label>Option 4:</label>
        <input type="text" name="option4" value="<?php echo $question['option4']?>" required><br><br>
        <label>Correct Answer (1-4):</label>
        <input type="number" name="answer" min="1" max="4" value="<?= $question['answer'] ?>" required><br><br>
        <button type="submit" class="btn">Update Question</button>
    </form>
    <br>
    <a href="dashboard.php"><button class="btn btn-delete">Back to Dashboard</button></a>
</div>
</body>
</html>
