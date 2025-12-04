<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "email_list_subscription";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $ssn = $_POST['empSSN'];

    $sql = "DELETE FROM employees WHERE SSN = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $ssn);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $color = "#73AF6F";
            $message = "Employee removed successfully!";
        } else {
            $color = "#FF3838";
            $message = "No employee found with that SSN.";
        }
    } else {
        $color = "#FF3838";
        $message = "Error: " . $stmt->error;
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
            <h1>Remove Employee from Database</h1>
            <form action="" method="post">

                <label for="empSSN">Employee SSN:</label>
                <input type="text" id="empSSN" name="empSSN" placeholder="Enter employee SSN" required>

                <input type="submit" value="Remove">
            </form>
        </main>

        <script src="../js/main.js"></script>
    </body>
</html>