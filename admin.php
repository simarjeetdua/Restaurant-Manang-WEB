<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

$server = "localhost";
$username = "root";
$password = "Simar@2005";
$dbname = "restaurant";

$con = mysqli_connect($server, $username, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// DELETE booking
if (isset($_GET['delete_booking'])) {
    $id = intval($_GET['delete_booking']);
    mysqli_query($con, "DELETE FROM bookings WHERE ID = $id");
}

// DELETE user
if (isset($_GET['delete_user'])) {
    $id = intval($_GET['delete_user']);
    mysqli_query($con, "DELETE FROM user WHERE id = $id");
}

// ADD new user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_user'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $plain_password = $_POST['password'];
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    mysqli_query($con, "INSERT INTO user (name, email, password, is_admin) VALUES ('$name', '$email', '$hashed_password', $is_admin)");
}

// SEARCH
$search_query = "";
if (isset($_GET['search'])) {
    $term = mysqli_real_escape_string($con, $_GET['search']);
    $search_query = "WHERE name LIKE '%$term%' OR checkin LIKE '%$term%'";
}

$bookings = mysqli_query($con, "SELECT * FROM bookings $search_query ORDER BY checkin DESC");
$users = mysqli_query($con, "SELECT * FROM user ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Restaurant</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f7f7f7; }
        h2 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; background: #fff; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        form { margin-bottom: 30px; }
        input, button { padding: 8px; margin: 5px 0; }
        .logout { float: right; margin-top: -50px; }
    </style>
</head>
<body>
    <h2>Welcome, Admin</h2>
    <div class="logout">
        <a href="logout.php"><button>Logout</button></a>
    </div>

    <!-- Search -->
    <form method="GET">
        <input type="text" name="search" placeholder="Search by name or date">
        <button type="submit">Search</button>
    </form>

    <!-- Bookings Table -->
    <h3>📋 Bookings</h3>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Phone</th>
            <th>Check-in</th><th>Time</th><th>Guests</th><th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($bookings)): ?>
            <tr>
                <td><?= $row['ID'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['checkin'] ?></td>
                <td><?= $row['checkin_time'] ?></td>
                <td><?= $row['guests'] ?></td>
                <td>
                    <a href="?delete_booking=<?= $row['ID'] ?>" onclick="return confirm('Delete this booking?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Users Table -->
    <h3>👥 Users</h3>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Admin?</th><th>Action</th>
        </tr>
        <?php while($u = mysqli_fetch_assoc($users)): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= $u['name'] ?></td>
                <td><?= $u['email'] ?></td>
                <td><?= $u['is_admin'] ? "Yes" : "No" ?></td>
                <td>
                    <a href="?delete_user=<?= $u['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Add New User -->
    <h3>➕ Add User</h3>
    <form method="POST">
        <input type="hidden" name="new_user" value="1">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <label><input type="checkbox" name="is_admin"> Is Admin</label><br>
        <button type="submit">Add User</button>
    </form>
    <p>all done</p>
</body>
</html>


