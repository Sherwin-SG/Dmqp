<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payroll Entry</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>

<body>
<div class="container">

<div class="sidebar sidebargo">

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
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

</div>

<div class="main">
    <div class="bars">
        <img class="bar" src="bar.png" alt="" width="40px">
        <img class="cross" src="cross.png" alt="" width="40px">
    </div>
</div>

</div>
    <h1>Add Payroll Entry</h1>

    <?php
    
    $servername = "localhost";
    $username = "admin";
    $password = "123";
    $database = "payroll";

     
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = new mysqli($servername, $username, $password, $database);

         
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

         
        $employee_id = $_POST["employee_id"];
        $date_from = $_POST["date_from"];
        $date_to = $_POST["date_to"];
        $type = $_POST["type"];
        $status = "New";  
        $date_created = date("Y-m-d H:i:s");  

        
        $insert_query = "INSERT INTO payroll (ref_no, date_from, date_to, type, status, date_created)
                        VALUES ('$employee_id', '$date_from', '$date_to', '$type', '$status', '$date_created')";

        if ($conn->query($insert_query) === TRUE) {
            echo "Payroll entry added successfully!";
            
            
            header("Location: payrolllist.php");
            exit();  
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>

     
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="employee_id">Employee:</label>
        
        <?php
        $conn = new mysqli($servername, $username, $password, $database);  
        $employee_query = "SELECT employee_no, firstname FROM employee";
        $employee_result = $conn->query($employee_query);
        ?>
        <select name="employee_id" required>
            <?php
            while ($row = $employee_result->fetch_assoc()) {
                echo "<option value='" . $row["employee_no"] . "'>" . $row["employee_no"] . " - " . $row["firstname"] . "</option>";
            }
            ?>
        </select><br>

        <label for="date_from">Date From:</label>
        <input type="date" name="date_from" required><br>

        <label for="date_to">Date To:</label>
        <input type="date" name="date_to" required><br>

         
        <label for="type">Type:</label>
    <select name="type">
        <option value="1">Monthly</option>
        <option value="2">Semi-Monthly</option>
    </select><br>

         

        <input type="submit" value="Add Payroll Entry">
    </form>
   
</body>

</html>
