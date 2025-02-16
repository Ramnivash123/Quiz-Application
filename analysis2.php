<?php
session_start();
include 'db.php';

// Fetch the teacher's name from the session
$teacher_name = $_SESSION['teacher_name'] ?? null;

if (!$teacher_name) {
    die("Teacher name not found in session.");
}

try {
    // Fetch marks data from the database
    $sql = "SELECT m.marks FROM marks m
            INNER JOIN exam e ON m.title = e.title
            WHERE e.teacher = :teacher";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':teacher' => $teacher_name]);

    $marksData = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($marksData)) {
        die("No data found.");
    }

    // Prepare histogram data
    $bins = array_fill(0, 11, 0); // 0-10, 10-20, ..., 90-100

    foreach ($marksData as $mark) {
        $index = min(intval($mark / 10), 10); // Cap at the last bin
        $bins[$index]++;
    }

} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// Close the connection
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histogram Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-4xl w-full p-6 bg-white shadow-lg rounded-lg">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Histogram of Marks Range</h2>
            <a href="leader.php" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                Back to Leaderboard
            </a>
        </div>
        <canvas id="histogramChart" width="400" height="200"></canvas>
    </div>

    <script>
        const bins = <?php echo json_encode($bins); ?>;

        const labels = [
            '0', '10', '20', '30', '40',
            '50', '60', '70', '80', '90', '100'
        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Student Count',
                data: bins.slice(0, 10), // Exclude the 100+ range
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count of Students'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Marks Range'
                        }
                    }
                }
            }
        };

        const histogramChart = new Chart(
            document.getElementById('histogramChart'),
            config
        );
    </script>
</body>
</html>
