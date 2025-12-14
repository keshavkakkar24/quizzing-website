<?php
    session_start();
    include "../config.php";

    if(isset($_SESSION['admin'])){
        header("Location: dashboard.php");
        exit();
    }

    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        if ($error == 'invalidCreds')
            echo "<script>alert(\"Invalid username or password, try again\")</script>";
        else
            echo "<script>alert(\"Error occured, try again\")</script>";
    }

    $error = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        $res = mysqli_query($connect, $query);

        if ($res)
        {
            if(mysqli_num_rows($res) == 1)
            {
                $_SESSION['admin'] = $username;
                header("Location: dashboard.php");
                exit();
            }
            else 
            {
                header("Location: login.php?error=" . "invalidCreds");
                exit();
            }
        }
        else
        {
            header("Location: login.php?error=" . "otherError");
            exit();
        }
    }
?>

<html>
    <head>
        <title>Admin page</title>
        <link rel="stylesheet" href="admin_style.css">
    </head>
    <body>
        <div class="container">
            <h2>Admin Login</h2>
            <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
            <form method="POST">
                <label>Username:</label>
                <input type="text" name="username" required><br><br>
                <label>Password:</label>
                <input type="password" name="password" required><br><br>
                <button type="submit" class="btn">Login</button>
            </form>
            <br>
            <!-- Back to home button -->
            <a href="../index.html"><button class="btn btn-delete">Back to Home</button></a>
        </div>
    </body>
</html>
