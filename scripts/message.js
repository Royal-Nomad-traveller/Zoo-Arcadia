document.addEventListener("DOMContentLoaded", function () {
  const alertBox = document.querySelector(".alert");
  if (alertBox) {
    alertBox.classList.add("fade-out");
    setTimeout(() => {
      alertBox.classList.add("hide");
      setTimeout(() => {
        alertBox.remove(); // supprime complètement du DOM
      }, 1000);
    }, 7000);
  }
});

// Nettoyer l'URL sans recharger la page
if (window.history.replaceState) {
  const url = new URL(window.location);
  url.searchParams.delete("flash");
  window.history.replaceState(null, "", url);
}

// Faire disparaître l'alerte après 7 secondes
const alertBox = document.getElementById("flashMessage");
if (alertBox) {
  setTimeout(() => {
    alertBox.style.display = "none";
  }, 7000);
}
