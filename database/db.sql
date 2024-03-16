CREATE DATABASE telephone_billing;

USE telephone_billing;

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    telephone_number VARCHAR(20) NOT NULL
);

CREATE TABLE calls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    minutes INT,
    call_date DATE,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);
