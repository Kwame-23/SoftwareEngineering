document.getElementById('register-form').addEventListener('submit', function (event) {
  // Prevent form submission
  event.preventDefault();

  // Validate each field
  const firstName = document.getElementById('fname');
  const lastName = document.getElementById('lname');
  const specialization = document.getElementById('Specialization');
  const contact = document.getElementById('contact');
  const emergencyContact = document.getElementById('emergencyContact');
  const email = document.getElementById('email');
  const password = document.getElementById('password');
  const dob = document.getElementById('dob');
  const gender = document.querySelector('input[name="gender"]:checked');

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

  if (!validateContactNumber(contact.value)) {
      alert('Please enter a valid contact number');
      contact.focus();
      return;
  }

  if (emergencyContact && !validateContactNumber(emergencyContact.value)) {
      alert('Please enter a valid emergency contact number');
      emergencyContact.focus();
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

  if (!dob.value) {
      alert('Please enter your date of birth');
      dob.focus();
      return;
  }

  if (!gender) {
      alert('Please select your gender');
      return;
  }

  // Submit the form if all validations pass
  document.getElementById('register-form').submit();
});

function validateName(name) {
  const regex = /^[a-zA-Z]+$/;
  return regex.test(name);
}

function validateContactNumber(contact) {
  // Updated regex to accommodate various contact number formats
  const regex = /^(\+\d{1,3}\s?)?(\(?\d{2,4}\)?[\s.-]?)?\d{3}[\s.-]?\d{4}$/;
  return regex.test(contact);
}

function validateEmail(email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}

function validatePassword(password) {
  const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
  return regex.test(password);
}
