/* to maintain school fee class wise */
CREATE TABLE `school_fee` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `class_id` int(11) NOT NULL,
 `fee_type` int(11) NOT NULL,
 `fee_amount` float NOT NULL,
 `fee_status` int(3) NOT NULL DEFAULT 1,
 `created_by` varchar(100) DEFAULT NULL,
 `created_on` date NOT NULL,
 `updated_by` varchar(100) DEFAULT NULL,
 `updated_on` datetime DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `school_fee` ADD `school_id` INT(11) NOT NULL AFTER `id`; 

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `attendance_status` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(100) DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `attendance` ADD `attendance_date` DATE NULL DEFAULT NULL AFTER `updated_by`; 
