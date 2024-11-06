<?php

/**
 * Template Name: Offres d'emploi
 * Template Post Type: page
 *
 * @package UnderscoreTW
 */

get_header();
?>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="max-w-4xl mx-auto p-6 mt-10">
        <!-- Formulaire de filtrage -->
        <form id="job-filter" method="GET" class="mb-10 flex flex-wrap gap-4">
            <!-- Filtre par lieu -->
            <div>
                <label for="lieu" class="text-gray-700">Lieu</label>
                <select name="lieu" id="lieu" class="p-2 border rounded-lg">
                    <option value="">Tous les lieux</option>
                    <option value="Paris" <?php echo isset($_GET['lieu']) && $_GET['lieu'] === 'Paris' ? 'selected' : ''; ?>>Paris</option>
                    <option value="Lyon" <?php echo isset($_GET['lieu']) && $_GET['lieu'] === 'Lyon' ? 'selected' : ''; ?>>Lyon</option>
                    <!-- Ajouter d'autres lieux ici -->
                </select>
            </div>

            <!-- Filtre par type de poste -->
            <div>
                <label for="typePoste" class="text-gray-700">Type de poste</label>
                <select name="typePoste" id="typePoste" class="p-2 border rounded-lg">
                    <option value="">Tous les types</option>
                    <option value="CDI" <?php echo isset($_GET['typePoste']) && $_GET['typePoste'] === 'CDI' ? 'selected' : ''; ?>>CDI</option>
                    <option value="CDD" <?php echo isset($_GET['typePoste']) && $_GET['typePoste'] === 'CDD' ? 'selected' : ''; ?>>CDD</option>
                    <option value="Stage" <?php echo isset($_GET['typePoste']) && $_GET['typePoste'] === 'Stage' ? 'selected' : ''; ?>>Stage</option>
                    <option value="Alternance" <?php echo isset($_GET['typePoste']) && $_GET['typePoste'] === 'Alternance' ? 'selected' : ''; ?>>Alternance</option>

                    <!-- Ajouter d'autres types ici -->
                </select>
            </div>

            <!-- Filtre par entreprise -->
            <div>
                <label for="entreprise" class="text-gray-700">Entreprise</label>
                <input type="text" name="entreprise" id="entreprise" class="p-2 border rounded-lg" 
                       value="<?php echo isset($_GET['entreprise']) ? esc_attr($_GET['entreprise']) : ''; ?>" 
                       placeholder="Nom de l'entreprise">
            </div>

            <!-- Bouton de soumission -->
            <div>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">Filtrer</button>
            </div>
        </form>

        <?php
        // Variables de filtres
        $lieu_filter = isset($_GET['lieu']) ? sanitize_text_field($_GET['lieu']) : '';
        $typePoste_filter = isset($_GET['typePoste']) ? sanitize_text_field($_GET['typePoste']) : '';
        $entreprise_filter = isset($_GET['entreprise']) ? sanitize_text_field($_GET['entreprise']) : '';

        // Compteur d'offres trouvées
        $offres_trouvees = 0;

        // Vérification si des offres d'emploi existent dans le répéteur
        if (have_rows('offres_emploi')) : ?>
            <?php while (have_rows('offres_emploi')) : the_row();
                // Récupérer les champs de chaque offre
                $entreprise = get_sub_field('entreprise');
                $intitulePoste = get_sub_field('intitule_poste');
                $dateDebutMission = get_sub_field('date_debut_mission');
                $lieu = get_sub_field('lieu');
                $typePoste = get_sub_field('type_poste');

                // Appliquer les filtres
                // Si un filtre est défini mais que la valeur ne correspond pas, passer à l'offre suivante
                if (($lieu_filter && $lieu_filter !== $lieu) || 
                    ($typePoste_filter && $typePoste_filter !== $typePoste) ||
                    ($entreprise_filter && stripos($entreprise, $entreprise_filter) === false)) {
                    continue; // Passer à l'offre suivante si elle ne correspond pas aux filtres
                }

                // Si une offre correspond aux filtres, on l'affiche
                $offres_trouvees++; // Incrémenter le compteur des offres trouvées
            ?>
            <!-- Affichage de l'offre d'emploi -->
            <div id="job-card" class="flex flex-col gap-4 p-6 rounded-lg mt-10 border border-gray-200 hover:shadow-xl hover:translate-x-2 hover:-translate-y-2">
                <div class="flex items-center">
                    <div class="text-gray-500 text-sm">
                        Il y a 3 jours
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        <?php echo $intitulePoste; ?>
                    </h2>
                    <p class="text-gray-500">
                        <?php echo $entreprise; ?>
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center text-yellow-600">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span class="ml-1 text-sm text-gray-600">À partir du <?php echo $dateDebutMission; ?></span>
                    </div>
                    <span class="text-gray-300">|</span>
                    <div class="flex items-center text-yellow-600">
                        <i class="fa-solid fa-location-dot"></i>
                        <span class="ml-1 text-sm text-gray-600"><?php echo $lieu; ?></span>
                    </div>
                    <span class="text-gray-300">|</span>
                    <div class="flex items-center text-yellow-600">
                        <i class="fa-solid fa-briefcase"></i>
                        <span class="ml-1 text-sm text-gray-600"><?php echo $typePoste; ?></span>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>

        <!-- Si aucune offre ne correspond aux filtres -->
        <?php if ($offres_trouvees === 0) : ?>
            <p class="text-center text-red-500">Aucune offre ne correspond aux critères de recherche.</p>
        <?php endif; ?>
    </div>
</body>

