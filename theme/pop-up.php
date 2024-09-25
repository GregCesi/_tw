<?php

/**
 * Template Name: Pop-up
 * Template Post Type: page
 *
 * @package UnderscoreTW
 */

 get_header()
?>


<!-- Bouton pour ouvrir la pop-up -->
<button id="openPopup" class="bg-blue-500 text-white px-4 py-2 rounded">Ouvrir la pop-up</button>

<!-- Contenu de la pop-up cachée initialement -->
<div id="popup" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-xl font-semibold mb-4">Titre de la pop-up</h2>
        <p class="mb-4">Contenu de la pop-up.</p>
        <button id="closePopup" class="bg-red-500 text-white px-4 py-2 rounded">Fermer</button>
    </div>
</div>

<div id="map" style="height: 400px; width: 100%;"></div>


<script>
    document.getElementById('openPopup').addEventListener('click', function() {
        document.getElementById('popup').classList.remove('hidden');
    });

    document.getElementById('closePopup').addEventListener('click', function() {
        document.getElementById('popup').classList.add('hidden');
    });

</script>