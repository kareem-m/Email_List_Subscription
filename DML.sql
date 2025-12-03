INSERT INTO departments (Dnum, Dname, Location, Mgr_Start_Date) VALUES 
(1, 'IT', 'Cairo', '2023-01-01'),
(2, 'Human Resources', 'Alexandria', '2022-05-15'),
(3, 'Sales', 'Giza', '2024-03-10');

INSERT INTO employees (SSN, Fname, Minit, Lname, Bdate, Address, Sex, Salary, JobTitle, Dno, Phone) VALUES 

('10000000000001', 'Kholio', 'A', 'Ali', '1995-10-10', '123 Tech St, Cairo', 'Male', 20000, 'IT Manager', 1, '+201000000001'),
('20000000000002', 'Sarah', 'M', 'Hassan', '1990-05-20', '456 HR Ave, Alex', 'Female', 18000, 'HR Director', 2, '+201100000002'),
('30000000000003', 'Mazen', 'K', 'Sherif', '1988-12-01', '789 Sales Rd, Giza', 'Male', 19000, 'Sales Head', 3, '+201200000003'),
('10000000000004', 'Mina', 'N', 'Nabil', '2000-01-15', '10 Code Ln, Cairo', 'Male', 8000, 'Junior Dev', 1, '+201000000004'),
('20000000000005', 'Salma', 'F', 'Farouk', '1998-07-30', '20 Hire St, Alex', 'Female', 7000, 'Recruiter', 2, '+201100000005'),
('30000000000006', 'Khaled', 'S', 'Salem', '1999-03-22', '30 Deal Blvd, Giza', 'Male', 7500, 'Sales Rep', 3, '+201200000006');

INSERT INTO subscriptions (Email) VALUES 
('client_one@gmail.com'),
('visitor_two@yahoo.com'),
('loyal_customer@hotmail.com'),
('student@alexu.edu.eg');


UPDATE departments SET Mgr_SSN = '10000000000001' WHERE Dnum = 1;

UPDATE departments SET Mgr_SSN = '20000000000002' WHERE Dnum = 2;

UPDATE departments SET Mgr_SSN = '30000000000003' WHERE Dnum = 3;

UPDATE employees SET SuperSSN = '10000000000001' WHERE SSN = '10000000000004';

UPDATE employees SET SuperSSN = '20000000000002' WHERE SSN = '20000000000005';

UPDATE employees SET SuperSSN = '30000000000003' WHERE SSN = '30000000000006';