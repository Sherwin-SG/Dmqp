<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allowance Management</title>
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
            </nav>

        </div>

    </div>

    <div class="main">
        <h1>Payroll List</h1>

        <?php
        $servername = "localhost";
        $username = "admin";
        $password = "123";
        $database = "payroll";
        $conn = new mysqli($servername, $username, $password, $database);

         
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
 
if (isset($_GET['calculate'])) {
    $refNo = $_GET['calculate'];

    
    $update_query = "UPDATE payroll SET status = 1 WHERE ref_no = '$refNo'";
    if ($conn->query($update_query) === TRUE) {
        echo "Payroll status updated to Completed.";
        header("Location: payrolllist.php");
        exit();  
    } else {
        echo "Error updating payroll status: " . $conn->error;
    }
}
        $payroll_query = "SELECT * FROM payroll";
        $payroll_result = $conn->query($payroll_query);
        

        if ($payroll_result->num_rows > 0) {
            echo "<table>
                        <tr>
                            <th>Ref_No</th>
                            <th>Date_From</th>
                            <th>Date_To</th>
                            <th>Status</th>
                        </tr>";

            while ($row = $payroll_result->fetch_assoc()) {
                $status = ($row["status"] == 1) ? "Calculated" : "New";  
                echo "<tr data-ref-no='" . $row["ref_no"] . "'>
            <td>" . $row["ref_no"] . "</td>
            <td>" . $row["date_from"] . "</td>
            <td>" . $row["date_to"] . "</td>
            <td>" . $status . "</td>
            <td>
                <button type='button' onclick='deleteDeduction({$row['id']})'>Delete</button>
             
                <button type='button' onclick='show(\"" . $row['ref_no'] . "\")'>calculate</button>
                <button type='button' onclick='slip(\"" . $row['ref_no'] . "\")'>slip</button>
            </td>
          </tr>";

            }

            echo "</table>";
        } else {
            echo "No payroll entries found.";
        } 
        if (isset($_GET['delete'])) {
            $deleteId = $_GET['delete'];

            // Perform the deletion
            $delete_query = "DELETE FROM payroll WHERE id = '$deleteId'";
            if ($conn->query($delete_query) === TRUE) {
                echo "payroll deleted successfully.";
                header("Location: payrolllist.php");
                exit(); 
            } else {
                echo "Error deleting payroll: " . $conn->error;
            }
        }

        ?>
        <button onclick="window.location.href='another.php'">Add Entry</button>
    </div>
    </div>
    <script>
        function deleteDeduction(Id) {
          
            var confirmDelete = confirm("Are you sure you want to delete this deduction?");
            if (confirmDelete) {
               
                window.location.href = "payrollList.php?delete=" + Id;
            }

        }

        function calculate(refNo) {
 
    window.location.href = "call.php?ref_no=" + refNo;
}
function show(refNo) {
    
    window.location.href = "payroll_items.php?ref_no=" + refNo;
}

function slip(refNo) { 
    window.location.href = "slip.php?ref_no=" + refNo;
}

    </script>
 
</body>

</html>
