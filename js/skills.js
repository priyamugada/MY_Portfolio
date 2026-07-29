let skill_name = "";
let skill_level = "";
let skill_type = "";

function clearFields() {
  document.getElementById("skilltype").value = "";
  document.getElementById("skillName").value = "";
  document.getElementById("proficiency").value = "";
}

function add_Skill(response) {
  if (response.success === true) {
    let table = document.getElementById(skill_type === "technical" ? "technical" : "soft");
    let row = table.insertRow();
    let cell1 = row.insertCell(0);
    let cell2 = row.insertCell(1);
    cell1.innerHTML = skill_name;
    cell2.innerHTML = skill_level;

    alert(`${skill_type === "technical" ? "Technical" : "Soft"} Skill Added Successfully`);
    clearFields();
  } else {
    alert(response.message || "Failed to add skill!");
  }
}

function error() {
  alert("Something went wrong!");
}

window.addEventListener("load", function () {
  let addSkillForm = document.getElementById("addSkill");
  addSkillForm.addEventListener("submit", function (event) {
    event.preventDefault();

    skill_name = document.getElementById("skillName").value;
    skill_level = document.getElementById("proficiency").value;
    skill_type = document.getElementById("skilltype").value;

    let form_data = new FormData(addSkillForm);
    let httpRequest = new XMLHttpRequest();

    httpRequest.open("POST", "./api/skills_api.php");
    httpRequest.onload = function () {
      if (httpRequest.status === 200) {
        console.log(httpRequest.responseText);

        try {
          let response = JSON.parse(httpRequest.responseText);
          add_Skill(response);
        } catch (err) {
          alert("Invalid response from server.");
        }
      } else {
        alert("Server error: " + httpRequest.status);
      }
    };

    httpRequest.onerror = error;
    httpRequest.send(form_data);
  });
});
