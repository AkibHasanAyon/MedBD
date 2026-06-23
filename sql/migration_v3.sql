-- Migration v3: Adding Stock Management
ALTER TABLE tbl_product ADD COLUMN stock_qty INT NOT NULL DEFAULT 50;
