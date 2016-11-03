-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2016 at 07:24 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examroutine`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `building_id` int(11) NOT NULL,
  `building_name` varchar(45) DEFAULT NULL COMMENT 'Such as Academic Building - A ,IIT Bulding etc',
  `building_code` varchar(10) DEFAULT NULL COMMENT 'such as : A , B , A-Ext'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_code` varchar(30) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `session` int(11) NOT NULL,
  `offering_dept` varchar(30) NOT NULL,
  `accepting_dept` varchar(30) NOT NULL,
  `general_type_id` int(11) NOT NULL,
  `credit` decimal(2,1) NOT NULL,
  `hour` int(11) DEFAULT NULL,
  `credit_hour` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains course information';

-- --------------------------------------------------------

--
-- Table structure for table `course_reg`
--

CREATE TABLE `course_reg` (
  `course_reg_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(30) NOT NULL,
  `dept_code` varchar(30) NOT NULL,
  `building_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains information about dept.';

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `desig_id` int(11) NOT NULL,
  `desig_name` varchar(50) NOT NULL,
  `desig_desc` varchar(200) DEFAULT NULL COMMENT 'deisgnation description'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Designation of instructor';

-- --------------------------------------------------------

--
-- Table structure for table `exam_routine`
--

CREATE TABLE `exam_routine` (
  `exam_routine_id` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `time` time DEFAULT '09:30:00',
  `room_1_id` int(11) NOT NULL,
  `room_2_id` int(11) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `course_code` varchar(30) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `dept` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `general_type`
--

CREATE TABLE `general_type` (
  `general_type_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invigilators`
--

CREATE TABLE `invigilators` (
  `i_id` int(11) NOT NULL,
  `exam_routine_id` int(11) NOT NULL,
  `chief_invigilator` int(20) NOT NULL,
  `invigilator1` int(20) NOT NULL,
  `invigilator2` int(20) NOT NULL,
  `invigilator3` int(20) DEFAULT NULL,
  `invigilator4` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_num` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `general_type_id` int(11) NOT NULL,
  `hour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` bigint(20) NOT NULL,
  `registration_no` int(11) NOT NULL,
  `email_no` varchar(30) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `contact_no` varchar(30) NOT NULL,
  `Address` varchar(90) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `marital_status` varchar(30) DEFAULT NULL,
  `blood_group` varchar(30) DEFAULT NULL,
  `religion` varchar(30) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains about student information';

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `instructor_id` int(20) NOT NULL,
  `employee_code` varchar(30) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `desig_id` int(11) NOT NULL,
  `is_permanent` tinyint(1) NOT NULL,
  `email` varchar(30) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `contact_no` bigint(18) NOT NULL,
  `full_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains about instructor details.';

-- --------------------------------------------------------

--
-- Table structure for table `teaches`
--

CREATE TABLE `teaches` (
  `teaches_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `instructor_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`building_id`),
  ADD UNIQUE KEY `building_idx_unique` (`building_name`,`building_code`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_unique` (`course_code`,`offering_dept`,`accepting_dept`,`session`,`course_title`),
  ADD KEY `general_type_course_fk1` (`general_type_id`) USING BTREE;

--
-- Indexes for table `course_reg`
--
ALTER TABLE `course_reg`
  ADD PRIMARY KEY (`course_reg_id`),
  ADD UNIQUE KEY `course_reg_unique` (`student_id`,`course_id`),
  ADD KEY `course_course_reg_fk` (`course_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`),
  ADD UNIQUE KEY `department_unique` (`dept_code`,`dept_name`),
  ADD KEY `department_building_fk` (`building_id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`desig_id`),
  ADD UNIQUE KEY `designation_unique` (`desig_name`);

--
-- Indexes for table `exam_routine`
--
ALTER TABLE `exam_routine`
  ADD PRIMARY KEY (`exam_routine_id`),
  ADD KEY `course_id_fk` (`course_id`);

--
-- Indexes for table `general_type`
--
ALTER TABLE `general_type`
  ADD PRIMARY KEY (`general_type_id`),
  ADD UNIQUE KEY `general_type_idx_unique` (`type`);

--
-- Indexes for table `invigilators`
--
ALTER TABLE `invigilators`
  ADD PRIMARY KEY (`i_id`),
  ADD KEY `exam_routine_id_fk` (`exam_routine_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_idx_unique` (`room_num`,`building_id`),
  ADD KEY `general_type_room_fk` (`general_type_id`),
  ADD KEY `building_room_fk` (`building_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_idx_unique` (`registration_no`),
  ADD KEY `department_student_fk` (`dept_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`instructor_id`),
  ADD UNIQUE KEY `teacher_unique` (`employee_code`,`dept_id`),
  ADD KEY `designation_teacher_fk` (`desig_id`),
  ADD KEY `department_teacher_fk` (`dept_id`);

--
-- Indexes for table `teaches`
--
ALTER TABLE `teaches`
  ADD PRIMARY KEY (`teaches_id`),
  ADD UNIQUE KEY `teaches_unique` (`course_id`,`instructor_id`),
  ADD KEY `teacher_teaches_fk` (`instructor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `course_reg`
--
ALTER TABLE `course_reg`
  MODIFY `course_reg_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2041;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `desig_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `exam_routine`
--
ALTER TABLE `exam_routine`
  MODIFY `exam_routine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `general_type`
--
ALTER TABLE `general_type`
  MODIFY `general_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `invigilators`
--
ALTER TABLE `invigilators`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;
--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `instructor_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `teaches`
--
ALTER TABLE `teaches`
  MODIFY `teaches_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `general_type_course_fk` FOREIGN KEY (`general_type_id`) REFERENCES `general_type` (`general_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `course_reg`
--
ALTER TABLE `course_reg`
  ADD CONSTRAINT `course_course_reg_fk` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `student_course_reg_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_building_fk` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `exam_routine`
--
ALTER TABLE `exam_routine`
  ADD CONSTRAINT `course_id_fk` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invigilators`
--
ALTER TABLE `invigilators`
  ADD CONSTRAINT `exam_routine_id_fk` FOREIGN KEY (`exam_routine_id`) REFERENCES `exam_routine` (`exam_routine_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `building_room_fk` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `general_type_room_fk` FOREIGN KEY (`general_type_id`) REFERENCES `general_type` (`general_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `department_student_fk` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `department_teacher_fk` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `designation_teacher_fk` FOREIGN KEY (`desig_id`) REFERENCES `designation` (`desig_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `teaches`
--
ALTER TABLE `teaches`
  ADD CONSTRAINT `course_teaches_fk` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `teacher_teaches_fk` FOREIGN KEY (`instructor_id`) REFERENCES `teacher` (`instructor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
