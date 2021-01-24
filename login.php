<?php
require_once "config.php";
require_once "session.php";
$error = '';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user_check_query = "SELECT * FROM users WHERE email = ?";

    //Validate if email is empty
    if(empty($email)) {
        $error .= '<p class="error">Please enter your email.</p>';
    }

    //Validate if password is empty
    if(empty($password)) {
        $error .= '<p class="error">Please enter your password.</p>';
    }
    
    if(empty($error)) {
        if($query = $db->prepare("SELECT id, name, password FROM users WHERE email = ?")) {
            $query->bind_param('s', $email);
            $query->execute();
            $query->bind_result($uid, $uname, $upassword);
            $row = $query->fetch();
            if ($row) {
                if (password_verify($password, $upassword)) {
                    $_SESSION["userid"] = $uid;
                    $_SESSION["uname"] = $uname;
                    $_SESSION["user"] = $row;

                    //Redirect the user to welcome page
                    header("location: dashboard.php");
                    exit;
                } else {
                    $error .= '<p class="error">The password is not valid.</p>';
                }   
            } else {
                $error .= '<p class="error">No User exist with that email address.</p>';
            }
        }
        $query->close();
    }
    //Close connection
    mysqli_close($db);
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
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
            <a class="active" href="login.php"><i class="fa fa-sign-in"></i> Login</a>
            <a href="https://github.com/rakeshswain123/nettantra2assign"><i class="fa fa-github"></i> Github</a>
            <a href="https://www.linkedin.com/in/rakesh-kumar-swain-aa0841a5/"><i class="fa fa-linkedin"></i> LinkedIn</a>
            <a href="register.php"><i class="fa fa-user-plus"></i> Sign Up</a>
        </div> 
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 style="padding: 50px; text-align: center">Please fill in you email and password</h3>
                    <?php echo $error; ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        </div>
                        <p>Don't have an account? <a href="register.php">Register</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>