const addStagiaireForm = document.getElementById("hide");
const addStagiaireButton = document.getElementsByClassName("add_new")[0];
const idInputToDelete = document.getElementsByClassName("id_To_Delete")[0];
const confirmationButton = document.getElementById("confirm");
const editButtons = document.querySelectorAll('input[name="edit"]');
const deleteButtons = document.querySelectorAll('input[name="delete"]');
const view_Chart = document.getElementById("view_Chart");
const view_Table = document.getElementById("view_Table");
const table_View = document.getElementById("table_View");
const chart_View = document.getElementById("chartContainer");
const pagination = document.getElementById("pagination");
const chartContainer = document.getElementById("chartContainer");
let person_Id = document.getElementById("person_Id");
let nameInput = document.getElementById("name");
let cneInput = document.getElementById("cne");
let citySelect = document.getElementById("city_selector");

addStagiaireButton.addEventListener("click", (e) => {
  addStagiaireForm.classList.remove("hide");
  addStagiaireButton.classList.add("hide");
});

view_Chart.addEventListener("click", (e) => {
  table_View.classList.add("hide");
  chart_View.classList.remove("hide");
//   pagination.classList.add("hide");
});
view_Table.addEventListener("click", (e) => {
  table_View.classList.remove("hide");
  chart_View.classList.add("hide");
//   pagination.classList.remove("hide");
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
    confirmationButton.value = "Editer";
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
    nameInput.ariaReadOnly ;
    cneInput.value = cne;
    selectOption(citySelect, city);
  });
});
deleteButtons.forEach((button) => {
  button.addEventListener("click", (e) => {
    const row = e.target.closest("tr");
    const id = row.cells[0].innerText;
    idInputToDelete.value = id;
  });
});

// ================= Table design and sort =================

(table_rows = document.querySelectorAll("tbody tr")),
  (table_headings = document.querySelectorAll("thead th"));

// 2. Sorting | Ordering data of HTML table

table_headings.forEach((head, i) => {
  let sort_asc = true;
  head.onclick = () => {
    table_headings.forEach((head) => head.classList.remove("active"));
    head.classList.add("active");

    document
      .querySelectorAll("td")
      .forEach((td) => td.classList.remove("active"));
    table_rows.forEach((row) => {
      row.querySelectorAll("td")[i].classList.add("active");
    });

    head.classList.toggle("asc", sort_asc);
    sort_asc = head.classList.contains("asc") ? false : true;

    sortTable(i, sort_asc);
  };
});

function sortTable(column, sort_asc) {
  [...table_rows]
    .sort((a, b) => {
      let first_row = a
          .querySelectorAll("td")
          [column].textContent.toLowerCase(),
        second_row = b.querySelectorAll("td")[column].textContent.toLowerCase();

      return sort_asc
        ? first_row < second_row
          ? 1
          : -1
        : first_row < second_row
        ? -1
        : 1;
    })
    .map((sorted_row) =>
      document.querySelector("tbody").appendChild(sorted_row)
    );
}

document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");

  form.addEventListener("submit", function (event) {
    // Validate The Name input
    const nameInputValue = nameInput.value.trim();
    if (!/^[A-Za-z ]+$/.test(nameInputValue)) {
      alert("Name must contain only alphabetic characters.");
      event.preventDefault();
      return;
    }

    // Validate The CNE input
    const cneInputValue = cneInput.value.trim();
    if (!/^[A-Z][0-9]{9}$/.test(cneInputValue)) {
      alert("CNE must start with a capital letter followed by 9 numbers.");
      event.preventDefault();
      return;
    }
  });
});
