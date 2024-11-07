<!-- templates/element/show_password.php -->
<script>
  const passwordLoadEvent = event => {
    const passwordInput = document.getElementById('password');
    const togglePasswordCheckbox = document.getElementById('show-password');
    const togglePasswordLabel = document.getElementById('show-password-label');
    
    togglePasswordCheckbox.addEventListener('click', togglePassword);
    
    function togglePassword() {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        togglePasswordLabel.textContent = 'Ocultar senha';
        togglePasswordCheckbox.setAttribute('aria-label', 'Ocultar senha');
      } else {
        passwordInput.type = 'password';
        togglePasswordLabel.textContent = 'Mostrar senha';
        togglePasswordCheckbox.setAttribute('aria-label', 'Mostrar senha');
      }
    }
  };
  addEventListener('load', passwordLoadEvent);
</script>