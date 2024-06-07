<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Management</title>
    <link rel="stylesheet" href="styles.css">
<script src="script.js" defer></script>
   
   
</head>

<body>
<div class="navbar-container">
        <div class="navbar-toggle">
            <div class="bars"></div>
            <div class="cross"></div>
        </div>
        <div class="sidebar">
            <nav>
                <ul>
                    <li><a href="intro.php">Home</a></li>
                    <li><a href="attendance.php">Attendance</a></li>
                    <li><a href="payrollList.php">Payroll List</a></li>
                    <li><a href="employee.php">Employee List</a></li>
                    <li><a href="department.php">Department List</a></li>
                    <li><a href="position.php">Position List</a></li>
                    <li><a href="allowances.php">Allowance List</a></li>
                    <li><a href="deductions.php">Deduction List</a></li>
                    <li><a href="users.php">User Management</a></li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <h1>Department Management</h1>
    <?php
    $servername = "localhost";
    $username = "admin";
    $password = "123";
    $database = "payroll";
    $conn = new mysqli($servername, $username, $password, $database);

     
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
        $Name = $_POST["department_name"];

         
        $insert_query = "INSERT INTO department (name) VALUES ('$Name')";

         
        if ($conn->query($insert_query) === TRUE) {
            echo "Department added successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    }

     
    if (isset($_GET['delete'])) {
        $deleteId = $_GET['delete'];

         
        $delete_query = "DELETE FROM department WHERE id = '$deleteId'";
        if ($conn->query($delete_query) === TRUE) {
            echo "Department deleted successfully.";
        } else {
            echo "Error deleting department: " . $conn->error;
        }
    }

     
    $select_query = "SELECT * FROM department";
    $result = $conn->query($select_query);

    if ($result->num_rows > 0) {
        echo "<h2>Department:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>
                        <button type='button' onclick='deleteDepartment({$row['id']})'>Delete</button>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No departments in the database.</p>";
    }

     
    $conn->close();
    ?>

    <form method="POST">
        <label for="department_name">Department Name:</label>
        <input type="text" name="department_name" required>
        <input type="submit" name="submit" value="Add Department">
    </form>

    <script>
        function deleteDepartment(Id) {
             
            var confirmDelete = confirm("Are you sure you want to delete this department?");
            
            if (confirmDelete) {
                 
                window.location.href = "department.php?delete=" + Id;
            }
        }
    </script>

     
</body>

</html>
