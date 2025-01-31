<?php
// Affichage des filtres pour les catégories et formats
$taxonomy = [
    'categorie' => 'CATEGORIES',
    'format' => 'Formats',
];

echo "<div class='taxo-gauche'>";

foreach ($taxonomy as $taxonomy_slug => $label) {
    $terms = get_terms($taxonomy_slug);

    if (!is_wp_error($terms) && !empty($terms)) {
        echo "<select id='{$taxonomy_slug}' class='custom-select taxonomy-select'>";
        echo "<option value=''>{$label}</option>";

        foreach ($terms as $term) {
            echo "<option value='{$term->slug}'>{$term->name}</option>";
        }

        echo "</select>";
    }
}

echo "</div>";

echo "<div class='taxo-droite'>";

echo "<select id='annee' class='custom-select taxonomy-select'>";
echo "<option value=''>TRIER PAR</option>";
echo "<option value='ASC'>Du plus ancien au plus récent</option>";
echo "<option value='DESC'>Du plus récent au plus ancien</option>";
echo "</select>";

echo "</div>";
?>
