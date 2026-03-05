<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT patient_id, password FROM patients WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        
        if (password_verify($password, $patient['password'])) {
            $_SESSION['patient_id'] = $patient['patient_id'];
            $_SESSION['email'] = $email;
            header("Location: index.php?page=dashboard");
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Email not found!";
    }
    $stmt->close();
}
?>

<main class="main-content">
    <div class="container">
        <div class="form-container">
            <h2 style="text-align: center; margin-bottom: 2rem; color: #667eea;">Patient Login</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" onsubmit="return validateLogin()">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit">Login</button>

                <div class="form-links">
                    <p>Don't have an account? <a href="index.php?page=register">Register here</a></p>
                    <p><a href="index.php?page=admin_login">Admin Login</a></p>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="js/validation.js"></script>