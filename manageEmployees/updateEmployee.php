<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Employees</title>
        <link rel="stylesheet" href="../manage.css">
        <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/14861/14861239.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <main>
            <h1>Update Employee in Database</h1>
            <form action="" method="post">

                <label for="empSSN">Employee SSN:</label>
                <input type="text" id="empSSN" name="empSSN" placeholder="Enter employee SSN" required>

                <label for="empFullName">Employee Full Name:</label>
                <input type="text" id="empFullName" name="empFullName" placeholder="Enter employee full name" required>

                <label for="empBdate">Employee Birthdate:</label>
                <input type="text" id="empBdate" name="empBdate" placeholder="Enter employee full name" required>

                <label for="empAddress">Employee Address:</label>
                <input type="text" id="empAddress" name="empAddress" placeholder="Enter employee full name" required>
                
                <label for="empSex">Employee Sex:</label>
                <input type="text" id="empSex" name="empSex" placeholder="Enter employee full name" required>
                
                <label for="empSalary">Employee Salary:</label>
                <input type="text" id="empSalary" name="empSalary" placeholder="Enter employee full name" required>
                
                <label for="empJob">Employee Job:</label>
                <input type="text" id="empJob" name="empJob" placeholder="Enter employee full name" required>
                
                <label for="empPhone">Employee Phone:</label>
                <input type="text" id="empPhone" name="empPhone" placeholder="Enter employee full name" required>
                
                <label for="empDepartment">Employee Department:</label>
                <input type="text" id="empDepartment" name="empDepartment" placeholder="Enter employee full name" required>
                
                <label for="empSupervisor">Employee Supervisor:</label>
                <input type="text" id="empSupervisor" name="empSupervisor" placeholder="Enter employee full name" required>

                <input type="submit" value="Update">
            </form>
        </main>
    </body>
</html>