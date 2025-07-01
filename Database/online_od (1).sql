-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 05:55 PM
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
-- Database: `online_od`
--

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `enrollment` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `year_of_study` varchar(50) NOT NULL,
  `programme` varchar(50) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `class` varchar(50) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `days_availed` int(11) DEFAULT NULL,
  `parent_sign` varchar(255) DEFAULT NULL,
  `student_sign` varchar(255) DEFAULT NULL,
  `advisor_letter` varchar(255) DEFAULT NULL,
  `hod_letter` varchar(255) DEFAULT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending',
  `email` varchar(100) NOT NULL,
  `leave_quota` int(11) DEFAULT 7,
  `dean_decision` varchar(20) DEFAULT NULL,
  `forwarded_to_hod` tinyint(1) NOT NULL DEFAULT 0,
  `forwarded_semester` varchar(50) DEFAULT NULL,
  `forwarded_to_teachers` int(11) DEFAULT NULL,
  `attendance_marked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `name`, `enrollment`, `department`, `year_of_study`, `programme`, `branch`, `class`, `leave_type`, `from_date`, `to_date`, `reason`, `days_availed`, `parent_sign`, `student_sign`, `advisor_letter`, `hod_letter`, `submission_time`, `status`, `email`, `leave_quota`, `dean_decision`, `forwarded_to_hod`, `forwarded_semester`, `forwarded_to_teachers`, `attendance_marked`) VALUES
(1, 'AARYAN M', '2201112003', 'IT', '3rd Year', 'B.Tech', 'CC', 'a', 'duty', '2025-03-20', '2025-03-22', 'Stress', 2, 'uploads/download.jpeg', 'uploads/images (1).png', 'uploads/Domain.pdf', 'uploads/pdfcoffee.com_web-technology-7-pdf-free.pdf', '2025-03-06 12:09:47', 'Approved', 'amizharasu@gmail.com', 7, NULL, 0, NULL, 0, 0),
(3, 'Adesh', '2201112004', 'IT', '3rd Year', 'B.Tech', 'CC', 'a', 'duty', '2025-03-07', '2025-03-08', 'Sports', 2, 'uploads/Adesh_2201112004/download.jpeg', 'uploads/Adesh_2201112004/images (1).png', 'uploads/Adesh_2201112004/pdfcoffee.com_web-technology-7-pdf-free.pdf', 'uploads/Adesh_2201112004/Domain.pdf', '2025-03-06 16:59:44', 'Approved', 'mohanaryan21@gmail.com', 7, NULL, 0, NULL, 0, 0),
(4, 'Sarvesh', '3456789456', 'IT', '2nd Year', 'B.Tech', 'Full Stack', 'a', 'duty', '2025-03-10', '2025-03-12', 'Sports', 2, 'uploads/Sarvesh_3456789456/images (1).png', 'uploads/Sarvesh_3456789456/download.jpeg', 'uploads/Sarvesh_3456789456/APPLICATION LAYER PROTOCOLS.pdf', 'uploads/Sarvesh_3456789456/Domain.pdf', '2025-03-07 13:44:02', 'Approved', 'sarweshsasi220@gmail.com', 7, NULL, 0, NULL, 0, 0),
(5, 'Adesh', '2201112004', 'IT', '3rd Year', 'B.Tech', 'CC', 'a', 'duty', '2025-03-22', '2025-03-24', 'Arupadai tour', 2, 'uploads/Adesh_2201112004/images (1).png', 'uploads/Adesh_2201112004/download.jpeg', 'uploads/Adesh_2201112004/Domain.pdf', 'uploads/Adesh_2201112004/Domain.pdf', '2025-03-08 13:50:36', 'Approved', 'adesh.saminathan998@ptuniv.edu.in', 7, NULL, 0, NULL, 0, 0),
(6, 'Thangamani', '12345', 'CSE', '1st Year', 'B.Tech', 'CC', 'a', 'personal', '2025-03-26', '2025-03-12', 'Bored', 4, 'uploads/Thangamani_12345/images (1).png', 'uploads/Thangamani_12345/download.jpeg', 'uploads/Thangamani_12345/Domain.pdf', 'uploads/Thangamani_12345/applying-uml-and-patterns-an-introduction-to-object-oriented-analysis-and-design-and-iterative-development-1163708372-0131489062-9780131489066_compress.pdf', '2025-03-08 18:32:21', 'Approved', 'mohanaryan21@gmail.com', 7, 'Rejected', 0, NULL, 0, 0),
(17, 'Sarwesh', '2301110043', 'CSE', '2nd Year', 'B.Tech', 'BTECH', 'a', 'personal', '2025-03-12', '2025-03-13', 'baseball', 2, 'uploads/Sarwesh_2301110043/TECHSPIRE.png', 'uploads/Sarwesh_2301110043/TECHSPIRE.png', 'uploads/Sarwesh_2301110043/iotunit1[1].pdf', 'uploads/Sarwesh_2301110043/iotunit1[1].pdf', '2025-03-11 14:26:54', 'Rejected', 'sarweshsasi220@gmail.com', 7, NULL, 1, NULL, 0, 0),
(18, 'Sarwesh', '2301110043', 'ECE', '2nd Year', 'B.Tech', 'cc', 'a', 'personal', '2025-03-12', '2025-03-13', 'cold', 1, 'uploads/Sarwesh_2301110043/TECHSPIRE.png', 'uploads/Sarwesh_2301110043/TECHSPIRE.png', 'uploads/Sarwesh_2301110043/iotunit1[1].pdf', 'uploads/Sarwesh_2301110043/iotunit1[1].pdf', '2025-03-11 14:47:13', 'Approved', 'sarweshsasi220@gmail.com', 7, NULL, 1, NULL, 0, 0),
(21, 'AARYAN M', '2201112003', 'IT', '3rd Year', 'B.Tech', 'Full Stack', 'a', 'personal', '2025-03-12', '2025-03-12', 'Cold', 2, 'uploads/AARYAN M_2201112003/TECHSPIRE.png', 'uploads/AARYAN M_2201112003/TECHSPIRE.png', 'uploads/AARYAN M_2201112003/iotunit1[1].pdf', 'uploads/AARYAN M_2201112003/iotunit1[1].pdf', '2025-03-11 16:27:06', 'Approved', 'amizharasu@gmail.com', 7, NULL, 1, NULL, 0, 0),
(22, 'Gold', '12345', 'CSE', '1st Year', 'B.Tech', 'Full Stack', 'a', 'personal', '2025-03-13', '2025-03-15', 'chicken pox', 3, 'uploads/Gold_12345/TECHSPIRE.png', 'uploads/Gold_12345/TECHSPIRE.png', 'uploads/Gold_12345/Domain.pdf', 'uploads/Gold_12345/Domain.pdf', '2025-03-11 16:53:42', 'Approved', 'mohanaryan21@gmail.com', 7, NULL, 1, NULL, 0, 0),
(23, 'AARYAN ', '2201112003', 'IT', '3rd Year', 'B.Tech', 'Full Stack', 'a', 'personal', '2025-03-13', '2025-03-13', 'Fever', 4, 'uploads/AARYAN _2201112003/TECHSPIRE.png', 'uploads/AARYAN _2201112003/TECHSPIRE.png', 'uploads/AARYAN _2201112003/iotunit1[1].pdf', 'uploads/AARYAN _2201112003/iotunit1[1].pdf', '2025-03-12 10:05:31', 'Rejected', 'amizharasu@gmail.com', 7, NULL, 0, NULL, 0, 0),
(24, 'AARYAN ', '2201112003', 'CSE', '3rd Year', 'B.Tech', 'Full Stack', 'a', 'personal', '2025-05-10', '2025-05-11', 'Heavy fever', 2, 'uploads/AARYAN _2201112003/Industrial_IOT1-removebg-preview.png', 'uploads/AARYAN _2201112003/designpanda.png', 'uploads/AARYAN _2201112003/IoT CAT 2.pdf', 'uploads/AARYAN _2201112003/IoT CAT 2.pdf', '2025-05-10 06:16:51', 'Approved', 'amizharasu@gmail.com', 7, NULL, 0, NULL, 0, 0),
(25, 'AARYAN ', '2201112003', 'CSE', '2nd Year', 'B.Tech', 'Automata Specialist', 'a', 'duty', '2025-05-14', '2025-05-14', 'Hackathon', 5, 'uploads/AARYAN _2201112003/Industrial_IOT1-removebg-preview.png', 'uploads/AARYAN _2201112003/Industrial_IOT1-removebg-preview.png', 'uploads/AARYAN _2201112003/thynk unlimted.pdf', 'uploads/AARYAN _2201112003/thynk unlimted.pdf', '2025-05-13 16:54:41', 'Approved', 'amizharasu@gmail.com', 7, NULL, 0, NULL, 0, 0),
(26, 'Aaryan', '2201112003', 'CSE', '3rd Year', 'B.Tech', 'BTECH', 'a', 'personal', '2025-05-16', '2025-05-16', 'Headache', 6, 'uploads/Aaryan_2201112003/Industrial_IOT1-removebg-preview.png', 'uploads/Aaryan_2201112003/designpanda.png', 'uploads/Aaryan_2201112003/thynk unlimted.pdf', 'uploads/Aaryan_2201112003/thynk unlimted.pdf', '2025-05-15 11:33:04', 'Forwarded to Teacher', 'amizharasu@gmail.com', 7, NULL, 0, '1', 1, 1),
(27, 'AARYAN M', '22011120031', 'CSE', '3rd Year', 'B.Tech', 'CC', 'a', 'personal', '2025-05-16', '2025-05-16', 'Fever', 6, 'uploads/AARYAN M_2201112003/designpanda.png', 'uploads/AARYAN M_2201112003/designpanda.png', 'uploads/AARYAN M_2201112003/thynk unlimted.pdf', 'uploads/AARYAN M_2201112003/thynk unlimted.pdf', '2025-05-15 15:31:23', 'Forwarded to Teacher', 'amizharasu@gmail.com', 7, NULL, 0, '6', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `od_attendance`
--

CREATE TABLE `od_attendance` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  `marked_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `od_attendance`
--

INSERT INTO `od_attendance` (`id`, `application_id`, `teacher_email`, `marked_at`) VALUES
(6, 27, 'aaryanabi72@gmail.com', '2025-05-15 21:09:11'),
(7, 27, 'mohanaryan21@gmail.com', '2025-05-15 21:21:19'),
(8, 26, 'mohanaryan21@gmail.com', '2025-05-15 21:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `od_teacher_forwarding`
--

CREATE TABLE `od_teacher_forwarding` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `forwarded_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `od_teacher_forwarding`
--

INSERT INTO `od_teacher_forwarding` (`id`, `application_id`, `teacher_email`, `semester`, `forwarded_at`) VALUES
(1, 26, 'mohanaryan21@gmail.com', '1', '2025-05-15 17:06:38'),
(2, 26, 'divyamohan554@gmail.com', '1', '2025-05-15 17:06:38'),
(3, 26, 'mohanaryan21@gmail.com', '1', '2025-05-15 17:06:38'),
(4, 26, 'mohanaryan21@gmail.com', '1', '2025-05-15 17:11:51'),
(5, 26, 'divyamohan554@gmail.com', '1', '2025-05-15 17:11:51'),
(6, 26, 'mohanaryan21@gmail.com', '1', '2025-05-15 17:11:51'),
(7, 27, 'mohanaryan21@gmail.com', '6', '2025-05-15 21:05:34'),
(8, 27, 'divyamohan554@gmail.com', '6', '2025-05-15 21:05:34'),
(9, 27, 'mohanaryan21@gmail.com', '6', '2025-05-15 21:05:34'),
(10, 27, 'mohanaryan21@gmail.com', '6', '2025-05-15 21:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `profile_change_requests`
--

CREATE TABLE `profile_change_requests` (
  `id` int(11) NOT NULL,
  `registration_number` varchar(50) NOT NULL,
  `current_name` varchar(100) NOT NULL,
  `current_email` varchar(100) NOT NULL,
  `new_name` varchar(100) NOT NULL,
  `new_email` varchar(100) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `request_date` datetime NOT NULL,
  `processed_date` datetime DEFAULT NULL,
  `processed_by` varchar(50) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_change_requests`
--

INSERT INTO `profile_change_requests` (`id`, `registration_number`, `current_name`, `current_email`, `new_name`, `new_email`, `status`, `request_date`, `processed_date`, `processed_by`, `admin_notes`) VALUES
(1, '2201112003', 'Aaryan', 'amizharasu@gmail.com', 'AARYAN M', 'amizharasu@gmail.com', 'approved', '2025-05-15 19:51:46', '2025-05-15 19:52:10', NULL, ''),
(2, '2201112003', 'AARYAN M', 'amizharasu@gmail.com', 'AARYAN M 01', 'amizharasu@gmail.com', 'approved', '2025-05-15 21:02:08', '2025-05-15 21:11:28', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `semester_teachers`
--

CREATE TABLE `semester_teachers` (
  `id` int(11) NOT NULL,
  `department` varchar(10) NOT NULL,
  `semester` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  `teacher_name` varchar(100) DEFAULT NULL,
  `staff_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester_teachers`
--

INSERT INTO `semester_teachers` (`id`, `department`, `semester`, `subject_name`, `teacher_email`, `teacher_name`, `staff_id`) VALUES
(1, 'CSE', 6, 'Mathematics-I', 'mohanaryan21@gmail.com', NULL, 'cs1'),
(2, 'CSE', 6, 'Physics', 'divyamohan554@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `registration_number` varchar(50) NOT NULL,
  `role` enum('student','dean','hod','vc','teacher','admin') DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `staff_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `registration_number`, `role`, `email`, `password`, `department`, `name`, `staff_id`) VALUES
(1, '12345', 'student', 'mohanaryan21@gmail.com', 'aari', NULL, 'Gold', NULL),
(2, '67890', 'dean', 'divyamohan554@gmail.com', 'aari', NULL, 'Dean', NULL),
(3, '54321', 'hod', 'amizharasu@gmail.com', 'aari', NULL, '', NULL),
(4, '98765', 'vc', 'jagahdish5@gmail.com', 'aari', NULL, 'MR.MOHAN', NULL),
(5, '221', 'hod', 'aaryanabi72@gmail.com', 'aari', 'CSE', 'CSE_HOD', NULL),
(6, 'hod_ece', 'hod', 'lokesh20ptu@gmail.com', 'aari', 'ECE', '', NULL),
(7, 'hod_eee', 'hod', 'hod_eee@ptuniv.edu.in', 'hashed_password', 'EEE', '', NULL),
(8, 'hod_mech', 'hod', 'hod_mech@ptuniv.edu.in', 'hashed_password', 'MECH', '', NULL),
(9, 'hod_civil', 'hod', 'hod_civil@ptuniv.edu.in', 'hashed_password', 'CIVIL', '', NULL),
(10, '220', 'hod', 'amizharasu@gmail.com', 'aari', 'IT', 'IT HOD', NULL),
(11, 'hod_chem', 'hod', 'hod_chem@ptuniv.edu.in', 'hashed_password', 'CHEM', '', NULL),
(12, '2301110043', 'student', 'sarweshsasi220@gmail.com', 'sarvesh', 'CSE', 'Sarwesh', NULL),
(13, '2201112003', 'student', 'amizharasu@gmail.com', 'aari', 'IT', 'AARYAN M 01', NULL),
(14, '2201112004', 'student', 'adesh.saminathan998@ptuniv.edu.in', 'adesh', 'IT', 'Adesh', NULL),
(30, 'T001', 'teacher', 'mohanaryan21@gmail.com', 'hashed_password', 'CSE', 'Teacher One', 'cs1'),
(31, 'T002', '', 'teacher2@ptuniv.edu.in', 'hashed_password', 'ECE', 'Teacher Two', 'TECH002'),
(32, 'T003', '', 'teacher3@ptuniv.edu.in', 'hashed_password', 'MECH', 'Teacher Three', 'TECH003'),
(33, '', 'admin', 'mohanaryan21@gmail.com', 'pass', 'NULL', 'Admin', 'NULL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `od_attendance`
--
ALTER TABLE `od_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `od_teacher_forwarding`
--
ALTER TABLE `od_teacher_forwarding`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `profile_change_requests`
--
ALTER TABLE `profile_change_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registration_number` (`registration_number`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `semester_teachers`
--
ALTER TABLE `semester_teachers`
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
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `od_attendance`
--
ALTER TABLE `od_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `od_teacher_forwarding`
--
ALTER TABLE `od_teacher_forwarding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `profile_change_requests`
--
ALTER TABLE `profile_change_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `semester_teachers`
--
ALTER TABLE `semester_teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `od_attendance`
--
ALTER TABLE `od_attendance`
  ADD CONSTRAINT `od_attendance_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `leave_applications` (`id`);

--
-- Constraints for table `od_teacher_forwarding`
--
ALTER TABLE `od_teacher_forwarding`
  ADD CONSTRAINT `od_teacher_forwarding_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `leave_applications` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
