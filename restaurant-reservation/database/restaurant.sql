CREATE DATABASE IF NOT EXISTS restaurant_mvc
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE restaurant_mvc;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL
);

CREATE TABLE restaurant_tables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_number VARCHAR(10) NOT NULL UNIQUE,
    capacity INT NOT NULL,
    is_active TINYINT(1) DEFAULT 1
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    table_id INT NOT NULL,
    user_id INT NOT NULL,
    guest_count INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    status VARCHAR(20) DEFAULT 'confirmed',
    notes TEXT,

    FOREIGN KEY (table_id)
        REFERENCES restaurant_tables(id),

    FOREIGN KEY (user_id)
        REFERENCES users(id)
);

INSERT INTO restaurant_tables (table_number, capacity)
VALUES
('T01', 2),
('T02', 2),
('T03', 4),
('T04', 4),
('T05', 6),
('T06', 6),
('T07', 8),
('T08', 8);


INSERT INTO users (username, password, full_name)
VALUES (
    'admin',
    '$2y$12$BVa7avg1jxQZzVSNuOyXmO3e7QJ5a0kyTGFeEbuLIhOWkK6gchW3W',
    'Restaurant Administrator'
);
