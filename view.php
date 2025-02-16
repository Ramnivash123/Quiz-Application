<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .profile-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Profile Button -->
    <div class="profile-btn">
        <a href="teacherr.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Profile</a>
    </div>

    <div class="container mx-auto my-10 px-4">
        <h1 class="text-3xl font-semibold text-center text-blue-600 mb-8">Assignments</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-700">Assignment</th>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-700">Timer</th>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-700">Assigned On</th>
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    session_start();

                    // Establishing a connection to the database (replace these values with your database credentials)
                    include 'db.php';

                    $teacher_name = $_SESSION['teacher_name'] ?? '';

                    // Fetching assignments from the database, including the assigned date
                    $sql = "SELECT id, title, timer, c_date FROM exam WHERE teacher = :teacher";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':teacher', $teacher_name, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($result === false) {
                        die("Error executing query: " . $conn->errorInfo()[2]);
                    }

                    if (count($result) > 0) {
                        // Output data of each row
                        foreach ($result as $row) {
                            // Format the assigned date for display
                            $assignedOn = date("Y-m-d H:i:s", strtotime($row["c_date"]));
                            echo "<tr class='border-t'>
                                    <td class='py-2 px-4'>
                                        <button class='bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600' onclick='viewAssignment(\"" . htmlspecialchars($row["title"]) . "\")'>" . htmlspecialchars($row["title"]) . "</button>
                                    </td>
                                    <td class='py-2 px-4 text-sm'>" . htmlspecialchars($row["timer"]) . " mins</td>
                                    <td class='py-2 px-4 text-sm'>" . htmlspecialchars($assignedOn) . "</td>
                                    <td class='py-2 px-4'>
                                        <button class='bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600' onclick='deleteAssignment(\"" . htmlspecialchars($row["id"]) . "\")'>Delete</button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center py-4 text-gray-500'>No assignments found</td></tr>";
                    }

                    $stmt->closeCursor(); // Close the cursor
                    $conn = null; // Close the connection
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tailwind JS (optional for some functionalities) -->
    <script>
        function viewAssignment(title) {
            window.location = "view2.php?title=" + encodeURIComponent(title);
        }

        function deleteAssignment(id) {
            if (confirm("Are you sure you want to delete this assignment?")) {
                window.location = "delete_assignment.php?id=" + encodeURIComponent(id);
            }
        }
    </script>
</body>
</html>
