<?php
$server = "localhost";
$username = "root";
$password = "Simar@2005";
$dbname = "restaurant";

$con = mysqli_connect($server, $username, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (name, email, password, is_admin) VALUES ('$name', '$email', '$hashed_password', 0)";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Signup successful! Please login.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "'); window.location.href='signup.html';</script>";
    }
} else {
    header("Location: signup.html");
    exit();
}
?>
