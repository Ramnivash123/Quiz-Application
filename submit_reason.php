<?php
include 'db.php'; // Include your database connection

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if 'reason' is set
        if (isset($_POST['reason']) && !empty($_POST['reason'])) {
            $reason = $_POST['reason'];

            // Insert the reason into the database
            $sql = "INSERT INTO reasons (reason) VALUES (:reason)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':reason', $reason);
            $stmt->execute();

            // Debugging logs (optional - remove in production)
            echo "Reason successfully submitted: " . $reason;

            // Redirect to student.php
            header("Location: student.php");
            exit();
        } else {
            echo "No reason was selected.";
        }
    } else {
        echo "Invalid request method.";
    }
} catch (PDOException $e) {
    // Display error if something goes wrong
    echo "Error: " . $e->getMessage();
}
?>
