-- Restaurant Reservation System - sample data
USE restaurant_mvc;

SET @staff_id = (SELECT MIN(id) FROM users);

START TRANSACTION;

DELETE FROM reservations;
DELETE FROM restaurant_tables;

INSERT INTO restaurant_tables (table_number, capacity, is_active) VALUES
('T01', 2, 1),
('T02', 2, 1),
('T03', 4, 1),
('T04', 4, 1),
('T05', 4, 1),
('T06', 6, 1),
('T07', 6, 1),
('T08', 8, 1),
('T09', 8, 1),
('T10', 4, 0);


INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Nimal Fernando', '0700000001', id, @staff_id, 2,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 0 DAY), '12:00:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 0 DAY), '13:30:00'),
       'confirmed', 'Phone booking'
FROM restaurant_tables WHERE table_number = 'T01';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Kavindi Perera', '0700000002', id, @staff_id, 3,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 0 DAY), '18:00:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 0 DAY), '19:30:00'),
       'confirmed', 'Walk-in enquiry'
FROM restaurant_tables WHERE table_number = 'T03';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Dinuka Silva', '0700000003', id, @staff_id, 2,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '12:30:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '14:00:00'),
       'confirmed', 'Window seat requested'
FROM restaurant_tables WHERE table_number = 'T02';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Hasini Jayawardena', '0700000004', id, @staff_id, 4,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '18:30:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '20:00:00'),
       'confirmed', 'Birthday dinner'
FROM restaurant_tables WHERE table_number = 'T04';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Akila Senanayake', '0700000005', id, @staff_id, 3,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 2 DAY), '13:00:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 2 DAY), '14:30:00'),
       'confirmed', 'Phone booking'
FROM restaurant_tables WHERE table_number = 'T05';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Sanduni Kumari', '0700000006', id, @staff_id, 5,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 2 DAY), '19:00:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 2 DAY), '20:30:00'),
       'confirmed', 'Family dinner'
FROM restaurant_tables WHERE table_number = 'T06';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Ravindu Wijesinghe', '0700000007', id, @staff_id, 6,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 3 DAY), '12:00:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 3 DAY), '13:30:00'),
       'confirmed', 'Group reservation'
FROM restaurant_tables WHERE table_number = 'T07';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Dilmi Herath', '0700000008', id, @staff_id, 7,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 3 DAY), '18:00:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 3 DAY), '19:30:00'),
       'confirmed', 'Anniversary dinner'
FROM restaurant_tables WHERE table_number = 'T08';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Tharindu Bandara', '0700000009', id, @staff_id, 8,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 4 DAY), '19:00:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 4 DAY), '20:30:00'),
       'confirmed', 'Team dinner'
FROM restaurant_tables WHERE table_number = 'T09';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Isuri Madushani', '0700000010', id, @staff_id, 2,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 5 DAY), '18:30:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 5 DAY), '20:00:00'),
       'confirmed', 'Phone booking'
FROM restaurant_tables WHERE table_number = 'T01';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Pasindu Rathnayake', '0700000011', id, @staff_id, 2,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '18:00:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '19:30:00'),
       'cancelled', 'Cancelled by phone'
FROM restaurant_tables WHERE table_number = 'T03';

INSERT INTO reservations
(customer_name, customer_phone, table_id, user_id, guest_count, start_time, end_time, status, notes)
SELECT 'Shenali de Silva', '0700000012', id, @staff_id, 4,
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 4 DAY), '12:00:00'),
       TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL 4 DAY), '13:30:00'),
       'cancelled', 'Customer changed plans'
FROM restaurant_tables WHERE table_number = 'T06';

COMMIT;

SELECT COUNT(*) AS total_tables, SUM(is_active) AS active_tables FROM restaurant_tables;
SELECT status, COUNT(*) AS reservation_count FROM reservations GROUP BY status;
SELECT COUNT(*) AS todays_reservations FROM reservations
WHERE DATE(start_time) = CURDATE() AND status != 'cancelled';
