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