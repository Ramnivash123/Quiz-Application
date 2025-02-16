<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .motivation-show {
            animation: slideUp 0.5s ease-out;
            opacity: 1;
        }
        
        @keyframes slideUp {
            from { 
                transform: translateY(20px);
                opacity: 0;
            }
            to { 
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Top Navigation Bar -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <button class="bg-blue-700 hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out" onclick="goBack()">
                    Back
                </button>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-700 rounded-lg px-4 py-2">
                        <span class="text-white font-medium">Time Remaining: <span id="timer" class="font-bold">00:00</span></span>
                    </div>
                    <button class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out" onclick="restartTimer()">
                        Restart
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        <!-- Progress Section -->
        <div class="mb-8">
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div id="progressBar" class="bg-blue-500 h-4 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
            <div id="progressText" class="text-center mt-2 text-gray-700 font-medium"></div>
        </div>

        <!-- Motivational Message -->
        <div id="motivation" class="hidden text-center text-xl font-bold text-blue-600 py-4"></div>

        <!-- Question Container -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form id="examForm" action="submit.php" method="post" class="space-y-6">
                <?php if (isset($_GET['title'])): ?>
                    <?php
                    include 'db.php';
                    $title = $_GET['title'];
                    $sql = "SELECT a.*, e.timer, e.subject FROM assignments a JOIN exam e ON a.title = e.title WHERE a.title = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(1, $title, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (count($result) > 0):
                        foreach ($result as $row):
                    ?>
                        <div class="assignment-details fade-in" data-qn="<?php echo $row['qn']; ?>">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Question <?php echo $row['qn']; ?></h2>
                            <div class="text-gray-700 text-lg mb-6"><?php echo $row["question"]; ?></div>
                            
                            <div class="space-y-4">
                                <?php for($i = 1; $i <= 4; $i++): ?>
                                    <label class="flex items-start p-4 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="radio" name="option[<?php echo $row['id']; ?>]" 
                                            value="<?php echo $row["opt".$i]; ?>" 
                                            id="opt<?php echo $i; ?>_<?php echo $row['id']; ?>"
                                            class="mt-1">
                                        <span class="ml-3"><?php echo $row["opt".$i]; ?></span>
                                    </label>
                                <?php endfor; ?>
                            </div>

                        </div>
                    <?php endforeach; ?>
                    <!-- Move the timer initialization outside the loop but still within the if condition -->
                    <script>
                        // Set timer duration using the first row's timer value
                        window.timerDuration = <?php echo ($result[0]["timer"] * 60); ?>;
                        console.log("Timer duration set to:", window.timerDuration); // Debug log
                    </script>
                    <input type="hidden" id="subject" name="subject" value="<?php echo $result[0]['subject']; ?>">
                    <input type="hidden" id="assignment_title" name="assignment_title" value="<?php echo $result[0]['title']; ?>">
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Hidden Fields -->
                <input type="hidden" id="date" name="date">
                <input type="hidden" id="start_time" name="start_time">
                <input type="hidden" id="end_time" name="end_time">
                <input type="hidden" id="quit_time" name="quit_time">
                <input type="hidden" id="question_number" name="question_number" value="1">
                <input type="hidden" id="qn" name="qn" value="">
            </form>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center">
            <button id="prevBtn" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-lg transition duration-150 ease-in-out" onclick="prevQuestion()">Previous</button>
            <button id="nextBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-lg transition duration-150 ease-in-out" onclick="nextQuestion()">Next</button>
            <button id="submitBtn" class="hidden bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-6 rounded-lg transition duration-150 ease-in-out" onclick="submitForm()">Submit</button>
        </div>
    </main>

    <!-- Modal -->
    <div id="reasonModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-6 m-4 max-w-sm w-full">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Why are you leaving?</h2>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeModal()">&times;</button>
            </div>
            <form id="reasonForm" action="submit_reason.php" method="post" class="space-y-4">
                <div class="space-y-2">
                    <label class="flex items-center p-2 rounded hover:bg-gray-50">
                        <input type="radio" name="reason" value="boring" class="mr-3">
                        <span>Content is boring</span>
                    </label>
                    <label class="flex items-center p-2 rounded hover:bg-gray-50">
                        <input type="radio" name="reason" value="more_questions" class="mr-3">
                        <span>Need more questions</span>
                    </label>
                    <label class="flex items-center p-2 rounded hover:bg-gray-50">
                        <input type="radio" name="reason" value="difficult" class="mr-3">
                        <span>Too difficult</span>
                    </label>
                </div>
                <div class="flex justify-center pt-4">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        Submit Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Initialize timer variables
    let remainingTime;
    let timerInterval;
    let currentQuestionIndex = 0;

    function startTimer(duration) {
        console.log("Starting timer with duration:", duration); // Debug log
        let timer = duration;
        const display = document.querySelector('#timer');
        
        // Clear any existing interval
        if (timerInterval) {
            clearInterval(timerInterval);
        }

        timerInterval = setInterval(() => {
            const minutes = String(Math.floor(timer / 60)).padStart(2, '0');
            const seconds = String(timer % 60).padStart(2, '0');
            
            display.textContent = `${minutes}:${seconds}`;
            remainingTime = timer;

            if (--timer < 0) {
                clearInterval(timerInterval);
                submitForm();
            }
        }, 1000);
    }

    function showQuestion(index) {
        const questions = document.querySelectorAll('.assignment-details');
        const totalQuestions = questions.length;

        questions.forEach((question, i) => {
            question.style.display = i === index ? 'block' : 'none';
            if (i === index) {
                document.getElementById('qn').value = question.getAttribute('data-qn');
            }
        });

        const progressPercentage = ((index + 1) / totalQuestions) * 100;
        document.getElementById('progressBar').style.width = `${progressPercentage}%`;
        document.getElementById('progressText').textContent = `Question ${index + 1} of ${totalQuestions}`;

        document.getElementById('prevBtn').style.display = index === 0 ? 'none' : 'block';
        document.getElementById('nextBtn').style.display = index === questions.length - 1 ? 'none' : 'block';
        document.getElementById('submitBtn').style.display = index === questions.length - 1 ? 'block' : 'none';

        // Navigate to different pages after a certain number of questions
        if (index === 9) {
            window.location.href = "snake.html";
        } else if (index === 19) {
            window.location.href = "memory.html";
        }

        if ((index + 1) % 6 === 0) {
            showMotivation();
        }
    }


    function showMotivation() {
        const quotes = [
            "You're doing great! 🌟",
            "Keep going! 💪",
            "Excellent progress! 🎯",
            "You've got this! ⭐"
        ];
        const motivationElement = document.getElementById('motivation');
        motivationElement.textContent = quotes[Math.floor(Math.random() * quotes.length)];
        motivationElement.classList.remove('hidden');
        motivationElement.classList.add('motivation-show');

        setTimeout(() => {
            motivationElement.classList.remove('motivation-show');
            motivationElement.classList.add('hidden');
        }, 2000);
    }

    function nextQuestion() {
        currentQuestionIndex++;
        showQuestion(currentQuestionIndex);
    }

    function prevQuestion() {
        currentQuestionIndex--;
        showQuestion(currentQuestionIndex);
    }

    function submitForm() {
        const endTime = new Date();
        document.getElementById('end_time').value = endTime.toTimeString().split(' ')[0];
        document.getElementById("examForm").submit();
    }

    function restartTimer() {
        if (confirm('Are you sure you want to restart? All progress will be lost.')) {
            clearInterval(timerInterval);
            document.getElementById('examForm').reset();
            localStorage.removeItem('remainingTime');
            remainingTime = window.timerDuration;
            startTimer(remainingTime);
            currentQuestionIndex = 0;
            showQuestion(0);
        }
    }

    function goBack() {
        document.getElementById('reasonModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('reasonModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('reasonModal');
        if (event.target === modal) {
            closeModal();
        }
    }

    window.onload = function() {
        console.log("Window loaded, timer duration:", window.timerDuration); // Debug log
        const startTime = new Date();
        document.getElementById('start_time').value = startTime.toTimeString().split(' ')[0];
        document.getElementById('date').value = startTime.toISOString().split('T')[0];

        const savedRemainingTime = localStorage.getItem('remainingTime');
        remainingTime = savedRemainingTime ? parseInt(savedRemainingTime, 10) : window.timerDuration;

        // Make sure we have a valid timer duration before starting
        if (window.timerDuration) {
            startTimer(remainingTime);
        } else {
            console.error("Timer duration not set!"); // Debug log
        }
        
        showQuestion(currentQuestionIndex);
    };
    </script>
</body>
</html>