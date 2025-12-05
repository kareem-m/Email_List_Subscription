<?php
mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "email_list_subscription";
} else {
    $servername = "sql104.infinityfree.com";
    $username   = "if0_40608957";
    $password   = "4nyYfkQDbBO";
    $dbname     = "if0_40608957_email_list_subscription";
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$color = "#FF3838";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ssn         = trim($_POST['empSSN']);
    $fullName    = trim($_POST['empFullName']);
    $bdate       = $_POST['empBdate'];
    $address     = trim($_POST['empAddress']);
    $sex         = trim($_POST['empSex']);
    $salary      = $_POST['empSalary'];
    $job         = trim($_POST['empJob']);
    $phone       = trim($_POST['empPhone']);
    $department  = $_POST['empDepartment'];
    $supervisor  = trim($_POST['empSupervisor']);

    if (strlen($ssn) !== 14) {
        $message = "SSN must be exactly 14 characters.";
    } elseif (!ctype_digit($ssn)) {
        $message = "SSN must contain only digits.";
    } elseif (strlen($phone) !== 13 || !ctype_digit($phone)) {
        $message = "Phone must be exactly 13 digits.";
    } elseif (!empty($supervisor) && (strlen($supervisor) !== 14 || !ctype_digit($supervisor))) {
        $message = "Supervisor SSN must be exactly 14 digits";
    } elseif (!in_array($sex, ['Male', 'Female'])) {
        $message = "Sex must be 'Male' or 'Female'.";
    } else {
        $nameParts = explode(" ", $fullName);
        if (count($nameParts) < 2) {
            $message = "Full name must contain at least first and last name.";
        } else {
            $fname = $nameParts[0];
            $minit = isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : "";
            $lname = $nameParts[2] ?? $nameParts[1];

            if (!empty($supervisor)) {
                if ($ssn === $supervisor) {
                    $message = "Employee cannot be their own supervisor.";
                } else {
                    $check = $conn->prepare("SELECT SSN FROM employees WHERE SSN = ?");
                    $check->bind_param("s", $supervisor);
                    $check->execute();
                    $check->store_result();
                    if ($check->num_rows === 0) {
                        $message = "Supervisor SSN does not exist in database.";
                    }
                    $check->close();
                }
            }

            if (empty($message)) {
                $sql = "INSERT INTO employees 
                        (SSN, Fname, Minit, Lname, Bdate, Address, Sex, Salary, JobTitle, Dno, SuperSSN, Phone)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    $message = "Prepare failed: " . $conn->error;
                } else {
                    $stmt->bind_param(
                        "sssssssdsiss",
                        $ssn,
                        $fname,
                        $minit,
                        $lname,
                        $bdate,
                        $address,
                        $sex,
                        $salary,
                        $job,
                        $department,
                        $supervisor,
                        $phone
                    );

                    if ($stmt->execute()) {
                        $color = "#73AF6F";
                        $message = "Employee added successfully!";
                    } else {
                        $color = "#FF3838";
                        $message = "Insert failed: " . $stmt->error;
                    }
                }
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Employees</title>
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/manage.css">
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
            <h1>Add Employee to Database</h1>
            <form action="" method="post">

                <label for="empSSN">Employee SSN:</label>
                <input type="text" id="empSSN" name="empSSN" placeholder="Enter employee SSN (14 characters)" required>

                <label for="empFullName">Employee Full Name:</label>
                <input type="text" id="empFullName" name="empFullName" placeholder="Enter employee full name (ex: Mahmoud M Elkholy)" required>

                <label for="empBdate">Employee Birthdate:</label>
                <input type="date" id="empBdate" name="empBdate" required>

                <label for="empAddress">Employee Address:</label>
                <input type="text" id="empAddress" name="empAddress" placeholder="Enter employee address" required>
                
                <label for="empSex">Employee Sex:</label>
                <input type="text" id="empSex" name="empSex" placeholder="Enter employee sex (Male, Female)" required>
                
                <label for="empSalary">Employee Salary:</label>
                <input type="text" id="empSalary" name="empSalary" placeholder="Enter employee salary" required>
                
                <label for="empJob">Employee Job:</label>
                <input type="text" id="empJob" name="empJob" placeholder="Enter employee job" required>
                
                <label for="empPhone">Employee Phone:</label>
                <input type="text" id="empPhone" name="empPhone" placeholder="Enter employee phone (13 characters)" required>
                
                <label for="empDepartment">Employee Department Number:</label>
                <input type="text" id="empDepartment" name="empDepartment" placeholder="Enter employee department number">
                
                <label for="empSupervisor">Employee Supervisor:</label>
                <input type="text" id="empSupervisor" name="empSupervisor" placeholder="Enter employee supervisor (14 characters)">

                <input type="submit" value="Add">
            </form>
        </main>

        <script src="../js/main.js"></script>
    </body>
</html>