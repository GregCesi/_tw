<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _tw
 */

?>

<header id="masthead" class="bg-black text-white">
    <div class="container flex flex-col justify-between mx-auto p-4">
            
        <div class="flex justify-between p-4">
            <a href="<?php echo home_url(); ?>" class="text-lg font-bold">CATRA</a>

            <!-- Menu Classique -->
            <nav class="max-lg:hidden">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'menu-1',
                    'menu_class'     => 'flex gap-4',
                    'container'      => false,
                ) );
                ?>
            </nav>

            <!-- Bouton Hamburger pour Mobile -->
            <button id="menu-toggle" class="block lg:hidden">
                <!-- Icône Hamburger Fermé (3 lignes complètes) -->
                <svg id="icon-menu-closed" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>

                <!-- Icône Hamburger Ouvert (2 lignes complètes, 1 ligne plus petite) -->
                <svg id="icon-menu-opened" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>    
        </div>

        <!-- Menu Hamburger -->
        <nav id="menu" class="hidden w-full text-center">
            <?php
            wp_nav_menu( array(
                    'theme_location' => 'menu-1',
                    'menu_class'     => 'flex flex-col p-4 bg-black',
                    'container'      => false,
                ) );
            ?>
        </nav>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('menu-toggle');
    var menu = document.getElementById('menu');
    var iconMenuClosed = document.getElementById('icon-menu-closed');
    var iconMenuOpened = document.getElementById('icon-menu-opened');

    // Fonction pour basculer le menu hamburger et les icônes SVG
    menuToggle.addEventListener('click', function() {
        menu.classList.toggle('hidden');
        iconMenuClosed.classList.toggle('hidden');
        iconMenuOpened.classList.toggle('hidden');
    });

    var menuItems = document.querySelectorAll('.menu-item-has-children > a');

    menuItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault(); // Empêche la navigation du lien
            var subMenu = item.nextElementSibling; // Sélectionne le sous-menu associé

            if (subMenu.style.display === 'flex') {
                subMenu.style.display = 'none';
                item.parentElement.classList.remove('open');
            } else {
                subMenu.style.display = 'flex';
                item.parentElement.classList.add('open');
            }
        });
    });

    // Fonction pour fermer le menu si l'écran est large
    function closeMenuOnResize() {
        if (window.innerWidth >= 1024) { // 1024px correspond au breakpoint lg
            menu.classList.add('hidden'); // Cache le menu si l'écran est large
            iconMenuClosed.classList.remove('hidden'); // Affiche l'icône fermé
            iconMenuOpened.classList.add('hidden'); // Cache l'icône ouvert

            // Fermer tous les sous-menus
            document.querySelectorAll('.menu-item-has-children .sub-menu').forEach(function(subMenu) {
                subMenu.style.display = 'none';
                subMenu.parentElement.classList.remove('open');
            });
        }
    }

    // Exécuter la fonction lors du redimensionnement de la fenêtre
    window.addEventListener('resize', closeMenuOnResize);

    // Fermer le menu au chargement si l'écran est large
    closeMenuOnResize();
    
});
</script>

<style>
    @media (max-width: 1023px) {
        /* Appliquer le padding et le style par défaut aux items */
        li.menu-item {
            padding: 1rem;
        }

        /* Appliquer le hover uniquement à l'élément survolé */
        li.menu-item:hover {
            background-color: #555;
        }

        /* Supprimer l'effet hover du parent si le sous-menu est ouvert */
        li.menu-item-has-children.open {
            background-color: transparent;
        }

        /* Appliquer le hover aux sous-éléments */
        li.menu-item-has-children .sub-menu li:hover {
            background-color: #555;
        }

        /* Appliquer le hover au parent si le sous-menu n'est pas ouvert */
        li.menu-item-has-children:not(.open):hover {
            background-color: #555;
        }
    }

    .sub-menu {
        display: none;
        background-color: #000;        
        flex-direction: column;
        padding-left: 10px;
       }

    .menu-item-has-children > a::after {
        content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>');
        display: inline-block;
        margin-left: 0.5rem;
        vertical-align: middle; /* Alignement vertical au milieu */
        transition: transform 0.3s ease;
    }

    .menu-item-has-children.open > a::after {
        transform: rotate(90deg);
    }
</style> 
