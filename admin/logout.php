<?php
// include constants.php for SITEURL
include('../config/constants.php');
// destroy session and redirect to login page
session_destroy(); //unset $_SESSION['user'] 
header('location:' . SITEURL . 'admin/login.php');
