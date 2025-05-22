<?php
$server = "localhost";
$username = "root";
$password = "Simar@2005";
$dbname = "restaurant";

$con = mysqli_connect($server, $username, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['searchName'])) {
    $searchName = mysqli_real_escape_string($con, $_GET['searchName']);
    $sql = "SELECT ID, name , email , phone , checkin , checkin_time , guests FROM bookings WHERE name LIKE '%$searchName%'";
    $result = mysqli_query($con, $sql);

    echo "<h3>Search Results for '$searchName':</h3>";
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1' cellpadding='8'><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Check-in</th><th>checkin_time</th><th>Guests</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['checkin']}</td>
                    <td>{$row['checkin_time']}</td>
                    <td>{$row['guests']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "❌ No bookings found for that name.";
    }

    exit(); 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $ID = mysqli_real_escape_string($con, $_POST['ID']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $checkin = mysqli_real_escape_string($con, $_POST['checkin']);
    $checkin_time = mysqli_real_escape_string($con, $_POST['checkin_time']);
    $guests = mysqli_real_escape_string($con, $_POST['guests']);

    $sql = "INSERT INTO bookings ( name, email, phone, checkin, checkin_time, guests)
            VALUES ('$name', '$email', '$phone', '$checkin', '$checkin_time', '$guests')";

    if (mysqli_query($con, $sql)) {
        echo "<h3 style='color:green;'>✅ Booking submitted successfully!</h3>";
    } else {
        echo "<h3 style='color:red;'>❌ Error: " . mysqli_error($con) . "</h3>";
    }

    mysqli_close($con);
} else {
    echo "<h3 style='color:orange;'>⚠️ No data received.</h3>";
}
?>


