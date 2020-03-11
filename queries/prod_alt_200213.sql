ALTER TABLE `departments` ADD `attendance_view` VARCHAR(45) NOT NULL AFTER `email`;
ALTER TABLE `user_meta` DROP `super_manager`;
CREATE TABLE `tth_attendancedb`.`department_map` ( `dept_id` INT(11) NOT NULL , `user_id` INT(11) NOT NULL ) ENGINE = InnoDB;
ALTER TABLE `departments` ADD `isActive` TINYINT(4) NOT NULL AFTER `attendance_view`;
ALTER TABLE `department_map` ADD `send_mail` TINYINT(4) NOT NULL AFTER `user_id`;

ALTER TABLE `documents` ADD `acknowledged` TINYINT(4) NOT NULL AFTER `doc_path`, ADD `created_dt` DATETIME NOT NULL AFTER `acknowledged`;
ALTER TABLE `documents` ADD `acknowledged_by` INT(11) NOT NULL AFTER `acknowledged`;
ALTER TABLE `documents` CHANGE `user_id` `dept_id` INT(11) NOT NULL;
ALTER TABLE `documents` ADD `acknowledged_dt` DATETIME NULL AFTER `acknowledged_by`;

DROP TABLE `tth_attendancedb`.`settings`;
CREATE TABLE `tth_attendancedb`.`settings` ( `ID` INT NOT NULL AUTO_INCREMENT , `field` VARCHAR(255) NOT NULL , `value` VARCHAR(255) NOT NULL , `category` VARCHAR(45) NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB;
ALTER TABLE `settings` CHANGE `value` `value` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

ALTER TABLE `departments` CHANGE `email` `email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, CHANGE `attendance_view` `attendance_view` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

ALTER TABLE `departments` ADD `schedule_view` VARCHAR(45) NOT NULL AFTER `attendance_view`;
ALTER TABLE `departments` CHANGE `schedule_view` `schedule_view` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
