-- Test database schema.
--
-- If you are not using CakePHP migrations you can put
-- your application's schema in this file and use it in tests.

CREATE TABLE IF NOT EXISTS artists (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    bio TEXT,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE IF NOT EXISTS records (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_id INTEGER NOT NULL,
    name VARCHAR(255) NOT NULL,
    cover VARCHAR(255),
    released DATE,
    is_latest BOOLEAN NOT NULL DEFAULT 0,
    price DECIMAL(8,2),
    color VARCHAR(7) DEFAULT '#000000',
    label_text VARCHAR(20) DEFAULT 'LP',
    in_stock BOOLEAN NOT NULL DEFAULT 1,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY (artist_id) REFERENCES artists(id)
);

