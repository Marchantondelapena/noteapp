<?php
// Include config.php and establish database connection
include "config.php";

// Define variables and initialize with empty values
$fname = $lname = $username = $email = $password = "";
$fname_err = $lname_err = $username_err = $email_err = $password_err = "";
$form_submitted = false;
$registration_success = false;
$emailError = $passwordError = ""; // Initialize error variables

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the registration form is submitted
    if (isset($_POST['register'])) {
        $form_submitted = true;

        // Validate first name
        if (empty(trim($_POST["fname"]))) {
            $fname_err = "Please enter your first name.";
        } else {
            $fname = trim($_POST["fname"]);
        }

        // Validate last name
        if (empty(trim($_POST["lname"]))) {
            $lname_err = "Please enter your last name.";
        } else {
            $lname = trim($_POST["lname"]);
        }

        // Validate username
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter a username.";
        } else {
            $username = trim($_POST["username"]);
        }

        // Validate email
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter your email address.";
        } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
            $email_err = "Please enter a valid email address.";
        } else {
            $email = trim($_POST["email"]);
        }

        // Validate password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter a password.";
        } else {
            $password = trim($_POST["password"]);
        }

        // Check if all fields are filled
        if (empty($fname_err) && empty($lname_err) && empty($username_err) && empty($email_err) && empty($password_err)) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare an SQL statement for registration
            $sql = "INSERT INTO user (p_fname, p_lname, p_username, p_email, p_password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $fname, $lname, $username, $email, $hashed_password);

            // Execute SQL statement
            if ($stmt->execute()) {
                $registration_success = true;
                echo '<script>
                        alert("Registration successful! You can now login.");
                        window.location.href = "homepage.php";
                      </script>';
                exit(); // Ensure that subsequent code is not executed after redirection
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Close statement and connection
            $stmt->close();
        }
    } elseif (isset($_POST['login'])) { // Check if the login form is submitted
        // Retrieve POST data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Email format validation
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format.";
        }

        // Password validation (optional)
        if (empty($password)) {
            $passwordError = "Password is required.";
        }

        if (empty($emailError) && empty($passwordError)) {
            // Query to fetch user based on email
            $sql = "SELECT * FROM user WHERE p_email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                $row = $result->fetch_assoc();
                if ($row) {
                    // Verify hashed password
                    if (password_verify($password, $row['p_password'])) {
                        // Password is correct, redirect to dash.php
                        header("Location: dash.php");
                        exit();
                    } else {
                        // Password is incorrect
                        $passwordError = "Invalid email or password.";
                    }
                } else {
                    // No user found with the given email
                    $passwordError = "Invalid email or password.";
                }
            } else {
                // Query execution failed
                echo "Error: " . $conn->error;
            }
        }
    }
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>Home</title>


</head>
<body>
   <!-- Navbar -->
   <nav>
      <div class="logo">
         <h1><span class="note">Note</span><span class="it">It!</span></h1>
      </div>
      <ul class="navs">
         <li><a href="#" id="homeLink">HOME</a></li>
         <li><a href="#" id="registerLink">REGISTER</a></li>
         <li><a href="#" id="signInButton">SIGN IN</a></li> <!-- Update ID -->
      </ul>
   </nav>


   
   <div class="login-form-container" id="loginFormContainer">
    <div class="container1">
        <div class="heading">Note<span class="green-text">It!</span></div>
        <form class="form" method="post" action="" novalidate> <!-- Add the 'novalidate' attribute here -->
            <input placeholder="Email" id="email" name="email" type="email" class="input">
            <span id="email-error" class="error-message"><?php echo $emailError;?></span>
            <input placeholder="Password" id="password" name="password" type="password" class="input">
            <span class="error"><?php echo $passwordError;?></span>
            <div class="forgot-password">
                <a href="#">Sign Up</a>
                <a href="#">Forgot Password?</a>
            </div>
            <input value="Log In" type="submit" class="login-button" > <!-- Disabled submit button -->
        </form>
    </div>
</div>


<div id="registrationFormContainer" class="login-form-container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form">
        <p class="title">Register</p>
        <p class="message">Signup now and get full access to our app.</p>
        <div class="flex">
            <label>
                <input placeholder="" type="text" class="input" name="fname" id="fname" value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>">
                <span>First Name</span>
            </label>
            <label>
                <input placeholder="" type="text" class="input" name="lname" id="lname" value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : ''; ?>">
                <span>Last Name</span>
            </label>
        </div>
        <?php if ($form_submitted && empty(trim($_POST["fname"]))): ?>
            <div style="color: red;"><?php echo $fname_err; ?></div>
        <?php endif; ?>
        <?php if ($form_submitted && empty(trim($_POST["lname"]))): ?>
            <div style="color: red;"><?php echo $lname_err; ?></div>
        <?php endif; ?>
        <label>
            <input placeholder="" type="text" class="input" name="username" id="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            <span>Username</span>
        </label>
        <div style="color: red;"><?php echo $username_err; ?></div>
        <label>
            <input placeholder="" type="text" class="input" name="email" id="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <span>Email</span>
        </label>
        <div style="color: red;"><?php echo $email_err; ?></div>
        <label>
            <input placeholder="" type="password" class="input" name="password" id="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">
            <span>Password</span>
        </label>
        <div style="color: red;"><?php echo $password_err; ?></div>
        <button type="submit" class="submit">Submit</button>
        <p class="signin">Already have an account? <a href="login.php">Signin</a></p>
    </div>
</form>
</div>

   <!-- Homepage content -->
  <div id="homePage">
      <div class="container">
         <div class="grid-container">
            <div class="grid1">
               <img src="imgs/m.png" alt="">
            </div>
            <div class="grid2">
               <div class="logo1">
                  <h1><span class="note1">Note</span><span class="it">It!</span></h1>
               </div>
               <h5>Meet Notelt!, the modernized app that makes</h5>
               <h5>note-taking a breeze. Jot down ideas</h5>
               <h5>effortlessly, organize them with ease, and</h5>
               <h5>retrieve information lightning-fast. Its</h5>
               <h5>customized formatting options and ideal</h5>
               <h5>sharing capabilities make Notelt! an</h5>
               <h5>indispensable tool for maximizing your</h5>
               <h5>efficiency.</h5>
               <div>
                  <!-- Sign In button with animation -->
                  <button class="btn" id="signInButton2"><i class="animation"></i>Sign In<i class="animation"></i></button>
               </div>
            </div>
         </div>
      </div>
   </div>


   <script>
document.addEventListener("DOMContentLoaded", function() {
    const loginFormContainer = document.getElementById("loginFormContainer");
    const registrationFormContainer = document.getElementById("registrationFormContainer");
    const homePage = document.getElementById("homePage");
    const registerLink = document.getElementById("registerLink");
    const signInButton2 = document.getElementById("signInButton2");
    const signInButton = document.getElementById("signInButton"); // Add this line

    // Function to hide all forms and display the login form
    function showLoginForm() {
        loginFormContainer.style.display = "block";
        registrationFormContainer.style.display = "none";
        homePage.style.display = "none";
    }

    // Event listeners
    registerLink.addEventListener("click", function(event) {
        event.preventDefault();
        loginFormContainer.style.display = "none";
        registrationFormContainer.style.display = "block";
        homePage.style.display = "none";
    });

    signInButton2.addEventListener("click", function(event) {
        event.preventDefault(); // Prevent the default form submission behavior
        showLoginForm(); // Display the login form
    });

    signInButton.addEventListener("click", function(event) {
        event.preventDefault();
        showLoginForm(); // Display the login form
    });

    // Additional event listeners for home and sign in links (if needed)
    // ...

    // Check if there are errors in the form submission
    const fnameError = "<?php echo $fname_err; ?>";
    const lnameError = "<?php echo $lname_err; ?>";
    const usernameError = "<?php echo $username_err; ?>";
    const emailError = "<?php echo $email_err; ?>";
    const passwordError = "<?php echo $password_err; ?>";

    if (fnameError || lnameError || usernameError || emailError || passwordError) {
        loginFormContainer.style.display = "none";
        registrationFormContainer.style.display = "block";
        homePage.style.display = "none";
    }

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
});
</script>
</body>
</html>
