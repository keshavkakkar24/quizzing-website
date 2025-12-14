<?php
    session_start();
    include "../config.php";

    header("Cache-Control: no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

    if(!isset($_SESSION['admin'])){
        header("Location: login.php");
        die();
    }

    $results_query = "SELECT * FROM results ORDER BY id DESC";
    $results_res = mysqli_query($connect, $results_query);
    $results = mysqli_fetch_all($results_res, MYSQLI_ASSOC);

    function get_subject_name($sub)
    {
        if ($sub == 'cs') return "Computer Science";
        if ($sub == 'math') return 'Mathematics';
        if ($sub == 'gk') return "General Knowledge";

        return $sub;
    }
?>

<html>
    <head>
        <title>Results View</title>
        <link rel="stylesheet" href="admin_style.css">
    </head>

    <body>
    <div class="container">
        <h2>Results Dashboard</h2>
        <p><a class="btn-logout" href="logout.php">Logout</a></p>
        <p><a class="btn-logout" href="dashboard.php">Back</a></p>
        <h3>Student Quiz Results</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Roll No</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Score</th>
            </tr>
            <?php foreach ($results as $index => $row) { ?>
            <tr>
                <td><?php echo $index+1 ?></td>
                <td><?php echo $row['roll_no'] ?></td>
                <td><?php echo $row['student_name'] ?></td>
                <td><?php echo get_subject_name($row['subject']) ?></td>
                <td><?php echo $row['score'] ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>


