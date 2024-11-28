<?php

class LoginContr extends Login {
    private $name;
    private $password;

    public function __construct($name, $password) {
        $this->name = $name;
        $this->password = $password;
    }

    public function loginUser() {
        if ($this->emptyInput() == false) {
            header("location: ../php/signup.php?error=emptyinput");
            exit();
        }
        
        // If all validations pass, set the user in the database
        $this->getUser($this->name, $this->password);
    }

    // Method to check for empty inputs
    private function emptyInput() {
        if (empty($this->name) || empty($this->password)) {
            return false; // There's an empty input
        } else {
            return true; // All inputs are filled
        }
    }

 

}

?>
