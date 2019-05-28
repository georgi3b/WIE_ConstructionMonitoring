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

        require_once('../start/connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

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

            header("location:../start/home.php");
        } else {
            $_SESSION['coverError'] = "login";
            $_SESSION['coverRequest'] = "login";
            header("location:../start/index.php");
        }
    }
}

?>