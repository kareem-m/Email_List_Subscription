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
    Sex ENUM('Male', 'Female'),
    Salary DECIMAL(10, 2),
    JobTitle VARCHAR(50),
    Dno INT,
    SuperSSN CHAR(14),
    Phone CHAR(13),
    FOREIGN KEY (Dno) REFERENCES departments(Dnum),
    FOREIGN KEY (SuperSSN) REFERENCES employees(SSN)
);

CREATE TABLE subscriptions (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(150) UNIQUE NOT NULL,
    SubscriptionDate DATETIME DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE departments
ADD CONSTRAINT fk_dept_mgr
    FOREIGN KEY (Mgr_SSN) REFERENCES employees(SSN)
