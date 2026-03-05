<main class="main-content">
    <div class="container">
        <div class="hero">
            <h1>Welcome to SmartCare Clinic</h1>
            <p>Your Health, Our Priority</p>
            <?php if (!isset($_SESSION['patient_id']) && !isset($_SESSION['admin_id'])): ?>
                <button onclick="window.location.href='index.php?page=register'" style="width: 150px; margin-right: 10px;">Register</button>
                <button onclick="window.location.href='index.php?page=login'" style="width: 150px; background: #28a745;">Login</button>
            <?php endif; ?>
        </div>

        <div class="clinic-info">
            <div class="info-card">
                <h3>📍 Location</h3>
                <p>123 Medical Street, Healthcare City, State - 123456</p>
            </div>
            <div class="info-card">
                <h3>⏰ Clinic Hours</h3>
                <p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed</p>
            </div>
            <div class="info-card">
                <h3>📞 Contact Information</h3>
                <p>Phone: +91-9876543210<br>Email: info@smartcare.com</p>
            </div>
        </div>

        <div class="doctors-section">
            <h2 style="text-align: center; margin-bottom: 2rem; color: #333;">Our Experienced Doctors</h2>
            <div class="doctors-grid">
                <?php
                $result = $conn->query("SELECT * FROM doctors");
                while ($doctor = $result->fetch_assoc()) {
                    echo '<div class="doctor-card">';
                    echo '<h4>' . $doctor['doctor_name'] . '</h4>';
                    echo '<p class="specialization">' . $doctor['specialization'] . '</p>';
                    echo '<p><strong>Email:</strong> ' . $doctor['email'] . '</p>';
                    echo '<p><strong>Phone:</strong> ' . $doctor['phone'] . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</main>