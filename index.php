<link rel="stylesheet" href="login2.css">
<?php
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $providedUsername = $_POST["username"];
    $providedPassword = $_POST["password"];

    $servername = "localhost";
    $username = "admin";
    $password = "123";
    $database = "payroll";
    $conn = new mysqli($servername, $username, $password, $database);

     
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

     
    $sql = "SELECT username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $providedUsername);
    $stmt->execute();
    $stmt->bind_result($username, $storedPassword);

     
    $stmt->fetch();

     
    if ($username && $providedPassword === $storedPassword) {
        session_start();
        $_SESSION["username"] = $providedUsername;  

         
        session_regenerate_id(true);

        header("Location: intro.php");  
        exit();
    } else {
        $error = "Invalid username or password";  
    }

     
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) {
            echo "<p style='color: red;'>$error</p>";
        } ?>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>

            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>
