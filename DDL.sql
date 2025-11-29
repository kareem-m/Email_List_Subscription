CREATE TABLE departments (
    Dnum INT AUTO_INCREMENT PRIMARY KEY,
    Dname VARCHAR(100) NOT NULL UNIQUE,
    Mgr_SSN INT,                
    Mgr_Start_Date DATE,        
    Locations VARCHAR(100)      
);

CREATE TABLE employees (
    SSN INT AUTO_INCREMENT PRIMARY KEY,
    Fname VARCHAR(50) NOT NULL,
    Minit VARCHAR(50),
    Lname VARCHAR(50) NOT NULL,
    Bdate DATE,
    Address VARCHAR(200),
    Sex ENUM('Male', 'Female'),
    Salary DECIMAL(10, 2),
    JobTitle VARCHAR(50),
    Dnum INT,
    SuperSSN INT,               
    Phone VARCHAR(15),          

    -- Foreign Key: Link to Department (Work For)
    CONSTRAINT fk_employee_dept 
        FOREIGN KEY (Dnum) REFERENCES departments(Dnum) 
        ON DELETE SET NULL,

    -- Foreign Key: Link to Supervisor (Supervision)
    CONSTRAINT fk_employee_super 
        FOREIGN KEY (SuperSSN) REFERENCES employees(SSN) 
        ON DELETE SET NULL
);

CREATE TABLE subscriptions (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(150) UNIQUE NOT NULL,
    SubscriptionDate DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 4. Add the Manager Relationship (Circular Link)
-- This links the Department Manager back to the Employee SSN
ALTER TABLE departments
ADD CONSTRAINT fk_dept_mgr 
    FOREIGN KEY (Mgr_SSN) REFERENCES employees(SSN) 
    ON DELETE SET NULL;