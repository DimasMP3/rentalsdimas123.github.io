-- Add attachment column to orders table
ALTER TABLE orders ADD COLUMN attachment VARCHAR(255) NULL AFTER payment_proof; 