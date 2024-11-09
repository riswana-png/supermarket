<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - SUPERMARKET MANAGEMENT SYSTEM</title>
    <link rel="stylesheet" href="feedback.css">

</head>
<body>
    <header>
        <nav>
            <div class="container">
                <h1>Supermarket Management System</h1>
                <ul>
                    <li><a href="./Userdash.php">Home</a></li>
                    <li><a href="./about.html">About</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section class="feedback-section">
            <div class="container">
                <h2>We Value Your Feedback</h2>
                <p>Please let us know how we can improve our marketing services. Your feedback is important to us!</p>
                <form action="" method="post">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                    
                    <button type="submit" name="submit">Submit Feedback</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>|------------THANK YOU------------| </p>
        </div>
    </footer>
</body>
</html>
<?php
$conn = mysqli_connect("localhost", "root", "", "supermarket_management_system");
if (!$conn) {
    die("Database connection failed:");
}


if (isset($_POST['submit'])) {
            $username = $_POST['name'];
             $email = $_POST['email'];
            $msg=$_POST['message'];
            
        
            $sql ="INSERT INTO feedback(username, email, messages) VALUES ('$username','$email','$msg')";
            echo"$sql";
            $data = mysqli_query($conn, $sql);
        
            if ($data) {
                echo "<script>alert('One feedback is inserted');</script>";
                // header('Location: index.html');
                exit();
            } else {
                echo "<script>alert('No feedback is inserted');</script>";
            }
        }
        
        // mysqli_close($con);
        ?>
