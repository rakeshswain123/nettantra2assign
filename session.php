<?php

// Start the session
session_start();

//If user is already logged in then redirect to welcome page
if(isset($_SESSION["userid"]) && $_SESSION["userid"] == true) {
    header("location : welcome.php");
    exit;
}

?>