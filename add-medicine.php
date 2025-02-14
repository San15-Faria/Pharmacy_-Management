<?php
// Include the database connection
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicine_name = $_POST['medicine_name'];
    $medicine_description = $_POST['medicine_description'];
    $medicine_price = $_POST['medicine_price'];
    $medicine_category = $_POST['medicine_category'];

    // Insert the new medicine into the database
    $stmt = $conn->prepare("INSERT INTO medicines (name, description, price, category) VALUES (:name, :description, :price, :category)");
    $stmt->bindParam(':name', $medicine_name);
    $stmt->bindParam(':description', $medicine_description);
    $stmt->bindParam(':price', $medicine_price);
    $stmt->bindParam(':category', $medicine_category);

    if ($stmt->execute()) {
        echo "Medicine added successfully!";
        header("Location: admin.php");
        exit;
    } else {
        echo "Error adding medicine.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine</title>
</head>
<body>

    <h2>Add Medicine</h2>
    <form action="add_medicine.php" method="post">
        <label for="medicine_name">Medicine Name:</label>
        <input type="text" id="medicine_name" name="medicine_name" required><br><br>

        <label for="medicine_description">Description:</label>
        <textarea id="medicine_description" name="medicine_description" required></textarea><br><br>

        <label for="medicine_price">Price:</label>
        <input type="number" step="0.01" id="medicine_price" name="medicine_price" required><br><br>

        <label for="medicine_category">Category:</label>
        <select id="medicine_category" name="medicine_category" required>
            <option value="Pain Relievers">Pain Relievers</option>
            <option value="Antibiotics">Antibiotics</option>
            <option value="Vitamins">Vitamins</option>
            <option value="Cold & Flu">Cold & Flu</option>
        </select><br><br>

        <button type="submit">Add Medicine</button>
    </form>

</body>
</html>
