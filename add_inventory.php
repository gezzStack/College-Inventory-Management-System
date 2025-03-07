<?php
// Database connection
$host = 'localhost';
$db = 'college_inventory';
$user = 'postgres';
$pass = 'DBMS';

$dsn = "pgsql:host=$host;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo 'Database connection failed: ' . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $quantity = (int)$_POST['quantity'];
    $type = $_POST['type'];

    if ($type === 'computer_lab') {
        $table = 'computer_lab_inventory';
    } elseif ($type === 'store') {
        $table = 'store_inventory';
    } else {
        echo "Invalid inventory type.";
        exit;
    }

    // Insert data into the correct table
    $query = "INSERT INTO $table (item_name, quantity) VALUES (:item_name, :quantity)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':item_name', $item_name);
    $stmt->bindParam(':quantity', $quantity);

    if ($stmt->execute()) {
        echo "Item added successfully!";
    } else {
        echo "Failed to add item.";
    }
}
?>
