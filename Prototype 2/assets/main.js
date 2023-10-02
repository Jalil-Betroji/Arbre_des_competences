const addStagiaireForm = document.getElementById("hide");
const addStagiaireButton = document.getElementsByClassName("add_new")[0];
const idInputToDelete = document.getElementsByClassName("id_To_Delete")[0];
const confirmationButton = document.getElementById('confirm');
const editButtons = document.querySelectorAll('input[name="edit"]');
const deleteButtons = document.querySelectorAll('input[name="delete"]')
let person_Id = document.getElementById('person_Id');
let nameInput = document.getElementById("name");
let cneInput = document.getElementById("cne");
let citySelect = document.getElementById("city_selector");

addStagiaireButton.addEventListener("click", (e) => {
  addStagiaireForm.classList.remove("hide");
  addStagiaireButton.classList.add("hide");
});

// Function to select an option in a <select> element by value or text
function selectOption(selectElement, text) {
  for (let i = 0; i < selectElement.options.length; i++) {
    if (
      selectElement.options[i].value === text ||
      selectElement.options[i].textContent.trim() === text.trim()
    ) {
      selectElement.options[i].selected = true;
      break;
    }
  }
}

// Add an event listener to all Edit buttons
editButtons.forEach((button) => {
  button.addEventListener("click", (e) => {
    confirmationButton.value = 'Editer'
    confirmationButton.id = "update";
    confirmationButton.name = "confirm_Update";
    // Access the parent <tr> element
    const row = e.target.closest("tr");
    // Retrieve values from the row cells
    const id = row.cells[0].innerText;
    const name = row.cells[1].innerText;
    const cne = row.cells[2].innerText;
    const city = row.cells[3].innerText;

    addStagiaireForm.classList.remove("hide");
    addStagiaireButton.classList.add("hide");

    // Populate the form fields with the retrieved values
    person_Id.value = id;
    nameInput.value = name;
    cneInput.value = cne;
    console.log(city);
    selectOption(citySelect, city);
  });
});
deleteButtons.forEach((button) => {
    button.addEventListener('click' , (e) => {
        const row = e.target.closest('tr');
        const id = row.cells[0].innerText;
        idInputToDelete.value = id;
    })
})