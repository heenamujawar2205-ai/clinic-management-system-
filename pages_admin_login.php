<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT admin_id, password FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['username'] = $username;
            header("Location: index.php?page=admin_dashboard");
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Username not found!";
    }
    $stmt->close();
}
?>

<main class="main-content">
    <div class="container">
        <div class="form-container">
            <h2 style="text-align: center; margin-bottom: 2rem; color: #667eea;">Admin Login</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" onsubmit="return validateLogin()">
                <div class="form-group">
                    <label for="email">Username *</label>
                    <input type="text" id="email" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit">Login</button>

                <div class="form-links">
                    <p><a href="index.php?page=login">Patient Login</a></p>
                    <p><a href="index.php?page=register">Patient Registration</a></p>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="js/validation.js"></script>