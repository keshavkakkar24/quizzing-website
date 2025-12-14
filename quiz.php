<?php
    include "config.php";

    $rno = $_GET['roll_no'] ?? '';
    $sname = $_GET['student_name'] ?? '';
    $sub = $_GET['subject'] ?? '';

    $query = "SELECT * FROM questions WHERE subject='$sub'";
    $result = mysqli_query($connect, $query);
    $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Get page title based on subject
    $title = "";
    if ($sub == 'cs') $title = 'Computer Science';
    if ($sub == 'gk') $title = 'General Knowledge';
    if ($sub == 'math') $title = 'Mathematics';

?>

<html>
    <head>
        <title>Quiz</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h2><?php echo $title ?> Quiz</h2>

            <!-- Timer element -->
            <div id="timer" class="timer"></div>

            <form id="quizForm" action="result.php" method="POST">

                <div class="student-info">
                    <label>Roll Number:</label>
                    <input type="text" name="roll_no" value="<?php echo htmlspecialchars($rno) ?>" readonly>
                    <label>Name:</label>
                    <input type="text" name="student_name" value="<?php echo htmlspecialchars($sname) ?>" readonly>
                    <input type="hidden" name="subject" value="<?php echo htmlspecialchars($sub) ?>">
                </div>

                <!-- Show question list -->
                <?php foreach ($questions as $index => $q) { ?>
                <div class="question">
                    <p><?php echo ($index+1) . ". " . $q['question'] ?></p>
                    <input type="radio" name="q<?= $q['id'] ?>" value="1" required> <?php echo $q['option1'] ?><br>
                    <input type="radio" name="q<?= $q['id'] ?>" value="2"> <?php echo $q['option2'] ?><br>
                    <input type="radio" name="q<?= $q['id'] ?>" value="3"> <?php echo $q['option3'] ?><br>
                    <input type="radio" name="q<?= $q['id'] ?>" value="4"> <?php echo $q['option4'] ?><br>
                    <input type="hidden" name="ans<?= $q['id'] ?>" value="<?php echo $q['answer'] ?>">
                </div>
                <?php } ?>

                <button type="submit" class="btn">Submit</button>
            </form>

            <!-- script for timer -->
            <script>
                let time = 300; // 5 minutes
                function start_timer() {
                    const timer = document.getElementById("timer");
                    const countdown = setInterval(() => {
                        let minutes = Math.floor(time / 60);
                        let seconds = time % 60;
                        timer.innerHTML = `Timer: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                        time--;
                        if (time < 0) {
                            clearInterval(countdown);
                            alert("Submitting!");
                            document.getElementById("quizForm").submit();
                        }
                    }, 1000);
                }
                start_timer();
            </script>
        </div>
    </body>
</html>
