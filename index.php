<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link rel="stylesheet" href="./css/home.css">
  <link rel="stylesheet" href="./css/about.css">
  <link rel="stylesheet" href="./css/edu.css">
  <link rel="stylesheet" href="./css/projects.css">
  <link rel="stylesheet" href="./css/skills.css">
  <link rel="stylesheet" href="./css/certifications.css">
  <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
    rel="stylesheet">
  <?php include("./index1.php") ?>
</head>

<body>
  <nav class="navbar navbar-expand-lg sticky-top" style="background-color: black;">
    <div class="container-fluid">
      <a class="navbar-brand" href="#" style="color: white;font-size: 25px;font-weight: bolder;">Priya's</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse " id="navbarText">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#" style="color: white;font-size: 19px;">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#About" style="color:white;font-size: 19px;">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#edu" style="color:white;font-size: 19px;">Education/Internships</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#Projects" style="color: white;font-size: 19px; ">Projects</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#skills" style="color: white;font-size: 19px;">Skills</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#certifications" style="color: white;font-size: 19px;">Certifications</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"
              style="color: white;font-size: 19px;">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="home" style="background-color:#988686;">
    <div class="container">
      <div class="row justify-content-center g-0">
        <div class="col-lg-11 col-md-11 col-sm-11" id="main">
          <div class="row g-0" id="main">
            <div class="col-lg-6 col-md-12 col-sm-12  sub">
              <p style="font-size: 20px;">Hello Everybody Iam </br>
              <h1>MUGADA RAMA SRI LAKSHMI PRIYA</h1></br>
              AI/ML Enthusiast & MERN Stack Developer.
              I build smart solutions where AI works hand in hand with the Web.
              </p>
              </br>
              <h3><i class="fas fa-calendar-alt"></i> &nbsp;<span>Jan 4 2005</span></h5>
                <h3><i class="fas fa-phone"></i> &nbsp;<span>7288957944</span></h3>
                <h3><i class="fas  fa-envelope"></i> &nbsp;<span>mugada.ramasri@sasi.ac.in</span></h3>
                <h3><i class="fas fa-map-marker-alt"></i> &nbsp;<span>India,Andhra Pradesh,</br>&nbsp; &nbsp; West
                    Godavari,Pentapadu,534166</span></h3>
                <div class="icons">
                  <div style="padding: 20px;">
                    <a href="#">
                      <h3><i class="fab fa-linkedin" style="color:white;"></i></h3>
                    </a>
                  </div>
                  <div style="padding: 20px;">
                    <a href="#">
                      <h3><i class="fas fa-trophy" style="color: white;"></i></h3>
                    </a>
                  </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12  sub " style="box-shadow: 8px 16px 16px black;">
              <img src="./images/photo.jpg" alt="photo" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="about" id="About">
    <div class="sub1">
      <div class="row g-0">
        <div class="card1 col-lg-6 col-md-12 col-sm-12">
          <div class="row g-0" id="boxed">
            <div class="a">
              <h1 style="align-self: self-start;padding-left: 4px;"> About My Self</h1>
              <p style="font-size: 20px;padding: 10px;">I am Priya, an AI/ML enthusiast and MERN stack developer,
                creating smart and user-friendly web solutions. I focus on combining AI with modern web technologies to
                deliver impactful results. Passionate about solving real-world problems through intelligent systems and
                full-stack innovation.</p>
            </div>
            <a href="./files/Resume.pdf" download style="padding-left: 250px;"><button class="button"
                style="width: fit-content; padding: 8px;">Download Resume</button></a>
          </div>
        </div>
        <div class="card1 col-lg-6 col-md-12 col-sm-12">
          <div class="round-container">
            <!-- Center Circle -->
            <div class="round center" style="width: 50px;height: 60px;">💠</div>

            <!-- Projects -->
            <div class="round one">
              <h5>Projects</h5>
              <p>9 projects: AIML, MERN, Cybersecurity</p>
            </div>

            <!-- Hackathons -->
            <div class="round two">
              <h5>Hackathons</h5>
              <p>SIH & other hackathons</p>
            </div>

            <!-- Internships -->
            <div class="round three">
              <h5>Internships</h5>
              <p>AI @ Aimers, Web & Cybersecurity @ Suparaja</p>
            </div>

            <!-- Certifications -->
            <div class="round four">
              <h5>Certifications</h5>
              <p>NPTEL: Java, C, Web; Internshala, ICT Academy, Infosys</p>
            </div>

            <!-- Problem Solver -->
            <div class="round five">
              <h5>Problem Solver</h5>
              <p>2⭐ CodeChef; 100+ LeetCode problems</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="buttons" id="edu">
    <button class="button" onclick="showSection('edu')">Education</button>
    <button class="button" onclick="showSection('intern')">internships</button>
  </div>
  <div class="edu-section">
    <div class="container">
      <div class="main-timeline">
        <div class="timeline">
          <div class="icon"></div>
          <div class="date-content">
            <div class="date-outer">
              <span class="date">
                <span class="month">4 Years</span>
                <span class="year">2022-26</span>
              </span>
            </div>
          </div>
          <div class="timeline-content">
            <h5 class="title">BTech</h5>
            <p class="description">
              pursuing BTech in Computer Science and Engineering at Sasi Institute of Technology and Engineering,
              Tadepalligudem, Andhra Pradesh, India. Expected graduation in 2026.
              ---CGPA: 9.08/10---
            </p>
          </div>
        </div>
        <div class="timeline">
          <div class="icon"></div>
          <div class="date-content">
            <div class="date-outer">
              <span class="date">
                <span class="month">2 Years</span>
                <span class="year">2020-22</span>
              </span>
            </div>
          </div>
          <div class="timeline-content">
            <h5 class="title">Intermediate</h5>
            <p class="description">
              Completed Intermediate education at N.L.V.R.G.S.R.V.JR.COLLEGE , NIMMAKURU, PAMARRU , Andhra Pradesh,
              India.
              Achieved a score of 85.6% in the 2022 board examinations.
              ---Marks:856/1000---
            </p>
          </div>
        </div>
        <div class="timeline">
          <div class="icon"></div>
          <div class="date-content">
            <div class="date-outer">
              <span class="date">
                <span class="month">4 Years</span>
                <span class="year">2016-20</span>
              </span>
            </div>
          </div>
          <div class="timeline-content">
            <h5 class="title">Secondary Education</h5>
            <p class="description">
              Completed Secondary education at Govt.Post Basic School, PENTAPADU, Andhra Pradesh, India. Achieved a
              score of 10.0
              CGPA in the 2020 board examinations.
              ---CGPA:10/10---
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="intern-section " style="display:none">
    <div class="container">
      <div class="main-timeline">
        <div class="timeline">
          <div class="icon"></div>
          <div class="date-content">
            <div class="date-outer">
              <span class="date">
                <span class="month">2 months</span>
                <span class="year">2024</span>
              </span>
            </div>
          </div>
          <div class="timeline-content">
            <h5 class="title">AIMERS Internship</h5>
            <p class="description">
              Completed a 2-month internship at AIMERS, focusing on AI and Machine Learning projects. Gained hands-on
              experience in developing AI models and applying machine learning techniques to real-world
              problems.projects like object-detection using yolov8,v11,visual
              question answering model and main project is Talking parrot a chatbot which can talk like human.
            </p>
          </div>
        </div>
        <div class="timeline">
          <div class="icon"></div>
          <div class="date-content">
            <div class="date-outer">
              <span class="date">
                <span class="month">3 months</span>
                <span class="year">2025</span>
              </span>
            </div>
          </div>
          <div class="timeline-content">
            <h5 class="title">Full Stack(MERN)</h5>
            <p class="description">
              completed a 3-month internship at NIT Tirichi, focusing on Full Stack Development using the MERN stack.
              Gained hands-on experience in building web applications with MongoDB, Express.js, React, and Node.js.
            </p>
          </div>
        </div>
        <div class="timeline">
          <div class="icon"></div>
          <div class="date-content">
            <div class="date-outer">
              <span class="date">
                <span class="month">2 months</span>
                <span class="year">2025</span>
              </span>
            </div>
          </div>
          <div class="timeline-content">
            <h5 class="title">Cybersecurity</h5>
            <p class="description">
              Completed a 2-month internship at Suparaja Technologies, focusing on Cybersecurity. Gained practical
              experience in identifying and mitigating security threats, implementing security protocols, and ensuring
              the protection of digital assets,finally i have done a project on cyber security called Image stegonograpy
              using python and LSB Technique.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="projects" id="Projects">
    <div class="container">
      <h2 class="text-center mb-4" style="color:white;">My Projects</h2>

      <!-- Filter Buttons -->
      <div class="text-center mb-4">
        <button class="button" onclick="filterProjects('all')">All</button>
        <button class="button" onclick="filterProjects('ml')">ML/DL</button>
        <button class="button" onclick="filterProjects('mern')">MERN</button>
        <button class="button" onclick="filterProjects('web')">Web Dev</button>
        <button class="button" onclick="filterProjects('frontend')">Frontend</button>
        <button class="button" onclick="filterProjects('genai')">GenAI</button>
        <button type="button" class="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
          Add Project
        </button>


      </div>

      <div class="row">
        <?php while ($row = mysqli_fetch_assoc($projects)): ?>
          <?php
          $id = (int)$row['id'];
          $domain = htmlspecialchars($row['domain_name']);
          $title = htmlspecialchars($row['title']);
          $desc = htmlspecialchars($row['description']);
          $tech = htmlspecialchars($row['technologies']);
          $link = htmlspecialchars($row['project_link']);
          $class = match ($row['domain_name']) {
            "Machine Learning/Deep Learning" => "ml",
            "MERN Stack" => "mern",
            "Web development" => "web",
            "Frontend" => "frontend",
            "Gen AI" => "genai",
            default => "other"
          };
          ?>
          <div class="box col-lg-4 col-md-11 col-sm-11 project <?php echo $class; ?>" id="project-card-<?php echo $id; ?>"
            data-id="<?php echo $id; ?>"
            data-domain="<?php echo $domain; ?>"
            data-title="<?php echo $title; ?>"
            data-desc="<?php echo $desc; ?>"
            data-tech="<?php echo $tech; ?>"
            data-link="<?php echo $link; ?>">
            <h4 class="card-domain"><?php echo $domain; ?></h4>
            <h5 class="card-title-text"><?php echo $title; ?> :</h5>
            <p class="card-desc"><?php echo $desc; ?></p>
            <h5>Tech :</h5>
            <p class="card-tech"><?php echo $tech; ?></p>
            <div class="d-flex flex-wrap gap-2 mt-2 align-items-center">
              <?php if (!empty($row['project_link'])): ?>
                <a href="<?php echo $link; ?>" target="_blank" class="card-link-anchor">
                  <button class="button">View</button>
                </a>
              <?php endif; ?>
              <button class="button btn-edit-project" onclick="openEditProjectModal(this)">Edit</button>
              <button class="button btn-delete-project" onclick="deleteProject(<?php echo $id; ?>)">Delete</button>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

    </div>
  </div>


  <div class="skills" id="skills">
    <div class="row">
      <div class="skill-table col-lg-6 col-md-11 col-sm-11">
        <table id="technical">
          <thead>
            <tr>
              <th colspan="3">Technical Skills</th>
            </tr>
            <tr>
              <th>Programming Languages</th>
              <th>Proficiency</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($technical_skills)): ?>
              <?php $id = (int)$row['id']; ?>
              <tr id="tech-skill-row-<?php echo $id; ?>" data-id="<?php echo $id; ?>" data-type="technical" data-name="<?php echo htmlspecialchars($row['programming_language']); ?>" data-level="<?php echo htmlspecialchars($row['proficiency']); ?>">
                <td class="skill-name-cell"><?php echo htmlspecialchars($row['programming_language']); ?></td>
                <td class="skill-level-cell"><?php echo htmlspecialchars($row['proficiency']); ?></td>
                <td>
                  <button class="button btn-sm" onclick="openEditSkillModal(this)">Edit</button>
                  <button class="button btn-sm btn-delete-skill" onclick="deleteSkill('technical', <?php echo $id; ?>)">Delete</button>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <button type="button" class="button mt-3" onclick="openAddSkillModal('technical')" id="technical_skill">
          Add Skill
        </button>
      </div>

      <div class="skill-table col-lg-6 col-md-11 col-sm-11">
        <table id="soft">
          <thead>
            <tr>
              <th colspan="3">Soft Skills</th>
            </tr>
            <tr>
              <th>Skill</th>
              <th>Proficiency</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($soft_skills)): ?>
              <?php $id = (int)$row['id']; ?>
              <tr id="soft-skill-row-<?php echo $id; ?>" data-id="<?php echo $id; ?>" data-type="soft" data-name="<?php echo htmlspecialchars($row['skills']); ?>" data-level="<?php echo htmlspecialchars($row['proficiency']); ?>">
                <td class="skill-name-cell"><?php echo htmlspecialchars($row['skills']); ?></td>
                <td class="skill-level-cell"><?php echo htmlspecialchars($row['proficiency']); ?></td>
                <td>
                  <button class="button btn-sm" onclick="openEditSkillModal(this)">Edit</button>
                  <button class="button btn-sm btn-delete-skill" onclick="deleteSkill('soft', <?php echo $id; ?>)">Delete</button>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <button type="button" class="button mt-3" onclick="openAddSkillModal('soft')">
          Add Skill
        </button>
      </div>
    </div>
  </div>
  <div class="Certifications" id="certifications">
    <div class="container">
      <div class="row">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM certifications ORDER BY issue_date DESC");
        while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="col-lg-3 col-md-12 col-sm-12 flip-card">
            <div class="flip-card-inner">
              <div class="flip-card-front">
                <img src="<?php echo htmlspecialchars($row['certificate_image']); ?>"
                  alt="Certificate" style="width:300px;height:300px;object-fit:cover;">
              </div>
              <div class="flip-card-back">
                <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                <p><?php echo htmlspecialchars($row['organization']); ?><br>
                  <?php echo htmlspecialchars($row['issue_date']); ?></p>
                <?php if (!empty($row['certificate_link'])): ?>
                  <a href="<?php echo htmlspecialchars($row['certificate_link']); ?>" target="_blank">
                    <button class="button">View</button>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
      <button class="button" data-bs-toggle="modal" data-bs-target="#addCertModal">Add Certification</button>
    </div>
  </div>



  <div class="modal fade" id="addCertModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Certification</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="certForm" enctype="multipart/form-data">
            <input type="text" name="title" class="form-control mb-2" placeholder="Certification Title" required>
            <input type="text" name="organization" class="form-control mb-2" placeholder="Organization" required>
            <input type="date" name="issue_date" class="form-control mb-2" required>
            <input type="url" name="certificate_link" class="form-control mb-2" placeholder="Certificate Link">
            <input type="file" name="certificate_image" class="form-control mb-2">
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="cmodal">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New Message</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="mailForm">
              <?php 
                $web3_key = $_ENV['WEB3FORMS_KEY'] ?? $_SERVER['WEB3FORMS_KEY'] ?? getenv('WEB3FORMS_KEY') ?: '';
                if (!empty($web3_key)): 
              ?>
                <input type="hidden" name="access_key" value="<?php echo htmlspecialchars($web3_key); ?>">
              <?php endif; ?>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Recipient:</label>
                <input type="email" class="form-control" id="recipient-name" name="recipient" required>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Message:</label>
                <textarea class="form-control" id="message-text" name="message" required></textarea>
              </div>
              <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="sendMessageBtn">Send Message</button>
          </div>
            </form>
          </div>
          
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade bd-example-modal-lg" tabindex="-1" aria-labelledby="addnewproject" aria-hidden="true" id="projectModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Project</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addProject">
            <input type="hidden" id="projectId" name="id" value="">
            <input type="hidden" id="projectAction" name="action" value="add">
            <div class="mb-3">
              <label for="projectName" class="form-label">Project Name</label>
              <input type="text" class="form-control" id="projectName" name="projectName">
            </div>
            <div class="mb-3">
              <label for="domainName" class="form-label">Domain Name</label>
              <select class="form-select" id="domainName" name="domainName">
                <option value="Machine Learning/Deep Learning">Machine Learning/Deep Learning</option>
                <option value="MERN Stack">MERN Stack</option>
                <option value="Web development">Web development</option>
                <option value="Frontend">Frontend</option>
                <option value="Gen AI">GenAI</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="projectDesc" class="form-label">Description</label>
              <textarea class="form-control" id="projectDesc" rows="3" name="projectDesc"></textarea>
            </div>
            <div class="mb-3">
              <label for="technologies" class="form-label">Tech stack</label>
              <textarea class="form-control" id="technologies" rows="3" name="technologies"></textarea>
            </div>
            <div class="mb-3">
              <label for="projectLink" class="form-label">GitHub Link</label>
              <input type="url" class="form-control" id="projectLink" name="projectLink">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                onclick="clearingElements()">Close</button>
              <button type="submit" class="btn btn-primary" id="saveProject">Save Project</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="addtechnicalskill"
    aria-hidden="true" id="skill_add">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="skillModalTitle">Add Skill</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
        </div>
        <div class="modal-body">
          <form id="addSkill">
            <input type="hidden" id="skillId" name="id" value="">
            <input type="hidden" id="skillAction" name="action" value="add">
            <div class="mb-3">
              <label for="skilltype" class="form-label">Skill Type</label>
              <select class="form-select" id="skilltype" name="table_name" required>
                <option value="technical">Technical Skill</option>
                <option value="soft">Soft Skill</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="skillName" class="form-label">Skill Name</label>
              <input type="text" class="form-control" id="skillName" name="skillName" required>
            </div>
            <div class="mb-3">
              <label for="proficiency" class="form-label">Proficiency Level</label>
              <select class="form-select" id="proficiency" name="proficiency" required>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                onclick="clearFields()">Close</button>
              <button type="submit" class="btn btn-primary" id="saveSkills">Save Skill</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script src="./js/edu.js"></script>
  <script src="./js/skills.js"></script>
  <script src="./js/project.js"></script>
  <script src="./js/certification.js"></script>
  <script src="./js/mail.js"></script>
</body>

</html>