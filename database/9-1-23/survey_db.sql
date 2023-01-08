-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2023 at 05:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `lesson_set`
--

CREATE TABLE `lesson_set` (
  `id` int(11) NOT NULL,
  `title` varchar(11) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `lesson` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson_set`
--

INSERT INTO `lesson_set` (`id`, `title`, `description`, `user_id`, `date_created`, `lesson`) VALUES
(2, 'Anatomy of ', '<ul>\r\n	<li><span style=\"font-size:16px\">Heart</span></li>\r\n	<li><span style=\"font-size:16px\">Lungs</span></li>\r\n	<li><span style=\"font-size:16px\">Layers</span></li>\r\n	<li><span style=\"font-size:16px\">Location</span></li>\r\n</ul>\r\n', 0, 0, ''),
(3, 'HEART VALVE', '<p>Heart Valves</p>\r\n\r\n<p>About Heart Valve</p>\r\n\r\n<p>The Four Chambers</p>\r\n', 0, 0, ''),
(4, 'Blood', '<p>Example2</p>\r\n', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(30) NOT NULL,
  `question` text NOT NULL,
  `frm_option` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `order_by` int(11) NOT NULL,
  `survey_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `frm_option`, `type`, `order_by`, `survey_id`, `date_created`) VALUES
(5, '1.	What is the bodily part that circulates blood throughout the entire body?', '{\"Vcein\":\"A. HEART	\",\"CbAUO\":\"B. Lungs\",\"dRJbh\":\"C. Kidneys \",\"VWkqe\":\"D. Blood Vessels\"}', 'radio_opt', 0, 6, '2022-12-12 07:56:30'),
(6, 'What is the bodily part that circulates blood throughout the entire body?', '{\"HntUL\":\"Heart\",\"EvjYh\":\"Lungs\",\"WFXBe\":\"Kidney\",\"CaHdK\":\"Blood Vessel\"}', 'radio_opt', 0, 1, '2022-12-12 23:53:10'),
(7, 'It is appropriate to visualize the heart as approximately the size the owner’s ______.', '{\"CuaiA\":\"Closed Fist\",\"BLMUf\":\"Elbow\",\"mYGVH\":\"Open Palm\",\"vCuJp\":\"Arm\"}', 'radio_opt', 0, 1, '2022-12-12 23:55:45'),
(8, '1.	What is the bodily part that circulates blood throughout the entire body?', '{\"eQqRY\":\"Heart\",\"hNEzS\":\"Lungs\",\"szOmo\":\"Kideny\",\"DuxYl\":\"Brain\"}', 'radio_opt', 0, 9, '2022-12-15 11:46:02'),
(14, '1.	What is the bodily part that circulates blood throughout the entire body?', '{\"qWJKo\":\"Heart\",\"cmjZp\":\"Lung\",\"MhgBs\":\"Blood Vessel\",\"CHWYy\":\"Kidney\"}', 'radio_opt', 0, 13, '2022-12-15 19:41:31'),
(24, 'Which event will NOT occur during depolarization phase?', '{\"JKZxD\":\"Heart\",\"zSwvW\":\"Lung\",\"emgBR\":\"Kidney\",\"mQhdA\":\"Brain\"}', 'radio_opt', 0, 12, '2022-12-20 13:25:04');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `Quiz_title` varchar(100) NOT NULL,
  `Quiz_desc` varchar(255) NOT NULL,
  `totalPoints` int(255) NOT NULL,
  `passing_score` int(255) NOT NULL,
  `totalItem` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `Quiz_title`, `Quiz_desc`, `totalPoints`, `passing_score`, `totalItem`) VALUES
(1, 'Lesson 1', 'Four Chambers', 75, 60, 15);

-- --------------------------------------------------------

--
-- Table structure for table `quizlist`
--

CREATE TABLE `quizlist` (
  `id` int(15) NOT NULL,
  `Quiz_title` varchar(100) NOT NULL,
  `Quiz_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizlist`
--

INSERT INTO `quizlist` (`id`, `Quiz_title`, `Quiz_desc`) VALUES
(1, 'Lesson 2', '<p>4 chambers for lesson</p>\r\n'),
(2, 'Lesson 3 ', '<p>Size and Location</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempt`
--

CREATE TABLE `quiz_attempt` (
  `quizAttempt_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `status` int(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_correct`
--

CREATE TABLE `quiz_correct` (
  `quizCorrect_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `quizItemID` int(11) NOT NULL,
  `points` int(255) NOT NULL,
  `hint_used` int(255) NOT NULL,
  `quiz_attempt` int(255) NOT NULL,
  `date_saved` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_item`
--

CREATE TABLE `quiz_item` (
  `quizItemID` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `ch1` varchar(255) NOT NULL,
  `ch2` varchar(255) NOT NULL,
  `ch3` varchar(255) NOT NULL,
  `ch4` varchar(255) NOT NULL,
  `answerkey` varchar(255) NOT NULL,
  `hint` varchar(255) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_item`
--

INSERT INTO `quiz_item` (`quizItemID`, `question`, `ch1`, `ch2`, `ch3`, `ch4`, `answerkey`, `hint`, `quiz_id`) VALUES
(1, 'How many chambers does the heart have?', '4', '5', '1', '2', '4', 'I am an even number. I am less than 2+3', 1),
(2, 'It receives oxygen-poor blood from the body and pumps it to the right ventricle.', 'Left ventricle', 'Right ventricle', 'Right atrium', 'Left atrium', 'Right atrium', 'It is located in the upper right corner of the heart.', 1),
(3, 'It pumps the oxygen-rich blood to the body.', 'Left  ventricle', 'Right ventricle', 'Right atrium', 'Left atrium', 'Left  ventricle', 'It is located in the bottom left portion of the heart below the left atrium.', 1),
(4, 'It pumps the oxygen-poor blood to the lungs.', 'Left  ventricle', 'Right ventricle', 'Right atrium', 'Left atrium', 'Right ventricle', 'It is located in the lower right portion of the heart below the right atrium and opposite the left ventricle.', 1),
(5, 'It receives oxygen-rich blood from the lungs and pumps it to the left ventricle.', 'Left  ventricle', 'Right ventricle', 'Right atrium', 'Left atrium', 'Left atrium', 'It is positioned slightly above and behind the right atrium.', 1),
(6, 'What is the plural for atrium?', 'Atriums', 'Atria', 'Atrias', 'Atrium', 'Atria', 'Sound like galleria.', 1),
(7, 'The _____  serves as the primary pumping chambers of the heart, propelling blood to the lungs or to the rest of the body.', 'Atrium', 'Ventricle', 'Atria', 'Capillaries', 'Ventricle', 'Part of the heart that pumps blood to the arteries.', 1),
(8, 'It transports blood to and from the lungs, where it picks up oxygen and delivers carbon dioxide for exhalation.', '	Systemic circuit', 'Pulmonary circuit', 'Pulmonary capillaries', 'Systemic capillaries', 'Pulmonary circuit', 'Division of the circulatory system in all vertebrates.', 1),
(9, 'It transports oxygenated blood to virtually all of the tissues of the body and returns to the heart.', 'Systemic circuit', 'Pulmonary circuit', 'Pulmonary capillaries', 'Systemic capillaries', 'Systemic circuit', 'Flows through arteries, then arterioles, then capillaries where gas exchange occurs to tissues.', 1),
(10, 'The right ventricle pumps deoxygenated blood into the  ______.', 'Pulmonary trunk', 'Pulmonary arteries', 'Pulmonary capillaries', 'Pulmonary veins', 'Pulmonary trunk', 'Transports blood from the right ventricle to the pulmonary arteries.', 1),
(11, 'What are the 4 chambers of the heart?', 'Right atrium, left atrium, right ventricle ,  left ventricle', 'Pulmonary trunk, Pulmonary arteries , pulmonary capillaries, pulmonary veins', 'Systemic atrium, pulmonary atrium,  systemic ventricle, pulmonary ventricle', 'Right chamber, left chamber, down chamber , up chamber', 'Right atrium, left atrium, right ventricle ,  left ventricle', 'Two atria and two ventricles.', 1),
(12, 'The wall of the heart is composed of three layers of 	unequal thickness. These are:', 'Epicardium, myocardium, endocardium', 'Capillaries, atrium , veins , chamber', 'Systemic atrium, pulmonary atrium,  systemic ventricle, pulmonary ventricle', 'Right chamber, left chamber, down chamber , up chamber', 'Epicardium, myocardium, endocardium', 'EME', 1),
(13, 'The middle and thickest layer is the _______, made largely of cardiac muscle cells.', 'Epicardium', 'Myocardium', 'Pericardium', 'Endocardium ', 'Myocardium', 'Middle muscular layer of the heart.', 1),
(14, 'It is the _________  of the myocardium that pumps blood through the heart and into the major arteries.', 'Contraction ', 'Palpitation', 'Distraction', 'Reaction', 'Contraction ', 'Another word for this is shrinkage.', 1),
(15, 'How many layers does the heart have?', '3', '2', '5', '1', '3', 'I am an odd number. I am greater than 1+1.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_mistake`
--

CREATE TABLE `quiz_mistake` (
  `mistake_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quizItem_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `input_answer` varchar(255) NOT NULL,
  `mistake` int(100) NOT NULL,
  `quiz_attempt` int(100) NOT NULL,
  `date_saved` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_set`
--

CREATE TABLE `survey_set` (
  `id` int(30) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `Quiz_title` varchar(155) NOT NULL,
  `Quiz_desc` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `survey_set`
--

INSERT INTO `survey_set` (`id`, `title`, `description`, `user_id`, `Quiz_title`, `Quiz_desc`, `date_created`) VALUES
(13, 'ANATOMY OF THE HEART', 'MULTIPLE CHOICE', 0, '', '', '2022-12-15 19:41:13'),
(16, 'Anatomy of the heart', 'Example', 0, '', '', '2022-12-16 22:46:49'),
(17, 'Anatomy of the heart', 'Example', 0, '', '', '2022-12-16 22:49:10'),
(18, 'Anatomy of the heart', 'Ex', 0, '', '', '2022-12-16 22:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2 = Teacher, 3= Student',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `middlename`, `contact`, `address`, `email`, `password`, `type`, `date_created`) VALUES
(1, 'Admin', 'Admin', '', '+123456789', 'Sample address', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 1, '2020-11-10 08:43:06'),
(2, 'Shiver Joy', 'Raboy', 'R', '8747808787', 'Mabini Street', 'shiver@gmail.com', '5a58c39cd988b334d7fb8bfa50daa6ff', 3, '2020-11-10 09:16:53'),
(3, 'Sean Lester', 'Villarta', 'P', '+6948 8542 623', 'Estrada 4th', 'sean@gmail.com', 'feed516f8ad036737189efce269d5936', 3, '2020-11-10 15:59:11'),
(4, 'Mary Lou', 'Cenabre', 'C', '8747808787', 'Cogon, Biao', 'mary@gmail.com', 'c2771f9081602248cf86ac8e7fb6f559', 3, '2020-11-10 16:21:02'),
(5, 'Regine', 'Vellarin', 'Mendez', '09105376536', 'Aplaya', 'reginevellarin@gmail.com', '946d9afb68a4a9df13d50c468e73f61a', 3, '2022-12-12 07:01:48'),
(6, 'James', 'Tuling', 'M', '09877834231', 'Mainland China', 'parengjames@gmail.com', '202cb962ac59075b964b07152d234b70', 3, '2023-01-05 23:32:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lesson_set`
--
ALTER TABLE `lesson_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quizlist`
--
ALTER TABLE `quizlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_attempt`
--
ALTER TABLE `quiz_attempt`
  ADD PRIMARY KEY (`quizAttempt_id`);

--
-- Indexes for table `quiz_correct`
--
ALTER TABLE `quiz_correct`
  ADD PRIMARY KEY (`quizCorrect_id`);

--
-- Indexes for table `quiz_item`
--
ALTER TABLE `quiz_item`
  ADD PRIMARY KEY (`quizItemID`);

--
-- Indexes for table `quiz_mistake`
--
ALTER TABLE `quiz_mistake`
  ADD PRIMARY KEY (`mistake_id`);

--
-- Indexes for table `survey_set`
--
ALTER TABLE `survey_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lesson_set`
--
ALTER TABLE `lesson_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quizlist`
--
ALTER TABLE `quizlist`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz_attempt`
--
ALTER TABLE `quiz_attempt`
  MODIFY `quizAttempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `quiz_correct`
--
ALTER TABLE `quiz_correct`
  MODIFY `quizCorrect_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `quiz_item`
--
ALTER TABLE `quiz_item`
  MODIFY `quizItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quiz_mistake`
--
ALTER TABLE `quiz_mistake`
  MODIFY `mistake_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `survey_set`
--
ALTER TABLE `survey_set`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
