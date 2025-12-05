CREATE TABLE departments (
    Dnum INT AUTO_INCREMENT PRIMARY KEY,
    Dname VARCHAR(100) NOT NULL UNIQUE,
    Mgr_SSN CHAR(14),
    Mgr_Start_Date DATE,
    Locations VARCHAR(100)
);

CREATE TABLE employees (
    SSN CHAR(14) PRIMARY KEY,
    Fname VARCHAR(50) NOT NULL,
    Minit CHAR(1),
    Lname VARCHAR(50) NOT NULL,
    Bdate DATE,
    Address VARCHAR(200),
    Sex ENUM('Male', 'Female') NOT NULL,
    Salary DECIMAL(10, 2),
    JobTitle VARCHAR(50),
    Dno INT,
    SuperSSN CHAR(14),
    Phone CHAR(13),
    CONSTRAINT Valid_Sex CHECK (Sex IN ('Male', 'Female'))
);

CREATE TABLE subscriptions (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(150) UNIQUE NOT NULL,
    SubscriptionDate DATETIME DEFAULT CURRENT_TIMESTAMP,
);

ALTER TABLE departments
ADD CONSTRAINT fk_dept_mgr
FOREIGN KEY (Mgr_SSN) REFERENCES employees(SSN)
ON DELETE SET NULL;

ALTER TABLE employees
ADD CONSTRAINT fk_supervisor
FOREIGN KEY (SuperSSN) REFERENCES employees(SSN)
ON DELETE SET NULL;

ALTER TABLE employees
ADD CONSTRAINT fk_employee_department
FOREIGN KEY (Dno) REFERENCES departments(Dnum)
ON DELETE SET NULL;