<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "email_list_subscription";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$department = null;
$message = "";

if (isset($_POST["search"])) {
    $depNum = $_POST["depNum"];

    $sql = "SELECT d.Dnumber, d.Dname, d.Mgr_ssn, d.Mgr_start, dl.Dlocation
            FROM department d
            LEFT JOIN dept_locations dl ON d.Dnumber = dl.Dnumber
            WHERE d.Dnumber = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $depNum);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $department = $result->fetch_assoc();
    } else {
        $color = "#FF3838";
        $message = "No department found with that number.";
    }
}

if (isset($_POST["update"])) {

    $depNum = $_POST["depNum"];
    $depName = $_POST["depName"];
    $mgeSSN = $_POST["mgeSSN"];
    $mgrStart = $_POST["mgrStartDate"];
    $deptLocation = $_POST["deptLocation"];

    $sql = "UPDATE department SET Dname = ?, Mgr_ssn = ?, Mgr_start = ? WHERE Dnumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $depName, $mgeSSN, $mgrStart, $depNum);

    $ok1 = $stmt->execute();

    $sql2 = "UPDATE dept_locations SET Dlocation = ? WHERE Dnumber = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("si", $deptLocation, $depNum);

    $ok2 = $stmt2->execute();

    if ($ok1 && $ok2) {
        $color = "#73AF6F";
        $message = "Department updated successfully.";
    } else {
        $color = "#FF3838";
        $message = "Update failed.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Department</title>
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
            <h1>Update Department in Database</h1>

            <form method="post">
                <label for="depNum">Department Number:</label>
                <input type="text" id="depNum" name="depNum" placeholder="Enter department number" required>

                <input type="submit" name="search" value="Load Department">
            </form>

            <?php if ($department): ?>
            <form method="post">

                <input type="hidden" name="depNum" value="<?= $department['Dnumber'] ?>">

                <label>Department Name:</label>
                <input type="text" name="depName" required value="<?= $department['Dname'] ?>">

                <label>Manager SSN:</label>
                <input type="text" name="mgeSSN" required value="<?= $department['Mgr_ssn'] ?>">

                <label>Manager Start Date:</label>
                <input type="date" name="mgrStartDate" required value="<?= $department['Mgr_start'] ?>">

                <label>Department Location:</label>
                <input type="text" name="deptLocation" required value="<?= $department['Dlocation'] ?>">

                <input type="submit" name="update" value="Update Department">

            </form>
            <?php endif; ?>
        </main>

    </body>
</html>