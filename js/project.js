function filterProjects(domain) {
  const allProjects = document.querySelectorAll('.project');
  allProjects.forEach(p => {
    p.style.display = (domain === 'all' || p.classList.contains(domain)) ? 'block' : 'none';
  });
}

function clearingElements() {
  document.getElementById("projectId").value = "";
  document.getElementById("projectAction").value = "add";
  document.getElementById("projectName").value = "";
  document.getElementById("domainName").value = "Machine Learning/Deep Learning";
  document.getElementById("projectDesc").value = "";
  document.getElementById("projectLink").value = "";
  document.getElementById("technologies").value = "";
  const titleEl = document.getElementById("projectModalTitle");
  if (titleEl) titleEl.textContent = "Add New Project";
}

function mapDomainToClass(domain_name) {
  switch (domain_name) {
    case "Machine Learning/Deep Learning": return "ml";
    case "MERN Stack": return "mern";
    case "Web development": return "web";
    case "Frontend": return "frontend";
    case "Gen AI": return "genai";
    default: return "other";
  }
}

function openAddProjectModal() {
  clearingElements();
  const modalEl = document.getElementById('projectModal');
  if (modalEl) {
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
  }
}

function openEditProjectModal(btn) {
  const card = btn.closest('.project');
  if (!card) return;

  const id = card.dataset.id || '';
  const domain = card.dataset.domain || '';
  const title = card.dataset.title || '';
  const desc = card.dataset.desc || '';
  const tech = card.dataset.tech || '';
  const link = card.dataset.link || '';

  document.getElementById("projectId").value = id;
  document.getElementById("projectAction").value = "edit";
  document.getElementById("projectName").value = title;
  document.getElementById("domainName").value = domain;
  document.getElementById("projectDesc").value = desc;
  document.getElementById("technologies").value = tech;
  document.getElementById("projectLink").value = link;

  const titleEl = document.getElementById("projectModalTitle");
  if (titleEl) titleEl.textContent = "Edit Project";

  const modalEl = document.getElementById('projectModal');
  if (modalEl) {
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
  }
}

function deleteProject(id) {
  if (!confirm("Are you sure you want to delete this project?")) {
    return;
  }

  const formData = new FormData();
  formData.append('action', 'delete');
  formData.append('id', id);

  const httpRequest = new XMLHttpRequest();
  httpRequest.onload = function () {
    if (httpRequest.status === 200) {
      try {
        const response = JSON.parse(httpRequest.responseText);
        if (response.success) {
          const card = document.getElementById(`project-card-${id}`);
          if (card) {
            card.remove();
          }
          alert("Project deleted successfully!");
        } else {
          alert("Error: " + (response.message || "Failed to delete project"));
        }
      } catch (e) {
        alert("Delete response error");
      }
    } else {
      alert("Failed to connect to server");
    }
  };

  httpRequest.open('POST', './api/project_api.php');
  httpRequest.send(formData);
}

window.addEventListener('load', function () {
  let addProjectForm = document.getElementById('addProject');
  if (!addProjectForm) return;

  addProjectForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const action = document.getElementById("projectAction").value || 'add';
    const id = document.getElementById("projectId").value || '';
    const project_name = document.getElementById("projectName").value.trim();
    const domain_name = document.getElementById("domainName").value.trim();
    const project_desc = document.getElementById("projectDesc").value.trim();
    const project_link = document.getElementById("projectLink").value.trim();
    const technologies = document.getElementById("technologies").value.trim();

    if (!project_name || !domain_name) {
      alert("Please fill in the project name and domain");
      return;
    }

    const httpRequest = new XMLHttpRequest();
    const form_data = new FormData(addProjectForm);

    httpRequest.onload = function () {
      if (httpRequest.status === 200) {
        let response;
        try {
          response = JSON.parse(httpRequest.responseText);
        } catch (e) {
          alert("Invalid server response");
          return;
        }

        if (response.success) {
          const modalEl = document.getElementById('projectModal');
          if (modalEl) {
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
          }

          const className = mapDomainToClass(domain_name);

          if (action === 'edit' && id) {
            const card = document.getElementById(`project-card-${id}`);
            if (card) {
              card.className = `box col-lg-4 col-md-11 col-sm-11 project ${className}`;
              card.dataset.domain = domain_name;
              card.dataset.title = project_name;
              card.dataset.desc = project_desc;
              card.dataset.tech = technologies;
              card.dataset.link = project_link;

              card.querySelector('.card-domain').textContent = domain_name;
              card.querySelector('.card-title-text').textContent = project_name + ' :';
              card.querySelector('.card-desc').textContent = project_desc;
              card.querySelector('.card-tech').textContent = technologies;

              let linkContainer = card.querySelector('.d-flex');
              let existingLink = linkContainer.querySelector('.card-link-anchor');
              if (project_link) {
                if (existingLink) {
                  existingLink.href = project_link;
                } else {
                  const newLink = document.createElement('a');
                  newLink.href = project_link;
                  newLink.target = '_blank';
                  newLink.className = 'card-link-anchor';
                  newLink.innerHTML = '<button class="button">View</button>';
                  linkContainer.insertBefore(newLink, linkContainer.firstChild);
                }
              } else if (existingLink) {
                existingLink.remove();
              }
            }
            alert("Project updated successfully!");
          } else {
            // Action === 'add'
            const newId = response.id || Date.now();
            const div = document.createElement("div");
            div.className = `box col-lg-4 col-md-11 col-sm-11 project ${className}`;
            div.id = `project-card-${newId}`;
            div.dataset.id = newId;
            div.dataset.domain = domain_name;
            div.dataset.title = project_name;
            div.dataset.desc = project_desc;
            div.dataset.tech = technologies;
            div.dataset.link = project_link;

            div.innerHTML = `
              <h4 class="card-domain">${domain_name}</h4>
              <h5 class="card-title-text">${project_name} :</h5>
              <p class="card-desc">${project_desc}</p>
              <h5>Tech :</h5>
              <p class="card-tech">${technologies}</p>
              <div class="d-flex flex-wrap gap-2 mt-2 align-items-center">
                ${project_link ? `<a href="${project_link}" target="_blank" class="card-link-anchor"><button class="button">View</button></a>` : ''}
                <button class="button btn-edit-project" onclick="openEditProjectModal(this)">Edit</button>
                <button class="button btn-delete-project" onclick="deleteProject(${newId})">Delete</button>
              </div>
            `;

            const projectsContainer = document.querySelector(".projects .row");
            if (projectsContainer) {
              projectsContainer.appendChild(div);
            }
            alert("Project added successfully!");
          }

          clearingElements();
        } else {
          alert("Error: " + (response.message || "Failed to save project"));
        }
      } else {
        alert("Server error, please try again!");
      }
    };

    httpRequest.open('POST', './api/project_api.php');
    httpRequest.send(form_data);
  });
});
