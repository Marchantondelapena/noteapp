<?php
// Define variables and initialize with empty values
$fname = $lname = $username = $email = $password = "";
$fname_err = $lname_err = $username_err = $email_err = $password_err = "";
$form_submitted = false;
$registration_success = false;

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_submitted = true;

    // Validate first name
    if (empty(trim($_POST["fname"]))) {
        $fname_err = "Please enter your first name";
    } else {
        $fname = trim($_POST["fname"]);
    }

    // Validate last name
    if (empty(trim($_POST["lname"]))) {
        $lname_err = "Please enter your last name";
    } else {
        $lname = trim($_POST["lname"]);
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address";
    } else {
        $email = trim($_POST["email"]);
    }
    

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check if all fields are filled
    if (empty($fname_err) && empty($lname_err) && empty($username_err) && empty($email_err) && empty($password_err)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Establish a database connection
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $dbname = "notepad";

        // Create connection
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare an SQL statement
        $sql = "INSERT INTO user (p_fname, p_lname, p_username, p_email, p_password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $fname, $lname, $username, $email, $hashed_password);

        // Execute SQL statement
        if ($stmt->execute()) {
            $registration_success = true;
            echo '<script>
                    alert("Registration successful! You can now login");
                    window.location.href = "homepage.php";
                  </script>';
            exit(); // Ensure that subsequent code is not executed after redirection
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<style>
#registrationFormContainer .form {
  display: flex;
  flex-direction: column;
  gap: 8px;
  max-width: 500px;
  background-color: #fff;
  padding: 20px;
  border-radius: 20px;
  position: relative;
  margin: 0 auto;
  font-family: "Poppins", sans-serif;
}

.input-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.error-message {
    color: red;
    text-align: center;
    margin-left: -50px;
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
  margin-bottom: 15px;
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
        gap: 5.7px;  
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
   top: 39px;
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


<div id="registrationFormContainer" class="login-form-container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form">
            <p class="title">Register</p>
            <p class="message">Signup now and get full access to our app.</p>
            <div class="flex">
                <div class="input-container">
                    <label>
                        <input placeholder="" type="text" class="input" name="fname" id="fname" value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>">
                        <span>First Name</span>
                    </label>
                    <div class="error-message"><?php echo $fname_err; ?></div>
                </div>
                <div class="input-container">
                    <label>
                        <input placeholder="" type="text" class="input" name="lname" id="lname" value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : ''; ?>">
                        <span>Last Name</span>
                    </label>
                    <div class="error-message"><?php echo $lname_err; ?></div>
                </div>
            </div>
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



</body>
</html>
