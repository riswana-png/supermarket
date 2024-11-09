<?php
$conn = mysqli_connect("localhost", "root", "", "supermarket_management_system");
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phnum = $_POST['phnum'];
    $pass = $_POST['pass'];
    $cnfpass = $_POST['cnfpass'];
    $type = 0;

    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    } else {
        $email_check = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $email_check);
        if (mysqli_num_rows($result) > 0) {
            $errors[] = "Email already exists.";
        }
    }

    if (empty($phnum) || !preg_match('/^[6789]\d{9}$/', $phnum)) {
        $errors[] = "Phone number must be a valid 10-digit Indian number starting with 7, 8, or 9.";
    }

    if (empty($pass) || strlen($pass) < 8 || !preg_match('/[A-Z]/', $pass) || !preg_match('/[a-z]/', $pass) || !preg_match('/[\W_]/', $pass)) {
        $errors[] = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one special character.";
    }

    if ($pass !== $cnfpass) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO `users`(`name`, `email`, `phonenum`, `password`) VALUES ('$name','$email','$phnum','$pass')";
        $data = mysqli_query($conn, $sql);

        $sql1 = "INSERT INTO `login`(`email`, `password`, `usertype`) VALUES ('$email','$pass','$type')";
        $data1 = mysqli_query($conn, $sql1);

        if ($data && $data1) {
            echo "<script>
                alert('Registration Successful');
                window.location.href = 'Login.php';  // Redirect to Login page
            </script>";
            exit();
        } else {
            echo "<script>alert('Registration Failed');</script>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Login.css">
    <title>Login</title>
</head>
<body>
    <nav class="navbar">
        <h1>Super Market Management Sysytem </h1>
        <div class="Nav_menus">
            <!-- <div class="menus">Home</div>
            <div class="menus">Login</div> -->
            <a href="index.html"><div class="menus">Home</div></a>
            <a href="Login.php"><div class="menus">Login</div></a>
        </div>
    </nav>
    <section class="Home_Section">
            <form class="Logincontainer" action="" method="post">
                <h1>Register</h1>
                
                <input class="Logininput1" type="text" placeholder="Name" name="name">
                <input class="Logininput1" type="email" placeholder="Email" name="email">
                <input class="Logininput1" type="number" placeholder="Phone Number" name="phnum">
                <input class="Logininput1" type="password" placeholder="Password" name="pass">
                <input class="Logininput1" type="password" placeholder="Confirm Password" name="cnfpass">
                <input class="Logininput2" type="submit" value="Register" name="submit">
            </form>
    </section>
</body>
</html>
