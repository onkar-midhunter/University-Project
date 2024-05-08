



<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your PHP code here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: rgba(10, 34, 57, 0.8); /* Dark blue with opacity */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            color: #fff;
            width: 300px;
        }

        input[type="text"],
        input[type="password"],
        input[type="username"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #193549; /* Dark blue */
            color: #fff;
        }

        input[type="submit"],
        input[type="button"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #FF4E00; /* Orange */
            color: #fff;
        }
        @media (max-width: 600px) {
            form {
                width: 75%; /* Make the form take up 90% of the screen width */
            }
        }
    </style>
</head>

<body>
    <form method="post">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
</body>
</html>
<?php
include("database.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM register WHERE userName = '$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])){
            $_SESSION['username'] = $username;
            header("Location: ../index.php"); // Changed this line
            exit;
        }else{
            echo "Invalid password.";
        }
    }else{
        echo "Invalid username.";
    }
}

mysqli_close($conn);
?>
