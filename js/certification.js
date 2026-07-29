document.getElementById("certForm").addEventListener("submit", function(e){
  e.preventDefault();
  const formData = new FormData(this);

  fetch("api/certification_api.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if(data.success) location.reload();
  })
  .catch(err => alert("Error: " + err));
});
