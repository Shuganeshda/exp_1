<?php
$conn = mysqli_connect("localhost", "root", "", "employeedb");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = $_POST["employee_id"];
    $name = $_POST["name"];
    $department = $_POST["department"];
    $age = $_POST["age"];
    $salary = $_POST["salary"];

    $check = mysqli_query($conn, "SELECT * FROM employees WHERE employee_id='$employee_id'");
    if (mysqli_num_rows($check) > 0) {
        $sql = "UPDATE employees SET 
                    name='$name', 
                    department='$department', 
                    age='$age', 
                    salary='$salary' 
                WHERE employee_id='$employee_id'";
    } else {
        $sql = "INSERT INTO employees (employee_id, name, department, age, salary) 
                VALUES ('$employee_id', '$name', '$department', '$age', '$salary')";
    }

    mysqli_query($conn, $sql);
}

if (isset($_GET['delete'])) {
    $employee_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM employees WHERE employee_id='$employee_id'");
}

$result = mysqli_query($conn, "SELECT * FROM employees");

echo "<center><table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr>
        <th>Employee ID</th>
        <th>Name</th>
        <th>Department</th>
        <th>Age</th>
        <th>Salary</th>
        <th>Actions</th>
      </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    $json = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
    echo "<tr>
            <td>{$row['employee_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['department']}</td>
            <td>{$row['age']}</td>
            <td>{$row['salary']}</td>
            <td>
                <button onclick='window.top.editEmployee($json)'>Edit</button>
                <button><a href='?delete={$row['employee_id']}' onclick=\"return confirm('Delete this employee?')\">Delete</a></button>
            </td>
          </tr>";
}

echo "</table></center>";

mysqli_close($conn);
?>
