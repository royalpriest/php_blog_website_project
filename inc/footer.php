<footer class="site-footer">
    <div class="footer-container">
        <p class="footer-brand">Programmer Hub &copy; <?php echo date('Y'); ?></p>
        <div class="footer-links">
            <a href="register.php">Register</a>
            <span class="separator">|</span>
            <a href="login.php">Login</a>
            <span class="separator">|</span>
            <a href="index.php">Home</a>
            <span class="separator">|</span>
            <a href="users.php">Users Hub</a>
            <span class="separator">|</span>
            <a href="#">Privacy</a>
            <span class="separator">|</span>
            <a href="#">Terms</a>
        </div>
    </div>
</footer>


<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        if (!field) return;

        const toggleBtn = document.querySelector(`[data-toggle="${fieldId}"]`);
        if (!toggleBtn) return;

        // Toggle password visibility
        field.type = field.type === 'password' ? 'text' : 'password';

        // Toggle eye icons (crossed eye shows when password is hidden)
        const showCrossedEye = field.type === 'password';
        toggleBtn.querySelector('.eye-closed').classList.toggle('hidden', !showCrossedEye);
        toggleBtn.querySelector('.eye-open').classList.toggle('hidden', showCrossedEye);
    }

    // Initialize all password fields on page load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.password-field').forEach(field => {
            field.type = 'password';
            const toggleBtn = document.querySelector(`[data-toggle="${field.id}"]`);
            if (toggleBtn) {
                toggleBtn.querySelector('.eye-closed').classList.remove('hidden');
                toggleBtn.querySelector('.eye-open').classList.add('hidden');
            }
        });
    });
</script>

</body>
</html>