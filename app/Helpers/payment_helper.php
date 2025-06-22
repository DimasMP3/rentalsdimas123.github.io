<?php

/**
 * Payment Method Helper Functions
 * 
 * Helper functions related to payment methods
 */

if (!function_exists('detect_payment_method')) {
    /**
     * Detect payment method from a payment record
     * 
     * @param array $payment Payment record
     * @return array Payment method info with keys: method, provider
     */
    function detect_payment_method($payment)
    {
        $result = [
            'method' => '',
            'provider' => ''
        ];
        
        if (!$payment) {
            return $result;
        }
        
        // Try to get payment method directly
        if (!empty($payment['payment_method'])) {
            $result['method'] = $payment['payment_method'];
            
            // Get provider details based on payment method
            if ($result['method'] == 'bank_transfer' && !empty($payment['bank_name'])) {
                $result['provider'] = $payment['bank_name'];
            } elseif (($result['method'] == 'e_wallet' || $result['method'] == 'ewallet') && !empty($payment['ewallet_provider'])) {
                $result['provider'] = $payment['ewallet_provider'];
            } elseif ($result['method'] == 'paylater' && !empty($payment['paylater_provider'])) {
                $result['provider'] = $payment['paylater_provider'];
            } elseif ($result['method'] == 'minimarket' && !empty($payment['minimarket_provider'])) {
                $result['provider'] = $payment['minimarket_provider'];
            }
        }
        // Fallback to detecting method by provider fields
        else {
            if (!empty($payment['bank_name'])) {
                $result['method'] = 'bank_transfer';
                $result['provider'] = $payment['bank_name'];
            } elseif (!empty($payment['ewallet_provider'])) {
                $result['method'] = 'e_wallet';
                $result['provider'] = $payment['ewallet_provider'];
            } elseif (!empty($payment['paylater_provider'])) {
                $result['method'] = 'paylater';
                $result['provider'] = $payment['paylater_provider'];
            } elseif (!empty($payment['minimarket_provider'])) {
                $result['method'] = 'minimarket';
                $result['provider'] = $payment['minimarket_provider'];
            }
        }
        
        return $result;
    }
}

if (!function_exists('format_payment_method')) {
    /**
     * Format payment method for display
     * 
     * @param array|string $paymentMethodData Payment method data from detect_payment_method() or string payment method
     * @param bool $includeProvider Whether to include provider info
     * @return string Formatted payment method
     */
    function format_payment_method($paymentMethodData, $includeProvider = true)
    {
        // If string was passed instead of array
        if (is_string($paymentMethodData)) {
            return ucfirst(str_replace('_', ' ', $paymentMethodData));
        }
        
        if (empty($paymentMethodData['method'])) {
            return '-';
        }
        
        $formattedMethod = ucfirst(str_replace('_', ' ', $paymentMethodData['method']));
        
        if ($includeProvider && !empty($paymentMethodData['provider'])) {
            $formattedMethod .= ' (' . strtoupper($paymentMethodData['provider']) . ')';
        }
        
        return $formattedMethod;
    }
}

if (!function_exists('fix_payment_method')) {
    /**
     * Fix payment method in database
     * 
     * @param mixed $paymentId Payment ID or order ID
     * @param string $idType Type of ID ('payment_id' or 'order_id')
     * @return bool Success flag
     */
    function fix_payment_method($paymentId, $idType = 'payment_id')
    {
        $db = \Config\Database::connect();
        $builder = $db->table('payments');
        
        if ($idType == 'payment_id') {
            $builder->where('id', $paymentId);
        } else {
            $builder->where('order_id', $paymentId);
        }
        
        $payment = $builder->get()->getRowArray();
        
        if (!$payment) {
            return false;
        }
        
        // Skip if payment method is already set
        if (!empty($payment['payment_method'])) {
            return true;
        }
        
        // Determine payment method based on provider fields
        $paymentMethod = '';
        if (!empty($payment['bank_name'])) {
            $paymentMethod = 'bank_transfer';
        } elseif (!empty($payment['ewallet_provider'])) {
            $paymentMethod = 'e_wallet';
        } elseif (!empty($payment['paylater_provider'])) {
            $paymentMethod = 'paylater';
        } elseif (!empty($payment['minimarket_provider'])) {
            $paymentMethod = 'minimarket';
        }
        
        // Update if we found a payment method
        if (!empty($paymentMethod)) {
            return $db->table('payments')
                      ->where('id', $payment['id'])
                      ->update(['payment_method' => $paymentMethod]);
        }
        
        return false;
    }
} 