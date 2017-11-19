-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2017 at 11:08 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(3) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(3) NOT NULL,
  `post_id` int(3) NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(3) NOT NULL,
  `category_id` int(3) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `image` text NOT NULL,
  `content` text NOT NULL,
  `tags` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `image`, `role`, `status`, `token`) VALUES
(16, 'admin', '$2y$10$yidKryG1cpMi7BkCCCLS2Op1.aDi.Et5kriLAILi.KdXfq0RJQlgu', 'first_name', 'last_name', 'konstadinoschr@windowslive.com', '', 'admin', 'approved', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
