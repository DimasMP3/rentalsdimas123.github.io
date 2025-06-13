-- Assuming car IDs 1, 2, 3 exist
-- Car 1 has discounts on Monday and Friday
INSERT INTO `car_discounts` (`car_id`, `discount_day`, `discount_percentage`, `created_at`, `updated_at`)
VALUES
(1, 'Monday', 10.00, NOW(), NOW()),
(1, 'Friday', 10.00, NOW(), NOW());

-- Car 2 has discounts on Wednesday and Sunday
INSERT INTO `car_discounts` (`car_id`, `discount_day`, `discount_percentage`, `created_at`, `updated_at`)
VALUES
(2, 'Wednesday', 10.00, NOW(), NOW()),
(2, 'Sunday', 10.00, NOW(), NOW());

-- Car 3 has discounts on Saturday
INSERT INTO `car_discounts` (`car_id`, `discount_day`, `discount_percentage`, `created_at`, `updated_at`)
VALUES
(3, 'Saturday', 10.00, NOW(), NOW()); 