<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCare Clinic Management System</title>
    <link rel="stylesheet" href="<?php echo (isset($_GET['page']) && $_GET['page'] != 'home') ? '../' : ''; ?>css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <h1>SmartCare Clinic</h1>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php?page=home">Home</a></li>
                <?php if (isset($_SESSION['patient_id'])): ?>
                    <li><a href="index.php?page=dashboard">Dashboard</a></li>
                    <li><a href="index.php?page=view_appointments">Appointments</a></li>
                    <li><a href="index.php?page=payment_status">Payments</a></li>
                    <li><a href="index.php?page=patient_history">Medical History</a></li>
                    <li><a href="pages/logout.php">Logout</a></li>
                <?php elseif (isset($_SESSION['admin_id'])): ?>
                    <li><a href="index.php?page=admin_dashboard">Dashboard</a></li>
                    <li><a href="index.php?page=admin_patients">Patients</a></li>
                    <li><a href="index.php?page=admin_appointments">Appointments</a></li>
                    <li><a href="pages/admin_logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="index.php?page=login">Patient Login</a></li>
                    <li><a href="index.php?page=register">Register</a></li>
                    <li><a href="index.php?page=admin_login">Admin Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>