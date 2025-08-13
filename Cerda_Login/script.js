document.addEventListener('DOMContentLoaded', () => {
  const loginContainer  = document.getElementById('login-container');
  const signupContainer = document.getElementById('signup-container');
  const goToSignup      = document.getElementById('go-to-signup');
  const goToLogin       = document.getElementById('go-to-login');

  if (goToSignup) {
    goToSignup.addEventListener('click', (e) => {
      e.preventDefault();
      loginContainer.classList.add('hidden');
      signupContainer.classList.remove('hidden');
    });
  }

  if (goToLogin) {
    goToLogin.addEventListener('click', (e) => {
      e.preventDefault();
      signupContainer.classList.add('hidden');
      loginContainer.classList.remove('hidden');
    });
  }
});