<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?page=admin_login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_treatment'])) {
        $appointment_id = $_POST['appointment_id'];
        $diagnosis = $_POST['diagnosis'];
        $treatment = $_POST['treatment'];
        $medications = $_POST['medications'];
        $notes = $_POST['notes'];
        $follow_up = $_POST['follow_up'];

        $sql = "INSERT INTO treatment_history (appointment_id, diagnosis, treatment_given, medications, doctor_notes, follow_up_date)
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $