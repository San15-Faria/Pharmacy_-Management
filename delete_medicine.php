<?php
// Include the database connection
include('connect.php');

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $medicine_id = $_GET['id'];

    // Prepare the SQL query to delete the medicine
    $stmt = $conn->prepare("DELETE FROM medicines WHERE id = :id");
    $stmt->bindParam(':id', $medicine_id, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Medicine deleted successfully!";
        // Redirect after deletion
        header("Location: admin.php?deleted=true");
        exit;
    } else {
        echo "Error deleting medicine.";
    }
} else {
    echo "No medicine ID specified.";
}

?>
