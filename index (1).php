<?php
include 'includes/header.php';
include 'config/db.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'home':
        include 'pages/home.php';
        break;
    case 'register':
        include 'pages/register.php';
        break;
    case 'login':
        include 'pages/login.php';
        break;
    case 'dashboard':
        include 'includes/auth_check.php';
        include 'pages/dashboard.php';
        break;
    case 'book_appointment':
        include 'includes/auth_check.php';
        include 'pages/book_appointment.php';
        break;
    case 'view_appointments':
        include 'includes/auth_check.php';
        include 'pages/view_appointments.php';
        break;
    case 'payment_status':
        include 'includes/auth_check.php';
        include 'pages/payment_status.php';
        break;
    case 'patient_history':
        include 'includes/auth_check.php';
        include 'pages/patient_history.php';
        break;
    case 'admin_login':
        include 'pages/admin_login.php';
        break;
    case 'admin_dashboard':
        include 'pages/admin_dashboard.php';
        break;
    case 'admin_patients':
        include 'pages/admin_patients.php';
        break;
    case 'admin_appointments':
        include 'pages/admin_appointments.php';
        break;
    default:
        include 'pages/home.php';
}

include 'includes/footer.php';
?>