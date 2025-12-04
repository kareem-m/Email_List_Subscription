<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "email_list_subscription";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$color = "#FF3838";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $dNum = $_POST["dNum"];

    $sqlCheck = "SELECT * FROM departments WHERE Dnum = ?";
    $stmt = $conn->prepare($sqlCheck);
    $stmt->bind_param("i", $dNum);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $message = "No department found with that number.";
        $color = "#FF3838";
    } else {

        $sqlEmpCheck = "SELECT * FROM employees WHERE Dno = ?";
        $stmt2 = $conn->prepare($sqlEmpCheck);
        $stmt2->bind_param("i", $dNum);
        $stmt2->execute();
        $empResult = $stmt2->get_result();

        if ($empResult->num_rows > 0) {
            $message = "Cannot delete this department because employees are assigned to it.";
            $color = "#FF3838";
        } else {

            $sqlMgrCheck = "SELECT * FROM departments WHERE Dnum = ? AND Mgr_SSN IS NOT NULL";
            $stmt3 = $conn->prepare($sqlMgrCheck);
            $stmt3->bind_param("i", $dNum);
            $stmt3->execute();
            $mgrResult = $stmt3->get_result();

            if ($mgrResult->num_rows > 0) {
                $message = "Cannot delete department because it currently has a manager assigned.";
                $color = "#FF3838";
            } else {

                $sqlDelete = "DELETE FROM departments WHERE Dnum = ?";
                $stmt4 = $conn->prepare($sqlDelete);
                $stmt4->bind_param("i", $dNum);

                if ($stmt4->execute()) {
                    $message = "Department removed successfully.";
                    $color = "#73AF6F";
                } else {
                    $message = "Failed to remove department: " . $stmt4->error;
                    $color = "#FF3838";
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
        <link rel="stylesheet" href="../manage.css">
        <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/14861/14861239.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    </head>
    <body>

        <?php if (!empty($message)) : ?>
            <p id="popup" style="background-color: <?= $color ?>;"><?= $message ?></p>
        <?php endif; ?>

        <main>
            <h1>Remove Department from Database</h1>
            <form action="" method="post">

                <label for="dNum">Department Number:</label>
                <input type="text" id="dNum" name="dNum" placeholder="Enter department number" required>
                <input type="submit" value="Remove">
            </form>
        </main>
    </body>
</html>