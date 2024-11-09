<?php
include 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Admindash.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="Addstaff.css">
    <title>Index</title>
</head>
<body>
    <section class="Main">
        <form class="Logincontainer" action="" method="post">
            <h1>ADD STAFF</h1>
            
            <input class="Logininput1" type="text" placeholder="Name" name="name" required>
            <input class="Logininput1" type="email" placeholder="Email" name="email" required>
            <input class="Logininput1" type="number" placeholder="Phone Number" name="phnum" required>
            <input class="Logininput1" type="password" placeholder="Password" name="pass" required>
            <input class="Logininput1" type="text" placeholder="Position" name="position" required><br>
            <input class="Logininput1" type="date" placeholder="Hire Date" name="hire_date" required><br>

            <input class="Logininput2" type="submit" value="ADD" name="submit">
        </form>
    </section>
</body>
</html>

<?php
$conn = mysqli_connect("localhost", "root", "", "supermarket_management_system");
if (!$conn) {
    echo "DB connection failed";
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phnum = $_POST['phnum'];
    $pass = $_POST['pass'];
    $position = $_POST['position'];
    $hire_date = $_POST['hire_date'];
    $type = 1;

    $email_check_sql = "SELECT * FROM `login` WHERE `email` = '$email'";
    $email_check_result = mysqli_query($conn, $email_check_sql);

    if (mysqli_num_rows($email_check_result) > 0) {
        echo "<script>alert('Email already exists. Please choose another email.');</script>";
    } else {
        if (empty($name) || empty($phnum) || empty($position) || empty($hire_date)) {
            echo "<script>alert('All fields are required.');</script>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Please enter a valid email address.');</script>";
        } elseif (!preg_match("/^[0-9]{10}$/", $phnum)) {
            echo "<script>alert('Please enter a valid 10-digit phone number.');</script>";
        } else {
            $sql = "INSERT INTO `staff`(`name`, `email`, `phnum`, `pass`, `position`, `hire_date`) 
                    VALUES ('$name', '$email', '$phnum', '$pass', '$position', '$hire_date')";
            $data = mysqli_query($conn, $sql);

            $sql1 = "INSERT INTO `login`(`email`, `password`, `usertype`) VALUES ('$email', '$pass', '$type')";
            $data1 = mysqli_query($conn, $sql1);

            echo "$sql AND $sql1";

            if ($data && $data1) {
                echo "<script>alert('Staff added successfully.'); window.location.href='addstaff.php';</script>";
            } else {
                echo "<script>alert('Error in adding staff. Please try again.');</script>";
            }
        }
    }
}
?>
