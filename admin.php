<?php
// Include the database connection
include('connect.php');

// Fetch medicines from the database
$sql = "SELECT * FROM medicines";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Fetch all results
$medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="med.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Admin - Manage Medicines</title>
</head>
<body>

    <!-- Header and Navigation -->
    <header>
        <nav>
            <label class="logo">Admin - Manage Medicines</label>
        </nav>
    </header>

    <!-- Admin Form to Add Medicine -->
    <main>
        <section class="admin-section">
            <h2>Add New Medicine</h2>
            <form action="add_medicine.php" method="POST">
                <label for="name">Medicine Name</label>
                <input type="text" id="name" name="medicine_name" required>

                <label for="description">Description</label>
                <textarea id="description" name="medicine_description" required></textarea>

                <label for="price">Price</label>
                <input type="number" step="0.01" id="price" name="medicine_price" required>

                <label for="category">Category</label>
                <select id="category" name="medicine_category" required>
                <option value="">Choose Medicine Category</option>
                    <option value="Pain Relievers">Pain Relievers</option>
                    <option value="Antibiotics">Antibiotics</option>
                    <option value="Vitamins">Vitamins</option>
                    <option value="Cold & Flu">Cold & Flu</option>
                </select>

                <button type="submit" class="submit-btn">Add Medicine</button>
            </form>
        </section>
    </main>
 
    <!-- Medicines Section in Table Format -->
    <main>
        <section class="category-section">
            <h2>Manage Medicines</h2>

            <?php
            if (count($medicines) > 0) {
                echo '<table class="medicine-table">';
                echo '<thead>
                        <tr>
                            <th>Medicine Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>';
                echo '<tbody>';

                // Loop through each medicine and display it in a row
                foreach ($medicines as $medicine) {
                    echo '
                    <tr>
                        <td>' . htmlspecialchars($medicine['name']) . '</td>
                        <td>' . htmlspecialchars($medicine['description']) . '</td>
                        <td>Rs.' . number_format($medicine['price'], 2) . '</td>
                        <td>' . htmlspecialchars($medicine['category']) . '</td>
                        <td>
                            <a href="update_medicine.php?id=' . $medicine['id'] . '" class="edit-btn">Update</a>
                            <a href="delete_medicine.php?id=' . $medicine['id'] . '" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this medicine?\')">Delete</a>
                        </td>
                    </tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo "<p>No medicines available.</p>";
            }
            ?>

        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <div class="footer-content">
            <ul class="footer-links">
                <li><a href="index.html">Back To Home</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>
