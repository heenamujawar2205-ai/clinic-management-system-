<?php
$patient_id = $_SESSION['patient_id'];

$sql = "SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.status, a.reason_for_visit,
                d.doctor_name, d.specialization
        FROM appointments a
        JOIN doctors d ON a.doctor_id = d.doctor_id
        WHERE a.patient_id = ?
        ORDER BY a.appointment_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<main class="main-content">
    <div class="container">
        <h1 style="margin-bottom: 2rem; color: #667eea;">My Appointments</h1>

        <div class="table-container">
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Appointment ID</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($appointment = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $appointment['appointment_id']; ?></td>
                                <td>
                                    <strong><?php echo $appointment['doctor_name']; ?></strong><br>
                                    <small><?php echo $appointment['specialization']; ?></small>
                                </td>
                                <td><?php echo date('d-m-Y', strtotime($appointment['appointment_date'])); ?></td>
                                <td><?php echo $appointment['appointment_time']; ?></td>
                                <td><?php echo substr($appointment['reason_for_visit'], 0, 30) . '...'; ?></td>
                                <td>
                                    <?php
                                    $status = $appointment['status'];
                                    $badge_class = 'badge-success';
                                    if ($status == 'Pending') $badge_class = 'badge-pending';
                                    if ($status == 'Cancelled') $badge_class = 'badge-cancelled';
                                    echo '<span class="badge ' . $badge_class . '">' . $status . '</span>';
                                    ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No appointments found. <a href="index.php?page=book_appointment">Book one now</a></div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 2rem;">
            <button onclick="window.location.href='index.php?page=dashboard'" style="width: auto;">Back to Dashboard</button>
        </div>
    </div>
</main>