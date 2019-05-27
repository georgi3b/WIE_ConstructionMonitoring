<?php
// Always start this first
session_start();

if (! empty($_POST)) {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
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

        $stmt1 = $conn->prepare("SELECT * FROM appuser WHERE u_mail = :email");
        $stmt1->execute(array(
            ':email' => $_POST['email']
        ));
        $user = $stmt1->fetchAll();

        if (! empty($user)) {
            $_SESSION['coverError'] = "register";
            $_SESSION['coverRequest'] = "register";
            header("location:CoverPage.php");
        } else {
            $stmt2 = $conn->prepare("INSERT INTO appuser (u_mail, u_name, password) VALUES (:email, :username, :password)");
            $stmt2->execute(array(
                ':email' => $_POST['email'],
                ':username' => $_POST['username'],
                ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
            ));
            if (isset($_SESSION['coverError'])) {
                unset($_SESSION['coverError']);
            }
            header("location:CoverPage.php#login");
        }
    }
}
?>

