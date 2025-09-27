-- Fix database schema - change INT columns to VARCHAR for proper data storage
-- Run this in your Coolify database to fix the existing table

USE `default`;

-- Modify the personal_data table to fix column types
ALTER TABLE `personal_data` 
  MODIFY COLUMN `phone` VARCHAR(20) NOT NULL,
  MODIFY COLUMN `tele` VARCHAR(20) NOT NULL, 
  MODIFY COLUMN `zip` VARCHAR(10) NOT NULL,
  MODIFY COLUMN `zip2` VARCHAR(10) NOT NULL,
  MODIFY COLUMN `tin` VARCHAR(20) NOT NULL;

-- Verify the changes
DESCRIBE `personal_data`;
