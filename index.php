<?php
// session_start();

// // Check if the user is logged in
// if (!isset($_SESSION['Usua_Id'])) {
//     // User is not logged in, redirect to the login page
//     header('Location: Views/Login.php');
//     exit();
// }

// Include your main application template
require_once 'Services/Template.services.php';

$template = new ControllerTemplate();
$template->ControllerTemplate();
?>