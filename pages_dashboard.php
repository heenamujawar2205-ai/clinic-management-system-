<?php
$patient_id = $_SESSION['patient_id'];

// Get patient info
$sql = "SELECT first_name, last_name, email FROM patients WHERE patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get upcoming appointments count
$sql = "SELECT COUNT(*) as count FROM appointments WHERE patient_id = ? AND appointment_date >= CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$upcoming = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get pending payments count
$sql = "SELECT COUNT(*) as count FROM payments p 
        JOIN appointments a ON p.appointment_id = a.appointment_id 
        WHERE a.patient_id = ? AND p.status = 'Pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$pending = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get total visits
$sql = "SELECT COUNT(*) as count FROM appointments WHERE patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$visits = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<main class="main-content">
    <div class="container">
        <h1 style="margin-bottom: 1rem; color: #667eea;">Welcome, <?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?>!</h1>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>📅 Upcoming Appointments</h3>
                <p class="stat"><?php echo $upcoming['count']; ?></p>
            </div>
            <div class="dashboard-card">
                <h3>💳 Pending Payments</h3>
                <p class="stat"><?php echo $pending['count']; ?></p>
            </div>
            <div class="dashboard-card">
                <h3>🏥 Total Visits</h3>
                <p class="stat"><?php echo $visits['count']; ?></p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <button onclick="window.location.href='index.php?page=book_appointment'" style="padding: 1.5rem; font-size: 1rem;">
                📋 Book Appointment
            </button>
            <button onclick="window.location.href='index.php?page=view_appointments'" style="padding: 1.5rem; font-size: 1rem; background: #28a745;">
                📅 View Appointments
            </button>
            <button onclick="window.location.href='index.php?page=payment_status'" style="padding: 1.5rem; font-size: 1rem; background: #ffc107; color: #333;">
                💳 Payment Status
            </button>
            <button onclick="window.location.href='index.php?page=patient_history'" style="padding: 1.5rem; font-size: 1rem; background: #17a2b8;">
                📝 Medical History
            </button>
        </div>
    </div>
</main>