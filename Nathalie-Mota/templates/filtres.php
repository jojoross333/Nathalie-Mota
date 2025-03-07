<?php
// Affichage des filtres pour les catégories, formats et autres taxonomies personnalisées
$taxonomy_filters = [
    'categorie' => 'CATEGORIE', // Label pour le filtre "Catégorie"
    'format' => 'FORMATS', // Label pour le filtre "Format"
];

echo "<div class='filtre-gauche'>"; // Conteneur des filtres à gauche

foreach ($taxonomy_filters as $taxonomy_slug => $filter_label) {
    $terms = get_terms($taxonomy_slug);

    if (!is_wp_error($terms) && !empty($terms)) {
        echo "<div {$taxonomy_slug}-filter'>";  

        // Affichage du label avant le select (que l'utilisateur verra avant de choisir)
        echo "<select id='{$taxonomy_slug}' class='select-filter custom-select taxonomy-select'>"; 
        echo "<option value='' disabled selected>{$filter_label}</option>";  // Valeur par défaut affichée dans la case

        foreach ($terms as $term) {
            echo "<option value='{$term->slug}'>{$term->name}</option>";  // Affichage des termes
        }

        echo "</select>";
        echo "</div>"; // Fermer le div du filtre
    }
}

echo "</div>"; // Fermer le conteneur des filtres à gauche

// Section de tri pour les photos (Trier par)
echo "<div class='filtre-droite'>";  // Conteneur pour "Trier par"
echo "<select id='sort_annee' class='select-filter custom-select taxonomy-select'>";
echo "<option value='' disabled selected>Trier par</option>";  // Valeur par défaut affichée dans la case
echo "<option value='ASC'>Du plus ancien au plus récent</option>";
echo "<option value='DESC'>Du plus récent au plus ancien</option>";
echo "</select>";
echo "</div>"; // Fermer le conteneur de tri
?>
