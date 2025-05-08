-- database creation
CREATE DATABASE grade;
-- database use
USE grade;
-- table creation (Clients,Campaigns,Employee,Advertisement,performance_matrix)
CREATE TABLE Clients (
    client_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email_address VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    start_date DATE,
    end_date DATE,
    password_hash VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE Advertisement (
    ad_id INT PRIMARY KEY AUTO_INCREMENT,
    ad_campaign_id INT,
    budget DECIMAL(10,2),
    advertisement_domain VARCHAR(100),
    media_type VARCHAR(50),
    message TEXT,
    client_id INT,
    campaign_id INT,
    advertisement_name VARCHAR(255),
    FOREIGN KEY (ad_campaign_id) REFERENCES Campaigns(campaign_id),
    FOREIGN KEY (client_id) REFERENCES Clients(client_id),
    FOREIGN KEY (campaign_id) REFERENCES Campaigns(campaign_id)
);

CREATE TABLE Campaigns (
    campaign_id INT PRIMARY KEY AUTO_INCREMENT,
    campaign_name VARCHAR(100),
    campaign_budget DECIMAL(10,2),
    email VARCHAR(100),
    campaign_description TEXT,
    start_date DATE,
    end_date DATE,
    client_id INT,
    FOREIGN KEY (client_id) REFERENCES clients(client_id)
);

CREATE TABLE Employee (
    employee_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_name VARCHAR(100) NOT NULL,
    employee_email VARCHAR(100) NOT NULL UNIQUE,
    employee_phone VARCHAR(20),
    client_name VARCHAR(100),
    advertisement_name VARCHAR(100),
    advertisement_id INT,
    ad_campaign VARCHAR(100),
    ad_campaign_id INT,
    campaign_name VARCHAR(100),
    client_id INT,
    FOREIGN KEY (client_id) REFERENCES clients(client_id)
);

CREATE TABLE performance_matrix (
    performance_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    advertisement_name VARCHAR(100),
    employee_name VARCHAR(100),
    campaign_name VARCHAR(100),
    conversion_rate DECIMAL(10,2),
    click_through_rate DECIMAL(10,2),
    return_on_time DECIMAL(10,2),
    customer_lifetime_value DECIMAL(10,2),
    bounce_rate DECIMAL(10,2)
);


-- insertion of data

INSERT INTO Clients (first_name, last_name, email_address, phone_number, start_date, end_date, password_hash, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?);

INSERT INTO Campaigns (campaign_name, campaign_budget, email, campaign_description, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?);

INSERT INTO Advertisement (client_id, ad_campaign_id, budget, advertisement_domain, media_type, message) VALUES (?, ?, ?, ?, ?, ?);

INSERT INTO Employee (employee_id, employee_name, employee_email, employee_phone, client_name, advertisement_name, advertisement_id, ad_campaign, ad_campaign_id, campaign_name, client_id) 
VALUES 
(1, 'John Doe', 'john.doe@example.com', '123-456-7890', 'ABC Corporation', 'Summer Sale', 1, 'Summer Campaign', 1, 'Summer Campaign', 1),
(2, 'Jane Smith', 'jane.smith@example.com', '987-654-3210', 'XYZ Corp', 'Back to School', 2, 'School Campaign', 2, 'School Campaign', 2),
(3, 'Alice Johnson', 'alice.johnson@example.com', NULL, 'ACME Inc', 'Holiday Special', 3, 'Holiday Campaign', 3, 'Holiday Campaign', 3),
(4, 'Bob Williams', 'bob.williams@example.com', '555-555-5555', 'GHI Industries', 'Winter Collection', 4, 'Winter Campaign', 4, 'Winter Campaign', 4);

INSERT INTO performance_matrix (advertisement_name, employee_name, campaign_name, conversion_rate, click_through_rate, return_on_time, customer_lifetime_value, bounce_rate)
VALUES ('Ad Name 1', 'Employee 1', 'Campaign 1', 0.85, 0.75, 0.92, 5000.00, 0.20),
    ('Ad Name 2', 'Employee 2', 'Campaign 2', 0.78, 0.65, 0.88, 6000.00, 0.25),
    ('Ad Name 3', 'Employee 3', 'Campaign 3', 0.90, 0.80, 0.95, 5500.00, 0.15);

-- join
-- This query joins the Clients, Advertisement, and Campaigns tables to retrieve information about clients along with their related advertisements and campaigns.
SELECT
    cl.first_name AS `Client Name`,
    cl.email_address AS `Email`,
    cl.phone_number AS `Phone Number`,
    a.advertisement_name AS `Advertisement Name`,
    a.budget AS `Advertisement Budget`,
    c.campaign_name AS `Campaign Name`,
    c.campaign_budget AS `Campaign Budget`        
    FROM
        Clients cl
    LEFT JOIN
        Advertisement a ON cl.client_id = a.client_id
    LEFT JOIN
        Campaigns c ON cl.client_id = c.client_id;

-- select queries
-- Retrieves all records from the Clients table. Similar SELECT queries are used for other tables.

SELECT * FROM Clients;
SELECT * FROM Employee;
SELECT * FROM Advertisement;
SELECT * FROM Campaigns;
SELECT * FROM performance_matrix;

SELECT * FROM Clients WHERE client_id='$id';

-- update  
-- Updates the first_name and last_name fields in the Clients table based on the client_id.

UPDATE Clients SET first_name='$first_name', last_name='$last_name' WHERE client_id='$id';

-- view 

CREATE VIEW employee_information AS
SELECT employee_id, employee_name, employee_email, employee_phone, client_name, advertisement_name, ad_campaign, campaign_name, client_id
FROM Employee;

SELECT * FROM employee_information;

-- clause

SELECT c.client_id, c.first_name, c.last_name, COUNT(a.advertisement_name) AS total_advertisements, SUM(a.budget) AS total_budget
                    FROM Clients c
                    LEFT JOIN Advertisement a ON c.client_id = a.client_id
                    GROUP BY c.client_id
                    HAVING total_budget > 1000
                    ORDER BY total_budget DESC;

-- nested queries

SELECT *, (SELECT COUNT(*) FROM Advertisement WHERE client_id = Clients.client_id) AS total_advertisements FROM Clients WHERE client_id='$id';

