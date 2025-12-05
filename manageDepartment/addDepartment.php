<?php
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

    $depName   = $_POST["depName"];
    $mgrSSN    = $_POST["mgeSSN"];
    $startDate = $_POST["mgrStartDate"];
    $location  = $_POST["deptLocation"];

    $checkMgr = "SELECT * FROM employees WHERE SSN = ?";
    $stmt = $conn->prepare($checkMgr);
    $stmt->bind_param("s", $mgrSSN);
    $stmt->execute();
    $mgrResult = $stmt->get_result();

    if ($mgrResult->num_rows === 0) {
        $message = "Manager SSN does not exist in employees table.";
        $color = "#FF3838";
    } else {

        $sqlInsert = "INSERT INTO departments (Dname, Mgr_SSN, Mgr_Start_Date, Locations) VALUES (?, ?, ?, ?)";

        $stmt2 = $conn->prepare($sqlInsert);
        $stmt2->bind_param("ssss", $depName, $mgrSSN, $startDate, $location);

        if ($stmt2->execute()) {
            $message = "Department added successfully.";
            $color = "#73AF6F";
        } else {
            $message = "Failed to add department: " . $stmt2->error;
            $color = "#FF3838";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Department</title>
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
            <h1>Add Department to Database</h1>
            <form action="" method="post">

                <label for="depName">Department Name:</label>
                <input type="text" id="depName" name="depName" placeholder="Enter Department name" required>
                
                <label for="mgeSSN">Manager SSN:</label>
                <input type="text" id="mgeSSN" name="mgeSSN" placeholder="Enter manager SSN" required>
                
                <label for="mgrStartDate">Manager Start Date:</label>
                <input type="date" id="mgrStartDate" name="mgrStartDate" placeholder="Enter manager Start Date" required>
                
                <label for="deptLocation">Department Location:</label>
                <input type="text" id="deptLocation" name="deptLocation" placeholder="Enter department Location" required>
                
                <input type="submit" value="Add">
            </form>
        </main>

        <script src="../js/main.js"></script>
    </body>
</html>