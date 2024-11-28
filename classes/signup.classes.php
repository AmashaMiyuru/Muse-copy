<?php
class Signup extends Dbh {

    protected function setUser($email,$name,$password,$address,$contactNumber){
        $stmt = $this->connect()->prepare('INSERT INTO users (users_email,users_name,users_password,users_address,users_contactNumber) VALUES (?,?,?,?,?);');

        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        if(!$stmt->execute(array($email,$name,$hashedPwd,$address,$contactNumber))){
            $stmt = null;
            header("../php/index.php?error=stmtfailed");
            exit();
        
        }
        $stmt=null;
    }
    protected function checkUser($email) {
        $stmt = $this->connect()->prepare('SELECT users_id FROM users WHERE users_email = ?;');
    
        if (!$stmt->execute(array($email))) {
            $stmt = null;
            header("location: ../php/signup.php?error=stmtfailed");
            exit();
        }
    
        return $stmt->rowCount() > 0; // Return true if the user exists
    }
    
    
}

?>