function showSection(section) {
  // Hide both sections
  document.querySelector('.edu-section').style.display = 'none';
  document.querySelector('.intern-section').style.display = 'none';

  // Show the selected section
  if (section === 'edu') {
    document.querySelector('.edu-section').style.display = 'block';
  } else if (section === 'intern') {
    document.querySelector('.intern-section').style.display = 'block';
  }
}
