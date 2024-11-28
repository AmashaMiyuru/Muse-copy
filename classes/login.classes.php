<?php
class Login extends Dbh {

    protected function getUser($name, $password) {
        // Prepare the SQL statement to fetch user data
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE users_name = ? OR users_email = ?;');

        if (!$stmt->execute(array($name, $name))) {
            $stmt = null;
            header("location: ../php/login.php?error=stmtfailed");
            exit();
        }

        // Check if user exists
        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../php/login.php?error=usernotfound");
            exit();
        }

        // Fetch user data and verify the password
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($password, $user["users_password"]);

        if ($checkPwd == false) {
            $stmt = null;
            header("location: ../php/login.php?error=incorrectpassword");
            exit();
        } else {
            // Start session and store user information
            session_start();
            $_SESSION["userid"] = $user["users_id"];
            $_SESSION["username"] = $user["users_name"];
            $_SESSION["useremail"] = $user["users_email"];
            $_SESSION["useraddress"] = $user["users_address"];
            $_SESSION["userphone"] = $user["users_contactNumber"];
        }

        $stmt = null;
    }
}
?>
