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
                // Redirect to homepage after successful registration
                header("Location: homepage.php");
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
            // Prepare and execute SQL query to fetch user data based on email
            $sql = "SELECT * FROM user WHERE p_email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                // Store query result
                $result = $stmt->get_result();

                // Check if user exists and verify password
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
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
                    $passwordError = "Invalid email ";
                }
            } else {
                // Query execution failed
                echo "Error: " . $conn->error;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');

* {
   box-sizing: border-box;
   margin: 0;
   padding: 0;
}  

body {
   margin: 0;
   padding: 0px 0 70px;
   overflow: scroll;
   background-size: 500% 500%;
   animation: gradient 5s ease infinite;
}

nav {
   background: linear-gradient(to right, transparent, transparent);
   backdrop-filter: blur(10px);
   position: fixed;
   width: 100%;
   z-index: 999;
   top: 0;
   list-style: none;
   display: flex;
   justify-content: space-between;
   padding: 20px 70px;
   align-items: center;
}

nav ul {
   display: flex;
   justify-content: flex-end;
   list-style: none;
}

nav ul li {
   margin: 0 10px;
}

nav ul li a {
   color: #292929;
   text-decoration: none;
   font-weight: bold;
   font-family: "Poppins", sans-serif; /* Add this line */
}

nav li a:hover {
   color: #5D61EA;
}

.logo {
   font-size: 25px;
   text-decoration: none;
   cursor: pointer;
   font-family: "Poppins", sans-serif;
   font-weight: bold;
   font-style: normal;
}

.logo h1 {
   display: inline;
   margin-right: 20px;
}

.logo h1 span.note {
   color: black;
}

.logo h1 span.it {
   color: green;
}

.logo1 {
   font-weight: 300;
   font-size: 25px;
   text-decoration: none;
   cursor: pointer;
   position: relative;
   top: -10%;
   margin-bottom: 25px;
   font-family: "Poppins", sans-serif;
   font-style: normal;
}

.logo1 h1 {
   display: inline;
}

.logo1 h1 span.note1 {
   color: black;
}

.logo1 h1 span.it {
   color: green;
}

.grid-container {
   display: grid;
   grid-template-columns: 1fr 1fr;
   margin-top: 56px;
}

.grid1 img {
   max-width: 100%;
   height: 70%;
   margin-left: 10%;   
   width: 90%;
   margin-top: 10%;
}

.grid2 {
   margin-top: 10%;
   background-color: #e0f2ff;
   padding: 40px 20px 20px;
   font-size: 10px;
   color: #292929;
   margin-right: 17%;
   text-align: center;
   display: flex;
   flex-direction: column;
   justify-content: center;
   align-items: center;
   height: 75%; 
   font-family: "Poppins", sans-serif;
   font-weight: 100;
   font-style: normal;  
}

.grid2 h5 {
   position: relative;
   top: -7%;
   margin-top: 0;
   display: inline-block;
   text-align: center;
   line-height: 2;
   margin: 0 auto;
   word-wrap: normal;
   font-size: 21px;
   font-family: "Quicksand", sans-serif;
   font-optical-sizing: auto;
   font-style: normal;
}
.btn {
  outline: 0;
  display: inline-flex;
  align-items: center;
  justify-content: space-between;
  background: #40B3A2;
  min-width: 200px;
  border: 0;
  border-radius: 4px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
  box-sizing: border-box;
  padding: 16px 20px;
  color: #fff;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 1.2px;
  text-transform: uppercase;
  overflow: hidden;
  cursor: pointer;
}

.btn:hover {
  opacity: .95; /* Reduce opacity on hover */
}

.btn .animation {
  border-radius: 100%; /* Make the animation circle */
  animation: ripple 0.6s linear infinite; /* Apply the ripple animation */
}

@keyframes ripple {
  0% {
    box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.1), 
                0 0 0 20px rgba(255, 255, 255, 0.1), 
                0 0 0 40px rgba(255, 255, 255, 0.1), 
                0 0 0 60px rgba(255, 255, 255, 0.1);
  }

  100% {
    box-shadow: 0 0 0 20px rgba(255, 255, 255, 0.1), 
                0 0 0 40px rgba(255, 255, 255, 0.1), 
                0 0 0 60px rgba(255, 255, 255, 0.1), 
                0 0 0 80px rgba(255, 255, 255, 0);
  }
}

/* Login form styles */
 .container1 {
   max-width: 694px;
   background: #f8f9fd;
   background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(244, 247, 251) 100%);
   border-radius: 40px;
   padding: 90px 170px;
   border: 5px solid rgb(255, 255, 255);
   box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
   margin: 310px;
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


.login-form-container {
   display: none;
   position: fixed;
   top: 58%;
   left: 50%;
   transform: translate(-50%, -50%);
   background-color: #ffffff;
   padding: 100px;
   border-radius: 10px;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
   max-width: 150%;
   width: 100%;
}

.login-form-container .heading {
   text-align: center;
   font-weight: bold;
   font-size: 24px;
   margin-bottom: 20px;
   color: #333333;
}

.login-form-container .form {
   margin-top: 20px;
}

.login-form-container .input {
   width: 100%;
  
   border: none;
   padding: 15px;
   border-radius: 5px;
   margin-top: 10px;
   box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.login-form-container .input:focus {
   outline: none;
   border: 1px solid #5D61EA;
}

.login-form-container .forgot-password,
.login-form-container .signup {
   display: flex;
   justify-content: space-between;
   margin-top: 10px;
}

.login-form-container .forgot-password a,
.login-form-container .signup a {
   font-size: 14px;
   color: #5D61EA;
   text-decoration: none;
}

.login-form-container .login-button {
   display: block;
   width: 100%;
   font-weight: bold;
   background-color: #5D61EA;
   color: #ffffff;
   padding: 15px;
   margin-top: 20px;
   border: none;
   border-radius: 5px;
   cursor: pointer;
   transition: background-color 0.3s ease;
}

.login-form-container .login-button:hover {
   background-color: #3f46e3;
}

/* Registration form styles */
#registrationFormContainer .form {
  display: flex;
  flex-direction: column;
  gap: 3px;
  max-width: 500px;
  background-color: #fff;
  padding: 20px;
  border-radius: 20px;
  position: relative;
  margin: 0 auto;
}


#registrationFormContainer .title {
   font-size: 40px;
  color: royalblue;
  font-weight: 600;
  letter-spacing: -1px;
  position: relative;
  display: flex;
  align-items: center;
  padding-left: 30px;
}

#registrationFormContainer .title::before,
#registrationFormContainer .title::after {
   position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  border-radius: 50%;
  left: 0px;
  background-color: royalblue;
}

#registrationFormContainer .title::before {
   width: 18px;
  height: 18px;
  background-color: royalblue;
}

#registrationFormContainer .title::after {
   width: 18px;
  height: 18px;
  animation: pulse 1s linear infinite;
}

#registrationFormContainer .message,
#registrationFormContainer .signin {
   color: rgba(88, 87, 87, 0.822);
  font-size: 20px;
}

#registrationFormContainer .signin {
   text-align: center;
}

#registrationFormContainer .signin a {
   color: royalblue;
}

#registrationFormContainer .signin a:hover {
   text-decoration: underline royalblue;
}

#registrationFormContainer .flex {
   display: flex;
        width: 100%;
        gap: 0.7px;  
}

#registrationFormContainer .flex label {
   flex: 1; 
}

#registrationFormContainer .form label {
   position: relative;
   flex: 1;
   margin-right: 10px;
}

#registrationFormContainer .form label .input {
   width: 100%;
  padding: 7px 0px 15px 10px;
  outline: 0;
  border: 1px solid rgba(105, 105, 105, 0.397);
  border-radius: 10px;
  font-size: 25px;
}

#registrationFormContainer .form label .input + span {
   position: absolute;
  left: 10px;
  top: 15px;
  color: grey;
  font-size: 0.9em;
  cursor: text;
  transition: 0.3s ease;
}



#registrationFormContainer .form label .input:placeholder-shown + span {
   top: 15px;
   font-size: 1.7em;
}

#registrationFormContainer .form label .input:focus + span,
#registrationFormContainer .form label .input:valid + span {
   top: 48px;
   font-size: 0.7em;
   font-weight: 600;
}

#registrationFormContainer .form label .input:valid + span {
   color: green;
}

#registrationFormContainer .form label:nth-child(2) {
   margin-right: 10px;
}

#registrationFormContainer .submit {
   border: none;
   outline: none;
   background-color: royalblue;
   padding: 10px;
   border-radius: 100px;
   color: #fff;
   font-size: 20px;
   transform: .3s ease;
   margin-right: 10px;
   margin-top: 10px;
}

#registrationFormContainer .submit:hover {
   background-color: rgb(56, 90, 194);
}





@keyframes pulse {
   from {
      transform: scale(0.9);
      opacity: 1;
   }
   to {
      transform: scale(1.8);
      opacity: 0;
   }
}

   </style>
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

   <div id="homePage">
      <div class="container">
         <div class="grid-container">
            <div class="grid1">
               <img src="imgs/ac.jpg" alt="">
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





<script> 
document.addEventListener("DOMContentLoaded", function() {
    const loginFormContainer = document.getElementById("loginFormContainer");
    const registrationFormContainer = document.getElementById("registrationFormContainer");
    const homePage = document.getElementById("homePage");
    const registerLink = document.getElementById("registerLink");
    const signInButton2 = document.getElementById("signInButton2");
    const signInButton = document.getElementById("signInButton"); // Add this line


    registerLink.addEventListener("click", function(event) {
        event.preventDefault();
        window.location.href = "register.php"; // Redirect to register.php
    });
 // Event listener for Sign In button
 signInButton2.addEventListener("click", function(event) {
        event.preventDefault();
        window.location.href = "login.php"; // Redirect to login.php
    });

    // Event listener for Sign In button
    signInButton.addEventListener("click", function(event) {
        event.preventDefault();
        window.location.href = "login.php"; // Redirect to login.php
    });
    // Hide login form and registration form by default
    loginFormContainer.style.display = "none";
    registrationFormContainer.style.display = "none";
    homePage.style.display = "block"; // Show home page by default

    // Event listener for register link
    registerLink.addEventListener("click", function(event) {
        event.preventDefault();
        loginFormContainer.style.display = "none";
        registrationFormContainer.style.display = "block";
        homePage.style.display = "none";
    });

    signInButton.addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    window.location.href = "login.php"; // Redirect to login.php
});


signInButton2.addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    window.location.href = "login.php"; // Redirect to login.php
});
    // Event listener for sign in link
    signInLink.addEventListener("click", function(event) {
        event.preventDefault();
        loginFormContainer.style.display = "block"; // Show login form
        registrationFormContainer.style.display = "none";
        homePage.style.display = "none";
    });

    // Event listener for home link
    homeLink.addEventListener("click", function(event) {
        event.preventDefault();
        loginFormContainer.style.display = "none";
        registrationFormContainer.style.display = "none";
        homePage.style.display = "block"; // Show home page
    });

    // Event listener for Sign In button
    signInButton.addEventListener("click", function(event) {
        event.preventDefault();
        loginFormContainer.style.display = "block"; // Show login form
        registrationFormContainer.style.display = "none";
        homePage.style.display = "none";
    });

    signInButton2.addEventListener("click", function(event) {
        event.preventDefault();
        loginFormContainer.style.display = "block"; // Show login form
        registrationFormContainer.style.display = "none";
        homePage.style.display = "none";
    });
    

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
