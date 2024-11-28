<?php

class SignupContr extends Signup {
    private $email;
    private $name;
    private $password;
    private $confirmPassword;
    private $address;
    private $contactNumber;

    public function __construct($email, $name, $password, $confirmPassword, $address, $contactNumber) {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
        $this->address = $address;
        $this->contactNumber = $contactNumber;
    }

    public function signupUser() {
        if ($this->emptyInput() == false) {
            header("location: ../php/signup.php?error=emptyinput");
            exit();
        }
        if ($this->isValidEmail() == false) {
            header("location: ../php/signup.php?error=invalidEmail");
            exit();
        }
        if ($this->pwdMatch() == false) {
            header("location: ../php/signup.php?error=passwordmismatch");
            exit();
        }
        
        // If all validations pass, set the user in the database
        $this->setUser($this->email, $this->name, $this->password, $this->address, $this->contactNumber);
    }

    // Method to check for empty inputs
    private function emptyInput() {
        if (empty($this->email) || empty($this->name) || empty($this->password) || empty($this->confirmPassword) || empty($this->address) || empty($this->contactNumber)) {
            return false; // There's an empty input
        } else {
            return true; // All inputs are filled
        }
    }

    // Method to validate the email format
    private function isValidEmail() {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }

    // Method to check if the passwords match
    private function pwdMatch() {
        if ($this->password !== $this->confirmPassword) {
            return false;
        } else {
            return true;
        }
    }


}

?>
