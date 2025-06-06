<?php

/**
 * Discount Helper Functions
 */

if (!function_exists('is_discount_day')) {
    /**
     * Check if today is a discount day for the given car
     *
     * @param int $carId The car ID
     * @param string|null $day Specific day to check (default: today)
     * @return bool
     */
    function is_discount_day($carId, $day = null)
    {
        $carDiscountModel = new \App\Models\CarDiscountModel();
        
        if ($day === null) {
            $day = date('l'); // Get current day name (Monday, Tuesday, etc.)
        }
        
        return $carDiscountModel->hasDiscountOnDay($carId, $day);
    }
}

if (!function_exists('get_discount_percentage')) {
    /**
     * Get the discount percentage for a car on a specific day
     *
     * @param int $carId The car ID
     * @param string|null $day Specific day to check (default: today)
     * @return float The discount percentage (e.g. 10.00)
     */
    function get_discount_percentage($carId, $day = null)
    {
        $carDiscountModel = new \App\Models\CarDiscountModel();
        
        if ($day === null) {
            $day = date('l'); // Get current day name (Monday, Tuesday, etc.)
        }
        
        if ($carDiscountModel->hasDiscountOnDay($carId, $day)) {
            return $carDiscountModel->getDiscountPercentage($carId, $day);
        }
        
        return 0;
    }
}

if (!function_exists('get_discounted_price')) {
    /**
     * Calculate discounted price for a car
     *
     * @param array $car Car data array with daily_rate
     * @param float $multiplier Price multiplier (0.5, 0.75, etc.)
     * @param string|null $day Specific day to check (default: today)
     * @return float
     */
    function get_discounted_price($car, $multiplier = 1.0, $day = null)
    {
        $originalPrice = $car['daily_rate'] * $multiplier;
        
        if (is_discount_day($car['id'], $day)) {
            $percentage = get_discount_percentage($car['id'], $day);
            return $originalPrice * (1 - ($percentage / 100));
        }
        
        return $originalPrice;
    }
}

if (!function_exists('get_discount_days_for_car')) {
    /**
     * Get all discount days for a specific car
     *
     * @param int $carId The car ID
     * @return array Array of discount days
     */
    function get_discount_days_for_car($carId)
    {
        $carDiscountModel = new \App\Models\CarDiscountModel();
        $discounts = $carDiscountModel->getCarDiscountDays($carId);
        
        $days = [];
        foreach ($discounts as $discount) {
            $days[] = $discount['discount_day'];
        }
        
        return $days;
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format a price as Indonesian currency (Rupiah)
     *
     * @param float $price The price to format
     * @return string
     */
    function format_currency($price)
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
} 