<!DOCTYPE html>
<html>
<head>
    <title>Employee Management</title>
</head>
<body>
    <center>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "employeedb";
        $conn = mysqli_connect($servername, $username, $password, $database);

        if($conn === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $employee_id = $_POST['employee_id'];
            $department = $_POST['department'];
            $age = $_POST['age'];
            $salary = $_POST['salary'];

            $insert_sql = "INSERT INTO employees (name, employee_id, department, age, salary)
                           VALUES ('$name', '$employee_id', '$department', '$age', '$salary')";

            if (mysqli_query($conn, $insert_sql)) {
                echo "<h3>Employee saved successfully.</h3>";
            } else {
                echo "<h3 style='color: red;'>Error: " . mysqli_error($conn) . "</h3>";
            }
        }

        $select_sql = "SELECT * FROM employees";
        $result = mysqli_query($conn, $select_sql);

        echo "<h3>Employee Records</h3>";
        echo "<table border='1' cellpadding='10'>
              <tr><th>Name</th><th>Employee ID</th><th>Department</th><th>Age</th><th>Salary</th></tr>";
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>{$row["name"]}</td>
                          <td>{$row["employee_id"]}</td>
                          <td>{$row["department"]}</td>
                          <td>{$row["age"]}</td>
                          <td>{$row["salary"]}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found.</td></tr>";
        }
        echo "</table>";

        mysqli_close($conn);
        ?>
    </center>
</body>
</html>
