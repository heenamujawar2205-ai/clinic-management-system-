<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?page=admin_login");
    exit;
}

// Get statistics
$total_patients = $conn->query("SELECT COUNT(*) as count FROM patients")->fetch_assoc()['count'];
$total_appointments = $conn->query("SELECT COUNT(*) as count FROM appointments")->fetch_assoc()['count'];
$pending_payments = $conn->query("SELECT COUNT(*) as count FROM payments WHERE status = 'Pending'")->fetch_assoc()['count'];
$completed_treatments = $conn->query("SELECT COUNT(*) as count FROM treatment_history")->fetch_assoc()['count'];
?>

<main class="main-content">
    <div class="container">
        <h1 style="margin-bottom: 2rem; color: #667eea;">Admin Dashboard</h1>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>👥 Total Patients</h3>
                <p class="stat"><?php echo $total_patients; ?></p>
            </div>
            <div class="dashboard-card">
                <h3>📅 Total Appointments</h3>
                <p class="stat"><?php echo $total_appointments; ?></p>
            </div>
            <div class="dashboard-card">
                <h3>💳 Pending Payments</h3>
                <p class="stat"><?php echo $pending_payments; ?></p>
            </div>
            <div class="dashboard-card">
                <h3>✅ Completed Treatments</h3>
                <p class="stat"><?php echo $completed_treatments; ?></p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <button onclick="window.location.href='index.php?page=admin_patients'" style="padding: 1.5rem; font-size: 1rem;">
                👥 View Patients
            </button>
            <button onclick="window.location.href='index.php?page=admin_appointments'" style="padding: 1.5rem; font-size: 1rem; background: #28a745;">
                📅 Manage Appointments
            </button>
        </div>
    </div>
</main>