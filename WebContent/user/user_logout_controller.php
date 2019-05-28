<?php
session_start();
session_destroy();
header('Location:../start/index.php');
exit;
?>

