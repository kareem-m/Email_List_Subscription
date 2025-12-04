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

    $sql = "SELECT Dnum, Dname, Mgr_SSN, Mgr_Start_Date, Locations
            FROM departments
            WHERE Dnum = ?";

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

    $depNum       = $_POST["depNum"];
    $depName      = $_POST["depName"];
    $mgeSSN       = $_POST["mgeSSN"];
    $mgrStartDate = $_POST["mgrStartDate"];
    $location     = $_POST["deptLocation"];

    $sql = "UPDATE departments 
            SET Dname = ?, Mgr_SSN = ?, Mgr_Start_Date = ?, Locations = ?
            WHERE Dnum = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $depName, $mgeSSN, $mgrStartDate, $location, $depNum);

    if ($stmt->execute()) {
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

                <input type="hidden" name="depNum" value="<?= $department['Dnum'] ?>">

                <label>Department Name:</label>
                <input type="text" name="depName" required value="<?= $department['Dname'] ?>">

                <label>Manager SSN:</label>
                <input type="text" name="mgeSSN" required value="<?= $department['Mgr_SSN'] ?>">

                <label>Manager Start Date:</label>
                <input type="date" name="mgrStartDate" required value="<?= $department['Mgr_Start_Date'] ?>">

                <label>Department Location:</label>
                <input type="text" name="deptLocation" required value="<?= $department['Locations'] ?>">

                <input type="submit" name="update" value="Update Department">

            </form>
            <?php endif; ?>
        </main>

    </body>
</html>
