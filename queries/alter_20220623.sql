-- These changes has been applied to prod

CREATE TABLE `tbl_reminders` (
  `reminder_id` INT NOT NULL AUTO_INCREMENT,
  `flight_id` INT NULL,
  `current_status` VARCHAR(45) NULL,
  `telegram_chat_id` VARCHAR(45) NULL,
  `stop_reminder` TINYINT(4) NULL,
  `scheduled_dt` DATETIME NULL,
  PRIMARY KEY (`reminder_id`));
