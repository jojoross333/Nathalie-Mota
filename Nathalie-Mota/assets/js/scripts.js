
//CODE JS DE LA MODALE ET CONTACT SINGLE-PHOTO

document.addEventListener("DOMContentLoaded", function() {
  // Sélectionner les éléments
  const contactBtnHeader = document.getElementById('menu-item-27');  // ID du bouton "Contact" du header
  const contactBtnPhoto = document.getElementById('contact-btn');    // ID du bouton "Contact" dans single-photo.php
  const modale = document.getElementById('modale');  // La modale de contact
  const closeBtn = document.querySelector('.close-btn'); // Bouton de fermeture de la modale

  // Afficher la modale au clic sur "Contact" dans le header
  if (contactBtnHeader) {
      contactBtnHeader.addEventListener('click', function(event) {
          event.preventDefault();  // Empêcher le comportement par défaut (si c'est un lien)
          modale.classList.add('visible'); // Afficher la modale
      });
  }

  // Afficher la modale au clic sur "Contact" dans single-photo.php
  if (contactBtnPhoto) {
      contactBtnPhoto.addEventListener('click', function(event) {
          event.preventDefault();  // Empêcher le comportement par défaut (si c'est un lien)
          modale.classList.add('visible'); // Afficher la modale
      });
  }

  // Fermer la modale au clic sur le bouton "×"
  if (closeBtn) {
      closeBtn.addEventListener('click', function() {
          modale.classList.remove('visible'); // Fermer la modale
      });
  }

  // Fermer la modale si on clique en dehors de la boîte de dialogue (overlay)
  if (modale) {
      modale.addEventListener('click', function(event) {
          if (event.target === modale) {
              modale.classList.remove('visible'); // Fermer la modale
          }
      });
  }
});

// CODE POUR LE BURGER EN RESPONSIVE

document.addEventListener("DOMContentLoaded", function () {
    const burger = document.querySelector(".burger-menu"); // Menu burger
    const navMenu = document.querySelector(".main-nav");  // Menu principal
    const navLinks = document.querySelectorAll(".main-nav a");  // Liens du menu
  
    // Écouteur d'événement pour le clic sur le burger
    burger.addEventListener("click", function () {
      // Toggle de la classe active sur le burger et le menu
      burger.classList.toggle("active");
      navMenu.classList.toggle("active");
    });
  
    // Écouteur d'événement pour les liens du menu
    navLinks.forEach(function (link) {
      link.addEventListener("click", function () {
        // Ferme le menu en cliquant sur un lien
        burger.classList.remove("active");
        navMenu.classList.remove("active");
      });
    });
  });


