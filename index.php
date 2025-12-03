<?php

mysqli_report(MYSQLI_REPORT_OFF);

$servername = "localhost";
$username = "root";
$password = "";
$dbname   = "email_list_subscription";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add Email
    if (!empty($_POST['add_email'])) {
        $email = $_POST['add_email'];

        $stmt = $conn->prepare("INSERT INTO subscriptions (Email) VALUES (?)");
        $stmt->bind_param("s", $email);

        $color = "#73AF6F";
        if ($stmt->execute()) {
            $message = "Email added successfully!";
        } else {
            $color = "#FF3838";
            if ($stmt->errno == 1062) {
                $message = "This email already exists!";
            } else {
                $message = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }

    // Remove Email
    if (!empty($_POST['remove_email'])) {
        $remove_email = $_POST['remove_email'];
        $stmt = $conn->prepare("DELETE FROM subscriptions WHERE Email = ?");
        $stmt->bind_param("s", $remove_email);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $color = "#73AF6F";
                $message = "Email removed successfully!";
            } else {
                $color = "#FF3838";
                $message = "This email does not exist!";
            }
        } else {
            $color = "#FF3838";
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Add Employee
    if (!empty($_POST['add_employee'])) {
        $addEmpSSN = $_POST['add_employee'];

        $stmt = $conn->prepare("INSERT INTO employees (SSN) VALUES (?)");
        $stmt->bind_param("s", $addEmpSSN);

        $color = "#73AF6F";
        if ($stmt->execute()) {
            $message = "Email added successfully!";
        } else {
            $color = "#FF3838";
            if ($stmt->errno == 1062) {
                $message = "This email already exists!";
            } else {
                $message = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email List Subscription</title>
        <link rel="stylesheet" href="main.css">
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
            <h1>Email List Subscription</h1>

            <div class="Mbuttons">
                <button id="button1">Manage Departments</button>
                <button id="button2">Manage Employees</button>
                <button id="button3">Manage Emails</button>
            </div>

            <div id="box1" class="box">
                <i class="close">x</i>
            </div>

            <div id="box2" class="box">
                <i class="close">x</i>

                <div class="buttons">
                    <button>Add Employee</button>
                    <button>Remove Employee</button>
                    <button>Update Employee</button>
                </div>

                <!-- <div class="addEmployee">
                    <p>Add Emploee to Database</p>
                    <form action="" method="post">
                        <input type="text" id="add_employee" name="add_employee" placeholder="Enter employee SSN" required>
                        <input type="submit" value="Add">
                    </form>
                </div>

                <div class="removeEmployee">
                    <p>Remove Employee from Database</p>
                    <form action="" method="post">
                        <input type="text" id="remove_employee" name="remove_employee" placeholder="Enter employee SSN" required>
                        <input type="submit" value="Remove">
                    </form>
                </div> -->

                <!-- <div class="updateEmployee">
                    <p>Update Full Name</p>
                    <form action="" method="post">
                        <input type="text" id="updateFName" name="updateFName" placeholder="" required>
                        <input type="submit" value="Remove">
                    </form>
                </div> -->
            </div>

            <div id="box3" class="box">
                <i class="close">x</i>

                <div class="addEmail">
                    <p>Add Email to Database</p>
                    <form action="" method="post">
                        <input type="email" id="add_email" name="add_email" placeholder="Enter email" required>
                        <input type="submit" value="Add">
                    </form>
                </div>

                <div class="removeEmail">
                    <p>Remove Email from Database</p>
                    <form action="" method="post">
                        <input type="email" id="remove_email" name="remove_email" placeholder="Enter email" required>
                        <input type="submit" value="Remove">
                    </form>
                </div>

                <div class="import">
                    <p>Import Data</p>
                    <button>Import</button>
                </div>
                <div class="export">
                    <p>Export Data</p>
                    <button>Export</button>
                </div>
            </div>
        </main>

        <div class="lines">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>

        <script src="main.js"></script>
    </body>
</html>