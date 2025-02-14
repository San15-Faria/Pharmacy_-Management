<?php
header('Content-Type: application/json');

// Get the data sent from the client
$data = json_decode(file_get_contents('php://input'), true);

// Database credentials
$host = 'localhost';  // Database host
$username = 'root';   // Database username
$password = '';       // Database password
$database = 'DBMS'; // Database name

// Create database connection
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Prepare the insert query
$stmt = $conn->prepare("INSERT INTO orders (patient_name, patient_gender, patient_age, medicine_name, medicine_price, quantity, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    'ssissds',
    $data['patientName'],
    $data['patientGender'],
    $data['patientAge'],
    $data['medicineName'],
    $data['price'],
    $data['quantity'],
    $data['total']
);

// Execute the query and check for errors
if ($stmt->execute()) {
    echo json_encode(['success' => 'Order placed successfully!']);
} else {
    echo json_encode(['error' => 'Error: ' . $stmt->error]);
}

// Close the connection
$stmt->close();
$conn->close();
?>
