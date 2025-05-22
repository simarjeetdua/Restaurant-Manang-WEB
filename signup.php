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
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password

    $sql = "INSERT INTO user (name, email, password) VALUES ('$name', '$email', '$password')";

    if (mysqli_query($con, $sql)) {
        echo "Signup successful. <a href='login.html'>Login here</a>";
    } else {
        echo "Signup failed: " . mysqli_error($con);
    }
}
?>