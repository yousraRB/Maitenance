// Get the error message element
var errorElement = document.getElementById("error");

// Check if the error message element exists
if (errorElement) {
  // Hide the error message after 3 seconds
  setTimeout(function() {
    errorElement.style.display = "none";
  }, 9000);

  // Add an event listener to hide the error message when the user clicks on it
  errorElement.addEventListener("click", function() {
    errorElement.style.display = "none";
  });
}