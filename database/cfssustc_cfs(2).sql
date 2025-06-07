-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2025 at 05:58 PM
-- Server version: 10.11.10-MariaDB-cll-lve
-- PHP Version: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cfssustc_cfs`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_page`
--

CREATE TABLE `about_page` (
  `id` int(11) NOT NULL,
  `about_text` text NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_page`
--

INSERT INTO `about_page` (`id`, `about_text`, `facebook_link`, `instagram_link`, `email_address`, `created_at`, `updated_at`) VALUES
(1, 'Film emerged from the desire to record and display moving scenes. The first public film screening took place in 1895, presented by the Lumière brothers. Since then, cinema has evolved into a rich and complex art form that integrates various artistic disciplines. To preserve and study this growing medium, the British Film Society was founded in the early 20th century.\\r\\nContinuing this tradition, the ‘Bangladesh Film Society’ was established in Dhaka in 1964. In the spirit of this movement, ‘Chokh Film Society’ was founded on August 29, 1996, at Shahjalal University of Science and Technology (SUST), with a commitment to progressive thought and meaningful film practice. As the university’s only film-related organization, it has extended its activities beyond campus, making a lasting impact on the cultural scene of Sylhet city from the very beginning.\\r\\nOver the past 27 years, the society has gained national recognition for promoting diversity and cultural engagement through film screenings, study circles, publications, cine-addas, and creative workshops. With more than 600 domestic and international films showcased, it has consistently provided a platform for film appreciation and intellectual exchange.\\r\\nIn addition to screenings, the organization offers regular workshops and hands-on training in filmmaking, helping nurture new generations of cinephiles and creators. As a long-standing member of the ‘Bangladesh Federation of Film Societies’, it continues to thrive—guided by the insights of respected faculty members, the dedication of alumni, and the passionate involvement of students. With a focus on thoughtful storytelling, community engagement, and cultural diversity, the journey of this film society is a testament to the power of cinema in shaping awareness and inspiring change.', 'https://www.facebook.com/cfssust', 'https://www.instagram.com/cfs_sust/?hl=en', 'cfs@sust.edu', '2025-05-10 05:31:23', '2025-05-31 04:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'letslivelife13@@%', '2025-05-02 21:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `advisors`
--

CREATE TABLE `advisors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `from_year` int(11) DEFAULT NULL,
  `to_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advisors`
--

INSERT INTO `advisors` (`id`, `name`, `designation`, `image_path`, `message`, `created_at`, `from_year`, `to_year`) VALUES
(7, 'test', 'teest', 'assets/uploads/advisors/6841d4a292ce9.png', 'test', '2025-06-05 17:32:18', 2022, 2025);

-- --------------------------------------------------------

--
-- Table structure for table `committee_members`
--

CREATE TABLE `committee_members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `post` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committee_members`
--

INSERT INTO `committee_members` (`id`, `name`, `post`, `year`, `image_path`, `created_at`) VALUES
(5, 'Test', 'Test', 2023, 'assets/uploads/committee/683820b68a350.jpg', '2025-05-29 08:54:14'),
(8, 'Imtiaz Hossain', 'President', 2024, 'assets/uploads/committee/683a7e04e34b2.jpg', '2025-05-31 03:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `location` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `map_embed_url` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `location`, `email`, `phone`, `facebook_link`, `instagram_link`, `map_embed_url`, `created_at`, `updated_at`) VALUES
(1, 'Shahjalal University of Science and Technology, Sylhet 3114, Bangladesh', 'cfs@sust.edu', '+8801768750214', 'https://www.facebook.com/cfssust', 'https://instagram.com/chokhfilmsociety', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.8274566013213!2d91.83075931500685!3d24.91745498400939!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3750552bc91107d1%3A0x6e2a32d2bb0e5096!2sShahjalal%20University%20of%20Science%20and%20Technology!5e0!3m2!1sen!2sbd!4v1625147000000!5m2!1sen!2sbd', '2025-05-10 05:36:54', '2025-05-30 04:30:42');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `created_at`) VALUES
(9, 'testtt55', 'test tfd', '2025-05-06', '2025-05-31 08:47:58');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `caption` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `event_id`, `image_path`, `caption`, `created_at`) VALUES
(12, 9, 'assets/uploads/495347248_4177990852472063_8539128445382248675_n.jpg', 'test', '2025-05-31 08:48:12'),
(15, 9, 'assets/uploads/Screenshot_2025-06-04-13-51-26-76_a23b203fd3aafc6dcb84e438dda678b6.jpg', 'Test', '2025-06-05 14:06:16'),
(16, 9, '../uploads/gallery/495347248_4177990852472063_8539128445382248675_n.jpg', 'test', '2025-06-05 17:03:49'),
(17, 9, '../uploads/gallery/6841ce629f399.jpg', 'test', '2025-06-05 17:05:38'),
(21, 9, 'assets/uploads/Black and Blue Modern Digital Marketing Facebook Cover.png', 'test', '2025-06-05 18:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `name`, `logo_path`, `website_url`, `description`, `created_at`) VALUES
(5, 'Ideal Tech Ltd', 'assets/uploads/sponsors/683b31fd365e4.png', 'https://idealtechltd.com/', '🎬 IdealTech Ltd. is Proud to Sponsor Chokh Film Society – SUST 🎬 At IdealTech Ltd., we believe in empowering communities, inspiring creativity, and fostering progressive thought — values that align deeply with Chokh Film Society’s mission.', '2025-05-31 16:44:45');

-- --------------------------------------------------------

--
-- Table structure for table `writings`
--

CREATE TABLE `writings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` enum('story','portal','writing') NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `writings`
--

INSERT INTO `writings` (`id`, `title`, `content`, `category`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 'story', 'assets/uploads/writings/6841da39d6689.jpg', '2025-06-05 17:56:09', '2025-06-05 17:56:09'),
(2, 'test', 'test', 'portal', 'assets/uploads/writings/684349e1991d2.png', '2025-06-06 20:04:49', '2025-06-06 20:04:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_page`
--
ALTER TABLE `about_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `advisors`
--
ALTER TABLE `advisors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `committee_members`
--
ALTER TABLE `committee_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `writings`
--
ALTER TABLE `writings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_page`
--
ALTER TABLE `about_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `advisors`
--
ALTER TABLE `advisors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `committee_members`
--
ALTER TABLE `committee_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `writings`
--
ALTER TABLE `writings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
