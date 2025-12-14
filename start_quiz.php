<?php
    include "config.php";

    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        if ($error == 'quiz_done')
            echo "<script>alert('You have already attempted this quiz!');</script>";

        if ($error == 'invalid_name')
            echo "<script>alert('Inconsistent name found in results');</script>";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rno = trim($_POST['roll_no']);
        $sname = trim($_POST['student_name']);
        $sub = trim($_POST['subject']);

        $check = "SELECT * FROM results WHERE LOWER(roll_no)=LOWER('$rno') AND LOWER(subject)=LOWER('$sub')";
        $result = mysqli_query($connect, $check);

        if (mysqli_num_rows($result) > 0) {
            $existing_name = mysqli_fetch_array($result, MYSQLI_ASSOC)['student_name'];
            $error = "quiz_done";
            if ($existing_name != $sname)
            {
                $error = 'invalid_name';
            }
            header("Location: start_quiz.php?error=" . urlencode($error));
            //header("Location: start_quiz.php");
            exit();
        } else {
            header("Location: quiz.php?roll_no=" . urlencode($rno) . "&student_name=" . urlencode($sname) . "&subject=" . urlencode($sub));
            exit();
        }
    }
?>

<html>
<head>
    <title>quiz page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Enter your details</h2>
    <form method="POST">
        <label>Roll Number:</label>
        <input type="text" name="roll_no" required><br><br>

        <label>Name:</label>
        <input type="text" name="student_name" required><br><br>

        <label>Subject:</label>
        <select name="subject" required>
            <option value="cs">Computer Science</option>
            <option value="math">Mathematics</option>
            <option value="gk">General Knowledge</option>
        </select><br><br>

        <button type="submit" class="btn">Start Quiz</button>
    </form>
</div>
</body>
</html>
