<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Departments</title>
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/manage.css">
        <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/14861/14861239.png">
    </head>
    <body>
        <main>
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
                die("<p id='popup' style='background-color: #FF3838;'>Database connection failed: " . $conn->connect_error . "</p>");
            }

            $sql = "
                SELECT 
                    d.Dnum,
                    d.Dname,
                    d.Mgr_SSN,
                    d.Locations,
                    d.Mgr_Start_Date,
                    e.Fname,
                    e.Minit,
                    e.Lname
                FROM departments d
                LEFT JOIN employees e
                    ON d.Mgr_SSN = e.SSN
                ORDER BY d.Dnum ASC
            ";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>Dnum</th>
                        <th>Department Name</th>
                        <th>Manager</th>
                        <th>Manager SSN</th>
                        <th>Manager Start Date</th>
                        <th>Location</th>
                    </tr>";

                while ($row = $result->fetch_assoc()) {

                    $managerName = ($row['Fname'])
                        ? $row['Fname'] . " " . $row['Minit'] . ". " . $row['Lname']
                        : "<i>No Manager</i>";

                    echo "<tr>
                            <td>{$row['Dnum']}</td>
                            <td>{$row['Dname']}</td>
                            <td>{$managerName}</td>
                            <td>" . ($row['Mgr_SSN'] ?: "<i>NULL</i>") . "</td>
                            <td>" . ($row['Mgr_Start_Date'] ?: "<i>NULL</i>") . "</td>
                            <td>" . ($row['Locations'] ?: "<i>NULL</i>") . "</td>
                        </tr>";
                }

                echo "</table>";

            } else {
                echo "<p>No departments found.</p>";
            }

            $conn->close();
            ?>

        </main>

        <script src="../js/main.js"></script>
    </body>
</html>
