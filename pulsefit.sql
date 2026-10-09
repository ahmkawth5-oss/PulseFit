-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2026 at 08:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pulsefit`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(10) NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  `class_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `check_in`, `check_out`, `user_id`, `class_id`) VALUES
(15, '2026-09-01 14:00:00', '2026-09-01 16:00:00', 22, 10),
(16, '2026-09-04 15:30:00', '2026-09-04 17:00:00', 13, 10),
(17, '2026-09-01 16:00:00', '2026-09-01 18:00:00', 50, 10),
(18, '2026-09-01 15:00:00', '2026-09-01 16:02:00', 52, 10);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(10) NOT NULL,
  `booking_date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `member_id` int(10) NOT NULL,
  `class_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `booking_date`, `status`, `member_id`, `class_id`) VALUES
(1, '2026-09-01', 'Confirmed', 1, 1),
(2, '2026-09-01', 'Confirmed', 2, 2),
(3, '2026-09-02', 'Confirmed', 3, 3),
(4, '2026-09-02', 'Confirmed', 4, 4),
(5, '2026-09-03', 'Confirmed', 5, 5),
(6, '2026-09-03', 'Confirmed', 6, 6),
(7, '2026-09-04', 'Confirmed', 7, 7),
(8, '2026-09-04', 'Confirmed', 8, 8),
(11, '2026-09-09', 'Confirmed', 16, 9);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(10) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `class_date` date NOT NULL,
  `start_time` time NOT NULL,
  `capacity` int(20) NOT NULL,
  `trainer_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `class_date`, `start_time`, `capacity`, `trainer_id`) VALUES
(1, 'Morning Yoga', '2026-09-05', '08:00:00', 20, 1),
(2, 'Weight Training', '2026-09-06', '10:00:00', 15, 2),
(3, 'Cardio Blast', '2026-09-07', '09:00:00', 25, 3),
(4, 'CrossFit Basics', '2026-09-08', '17:00:00', 15, 4),
(5, 'Pilates', '2026-09-09', '11:00:00', 20, 5),
(6, 'Fitness Training', '2026-09-10', '16:00:00', 20, 6),
(7, 'Boxing Training', '2026-09-11', '18:00:00', 12, 7),
(8, 'Zumba', '2026-09-12', '17:30:00', 25, 8),
(9, 'Nutrition Workshop', '2026-09-13', '12:00:00', 30, 9),
(10, 'Personal Training', '2026-09-14', '15:00:00', 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(10) NOT NULL COMMENT 'pk',
  `gender` varchar(10) NOT NULL,
  `birth_date` date NOT NULL,
  `join_date` date NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `gender`, `birth_date`, `join_date`, `user_id`, `created_at`) VALUES
(1, 'Male', '1998-03-12', '2026-08-01', 15, '2026-09-04 19:12:51'),
(2, 'Male', '1997-07-20', '2026-08-03', 16, '2026-09-04 19:12:51'),
(3, 'Male', '2000-01-15', '2026-08-05', 17, '2026-09-04 19:12:51'),
(4, 'Male', '1996-11-10', '2026-08-07', 18, '2026-09-04 19:12:51'),
(5, 'Male', '1999-05-25', '2026-08-10', 19, '2026-09-04 19:12:51'),
(6, 'Female', '2001-02-18', '2026-08-12', 20, '2026-09-04 19:12:51'),
(7, 'Female', '1998-09-30', '2026-08-14', 21, '2026-09-04 19:12:51'),
(8, 'Female', '2000-06-11', '2026-08-16', 22, '2026-09-04 19:12:51'),
(16, 'Female', '1988-03-01', '2026-09-06', 50, '2026-09-06 16:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `membership_id` int(10) NOT NULL,
  `membership_name` varchar(100) NOT NULL,
  `duration` int(3) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`membership_id`, `membership_name`, `duration`, `price`, `description`) VALUES
(1, 'Basic', 1, 25.00, 'Basic gym access'),
(2, 'Standard', 3, 65.00, 'Gym access with fitness programs'),
(3, 'Premium', 6, 110.00, 'Gym access with classes'),
(4, 'VIP', 12, 200.00, 'Full gym access with premium services'),
(5, 'Student', 3, 50.00, 'Discount membership for students'),
(6, 'Couple', 3, 120.00, 'Membership for two people'),
(7, 'Family', 6, 250.00, 'Family gym membership'),
(8, 'Annual VIP', 12, 300.00, 'Premium annual membership'),
(9, 'Fitness', 1, 40.00, 'Fitness and cardio access'),
(10, 'Elite', 12, 400.00, 'Elite membership with premium services');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(10) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(30) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `subscription_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `payment_date`, `amount`, `payment_method`, `payment_status`, `subscription_id`) VALUES
(1, '2026-08-01', 25.00, 'Cash', 'Paid', 1),
(2, '2026-08-02', 65.00, 'Card', 'Paid', 2),
(3, '2026-08-05', 110.00, 'Cash', 'Paid', 3),
(4, '2026-08-07', 200.00, 'Card', 'Paid', 4),
(5, '2026-08-10', 50.00, 'Cash', 'Paid', 5),
(6, '2026-08-12', 120.00, 'Bank Transfer', 'Paid', 6),
(7, '2026-08-14', 250.00, 'Card', 'Paid', 7),
(8, '2026-08-16', 300.00, 'Cash', 'Paid', 8);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`, `description`) VALUES
(1, 'manage_users', 'Manage system users'),
(2, 'manage_managers', 'Manage managers'),
(3, 'manage_trainers', 'Manage trainers'),
(4, 'manage_members', 'Manage members'),
(5, 'manage_classes', 'Manage classes'),
(6, 'manage_bookings', 'Manage bookings'),
(7, 'manage_subscriptions', 'Manage subscriptions'),
(8, 'manage_payments', 'Manage payments'),
(9, 'manage_attendance', 'Manage attendance');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `profile_id` int(11) NOT NULL,
  `profile_name` varchar(20) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profile_id`, `profile_name`, `description`) VALUES
(1, 'admin', 'Super Administrator'),
(2, 'manager', 'Manager'),
(3, 'trainer', 'Trainer'),
(4, 'member', 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `profile_permissions`
--

CREATE TABLE `profile_permissions` (
  `profile_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_permissions`
--

INSERT INTO `profile_permissions` (`profile_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(3, 5),
(3, 6),
(3, 9),
(4, 6),
(4, 9);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `subscription_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `membership_id` int(10) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`subscription_id`, `member_id`, `membership_id`, `start_date`, `end_date`, `status`) VALUES
(1, 1, 1, '2026-08-01', '2026-09-01', 'Active'),
(2, 2, 2, '2026-08-02', '2026-11-02', 'Active'),
(3, 3, 3, '2026-08-05', '2027-02-05', 'Active'),
(4, 4, 4, '2026-08-07', '2027-08-07', 'Active'),
(5, 5, 5, '2026-08-10', '2026-11-10', 'Active'),
(6, 6, 6, '2026-08-12', '2026-11-12', 'Active'),
(7, 7, 7, '2026-08-14', '2027-02-14', 'Active'),
(8, 8, 8, '2026-08-16', '2027-08-16', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `trainer_id` int(10) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `hire_date` date NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `user_id` int(10) NOT NULL,
  `birth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`trainer_id`, `specialty`, `hire_date`, `salary`, `user_id`, `birth_date`) VALUES
(1, 'Yoga', '2026-01-10', 800.00, 5, '1992-03-15'),
(2, 'Weightlifting', '2026-01-15', 950.00, 6, '1990-07-20'),
(3, 'Cardio', '2026-02-01', 850.00, 7, '1993-05-12'),
(4, 'CrossFit', '2026-02-10', 1000.00, 8, '1989-11-08'),
(5, 'Pilates', '2026-02-15', 900.00, 9, '1991-02-25'),
(6, 'Fitness', '2026-03-01', 820.00, 10, '1994-06-18'),
(7, 'Boxing', '2026-03-05', 1100.00, 11, '1988-09-14'),
(8, 'Zumba', '2026-03-15', 780.00, 12, '1995-01-30'),
(9, 'Nutrition', '2026-04-01', 1200.00, 13, '1987-12-22'),
(10, 'Personal Training', '2026-04-10', 1050.00, 14, '1990-04-10'),
(17, 'Crossfit', '2026-09-08', 750.00, 52, '2003-02-02'),
(19, 'Karate', '2026-09-10', 500.00, 54, '1998-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL COMMENT 'pk',
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `profile_id` int(10) DEFAULT 4,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `role`, `profile_id`, `phone`, `email`, `status`, `image`) VALUES
(1, 'System Administrator', 'admin', '$2y$12$UrMJIeGEis2b3KgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'admin', 1, '777000000', 'admin@pulsefit.com', 'active', ''),
(2, 'Hanan', 'Hanan', '$2y$12$UrMJIeGEis2b3KgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Manager', 2, '777999888', 'Hanan@gmail.com', 'active', ''),
(4, 'Kawther', 'Kawther', '$2y$12$UrMJIeGEis2b3KgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Manager', 2, '777444111', 'Kawther@gmail.com', 'active', 'user_1c5ec6edb6a4a5e6.jpg'),
(5, 'Ahmed Ali', 'ahmed.trainer', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Trainer', 3, '777100001', 'ahmed@pulsefit.com', 'active', ''),
(6, 'Mohammed Hassan', 'mohammed.trainer', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Trainer', 3, '777100002', 'mohammed@pulsefit.com', 'active', ''),
(7, 'Omar Saleh', 'omar.trainer', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Trainer', 3, '777100003', 'omar@pulsefit.com', 'active', ''),
(8, 'Khaled Ahmed', 'khaled.trainer', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Trainer', 3, '777100004', 'khaled@pulsefit.com', 'active', ''),
(9, 'Yousef Ali', 'yousef.trainer', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Trainer', 3, '777100005', 'yousef@pulsefit.com', 'active', ''),
(10, 'Sara Mohammed', 'sara.trainer', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Trainer', 3, '777100006', 'sara@pulsefit.com', 'active', ''),
(11, 'Noura Ahmed', 'noura.trainer', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Trainer', 3, '777100007', 'noura@pulsefit.com', 'active', ''),
(12, 'Laila Hassan', 'laila.trainer', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Trainer', 3, '777100008', 'laila@pulsefit.com', 'active', ''),
(13, 'Mona Saleh', 'mona.trainer', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Trainer', 3, '777100009', 'mona@pulsefit.com', 'active', ''),
(14, 'Reem Ali', 'reem.trainer', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Trainer', 3, '777100010', 'reem@pulsefit.com', 'active', ''),
(15, 'Ali Abdullah', 'ali.member', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Member', 4, '777200001', 'ali@pulsefit.com', 'active', ''),
(16, 'Hassan Ahmed', 'hassan.member', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Member', 4, '777200002', 'hassan@pulsefit.com', 'active', ''),
(17, 'Ibrahim Saleh', 'ibrahim.member', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Member', 4, '777200003', 'ibrahim@pulsefit.com', 'active', ''),
(18, 'Fahad Mohammed', 'fahad.member', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Member', 4, '777200004', 'fahad@pulsefit.com', 'active', ''),
(19, 'Salem Ali', 'salem.member', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Member', 4, '777200005', 'salem@pulsefit.com', 'active', ''),
(20, 'Aisha Mohammed', 'aisha.member', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Member', 4, '777200006', 'aisha@pulsefit.com', 'active', ''),
(21, 'Fatima Ahmed', 'fatima.member', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Member', 4, '777200007', 'fatima@pulsefit.com', 'active', ''),
(22, 'Noor Hassan', 'noor.member', '$2y$12$UrMJIeGEis2bKgGkMJECuRQrI7jk7TFIEDOeRfy7I1jXaSM4gGMi', 'Member', 4, '777200008', 'noor@pulsefit.com', 'active', ''),
(50, 'Nazmiah', 'nazi', '$2y$10$x.g2XWnA42446kY7tP8zf.yCkv3k86VevaTqu0iBlnmEqu8umBDvC', 'member', 4, '111222333', 'naz@gmail.com', 'active', 'user_706aa7d0a4281fb5.jpg'),
(52, 'Warda', 'warda', '$2y$10$RZoEwgywaVgNxAIGNGoeFeWhH0DgMJn1mdFbLQJ0bofgJfKn2Mv72', 'trainer', 3, '123321231', 'warda@gmail.com', 'Active', ''),
(54, 'Zaid', 'Zaid', '$2y$10$bEDs4X6qFkZ3wQlGGMYHKeVh/KvSmnMmsT3qLo518kRHeIc8OxrWG', 'trainer', 3, '222435654', 'zaid@gmail.com', 'Active', 'user_f00bdf065140d1d1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `fk_attendance_user_id` (`user_id`),
  ADD KEY `fk_attendance_class_id` (`class_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `fk_bookings_member_id` (`member_id`),
  ADD KEY `fk_bookings_class_id` (`class_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `fk_classes_trainer_id` (`trainer_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `fk_members_user_id` (`user_id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`membership_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payments_subscription_id` (`subscription_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `permission_name` (`permission_name`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD UNIQUE KEY `profile_name` (`profile_name`);

--
-- Indexes for table `profile_permissions`
--
ALTER TABLE `profile_permissions`
  ADD PRIMARY KEY (`profile_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`subscription_id`),
  ADD KEY `fk_subscriptions_member_id` (`member_id`),
  ADD KEY `fk_subscriptions_membership_id` (`membership_id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`trainer_id`),
  ADD KEY `fk_trainers_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `profile_id` (`profile_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'pk', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `membership_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `subscription_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `trainer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'pk', AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_class_id` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_attendance_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_bookings_class_id` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `fk_bookings_member_id` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `fk_classes_trainer_id` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`trainer_id`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `fk_members_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_subscription_id` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`subscription_id`);

--
-- Constraints for table `profile_permissions`
--
ALTER TABLE `profile_permissions`
  ADD CONSTRAINT `profile_permissions_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profile_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `fk_subscriptions_member_id` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `fk_subscriptions_membership_id` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`membership_id`);

--
-- Constraints for table `trainers`
--
ALTER TABLE `trainers`
  ADD CONSTRAINT `fk_trainers_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`profile_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
