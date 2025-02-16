<?php
session_start();
include 'db.php';

try {
    $sql = "SELECT id, title, timer, subject, c_date FROM exam";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $assignments = [];
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        foreach ($results as $row) {
            $assignments[$row["subject"]][] = $row;
        }
    } else {
        $noAssignments = true;
    }
} catch(PDOException $e) {
    die("Error executing query: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a class="text-2xl font-bold text-blue-600" href="#">
                    <i class="fas fa-graduation-cap mr-2"></i>ClassMate
                </a>
                <a href="studentt.php" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                    <i class="fas fa-user mr-2"></i>
                    <span>Profile</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Action Buttons -->
        <div class="flex gap-4 mb-6">
            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                Assignments
            </button>
            <a href="marks.php" class="border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-lg hover:bg-blue-50 transition-colors">
                View Score
            </a>
        </div>

        <!-- Assignments Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <?php
                if (isset($noAssignments)) {
                    echo '<p class="text-gray-500">No assignments found</p>';
                } else {
                    foreach ($assignments as $subject => $subjectAssignments) {
                        echo '<div class="mb-8 last:mb-0">';
                        echo '<h2 class="text-xl font-semibold text-blue-600 border-b border-gray-200 pb-3 mb-4">' . 
                             '<i class="fas fa-book mr-2"></i>' . htmlspecialchars($subject) . '</h2>';
                        echo '<div class="overflow-x-auto">';
                        echo '<table class="w-full min-w-full divide-y divide-gray-200">';
                        echo '<thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assignment</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned On</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                              </thead>';
                        echo '<tbody class="bg-white divide-y divide-gray-200">';
                        
                        foreach ($subjectAssignments as $assignment) {
                            $assignedOn = date("Y-m-d H:i:s", strtotime($assignment["c_date"]));
                            
                            try {
                                $checkSql = "SELECT status FROM marks WHERE title = :title AND stu_name = :student_name";
                                $checkStmt = $conn->prepare($checkSql);
                                $checkStmt->bindParam(':title', $assignment["title"], PDO::PARAM_STR);
                                $checkStmt->bindParam(':student_name', $_SESSION['student_name'], PDO::PARAM_STR);
                                $checkStmt->execute();
                                $submittedResult = $checkStmt->fetch(PDO::FETCH_ASSOC);
                                
                                $submitted = $submittedResult && $submittedResult['status'] == 'completed';

                                if (!$submitted) {
                                    echo '<tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <button onclick="viewAssignment(\'' . htmlspecialchars($assignment["title"]) . '\')"
                                                    class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                                ' . htmlspecialchars($assignment["title"]) . '
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 text-gray-700">
                                            <i class="far fa-clock mr-2"></i>' . htmlspecialchars($assignment["timer"]) . ' mins
                                        </td>
                                        <td class="px-6 py-4 text-gray-700">
                                            <i class="far fa-calendar-alt mr-2"></i>' . htmlspecialchars($assignedOn) . '
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        </td>
                                    </tr>';
                                } else {
                                    echo '<tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-gray-700">' . htmlspecialchars($assignment["title"]) . '</td>
                                        <td class="px-6 py-4 text-gray-700">
                                            <i class="far fa-clock mr-2"></i>' . htmlspecialchars($assignment["timer"]) . ' mins
                                        </td>
                                        <td class="px-6 py-4 text-gray-700">
                                            <i class="far fa-calendar-alt mr-2"></i>' . htmlspecialchars($assignedOn) . '
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>Completed
                                            </span>
                                        </td>
                                    </tr>';
                                }
                            } catch(PDOException $e) {
                                echo '<tr><td colspan="4" class="px-6 py-4 text-red-600">Error checking assignment status: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                            }
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <script>
    function viewAssignment(title) {
        window.location = "assignments.php?title=" + encodeURIComponent(title);
    }
    </script>
</body>
</html>