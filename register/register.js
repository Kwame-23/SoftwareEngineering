document.addEventListener("DOMContentLoaded", function() {
    const roleSelect = document.getElementById("role");
    const doctorFields = document.getElementById("doctor-fields");
    const patientFields = document.getElementById("patient-fields");
  
    roleSelect.addEventListener("change", function() {
      if (this.value === "doctor") {
        doctorFields.style.display = "block";
        patientFields.style.display = "none";
      } else if (this.value === "patient") {
        doctorFields.style.display = "none";
        patientFields.style.display = "block";
      }
    });
  });