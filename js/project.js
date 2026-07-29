let project_name;
let domain_name;
let project_desc;
let project_link;
let technologies;

function filterProjects(domain) {
  const allProjects = document.querySelectorAll('.project');
  allProjects.forEach(p => {
    p.style.display = (domain === 'all' || p.classList.contains(domain)) ? 'block' : 'none';
  });
}

function clearingElements() {
  document.getElementById("projectName").value = "";
  document.getElementById("domainName").value = "";
  document.getElementById("projectDesc").value = "";
  document.getElementById("projectLink").value = "";
  document.getElementById("technologies").value = "";
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

function addNewProject(response) {
  if (response.success === true) {
    if (!project_name || !domain_name || !project_desc) {
      alert("Please fill all the fields");
      return;
    }

    const class_Name = mapDomainToClass(domain_name);

    const div = document.createElement("div");
    div.className = `box col-lg-4 col-md-11 col-sm-11 project ${class_Name}`;
    div.innerHTML = `
      <h4>${domain_name}</h4>
      <h5>${project_name}</h5>
      <p>${project_desc}</p>
      <h5>Tech :</h5>
      <p>${technologies}</p>
      <a href="${project_link}" target="_blank">
        <button class="button">View</button>
      </a>
    `;

    document.querySelector(".projects .row").appendChild(div);
    alert("Project added successfully!");
    clearingElements();
  } else {
    alert("Something went wrong!");
  }
}

window.addEventListener('load', function () {
  let addProjectForm = document.getElementById('addProject');
  addProjectForm.addEventListener('submit', function (event) {
    event.preventDefault();

    project_name = document.getElementById("projectName").value.trim();
    domain_name = document.getElementById("domainName").value.trim();
    project_desc = document.getElementById("projectDesc").value.trim();
    project_link = document.getElementById("projectLink").value.trim();
    technologies = document.getElementById("technologies").value.trim();

    let httpRequest = new XMLHttpRequest();
    let form_data = new FormData(addProjectForm);

    httpRequest.onload = function () {
      if (httpRequest.status === 200) {
        console.log(httpRequest.responseText);
        let response = JSON.parse(httpRequest.responseText);
        addNewProject(response);
      } else {
        alert("Try again!");
      }
    };

    httpRequest.open('POST', './api/project_api.php');
    httpRequest.send(form_data);
  });
});
