<?php
$patient_id = $_SESSION['patient_id'];

$sql = "SELECT a.appointment_id, a.appointment_date, a.reason_for_visit,
                d.doctor_name, d.specialization,
                t.diagnosis, t.treatment_given, t.medications, t.doctor_notes, t.follow_up_date
        FROM appointments a
        JOIN doctors d ON a.doctor_id = d.doctor_id
        LEFT JOIN treatment_history t ON a.appointment_id = t.appointment_id
        WHERE a.patient_id = ? AND a.appointment_date < CURDATE()
        ORDER BY a.appointment_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<main class="main-content">
    <div class="container">
        <h1 style="margin-bottom: 2rem; color: #667eea;">Medical History</h1>

        <?php if ($result->num_rows > 0): ?>
            <div style="display: grid; gap: 2rem;">
                <?php while ($record = $result->fetch_assoc()): ?>
                    <div class="info-card">
                        <h3>Appointment #<?php echo $record['appointment_id']; ?></h3>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin: 1rem 0;">
                            <div>
                                <strong>Date:</strong> <?php echo date('d-m-Y', strtotime($record['appointment_date'])); ?>
                            </div>
                            <div>
                                <strong>Doctor:</strong> <?php echo $record['doctor_name']; ?>
                            </div>
                        </div>

                        <div>
                            <strong>Reason for Visit:</strong>
                            <p><?php echo $record['reason_for_visit']; ?></p>
                        </div>

                        <?php if ($record['diagnosis']): ?>
                            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #ddd;">
                                <strong>Diagnosis:</strong>
                                <p><?php echo $record['diagnosis']; ?></p>

                                <strong>Treatment Given:</strong>
                                <p><?php echo $record['treatment_given']; ?></p>

                                <?php if ($record['medications']): ?>
                                    <strong>Medications:</strong>
                                    <p><?php echo $record['medications']; ?></p>
                                <?php endif; ?>

                                <?php if ($record['doctor_notes']): ?>
                                    <strong>Doctor Notes:</strong>
                                    <p><?php echo $record['doctor_notes']; ?></p>
                                <?php endif; ?>

                                <?php if ($record['follow_up_date']): ?>
                                    <strong>Follow-up Date:</strong>
                                    <p><?php echo date('d-m-Y', strtotime($record['follow_up_date'])); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 4px;">
                                <em>Treatment notes not yet added by doctor.</em>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No medical history available.</div>
        <?php endif; ?>

        <div style="margin-top: 2rem;">
            <button onclick="window.location.href='index.php?page=dashboard'" style="width: auto;">Back to Dashboard</button>
        </div>
    </div>
</main>