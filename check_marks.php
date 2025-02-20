<?php
session_start();

include 'db.php';

// Retrieve student name from session
$student_name = $_SESSION['student_name'] ?? '';

// Fetch data from marks table for the specific student and join with assignments table
$sql = "
    SELECT a.qn, a.question, a.opt1, a.opt2, a.opt3, a.opt4, a.answer
    FROM marks m
    JOIN assignments a ON m.title = a.title
    WHERE m.stu_name = ?
";
$stmt = $conn->prepare($sql);
$stmt->execute([$student_name]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="h5 text-primary border-bottom pb-2 mb-3">Marks Details</h3>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>QN</th>
                                <th>Question</th>
                                <th>Option 1</th>
                                <th>Option 2</th>
                                <th>Option 3</th>
                                <th>Option 4</th>
                                <th>Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['qn']) ?></td>
                                    <td><strong><?= htmlspecialchars($row['question']) ?></strong></td>
                                    <td><?= htmlspecialchars($row['opt1']) ?></td>
                                    <td><?= htmlspecialchars($row['opt2']) ?></td>
                                    <td><?= htmlspecialchars($row['opt3']) ?></td>
                                    <td><?= htmlspecialchars($row['opt4']) ?></td>
                                    <td><span class="text-success"><?= htmlspecialchars($row['answer']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close statement and connection
$stmt = null;
$conn = null;
?>
