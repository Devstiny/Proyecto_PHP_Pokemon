const profilemenu = document.getElementById("profilemenu");
const profiledropdown = document.getElementById("profiledropdown");

const showLogout = () => {
  profiledropdown.classList.toggle("hidden");
};

profilemenu.addEventListener("click", showLogout);
