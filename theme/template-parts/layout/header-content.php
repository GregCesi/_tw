<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _tw
 */

$locations = get_nav_menu_locations(); 
$menu_id = $locations['menu-1'];
$menu = wp_get_nav_menu_object($menu_id);
$menu_logo = get_field('logo', $menu); // Récupérer le champ ACF 'logo' pour ce menu


$menu_items = wp_get_nav_menu_items('menu');
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
    <div class="mx-8 flex flex-col justify-between p-4">
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
    </div>
</header>

<!-- Sidebar pour le menu hamburger -->
<aside id="sidebar-menu" class="fixed top-0 left-0 w-64 h-full bg-black text-white transform -translate-x-full transition-transform duration-300">
    <div class="flex flex-col p-4">
        <button id="close-sidebar" class="self-end">
            <!-- Icône de fermeture de la sidebar -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <ul class="flex flex-col gap-4 mt-8">
            <!-- Liste des éléments du menu -->
            <?php foreach ($menu_data as $item): ?>
                <?php if (!empty($item['children'])): ?>
                    <li id="menu-burger" class="menu-burger relative p-2 flex flex-col gap-2">
                        <div class="flex gap-2 items-center">
                            <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?>   
                            </a>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </div>
                        <ul id="sub-menu-burger" class="sub-menu-burger hidden bg-black">
                            <?php foreach ($item['children'] as $child): ?>
                                <li class="sub-menu-item-burger p-2 hover:font-bold"><a href="<?php echo esc_url($child['url']); ?>"><?php echo esc_html($child['title']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>  
                    <li class="relative lg:hover:bg-transparent p-2">
                        <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?></a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>

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

/* Barre visuelle qui apparaît à gauche sur hover */
/*Ici pour GPT*/
.sub-menu-item-burger li:hover::before {
    content: '';
    position: absolute;
    left: -10px; /* Place la barre à gauche du texte */
    top: 0;
    height: 25%; /* La hauteur est égale à celle du texte */
    width: 3px; /* Ajuste la largeur de la barre */
    background-color: #fff; /* Couleur de la barre */
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.rotate-90 > a::after {
    transform: rotate(90deg);
    transition: transform 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('menu-toggle');
    var sidebarMenu = document.getElementById('sidebar-menu');
    var closeSidebar = document.getElementById('close-sidebar');
    var iconMenuClosed = document.getElementById('icon-menu-closed');
    var iconMenuOpened = document.getElementById('icon-menu-opened');

    var menuBurger = document.getElementById('menu-burger');
    var subMenuBurger = document.getElementById('sub-menu-burger');

    // Fonction pour fermer la sidebar
    function closeSidebarMenu() {
        sidebarMenu.classList.add('-translate-x-full'); // Cacher la sidebar
        iconMenuClosed.classList.remove('hidden'); // Afficher l'icône hamburger fermé
        iconMenuOpened.classList.add('hidden'); // Cacher l'icône hamburger ouvert
    }

    // Ouverture de la sidebar
    menuToggle.addEventListener('click', function() {
        // Afficher/masquer le menu burger
        sidebarMenu.classList.toggle('-translate-x-full');
        iconMenuClosed.classList.toggle('hidden');
        iconMenuOpened.classList.toggle('hidden');
    });

    // Gestion du sous-menu burger
    menuBurger.addEventListener('click', function(e) {
        e.preventDefault(); // Empêche la navigation par défaut

        var link = menuBurger.querySelector('svg');
        link.classList.toggle('rotate-90');

        if (subMenuBurger.classList.contains('hidden')) {
            subMenuBurger.classList.remove('hidden');
        } else {
            subMenuBurger.classList.add('hidden');
        }
    });

    // Fermeture de la sidebar quand on clique sur le bouton fermer
    closeSidebar.addEventListener('click', function() {
        closeSidebarMenu();
    });

    // Fonction pour fermer la sidebar quand l'écran est redimensionné à lg (1024px ou plus)
    function closeMenuOnResize() {
        if (window.innerWidth >= 1024) { // Taille de l'écran >= 1024px
            closeSidebarMenu(); // Appel à la fonction pour fermer la sidebar
        }
    }

    // Ajouter un écouteur sur le redimensionnement de la fenêtre
    window.addEventListener('resize', closeMenuOnResize);

    // Appeler immédiatement la fonction pour s'assurer que le menu est bien fermé au chargement si l'écran est large
    closeMenuOnResize();
    });


</script>
