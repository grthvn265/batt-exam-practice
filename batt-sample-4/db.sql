CREATE DATABASE IF NOT EXISTS batt_sample4_db;
USE batt_sample4_db;

CREATE TABLE IF NOT EXISTS residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resident_id VARCHAR(50) NOT NULL UNIQUE,
    family_name VARCHAR(100) NOT NULL,
    given_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    date_of_residency DATE NOT NULL,
    property_land_area DECIMAL(10,2) NOT NULL
);

