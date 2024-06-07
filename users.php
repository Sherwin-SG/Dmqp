<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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

    <h1>User Management</h1>

    <button onclick="openAddUserForm()">Add User</button>

    <div id="addUserForm" style="display: none;">
        <h2>Add New User:</h2>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            <br>
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <br>
            <input type="submit" name="submit_user" value="Add Entry">
        </form>
    </div>

    <h2>Edit User:</h2>

    <?php
    $servername = "localhost";
    $username = "admin";
    $password = "123";
    $database = "payroll";
    $conn = new mysqli($servername, $username, $password, $database);

   
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_user"])) {
   
    $name = isset($_POST["name"]) ? $_POST["name"] : '';
    $username = isset($_POST["username"]) ? $_POST["username"] : '';
    $password = isset($_POST["password"]) ? $_POST["password"] : '';

    if (!empty($name) && !empty($username) && !empty($password)) {
      
        $insert_query = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$password')";

         
        if ($conn->query($insert_query) === TRUE) {
            echo "User added successfully.";
        } else {
            echo "Error adding user: " . $conn->error;
        }
    } else {
        echo "Error: Name, username, or password is empty.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $deleteId = $_POST['delete'];

 
    $delete_query = "DELETE FROM users WHERE id = '$deleteId'";
    if ($conn->query($delete_query) === TRUE) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}


     
    $select_query = "SELECT * FROM users";
    $result = $conn->query($select_query);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['password']}</td>
                    <td>
                        <button type='button' onclick='deleteUser({$row['id']})'>Delete</button>
                        <button type='button' onclick='editUser({$row['id']}, \"{$row['username']}\", \"{$row['password']}\")'>Edit</button>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No users in the 'users' table.</p>";
    }
    ?>

    <script>
        function openAddUserForm() {
            var form = document.getElementById("addUserForm");
            form.style.display = "block";
        }

        function deleteUser(Id) {
     
    var confirmDelete = confirm("Are you sure you want to delete this user?");
    if (confirmDelete) {
        
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "users.php";

         
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "delete";
        input.value = Id;
        form.appendChild(input);

        
        document.body.appendChild(form);

         
        form.submit();
    }
}

function editUser(Id, currentUsername, currentPassword) {
     
    var newUsername = prompt("Enter the new username:", currentUsername);
    var newPassword = prompt("Enter the new password:", currentPassword);

    if (newUsername !== null && newPassword !== null) {
         
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "users.php";

        
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "edit_user";
        input.value = Id;
        form.appendChild(input);

         
        input = document.createElement("input");
        input.type = "hidden";
        input.name = "new_username";
        input.value = newUsername;
        form.appendChild(input);

        
        input = document.createElement("input");
        input.type = "hidden";
        input.name = "new_password";
        input.value = newPassword;
        form.appendChild(input);

       
        document.body.appendChild(form);

        
        form.submit();
    }
}
    </script>

     
</body>

</html>
