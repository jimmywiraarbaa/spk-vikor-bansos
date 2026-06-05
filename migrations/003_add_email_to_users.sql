SET @exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'users'
      AND COLUMN_NAME = 'email'
);
SET @sql = IF(@exists = 0,
    'ALTER TABLE users ADD COLUMN email VARCHAR(100) NOT NULL UNIQUE AFTER username',
    'SELECT "Column email already exists, skipping." AS msg'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
