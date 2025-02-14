<?php
// Include the database connection
include('connect.php');

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $medicine_id = $_GET['id'];

    // Fetch the existing details of the medicine
    $stmt = $conn->prepare("SELECT * FROM medicines WHERE id = :id");
    $stmt->bindParam(':id', $medicine_id, PDO::PARAM_INT);
    $stmt->execute();
    $medicine = $stmt->fetch(PDO::FETCH_ASSOC);

    // If medicine doesn't exist
    if (!$medicine) {
        echo "Medicine not found!";
        exit;
    }
}

// Check if the form is submitted for updating
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicine_name = $_POST['medicine_name'];
    $medicine_description = $_POST['medicine_description'];
    $medicine_price = $_POST['medicine_price'];
    $medicine_category = $_POST['medicine_category'];

    // Prepare the SQL query to update the medicine
    $stmt = $conn->prepare("UPDATE medicines SET name = :name, description = :description, price = :price, category = :category WHERE id = :id");
    $stmt->bindParam(':name', $medicine_name);
    $stmt->bindParam(':description', $medicine_description);
    $stmt->bindParam(':price', $medicine_price);
    $stmt->bindParam(':category', $medicine_category);
    $stmt->bindParam(':id', $medicine_id, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Medicine updated successfully!";
        header("Location: admin.php");
        exit;
    } else {
        echo "Error updating medicine.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medicine</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, white, #2d6a4f);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
            color: #333;
        }

        input[type="number"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #173829;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4db687;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group select,
        .form-group textarea {
            height: auto;
            resize: vertical;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Update Medicine</h2>
        <form action="update_medicine.php?id=<?php echo $medicine['id']; ?>" method="post">
            <div class="form-group">
                <label for="medicine_name">Medicine Name:</label>
                <input type="text" id="medicine_name" name="medicine_name" value="<?php echo htmlspecialchars($medicine['name']); ?>" required><br>
            </div>

            <div class="form-group">
                <label for="medicine_description">Description:</label>
                <textarea id="medicine_description" name="medicine_description" required><?php echo htmlspecialchars($medicine['description']); ?></textarea><br>
            </div>

            <div class="form-group">
                <label for="medicine_price">Price:</label>
                <input type="number" step="0.01" id="medicine_price" name="medicine_price" value="<?php echo $medicine['price']; ?>" required><br>
            </div>

            <div class="form-group">
                <label for="medicine_category">Category:</label>
                <select id="medicine_category" name="medicine_category" required>
                    <option value="Pain Relievers" <?php echo ($medicine['category'] == 'Pain Relievers') ? 'selected' : ''; ?>>Pain Relievers</option>
                    <option value="Antibiotics" <?php echo ($medicine['category'] == 'Antibiotics') ? 'selected' : ''; ?>>Antibiotics</option>
                    <option value="Vitamins" <?php echo ($medicine['category'] == 'Vitamins') ? 'selected' : ''; ?>>Vitamins</option>
                    <option value="Cold & Flu" <?php echo ($medicine['category'] == 'Cold & Flu') ? 'selected' : ''; ?>>Cold & Flu</option>
                </select><br>
            </div>

            <button type="submit">Update Medicine</button>
        </form>
    </div>

</body>
</html>
