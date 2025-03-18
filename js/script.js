document.addEventListener("DOMContentLoaded", function() {
  const menuToggle = document.getElementById("menu-toggle");
  const menu = document.getElementById("menu");

  menuToggle.addEventListener("click", function() {
      menu.classList.toggle("show"); 
  });

  document.addEventListener("click", function(event) {
      if (!menu.contains(event.target) && event.target !== menuToggle) {
          menu.classList.remove("show");
      }
  });
});


function togglePassword(id, eyeId) {
  let input = document.getElementById(id);
  let eye = document.getElementById(eyeId);
  if (input.type === "password") {
      input.type = "text";
      eye.textContent = "🐵"; 
  } else {
      input.type = "password";
      eye.textContent = "🙈"; 
  }
}

