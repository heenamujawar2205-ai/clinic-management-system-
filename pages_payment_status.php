<?php
$patient_id = $_SESSION['patient_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_id'])) {
    $payment_id = $_POST['payment_id'];
    
    // Only admin can update payment, but simulate payment for demo
    $update_sql = "UPDATE payments SET status = 'Paid', payment_date = NOW() WHERE payment_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $payment_id);
    $update_stmt->execute();
    $update_stmt->close();
    
    $success = "Payment marked as paid!";
}

$sql = "SELECT p.payment_id, p.appointment_id, p.amount, p.status, p.payment_date,
                a.appointment_date, d.doctor_name
        FROM payments p
        JOIN appointments a ON p.appointment_id = a.appointment_id
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
        <h1 style="margin-bottom: 2rem; color: #667eea;">Payment Status</h1>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="table-container">
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Doctor</th>
                            <th>Appointment Date</th>
                            <th>Amount (₹)</th>
                            <th>Status</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($payment = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $payment['payment_id']; ?></td>
                                <td><?php echo $payment['doctor_name']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($payment['appointment_date'])); ?></td>
                                <td><?php echo $payment['amount']; ?></td>
                                <td>
                                    <?php
                                    $status = $payment['status'];
                                    $badge_class = $status == 'Paid' ? 'badge-success' : 'badge-pending';
                                    echo '<span class="badge ' . $badge_class . '">' . $status . '</span>';
                                    ?>
                                </td>
                                <td><?php echo $payment['payment_date'] ? date('d-m-Y', strtotime($payment['payment_date'])) : 'N/A'; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No payments found.</div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 2rem;">
            <button onclick="window.location.href='index.php?page=dashboard'" style="width: auto;">Back to Dashboard</button>
        </div>
    </div>
</main>