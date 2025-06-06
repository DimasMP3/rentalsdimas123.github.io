-- Add missing columns to payments table
ALTER TABLE payments 
ADD COLUMN bank_name VARCHAR(50) NULL AFTER payment_method,
ADD COLUMN ewallet_provider VARCHAR(50) NULL AFTER bank_name,
ADD COLUMN paylater_provider VARCHAR(50) NULL AFTER ewallet_provider,
ADD COLUMN minimarket_provider VARCHAR(50) NULL AFTER paylater_provider; 