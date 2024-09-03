<?php

/**
 * Template Name: Offres d'emploi
 * Template Post Type: page
 *
 * @package UnderscoreTW
 */

 get_header();

 $entreprise = get_field('entreprise');
 $intitulePoste = get_field('intitule_poste');
 $dateDebutMission = get_field('date_debut_mission');
 $lieu = get_field('lieu');
 $typePoste = get_field('type_poste');

 ?>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div id="job-card" class="flex flex-col gap-4 max-w-4xl mx-auto p-6 rounded-lg mt-10 border border-gray-200 hover:shadow-xl hover:translate-x-2 hover:-translate-y-2">
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
</body>


