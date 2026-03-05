<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?page=admin_login");
    exit;
}

$sql = "SELECT patient_id, first_name, last_name, email, phone, created_at FROM patients ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<main class="main-content">
    <div class="container">
        <h1 style="margin-bottom: 2rem; color: #667eea;">All Patients</h1>

        <div class="table-container">
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registered Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($patient = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $patient['patient_id']; ?></td>
                                <td><?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?></td>
                                <td><?php echo $patient['email']; ?></td>
                                <td><?php echo $patient['phone']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($patient['created_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No patients found.</div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 2rem;">
            <button onclick="window.location.href='index.php?page=admin_dashboard'" style="width: auto;">Back to Dashboard</button>
        </div>
    </div>
</main>