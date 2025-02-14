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
    <link rel="stylesheet" href="medicines.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Medicines - Pharmacy Management</title>
</head>
<body>

    <!-- Header and Navigation -->
    <header>
        <nav>
            <label class="logo">Pharmacy Management</label>
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a class="active" href="medicines.php">Medicines</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Medicines Section -->
    <main>
        <section class="category-section">
            <h2>Available Medicines</h2>

            <?php
            if (count($medicines) > 0) {
                echo '
                <table class="medicine-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';

                // Loop through each medicine and display it in table rows
                foreach ($medicines as $medicine) {
                    echo '
                    <tr>
                        <td>' . htmlspecialchars($medicine['name']) . '</td>
                        <td>' . htmlspecialchars($medicine['description']) . '</td>
                        <td>Rs.' . number_format($medicine['price'], 2) . '</td>
                        <td>' . htmlspecialchars($medicine['category']) . '</td>
                        <td>
                            <a href="purchase.php?medicine_id=' . $medicine['id'] . '&medicine_name=' . urlencode($medicine['name']) . '&price=' . $medicine['price'] . '" class="buy-btn">Buy Now</a>
                        </td>
                    </tr>';
                }

                echo '</tbody></table>';
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

<?php
// No need to explicitly close the PDO connection in PHP
?>
