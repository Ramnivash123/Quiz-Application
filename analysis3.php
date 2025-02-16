<?php
// Include database connection
include 'db.php';

// Fetch data from the database
try {
    $sql = "SELECT reason, COUNT(reason) as count FROM reasons GROUP BY reason";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for the chart
    $reasons = [];
    $counts = [];
    foreach ($results as $row) {
        $reasons[] = $row['reason'];
        $counts[] = $row['count'];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reasons Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto mt-10">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-2xl font-bold text-gray-800">Reasons Count Chart</h1>
            <a href="teacherr.php" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition">
                Back
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <canvas id="reasonsChart" class="w-full"></canvas>
        </div>
    </div>

    <script>
        // Prepare data for the chart
        const data = {
            labels: <?php echo json_encode($reasons); ?>, // X-axis labels
            datasets: [{
                label: 'Reason Count',
                data: <?php echo json_encode($counts); ?>, // Data points
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Chart configuration
        const config = {
            type: 'bar', // Bar chart
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Reasons Count Chart'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Render the chart
        const reasonsChart = new Chart(
            document.getElementById('reasonsChart'),
            config
        );
    </script>
</body>
</html>
