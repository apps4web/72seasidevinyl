-- Test database schema.
--
-- If you are not using CakePHP migrations you can put
-- your application's schema in this file and use it in tests.

CREATE TABLE IF NOT EXISTS releases (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    artist VARCHAR(255) NOT NULL,
    genre VARCHAR(100) NOT NULL DEFAULT '',
    price DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    color VARCHAR(7) NOT NULL DEFAULT '#000000',
    label_text VARCHAR(20) NOT NULL DEFAULT 'LP',
    in_stock BOOLEAN NOT NULL DEFAULT 1,
    created DATETIME,
    modified DATETIME
);

