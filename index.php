<?php
session_start();

 
if (!isset($_SESSION['Usua_Id'])) {
    
  header('Location: Views/Login.php');
    exit();
 }

// Include your main application template
require_once 'Services/Template.services.php';

$template = new ControllerTemplate();
$template->ControllerTemplate();
?>
