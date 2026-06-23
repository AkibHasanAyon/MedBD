-- Migration v4: Adding OTP Verification Fields
ALTER TABLE tbl_customer ADD COLUMN is_verified TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE tbl_customer ADD COLUMN otp_code VARCHAR(10) DEFAULT NULL;
ALTER TABLE tbl_customer ADD COLUMN otp_expires_at DATETIME DEFAULT NULL;

-- Automatically mark existing users as verified so they are not locked out
UPDATE tbl_customer SET is_verified = 1;
