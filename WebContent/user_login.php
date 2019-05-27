<?php
// Always start this first
session_start();

if (! empty($_POST)) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Getting submitted user data from database
        $servername = "dumbo.db.elephantsql.com";
        $dbname = "ajuplode";
        $username = "ajuplode";
        $password = "iU-Fy_Gx3BL7bXslEOBvslItAPO2xTaF";

        try {
            $conn = new PDO("pgsql:host=$servername;dbname=$dbname", $username, $password, array(
                PDO::ATTR_PERSISTENT => true
            ));
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {}

        $stmt = $conn->prepare("SELECT * FROM appuser WHERE u_mail = :email");
        $stmt->execute(array(
            ':email' => $_POST['email']
        ));
        $user = $stmt->fetchObject();

        // Verify user password and set $_SESSION

        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['user_id'] = $user;

            if (isset($_SESSION['coverError'])) {
                unset($_SESSION['coverError']);
            }

            header("location:exampleHome.php");
        } else {
            $_SESSION['coverError'] = "login";
            $_SESSION['coverRequest'] = "login";
            header("location:index.php");
        }
    }
}

?>