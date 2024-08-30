// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

// Dark mode
let body = document.querySelector("body");
let nav = document.querySelector(".navigation");
var icon = document.getElementById("mode-icon");
var icon = document.getElementById("mode-icon");

function dark() {
  body.classList.toggle("dark-body");
  nav.classList.toggle("dark-nav");
  main.classList.toggle("dark-body");

  // Update localStorage value
  if (body.classList.contains("dark-body")) {
    localStorage.setItem('dark', 'true');
    icon.setAttribute("name", "sunny-outline");
  } else {
    localStorage.setItem('dark', 'false');
    icon.setAttribute("name", "moon-outline");
  }
}

// Load dark mode on page load
var darkMode = localStorage.getItem('dark');
if (darkMode === 'true') {
  dark(); // Apply dark mode styles
}


function showEditForm(code) {
  // Hide document information container
  document.querySelector('.container').style.display = 'none';
  
  // Show edit form container
  document.querySelector('.edit-container').style.display = 'block';
  
  // Populate edit form with document information
  // You can use AJAX to retrieve the document information from the server based on the code parameter
  // and populate the form fields
}

function showInputField() {
  var selectElement = document.querySelector(".grade");
  var selectedOption = selectElement.options[selectElement.selectedIndex].value;
  var inputField = document.createElement("div");

  if (selectedOption == "autre") {
    inputField.innerHTML = `
      <div class="input-field">
        <input type="text" name="grade" id="autre-grade" required>
      </div>
    `;
    selectElement.parentElement.appendChild(inputField);
  } else {
    var existingInputField = document.querySelector("#autre-grade");
    if (existingInputField) {
      existingInputField.parentElement.removeChild(existingInputField);
    }
  }
}

function showInputField2() {
  var selectElement = document.querySelector(".fonction");
  var selectedOption = selectElement.options[selectElement.selectedIndex];
  var inputField = document.querySelector("#autre-fonction");

  if (selectedOption.value === "au") {
    if (!inputField) {
      inputField = document.createElement("input");
      inputField.type = "text";
      inputField.name = "fonction";
      inputField.id = "autre-fonction";
      inputField.required = true;

      var inputContainer = document.createElement("div");
      inputContainer.className = "input-field";
      inputContainer.appendChild(inputField);

      selectElement.parentElement.appendChild(inputContainer);
    } else {
      inputField.required = true;
    }

    selectedOption.value = inputField.value; // Set option value to input field value
  } else {
    if (inputField) {
      inputField.required = false;
      inputField.parentElement.remove();
    }
  }
}

function updateAutreValue(value) {
  var autreValue = value.substring(0, 2);
  console.log("Autre value:", autreValue);
}
