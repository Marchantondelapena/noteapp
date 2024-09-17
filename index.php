<?php
session_start(); // Start the session
include  "config.php";
// Initialize variables to empty strings
$email = $password = $email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        require_once "config.php"; // Assuming you have a separate file for database connection
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Email format validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        } else {
            // Prepare and bind the SQL statement
            $sql = "SELECT * FROM user WHERE p_email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $userData = $result->fetch_assoc();
                if (password_verify($password, $userData['p_password'])) {
                    $_SESSION['username'] = $email; // Set username in session
                    $_SESSION['user_id'] = $userData['p_id']; // Optionally, store user ID in session
                    // Redirect to dashboard
                    header("Location: dash.php");
                    exit();
                } else {
                    // Incorrect password
                    $password_err = "Invalid password";
                }
            } else {
                // User not found
                $email_err = "User not found";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <style>
     body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            font-family: "Poppins", sans-serif;
        }

        .container {
            max-width: 350px;
            background: #f8f9fd;
            background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(244, 247, 251) 100%);
            border-radius: 40px;
            padding: 90px 35px;
            border: 5px solid rgb(255, 255, 255);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
            margin: 20px;
            
        }

        .heading {
            text-align: center;
            font-weight: 900;
            font-size: 50px;
            color: rgb(16, 137, 211);
            margin-bottom: 20px;
        }

        .form {
            margin-top: 20px;
        }

        .form .input {
            width: 100%;
            background: white;
            border: none;
            padding: 25px 5px;
            border-radius: 20px;
            margin-top: 25px;
            box-shadow: #cff0ff 0px 10px 10px -5px;
            border-inline: 2px solid transparent;
        }

        .form .input::-moz-placeholder {
            color: rgb(170, 170, 170);
        }

        .form .input::placeholder {
            color: rgb(170, 170, 170);
        }

        .form .input:focus {
            outline: none;
            border-inline: 2px solid #12b1d1;
        }

        .form .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .form .forgot-password,
        .form .signup {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .form .forgot-password a,
        .form .signup a {
            font-size: 11px;
            color: #0099ff;
            text-decoration: none;
        }

        .form .login-button {
            display: block;
            width: 100%;
            font-weight: bold;
            background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
            color: white;
            padding-block: 15px;
            margin: 20px auto;
            border-radius: 20px;
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 20px 10px -15px;
            border: none;
            transition: all 0.2s ease-in-out;
        }

        .form .login-button:hover {
            transform: scale(1.03);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 23px 10px -20px;
        }

        .form .login-button:active {
            transform: scale(0.95);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 15px 10px -10px;
        }
        .green-text {
            color: green;
        }

        .forgot-password{
            font-size: 40px;
        }


    </style>
</head>

<body>
<div class="container"> 
    <div class="heading">Note<span class="green-text">It!</span></div>
    <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
        <div>
          
            <input placeholder="Email" id="email" name="email" type="email" class="input" value="<?php echo htmlspecialchars($email); ?>">
            <span class="error-message"><?php echo $email_err; ?></span>
        </div>
        <div>
        
            <input placeholder="Password" id="password" name="password" type="password" class="input">
            <span id="password-error" class="error-message"><?php echo $password_err; ?></span>

            <!-- Password visibility toggle -->
            <input type="checkbox" id="show-password">
            <label for="show-password" style="color: #0099ff;">Show Password</label>

        </div>
        <div class="forgot-password">
        <a href="register.php" style="font-size: 16px;">Sign Up</a>
            <a href="#" style="font-size: 16px;">Forgot Password?</a>

        </div>
        <input value="Sign In" type="submit" name="login" class="login-button">
    </form>
</div>
        
<script>
    document.getElementById('email').addEventListener('input', function(event) {
        document.getElementById('email-error').textContent = ''; // Clear the error message when typing
        var email = event.target.value;
        var emailError = document.getElementById('email-error');
        if (email === '' || !validateEmail(email)) {
            emailError.textContent = 'Invalid email format.';
        }
    });

    function validateEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    // Add event listener for password visibility toggle
    document.getElementById('show-password').addEventListener('change', function() {
        var passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    });
</script>
</body>
</html>
