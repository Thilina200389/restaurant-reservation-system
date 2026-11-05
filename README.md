# Restaurant Reservation System

A web-based Restaurant Reservation System developed using PHP, MySQL, and MVC architecture.

## Technologies Used
- PHP
- MySQL
- HTML, CSS, JavaScript
- WAMP Server

## Installation

1. Copy the project folder to `C:\wamp64\www\restaurant-reservation`.
2. Start Apache and MySQL using WAMP Server.
3. Open phpMyAdmin and import `database/restaurant.sql`.
4. Import `database/sample_data.sql` if sample data is required (optional).
5. Open the application:

   `http://localhost/restaurant-reservation/public/index.php`

## Demo Login

- **Username:** admin
- **Password:** Admin@12345

## Features

- Staff Login and Logout
- Dashboard
- Add and Edit Restaurant Tables
- Activate and Deactivate Tables
- Create and Edit Reservations
- Cancel Reservations
- Search Reservations
- Table Capacity Validation
- Double Booking Prevention

## MVC Structure

- **Models:** Handle database operations and validation.
- **Views:** Display application pages and forms.
- **Controllers:** Process user requests and communicate with Models.
- **Core:** Contains routing and database connection classes.

## Database

The system uses a MySQL database named `restaurant_mvc` with three main tables:

- `users`
- `restaurant_tables`
- `reservations`

The `restaurant.sql` file creates the database structure and demo login. The optional `sample_data.sql` file adds sample restaurant tables and reservations.

**Note:** Importing `sample_data.sql` replaces existing reservation and restaurant table records. Back up existing data before importing.

## Development Note

This project is intended for local development and demonstration with WAMP. The included `admin` account is for local testing only. Change the default credentials and database configuration before deploying to any public server.
