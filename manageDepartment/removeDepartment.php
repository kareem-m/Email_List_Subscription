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
    } 
    else {
        $sqlMgrUpdate = "UPDATE departments SET Mgr_SSN = NULL WHERE Dnum = ?";
        $stmtMgr = $conn->prepare($sqlMgrUpdate);
        $stmtMgr->bind_param("i", $dNum);
        $stmtMgr->execute();

        $sqlEmpUpdate = "UPDATE employees SET Dno = NULL WHERE Dno = ?";
        $stmtEmp = $conn->prepare($sqlEmpUpdate);
        $stmtEmp->bind_param("i", $dNum);
        $stmtEmp->execute();

        $sqlDelete = "DELETE FROM departments WHERE Dnum = ?";
        $stmtDel = $conn->prepare($sqlDelete);
        $stmtDel->bind_param("i", $dNum);

        if ($stmtDel->execute()) {
            $message = "Department deleted successfully. Any manager or employees assigned were detached first.";
            $color = "#73AF6F";
        } else {
            $message = "Failed to delete department: " . $stmtDel->error;
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

        <script src="../js/main.js"></script>
    </body>
</html>