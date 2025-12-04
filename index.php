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

    // Import CSV
    if (isset($_POST['import_submit']) && isset($_FILES['csv_file'])) {
        $filename = $_FILES['csv_file']['tmp_name'];

        if ($_FILES['csv_file']['size'] > 0) {
            $file = fopen($filename, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $csv_email = isset($column[1]) ? $column[1] : $column[0]; 

                if (!empty($csv_email)) {
                    $stmt = $conn->prepare("INSERT IGNORE INTO subscriptions (Email) VALUES (?)");
                    $stmt->bind_param("s", $csv_email);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            fclose($file);
            $message = "CSV imported successfully!";
            $color = "#73AF6F";
        } else {
            $message = "File is empty or invalid.";
            $color = "#FF3838";
        }
    }

    // Export CSV
        if (isset($_POST['export_submit'])) {
        // Set headers to force download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=email_list.csv');
        
        // Open output stream
        $output = fopen('php://output', 'w');
        
        // Write Column Headers
        fputcsv($output, array('ID', 'Email', 'Subscription Date'));
        
        // Fetch Data
        $sql = "SELECT ID, Email, SubscriptionDate FROM subscriptions";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                fputcsv($output, $row);
            }
        }
        
        fclose($output);
        $conn->close();
        exit(); 
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
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/home.css">
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

            <div class="MainButtons">
                <button id="mngDepartmentBtn">Manage Departments</button>
                <button id="mngEmployeeBtn">Manage Employees</button>
                <button id="mngEmailBtn">Manage Emails</button>
            </div>

            <!-- Start mngDepartmentBox -->
            <div id="mngDepartmentBox" class="mainBoxes">
                <i class="close">x</i>

                <div class="buttons">
                    <button id="addDepartmentBtn" onclick="window.location.href='manageDepartment/addDepartment.php'">Add Department</button>
                    <button id="removeDepartmentBtn" onclick="window.location.href='manageDepartment/removeDepartment.php'">Remove Department</button>
                    <button id="updateDepartmentBtn" onclick="window.location.href='manageDepartment/updateDepartment.php'">Update Department</button>
                </div>
            </div>
            <!-- End mngDepartmentBox -->

            <!-- Start mngEmployeeBox -->
            <div id="mngEmployeeBox" class="mainBoxes">
                <i class="close">x</i>
                
                <div class="buttons">
                    <button id="addEmployeeBtn" onclick="window.location.href='manageEmployees/addEmployee.php'">Add Employee</button>
                    <button id="removeEmployeeBtn" onclick="window.location.href='manageEmployees/removeEmployee.php'">Remove Employee</button>
                    <button id="updateEmployeeBtn" onclick="window.location.href='manageEmployees/updateEmployee.php'">Update Employee</button>
                </div>
            </div>
            <!-- End mngEmployeeBox -->

            <!-- Start mngEmailBox -->
            <div id="mngEmailBox" class="mainBoxes">
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
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="csv_file" accept=".csv" required style="color: white; margin-bottom: 10px;">
                        <input type="submit" name="import_submit" value="Upload & Import">
                    </form>
                </div>
                
                <div class="export">
                    <p>Export Data</p>
                    <form action="" method="post">
                        <input type="submit" name="export_submit" value="Export to CSV">
                    </form>
                </div>
            </div>
            <!-- End mngEmailBox -->
        </main>

        <div class="lines">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>

        <script src="js/home.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>