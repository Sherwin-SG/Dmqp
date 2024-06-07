<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deduction Management</title>
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

    <h1>Deduction Management</h1>

    <?php
$servername = "localhost";
$username = "admin";
$password = "123";
$database = "payroll";
$conn = new mysqli($servername, $username, $password, $database);

 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_deduction"])) {
    
    $deduction = isset($_POST["deduction_info"]) ? $_POST["deduction_info"] : '';

    if (!empty($deduction)) {
        
        $insert_query = "INSERT INTO deductions (deduction, description) VALUES ('$deduction', '$deduction')";

         
        if ($conn->query($insert_query) === TRUE) {
            echo "Deduction added successfully.";
        } else {
            echo "Error adding deduction: " . $conn->error;
        }
    } else {
        echo "Error: Deduction information entry is empty.";
    }
}

     
    if (isset($_GET['delete'])) {
        $deleteId = $_GET['delete'];

         
        $delete_query = "DELETE FROM deductions WHERE id = '$deleteId'";
        if ($conn->query($delete_query) === TRUE) {
            echo "Deduction deleted successfully.";
        } else {
            echo "Error deleting deduction: " . $conn->error;
        }
    }

     
    $select_query = "SELECT * FROM deductions";
    $result = $conn->query($select_query);

    if ($result->num_rows > 0) {
        echo "<h2>Deductions:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Deduction Information</th>
                    <th>Action</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['deduction']}</td>
                    <td>
                        <button type='button' onclick='deleteDeduction({$row['id']})'>Delete</button>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No deductions in the 'deductions' table.</p>";
    }
    ?>

    <h2>Add Entry to Deductions:</h2>
    <form method="POST">
        <label for="deduction_info">Deduction Information:</label>
        <input type="text" name="deduction_info" required>
        <br>
        <input type="submit" name="submit_deduction" value="Add Entry">
    </form>

    <script>
        function deleteDeduction(Id) {
             
            var confirmDelete = confirm("Are you sure you want to delete this deduction?");
            if (confirmDelete) {
                
                window.location.href = "deductions.php?delete=" + Id;
            }
        }
    </script>

     
</body>

</html>
