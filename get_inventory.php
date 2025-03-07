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

$type = $_GET['type'];
if ($type === 'computer_lab') {
    $table = 'computer_lab_inventory';
} elseif ($type === 'store') {
    $table = 'store_inventory';
} else {
    echo json_encode(['error' => 'Invalid inventory type.']);
    exit;
}

// Fetch data from the correct table
$query = "SELECT item_name, quantity, last_updated FROM $table ORDER BY last_updated DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the data as JSON
echo json_encode($result);
?>
