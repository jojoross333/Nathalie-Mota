jQuery(document).ready(function ($) {
    var currentIndex = 0; // L'index de la photo actuelle
    var targetUrl = photoData.photo_ids[currentIndex]; // L'URL de la photo à rediriger

    // Fonction pour mettre à jour la miniature et le lien
    function updateThumbnail() {
        var thumbnailUrl = photoData.thumbnails[currentIndex];
        targetUrl = photoData.photo_ids[currentIndex]; // Mise à jour du targetUrl avec l'URL de la photo

        // Mettre à jour la miniature avec la photo actuelle
        $("#miniaturePhoto").css("background-image", "url('" + thumbnailUrl + "')");
        $("#miniaturePhoto").attr("href", targetUrl);  // Lien vers la page de la photo
    }

    // Initialiser la miniature
    updateThumbnail();

    // Clic sur flèche gauche
    $(".arrow-left").on("click", function () {
        currentIndex = (currentIndex - 1 + photoData.thumbnails.length) % photoData.thumbnails.length;
        updateThumbnail();
    });

    // Clic sur flèche droite
    $(".arrow-right").on("click", function () {
        currentIndex = (currentIndex + 1) % photoData.thumbnails.length;
        updateThumbnail();
    });

    // Cliquer sur la miniature pour rediriger vers la photo correspondante
    $("#miniaturePhoto").on("click", function (e) {
        e.preventDefault();  // Empêcher le comportement par défaut du lien
        window.location.href = targetUrl;  // Rediriger vers la page de la photo
    });
});
