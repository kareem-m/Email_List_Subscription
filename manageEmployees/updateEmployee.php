<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "email_list_subscription";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$employee = null;
$message  = "";

if (isset($_POST["search"])) {
    $ssn = $_POST["empSSN"];

    $sql  = "SELECT * FROM employees WHERE SSN = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ssn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        $color = "#FF3838";
        $message = "No employee found with that SSN";
    }
}

if (isset($_POST["update"])) {

    $ssn       = $_POST["empSSN"];
    $fullName  = $_POST["empFullName"];
    $bdate     = $_POST["empBdate"];
    $address   = $_POST["empAddress"];
    $sex       = $_POST["empSex"];
    $salary    = $_POST["empSalary"];
    $job       = $_POST["empJob"];
    $phone     = $_POST["empPhone"];
    $dept      = $_POST["empDepartment"];
    $super     = $_POST["empSupervisor"];

    $parts = explode(" ", $fullName);
    $fname = $parts[0] ?? "";
    $lname = $parts[count($parts)-1] ?? "";
    $minit = isset($parts[1]) ? substr($parts[1], 0, 1) : "";

    $sql = "UPDATE employees SET 
                Fname = ?, 
                Minit = ?, 
                Lname = ?, 
                Bdate = ?, 
                Address = ?, 
                Sex = ?, 
                Salary = ?, 
                JobTitle = ?, 
                Dno = ?, 
                SuperSSN = ?, 
                Phone = ?
            WHERE SSN = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssdissss",
        $fname, $minit, $lname, $bdate, $address, $sex, 
        $salary, $job, $dept, $super, $phone, $ssn
    );

    if ($stmt->execute()) {
        $color = "#73AF6F";
        $message = "Employee updated successfully.";
    } else {
        $color = "#FF3838";
        $message = "Update failed: " . $stmt->error;
    }
}

?>



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

        <?php if (!empty($message)) : ?>
            <p id="popup" style="background-color: <?= $color ?>;"><?php echo $message; ?></p>
        <?php endif; ?>

        <main>
            <form method="post">
                <label for="empSSN">Employee SSN:</label>
                <input type="text" id="empSSN" name="empSSN" required placeholder="Enter employee SSN (14 characters)">

                <input type="submit" name="search" value="Load Employee">
            </form>

            <?php if ($employee): ?>
            <form method="post">

                <input type="hidden" name="empSSN" value="<?= $employee['SSN'] ?>">

                <label>Employee Full Name:</label>
                <input type="text" name="empFullName" required
                    value="<?= $employee['Fname'] . ' ' . $employee['Minit'] . ' ' . $employee['Lname'] ?>">

                <label>Birthdate:</label>
                <input type="text" name="empBdate" required value="<?= $employee['Bdate'] ?>">

                <label>Address:</label>
                <input type="text" name="empAddress" required value="<?= $employee['Address'] ?>">

                <label>Sex:</label>
                <input type="text" name="empSex" required value="<?= $employee['Sex'] ?>">

                <label>Salary:</label>
                <input type="text" name="empSalary" required value="<?= $employee['Salary'] ?>">

                <label>Job:</label>
                <input type="text" name="empJob" required value="<?= $employee['JobTitle'] ?>">

                <label>Phone:</label>
                <input type="text" name="empPhone" required value="<?= $employee['Phone'] ?>">

                <label>Department Number:</label>
                <input type="text" name="empDepartment" required value="<?= $employee['Dno'] ?>">

                <label>Supervisor SSN:</label>
                <input type="text" name="empSupervisor" required value="<?= $employee['SuperSSN'] ?>">

                <input type="submit" name="update" value="Update Employee">

            </form>
            <?php endif; ?>

        </main>
    </body>
</html>