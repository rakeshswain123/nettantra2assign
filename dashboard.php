<?php
    //Start the session
    session_start();

    if (isset($_SESSION['userid'])) {
        echo "";
    } else {
        header("Location: login.php");
        exit;
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
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
            <a class="active" href="dashboard.php"><i class="fa fa-fw fa-home"></i> Dashboard</a>
            <a href="https://github.com/rakeshswain123"><i class="fa fa-github"></i> Github</a>
            <a href="https://www.linkedin.com/in/rakesh-kumar-swain-aa0841a5/"><i class="fa fa-linkedin"></i> LinkedIn</a>
            <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </div>     
        
            <div>
            <h1 style="text-align:center; padding:20%;">Welcome to the dashboard</h1>
            </div>
    </body>
</html>