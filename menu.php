<?php
$server = "localhost";
$username = "root";
$password = "Simar@2005";
$dbname = "restaurant";

$con = mysqli_connect($server, $username, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM menu";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .menu-item { border: 1px solid #ccc; margin: 10px 0; padding: 15px; border-radius: 10px; }
        .menu-item img { max-width: 150px; }
    </style>
</head>
<body>
    <h1>Restaurant Menu</h1>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="menu-item">
            <h2><?= htmlspecialchars($row['name']) ?> - ₹<?= number_format($row['price'], 2) ?></h2>
            <p><?= htmlspecialchars($row['description']) ?></p>
            <p><strong>Category:</strong> <?= htmlspecialchars($row['category']) ?></p>
            <?php if (!empty($row['image'])): ?>
                <img src="<?= htmlspecialchars($row['image']) ?>" alt="Menu Image">
            <?php endif; ?>
        </div>
    <?php } ?>

</body>
</html>
