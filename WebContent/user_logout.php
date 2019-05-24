<?php
session_start();
session_destroy();
header('Location: CoverPage.php');
exit;
?>

