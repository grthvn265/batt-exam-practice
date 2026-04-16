CREATE TABLE business (
    id INT AUTO_INCREMENT PRIMARY KEY,
    business_name VARCHAR(255) NOT NULL,
    date_of_registration DATE NOT NULL,
    business_total_assets DECIMAL(20,2) NOT NULL,
    business_category VARCHAR(20) NOT NULL
);

INSERT INTO business (business_name, date_of_registration, business_total_assets, business_category)
VALUES
('ABC ni XYZ', '2025-01-14', 25000000.00, 'Medium'),
('Bake My Day', '2024-04-16', 14000000.00, 'Small');