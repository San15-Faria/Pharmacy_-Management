<?php
include 'order.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="medicines.css">
    <title>Medicines - Pharmacy Management</title>
</head>

<style>
    /* General Body and Layout Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to bottom, white, #2d6a4f);
    color: #333;
}

header {
    background-color: #2f7b59;
    color: white;
    padding: 15px;
    text-align: center;
}

header .logo {
    font-size: 24px;
    font-weight: bold;
}

main {
    padding: 20px;
    margin: 0 auto;
    max-width: 1200px;
    background-color: white;
}

h2 {
    text-align: center;
    font-size: 30px;
    margin-bottom: 20px;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 600px;
    margin: 0 auto;
}

form label {
    font-size: 16px;
    font-weight: bold;
}

form input,
form select,
form button {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

form button {
    background-color: #2f7b58;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #3c9f72;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

table th,
table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #2f7b58;
    color: white;
    font-size: 18px;
}

table td {
    background-color: #fafafa;
}

table tr:nth-child(even) td {
    background-color: #f2f2f2;
}

table td a {
    color: #3c9f72;
    text-decoration: none;
    font-weight: bold;
}

table td a:hover {
    color: #c0392b;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    body {
        padding: 10px;
    }

    h2 {
        font-size: 26px;
    }

    form {
        max-width: 100%;
    }

    table {
        font-size: 14px;
    }

    table th, table td {
        padding: 10px;
    }
}

@media screen and (max-width: 480px) {
    table {
        font-size: 12px;
    }

    form label,
    form input,
    form select,
    form button {
        font-size: 14px;
    }
}

/* Additional Styling */
footer {
    background-color: #2c3e50;
    color: white;
    text-align: center;
    padding: 15px;
    position: fixed;
    bottom: 0;
    width: 100%;
}

footer a {
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    font-size: 16px;
}

footer a:hover {
    background-color: #2980b9;
    border-radius: 5px;
}

</style>

<body>
    <header>
        <nav>
            <label class="logo">Pharmacy Management</label>
        </nav>
    </header>

    <main>
        <h2>Place Your Order</h2>

        <!-- Add new order form -->
        <form action="purchase.php" method="POST">
            <label for="patient_name">Patient Name:</label>
            <input type="text" name="patient_name" required>

            <label for="patient_email">Patient Email:</label>
            <input type="email" name="patient_email">

            <label for="patient_phone">Patient Phone:</label>
            <input type="text" name="patient_phone">

            <!-- Add Age field -->
            <label for="patient_age">Patient Age:</label>
            <input type="number" name="patient_age" required>

            <!-- Add Gender field -->
            <label for="patient_gender">Patient Gender:</label>
            <select name="patient_gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="medicine_id">Medicine:</label>
            <select name="medicine_id" required>
                <?php
                // Get the medicine_id from the query parameters
                $selected_medicine_id = isset($_GET['medicine_id']) ? $_GET['medicine_id'] : null;

                if ($selected_medicine_id) {
                    // Fetch the selected medicine from the database based on the medicine_id
                    $stmt = $conn->prepare("SELECT * FROM medicines WHERE id = :id");
                    $stmt->bindParam(':id', $selected_medicine_id);
                    $stmt->execute();
                    $medicine = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($medicine) {
                        // Display the selected medicine in the dropdown
                        echo "<option value='" . $medicine['id'] . "' selected>" . $medicine['name'] . " - Rs. " . $medicine['price'] . "</option>";
                    } else {
                        echo "<option value='' disabled>No medicine found</option>";
                    }
                } else {
                    // If no medicine_id is set, display a placeholder option
                    echo "<option value='' disabled>Please select a medicine</option>";
                }
                ?>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" value="1" required>

            <button type="submit" name="add_order">Add Order</button>
        </form>

        <!-- Back to Medicines button -->
        <div style="text-align: center; margin-top: 20px;">
            <a href="medicines.php">
                <button type="button" style="padding: 10px 20px; font-size: 16px; background-color: #2f7b58; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Back to Medicines
                </button>
            </a>
        </div>

        <!-- Display orders -->
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Patient Age</th>
                    <th>Patient Phone</th>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['patient_age']); ?></td>
                        <td><?php echo htmlspecialchars($order['patient_phone']); ?></td>
                        <td><?php echo htmlspecialchars($order['medicine_name']); ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td>Rs. <?php echo number_format($order['total_price'], 2); ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                        <td><a href="purchase.php?delete_order=<?php echo $order['id']; ?>">Cancel Order</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
