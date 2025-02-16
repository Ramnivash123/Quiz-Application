<?php
// Start the session to access session variables
session_start();

// Check if the student name is set in the session
$student_name = $_SESSION['student_name'] ?? '';
if (empty($student_name)) {
    die("Student name is not set. Please log in.");
}

include 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form values
    $stu_name = $student_name; // Use the student name from the session
    $title = $_POST['assignment_title'];
    $subject = $_POST['subject'];

    // Initialize variables for tracking answers
    $correct = 0;
    $wrong = 0;
    $total_questions = count($_POST['option']);
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $time_difference = strtotime($end_time) - strtotime($start_time);

    // Loop through each question and check the answers
    foreach ($_POST['option'] as $question_id => $selected_option) {
        // Check the selected option against the correct answer stored in the database
        $sql = "SELECT answer FROM assignments WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $question_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Trim both the selected option and correct answer to avoid whitespace issues
        $selected_option = trim($selected_option);
        $correct_answer = trim($row['answer']);

        // Check if the selected option matches the correct answer
        if ($selected_option === $correct_answer) {
            $correct++;
        } else {
            $wrong++;
        }
    }

    // Calculate the marks as a percentage
    $percentage = ($correct / $total_questions) * 100;

    // Prepare the SQL statement for insertion or update
    $sql = "INSERT INTO marks (stu_name, title, correct, wrong, marks, start_time, end_time, time_difference, status)
            VALUES (:stu_name, :title, :correct, :wrong, :marks, :start_time, :end_time, :time_difference, 'completed')
            ON DUPLICATE KEY UPDATE correct = :correct, wrong = :wrong, marks = :marks,
            start_time = :start_time, end_time = :end_time, time_difference = :time_difference, status = 'completed'";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':stu_name', $stu_name);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':correct', $correct, PDO::PARAM_INT);
    $stmt->bindParam(':wrong', $wrong, PDO::PARAM_INT);
    $stmt->bindParam(':marks', $percentage, PDO::PARAM_STR); // Insert percentage as marks
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':time_difference', $time_difference, PDO::PARAM_INT);

    // Execute the query
    if ($stmt->execute()) {
        header("Location: student.php");
        exit();

    } else {
        echo "Error occurred while submitting the data.";
    }
}
?>
