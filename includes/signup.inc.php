<?php
if(isset($_POST["signupSubmit"]))
{
    //Grabbing the data
    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $address = $_POST["address"];
    $contactNumber = $_POST["contactNumber"];

    //Instantiate signup controller class
    include "../classes/dbh.classes.php";
    include "../classes/signup.classes.php";
    include "../classes/signup-contr.classes.php";
    $signup = new SignupContr($email,$name,$password,$confirmPassword,$address,$contactNumber);

    //Running error handlers and user sign up
    $signup->signupUser();

    //Going back to home page
    header("location: ../index.php?error=none");



}

?>