

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
          body {
            font-family: Arial, sans-serif;
            background-color: black; /* Add your image path here */
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
                width: 90%; /* Make the form take up 90% of the screen width */
            }
        }
    </style>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Register</h2>
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="course" placeholder="Course Name" required>
        <input type="username" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <div>
            Gender:
            <input type="radio" name="gender" value="male" id="male" required>
            <label for="male">Male</label>
            <input type="radio" name="gender" value="female" id="female">
            <label for="female">Female</label>
            <input type="radio" name="gender" value="other" id="other">
            <label for="other">Other</label>
        </div>
        <input type="submit" value="Register">
        <input type="button" value="Login" onclick="window.location.href='login.php';">
    </form>
</body>
</html>
<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $course = filter_input(INPUT_POST, "course", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = $_POST["username"];
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $gend = $_POST["gender"];
    $gender = filter_var($gend, FILTER_SANITIZE_STRING);

    if (empty($name)) {
        echo "enter a name";
    } elseif (empty($course)) {
        echo "enter a course Name";
    } elseif (empty($username)) {
        echo "enter a valid username";
    } elseif (empty($password)) {
        echo "enter a password";
    } elseif (empty($gender)) {
        echo "select a valid gender";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO register(Name,courseName,userName,password,gender)
                VALUES('$name','$course','$username','$hash','$gender')";
        try {
            mysqli_query($conn, $sql);
        } catch (mysqli_sql_exception $e) {
            // Handle exception
            echo "Error: " . $e->getMessage();
        }
        
        // Redirect to login page
        header("Location: login.php");
        exit(); // Ensure script execution stops after redirection
    }
}

mysqli_close($conn);
?>
