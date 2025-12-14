<?php
    include "config.php";

    $rno = $_POST['roll_no'];
    $name = $_POST['student_name'];
    $sub = $_POST['subject'];

    // get title
    $title = "";
    if ($sub == 'cs') $title = 'Computer Science';
    if ($sub == 'gk') $title = 'General Knowledge';
    if ($sub == 'math') $title = 'Mathematics';

    $query = "SELECT * FROM questions WHERE subject='$sub'";
    $result = mysqli_query($connect, $query);
    $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $total = count($questions);
    $score = 0;

    // Calculate score
    foreach ($questions as $q) {
        $qid = $q['id'];
        if ($_POST["q$qid"] == $q['answer']) {
            $score++;
        }
    }

    // Calculate percentage
    $percentage = ($total > 0) ? ($score / $total) * 100 : 0;

    // Store result
    $insert = "INSERT INTO results (roll_no, student_name, subject, score)
            VALUES ('$rno','$name','$sub','$score')";
    mysqli_query($connect, $insert);
    echo "<script>alert('Quiz saved successfully!')</script>";
?>

<html>
    <head>
        <title>Result page</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- display score -->
        <div class="container">
            <h1>Result - <?php echo $title ?></h1>
            <hr><br>
            <p><b>Roll Number:</b> <?php echo $rno ?></p>
            <p><b>Name:</b> <?php echo $name ?></p>
            <p><b>Score:</b> <?php echo $score ?> / <?php echo $total ?></p>
            <p><b>Percentage:</b> <?php echo $percentage ?>%</p>
            <br>
            <center>
                <a href="index.html"><button class="btn">Home page</button></a>
            </center>
        </div>
    </body>
</html>
