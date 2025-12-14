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

    $selected_subject = '';

    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        if (isset($_SESSION['selected_subject']))
        {
            echo "<script>console.log('Selected subject: $selected_subject');</script>";
            $selected_subject = $_SESSION['selected_subject'];
            unset($_SESSION['selected_subject']);
        }
        if (isset($_GET['isSuccess']))
        {
            $successCode = $_GET['isSuccess'];
            if ($successCode == "add")
                echo "<script>alert(\"Added new question successfully\")</script>";
            if ($successCode == "delete")
                echo "<script>alert(\"Deleted question successfully\")</script>";
            if ($successCode == "edit")
                echo "<script>alert(\"Edited question successfully\")</script>";
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (isset($_POST['subject']) && !empty($_POST['subject'])) {
            $selected_subject = $_POST['subject']; // store selected subject
        }
    }

    function getQuestionsBySubject($connect, $subject) {
        $query = "SELECT * FROM questions WHERE subject='$subject'";
        $result = mysqli_query($connect, $query);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function get_selection($selected_subject, $sub)
    {
        if ($selected_subject == $sub) return ' selected';
        else return '';
    }

?>

<html>
    <head>
        <title>Question View</title>
        <link rel="stylesheet" href="admin_style.css">
    </head>

    <body>
    <div class="container">
        <h2>Questions Dashboard</h2>
        <p><a class="btn-logout" href="logout.php">Logout</a></p>
        <p><a class="btn-logout" href="dashboard.php">Back</a></p>

        <div class="menu">
            <a class="btn-action" href="add_question.php">Add New Question</a>
        </div>

        <form method="POST" action="">
            <label>Select subject:</label>
            <select name="subject" onchange="this.form.submit()">
                <option value="">--No selection--</option>
                <?php $attribute = get_selection($selected_subject, "cs") ?>
                <option value="cs" <?php echo $attribute ?>>Computer Science</option>
                <?php $attribute = get_selection($selected_subject, "math") ?>
                <option value="math" <?php echo $attribute ?>>Mathematics</option>
                <?php $attribute = get_selection($selected_subject, "gk") ?>
                <option value="gk" <?php echo $attribute ?>>General Knowledge</option>
            </select>
        </form>
        <br><br>

        <?php if ($selected_subject) ?>
            <h3>Questions:</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Options</th>
                    <th>Answer</th>
                    <th>Actions</th>
                </tr>
                <?php $allQues = getQuestionsBySubject($connect, $selected_subject)?>
                <?php foreach ($allQues as $index => $q) { ?>
                <tr>
                    <td><?php echo $index+1 ?></td>
                    <td><?php echo $q['question'] ?></td>
                    <td>
                        1. <?php echo $q['option1']?><br>
                        2. <?php echo $q['option2'] ?><br>
                        3. <?php echo $q['option3'] ?><br>
                        4. <?php echo $q['option4']?>
                    </td>
                    <td><?php echo $q['answer'] ?></td>
                    <td>
                        <a class="btn-action" href="edit_question.php?id=<?= $q['id'] ?>">Edit</a>
                        <a class="btn-delete" href="delete_question.php?id=<?php echo $q['id'] ?>&sub=<?php echo $selected_subject ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
    </div>
    </body>
</html>