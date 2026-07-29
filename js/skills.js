function clearFields() {
  const typeEl = document.getElementById("skilltype");
  if (typeEl) typeEl.value = "technical";
  const nameEl = document.getElementById("skillName");
  if (nameEl) nameEl.value = "";
  const profEl = document.getElementById("proficiency");
  if (profEl) profEl.value = "Beginner";
  const idEl = document.getElementById("skillId");
  if (idEl) idEl.value = "";
  const actionEl = document.getElementById("skillAction");
  if (actionEl) actionEl.value = "add";
  const titleEl = document.getElementById("skillModalTitle");
  if (titleEl) titleEl.textContent = "Add Skill";
}

function openAddSkillModal(type) {
  clearFields();
  const typeEl = document.getElementById("skilltype");
  if (typeEl && type) {
    typeEl.value = type;
  }
  const modalEl = document.getElementById('skill_add');
  if (modalEl) {
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
  }
}

function openEditSkillModal(btn) {
  const row = btn.closest('tr');
  if (!row) return;

  const id = row.dataset.id || '';
  const type = row.dataset.type || 'technical';
  const name = row.dataset.name || '';
  const level = row.dataset.level || 'Beginner';

  document.getElementById("skillId").value = id;
  document.getElementById("skillAction").value = "edit";
  document.getElementById("skilltype").value = type;
  document.getElementById("skillName").value = name;
  document.getElementById("proficiency").value = level;

  const titleEl = document.getElementById("skillModalTitle");
  if (titleEl) titleEl.textContent = "Edit Skill";

  const modalEl = document.getElementById('skill_add');
  if (modalEl) {
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
  }
}

function deleteSkill(type, id) {
  if (!confirm("Are you sure you want to delete this skill?")) {
    return;
  }

  const formData = new FormData();
  formData.append('action', 'delete');
  formData.append('table_name', type);
  formData.append('id', id);

  const httpRequest = new XMLHttpRequest();
  httpRequest.onload = function () {
    if (httpRequest.status === 200) {
      try {
        const response = JSON.parse(httpRequest.responseText);
        if (response.success) {
          const rowId = (type === 'technical') ? `tech-skill-row-${id}` : `soft-skill-row-${id}`;
          const row = document.getElementById(rowId);
          if (row) {
            row.remove();
          }
          alert("Skill deleted successfully!");
        } else {
          alert("Error: " + (response.message || "Failed to delete skill"));
        }
      } catch (e) {
        alert("Delete response error");
      }
    } else {
      alert("Failed to connect to server");
    }
  };

  httpRequest.open('POST', './api/skills_api.php');
  httpRequest.send(formData);
}

window.addEventListener("load", function () {
  let addSkillForm = document.getElementById("addSkill");
  if (!addSkillForm) return;

  addSkillForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const action = document.getElementById("skillAction").value || "add";
    const id = document.getElementById("skillId").value || "";
    const skill_name = document.getElementById("skillName").value.trim();
    const skill_level = document.getElementById("proficiency").value.trim();
    const skill_type = document.getElementById("skilltype").value.trim();

    if (!skill_name || !skill_level || !skill_type) {
      alert("Please fill in all skill fields");
      return;
    }

    const form_data = new FormData(addSkillForm);
    const httpRequest = new XMLHttpRequest();

    httpRequest.open("POST", "./api/skills_api.php");
    httpRequest.onload = function () {
      if (httpRequest.status === 200) {
        let response;
        try {
          response = JSON.parse(httpRequest.responseText);
        } catch (err) {
          alert("Invalid response from server.");
          return;
        }

        if (response.success) {
          const modalEl = document.getElementById('skill_add');
          if (modalEl) {
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
          }

          const targetTable = document.getElementById(skill_type);
          if (!targetTable) {
            alert("Skill saved successfully!");
            clearFields();
            return;
          }

          let tbody = targetTable.querySelector('tbody');
          if (!tbody) {
            tbody = document.createElement('tbody');
            targetTable.appendChild(tbody);
          }

          if (action === 'edit' && id) {
            const rowId = (skill_type === 'technical') ? `tech-skill-row-${id}` : `soft-skill-row-${id}`;
            const row = document.getElementById(rowId);
            if (row) {
              row.dataset.name = skill_name;
              row.dataset.level = skill_level;
              row.dataset.type = skill_type;
              const nameCell = row.querySelector('.skill-name-cell');
              const levelCell = row.querySelector('.skill-level-cell');
              if (nameCell) nameCell.textContent = skill_name;
              if (levelCell) levelCell.textContent = skill_level;
            }
            alert("Skill updated successfully!");
          } else {
            // Action === 'add'
            const newId = response.id || Date.now();
            const rowId = (skill_type === 'technical') ? `tech-skill-row-${newId}` : `soft-skill-row-${newId}`;
            const tr = document.createElement('tr');
            tr.id = rowId;
            tr.dataset.id = newId;
            tr.dataset.type = skill_type;
            tr.dataset.name = skill_name;
            tr.dataset.level = skill_level;

            tr.innerHTML = `
              <td class="skill-name-cell">${skill_name}</td>
              <td class="skill-level-cell">${skill_level}</td>
              <td>
                <button class="button btn-sm" onclick="openEditSkillModal(this)">Edit</button>
                <button class="button btn-sm btn-delete-skill" onclick="deleteSkill('${skill_type}', ${newId})">Delete</button>
              </td>
            `;

            tbody.appendChild(tr);
            alert(`${skill_type === "technical" ? "Technical" : "Soft"} skill added successfully!`);
          }

          clearFields();
        } else {
          alert(response.message || "Failed to save skill!");
        }
      } else {
        alert("Server error: " + httpRequest.status);
      }
    };

    httpRequest.onerror = function () {
      alert("Something went wrong!");
    };
    httpRequest.send(form_data);
  });
});
