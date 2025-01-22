
//code js pour la modale 

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
