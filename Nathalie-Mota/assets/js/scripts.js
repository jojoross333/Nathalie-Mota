
//CODE JS DE LA MODALE 

document.addEventListener("DOMContentLoaded", function() {
    // Sélectionner les éléments
    const contactBtn = document.getElementById('menu-item-27');  // Remplace par l'ID correct du bouton "Contact"
    const modale = document.getElementById('modale');  // La modale elle-même
    const closeBtn = document.querySelector('.close-btn'); // Bouton de fermeture

    // Afficher la modale au clic sur "Contact"
    contactBtn.addEventListener('click', function(event) {
        event.preventDefault();  // Empêche le comportement par défaut (si c'est un lien)
        modale.classList.add('visible'); // Afficher la modale
    });

    // Fermer la modale au clic sur le bouton "×"
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modale.classList.remove('visible'); // Fermer la modale
        });
    }

    // Fermer la modale si on clique en dehors de la boîte de dialogue (overlay)
    modale.addEventListener('click', function(event) {
        if (event.target === modale) {
            modale.classList.remove('visible'); // Fermer la modale
        }
    });
});

// CODE POUR LE BURGER EN RESPONSIVE

document.addEventListener("DOMContentLoaded", function() {
    const burgerMenu = document.getElementById('burger-menu');  // Sélectionne le menu burger
    const mainNav = document.querySelector('.main-nav');  // Sélectionne la barre de navigation
    const header = document.querySelector('header');  // Sélectionne le header
    const menuContent = document.querySelector('.menu-menu-header-container');  // Sélectionne la section de contenu
    
    // Ajouter un événement pour afficher/masquer le menu et agrandir le header
    burgerMenu.addEventListener('click', function() {
        mainNav.classList.toggle('active');  // Afficher/masquer le menu burger
        header.classList.toggle('active');  // Agrandir le header lorsque le menu est ouvert
        menuContent.classList.toggle('active');  // Agrandir ou afficher le contenu si nécessaire
    });
});
