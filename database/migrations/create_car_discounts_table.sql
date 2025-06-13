CREATE TABLE IF NOT EXISTS `car_discounts` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `car_id` INT(11) UNSIGNED NOT NULL,
  `discount_day` VARCHAR(10) NOT NULL COMMENT 'Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday',
  `discount_percentage` DECIMAL(5,2) NOT NULL DEFAULT 10.00,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_car_discounts_car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 