<?php
// Affichage des filtres pour les catégories et formats
$taxonomy = [
    'categorie' => 'CATEGORIES',
    'format' => 'FORMATS',
];

// Démarrer le conteneur des filtres à gauche (conteneur pour les catégories et formats)
echo "<div class='filtre-gauche'>";
// Pour chaque taxonomie dans le tableau $taxonomy
foreach ($taxonomy as $taxonomy_slug => $label) { //génére automatiquement un select pour chaque taxo définie
    // Utiliser la fonction get_terms() pour récupérer toutes les options disponibles pour chaque taxonomie
    $terms = get_terms($taxonomy_slug);
    // Vérifier qu'il n'y a pas d'erreur et que la taxonomie contient des termes
    if (!is_wp_error($terms) && !empty($terms)) {
        // Créer un élément <select> pour afficher les options de la taxonomie
        echo "<select id='{$taxonomy_slug}' class='custom-select taxonomy-select'>"; // class pour le style des taxo 
        // Ajouter une option par défaut vide
        echo "<option value=''>{$label}</option>";
        // Boucler sur les termes de la taxonomie (par exemple, les catégories de photos) pour créer les options du <select>
        foreach ($terms as $term) {
            echo "<option value='{$term->slug}'>{$term->name}</option>";
        }

        echo "</select>"; // fin select filtre gauche
    }
}

echo "</div>"; // fin du contenu

echo "<div class='filtre-droite'>"; // filtre indépendant pour trier année 

echo "<select id='annee' class='custom-select taxonomy-select'>";
echo "<option value=''>TRIER PAR</option>";
echo "<option value='ASC'>Du plus ancien au plus récent</option>";
echo "<option value='DESC'>Du plus récent au plus ancien</option>";
echo "</select>";

echo "</div>";
?>