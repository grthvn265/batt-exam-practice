CREATE TABLE residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resident_num VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL,
    house_num VARCHAR(100),
    street_name VARCHAR(100),
    brgy_name VARCHAR(100),
    zip_code VARCHAR(10),
    city_name VARCHAR(100),
    res_type VARCHAR(50), -- Homeowner or Tenant
    annual_income DECIMAL(19,4) NOT NULL
);