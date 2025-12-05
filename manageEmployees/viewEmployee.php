<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Employees</title>
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/manage.css">
        <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/14861/14861239.png">
    </head>
    <body>
        <main class="view-employee-main">

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
            die("<p id='popup' style='background-color:#FF3838;'>Database connection failed: " . $conn->connect_error . "</p>");
        }

        $sql = "
            SELECT 
                e.SSN,
                e.Fname,
                e.Minit,
                e.Lname,
                e.Bdate,
                e.Address,
                e.Sex,
                e.Salary,
                e.JobTitle,
                e.Phone,
                e.SuperSSN,
                d.Dname AS DepartmentName,
                
                s.Fname AS SuperFname,
                s.Minit AS SuperMinit,
                s.Lname AS SuperLname
                
            FROM employees e
            LEFT JOIN departments d
                ON e.Dno = d.Dnum
            LEFT JOIN employees s 
                ON e.SuperSSN = s.SSN
            ORDER BY e.SSN ASC
        ";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            echo "<table class='dept-table'>";
            echo "<tr>
                    <th>SSN</th>
                    <th>Name</th>
                    <th>Bdate</th>
                    <th>Address</th>
                    <th>Sex</th>
                    <th>Salary</th>
                    <th>Job Title</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Supervisor</th>
                </tr>";

            while ($row = $result->fetch_assoc()) {

                $empName = $row['Fname'] . " " . $row['Minit'] . ". " . $row['Lname'];

                $deptName = $row['DepartmentName'] ?: "<i>NULL</i>";

                $supervisorName = ($row['SuperFname'])
                    ? $row['SuperFname'] . " " . $row['SuperMinit'] . ". " . $row['SuperLname']
                    : "<i>NULL</i>";

                echo "<tr>
                        <td>{$row['SSN']}</td>
                        <td>{$empName}</td>
                        <td>" . ($row['Bdate'] ?: "<i>NULL</i>") . "</td>
                        <td>" . ($row['Address'] ?: "<i>NULL</i>") . "</td>
                        <td>{$row['Sex']}</td>
                        <td>" . ($row['Salary'] ?: "<i>NULL</i>") . "</td>
                        <td>" . ($row['JobTitle'] ?: "<i>NULL</i>") . "</td>
                        <td>" . ($row['Phone'] ?: "<i>NULL</i>") . "</td>
                        <td>{$deptName}</td>
                        <td>{$supervisorName}</td>
                    </tr>";
            }

            echo "</table>";

        } else {
            echo "<p>No employees found.</p>";
        }

        $conn->close();
        ?>

        </main>

        <script src="../js/main.js"></script>
    </body>
</html>
