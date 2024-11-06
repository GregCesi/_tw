<?php

/**
 * Template Name: Home Page
 * Template Post Type: page
 *
 * @package UnderscoreTW
 */

get_header();
$title = get_field('titre');
$descTitle = get_field('description_titre');
$descImage = get_field('description_image');
$image = get_field('image');
$detail = get_field('detail');



?>

<body>
    <!-- <?php var_dump($image['url']); // Just for debugging ?> -->

    <main class="flex flex-col gap-4 bg-gray-200">
        <section class="flex flex-col gap-4">
            <!-- Section Header -->
            <header class="p-4">
                <h1 class="font-bold text-3xl"><?php echo esc_html($title); ?></h1>
                <p class="text-xl"><?php echo esc_html($descTitle); ?></p>
            </header>
            
            <article class="flex max-lg:flex-col max-lg:text-center text-balance bg-white">
                <div class="basis-1/2">
                    <img class="w-full" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($descImage); ?>">
                </div>
                <div class="basis-1/2 flex flex-col">
                    <h2 class="text-balance text-5xl max-sm:text-3xl lg:text-3xl 2xl:text-7xl p-4 font-bold decoration-[4px] decoration-purple-500 text-transparent bg-clip-text bg-gradient-to-r from-black to-red-600">
                        <?php echo esc_html($descImage); ?>
                    </h2>
                    <div class="text-sm font-bold list-disc p-4"><?php echo wp_kses_post($detail); ?></div>
                </div>
            </article>
        </section>

        <section class="flex flex-wrap max-md:flex-col text-center max-md:gap-8 justify-around px-8 py-20">
            <!-- Bouton Nous Contacter -->
            <div class="flex flex-col gap-8">
                <p class="font-bold text-xl">Besoin de renseignement ?</p>
                <a href="#contact"
                    class="bg-gradient-to-r from-black to-red-600 text-white font-bold text-3xl py-12 px-9 rounded-full shadow-lg hover:shadow-red-300 transition-shadow duration-300 ease-in-out">
                    NOUS CONTACTER
                </a>
            </div>
           

            <!-- Bouton Nous Rejoindre -->
            <div class="flex flex-col gap-8">
                <p class="font-bold text-xl">Envie de vivre l'aventure CATRA !</p>
                <a href="#join"
                    class="bg-gradient-to-r from-black to-red-600 text-white font-bold text-3xl py-12 px-9 rounded-full shadow-lg hover:shadow-red-300 transition-shadow duration-300 ease-in-out">
                    NOUS REJOINDRE
                </a>
            <div>
        
        </section>

        <section>
        <!-- Splide CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide.min.css">

        <!-- Splide JS -->
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js"></script>

        <?php
        $images = get_field('photos'); // Récupération du champ galerie
        if( $images ): ?>
            <div id="image-carousel" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach( $images as $image ): ?>
                            <li class="splide__slide">
                                <div class="image-wrapper w-full h-[400px]">
                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="w-full h-full object-cover rounded-lg shadow-lg">
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- Pagination sous forme de points -->
                <div class="splide__pagination"></div>
            </div>
        <?php endif; ?>


        <div id="image-carousel" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <!-- Images -->
                </ul>
            </div>
            <div class="splide__arrows">
                <button class="splide__arrow splide__arrow--prev">Prev</button>
                <button class="splide__arrow splide__arrow--next">Next</button>
            </div>
        </div>

        </section>
    </main>
</body>

<script>

document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '#image-carousel', {
        type   : 'loop',
        perPage: 3,  // Trois images visibles en même temps
        focus  : 'center',  // L'image centrale est mise en avant
        gap    : '2rem',  // Espacement entre les images
        pagination: true, // Afficher les points de pagination
        breakpoints: {
            768: {
                perPage: 1,  // Une seule image visible sur les petits écrans
                gap: '1rem',
            },
            1024: {
                perPage: 2,  // Deux images sur les tablettes
            },
        },
    }).mount();
});

</script>

<style>
    .splide__slide.is-active img {
    transform: scale(1.05);  /* Agrandir légèrement l'image centrale */
    }

    .splide__slide img {
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .splide__slide:not(.is-active) img {
        opacity: 0.7; /* Réduire légèrement l'opacité des images adjacentes */
    }
</style>