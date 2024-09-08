<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _tw
 */

$menu_name = 'menu'; // Remplacez par le nom ou l'ID de votre menu
$menu_items = wp_get_nav_menu_items($menu_name);

$locations = get_nav_menu_locations(); 
$menu_id = $locations['menu-1'];

$menu = wp_get_nav_menu_object($menu_id);


// Récupérer le champ ACF 'logo' pour ce menu
$menu_logo = get_field('logo', $menu);

$menu_data = []; // Variable pour stocker les informations du menu

if ($menu_items) {
    // Organiser les éléments en fonction de leur relation parent-enfant
    foreach ($menu_items as $item) {
        if (!$item->menu_item_parent) {
            // Élément de premier niveau
            $menu_data[$item->ID] = [
                'title' => $item->title,
                'url' => $item->url,
                'children' => []
            ];
        } else {
            // Élément de sous-menu
            $menu_data[$item->menu_item_parent]['children'][] = [
                'title' => $item->title,
                'url' => $item->url
            ];
        }
    }
}
?>

<header id="masthead" class="bg-black text-white">
    <div class="container flex flex-col justify-between mx-auto p-4">
        <div class="flex justify-between p-4">
            <!-- <?php echo var_dump($menu_logo); ?> -->
            <a href="<?php echo home_url(); ?>" class="text-lg font-bold">
                <!-- <img src="<?php echo $menu_logo['url']; ?>"> -->
                CATRA
            </a>

            <!-- Menu Classique -->
            <nav class="max-lg:hidden">
                <ul class="flex gap-4">
                    <?php foreach ($menu_data as $item): ?>
                        <?php if (!empty($item['children'])): ?>
                            <li class="relative menu-item-has-children">
                                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?></a>
                                <ul class="sub-menu bg-black">
                                    <?php foreach ($item['children'] as $child): ?>
                                        <li class="p-4 hover:font-bold"><a href="<?php echo esc_url($child['url']); ?>"><?php echo esc_html($child['title']); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else: ?>  
                            <li class="relative hover:bg-gray-600 lg:hover:bg-transparent">
                                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
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
            <ul class="flex flex-col p-4 bg-black">
                <?php foreach ($menu_data as $item): ?>
                    <?php if (!empty($item['children'])): ?>
                        <li class="menu-item-has-children p-4">
                            <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?></a>
                            <ul class="sub-menu">
                                <?php foreach ($item['children'] as $child): ?>
                                    <li class="p-4 hover:bg-gray-600"><a href="<?php echo esc_url($child['url']); ?>"><?php echo esc_html($child['title']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="p-4 hover:bg-gray-600">
                            <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sélection des éléments du menu hamburger
    var menuToggle = document.getElementById('menu-toggle');
    var menu = document.getElementById('menu');
    var iconMenuClosed = document.getElementById('icon-menu-closed');
    var iconMenuOpened = document.getElementById('icon-menu-opened');

    // Bascule du menu hamburger et des icônes SVG
    menuToggle.addEventListener('click', function() {
        menu.classList.toggle('hidden'); // Afficher ou cacher le menu
        iconMenuClosed.classList.toggle('hidden'); // Basculer l'icône fermé
        iconMenuOpened.classList.toggle('hidden'); // Basculer l'icône ouvert
    });

    // Gérer les sous-menus dans la version mobile
    var menuItems = document.querySelectorAll('.menu-item-has-children > a');

    menuItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault(); // Empêche la navigation par défaut
            var subMenu = item.nextElementSibling; // Sélectionne le sous-menu

            if (subMenu.style.display === 'flex') {
                subMenu.style.display = 'none'; // Fermer le sous-menu
                item.parentElement.classList.remove('open');
            } else {
                subMenu.style.display = 'flex'; // Ouvrir le sous-menu
                item.parentElement.classList.add('open');
            }
        });
    });

    // Fonction pour fermer le menu si l'écran est redimensionné à une taille large
    function closeMenuOnResize() {
        if (window.innerWidth >= 1024) { // Taille de l'écran >= 1024px
            menu.classList.add('hidden'); // Cacher le menu
            iconMenuClosed.classList.remove('hidden'); // Afficher l'icône fermé
            iconMenuOpened.classList.add('hidden'); // Cacher l'icône ouvert

            // Fermer tous les sous-menus
            document.querySelectorAll('.menu-item-has-children .sub-menu').forEach(function(subMenu) {
                subMenu.style.display = 'none'; // Fermer les sous-menus
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
/* Sous-menu initialement caché avec scaleY */
.sub-menu {
    transform: scaleY(0);
    transform-origin: top center;
    transition: transform 0.3s ease-in-out;
    position: absolute;
    background: #000;
    top: calc(100% + 1rem);
    left: 0;
    min-width: 125px;
    /* max-width: 75vw; */
    z-index: 10;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);
    /* margin: 5px 0 0; */
    border-radius: 3px;
    /* padding: 1rem; */
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    pointer-events: none;
    visibility: hidden;
    opacity: 0;
    position: absolute;
    top: 100%; /* Positionner le sous-menu directement en dessous de l'élément parent */
    left: 0;
}

/* Afficher le sous-menu au survol de l'élément parent */
.menu-item-has-children:hover .sub-menu, 
.menu-item-has-children:focus-within .sub-menu {
    transform: scaleY(1);
    pointer-events: auto;
    visibility: visible;
    opacity: 1;
}

/* Rotation de l'icône ">" au survol de l'élément parent */
.menu-item-has-children:hover > a::after {
    transform: rotate(90deg);
}

/* Style de l'icône */
.menu-item-has-children > a::after {
    content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>');
    display: inline-block;
    vertical-align: middle;
    margin-left: 0.5rem;
    transform: rotate(0);
    transition: transform 0.3s ease;
}

.menu-item-has-children {
    position: relative; /* Assurer que le sous-menu est positionné par rapport à l'élément parent */
}

/* Sous-élément de menu */
.sub-menu a {
    position: relative; /* Pour permettre l'affichage de la barre */
}

/* Barre visuelle qui apparaît à gauche sur hover */
.sub-menu a:hover::before {
    content: '';
    position: absolute;
    left: -10px; /* Ajuste la distance par rapport à l'élément */
    top: 50%;
    transform: translateY(-50%);
    width: 3px; /* Largeur de la barre */
    height: 200%; /* Hauteur de la barre, peut être ajustée */
    background-color: #fff; /* Couleur de la barre */
}

/* Supprimer le changement de couleur de fond au survol */
.sub-menu a:hover {
    background-color: transparent;

}

#menu {
    display: none; /* Menu caché par défaut */
}

/* Affichage du menu mobile lorsqu'il est activé */
#menu:not(.hidden) {
    display: flex;
    flex-direction: column;
}

/* Afficher le bouton hamburger uniquement sur mobile */
@media (max-width: 1024px) {
    #menu-toggle {
        display: block;
    }
}

/* Cacher le bouton hamburger sur les écrans larges */
@media (min-width: 1025px) {
    #menu-toggle {
        display: none;
    }

    #menu {
        display: flex; /* Toujours visible sur desktop */
    }
}

/* Sous-menu caché par défaut */
.sub-menu {
    display: none;
}

/* Afficher les sous-menus dans la version mobile */
.menu-item-has-children.open .sub-menu {
    display: flex;
    flex-direction: column;
}

</style>
