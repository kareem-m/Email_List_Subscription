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
            <h1>Update Department in Database</h1>
            <form action="" method="post">

                <label for="depNum">Department Number:</label>
                <input type="text" id="depNum" name="depNum" placeholder="Enter Department number" required>

                <label for="depName">Department Name:</label>
                <input type="text" id="depName" name="depName" placeholder="Enter Department name" required>
                
                <label for="mgeSSN">Manager SSN:</label>
                <input type="text" id="mgeSSN" name="mgeSSN" placeholder="Enter manager SSN" required>
                
                <label for="mgrStartDate">Manager Start Date:</label>
                <input type="date" id="mgrStartDate" name="mgrStartDate" placeholder="Enter manager Start Date" required>
                
                <label for="deptLocation">Department Location:</label>
                <input type="text" id="deptLocation" name="deptLocation" placeholder="Enter department Location" required>

                <input type="submit" value="Update">
            </form>
        </main>
    </body>
</html>