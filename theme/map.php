<?php

/**
 * Template Name: Carte
 * Template Post Type: page
 *
 * @package UnderscoreTW
 */

get_header();

?>

<div id="map" style="height: 500px;"></div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
// document.addEventListener('DOMContentLoaded', function() {
//     var map = L.map('map').setView([48.8566, 2.3522], 6); // Vue initiale, centré sur la France

//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
//     }).addTo(map);

//     // Ajouter les marqueurs pour chaque établissement
//     <?php if( have_rows('boutique') ): ?>
//         var bounds = new L.LatLngBounds(); // Pour ajuster la vue à tous les marqueurs
        
//         <?php while( have_rows('boutique') ): the_row(); ?>
//             var latLng = [<?php the_sub_field('latitude'); ?>, <?php the_sub_field('longitude'); ?>];
//             var marker = L.marker(latLng, {icon: customIcon}).addTo(map)
//             .bindPopup("<b><?php the_sub_field('nom'); ?></b><br><?php the_sub_field('adresse'); ?>");
            
//             bounds.extend(latLng); // Étendre les limites pour inclure ce marqueur
//         <?php endwhile; ?>
        
//         map.fitBounds(bounds); // Adapter la vue pour inclure tous les marqueurs
//     <?php endif; ?>
// });

document.addEventListener('DOMContentLoaded', function() {
    // Initialiser la carte avec une vue centrée par défaut
    var map = L.map('map').setView([48.8566, 2.3522], 6); // Vue centrée sur la France

    // Charger les tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Variable pour ajuster les limites de la carte à tous les marqueurs
    var bounds = new L.LatLngBounds(); 

    // Boucle sur chaque boutique dans ACF pour récupérer les adresses
    <?php if( have_rows('boutique') ): ?>
        <?php while( have_rows('boutique') ): the_row(); ?>
            // Obtenir l'adresse de la boutique
            var address = "<?php the_sub_field('adresse'); ?>"; // Champ ACF 'adresse' pour chaque boutique
            
            // Utiliser Nominatim pour géocoder l'adresse
            var nominatimUrl = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);

            fetch(nominatimUrl)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    // Récupérer les coordonnées (latitude et longitude) retournées par Nominatim
                    var lat = data[0].lat;
                    var lon = data[0].lon;

                    // Ajouter un marqueur à l'emplacement géocodé
                    var latLng = [lat, lon];
                    var marker = L.marker(latLng, {icon: customIcon}).addTo(map)
                        .bindPopup("<b><?php the_sub_field('nom'); ?></b><br>" + address);

                        
                    // Étendre les limites de la carte pour inclure ce marqueur
                    bounds.extend(latLng);
                    
                    // Ajuster la vue de la carte pour inclure tous les marqueurs
                    map.fitBounds(bounds);
                } else {
                    console.error('Adresse introuvable : ' + address);
                }
            })
            .catch(error => {
                console.error('Erreur de géocodage pour l\'adresse : ' + address, error);
            });

        <?php endwhile; ?>
    <?php endif; ?>
});

var customIcon = L.icon({
    iconUrl: 'http://devcatra.local/wp-content/uploads/2024/09/placeholder.png',
    iconSize: [38, 38], // Taille de l'icône
});




</script>
