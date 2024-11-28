<?php
if (isset($_POST["submit"])) {
    // Grabbing the data
    $name = $_POST["name"];
    $password = $_POST["password"];

    // Instantiate login controller class
    include "../classes/dbh.classes.php";
    include "../classes/login.classes.php";
    include "../classes/login-contr.classes.php";
    $login = new LoginContr($name, $password);

    // Running error handlers and user login
    $login->loginUser();

    // Redirect to index.php after successful login
    header("location: ../php/index.php");
    exit();
}
?>
