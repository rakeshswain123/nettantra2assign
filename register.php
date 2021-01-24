<?php
require_once "config.php";
require_once "session.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    if($query = $db->prepare("SELECT * from users WHERE email = ?")) {
        $error = '';
        
        // Bind parameters (s = string, i = int, b = blob, etc), in out case the username is a string so we use "s"
        $query->bind_param('s', $email);
        $query->execute();

        //Store the result so we can check if the account exists in the database.
        $query->store_result();
        if($query->num_rows > 0) {
            $error .= '<p class="error">The email address is already registered!</p>';
        } else {
            //Validate password
            if(strlen($password) < 6) {
                $error .= '<p class="error">Password must have atleast 6 characters.</p>';
            }

            //Validate confirm password
            if(empty($confirm_password)) {
                $error .= '<p class="error">Please enter coonfirm password.</p>';
            } else {
                if(empty($error) && ($password != $confirm_password)) {
                    $error .= '<p class="error">Password did not match.</p>';
                }
            }

            if(empty($error)) {
                $insertQuery = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?);");
                $insertQuery->bind_param("sss", $fullname, $email, $password_hash);
                $result = $insertQuery->execute();
                if($result) {
                    $error .= '<p class="success">Your registration was sucessful!</p>';
                } else {
                    $error .= '<p class="error">Something went wrong!</p>';
                }
            }

        }

    }

    $query->close();
    $insertQuery->close();

    //Close DB connection
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            /* Style the navigation bar */
            .navbar {
            width: 100%;
            background-color: #6E81BE;
            overflow: auto;
            }

            /* Navbar links */
            .navbar a {
            float: left;
            text-align: center;
            padding: 12px;
            color: white;
            text-decoration: none;
            font-size: 17px;
            }

            /* Navbar links on mouse-over */
            .navbar a:hover {
            background-color: #B4C7FF;
            }

            /* Current/active navbar link */
            .active {
            background-color: #4863A0;
            }

            /* Add responsiveness - will automatically display the navbar vertically instead of horizontally on screens less than 500 pixels */
            @media screen and (max-width: 500px) {
            .navbar a {
                float: none;
                display: block;
            }
            }
        </style>
    </head>
    <body style="background-color:#BFAD6F">
        <div class="navbar">
            <a class="active" href="register.php"><i class="fa fa-user-plus"></i> Sign Up</a>
            <a href="https://github.com/rakeshswain123/nettantra2assign"><i class="fa fa-github"></i> Github</a>
            <a href="https://www.linkedin.com/in/rakesh-kumar-swain-aa0841a5/"><i class="fa fa-linkedin"></i> LinkedIn</a>
            <a href="login.php"><i class="fa fa-sign-in"></i> Login</a>
        </div> 
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 style="padding: 50px; text-align: center">Please fill the form to create an account</h3>

                    <!-- <?php echo $success; ?>
                    <?php echo $error; ?> -->
                    
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        </div>
                        <p>Already have a account? <a href="login.php">Login here</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>