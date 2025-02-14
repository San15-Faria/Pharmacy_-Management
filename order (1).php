<?php
include 'connect.php';

// Handle adding an order
if (isset($_POST['add_order'])) {
    $patient_name = $_POST['patient_name'];
    $patient_email = $_POST['patient_email'];
    $patient_phone = $_POST['patient_phone'];
    $patient_age = $_POST['patient_age'];
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];

    // Get the price of the selected medicine
    $stmt = $conn->prepare("SELECT price FROM medicines WHERE id = :medicine_id");
    $stmt->bindParam(':medicine_id', $medicine_id);
    $stmt->execute();
    $medicine = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_price = $medicine['price'] * $quantity;

    // Insert order into orders table
    $stmt = $conn->prepare("INSERT INTO orders (patient_name, patient_email, patient_phone,patient_age, medicine_id, quantity, total_price) VALUES (:patient_name, :patient_email, :patient_phone,:patient_age, :medicine_id, :quantity, :total_price)");
    $stmt->bindParam(':patient_name', $patient_name);
    $stmt->bindParam(':patient_email', $patient_email);
    $stmt->bindParam(':patient_phone', $patient_phone);
    $stmt->bindParam(':patient_age', $patient_age);
    $stmt->bindParam(':medicine_id', $medicine_id);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':total_price', $total_price);
    $stmt->execute();
}

// Handle deleting an order
if (isset($_GET['delete_order'])) {
    $order_id = $_GET['delete_order'];

    // Delete the order from the database
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = :order_id");
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
}

// Fetch all orders to display
$stmt = $conn->prepare("SELECT o.id, o.patient_name, o.patient_age, o.patient_phone, m.name AS medicine_name, o.quantity, o.total_price, o.order_date FROM orders o INNER JOIN medicines m ON o.medicine_id = m.id");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
