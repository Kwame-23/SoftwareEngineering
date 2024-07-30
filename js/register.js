document.getElementById('register-form').addEventListener('submit', function (event) {
  // Prevent form submission
  // event.preventDefault();

  // Validate each field
  const firstName = document.getElementById('fname');
  const lastName = document.getElementById('lname');
  const email = document.getElementById('email');
  const password = document.getElementById('password');
  const confirmPassword = document.getElementById("confirmPassword");


  if (!validateName(firstName.value)) {
      alert('Please enter a valid first name');
      firstName.focus();
      return;
  }

  if (!validateName(lastName.value)) {
      alert('Please enter a valid last name');
      lastName.focus();
      return;
  }

  if (!validateEmail(email.value)) {
      alert('Please enter a valid email address');
      email.focus();
      return;
  }

  if (!validatePassword(password.value)) {
      alert('Password must be at least 8 characters long and contain at least one letter and one number');
      password.focus();
      return;
  }

  if (password !== confirmPassword) {
    alert("Passwords do not match.");
    return false;
}
  // Submit the form if all validations pass
  document.getElementById('register-form').submit();
});

function validateName(name) {
  const regex = /^[a-zA-Z]+$/;
  return regex.test(name);
}

function validateEmail(email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}

function validatePassword(password) {
  const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
  return regex.test(password);
}
