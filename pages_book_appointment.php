<?php
$patient_id = $_SESSION['patient_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $reason = $_POST['reason'];

    // Check if slot is available
    $check_sql = "SELECT appointment_id FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("iss", $doctor_id, $appointment_date, $appointment_time);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $error = "This slot is already booked. Please choose another time.";
    } else {
        $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, reason_for_visit, status) 
                VALUES (?, ?, ?, ?, ?, 'Scheduled')";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $patient_id, $doctor_id, $appointment_date, $appointment_time, $reason);
        
        if ($stmt->execute()) {
            $appointment_id = $stmt->insert_id;
            
            // Create payment record
            $payment_sql = "INSERT INTO payments (appointment_id, amount, status) VALUES (?, 500, 'Pending')";
            $payment_stmt = $conn->prepare($payment_sql);
            $payment_stmt->bind_param("i", $appointment_id);
            $payment_stmt->execute();
            $payment_stmt->close();
            
            $success = "Appointment booked successfully! Appointment ID: #" . $appointment_id;
        } else {
            $error = "Error booking appointment!";
        }
        $stmt->close();
    }
    $check_stmt->close();
}

// Get available time slots
$time_slots = array('09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30');
?>

<main class="main-content">
    <div class="container">
        <div class="form-container">
            <h2 style="text-align: center; margin-bottom: 2rem; color: #667eea;">Book an Appointment</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" onsubmit="return validateAppointment()">
                <div class="form-group">
                    <label for="doctor">Select Doctor *</label>
                    <select id="doctor" name="doctor" required>
                        <option value="">Choose a Doctor</option>
                        <?php
                        $result = $conn->query("SELECT doctor_id, doctor_name, specialization FROM doctors");
                        while ($doctor = $result->fetch_assoc()) {
                            echo '<option value="' . $doctor['doctor_id'] . '">' . $doctor['doctor_name'] . ' (' . $doctor['specialization'] . ')</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="appointment_date">Select Date (Future dates only) *</label>
                    <input type="date" id="appointment_date" name="appointment_date" required>
                </div>

                <div class="form-group">
                    <label for="appointment_time">Select Time *</label>
                    <select id="appointment_time" name="appointment_time" required>
                        <option value="">Choose a Time Slot</option>
                        <?php
                        foreach ($time_slots as $slot) {
                            echo '<option value="' . $slot . '">' . $slot . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="reason">Reason for Visit *</label>
                    <textarea id="reason" name="reason" required></textarea>
                </div>

                <button type="submit">Book Appointment</button>

                <div class="form-links">
                    <p><a href="index.php?page=dashboard">Back to Dashboard</a></p>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="js/validation.js"></script>
<script>
// Set minimum date to today
document.getElementById('appointment_date').min = new Date().toISOString().split('T')[0];
</script>