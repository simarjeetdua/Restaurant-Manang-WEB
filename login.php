<?php
session_start();
ob_start(); // Prevent header error

$server = "localhost";
$username = "root";
$password = "Simar@2005";
$dbname = "restaurant";

$con = mysqli_connect($server, $username, $password, $dbname);

if (!$con) {
    die("❌ Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            // If it's an admin
            if ($user['is_admin'] == 1) {
                $_SESSION['admin'] = $user['name'];
                header("Location: admin.php");
                exit();
            } 
            // If it's a regular user
            else {
                $_SESSION['user'] = $user['name'];
                header("Location: booking.html");
                exit();
            }
        } else {
            echo "<script>alert('❌ Incorrect password'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('❌ User not found'); window.location.href='login.html';</script>";
    }
}
?>



