-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2025 at 07:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `qn` int(11) NOT NULL,
  `question` text NOT NULL,
  `opt1` varchar(100) NOT NULL,
  `opt2` varchar(100) NOT NULL,
  `opt3` varchar(100) NOT NULL,
  `opt4` varchar(100) NOT NULL,
  `answer` text NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `qn`, `question`, `opt1`, `opt2`, `opt3`, `opt4`, `answer`, `title`) VALUES
(126, 1, 'What is a neural network?', 'A type of biological brain structure', 'A mathematical model designed to simulate the workings of the human brain', 'A software for managing data in databases', 'A type of programming language', '2', 'Neural Networks'),
(127, 2, 'What is the primary purpose of an activation function in a neural network?', 'To initialize weights', 'To introduce non-linearity to the model', 'To connect input and output layers', 'To calculate the loss', '2', 'Neural Networks'),
(128, 3, 'What is the role of the input layer in a neural network?', 'To process errors in predictions', 'To receive data from external sources', 'To compute gradients during training', 'To perform backpropagation', '2', 'Neural Networks'),
(129, 4, 'Which of the following is an example of a loss function?', 'ReLU', 'Cross-Entropy', 'Dropout', 'SGD', '2', 'Neural Networks'),
(130, 5, 'What is backpropagation?', 'A method to train the neural network by updating weights using gradients', 'A technique to increase the number of layers in a network', 'A function to reduce overfitting in the network', 'A process to randomly initialize network weights', '1', 'Neural Networks'),
(131, 1, 'What is a neural network inspired by?', 'Human nervous system', 'Animal digestive system', 'Computer processors', 'Solar systems', 'Human nervous system', 'NEURAL NETWORKS'),
(132, 2, 'What is the function of an activation function in a neural network?', 'Transfer data between neurons', 'Introduce non-linearity', 'Reduce computational complexity', 'Generate random weights', 'Introduce non-linearity', 'NEURAL NETWORKS'),
(133, 3, 'Which of the following is NOT a type of neural network?', 'Convolutional Neural Network (CNN)', 'Recurrent Neural Network (RNN)', 'Evolutionary Neural Network (ENN)', 'Feedforward Neural Network (FNN)', 'Evolutionary Neural Network (ENN)', 'NEURAL NETWORKS'),
(134, 4, 'What does the \"epoch\" refer to in training a neural network?', 'Number of layers in the network', 'One complete forward and backward pass of the entire dataset', 'Size of the batch used during training', 'Total number of neurons in a layer', 'One complete forward and backward pass of the entire dataset', 'NEURAL NETWORKS'),
(135, 5, 'What is backpropagation used for?', 'To initialize weights', ' To calculate the output of a neural network', 'To update weights using gradients', 'To process inputs in reverse order', 'To update weights using gradients', 'NEURAL NETWORKS'),
(136, 6, 'What type of neural network is best suited for image recognition?', 'Recurrent Neural Network (RNN)', 'Convolutional Neural Network (CNN)', 'Feedforward Neural Network (FNN)', 'Radial Basis Function Network (RBFN)', 'Convolutional Neural Network (CNN)', 'NEURAL NETWORKS'),
(137, 7, 'What is the vanishing gradient problem?', 'Gradients become extremely small, slowing down learning', 'Gradients become extremely large, causing instability', 'Gradients disappear during testing', ' Gradients affect weight initialization', 'Gradients become extremely small, slowing down learning', 'NEURAL NETWORKS'),
(138, 8, 'Which optimizer is widely used for neural networks?', 'Stochastic Gradient Descent (SGD)', ' Newton-Raphson', 'K-Nearest Neighbors', 'Principal Component Analysis', 'Stochastic Gradient Descent (SGD)', 'NEURAL NETWORKS'),
(139, 9, 'What does \"ReLU\" stand for in neural networks?', 'Relative Linear Unit', 'Rectified Linear Unit', ' Recursive Linear Unit', ' Recurrent Linear Unit', 'Rectified Linear Unit', 'NEURAL NETWORKS'),
(140, 10, 'What does overfitting in a neural network imply?', 'The model performs well on training data but poorly on unseen data', 'The model generalizes well to all datasets', 'The model trains faster than expected', 'The model cannot learn from the dataset', 'The model performs well on training data but poorly on unseen data', 'NEURAL NETWORKS'),
(141, 11, 'Which layer is used for feature extraction in a CNN?', 'Fully connected layer', 'Convolutional layer', 'Dropout layer', 'Pooling layer', 'Convolutional layer', 'NEURAL NETWORKS'),
(142, 12, 'Which function is commonly used in the output layer of a binary classification neural network?', 'Sigmoid', 'ReLU', 'Softmax', 'Tanh', 'Sigmoid', 'NEURAL NETWORKS'),
(143, 13, 'What is the primary goal of dropout in neural networks?', ' Improve computation speed', 'Prevent overfitting', 'Increase the number of neurons', 'Train deeper networks', 'Prevent overfitting', 'NEURAL NETWORKS'),
(144, 14, 'What is a hyperparameter in neural networks?', 'A parameter learned during training', 'A parameter manually set before training', 'A type of layer in the network', ' A function used for activation', 'A parameter manually set before training', 'NEURAL NETWORKS'),
(145, 15, 'What is the primary purpose of a pooling layer in a CNN?', 'Reduce the spatial dimensions of the data', 'Increase the number of features', 'Change the number of channels', 'Flatten the input for the output layer', 'Reduce the spatial dimensions of the data', 'NEURAL NETWORKS'),
(146, 16, 'Which architecture is commonly used for sequential data like text or time series?', 'Convolutional Neural Network', 'Recurrent Neural Network', 'Generative Adversarial Network', 'Radial Basis Function Network', 'Recurrent Neural Network', 'NEURAL NETWORKS'),
(147, 17, 'Which loss function is commonly used for multi-class classification tasks?', ' Mean Squared Error (MSE)', 'Cross-Entropy Loss', 'Hinge Loss', 'L1 Loss', 'Cross-Entropy Loss', 'NEURAL NETWORKS'),
(148, 18, 'What is gradient descent used for?', 'Finding the optimal weights in a neural network', 'Increasing the dataset size', 'Generating activation functions', 'Improving network architecture', 'Finding the optimal weights in a neural network', 'NEURAL NETWORKS'),
(149, 19, 'Which of these is an example of a generative model?', 'Support Vector Machine', 'Generative Adversarial Network (GAN)', 'Logistic Regression', 'Decision Trees', 'Generative Adversarial Network (GAN)', 'NEURAL NETWORKS'),
(150, 20, ' Which regularization technique penalizes large weights by adding their squares to the loss function?', 'L1 Regularization', 'L2 Regularization', ' Dropout', 'Data Augmentation', 'L2 Regularization', 'NEURAL NETWORKS');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `timer` int(11) NOT NULL,
  `teacher` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `c_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`id`, `title`, `timer`, `teacher`, `subject`, `c_date`) VALUES
(72, 'NEURAL NETWORKS', 10, 'Raja', 'DEEP LEARNING', '2025-01-23 11:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `qn` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `timing` time NOT NULL,
  `c_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `stu_name` varchar(100) NOT NULL,
  `correct` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `time_difference` time NOT NULL,
  `status` varchar(10) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `title`, `stu_name`, `correct`, `wrong`, `marks`, `date`, `start_time`, `end_time`, `time_difference`, `status`) VALUES
(96, 'Neural Networks', 'Harish', 5, 0, 100, '2025-01-20', '21:29:01', '21:29:16', '00:00:15', 'completed'),
(98, 'Neural Networks', 'brama', 5, 0, 100, '2025-01-21', '14:21:57', '14:23:26', '00:00:00', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `reasons`
--

CREATE TABLE `reasons` (
  `id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reasons`
--

INSERT INTO `reasons` (`id`, `reason`, `created_at`) VALUES
(1, 'boring', '2025-01-20 17:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `stu_signup`
--

CREATE TABLE `stu_signup` (
  `id` int(11) NOT NULL,
  `na` varchar(100) NOT NULL,
  `em` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stu_signup`
--

INSERT INTO `stu_signup` (`id`, `na`, `em`, `pass`) VALUES
(12, 'Harish', 'harish@gmail.com', '$2y$10$9fAxKQ1P/WqhcYqYeOEeOOMqTZ7pTs1JyxdSLyGnPHw/ReM6i/sVK'),
(13, 'brama', 'brama@gmail.com', '$2y$10$h9QUVqU8N7NpWyzPoBOpDOsokId8XWAZETbySQp67ZnXp2JkZ5wzO'),
(22, 'Nikhil', 'nik@gmail.com', '$2y$10$fUK9sBy2qY6TTMKYrCgnE.EAl2JZTbhBz67KCP5ENcck7IwxezEyO');

-- --------------------------------------------------------

--
-- Table structure for table `tea_signup`
--

CREATE TABLE `tea_signup` (
  `id` int(11) NOT NULL,
  `na` varchar(100) NOT NULL,
  `em` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tea_signup`
--

INSERT INTO `tea_signup` (`id`, `na`, `em`, `pass`) VALUES
(12, 'Ramnivash', 'ram@gmail.com', '$2y$10$SwB7rsQUZxuauA5zryyXtOFQ5xD.4uxcXGyljfytrRAe0NzjmogR2'),
(13, 'Raja', 'raj@gmail.com', '$2y$10$aCHWps1c7PjWFvgGzB/rbOPW1Ty6JkTuZRHgPj6iUNRE00KzSEvzO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reasons`
--
ALTER TABLE `reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stu_signup`
--
ALTER TABLE `stu_signup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tea_signup`
--
ALTER TABLE `tea_signup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `reasons`
--
ALTER TABLE `reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stu_signup`
--
ALTER TABLE `stu_signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tea_signup`
--
ALTER TABLE `tea_signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
